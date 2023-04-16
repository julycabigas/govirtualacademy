<?php

namespace App\Http\Controllers;
use App\Badge;

use Illuminate\Http\Request;

class BadgeController extends Controller
{
    // Get All Badges           
    public function all() {
        $badges = Badge::orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "badges" => $badges
          ], 200);
    }


    // Get All Badges           
    public function list() {
        $badges = Badge::all();
      
          return response()->json([
              "badges" => $badges
          ], 200);
    }

    //Get a badge
    public function get($id) {
        $badge = Badge::find($id);
      
          return response()->json([
              "badge" => $badge
          ], 200);
    }

      

    // Add new badge
    public function new(Request $request)
    {


        $input = $request->badge;

        $badge = new Badge;
        $badge->name = $input['name'];
        $badge->description = $input['description'];
        $badge->save();

        
        return response()->json([
        "badge" => $badge,

        ], 200);
    }
    

    //Update badge
    public function update($id, Request $request)
    {
        $badge = Badge::find($id);
        $input = $request->badge;

        $badge->name = $input['name'];
        $badge->description = $input['description'];
        $badge->save();

        return response()->json([
                'badge' => $badge,

        ], 200);

    }

    //Delete badge
    public function delete($id) 
    {
        $badge = Badge::find($id)->delete();


        return response()->json([
            'message' => 'badge group deleted successfully!'
        ]);
    }


}
