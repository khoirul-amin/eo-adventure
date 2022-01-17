<?php

namespace App\Http\Controllers\Api;

use App\Http\Library\ResponseLibrary;
use App\Http\Library\ValidasiLibrary;
use App\Http\Models\event_m;
use App\Http\Models\images_m;
use App\Http\Models\paket_m;
use App\Http\Models\transaksi_m;
use App\Http\Models\user_m;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class TransaksiController{
    function all_history(Request $request){
        $userId = $request->header('userId');

        $history = transaksi_m::join('paket', 'transaksi.paket_id', '=', 'paket.id')
        ->join('event', 'transaksi.event_id', '=', 'event.id')
        ->join('images', 'event.kode_event', '=', 'images.type')->where('images.deskripsi','images1')
        ->where('transaksi.user_id',$userId)->orderBy('transaksi.id', 'DESC')->get(['transaksi.*','event.judul']);

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
        ->join('pembayaran', 'transaksi.pembayaran_id','=','pembayaran.id')
        ->where('transaksi.id', $id)
        ->get(['transaksi.*', 'pembayaran.*','transaksi.id as id_transaksi','event.*','users.telpon','users.name','paket.paket','paket.harga','kategori_event.kategori','transportasi.transportasi'])->first();

        

        if($history->first()){
            $gambar = images_m::where('type', $history->kode_event)->first();
            $res = array();

            $res['id'] = $history->id_transaksi;
            $res['id_event'] = $history->event_id;
            $res['invoice'] = $history->invoice;
            $res['tanggal'] = $history->tanggal;
            $res['pemberangkatan'] = $history->pemberangkatan;
            $res['bukti_pembayaran'] = $history->bukti_pembayaran; 
            if(empty($history->bukti_pembayaran)){
                $res['bukti_pembayaran'] = "Kosong"; 
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
                $res['keterangan'] = "Kosong";
            }
            $res['judul'] = $history->judul;
            $res['biaya'] = $history->harga;
            $res['transportasi'] = $history->transportasi;
            $res['kategori'] = $history->paket;
            $res['gambar'] = $gambar->images;
            $res['kode_pembayaran'] = "1161900000001902";
            $res['nama_pemilik'] = $history->atas_nama;
            $res['nama_tujuan_pembayaran'] = $history->tujuan;
            

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
            $user = user_m::where('id',$request->header('userId'))->first();
            if(!empty($user->telpon)){
                $paket = paket_m::where('id', $request->paket_id)->first();
                $event = event_m::where('id', $request->event_id)->first();
                $posts = array();

                $date = date_create($request->tanggal_pemberangkatan);
                $dateformat = date_format($date,"Y-m-d H:i:s");
                $pembayaran = date('Y-m-d H:i:s',strtotime($dateformat . "-1 days"));

                $posts['pemberangkatan'] = $dateformat;
                $posts['pembayaran_id'] = $request->pembayaran_id;
                $posts['user_id'] = $request->header('userId');
                $posts['event_id'] = $request->event_id;
                $posts['paket_id'] = $request->paket_id;
                $posts['tanggal'] = date('Y-m-d H:i:s');
                $posts['invoice'] = 'TRX'.$request->header('userId').date('Ymd').(transaksi_m::max('id')+1);
                $posts['status_transaksi'] = 3;
                $posts['dadeline_pembayaran'] = $pembayaran;


                $test_data = array(
                    "amount" => $paket->harga,
                    "cust_email" => $user->email,
                    "cust_id" => $user->id,
                    "cust_msisdn" => $user->id.$user->telpon,
                    "cust_name" => $user->name,
                    "invoice" => 'TRX'.$request->header('userId').date('Ymd').(transaksi_m::max('id')+1),  
                    "merchant_id" => "J777IYQZGM58I",
                    "items" => "TEST 123",
                    "sof_type" => "pay",
                    "sof_id" => "vabni",
                    "return_url" => "https://enjocyjoky2hc.x.pipedream.net",
                    "success_url" => "https://enprkoj2cr34s.x.pipedream.net",
                    "failed_url" => "https://enbgemck5o0z.x.pipedream.net",
                    "back_url" => "https://en83plhn4lo0g.x.pipedream.net",
                    "timeout" => "300",  
                    "trans_date" => date('YmdHis'),
                    "add_info1" => $user->name."-".$event->judul,
                    "add_info2" => "JM-Adventure",
                    "add_info3" => "tiga",
                    "add_info4" => "empat",
                    "add_info5" => "jt5m7523vspqntsmqd8yd634"	
                );



                $tes = $this->createSignature($test_data,"cWITayeA");
                $test_data["mer_signature"] = $tes["result"];

                // $response_api = Http::post('https://sandbox.finpay.co.id/servicescode/api/pageFinpay.php', $test_data);
                $response_api = Http::post('https://sandbox.finpay.co.id/servicescode/api/apiFinpay.php', $test_data);
                $response_code =  $response_api->json()["status_code"];
                if($response_code != "00"){
                    return response()->json((new ResponseLibrary())->res(302, null, $response_api->json()["status_desc"]));
                }else{
                    $posts['keterangan'] = $response_api->json()["redirect_url"];
                    $id = transaksi_m::insertGetId($posts);

                    if(!empty($id)){
                        return response()->json((new ResponseLibrary())->res(200, $id, "Request order berhasil silahkan lakukan pembayaran terahir tanggal $pembayaran"));
                    }else{
                        return response()->json((new ResponseLibrary())->res(302, null, 'Terjadi kesalahan pada aplikasi'));
                    }
                }
            }else{
                return response()->json((new ResponseLibrary())->res(302, null, 'Lengkapi nomor telpon anda sebelum mulai transaksi'));
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


    function createSignature($data,$pass){
        $sign_component = $this->mer_signature($data,$sortir='Y').$pass;
        $sign_result = strtoupper(hash("sha256",$sign_component));
        $sign_response['component'] = $sign_component;
        $sign_response['result'] = $sign_result;
        return($sign_response);
    }
    
    function mer_signature($dataArray,$sortir=''){
        $output = "";
        unset($dataArray['mer_signature']);
        $result = array_filter($dataArray);
        if($sortir=='Y'){
            ksort ($result);
        }
        foreach($result as $key=>$val){
            if(!empty($val)){
                if(is_array($val)){
                    $output .= json_encode($val).'%';
                }else{
                    $output .= $val.'%';
                }
            }
        }
        return strtoupper($output);
    }
}