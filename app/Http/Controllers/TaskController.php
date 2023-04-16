<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{

        // Get All Tasks           
        public function all(Request $request) {

            $keyword = '';
            if($request->has('keyword') && $request->keyword) {
                $keyword = $request->keyword;
            }

            if($keyword) {
            $tasks = Task::where(function($query) use($keyword){
                            if($keyword) {
                                $query->orWhere(\DB::raw('name'), 'LIKE', '%' . $keyword . '%');
                                $query->orWhere(\DB::raw('description'), 'LIKE', '%' . $keyword . '%');
                            }
                        })
                        ->orderBy('id', 'desc')->paginate(10); 
            } else {
            $tasks = Task::orderBy('id', 'desc')->paginate(10); 
            }
            
        
            return response()->json([
                "tasks" => $tasks,
                "keyword" => $keyword
            ], 200);
        }


        // Get All Tasks           
        public function list() {
            $tasks = Task::orderBy('id', 'desc')->get();
        
            return response()->json([
                "tasks" => $tasks
            ], 200);
        }



        //Get a task
        public function get($id) {
            $task = Task::find($id);
        
            return response()->json([
                "task" => $task
            ], 200);
        }

        

        // Add new task
        public function new(Request $request)
        {


            $input = $request->task;

            $task = new Task;
            $task->name = strip_tags($input['name']);
            $task->description = $input['description'];
            $task->group_identifiers_id = $input['group_identifiers_id'];
            $task->save();

            
            return response()->json([
            "task" => $task,

            ], 200);
        }
        

        //Update task
        public function update($id, Request $request)
        {
              $task = Task::find($id);
              $input = $request->task;
 
              $task->name = strip_tags($input['name']);
              $task->description = $input['description'];
              $task->group_identifiers_id = $input['group_identifiers_id'];
              $task->notes = $input['notes'];
              $task->save();
    
              return response()->json([
                        'task' => $task,
       
                ], 200);
    
        }

        //Delete task
        public function delete($id) 
        {
            $task = Task::find($id)->delete();
    
    
            return response()->json([
                'message' => 'Task group deleted successfully!'
            ]);
        }
    
}
