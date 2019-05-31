<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
    	$products = DB::table("ProductInfo")
    				  ->get();
        return view('functions.order', compact("products"));
    }
}
