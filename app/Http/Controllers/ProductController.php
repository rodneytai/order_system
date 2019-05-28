<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductInfo as Products;
use DB;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->has("delete")) 
        {
            $dltId = key($request->input("delete"));
            DB::table('ProductInfo')
              ->where("pId", $dltId)
              ->delete();
        }
        if ($request->has("save")) 
        {
            $saveId = key($request->input("save")); //ori id
            $pid = DB::table("ProductInfo")
                     ->pluck("pId")
                     ->toArray();
            if (($key = array_search($saveId, $pid)) !== false) //remove the ori Id from array
                unset($pid[$key]);
            $edit_id = $request->input("edit_id");
            if (!in_array($edit_id, $pid)) 
            {
                DB::table('ProductInfo')
                  ->where("pId", $saveId)
                  ->update([
                        "pId" => $request->input("edit_id"),
                        "pName" => $request->input("edit_name"),
                        "pUnit" => $request->input("edit_unit"),
                        "pPrice" => $request->input("edit_price"),
                  ]);
            }
        }
        $products = DB::table('ProductInfo')
                      ->paginate(15);
        return view('functions.products_list',
            compact('products'));
    }
}
