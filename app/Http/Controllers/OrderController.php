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
                $orderId = DB::table("OrderInfo")->max("orderId");
                if ($orderId == null) 
                    $orderId = 100000;
                else
                    $orderId += 1;
                $id = DB::table('OrderInfo')
                        ->insertGetId([ 
                            "orderId" => $orderId,
                            "orderGoods" => $request->input("product_name"),
                            "orderUnit" => $good[0]->pUnit,
                            "orderUnitPrice" => $good[0]->pPrice,
                            "orderAmount" => $request->input("qty"),
                            "orderTotal" => $request->input("price"),
                            "orderCus" => $request->input("customer")
                          ]
                        );
                $dId = DB::table("DeliveryDetails")->max("dId");
                if ($dId == null)
                    $dId = 800000;
                else
                    $dId += 1; 
                DB::table("DeliveryDetails")
                  ->insert([
                      "dId" => $dId,
                      "dOrderId" => $id,
                      "dStatus" => "確認訂單中",
                  ]);
                $msg = "Success";
            }     
        }
        $products = DB::table("ProductInfo")
                          ->get();     
        return view('functions.order', compact("products", "msg"));
    }
}
