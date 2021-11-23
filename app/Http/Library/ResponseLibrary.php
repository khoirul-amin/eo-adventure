<?php

namespace App\Http\Library;

class ResponseLibrary{

    private $_OK = "Success";
    private $_UNAUTHORIZED = "Unauthorized";
    private $_NO_CONTENT = "Success";
    private $_ERROR = "Error";

    public function res($code, $data = null, $mesage = ""){
        date_default_timezone_set("Asia/Jakarta");
        
        $result = array();
        
        $result['code'] = $code; 
        $result['status'] = $this->_OK;
        $result['message'] = $mesage;
        $result['time'] = date('d-m-Y H:i:s');
        $fake = array("Fake Data");

        if($data != null){
            $result['data'] = $data; 
        }else{
            $result['data'] = $fake;
        }

        return $result;
    }

}
