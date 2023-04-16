<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exercise;
use App\ExerciseEntry;
use DB;

class ExercisesController extends Controller
{
        // Get All Exercises           
        public function all(Request $request) {

            $keyword = '';
            if($request->has('keyword') && $request->keyword) {
                $keyword = $request->keyword;
            }

            if($keyword) {
            $exercises = Exercise::where(function($query) use($keyword){
                            if($keyword) {
                                $query->orWhere(\DB::raw('title'), 'LIKE', '%' . $keyword . '%');
                                $query->orWhere(\DB::raw('description'), 'LIKE', '%' . $keyword . '%');
                            }
                        })
                        ->orderBy('id', 'desc')->paginate(10); 
            } else {
                $exercises = Exercise::orderBy('id', 'desc')->paginate(10); 
            }
            
        
            return response()->json([
                "exercises" => $exercises,
                "keyword" => $keyword
            ], 200);
        }


        // Get All Exercises         
        public function list() {
            $exercises = Exercise::orderBy('id', 'desc')->get();
        
            return response()->json([
                "exercises" => $exercises
            ], 200);
        }



        //Get a exercise
        public function get($id) {
            $exercise = Exercise::find($id);
        
            return response()->json([
                "exercise" => $exercise
            ], 200);
        }

        

        // Add new exercise
        public function new(Request $request)
        {

            $input = $request->exercise;

            $exercise = new Exercise;
            $exercise->title = strip_tags($input['title']);
            $exercise->description = $input['description'];
            $exercise->group_id = $input['group_id'];
            $exercise->save();

            
            return response()->json([
            "exercise" => $exercise,

            ], 200);
        }
        

        //Update exercise
        public function update($id, Request $request)
        {
              $exercise = Exercise::find($id);
              $input = $request->exercise;
 
              $exercise->title = strip_tags($input['title']);
              $exercise->description = $input['description'];
              $exercise->group_id = $input['group_id'];
              $exercise->save();
    
              return response()->json([
                        'exercise' => $exercise,
       
                ], 200);
    
        }

        public function checkCompleted($user_id, Request $request) {


            $exercises = DB::table('exercises')
            ->select('exercises.*')
            ->where('exercises.group_id', '=', $request->get('group_id'))
            ->get();  
    
           //Get all exercises
           foreach( $exercises as $exercise ) {
                
            $exercise_entries = ExerciseEntry::where('user_id', '=', $user_id)
                    ->where(function($query) use ($exercise){
                        $query->where('exercise_id', '=', $exercise->id);
                    })
                    ->get(); 
    
                 if(count($exercise_entries)) {
                    $exercise->completed = true;
                 }   
                 else {
                    $exercise->completed = false;
                 }
           } 
           return response()->json([
                "exercises" => $exercises
            ], 200);
        }

        //Delete exercise
        public function delete($id) 
        {
            $exercise = Exercise::find($id)->delete();
    
    
            return response()->json([
                'message' => 'Exercise deleted successfully!'
            ]);
        }
    
}
