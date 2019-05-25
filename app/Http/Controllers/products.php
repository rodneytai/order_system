<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class products extends Controller
{
    //
    public function index()
    {
        return view('functions.products_list');
    }
}
