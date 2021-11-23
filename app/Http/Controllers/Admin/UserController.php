<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\user_m;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class UserController extends Controller{
    function index(){
        return view('pages.users.user');
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'id',
            1 => 'avatar',
            2 => 'name',
            3 => 'alamat',
            4 => 'id'
        );

        // Total Data
        $totaldata = count(user_m::get());

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = user_m::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        $totalFiltered = $totaldata;


        $data = array();
        if($posts){
            foreach($posts as $row){
                $btn_delete = "<button type='button' onclick=\"hapus('$row->id')\" class='ml-2 btn btn-sm btn-danger'>Delete</button>";
                $avatar = "";
                $default_avatar = URL::to('/').'/assets/adminLte/dist/img/avatar6.png';
                if(!empty($row->avatar)){
                    $avatar = "<img class='rounded-circle' width='50px' src='$row->avatar' alt='avatar' />";
                } else {
                    $avatar = "<img class='rounded-circle' width='50px' src='$default_avatar' alt='avatar' />";
                }
                $nestedData['id'] = $row->id;
                $nestedData['avatar'] = $avatar;
                $nestedData['akun'] = "<b>Nama :</b> $row->name <br/> <b>Email :</b> $row->email <br/> <b>Telpon :</b> $row->telpon";
                $nestedData['data'] = "<b>Alamat :</b> $row->alamat <br/>  <b>Last Login :</b> $row->last_login";
                // $nestedData['last_login'] = $row->last_login;
                $nestedData['action'] = "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' onClick=\"setDataUpdate('$row->id','$row->name','$row->email')\" data-target='#modalform'>Update</button>";
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
            'avatar' => 'required|max:2000|mimes:jpg,png,jpeg',
            'password' => 'required|min:8',
            'email' => 'required|email',
            'name' => 'required',
        ]);
        $cek_email = user_m::where('email', $request->email)->first();

        if(!$cek_email){
            $role = $request->alamat;
            $name = $request->name;
            $email = $request->email;
            $password = Hash::make($request->password);

            $posts = array();


            $post['role'] = $role;
            $post['name'] = $name;
            $post['email'] = $email;
            $post['password'] = $password;
            $post['telpon'] = $request->telpon;


            $file = $request->avatar;
    
            $file_avatar = uniqid('avatar-' . rand(100,999)) . '.' . $file->getClientOriginalExtension();
            $result_file = $file->move(\base_path() .'/public/avatar', $file_avatar);
    
            if($result_file){
                $post['image'] = '/avatar/'.$file_avatar;
            }else{
                $respMesssage = 'Terjadi kesalahan saat upload gambar';
            }

            $res = user_m::insert($posts);
                
            if($res){
                $respError = TRUE;
                $respMesssage = 'Input data Admin berhasil';
            }else{
                $respMesssage = 'Input data Gagal';
            }
            
        }else{
            $respMesssage = 'Email sudah terdaftar';
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

        if($request->password){
            $request->validate([
                'password' => 'required|min:8'
            ]);
            $array_post['password'] = Hash::make($request->password);
        }

        $res = user_m::where('id', $id)->update($array_post);

        if($res){
            $respError = TRUE;
            $respMesssage = 'Update data Admin berhasil';
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
        if($id == Auth::id()){
            $respMesssage = 'Anda tidak bisa menghapus akun anda';
        }else{

        
            $cek_data = user_m::where('id', '=', $id)->first();
            
            $image_cek = explode("/",$cek_data->image);
            $image_last = end($image_cek);
            if(File::exists(\base_path() .'/public/avatar/'.$image_last)){
                File::delete(\base_path() .'/public/avatar/'.$image_last);
            }
            $res = user_m::where('id', $id)->delete();
            if($res){
                $respError = TRUE;
                $respMesssage = 'Hapus data berhasil';
            }else{
                $respMesssage = 'Terjadi kesalahan saat hapus data';
            } 
        }

        $response = array(
            'status' => $respError,
            'message' => $respMesssage
        );

        return response()->json($response);
    }
}
