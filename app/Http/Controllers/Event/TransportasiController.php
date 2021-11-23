<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Models\images_m;
use Illuminate\Http\Request;
use App\Http\Models\transportasi_m;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class TransportasiController extends Controller{
    function index(){
        return view('pages.event.transportasi');
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'id',
            1 => 'transportasi',
            2 =>'muatan',
            3 =>'keterangan',
            4 =>'transportasi'
        );

        // Total Data
        $totaldata = count(transportasi_m::get());

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = transportasi_m::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        $totalFiltered = $totaldata;


        $data = array();
        if($posts){
            foreach($posts as $row){
                $btn_delete = "<button type='button' onclick=\"hapus('$row->id')\" class='ml-2 btn btn-sm btn-danger'>Delete</button>";
                $view_images = "<button type='button' data-toggle='modal' data-target='#modalView' onclick=\"getImages('$row->kode_transportasi')\" class='ml-2 btn btn-sm btn-warning'>View Images</button>";
                $nestedData['id'] = $row->id;
                $nestedData['transportasi'] = $row->transportasi;
                $nestedData['muatan'] = $row->muatan. " Orang";
                $nestedData['keterangan'] = substr($row->keterangan, 0, 60)."....";
                $nestedData['action'] = "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' onClick=\"setDataUpdate('$row->id','$row->transportasi','$row->muatan','$row->keterangan')\" data-target='#modalform'>Update</button> $view_images $btn_delete";
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

        $last_data = transportasi_m::max('id');
        $kode_transportasi = "TRANS0".($last_data+1);

        $request->validate([
            'transportasi' => 'required',
            'muatan' => 'required',
            'keterangan' => 'required|max:500'
        ]);

        $transportasi = $request->transportasi;

        $posts = array();
        $posts['transportasi'] = $transportasi;
        $posts['muatan'] = $request->muatan;
        $posts['keterangan'] = $request->keterangan;
        $posts['kode_transportasi'] = $kode_transportasi;
        
        $res = transportasi_m::insert($posts);
            
        if($res){
            for($i=1; $i <= 4; $i++){
                images_m::insert([
                    'type' => $kode_transportasi,
                    'images' => '/images/gambar_kosong.png',
                    'deskripsi' => 'images'.$i
                ]);
            }
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

        $request->validate([
            'transportasi' => 'required',
            'muatan' => 'required',
            'keterangan' => 'required|max:500'
        ]);

        $posts = array();
        $posts['transportasi'] = $request->transportasi;
        $posts['muatan'] = $request->muatan;
        $posts['keterangan'] = $request->keterangan;

        $res = transportasi_m::where('id', $id)->update($posts);

        if($res){
            $respError = TRUE;
            $respMesssage = 'Update data Transportasi berhasil';
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
        
        $cek_destinasi = transportasi_m::where('id', $id)->first();
        $cek_gambar = images_m::where('type', $cek_destinasi->kode_transaksi)->get();

        foreach($cek_gambar as $gambar){

            $image_cek = explode("/",$gambar->images);
            $image_last = end($image_cek);

            if($image_last != "gambar_kosong.png"){
                if(File::exists(\base_path() .'/public/images/'.$image_last)){
                    File::delete(\base_path() .'/public/images/'.$image_last);
                }
            }
        }

        images_m::where('type', $cek_destinasi->kode_transaksi)->delete();
        $res = transportasi_m::where('id', $id)->delete();
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


    function updategambar(Request $request){

        if(!empty($request->images1)){
            $request->validate([
                'images1' => 'max:2000|mimes:jpg,png,jpeg',
            ]);
        }
        if(!empty($request->images2)){
            $request->validate([
                'images2' => 'max:2000|mimes:jpg,png,jpeg',
            ]);
        }
        if(!empty($request->images3)){
            $request->validate([
                'images3' => 'max:2000|mimes:jpg,png,jpeg',
            ]);
        }
        if(!empty($request->images4)){
            $request->validate([
                'images4' => 'max:2000|mimes:jpg,png,jpeg',
            ]);
        }

        $respError = FALSE;
        $respMesssage = '';

        try {
            $kode = $request->id_gambar;
            $cek_images = images_m::where('type', $kode)->get();
            foreach($cek_images as $row){
                $file_column = $row->deskripsi;

                if(!empty($request->$file_column)){
                    $file = $request->$file_column;
                    $file_image = $kode.$row->deskripsi.'.' . $file->getClientOriginalExtension();

                    $post = array();

                    $image_cek = explode("/",$row->images);
                    $image_last = end($image_cek);
                    if($image_last != "gambar_kosong.png"){
                        if(File::exists(\base_path() .'/public/images/'.$image_last)){
                            File::delete(\base_path() .'/public/images/'.$image_last);
                            $file->move(\base_path() .'/public/images', $file_image);
                        }else{
                            $file->move(\base_path() .'/public/images', $file_image);
                        }
                    }else{
                        $file->move(\base_path() .'/public/images', $file_image);
                    }

                    $post['type'] = $kode;
                    $post['images'] = '/images/'.$file_image;
                    $post['deskripsi'] = $row->deskripsi;

                    images_m::where('id', $row->id)->update($post);
                } 
            }
            $respError = TRUE;
            $respMesssage = 'Update image berhasil';
        } catch (\Throwable $th) {
            $respMesssage = $th;
        }

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);

    }
    
    function getgambar($id){
        $images = images_m::where('type', $id)->get();
        return response()->json($images);
    }
}