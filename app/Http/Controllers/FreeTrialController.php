<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FreeTrial;

class FreeTrialController extends Controller
{
    public function update($id, Request $request) {
        
        $course_id = $request->course_id;

        $trial = FreeTrial::
                    where('user_id', $id)
                    // ->where(function($query) use ($course_id) {
                    //     $query->where('group_id', '=', $course_id);
                    // })
                    ->value('step_limit');
  

        return response()->json([
          "trial" => $trial
        ], 200);
      
    }
}
