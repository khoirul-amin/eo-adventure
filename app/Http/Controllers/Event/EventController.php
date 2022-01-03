<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Models\agenda_m;
use App\Http\Models\destinasi_m;
use Illuminate\Http\Request;
use App\Http\Models\event_m;
use App\Http\Models\images_m;
use App\Http\Models\kategori_m;
use App\Http\Models\keterangan_m;
use App\Http\Models\paket_m;
use App\Http\Models\transportasi_m;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class EventController extends Controller{
    function index(){
        $transportasi =  transportasi_m::get();
        $kategori = kategori_m::get();
        $destinasi = destinasi_m::get();
        return view('pages.event.event', compact('transportasi','kategori','destinasi'));
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'id',
            1 => 'judul',
            2 =>'biaya',
            3 =>'judul',
            4 => 'judul',
            5 =>'judul'
        );

        // Total Data
        $totaldata = count(event_m::get());

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = event_m::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        $totalFiltered = $totaldata;


        $data = array();
        if($posts){
            foreach($posts as $row){
                $kategori = kategori_m::where('id', $row->kategori_id)->first();

                $btn_delete = "<button type='button' onclick=\"hapus('$row->id')\" class='ml-2 btn btn-sm btn-danger'>Delete</button>";
                $view_images = "<button type='button' data-toggle='modal' data-target='#modalView' onclick=\"getImages('$row->kode_event')\" class='ml-2 btn btn-sm btn-warning'>Images</button>";
                $paket_peserta = "<button type='button' data-toggle='modal' data-target='#paketView' onclick=\"getPaket('$row->id')\" class='ml-2 btn btn-sm btn-warning'>Paket Peserta</button>";
                $keterangan_event = "<button type='button' data-toggle='modal' data-target='#keteranganView' onclick=\"getKeterangan('$row->id')\" class='ml-2 btn btn-sm btn-success'>Keterangan</button>";

                $view_event = "<a class='ml-2 btn btn-success btn-sm' href='/event/$row->id'>View Full </a>";


                $nestedData['id'] = $row->id;
                $nestedData['judul'] = $row->judul;
                $nestedData['biaya'] = 'Rp '. number_format($row->biaya,0,',','.');
                $nestedData['kategori'] = $kategori->kategori;

                $nestedData['tujuan'] = "<button data-toggle='modal' data-target='#agendaView' onclick=\"getAgenda('$row->id')\" class='btn btn-primary btn-sm' type='button' >Agenda & Tujuan</button>";

                $nestedData['action'] = "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' onClick=\"setDataUpdate('$row->id','$row->judul','$row->biaya','$row->transportasi_id','$row->kategori_id','$row->kuota')\" data-target='#modalform'>Update</button> $view_images $keterangan_event $btn_delete $paket_peserta $view_event";
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

        $last_data = event_m::max('id');
        $kode_destinasi = "EVNT0".($last_data+1);

        $request->validate([
            'judul' => 'required',
            'biaya' => 'required',
            'kuota' => 'required|numeric',
            'transportasi' => 'required',
            'kategori' => 'required'
        ]);

        $posts = array();
        $posts['judul'] = $request->judul;
        $posts['biaya'] = $request->biaya;
        $posts['kuota'] = $request->kuota;
        $posts['kategori_id'] = $request->kategori;
        $posts['transportasi_id'] = $request->transportasi;
        $posts['kode_event'] = $kode_destinasi;

        $res = event_m::insert($posts);
            
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
            'judul' => 'required',
            'biaya' => 'required',
            'kuota' => 'required',
            'transportasi' => 'required',
            'kategori' => 'required'
        ]);

        $array_post = array();
        $array_post['judul'] = $request->judul;
        $array_post['biaya'] = $request->biaya;
        $array_post['kuota'] = $request->kuota;
        $array_post['kategori_id'] = $request->kategori;
        $array_post['transportasi_id'] = $request->transportasi;

        $res = event_m::where('id', $id)->update($array_post);

        if($res){
            $respError = TRUE;
            $respMesssage = 'Update data event berhasil';
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
        $cek_destinasi = event_m::where('id', $id)->first();
        $cek_gambar = images_m::where('type', $cek_destinasi->kode_event)->get();

        foreach($cek_gambar as $gambar){

            $image_cek = explode("/",$gambar->images);
            $image_last = end($image_cek);

            if($image_last != "gambar_kosong.png"){
                if(File::exists(\base_path() .'/public/images/'.$image_last)){
                    File::delete(\base_path() .'/public/images/'.$image_last);
                }
            }
        }
        images_m::where('type', $cek_destinasi->kode_event)->delete();
        keterangan_m::where('event_id', $cek_destinasi->id)->delete();
        paket_m::where('event_id', $cek_destinasi->id)->delete();
        agenda_m::where('event_id', $cek_destinasi->id)->delete();
        $res = event_m::where('id', $id)->delete();
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
    // Update Data Peserta
    function get_data_paket(Request $request){
        $posts = paket_m::where('event_id', (int)$request->id)->get();
        $data = array();
        if($posts){
            foreach($posts as $row){
                $nestedData['id'] = $row->id;
                $nestedData['paket'] = $row->paket;
                $nestedData['harga'] = 'Rp '. number_format($row->harga,0,',','.');
                $nestedData['action'] = "<button type='button' onclick=\"hapusPaket('$row->id')\" class='btn btn-sm btn-danger'>Hapus</button>";
                $data[] = $nestedData;
            }
        }

        echo json_encode(array(
            "data"              => $data
        ));
    }

    function insertpaket(Request $request){
        paket_m::insert([
            'event_id' => $request->event_id,
            'paket' => $request->paket,
            'harga' => $request->harga
        ]);

        $respError = TRUE;
        $respMesssage = 'Input data Paket peserta berhasil';

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }
    function hapuspaket($id){
        
        $res = paket_m::where('id', (int)$id)->delete();
        if($res){
            $respError = TRUE;
            $respMesssage = 'Hapus data berhasil';
        }else{
            $respError = FALSE;
            $respMesssage = 'Terjadi kesalahan saat hapus data';
        } 

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }

    function get_data_jadwal(Request $request){
        $posts = agenda_m::join('destinasi', 'agenda.destinasi_id', '=', 'destinasi.id')->where('event_id', (int)$request->id)->get(['agenda.*', 'destinasi.nama_tujuan']);
        $data = array();
        if($posts){
            foreach($posts as $row){
                $nestedData['id'] = $row->id;
                $nestedData['waktu'] = "<b>$row->waktu</b>";
                $nestedData['tujuan'] = "<b>$row->nama_tujuan </b> <br/> $row->keterangan";
                $nestedData['action'] = "<button type='button' onclick=\"hapusJadwal('$row->id')\" class='btn btn-sm btn-danger'>Hapus</button>";
                $data[] = $nestedData;
            }
        }

        echo json_encode(array(
            "data"              => $data
        ));
    }

    function insertjadwal(Request $request){
        
        $request->validate([
            'kegiatan' => 'required|max:500',
            'waktu' => 'required'
        ]);

        agenda_m::insert([
            'event_id' => $request->eventagenda_id,
            'destinasi_id' => $request->destinasi,
            'keterangan' => $request->kegiatan,
            'waktu' => $request->waktu
        ]);

        $respError = TRUE;
        $respMesssage = 'Input data jadwal kegiatan berhasil';

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }
    function hapusjadwal($id){
        
        $res = agenda_m::where('id', (int)$id)->delete();
        if($res){
            $respError = TRUE;
            $respMesssage = 'Hapus data berhasil';
        }else{
            $respError = FALSE;
            $respMesssage = 'Terjadi kesalahan saat hapus data';
        } 

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }

    function get_data_keterangan(Request $request){
        $posts = keterangan_m::where('event_id', $request->id)->orderBy('judul_keterangan', 'ASC')->get();
        $data = array();
        if($posts){
            $judul = "";
            $no = 1;
            foreach($posts as $row){
                if($judul == $row->judul_keterangan){
                    $nestedData['judul'] = "";
                    $nestedData['id'] = "";
                }else{
                    $judul = $row->judul_keterangan;
                    $nestedData['judul'] = "<b>$judul</b>";
                    $nestedData['id'] = $no;
                    $no++;
                }
                $nestedData['keterangan'] = $row->keterangan;
                $nestedData['action'] = "<button type='button' onclick=\"hapusKeterangan('$row->id')\" class='btn btn-sm btn-danger'>Hapus</button>";
                $data[] = $nestedData;
            }
        }

        echo json_encode(array(
            "data"              => $data
        ));
    }

    function insertketerangan(Request $request){
        
        $request->validate([
            'keterangan' => 'required|max:1000'
        ]);

        keterangan_m::insert([
            'event_id' => $request->eventketerangan_id,
            'judul_keterangan' => $request->jenis,
            'keterangan' => $request->keterangan
        ]);

        $respError = TRUE;
        $respMesssage = 'Input data keterangan berhasil';

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }

    function hapusketerangan($id){
        
        $res = keterangan_m::where('id', (int)$id)->delete();
        if($res){
            $respError = TRUE;
            $respMesssage = 'Hapus data berhasil';
        }else{
            $respError = FALSE;
            $respMesssage = 'Terjadi kesalahan saat hapus data';
        } 

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }

    function view_event($id){
        $event = event_m::join('kategori_event', 'event.kategori_id','=', 'kategori_event.id')->where('event.id', $id)->get(['event.*','kategori_event.kategori'])->first();
        $banner_event = images_m::where('type', $event->kode_event)->get();
        $transportasi = transportasi_m::where('id', (int)$event->transportasi_id)->first();
        $banner_trans = images_m::where('type', $transportasi->kode_transportasi)->get();
        $agenda = agenda_m::join('destinasi','agenda.destinasi_id','=','destinasi.id')->where('agenda.event_id', $event->id)->get(['agenda.*','destinasi.nama_tujuan','destinasi.provinsi']);
        $paket = paket_m::where('event_id', $event->id)->get();
        $keterangan = keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Deskripsi')->first();
        $perlengkapan =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Perlengkapan')->get();
        $fasilitas =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Fasilitas')->get();
        $tidaktermasuk =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Tidak Termasuk')->get();


        return view('pages.event.view_event', compact('event','banner_event','transportasi','banner_trans','paket','agenda','keterangan', 'perlengkapan', 'fasilitas', 'tidaktermasuk'));
    }

}