<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{

    public function index(){
        return view('layouts.app',[
           'page'=>'SellerAuthentication.index'
        ]);
    }
}
