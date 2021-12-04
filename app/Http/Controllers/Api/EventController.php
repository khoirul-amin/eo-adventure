<?php

namespace App\Http\Controllers\Api;

use App\Http\Library\ResponseLibrary;
use App\Http\Library\ValidasiLibrary;
use App\Http\Models\agenda_m;
use App\Http\Models\event_m;
use App\Http\Models\images_m;
use App\Http\Models\kategori_m;
use App\Http\Models\keterangan_m;
use App\Http\Models\paket_m;
use App\Http\Models\transportasi_m;
use Illuminate\Http\Request;

class EventController{
    function get_all(){
        $events = event_m::join('images', 'event.kode_event', '=', 'images.type')->where('images.deskripsi', 'images1')->get(['event.*', 'images.images']);
        if($events->first()){
            return response()->json((new ResponseLibrary())->res(200, $events, 'Data event'));
        }else{
            return response()->json((new ResponseLibrary())->res(200, null, 'Data event kosong'));
        }
    }
    function get_all_kategori(){
        $kategori = kategori_m::get();
        if($kategori->first()){
            return response()->json((new ResponseLibrary())->res(200, $kategori, 'Data kategori event'));
        }else{
            return response()->json((new ResponseLibrary())->res(200, null, 'Data kategori event kosong'));
        }
    }

    function get_by_kategori($id){
        $event = event_m::join('kategori_event', 'event.kategori_id', '=', 'kategori_event.id')->where('event.kategori_id', $id)->get(['event.*', 'kategori_event.kategori'])->first();

        if($event){
            $data = array();

            $keterangan = keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Deskripsi')->get(['judul_keterangan','keterangan'])->first();
            $perlengkapan =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Perlengkapan')->get(['judul_keterangan','keterangan']);
            $fasilitas =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Fasilitas')->get(['judul_keterangan','keterangan']);
            $tidaktermasuk =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Tidak Termasuk')->get(['judul_keterangan','keterangan']);


            $banner_event = images_m::where('type', $event->kode_event)->get();
            $transportasi = transportasi_m::where('id', (int)$event->transportasi_id)->first();
            $banner_trans = images_m::where('type', $transportasi->kode_transportasi)->get();
            $agenda = agenda_m::join('destinasi','agenda.destinasi_id','=','destinasi.id')->where('agenda.event_id', $event->id)->get(['agenda.*','destinasi.nama_tujuan','destinasi.provinsi']);
            $paket = paket_m::where('event_id', $event->id)->get();


            $data['event'] = $event;
            $data['banner_event'] = $banner_event;
            $data['transportasi'] = $transportasi;
            $data['banner_trans'] = $banner_trans;
            $data['agenda'] = $agenda;
            $data['paket'] = $paket;

            if($keterangan){
                $data['keterangan'] = $keterangan;
            }else{
                $data['keterangan'] = array();
            }

            $data['perlengkapan'] = $perlengkapan;
            $data['fasilitas'] = $fasilitas;
            $data['tidaktermasuk'] = $tidaktermasuk;


            return response()->json((new ResponseLibrary())->res(200, $data, "Data event dengan id : $id"));
        }else{
            return response()->json((new ResponseLibrary())->res(200, null, 'Data event kosong'));
        }
    }

    function get_by_id($id){
        $event = event_m::join('kategori_event', 'event.kategori_id', '=', 'kategori_event.id')->where('event.id', $id)->get(['event.*', 'kategori_event.kategori'])->first();

        if($event){
            $data = array();

            $keterangan = keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Deskripsi')->get(['judul_keterangan','keterangan'])->first();
            $perlengkapan =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Perlengkapan')->get(['judul_keterangan','keterangan']);
            $fasilitas =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Fasilitas')->get(['judul_keterangan','keterangan']);
            $tidaktermasuk =  keterangan_m::where('event_id', $event->id)->where('judul_keterangan', 'Tidak Termasuk')->get(['judul_keterangan','keterangan']);


            $banner_event = images_m::where('type', $event->kode_event)->get();
            $transportasi = transportasi_m::where('id', (int)$event->transportasi_id)->first();
            $banner_trans = images_m::where('type', $transportasi->kode_transportasi)->get();
            $agenda = agenda_m::join('destinasi','agenda.destinasi_id','=','destinasi.id')->where('agenda.event_id', $event->id)->get(['agenda.*','destinasi.nama_tujuan','destinasi.provinsi']);
            $paket = paket_m::where('event_id', $event->id)->get();


            $data['event'] = $event;
            $data['banner_event'] = $banner_event;
            $data['transportasi'] = $transportasi;
            $data['banner_trans'] = $banner_trans;
            $data['agenda'] = $agenda;
            $data['paket'] = $paket;

            if($keterangan){
                $data['keterangan'] = $keterangan;
            }else{
                $data['keterangan'] = array();
            }

            $data['perlengkapan'] = $perlengkapan;
            $data['fasilitas'] = $fasilitas;
            $data['tidaktermasuk'] = $tidaktermasuk;


            return response()->json((new ResponseLibrary())->res(200, $data, "Data event dengan id : $id"));
        }else{
            return response()->json((new ResponseLibrary())->res(200, null, 'Data event kosong'));
        }
    }
}