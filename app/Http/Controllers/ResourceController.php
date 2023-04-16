<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;

class ResourceController extends Controller
{
    // Get All resource and paginate          
    public function all() {
        $resources = Resource::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "resources" => $resources
          ], 200);
    }


    // Get All resources           
    public function list() {
        $resources = Resource::orderBy('id', 'desc')->get();
      
          return response()->json([
              "resource" => $resources
          ], 200);
    }



    //Get the resource
    public function get($id) {
        $resource = Resource::find($id);
      
          return response()->json([
              "resource" => $resource
          ], 200);
    }

      

    // Add new resource
    public function new(Request $request)
    {
        $input = $request->resource;

        $resource = new Resource;
        $resource->name = strip_tags($input['name']);
        $resource->description = $input['description'];
        $resource->category_id = $input['category_id'];
        $resource->save();

        
        return response()->json([
        "resource" => $resource,

        ], 200);
    }
    
    //Update resource
    public function update($id, Request $request)
    {
            $resource = Resource::find($id);
            $input = $request->resource;

            $resource->name = strip_tags($input['name']);
            $resource->description = $input['description'];
            $resource->category_id = $input['category_id'];
            $resource->save();

            return response()->json([
                    'resource' => $resource,
    
            ], 200);

    }

    //Delete resource
    public function delete($id) 
    {
        $resource = Resource::find($id)->delete();


        return response()->json([
            'message' => 'Resource has been deleted successfully!'
        ]);
    }
}
