<?php

namespace App\Http\Controllers\Ulasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ulasan_m;

class GaleryController extends Controller{
    function index(){
        return view('pages.ulasan.galery');
    }

}