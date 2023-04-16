<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exercise;
use App\ExerciseEntry;
use DB;

class ExerciseEntryController extends Controller
{
    // Get All Student's Exercises           
    public function all() {
        $exercises = ExerciseEntry::with('user','exercise')->orderBy('id', 'desc')->paginate(10);
        
            return response()->json([
                "exercises" => $exercises
            ], 200);
    }
    

    // Complete exercise for the student
    public function new(Request $request)
    {


        $exercise = new ExerciseEntry;
        $exercise->exercise_id = $request->exercise_id;
        $exercise->user_id = $request->user_id;
        $exercise->content = strip_tags($request->content);
        $exercise->has_passed = false;
        $exercise->save();
  
        return response()->json([
            "status" => true,
            "exercise" => $exercise
        ], 200);
    }

    //Get the training
    public function get($id) {
        $exercise = ExerciseEntry::with('users','exercises')->find($id);
        
            return response()->json([
                "exercise" => $exercise
            ], 200);
    }


    public function update(Request $request, $id) {
         $entry = ExerciseEntry::find($id);
         $entry->has_passed = $request->has_passed;
         $entry->comment = $request->comment;
         $entry->save();

         return response()->json([
            "success" => true,
        ], 200);
    }

    //Get the training
    public function checkCompleted($user_id, Request $request) {


        $exercises = Exercise::with(['entry' => function($query) use ($user_id){
                $query->orderBy('created_at', 'desc')
                      ->where('user_id', '=', $user_id);

         }])
        ->where('exercises.group_id', '=', $request->get('group_id'))
        ->get();  

       //Get all exercises
       foreach( $exercises as $exercise ) {
            
            $check_pass = ExerciseEntry::where('user_id', '=', $user_id)
                ->where(function($query) use ($exercise){
                    $query->where('exercise_id', '=', $exercise->id);
                })
                ->where(function($query) use ($exercise){
                    $query->where('has_passed', '=', true);
                })
                ->value('has_passed'); 

             $exercise->has_passed = $check_pass;
        }  

                
        return response()->json([
            "exercises" => $exercises,
            "user_id" => $user_id
        ], 200);

    }


    //Delete exercises of the student
    public function delete($id) 
    {
        $exercise = ExerciseEntry::find($id)->delete();

        return response()->json([
            'message' => 'Task group deleted successfully!',
            'success' => true
        ]);
    }
    
}
