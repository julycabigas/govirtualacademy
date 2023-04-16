<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlueprintCategory;

class BlueprintCategoryController extends Controller
{
   // Get All blueprint and paginate          
    public function all() {
        $blueprints = BlueprintCategory::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "blueprints" => $blueprints
          ], 200);
    }


    // Get All blueprints           
    public function list() {
        $blueprints = BlueprintCategory::orderBy('id', 'desc')->get();
      
          return response()->json([
              "blueprint" => $blueprints
          ], 200);
    }

    // Get All blueprints & data          
    public function listBlueprints() {
        $blueprints = BlueprintCategory::with('blueprint')->orderBy('id', 'desc')->get();
      
          return response()->json([
              "blueprints" => $blueprints
          ], 200);
    }


    //Get the blueprint
    public function get($id) {
        $blueprint = BlueprintCategory::find($id);
      
          return response()->json([
              "blueprint" => $blueprint
          ], 200);
    }



    // Add new blueprint
    public function new(Request $request)
    {
        $input = $request->blueprint;

        $blueprint = new BlueprintCategory;
        $blueprint->name = strip_tags($input['name']);
        $blueprint->save();

        
        return response()->json([
        "blueprint" => $blueprint,

        ], 200);
    }
    
    //Update blueprint
    public function update($id, Request $request)
    {
            $blueprint = BlueprintCategory::find($id);
            $input = $request->blueprint;

            $blueprint->name = strip_tags($input['name']);
            $blueprint->save();

            return response()->json([
                    'blueprint' => $blueprint,
    
            ], 200);

    }

    //Delete blueprint
    public function delete($id) 
    {
        $blueprint = BlueprintCategory::find($id)->delete();


        return response()->json([
            'message' => 'Blueprint Category has been deleted successfully!'
        ]);
    }
}
