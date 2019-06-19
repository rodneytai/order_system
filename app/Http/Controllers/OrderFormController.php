<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;

class OrderFormController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        $products = DB::table('ProductInfo')
                      ->get();
        $isAdmin = Auth::user()->auth;
        if ($isAdmin == 'admin') 
        {
            if ($request->has("save")) 
            {
                if ($request->input("edit_amount")) 
                {
                    DB::table("OrderInfo")
                      ->where("orderId", key($request->input("save")))
                      ->update([
                            "orderGoods" => $request->input("pName"),
                            "orderUnit" => $request->input("unit"),
                            "orderUnitPrice" => $request->input("unitprice"),
                            "orderAmount" => $request->input("edit_amount"),
                            "orderTotal" => $request->input("price")
                      ]);
                }
            }
            if ($request->has("delete")) 
            {
                DB::table("OrderInfo")
                  ->where("orderId", key($request->input("delete")))
                  ->delete();
                DB::table("DeliveryDetails")
                  ->where("dOrderId", key($request->input("delete")))
                  ->delete();
            }
            $details = DB::table("OrderInfo")
                         ->leftjoin("users", "users.id", "OrderInfo.orderCus")
                         ->leftjoin("ProductInfo", "OrderInfo.orderGoods", "ProductInfo.pId")
                         ->select(
                            'orderId',
                            'orderGoods',
                            'orderUnit',
                            'orderUnitPrice',
                            'orderAmount',
                            'orderTotal',
                            'orderCus',
                            'users.cusName',
                            'pName'
                         )
                         ->paginate(10);
        }
        else
        {
            $user = Auth::user()->id;
            $details = DB::table("OrderInfo")
                         ->leftjoin("users", "users.id", "OrderInfo.orderCus")
                         ->leftjoin("ProductInfo", "OrderInfo.orderGoods", "ProductInfo.pId")
                         ->select(
                            'orderId',
                            'orderGoods',
                            'orderUnit',
                            'orderUnitPrice',
                            'orderAmount',
                            'orderTotal',
                            'orderCus',
                            'users.cusName',
                            'pName'
                         )
                         ->where('OrderInfo.orderCus', $user)
                     ->paginate(10);
        }
        return view('functions.order_details', compact('details','products'));
    }
}
