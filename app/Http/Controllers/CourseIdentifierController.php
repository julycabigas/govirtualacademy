<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseIdentifier;
use App\CourseGroupIdentifier;
use DB;


class CourseIdentifierController extends Controller
{
    public function all()
    {
      $courseIdentifier = DB::table('course_identifiers')
      ->leftJoin('access_levels', 'course_identifiers.course_id', '=', 'access_levels.id')
      ->select('course_identifiers.*', 'access_levels.display_name')
      ->orderBy('course_identifiers.level', 'asc')
      ->get();
      
   
    	return response()->json([
    		"course_ids" => $courseIdentifier
    	], 200);
    }

    public function list()
    {
      $coursesIdentifiers = CourseIdentifier::orderBy('id', 'desc')->get();
    
    	return response()->json([
    		"courses_identifiers" => $coursesIdentifiers
    	], 200);
    }

    public function allGroups() {
      $coursesIdentifiers = CourseIdentifier::orderBy('id', 'desc')->paginate(10);
    
    	return response()->json([
    		"courses_identifiers" => $coursesIdentifiers
    	], 200);
    }

    public function getGroup($id) {

      $course = CourseIdentifier::where('id',$id)->first();

      return response()->json([
        "course" => $course
      ], 200);
    }

    public function getStudentCourseGroups($id) {

      $access_items = DB::table('access_items')
                            ->join('course_identifiers', 'access_items.access_id', '=', 'course_identifiers.course_id') 
                            ->select('course_identifiers.*') 
                            ->where('access_items.user_id','=', $id)
                            ->get();

      $access = [];     
      $count = 0;               

      // foreach( $access_items as $item ) {
          
      //     $courses = DB::table('course_identifiers')
      //               ->select('course_identifiers.*')
      //               ->where('course_identifiers.course_id', '=', $item->id)
      //               ->get();  

      //     $access_items->training_id = $item->id;          

      //     //$access[$count]['training'] = $item->display_name;
      //     //$access[$count]['course_group'] = $courses;
    
      //     $count++;  
      // }   

      // $courses = DB::table('access_items')->where('user_id', $studentID)->get();
      
   
    	return response()->json([
        "access_items" => $access_items
    	], 200);


    }


    // Add new course group
    public function new(Request $request)
    {

        if( $request->get('image') ) {

                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
                
        } 

        $input        = $request->course;
        $accessID    = $request->accessID;

        if(  $request->get('image') ) {

            $groupID = new CourseIdentifier;
            $groupID->name = strip_tags($input['title']);
            $groupID->description = $input['description'];
            $groupID->level = $input['level'];
            $groupID->course_id = $accessID;
            $groupID->image = $name;
            $groupID->save();

        } 
        else {
          $groupID = new CourseIdentifier;
          $groupID->name = strip_tags($input['title']);
          $groupID->description = $input['description'];
          $groupID->level = $input['level'];
          $groupID->course_id = $accessID;
          $groupID->save();
        }

    	return response()->json([
        "course" => $groupID,
        ""
    	], 200);
    }

    public function updateGroup($id,Request $request)
    {
        $course = CourseIdentifier::find($id);

        if( $request->get('image') ) {
                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
                
        } 

        $input = $request->course;
        $accessID    = $request->accessID;

        if(  $request->get('image') ) {
            $course->update([
                  'name' => strip_tags($input['name']),
                  'description' => strip_tags($input['description']),
                  'level' => $input['level'],
                  'course_id' => $accessID,
                  'image' => $name
            ]);
        } 
        else {
            $course->update([
              'name' => strip_tags($input['name']),
              'description' => strip_tags($input['description']),
              'level' => $input['level'],
              'course_id' => $accessID,
            ]);
        }
  

        return response()->json([
            "course" => $course,
        ], 200);

    }

    public function delete($id) 
    {
        $course = CourseIdentifier::find($id)->delete();


        return response()->json([
            'message' => 'Course group deleted successfully!'
        ]);
    }


