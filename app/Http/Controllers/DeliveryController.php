<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DeliveryController extends Controller
{
    //
    public function index(Request $request)
    {
        if (Auth::user()->auth == "admin") 
        {
            
            // if ($request->has("save")) 
            // {
            //     if ($request->input("dTime") == null) 
            //         $dTime = null;
            //     else
            //         $dTime = date('Y-m-d', strtotime($request->input("dTime")));
            //     if ($request->input("dArriveTime") == null) 
            //         $dArriveTime = null;
            //     else
            //         $dArriveTime = date('Y-m-d', strtotime($request->input("dArriveTime")));
            //     DB::table("DeliveryDetails")
            //       ->where("dId", key($request->input("save")) )
            //       ->update([
            //           "dStatus" => $request->input("status"),
            //           "dTime" => $dTime,
            //           "dArriveTime" => $dArriveTime,
            //       ]);
            // }
            $delivery = DB::table("DeliveryDetails")
                          ->paginate(10);
        }
        else
        {
            $user = Auth::user()->id;
            $order = DB::table("OrderInfo")
                       ->where("orderCus", $user)
                       ->pluck("orderId");
            $delivery = DB::table("DeliveryDetails")
                          ->whereIn('dOrderId', $order)
                          ->paginate(10);
        }
        return view("functions.delivery", compact("delivery"));
    }
    public function edit($id)
    {
        if (Auth::user()->auth == "admin") 
        {
            $delivery = DB::table("DeliveryDetails")
                          ->where("dId", $id)
                          ->get();
            return response()->json($delivery);
        }
    }
    public function save(Request $request)
    {
        if (Auth::user()->auth == "admin") 
        {
            $auth = true;
            if ($request->input("dTime") == null) 
                    $dTime = null;
            else
                $dTime = date('Y-m-d', strtotime($request->dTime));
            if ($request->input("dArriveTime") == null) 
                $dArriveTime = null;
            else
                $dArriveTime = date('Y-m-d', strtotime($request->dArriveTime));
            DB::table("DeliveryDetails")
              ->where("dId", $request->dId )
              ->update([
                  "dStatus" => $request->status,
                  "dTime" => $dTime,
                  "dArriveTime" => $dArriveTime,
              ]);
            $delivery = DB::table("DeliveryDetails")
                          ->where("dId", $request->dId)
                          ->get();
            return response()->json([
                "auth" => $auth,
                "delivery" => $delivery
            ]);
        }
    }
    public function search(Request $request)
    {
        if (Auth::user()->auth == "admin") 
        {
            $auth = true;
            $delivery = DB::table("DeliveryDetails")
                          ->where("dOrderId", 'LIKE', '%'.$request->text.'%')
                          ->paginate(10);
        }
        else
        {
            $auth = false;
            $user = Auth::user()->id;
            $order = DB::table("OrderInfo")
                       ->where("orderCus", $user)
                       ->pluck("orderId");
            $delivery = DB::table("DeliveryDetails")
                          ->whereIn('dOrderId', $order)
                          ->where("dOrderId", 'LIKE', '%'.$request->text.'%')
                          ->paginate(10);
        }
        return response()->json([
            "auth" => $auth,
            "delivery" => $delivery
        ]);
    }
}
