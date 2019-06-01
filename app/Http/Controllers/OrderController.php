<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $msg = "";
        if ($request->has("order")) 
        {
            $messages = [
                'qty.required'    => 'Please enter quantity',
            ];
            $validator = Validator::make($request->all(), [
                'product_name' => 'required',
                'qty' => 'required',
            ], $messages);
            if ($validator->fails()) {
                return redirect('/order')
                            ->withErrors($validator);
            }
            else
            {
                $good = DB::table("ProductInfo")
                          ->where("pId", $request->input("product_name"))
                          ->get();
                DB::table("OrderInfo")
                  ->insert([
                      "orderGoods" => $request->input("product_name"),
                      "orderUnit" => $good[0]->pUnit,
                      "orderUnitPrice" => $good[0]->pPrice,
                      "orderAmount" => $request->input("qty"),
                      "orderTotal" => $request->input("price"),
                      "orderCus" => $request->input("customer")
                  ]);
                $msg = "Success";
            }     
        }
        $products = DB::table("ProductInfo")
                          ->get();     
        return view('functions.order', compact("products", "msg"));
    }
}
