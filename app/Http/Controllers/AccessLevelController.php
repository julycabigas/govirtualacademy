<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccessLevel;

class AccessLevelController extends Controller
{
    public function all()
    {
    	$accesslevels = AccessLevel::paginate(10);
    
    	return response()->json([
    		"access_levels" => $accesslevels
    	], 200);
    }


    public function allList()
    {
        $accesslevels = AccessLevel::where('type', 'bundle')->get();
    
        return response()->json([
            "access_levels" => $accesslevels
        ], 200);
    }

    public function new(Request $request)
    {

        
        if( $request->get('image') ) {

                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
                
        }

    
        $input    = $request->access; 

        $access_level = new AccessLevel;
        $access_level->name = strip_tags($input['name']);
        $access_level->display_name = strip_tags($input['display_name']);
        $access_level->reg_price = strip_tags($input['reg_price']);
        $access_level->discount_price = strip_tags($input['discount_price']);
        $access_level->short_description = strip_tags($input['short_description']);
        $access_level->description = strip_tags($input['description']);
        $access_level->type = strip_tags($input['type']);
        if( $request->get('image') ) {
            $access_level->image = $name;
        }
        $access_level->save();


    	return response()->json([
    		"access_levels" => $access_level,
            "message" => "New access level has been added successfully"
    	], 200);
    }


    public function get($id)
    {
    	$access_level = AccessLevel::where('id',$id)->first();

      	return response()->json([
    		"access_level" => $access_level
    	], 200);
    }

	public function update($id, Request $request)
    {


        if( $request->get('image') ) {

                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
                
        } 

        $input    = $request->access;   

        $access_level = AccessLevel::find($id);
        $access_level->name = strip_tags($input['name']);
        $access_level->display_name = strip_tags($input['display_name']);
        $access_level->reg_price = strip_tags($input['reg_price']);
        $access_level->discount_price = strip_tags($input['discount_price']);
        $access_level->short_description = strip_tags($input['short_description']);
        $access_level->description = strip_tags($input['description']);
        $access_level->type = strip_tags($input['type']);
        if( $request->get('image') ) {
            $access_level->image = $name;
        }
        $access_level->save();


        return response()->json([
                'access_level' => $access_level
        ], 200);
    }

}
