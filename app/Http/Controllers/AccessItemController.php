<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccessItem;
use App\Training;
use DB;

class AccessItemController extends Controller
{

    public function get($id)
    {
    	$access= AccessItem::where('user_id',$id)->get();

      	return response()->json([
    		"access" => $access
    	], 200);
    }


    public function checkUserPurchased($id, Request $request)
    {
        $has_purchased = false;

        //Check User Access by user id
        $userAccess = AccessItem::where('user_id',$id)->get();

        //Check Course Access by course id
        $courseAccess = Training::where('course_id', $request->course_id)->get();
        

        //Evaluate access
        foreach( $userAccess as $userItem ) {

            $access =  $userItem['access_id'];

            foreach( $courseAccess as $courseItem ) {

                if($courseItem['access_id'] == $access) {
                    $has_purchased = true;
                    break;
                }
            }
        }
        

        return response()->json([
            "hasPurchased" => $has_purchased
        ], 200);
    }


    public function checkPurchasedBundle($id, Request $request)
    {
        $has_purchased = false;

        //Check User Access by user id
        $userAccess = AccessItem::where('user_id',$id)->get();


        //Evaluate access
        if(count($userAccess) > 0) {
            $has_purchased = true;
        }


        return response()->json([
            "hasPurchased" => $has_purchased
        ], 200);
    }


	public function update($id, Request $request)
    {
            $roles = $request->role;  
          
            if( $roles ) {
	          $delete_roles = DB::table('access_items')->where('user_id', '=',$id)->delete();

	          for($a = 0; $a < count($roles); $a++) {

	             $access = new AccessItem;
	             $access->user_id = $id;
	             $access->access_id = $roles[$a];
	             $access->save();
	          }
      	    }

            return response()->json([
                    'roles' => count($roles),
                    'id' => $id
            ], 200);
    }


}
