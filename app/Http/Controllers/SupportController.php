<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support;

class SupportController extends Controller
{
    // Get All support and paginate          
    public function all() {
        $supports = Support::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "supports" => $supports
          ], 200);
    }


    // Get All supports           
    public function list() {
        $supports = Support::orderBy('id', 'desc')->get();
      
          return response()->json([
              "supports" => $supports
          ], 200);
    }



    //Get the support
    public function get($id) {
        $support = Support::find($id);
      
          return response()->json([
              "support" => $support
          ], 200);
    }

    //Get the support by category
    public function getByCategory($id) {
        $supports = Support::where('category_id',$id)->get();
      
          return response()->json([
              "supports" => $supports
          ], 200);
    }  

    // Add new support
    public function new(Request $request)
    {
        $input = $request->support;

        $support = new Support;
        $support->title = strip_tags($input['title']);
        $support->description = $input['description'];
        $support->video = $input['video'];
        $support->image = $input['image'];
        $support->solution = $input['solution'];
        $support->category_id = $input['category_id'];
        $support->save();

        
        return response()->json([
        "support" => $support,

        ], 200);
    }
    
    //Update support
    public function update($id, Request $request)
    {
            $support = Support::find($id);
            $input = $request->support;

            $support->title = strip_tags($input['title']);
            $support->description = $input['description'];
            $support->video = $input['video'];
            $support->image = $input['image'];
            $support->solution = $input['solution'];
            $support->category_id = $input['category_id'];
            $support->save();

            return response()->json([
                    'support' => $support,
    
            ], 200);

    }

    //Delete support
    public function delete($id) 
    {
        $support = Support::find($id)->delete();


        return response()->json([
            'message' => 'Support has been deleted successfully!'
        ]);
    }
}
