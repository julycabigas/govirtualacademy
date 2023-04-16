<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResourceCategory;

class ResourceCategoryController extends Controller
{
    // Get All resource and paginate          
    public function all() {
        $resources = ResourceCategory::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "resources" => $resources
          ], 200);
    }


    // Get All resources           
    public function list() {
        $resources = ResourceCategory::orderBy('id', 'desc')->get();
      
          return response()->json([
              "resource" => $resources
          ], 200);
    }

    // Get All resources & data          
    public function listResources() {
        $resources = ResourceCategory::with('resource')->orderBy('id', 'desc')->get();
      
          return response()->json([
              "resources" => $resources
          ], 200);
    }


    //Get the resource
    public function get($id) {
        $resource = ResourceCategory::find($id);
      
          return response()->json([
              "resource" => $resource
          ], 200);
    }

      

    // Add new resource
    public function new(Request $request)
    {
        $input = $request->resource;

        $resource = new ResourceCategory;
        $resource->name = strip_tags($input['name']);
        $resource->save();

        
        return response()->json([
        "resource" => $resource,

        ], 200);
    }
    
    //Update resource
    public function update($id, Request $request)
    {
            $resource = ResourceCategory::find($id);
            $input = $request->resource;

            $resource->name = strip_tags($input['name']);
            $resource->save();

            return response()->json([
                    'resource' => $resource,
    
            ], 200);

    }

    //Delete resource
    public function delete($id) 
    {
        $resource = ResourceCategory::find($id)->delete();


        return response()->json([
            'message' => 'Resource Category has been deleted successfully!'
        ]);
    }
}
