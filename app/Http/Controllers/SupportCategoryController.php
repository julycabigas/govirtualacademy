<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupportCategory;

class SupportCategoryController extends Controller
{
    // Get All support and paginate          
    public function all() {
        $supports = SupportCategory::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "supports" => $supports
          ], 200);
    }


    // Get All supports           
    public function list() {
        $supports = SupportCategory::orderBy('id', 'desc')->get();
      
          return response()->json([
              "support" => $supports
          ], 200);
    }

    // Get All supports & data          
    public function listSupports() {
        $supports = SupportCategory::with('support')->orderBy('id', 'desc')->get();
      
          return response()->json([
              "supports" => $supports
          ], 200);
    }


    //Get the support
    public function get($id) {
        $support = SupportCategory::find($id);
      
          return response()->json([
              "support" => $support
          ], 200);
    }



    // Add new support
    public function new(Request $request)
    {
        $input = $request->support;

        $support = new SupportCategory;
        $support->name = strip_tags($input['name']);
        $support->save();

        
        return response()->json([
        "support" => $support,

        ], 200);
    }
    
    //Update support
    public function update($id, Request $request)
    {
            $support = SupportCategory::find($id);
            $input = $request->support;

            $support->name = strip_tags($input['name']);
            $support->save();

            return response()->json([
                    'support' => $support,
    
            ], 200);

    }

    //Delete support
    public function delete($id) 
    {
        $support = SupportCategory::find($id)->delete();


        return response()->json([
            'message' => 'Support Category has been deleted successfully!'
        ]);
    }
}
