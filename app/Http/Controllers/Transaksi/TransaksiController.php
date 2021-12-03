<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Models\admin_m;
use App\Http\Models\agenda_m;
use App\Http\Models\event_m;
use App\Http\Models\paket_m;
use Illuminate\Http\Request;
use App\Http\Models\transaksi_m;
use App\Http\Models\user_m;
use Illuminate\Support\Facades\Auth;
use PDF;

class TransaksiController extends Controller{
    function index(){
        return view('pages.transaksi.transaksi');
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'transaksi.id',
            1 => 'transaksi.user_id',
            2 =>'transaksi.event_id',
            3 =>'event.biaya',
            4 =>'transaksi.status_transaksi',
            5 =>'transaksi.status_transaksi'
        );

        // Total Data
        $totaldata = count(transaksi_m::get());


        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = transaksi_m::join('users','transaksi.user_id','=','users.id')
                ->join('event', 'transaksi.event_id', '=', 'event.id')
                ->join('paket', 'transaksi.paket_id', '=', 'paket.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get(['transaksi.*', 'users.name', 'event.judul', 'event.biaya', 'paket.paket', 'paket.harga']);
        $totalFiltered = $totaldata;

        $data = array();
        if($posts){
            $no = 1;
            foreach($posts as $row){
                $date=date_create($row->dadeline_pembayaran);
                $status_transaksi = "";
                if($row->status_transaksi == 1){
                    $status_transaksi = "Disetujui";
                }elseif($row->status_transaksi == 2){
                    $status_transaksi = "Ditolak";
                }elseif($row->status_transaksi == 3){
                    $status_transaksi = "Menunggu";
                }elseif($row->status_transaksi == 4){
                    $status_transaksi = "Dibatalkan";
                }

                $admin = "";
                if(!empty($row->admin_id)){
                    $admin_row = admin_m::where('id',$row->admin_id)->first();
                    $admin = " <br/> <b>Admin :</b> $admin_row->name";
                }
                
                $keterangan = "<br/> <b>Keterangan :</b> ";
                if(!empty($row->keterangan)){
                    $keterangan = "<br/> <b>Keterangan :</b> $row->keterangan";
                }

                $bukti = "<br/> <b>Bukti Pembayaran :</b> ";
                if(!empty($row->bukti_pembayaran)){
                    $bukti = "<br/> <b>Bukti Pembayaran :</b> <a href='$row->bukti_pembayaran' target='new'>Lihat Bukti</a>";
                }

                $nestedData['no'] = $no;
                $nestedData['keterangan'] = "<b>Nama Pemesan :</b> $row->name <br/> <b>Invoice :</b> <a href='transaksi/invoice/$row->invoice' target='new'> $row->invoice </a> <br/> <b>Paket :</b> $row->paket";
                $nestedData['event'] =  $row->judul;
                $nestedData['pembayaran'] ="<b>Harga :</b> Rp  ".number_format($row->harga,0,',','.')." $bukti <br/> <b>Pembayaran Terahir :</b> ".date_format($date,"d-M-Y H:i:s");
                $nestedData['transaksi'] = "<b>Status :</b> $status_transaksi  $admin $keterangan";
                $nestedData['action'] = "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' onClick=\"setDataUpdate('$row->id','$row->status_transaksi','$row->keterangan')\" data-target='#modalform'>Update Status</button>";
                $data[] = $nestedData;
                $no++;
            }
        }

        echo json_encode(array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totaldata),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data
        ));
    }


    function update(Request $request){

        $respError = FALSE;
        $respMesssage = '';
        $id = (int)$request->id;

        $array_post = array();

        $request->validate([
            'status_transaksi' => 'required',
            'keterangan' => 'required||max:200',
        ]);
        $array_post['status_transaksi'] = $request->status_transaksi;
        $array_post['keterangan'] = $request->keterangan;
        $array_post['admin_id'] = Auth::id();

        $res = transaksi_m::where('id', $id)->update($array_post);

        if($res){
            $respError = TRUE;
            $respMesssage = 'Update status transaksi berhasil';
        }else{
            $respMesssage = 'Terjadi kesalahan saat update data';
        }
        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }

    function invoice($id){
        $data = transaksi_m::where('invoice', $id)->first();

        $status_transaksi = "";
        if($data->status_transaksi == 1){
            $status_transaksi = "Disetujui";
        }elseif($data->status_transaksi == 2){
            $status_transaksi = "Ditolak";
        }elseif($data->status_transaksi == 3){
            $status_transaksi = "Menunggu";
        }elseif($data->status_transaksi == 4){
            $status_transaksi = "Dibatalkan";
        }

        $datei=date_create($data->dadeline_pembayaran);
        $date=date_format($datei,"d-M-Y H:i:s");

        $datep=date_create($data->pemberangkatan);
        $pemberangkatan=date_format($datep,"d-M-Y H:i:s");

        $user = user_m::where('id', $data->user_id)->first();
        $event = event_m::where('event.id', $data->event_id)->first();
        $paket = paket_m::where('id', $data->paket_id)->first();
        $agenda = agenda_m::join('destinasi','agenda.destinasi_id','=','destinasi.id')->where('agenda.event_id', $event->id)->get(['agenda.*','destinasi.nama_tujuan','destinasi.provinsi']);
        $admin_name = "";
        if(!empty($data->admin_id)){
            $admin = admin_m::where('id', $data->admin_id)->first();
            $admin_name = $admin->name;
        }

        $pdf = PDF::loadview('pages.transaksi.invoice', compact('pemberangkatan','paket','admin_name','status_transaksi','data','user','event','agenda','date'))->setPaper('A4','potrait');
        return $pdf->stream();
    }
}