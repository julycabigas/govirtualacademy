<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentBadges;

class StudentBadgesController extends Controller
{
    // Get All Student's Badges           
    public function all() {
        $badges = StudentBadges::with('users','badges')->orderBy('id', 'desc')->paginate(10);
      
          return response()->json([
              "badges" => $badges
          ], 200);
    }


    // Add new student badge
    public function new(Request $request)
    {

        $badgeID = $request->badgeID;
        $studentID = $request->studentID;
        $star = $request->star;

        $badge = new StudentBadges;
        $badge->badge_id = $badgeID;
        $badge->student_id = $studentID;
        $badge->total_star = $star;
        $badge->save();

        
        return response()->json([
            "badge" => $badge,
            "status" => true
        ], 200);
    }

    //Get badge
    public function get($id) {
        $badge = StudentBadges::find($id);
      
          return response()->json([
              "badge" => $badge
          ], 200);
    }

    //Delete badge
    public function delete($id) 
    {
        $badge = StudentBadges::find($id)->delete();


        return response()->json([
            'message' => 'Badge group deleted successfully!'
        ]);
    }

}
