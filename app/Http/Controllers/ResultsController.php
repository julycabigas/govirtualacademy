<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Result;
use App\Course;
use DB;
use Carbon;

class ResultsController extends Controller
{
    public function all()
    {
    	$retuls = Result::all();
    
    	return response()->json([
    		"results" => $results
    	], 200);
    }


    public function get($id)
    {
    	$result = Result::where('id', $id)->first();

      	return response()->json([
    		"result" => $result
    	], 200);
    }

    /**
     * Get all exams of the students
     * @param  int   $id    User ID
     * @return Array Json 
     */
    public function StudentExamResults($id)
    {


        $results = DB::table('results')
                    ->leftJoin('courses', 'results.course_id', '=', 'courses.id')
                    ->select('results.score','results.has_passed','courses.title', 'results.created_at')
                    ->where('results.user_id', $id)
                    //->where('results.created_at','<=', Carbon::subWeekdays(2))
                    ->get();

        return response()->json([
            "results" => $results
        ], 200);
    }

    /**
     * Check failed exam
     * @param  int   $id    User ID
     * @return Array Json 
     */
    public function checkFailedResults($id, Request $request)
    {
        $failed_count = DB::table('results')
                       ->where('user_id', $request->user_id)
                       ->where(function($query) use ($id) {
                            $query
                                ->where('course_id',  $id);
                       })
                       ->where('has_resolve', '=', 1)
                       ->get();
        $result = DB::table('results')
                       ->where('user_id', $request->user_id)
                       ->where(function($query) use ($id) {
                            $query
                                ->where('course_id',  $id);
                       })
                       ->first(); 

                      
         $dateTaken = ( $result )  ? strtotime($result->created_at): '';    
         $weekAfter = ( $dateTaken )  ? strtotime("+7 day", $dateTaken): '';  
         $today = strtotime("now");


         $canTake = ( $weekAfter  && ( $today >= $weekAfter ) ) ? true : false;                   

        $exams = DB::table('examinations')
                          ->where('course_id', $id)       
                          ->get();                            
              

        return response()->json([
            "failed_count" => count($failed_count),
            "result" => $result,
            "lastTaken" => $dateTaken,
            "1 week" => $weekAfter,
            "can_take" => $canTake,
            "exam_count" => count($exams),
            "id" => $id
        ], 200);
    }


    /**
     * Get User's exam results
     * @param  int   $id    User ID
     * @return Array Json 
     */
    public function getUserResults($id)
    {
        $results = Result::where('user_id',$id)->get();

        return response()->json([
            "results" => $results
        ], 200);
    }

    public function new(Request $request)
    {
  
    	$answers = $request->info;
        $questions = $request->exams;
        $qa = [];
        $score = 0;
        $has_passed = false;

        foreach( $answers as $key => $value )
        {
            if( $answers[$key] === $questions[$key]['answer'] ) {
                $score++;
            } 
        } 


        // Determine Student score
        $my_score = ($score / $request->total_questionnaire) * 100 ;  

        $has_prev_result = DB::table('results')
                            ->where('user_id', $request->user_id)
                            ->where('course_id', $request->course_id)
                            ->get();

        // Delete previous result                  
        if( count($has_prev_result) > 0 ) {

                DB::table('results')
                    ->where('user_id', $request->user_id)
                    ->where('course_id', $request->course_id)
                    ->delete();
        }                   

        //
        if( $my_score >= $request->passing_score )
        {
            $has_passed = true;

        } 

    	$result = Result::create([

    			'course_id' => $request->course_id,
    			'user_id'   => $request->user_id,
    			'score'     => $my_score,
    			'info'      => "Answers",
    			'has_passed' => $has_passed,
                'has_resolve' => 0
    	]);


    	return response()->json([
    		"score" => $my_score,
            "result" => $has_passed,
            "results" => $result
    	], 200);
    }

    public function update($id, Request $request)
    {

        $result = Result::find($id);

        $result->update($request->all());

        return response()->json([
                'result' => $result
        ], 200);

    }

    public function delete($id) 
    {
        $result = Result::find($id)->delete();


        return response()->json([
            'message' => 'Result deleted successfully!',
            'courses' => $result
        ]);
    }
}
