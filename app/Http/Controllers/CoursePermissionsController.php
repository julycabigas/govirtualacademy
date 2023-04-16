<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoursePermission;
use App\User;
use App\Training;
use DB;

class CoursePermissionsController extends Controller
{
    /**
     * Unused - to be deleted
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function courseRoles($id)
    {
        $roles = CoursePermission::where('course_id', $id)->get();

        return response()->json([
            'roles' => $roles
        ], 200);
    }



	  /**
	   *  @param $id course id
	  */
    public function getPermission($course_id, Request $request) {
      $user_id = $request->user_id;

      $access_id = DB::table('trainings')
                      ->where( 'course_id', $course_id )
                      ->value('access_id');

    	$role = DB::table('access_items')
                    ->where('user_id', $user_id)
                    ->where(function($query) use ($access_id )  {
                        $query
                          ->where('access_id', '=', $access_id);
                    })
                    ->get();

    	if(count($role) > 0) {
    		$hasPermission = true;
    	} 
      elseif(!count($role) > 0 && $access_id == 7) {
        $hasPermission = true;
      }
    	else {
    		$hasPermission = false;
    	} 

    	return response()->json([
    				'has_permission' => $hasPermission,
            'role' => $role
    		], 200);
    }

    public function new(Request $request)
    {
          $roles     = $request->role;  
          $id = $request->course_id; 


          for($a = 0; $a < count($roles); $a++) {

             $permission = new Training;
             $permission->course_id = $id;
             $permission->access_id = $roles[$a];
             $permission->save();
          }

          return response()->json([
                    'roles' => count($roles),
                    'id' => $id
            ], 200);

    }


    public function update($id, Request $request)
    {
          $roles = $request->role;  

          //$delete_roles = DB::table('course_permissions')->where('course_id', '=',$id)->delete();
          
          $delete_roles = DB::table('trainings')->where('course_id', '=',$id)->delete();

          for($a = 0; $a < count($roles); $a++) {

             $permission = new Training;
             $permission->course_id = $id;
             $permission->access_id = $roles[$a];
             $permission->save();
          }

          return response()->json([
                    'roles' => count($roles),
                    'id' => $id
            ], 200);

    }
}
