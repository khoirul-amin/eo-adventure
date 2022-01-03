<?php

namespace App\Http\Controllers\Ulasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ulasan_m;

class UlasanController extends Controller{
    function index(){
        return view('pages.ulasan.ulasan');
    }

    function get_datatables(Request $request){
        $columns = array(
            0 =>'ulasan.id',
            1 => 'users.name',
            2 =>'ulasan.rate',
            3 =>'ulasan.ulasan',
        );

        // Total Data
        $totaldata = count(ulasan_m::get());


        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $posts = ulasan_m::join('users','ulasan.user_id','=','users.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get(['ulasan.*', 'users.name']);
        $totalFiltered = $totaldata;

        $data = array();
        if($posts){
            $no = 1;
            foreach($posts as $row){

                $nestedData['no'] = $no;
                $nestedData['nama'] = $row->name;
                $nestedData['rating'] =  $row->rate."/5";
                $nestedData['ulasan'] = $row->ulasan;
                $data[] = $nestedData;
                $no++;
            }
        }

        echo json_encode(array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totaldata),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data
        ));
    }


}