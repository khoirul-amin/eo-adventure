<?php

namespace App\Http\Controllers\Api;

use App\Http\Library\ResponseLibrary;
use App\Http\Library\ValidasiLibrary;
use App\Http\Models\user_m;
use App\Mail\MailSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController{
    public function register(Request $request){
        $validasi = array(
            'name' => $request->name,
            'email' =>$request->email,
            'password' => $request->password,
        );
        
        $validate = (new ValidasiLibrary())->cek($validasi);
        
        if($validate != null){
            return response()->json($validate);
        }else{
            $cek_email = user_m::where('email', $request->email)->first();
            // dd($cek_email);
            if(!$cek_email){
                $data = array();

                $data['password'] = Hash::make($request->password);
                $data['name'] = $request->name;
                $data['email'] = $request->email;

                $res = user_m::insert($data);

                if($res){
                    $cek_email = user_m::where('email', $request->email)->first();
                    Mail::to($request->email)->send(new MailSend($request->name));
                    if($cek_email){
                        
                        // Cek password
                        $cek_password = Hash::check($request->password, $cek_email->password);
        
                        if($cek_password){
                            $data = array();
                            $token =  Hash::make(date('d-m-Y H:i:s'));
        
                            $data['id'] = $cek_email->id;
                            $data['email'] = $cek_email->email;
                            $data['token'] = $token;
                            
                            user_m::where('email', $request->email)->update([
                                'last_login' => date('Y-m-d H:i:s'),
                                'token' => $token,
                            ]);
        
                            return response()->json((new ResponseLibrary())->res(200, $data, 'Register berhasil'));
                        }
                    }
                    // return response()->json((new ResponseLibrary())->res(200, null, 'Registrasi berhasil silahkan login'));
                }else{
                    return response()->json((new ResponseLibrary())->res(302, null, 'Terjadi kesalahan pada aplikasi'));
                }
            }else{
                return response()->json((new ResponseLibrary())->res(201, null, 'Email Sudah Terdaftar'));
            }
        }
    }

    public function login(Request $request){

        $validasi = array(
            'email' =>$request->email,
            'password' => $request->password,
        );
        
        $validate = (new ValidasiLibrary())->cek($validasi);

        if($validate != null){
            return response()->json($validate);
        }else{
            $cek_email = user_m::where('email', $request->email)->first();
            if($cek_email){
                
                // Cek password
                $cek_password = Hash::check($request->password, $cek_email->password);

                if($cek_password){
                    $data = array();
                    $token =  Hash::make(date('d-m-Y H:i:s'));

                    $data['id'] = $cek_email->id;
                    $data['email'] = $cek_email->email;
                    $data['token'] = $token;
                    
                    user_m::where('email', $request->email)->update([
                        'last_login' => date('Y-m-d H:i:s'),
                        'token' => $token,
                    ]);

                    return response()->json((new ResponseLibrary())->res(200, $data, 'Login berhasil'));
                }else{
                    return response()->json((new ResponseLibrary())->res(201, null, 'Password salah'));
                }
            }else{
                return response()->json((new ResponseLibrary())->res(201, null, 'Email Belum Terdaftar'));
            }
        }

    }

    public function update_profile(Request $request){
        $data = array();
        $id = $request->header('userId');

        if(!empty($request->avatar)){
            $avatar = $request->avatar;
            $extension = $avatar->getClientOriginalExtension();
            $size = $avatar->getSize();

            if($extension != "jpg" && $extension != "jpeg" && $extension != "png"){
                return response()->json((new ResponseLibrary())->res(301, null, 'Hanya mengizinkan file gambar : jpg,jpeg,png'));
            }
            if($size > 2097152){
                return response()->json((new ResponseLibrary())->res(301, null, 'Ukuran foto terlalu besar'));
            }

            $cek_data = user_m::where('id', '=', $id)->first();
            $nama_file = uniqid('avatar-' . rand(100,999)) . '.' . $avatar->getClientOriginalExtension();
            $image_cek = explode("/",$cek_data->avatar);
            $image_last = end($image_cek);
            
            if(File::exists(\base_path() .'/public/avatar/'.$image_last)){
                File::delete(\base_path() .'/public/avatar/'.$image_last);
                $avatar->move(\base_path() .'/public/avatar', $nama_file);
            }else{
                $avatar->move(\base_path() .'/public/avatar', $nama_file);
            }
            $data['avatar'] = '/avatar/'.$nama_file;
        }

        if($request->name){
            $data['name'] = $request->name;
        }
        if($request->telpon){
            $data['telpon'] = $request->telpon;
        }
        if($request->alamat){
            $data['alamat'] = $request->alamat;
        }

        $res = user_m::where('id', $id)->update($data);

        if($res){
            return response()->json((new ResponseLibrary())->res(200, null, 'Update profil berhasil'));
        }
    }

    public function get_profil($id){
        $result = user_m::where('id', (int)$id)->first();
        $data = array();
        $data['name'] = $result->name;
        $data['email'] = $result->email;
        $data['alamat'] = $result->alamat;
        $data['last_login'] = $result->last_login;


        if(empty($result->telpon)){
            $data['telpon'] = "-";
        }else{
            $data['telpon'] = $result->telpon;
        }
        if(empty($result->avatar)){
            $data['avatar'] = "/assets/adminLte/dist/img/avatar.png";
        }else{
            $data['avatar'] = $result->avatar;
        }

        return response()->json((new ResponseLibrary())->res(200, $data, 'Data Profil'));
    }

    public function test_mail(){
        Mail::to("anisatulmahzumah123@gmail.com")->send(new MailSend("Anisatul"));
    }
}
