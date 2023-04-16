<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseGroupIdentifier;

class CourseGroupController extends Controller
{
    public function all()
    {
        $courseIdentifiers = CourseGroupIdentifier::with('identifier', 'course')
            ->orderBy('menu_order', 'desc')->paginate(20);

    	return response()->json([
    		"groups" => $courseIdentifiers
    	], 200);
    }

    public function get($id) {
            
      $group = CourseGroupIdentifier::where('id',$id)->first();

      return response()->json([
        "group" => $group
      ], 200);
    
    }


    public function update($id,Request $request)
    {
        $course = CourseGroupIdentifier::find($id);

        $input = $request->group;


        $course->update([
                'menu_order' => $input['menu_order'],
                'course_identifers_id' => $input['course_identifiers_id'],
                'course_id' => $input['course_id'],
                'module_id' => $input['module_id'],
                'status' => $input['status']
        ]);

        return response()->json([
            "course" => $course,
            "input" => $input
        ], 200);

    }


    //Delete
    public function delete($id) 
    {
        $course = CourseGroupIdentifier::find($id)->delete();


        return response()->json([
            'message' => 'Course group has been deleted successfully!'
        ]);
    }
}
