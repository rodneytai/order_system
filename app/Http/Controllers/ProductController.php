<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductInfo as Products;
use DB;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = DB::table('ProductInfo')
                      ->paginate(15);
        return view('functions.products_list',
            compact('products'));
    }
}