    //Add new course to the course group
    public function addCourse(Request $request)
    {
           
          $groupid = $request->groupID;

          $delete_course_group = DB::table('course_group_identifiers')
                                    ->where('course_id', '=',$request->courseID)
                                    ->where(function($query) use ($groupid )  {
                                        $query
                                          ->where('course_identifiers_id', '=', $groupid);
                                    })
                                    ->delete();

          $groupID = new CourseGroupIdentifier;
          $groupID->course_identifiers_id = $request->groupID;
          $groupID->course_id = $request->courseID;
          $groupID->menu_order = $request->menuID;
          $groupID->module_id = $request->moduleID;
          $groupID->save();

          if($groupID) {
              $status = true;
          } else {
            $status = false;
          }

          return response()->json([

                    'status' => $status
            ], 200);

    }
    

    public function getName($id) {

      //$courses = CourseGroupIdentifier::where('course_identifiers_id',$id)->get();
      
        $name = DB::table('course_identifiers')
                          ->where('id', '=', $id)
                          ->value('name');

      	return response()->json([
          "name" => $name
        ], 200);
    }

    public function get($id) {


        // $courses = DB::table('course_group_identifiers')
        // ->leftJoin('courses', 'course_group_identifiers.course_id', '=', 'courses.id')
        // ->where('course_group_identifiers.course_identifiers_id', '=', $id)
        // ->select('course_group_identifiers.id as group_id', 'course_group_identifiers.status as note','courses.*')
        // ->orderBy('course_group_identifiers.menu_order', 'asc')
        // ->get();

        $courses = DB::table('course_group_identifiers')
        ->leftJoin('courses', 'course_group_identifiers.course_id', '=', 'courses.id')
        ->where('course_group_identifiers.module_id', '=', $id)
        ->select('course_group_identifiers.id as group_id', 'course_group_identifiers.status as note','courses.*')
        ->orderBy('course_group_identifiers.menu_order', 'asc')
        ->get();


        $count  = 1;

        //Get all tasks
        foreach( $courses as $course ) {
            
            $tasks = DB::table('tasks')
                      ->select('tasks.*')
                      ->where('tasks.group_identifiers_id', '=', $course->group_id)
                      ->get();  

            $course->tasks  = $tasks;

            $badges = DB::table('badge_requirements')
                       ->leftJoin('badges', 'badge_requirements.badge_id', '=', 'badges.id')
                       ->select('badges.*')
                       ->where('badge_requirements.group_identifiers_id', '=', $course->group_id)
                       ->get();
            
            $course->badges = $badges;

            $count++;  
        }  

    


      	return response()->json([
          "courses" => $courses
        ], 200);
    }

    //Update course group
    public function update($id, Request $request)
    {
          $groups = $request->group;  

          $delete_course_group = DB::table('course_group_indentifiers')->where('course_id', '=',$id)->delete();

          for($a = 0; $a < count($roles); $a++) {

             $groupID = new CourseGroupIdentifier;
             $groupID->course_identifiers_id = $id;
             $groupID->course_id = $groups[$a];
             $groupID->menu_order = '';
             $groupID->save();
          }

          return response()->json([
                    'roles' => count($groups),
                    'id' => $id
            ], 200);

    }


    public function allGroupIdentifiers() {

      $groupIndentifiers  = DB::table('course_group_identifiers')
        ->leftJoin('courses', 'course_group_identifiers.course_id', '=', 'courses.id')
        ->leftJoin('course_identifiers', 'course_identifiers.id', '=', 'course_group_identifiers.course_identifiers_id')
        ->select('course_group_identifiers.id', 'courses.title', 'course_identifiers.name')
        ->orderBy('course_identifiers.name', 'asc')
        ->get();

      return response()->json([
          "groups" => $groupIndentifiers
      ], 200);
    }



}
