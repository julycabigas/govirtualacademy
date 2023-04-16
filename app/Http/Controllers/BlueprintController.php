<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blueprint;

class BlueprintController extends Controller
{
    // Get All blueprint and paginate          
    public function all() {
        $blueprints = Blueprint::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "blueprints" => $blueprints
          ], 200);
    }


    // Get All blueprints           
    public function list() {
        $blueprints = Blueprint::orderBy('id', 'desc')->get();
      
          return response()->json([
              "blueprints" => $blueprints
          ], 200);
    }



    //Get the blueprint
    public function get($id) {
        $blueprint = Blueprint::find($id);
      
          return response()->json([
              "blueprint" => $blueprint
          ], 200);
    }

    //Get the blueprint by category
    public function getByCategory($id) {
        $blueprints = Blueprint::where('category_id',$id)->get();
      
          return response()->json([
              "blueprints" => $blueprints
          ], 200);
    }  

    // Add new blueprint
    public function new(Request $request)
    {
        $input = $request->blueprint;

        if( $request->get('image') ) {

            // Upload and Save File
            $image = $request->get('image');
            $img_name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('image'))->save(public_path('images/blueprint/').$img_name);
            
        } 

        if(  $request->get('image') ) {

            $blueprint = new Blueprint;
            $blueprint->title = strip_tags($input['title']);
            $blueprint->description = $input['description'];
            $blueprint->video = $input['video'];
            $blueprint->image = $img_name;
            $blueprint->solution = $input['solution'];
            $blueprint->category_id = $input['category_id'];
            $blueprint->save();

        } 
        else {
            $blueprint = new Blueprint;
            $blueprint->title = strip_tags($input['title']);
            $blueprint->description = $input['description'];
            $blueprint->video = $input['video'];
            $blueprint->image = "";
            $blueprint->solution = $input['solution'];
            $blueprint->category_id = $input['category_id'];
            $blueprint->save();
        }

        
        return response()->json([
        "blueprint" => $blueprint,

        ], 200);
    }
    
    //Update blueprint
    public function update($id, Request $request)
    {
            $blueprint = Blueprint::find($id);
            $input = $request->blueprint;


            if( $request->get('image') ) {

                // Upload and Save File
                $image = $request->get('image');
                $img_name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/blueprint/').$img_name);
                
            } 
    
            if(  $request->get('image') ) {
    
            
                $blueprint->title = strip_tags($input['title']);
                $blueprint->description = $input['description'];
                $blueprint->video = $input['video'];
                $blueprint->image = $img_name;
                $blueprint->solution = $input['solution'];
                $blueprint->category_id = $input['category_id'];
                $blueprint->save();
    
            } 
            else {
           
                $blueprint->title = strip_tags($input['title']);
                $blueprint->description = $input['description'];
                $blueprint->video = $input['video'];
                $blueprint->image = "";
                $blueprint->solution = $input['solution'];
                $blueprint->category_id = $input['category_id'];
                $blueprint->save();
            }



            return response()->json([
                    'blueprint' => $blueprint,
    
            ], 200);

    }

    //Delete blueprint
    public function delete($id) 
    {
        $blueprint = Blueprint::find($id)->delete();


        return response()->json([
            'message' => 'Blueprint has been deleted successfully!'
        ]);
    }
}
