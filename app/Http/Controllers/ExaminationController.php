<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Examination;
use App\Course;

class ExaminationController extends Controller
{
    public function all()
    {
    	$examinations = Examination::all();
    
    	return response()->json([
    		"examinations" => $examinations
    	], 200);
    }

    public function listing()
    {
        $examinations = Examination::with('course')->paginate(4);
    
        return response()->json([
            "examinations" => $examinations
        ], 200);
    }

    public function get($id)
    {
    	$examination = Examination::where('id',$id)->first();

      	return response()->json([
    		"examination" => $examination
    	], 200);
    }

    public function getByCourse($id)
    {
        $random = rand(0, 3);   

        switch($random){
            case 0: 
                $examinations = Examination::where('course_id',$id)->get();
                break;
            case 1: 
                $examinations = Examination::where('course_id',$id)->orderBy('created_at', 'DESC')->get();
                break;  
            case 2: 
                $examinations = Examination::where('course_id',$id)->orderBy('choice_1', 'DESC')->get();
                break; 
            case 3: 
                $examinations = Examination::where('course_id',$id)->orderBy('choice_2', 'DESC')->get();
                break; 
            default: 
                $examinations = Examination::where('course_id',$id)->orderBy('choice_3', 'DESC')->get();
                break;
        }


        return response()->json([
            "examinations" => $examinations
        ], 200);
    }

    public function new(Request $request)
    {
    	$examination = Examination::create($request->only(["question","choice_1","choice_2", "choice_3","choice_4","answer","course_id"]));

    	return response()->json([
    		"examination" => $examination
    	], 200);
    }

    public function update($id, Request $request)
    {

        $examination = Examination::find($id);

        $examination->update($request->all());

        return response()->json([
                'examination' => $examination
        ], 200);

    }

    public function delete($id) 
    {
        $examination = Examination::find($id)->delete();

        $courses = Course::all();

        return response()->json([
            'message' => 'Examination deleted successfully!',
            'courses' => $courses
        ]);
    }
}
