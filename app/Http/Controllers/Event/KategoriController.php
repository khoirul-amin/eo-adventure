<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\kategori_m;

class KategoriController extends Controller{
    function index(){
        return view('pages.event.kategori');
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'id',
            1 => 'kategori',
            2 =>'kategori'
        );

        // Total Data
        $totaldata = count(kategori_m::get());

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = kategori_m::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        $totalFiltered = $totaldata;


        $data = array();
        if($posts){
            foreach($posts as $row){
                $btn_delete = "<button type='button' onclick=\"hapus('$row->id')\" class='ml-2 btn btn-sm btn-danger'>Delete</button>";
                $nestedData['id'] = $row->id;
                $nestedData['kategori'] = $row->kategori;
                $nestedData['action'] = "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' onClick=\"setDataUpdate('$row->id','$row->kategori')\" data-target='#modalform'>Update</button> $btn_delete";
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
            'kategori' => 'required'
        ]);

        $kategori = $request->kategori;

        $posts = array();
        $posts['kategori'] = $kategori;
        
        $res = kategori_m::insert($posts);
            
        if($res){
            $respError = TRUE;
            $respMesssage = 'Input data Admin berhasil';
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
            'kategori' => 'required',
        ]);
        $array_post['kategori'] = $request->kategori;

        $res = kategori_m::where('id', $id)->update($array_post);

        if($res){
            $respError = TRUE;
            $respMesssage = 'Update data kategori berhasil';
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
        
        $res = kategori_m::where('id', $id)->delete();
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