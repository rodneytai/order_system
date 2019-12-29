<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ContactController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('functions.contact');
    }
    public function contact(Request $request)
    {
        $msg = "";
        if($request->cName != "" && ($request->cEmail !="" || $request->cPhone != ""))
        {
            $id = DB::table("Contact")->max("id")+1;
            DB::table("Contact")
              ->insert([
                    "id" => $id,
                    "cName" => $request->cName,
                    "cEmail" => $request->cEmail,
                    "cPhone" => $request->cPhone,
                    "cDis" => $request->cDis,
                    "cCheck" => "未聯絡"
              ]);
            $msg = "我們會盡快聯絡您！";
        }
        else
        {
            if($request->cName == "")
                $msg = "請輸入姓名";
            else if($request->cEmail == "" && $request->cPhone == "")
                $msg = "請提供聯絡方式";
        }
        return response()->json([
            "msg" => $msg
        ]);
    }
}
