<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\pembayaran_m;

class PembayaranController extends Controller{
    function index(){
        return view('pages.transaksi.pembayaran');
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'id',
            1 => 'no_tujuan',
            2 =>'atas_nama',
            3 =>'tujuan',
            4 =>'tujuan'
        );

        // Total Data
        $totaldata = count(pembayaran_m::get());

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = pembayaran_m::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        $totalFiltered = $totaldata;


        $data = array();
        if($posts){
            foreach($posts as $row){
                $btn_delete = "<button type='button' onclick=\"hapus('$row->id')\" class='ml-2 btn btn-sm btn-danger'>Delete</button>";
                $nestedData['id'] = $row->id;
                $nestedData['no_tujuan'] = $row->no_tujuan;
                $nestedData['atas_nama'] = $row->atas_nama;
                $nestedData['tujuan'] = $row->tujuan;
                $nestedData['action'] = "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' onClick=\"setDataUpdate('$row->id','$row->no_tujuan','$row->atas_nama','$row->tujuan')\" data-target='#modalform'>Update</button> $btn_delete";
                $data[] = $nestedData;
            }
        }

        echo json_encode(array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totaldata),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data
        ));
    }

        
    function insert(Request $request){
        $respError = FALSE;
        $respMesssage = '';

        $request->validate([
            'no_tujuan' => 'numeric|required',
            'atas_nama' => 'required',
            'tujuan' => 'required',
        ]);

        $posts = array();
        $posts['no_tujuan'] = $request->no_tujuan;
        $posts['atas_nama'] = $request->atas_nama;
        $posts['tujuan'] = $request->tujuan;
        
        $res = pembayaran_m::insert($posts);
            
        if($res){
            $respError = TRUE;
            $respMesssage = 'Input data Tujuan Pembayaran berhasil';
        }else{
            $respMesssage = 'Input data Gagal';
        }

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }

        
    function update(Request $request){
        $respError = FALSE;
        $respMesssage = '';
        $id = (int)$request->id;

        $array_post = array();

        $request->validate([
            'no_tujuan' => 'numeric|required',
            'atas_nama' => 'required',
            'tujuan' => 'required',
        ]);

        $array_post['no_tujuan'] = $request->no_tujuan;
        $array_post['atas_nama'] = $request->atas_nama;
        $array_post['tujuan'] = $request->tujuan;

        $res = pembayaran_m::where('id', $id)->update($array_post);

        if($res){
            $respError = TRUE;
            $respMesssage = 'Update data Tujuan Pembayaran berhasil';
        }else{
            $respMesssage = 'Terjadi kesalahan saat update data';
        }
        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }
    
    function delete($id){
        $respError = FALSE;
        $respMesssage = '';
        
        $res = pembayaran_m::where('id', $id)->delete();
        if($res){
            $respError = TRUE;
            $respMesssage = 'Hapus data berhasil';
        }else{
            $respMesssage = 'Terjadi kesalahan saat hapus data';
        } 

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }
}