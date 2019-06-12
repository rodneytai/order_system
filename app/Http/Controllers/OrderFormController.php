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
        $isAdmin = Auth::user()->auth;
        if ($isAdmin == 'admin') 
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
        return view('functions.order_details', compact('details'));
    }
}
