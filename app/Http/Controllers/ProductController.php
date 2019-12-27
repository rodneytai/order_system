<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductInfo as Products;
use DB;
use Auth;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        // if (Auth::user()->auth == "admin") 
        // {
        //     if ($request->has("delete")) 
        //     {
        //         $dltId = key($request->input("delete"));
        //         DB::table('ProductInfo')
        //           ->where("pId", $dltId)
        //           ->delete();
        //     }
        //     if ($request->has("save")) 
        //     {
        //         $saveId = key($request->input("save")); //ori id
        //         $pid = DB::table("ProductInfo")
        //                  ->pluck("pId")
        //                  ->toArray();
        //         if (($key = array_search($saveId, $pid)) !== false) //remove the ori Id from array
        //             unset($pid[$key]);
        //         $edit_id = $request->input("edit_id");
        //         if (!in_array($edit_id, $pid)) 
        //         {
        //             DB::table('ProductInfo')
        //               ->where("pId", $saveId)
        //               ->update([
        //                     "pId" => $request->input("edit_id"),
        //                     "pName" => $request->input("edit_name"),
        //                     "pUnit" => $request->input("edit_unit"),
        //                     "pPrice" => $request->input("edit_price"),
        //               ]);
        //         }
        //     }
        // }   
        $products = DB::table('ProductInfo')
                      ->paginate(15);
        return view('functions.products_list',
            compact('products'));
    }
    //ajax search products
    public function search(Request $request)
    {
        if (Auth::user()->auth == "admin") 
            $auth = true;
        $products = DB::table('ProductInfo')
                      ->where('pName', 'LIKE', '%'.$request->text.'%')
                      ->paginate(15)
                      ->toArray();
        return response()->json([
            "auth" => $auth,
            "products" => $products
        ]);
        
    }
    //edit pop out
    public function edit($id)
    {
        $product = DB::table("ProductInfo")
                     ->where("pId", $id)
                     ->get();
        return response()->json($product);
    }
    //save changes
    public function save(Request $request)
    {
        if (Auth::user()->auth == 'admin') 
        {
            $saveId = $request->pId; //ori id
            $pid = DB::table("ProductInfo")
                     ->pluck("pId")
                     ->toArray();
            if (($key = array_search($saveId, $pid)) !== false) //remove the ori Id from array
                unset($pid[$key]);
            $edit_id = $request->edit_id;
            if (!in_array($edit_id, $pid)) 
            {
                $q = DB::table('ProductInfo')
                       ->where("pId", $saveId)
                       ->update([
                            "pId" => $edit_id,
                            "pName" => $request->edit_name,
                            "pUnit" => $request->edit_unit,
                            "pPrice" => $request->edit_price,
                        ]);
                
            }
            $products = DB::table('ProductInfo')
                          ->where("pId", $edit_id)
                          ->get();
        }
        if (Auth::user()->auth == "admin") 
            $auth = true;
        return response()->json([
            "auth" => $auth,
            "products" => $products
        ]);
    }
    //delete
    public function delete($id)
    {
        DB::table('ProductInfo')
          ->where("pId", $id)
          ->delete();
        return response()->json([
            "msg" => "success"
        ]);
    }
}
