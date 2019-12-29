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
        // if ($request->has("order")) 
        // {
        //     $messages = [
        //         'qty.required'    => 'Please enter quantity',
        //     ];
        //     $validator = Validator::make($request->all(), [
        //         'product_name' => 'required',
        //         'qty' => 'required',
        //     ], $messages);
        //     if ($validator->fails()) {
        //         return redirect('/order')
        //                     ->withErrors($validator);
        //     }
        //     else
        //     {
        //         $good = DB::table("ProductInfo")
        //                   ->where("pId", $request->input("product_name"))
        //                   ->get();
        //         $orderId = DB::table("OrderInfo")->max("orderId");
        //         if ($orderId == null) 
        //             $orderId = 100000;
        //         else
        //             $orderId += 1;
        //         if (env("DB_CONNECTION") == 'sqlsrv')
        //             DB::unprepared('SET IDENTITY_INSERT OrderInfo ON');
        //         $id = DB::table('OrderInfo')
        //                 ->insertGetId([ 
        //                     "orderId" => $orderId,
        //                     "orderGoods" => $request->input("product_name"),
        //                     "orderUnit" => $good[0]->pUnit,
        //                     "orderUnitPrice" => $good[0]->pPrice,
        //                     "orderAmount" => $request->input("qty"),
        //                     "orderTotal" => $request->input("price"),
        //                     "orderCus" => $request->input("customer")
        //                   ]
        //                 );
        //         if (env("DB_CONNECTION") == 'sqlsrv')
        //             DB::unprepared('SET IDENTITY_INSERT OrderInfo OFF');
        //         $dId = DB::table("DeliveryDetails")->max("dId");
        //         if ($dId == null)
        //             $dId = 800000;
        //         else
        //             $dId += 1; 
        //         if (env("DB_CONNECTION") == 'sqlsrv')
        //             DB::unprepared('SET IDENTITY_INSERT DeliveryDetails ON');
        //         DB::table("DeliveryDetails")
        //           ->insert([
        //               "dId" => $dId,
        //               "dOrderId" => $id,
        //               "dStatus" => "確認訂單中",
        //           ]);
        //         if (env("DB_CONNECTION") == 'sqlsrv')
        //             DB::unprepared('SET IDENTITY_INSERT DeliveryDetails OFF');
        //         $msg = "Success";
        //     }     
        // }
        $products = DB::table("ProductInfo")
                      ->get();     
        return view('functions.order', compact("products", "msg"));
    }
    //order
    public function order(Request $request)
    {
        if ($request) 
        {
            $messages = [
                'qty.required'    => 'Please enter quantity',
            ];
            $validator = Validator::make($request->all(), [
                'product_name' => 'required',
                'qty' => 'required',
            ], $messages);
            $msg = "";
            if ($validator->fails()) {
                $msg = "請輸入數量";
                return response()->json([
                    "msg" => $msg
                ]);
            }
            else
            {
                $good = DB::table("ProductInfo")
                          ->where("pId", $request->product_name)
                          ->get();
                $orderId = DB::table("OrderInfo")->max("orderId");
                if ($orderId == null) 
                    $orderId = 100000;
                else
                    $orderId += 1;
                if (env("DB_CONNECTION") == 'sqlsrv')
                    DB::unprepared('SET IDENTITY_INSERT OrderInfo ON');
                $id = DB::table('OrderInfo')
                        ->insertGetId([ 
                            "orderId" => $orderId,
                            "orderGoods" => $request->product_name,
                            "orderUnit" => $good[0]->pUnit,
                            "orderUnitPrice" => $good[0]->pPrice,
                            "orderAmount" => $request->qty,
                            "orderTotal" => $request->price,
                            "orderCus" => $request->customer
                          ]
                        );
                if (env("DB_CONNECTION") == 'sqlsrv')
                    DB::unprepared('SET IDENTITY_INSERT OrderInfo OFF');
                $dId = DB::table("DeliveryDetails")->max("dId");
                if ($dId == null)
                    $dId = 800000;
                else
                    $dId += 1; 
                if (env("DB_CONNECTION") == 'sqlsrv')
                    DB::unprepared('SET IDENTITY_INSERT DeliveryDetails ON');
                DB::table("DeliveryDetails")
                  ->insert([
                      "dId" => $dId,
                      "dOrderId" => $id,
                      "dStatus" => "確認訂單中",
                  ]);
                if (env("DB_CONNECTION") == 'sqlsrv')
                    DB::unprepared('SET IDENTITY_INSERT DeliveryDetails OFF');
                $msg = "成功下訂單";
                return response()->json([
                    "msg" => $msg
                ]);
            }     
        }
    }
}
