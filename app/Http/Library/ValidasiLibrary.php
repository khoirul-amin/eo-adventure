<?php

namespace App\Http\Library;


use App\Http\Library\ResponseLibrary;

class ValidasiLibrary{
    public function cek($data){
        $res_data = array();

        foreach($data as $key => $val ){
            if(empty($data[$key])){
                $res_data[] = "data $key kosong";
            }
        }
        
        if(!empty($res_data)){
            return (new ResponseLibrary())->res(204 , $res_data, "Input Kosong");
        }
    }

}
