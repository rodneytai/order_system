<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class CheckContactController extends Controller
{
    //
    public function index(Request $request)
    {
        if (Auth::user()->auth == "admin") 
        {
            $check = DB::table("Contact")
                       ->paginate(15);
            return view('functions.checkcontact', compact("check"));
        }
    }
    public function more($id)
    {
        if (Auth::user()->auth == "admin") 
        {
            $check = DB::table("Contact")
                       ->where("id", $id)
                       ->get();
        }
        return response()->json([
            "check" => $check
        ]);
    }
    public function contact(Request $request)
    {
        $auth = false;
        if (Auth::user()->auth == "admin") 
        {
            $auth = true;
            DB::table("Contact")
              ->where("id", $request->id)
              ->update([
                    "cCheck" => "已聯絡"
              ]);
            $check = DB::table("Contact")
                       ->where("id", $request->id)
                       ->get();
        }
        return response()->json([
            "auth" => $auth,
            "check" => $check
        ]);
    }
    public function solve(Request $request)
    {
        $auth = false;
        if (Auth::user()->auth == "admin") 
        {
            $auth = true;
            DB::table("Contact")
              ->where("id", $request->id)
              ->update([
                    "cCheck" => "已解決"
              ]);
            $check = DB::table("Contact")
                       ->where("id", $request->id)
                       ->get();
        }
        return response()->json([
            "auth" => $auth,
            "check" => $check
        ]);
    }
}
