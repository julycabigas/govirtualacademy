<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webinar;

class WebinarController extends Controller
{
    // Get All resource and paginate          
    public function all() {
        $webinars = Webinar::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "webinars" => $webinars
          ], 200);
    }


    // Get All webinars           
    public function list() {
        $webinars = Webinar::orderBy('id', 'desc')->get();
      
          return response()->json([
              "webinars" => $webinars
          ], 200);
    }



    //Get the resource
    public function get($id) {
        $webinar = Webinar::find($id);
      
          return response()->json([
              "webinar" => $webinar
          ], 200);
    }

      

    // Add new resource
    public function new(Request $request)
    {
        $input = $request->webinar;

        if( $request->get('image') ) {
            // Upload and Save File
            $image = $request->get('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('image'))->save(public_path('images/').$name);
            
        } 

        $webinar = new webinar;
        $webinar->name = $input['name'];
        $webinar->description = $input['description'];
        $webinar->image_url = $name;
        $webinar->host = $input['host'];
        $webinar->date = $input['date'];
        $webinar->time = $input['time'];
        $webinar->save();

        
        return response()->json([
        "webinar" => $webinar,

        ], 200);
    }
    
    //Update resource
    public function update($id, Request $request)
    {
            $webinar = Webinar::find($id);
            $input = $request->webinar;

            if( $request->get('image') ) {
                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
                
            } 
            
            if( $request->get('image')) {
                $webinar->update([
                    'name' => strip_tags($input['name']),
                    'description' => strip_tags($input['description']),
                    'host' => strip_tags($input['host']),
                    'date' => strip_tags($input['date']),
                    'time' => strip_tags($input['time']),
                    'image_url' => $name,
                    'video' => strip_tags($input['video'])
              ]);

            } else {

                $webinar->update([
                    'name' => strip_tags($input['name']),
                    'description' => strip_tags($input['description']),
                    'host' => strip_tags($input['host']),
                    'date' => strip_tags($input['date']),
                    'time' => strip_tags($input['time']),
                    'image_url' => strip_tags($input['image_url']),
                    'video' => strip_tags($input['video'])
              ]);
            }



            return response()->json([
                    'webinar' => $webinar,
    
            ], 200);

    }

    //Delete resource
    public function delete($id) 
    {
        $webinar = Webinar::find($id)->delete();


        return response()->json([
            'message' => 'Webinar has been deleted successfully!'
        ]);
    }
}
