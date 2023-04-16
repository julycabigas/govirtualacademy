<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskEntry;
use DB;

class TaskEntryController extends Controller
{
    // Get All Student's Tasks           
    public function all() {
        $tasks = TaskEntry::with('users','tasks')->orderBy('id', 'desc')->paginate(10);
        
            return response()->json([
                "tasks" => $tasks
            ], 200);
    }
    

    // Complete task for the student
    public function new(Request $request)
    {

        $taskID = $request->taskID;
        $studentID = $request->studentID;

        $task = new TaskEntry;
        $task->task_id = $taskID;
        $task->user_id = $studentID;
        $task->status = 'completed';
        $task->save();
  
        return response()->json([
            "status" => true
        ], 200);
    }

    public function update(Request $request, $id)
    {

        $taskID = $id;

        $task = TaskEntry::find($taskID);
        $task->status = 'completed';
        $task->save();
  
        return response()->json([
            "status" => true
        ], 200);
    }

    // Pending task for the student
    public function pending(Request $request)
    {

        $taskID = $request->task_id;
        $studentID = $request->student_id;
        $content = $request->content;

        $has_task = TaskEntry::find($taskID);    
        if($has_task != null) {
            TaskEntry::find($taskID)->delete();
        }
        

        $task = new TaskEntry;
        $task->task_id = $taskID;
        $task->user_id = $studentID;
        $task->status = 'pending';
        $task->content = $content;
        $task->save();  
          
        
    
        return response()->json([
            "status" => true
        ], 200);
    }

    
    // Get pending task for the student
    public function getPending(Request $request)
    {

        $taskID = $request->task_id;
        $studentID = $request->student_id;

        $tasks = TaskEntry::with('users', 'tasks')->where('status', '=', 'pending')->orderBy('id', 'desc')->paginate(15);

    
        return response()->json([
            "status" => true,
            'tasks' => $tasks
        ], 200);
    }


    //Get the training
    public function get($id) {
        $task = TaskEntry::with('users','tasks')->find($id);
        
            return response()->json([
                "task" => $task
            ], 200);
    }

    //Get the training
    public function checkCompleted($user_id, Request $request) {


        $tasks = DB::table('tasks')
        ->select('tasks.*')
        ->where('tasks.group_identifiers_id', '=', $request->get('group_id'))
        ->get();  

       //Get all tasks
       foreach( $tasks as $task ) {
            
            $is_completed = TaskEntry::where('user_id', '=', $user_id)
                ->where(function($query) use ($task){
                    $query->where('task_id', '=', $task->id);
                })
                ->where(function($query) {
                    $query->where('status', '=', 'completed');
                })
                ->get(); 

             if(count($is_completed)) {
                $task->completed = true;
             }   
             else {
                $task->completed = false;
             }
    }  

                    

        return response()->json([
            "tasks" => $tasks
        ], 200);
    }


    //Delete tasks of the student
    public function delete($id) 
    {
        $task = TaskEntry::find($id)->delete();

        return response()->json([
            'message' => 'Task group deleted successfully!'
        ]);
    }
    
}
