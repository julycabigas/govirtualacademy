<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\BadgeRequirement;

class BadgeRequirementController extends Controller
{
    //Get all badges by ID
    public function getBadges($id)
    {
        $badges = BadgeRequirement::where('group_identifiers_id', $id)->get();

        return response()->json([
            'badges' => $badges
        ], 200);
    }

    public function update($id, Request $request)
    {
          $badges = $request->badges;  

          //remove current badges on  the db and replace it
          $delete_badges = DB::table('badge_requirements')->where('group_identifiers_id', '=',$id)->delete();

           //new badges 
          for($a = 0; $a < count($badges); $a++) {

             $permission = new BadgeRequirement;
             $permission->badge_id = $badges[$a];
             $permission->group_identifiers_id = $id;
             $permission->save();
          }

          return response()->json([
                    'badges' => count($badges),
                    'id' => $id
            ], 200);

    }

}
