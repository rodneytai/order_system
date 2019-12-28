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
            // if ($request->has("save")) 
            // {
            //     if ($request->input("edit_amount")) 
            //     {
            //         DB::table("OrderInfo")
            //           ->where("orderId", key($request->input("save")))
            //           ->update([
            //                 "orderGoods" => $request->input("pName"),
            //                 "orderUnit" => $request->input("unit"),
            //                 "orderUnitPrice" => $request->input("unitprice"),
            //                 "orderAmount" => $request->input("edit_amount"),
            //                 "orderTotal" => $request->input("price")
            //           ]);
            //     }
            // }
            // if ($request->has("delete")) 
            // {
            //     DB::table("OrderInfo")
            //       ->where("orderId", key($request->input("delete")))
            //       ->delete();
            //     DB::table("DeliveryDetails")
            //       ->where("dOrderId", key($request->input("delete")))
            //       ->delete();
            // }
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
    public function edit($id)
    {
        if (Auth::user()->auth == "admin") 
        {
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
                         ->where("orderId", $id)
                         ->get();
        }
        return response()->json($details);
    }
    public function save(Request $request)
    {
        # code...
        $auth = false;
        if (Auth::user()->auth == "admin")
            $auth = true;
        if (Auth::user()->auth == "admin") {
            DB::table("OrderInfo")
              ->where("orderId", $request->dId)
              ->update([
                    "orderGoods" => $request->pName,
                    "orderUnit" => $request->edit_unit,
                    "orderUnitPrice" => $request->edit_unitPrice,
                    "orderAmount" => $request->edit_amount,
                    "orderTotal" => $request->price
              ]);
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
                         ->where("orderId", $request->dId)
                         ->get();
        }
        return response()->json([
            "auth" => $auth,
            "details" => $details
        ]);

    }
    public function delete($id)
    {
        if (Auth::user()->auth == "admin") 
        {
            DB::table("DeliveryDetails")
              ->where("dOrderId", $id)
              ->delete();
            DB::table("OrderInfo")
              ->where("orderId", $id)
              ->delete();
            
            return response()->json([
                "msg" => "success"
            ]);
        }
    }
}
