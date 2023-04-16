<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Training;
use App\AccessLevel;
use DB;

class TrainingController extends Controller
{


	 /**
     * 
     * @param  [type] $id Course ID
     * @return [type]     JSON
     */
    public function getCourseAccess($id)
    {
        $access = Training::where('course_id', $id)->get();

        return response()->json([
            'access' => $access
        ], 200);
    }

    /**
     * Get Bundle courses 
     * @param  int    $id Access ID
     * @return json       Array
     */
    public function getBundleCourse($id)
    {
        $training = AccessLevel::find($id);
        $courses = DB::table('trainings')
                        ->join('courses', 'trainings.course_id', '=', 'courses.id')
                        ->select('courses.*')
                        ->where('trainings.access_id', '=', $id)
                        ->get();

        if(count($courses) > 0) {
            $hasCourses = true;
        }  
        else {
            $hasCourses = false;
        }              

        return response()->json([
            'courses' => $courses,
            'training' => $training,
            'hasCourses' => $hasCourses
        ], 200);
    }

    
}
