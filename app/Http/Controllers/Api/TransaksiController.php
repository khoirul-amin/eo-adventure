<?php

namespace App\Http\Controllers\Api;

use App\Http\Library\ResponseLibrary;
use App\Http\Library\ValidasiLibrary;
use App\Http\Models\transaksi_m;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TransaksiController{
    function all_history(Request $request){
        $userId = $request->header('userId');

        $history = transaksi_m::join('paket', 'transaksi.paket_id', '=', 'paket.id')
        ->join('event', 'transaksi.event_id', '=', 'event.id')
        ->join('images', 'event.kode_event', '=', 'images.type')->where('images.deskripsi','images1')
        ->where('transaksi.user_id',$userId)->get(['transaksi.*','event.judul']);

        if($history->first()){
            return response()->json((new ResponseLibrary())->res(200, $history, 'Data history transaksi'));
        }else{
            return response()->json((new ResponseLibrary())->res(200, null, 'Data history transaksi kosong'));
        }
    }

    function get_history_by_id($id){

        $history = transaksi_m::join('users','transaksi.user_id','=','users.id')
        ->join('event', 'transaksi.event_id', '=', 'event.id')
        ->join('transportasi', 'event.transportasi_id', '=', 'transportasi.id')
        ->join('kategori_event', 'event.kategori_id', '=', 'kategori_event.id')
        ->join('paket', 'transaksi.paket_id', '=', 'paket.id')
        ->where('transaksi.id', $id)
        ->get(['transaksi.*','transaksi.id as id_transaksi','event.*','users.name','paket.paket','paket.harga','kategori_event.kategori','transportasi.transportasi'])->first();

        

        if($history->first()){
            $res = array();

            $res['id'] = $history->id_transaksi;
            $res['invoice'] = $history->invoice;
            $res['tanggal'] = $history->tanggal;
            $res['pemberangkatan'] = $history->pemberangkatan;
            $res['bukti_pembayaran'] = $history->bukti_pembayaran; 
            if(empty($history->bukti_pembayaran)){
                $res['bukti_pembayaran'] = "Data Kosong"; 
            }
            $res['dadeline_pembayaran'] = $history->dadeline_pembayaran;
            $status = "";
            if($history->status_transaksi == 1){
                $status = "Disetujui";
            }elseif($history->status_transaksi == 2){
                $status = "Ditolak";
            }elseif($history->status_transaksi == 3){
                $status = "Menunggu";
            }elseif($history->status_transaksi == 4){
                $status = "Dibatalkan";
            }
            $res['status_transaksi'] = $status;

            $res['keterangan'] = $history->keterangan;
            if(empty($history->keterangan)){
                $res['keterangan'] = "Kososong";
            }
            $res['judul'] = $history->judul;
            $res['biaya'] = $history->harga;
            // $res['kuota'] = 15;
            // $res['transportasi_id'] = 5;
            // $res['kategori_id'] = 2;
            // $res['name'] = $res['Amin$res[';
            // $res['paket'] = $res['3 Orang$res[';
            // $res['harga'] = 500000;
            // $res['kategori'] = $res['2 Hari 1 Malam$res[';
            // $res['transportasi'] = $res['Elf Long$res['
            

            return response()->json((new ResponseLibrary())->res(200, $res, 'Data history transaksi'));
        }else{
            return response()->json((new ResponseLibrary())->res(200, null, 'Data history transaksi kosong'));
        }
    }

    function order(Request $request){
        $validasi = array(
            'tanggal_pemberangkatan' => $request->tanggal_pemberangkatan,
            'event_id' => $request->event_id,
            'paket_id' => $request->paket_id,
        );
        
        $validate = (new ValidasiLibrary())->cek($validasi);


        if($validate != null){
            return response()->json($validate);
        }else{
            $posts = array();

            $date = date_create($request->tanggal_pemberangkatan);
            $dateformat = date_format($date,"Y-m-d H:i:s");
            $pembayaran = date('Y-m-d H:i:s',strtotime($dateformat . "-1 days"));

            $posts['pemberangkatan'] = $dateformat;
            $posts['user_id'] = $request->header('userId');
            $posts['event_id'] = $request->event_id;
            $posts['paket_id'] = $request->paket_id;
            $posts['tanggal'] = date('Y-m-d H:i:s');
            $posts['invoice'] = 'TRX'.$request->header('userId').date('Ymd').(transaksi_m::max('id')+1);
            $posts['status_transaksi'] = 3;
            $posts['dadeline_pembayaran'] = $pembayaran;

            $transaksi = transaksi_m::insert($posts);

            if($transaksi){
                return response()->json((new ResponseLibrary())->res(200, null, "Request order berhasil silahkan lakukan pembayaran terahir tanggal $pembayaran"));
            }else{
                return response()->json((new ResponseLibrary())->res(302, null, 'Terjadi kesalahan pada aplikasi'));
            }

        }
    }

    function upload_bukti(Request $request){

        $data = array();

        if(!empty($request->bukti)){
            $bukti = $request->bukti;
            $extension = $bukti->getClientOriginalExtension();
            $size = $bukti->getSize();

            if($extension != "jpg" && $extension != "jpeg" && $extension != "png"){
                return response()->json((new ResponseLibrary())->res(301, null, 'Hanya mengizinkan file gambar : jpg,jpeg,png'));
            }
            if($size > 2097152){
                return response()->json((new ResponseLibrary())->res(301, null, 'Ukuran foto terlalu besar, Hanya boleh dibawah 2MB'));
            }


            $cek_data = transaksi_m::where('id', '=', $request->id_transaksi)->first();
            $nama_file = uniqid('bukti-' . rand(100,999)) . '.' . $bukti->getClientOriginalExtension();
            $image_cek = explode("/",$cek_data->bukti);
            $image_last = end($image_cek);
            
            if(File::exists(\base_path() .'/public/bukti/'.$image_last)){
                File::delete(\base_path() .'/public/bukti/'.$image_last);
                $bukti->move(\base_path() .'/public/bukti', $nama_file);
            }else{
                $bukti->move(\base_path() .'/public/bukti', $nama_file);
            }
            $data['bukti_pembayaran'] = '/bukti/'.$nama_file;
            $data['status_transaksi'] = 3;

            $res = transaksi_m::where('id', $request->id_transaksi)->update($data);

            if($res){
                return response()->json((new ResponseLibrary())->res(200, null, 'Update pembayaran berhasil'));
            }

        }else{
            return response()->json((new ResponseLibrary())->res(301, null, 'Masukkan foto bukti transaksi'));
        }


    }
}