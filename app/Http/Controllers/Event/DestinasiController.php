<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\destinasi_m;
use App\Http\Models\images_m;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class DestinasiController extends Controller{
    function index(){
        return view('pages.event.destinasi');
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'id',
            1 => 'nama_tujuan',
            2 =>'provinsi',
            3 =>'deskripsi_lokasi'
        );

        // Total Data
        $totaldata = count(destinasi_m::get());

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = destinasi_m::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        $totalFiltered = $totaldata;


        $data = array();
        if($posts){
            foreach($posts as $row){
                $btn_delete = "<button type='button' onclick=\"hapus('$row->id')\" class='ml-2 btn btn-sm btn-danger'>Delete</button>";
                $view_images = "<button type='button' data-toggle='modal' data-target='#modalView' onclick=\"getImages('$row->kode_destinasi')\" class='ml-2 btn btn-sm btn-warning'>View Images</button>";
                $nestedData['id'] = $row->id;
                $nestedData['nama_tujuan'] = $row->nama_tujuan;
                $nestedData['provinsi'] = $row->provinsi;
                $nestedData['deskripsi_lokasi'] =  substr($row->deskripsi_lokasi, 0, 60)."....";
                $nestedData['action'] = "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' onClick=\"setDataUpdate('$row->id','$row->nama_tujuan','$row->provinsi','$row->deskripsi_lokasi')\" data-target='#modalform'>Update</button> $view_images $btn_delete";
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

        $last_data = destinasi_m::max('id');
        $kode_destinasi = "DEST0".($last_data+1);

        $request->validate([
            'nama_tujuan' => 'required',
            'provinsi' => 'required',
            'deskripsi_lokasi' => 'required|max:500'
        ]);

        $nama_tujuan = $request->nama_tujuan;
        $provinsi = $request->provinsi;
        $deskripsi_lokasi = $request->deskripsi_lokasi;

        $posts = array();
        $posts['nama_tujuan'] = $nama_tujuan;
        $posts['provinsi'] = $provinsi;
        $posts['deskripsi_lokasi'] = $deskripsi_lokasi;
        $posts['kode_destinasi'] = $kode_destinasi;
        

        $res = destinasi_m::insert($posts);
            
        if($res){
            for($i=1; $i <= 4; $i++){
                images_m::insert([
                    'type' => $kode_destinasi,
                    'images' => '/images/gambar_kosong.png',
                    'deskripsi' => 'images'.$i
                ]);
            }
            $respError = TRUE;
            $respMesssage = 'Input data Tujuan berhasil';
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
            'nama_tujuan' => 'required',
            'provinsi' => 'required',
            'deskripsi_lokasi' => 'required'
        ]);

        $nama_tujuan = $request->nama_tujuan;
        $provinsi = $request->provinsi;
        $deskripsi_lokasi = $request->deskripsi_lokasi;

        $array_post = array();
        $array_post['nama_tujuan'] = $nama_tujuan;
        $array_post['provinsi'] = $provinsi;
        $array_post['deskripsi_lokasi'] = $deskripsi_lokasi;

        $res = destinasi_m::where('id', $id)->update($array_post);

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
    
    function delete($id){
        $respError = FALSE;
        $respMesssage = '';
        $cek_destinasi = destinasi_m::where('id', $id)->first();
        $cek_gambar = images_m::where('type', $cek_destinasi->kode_destinasi)->get();

        foreach($cek_gambar as $gambar){

            $image_cek = explode("/",$gambar->images);
            $image_last = end($image_cek);

            if($image_last != "gambar_kosong.png"){
                if(File::exists(\base_path() .'/public/images/'.$image_last)){
                    File::delete(\base_path() .'/public/images/'.$image_last);
                }
            }
        }
        images_m::where('type', $cek_destinasi->kode_destinasi)->delete();
        $res = destinasi_m::where('id', $id)->delete();
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

    function getgambar($id){
        $images = images_m::where('type', $id)->get();
        return response()->json($images);
    }
}