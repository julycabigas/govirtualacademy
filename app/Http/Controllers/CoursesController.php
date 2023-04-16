<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\AccessLevel;
use App\CoursePermission;
use DB;
use App\Training;

class CoursesController extends Controller
{
    public function all()
    {
    	$courses = Course::with(['video','exam'])->orderBy('id', 'desc')->paginate(7);
    
    	return response()->json([
    		"courses" => $courses
    	], 200);
    }

    public function allList()
    {
      $courses = Course::all();
    
      return response()->json([
        "courses" => $courses
      ], 200);
    }

    public function allVisible()
    {
      $courses = Course::with(['video','exam'])->get();
    
      return response()->json([
        "courses" => $courses
      ], 200);
    }

    public function get($id)
    {
    	$course = Course::where('id',$id)->first();

      	return response()->json([
    		"course" => $course
    	], 200);
    }

    public function new(Request $request)
    {

        if( $request->get('image') ) {

                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
                
        } 

        $input    = $request->course;
        $featured = ( $input['featured'] == null) ? 1 : 0;


        if(  $request->get('image') ) {

            $course = Course::create([
                  'title' => strip_tags($input['title']),
                  'short_description' => strip_tags($input['short_description']),
                  'description' => $input['description'],
                  'orig_price' => strip_tags($input['orig_price']),
                  'discount_price' => strip_tags($input['discount_price']),
                  'inclusions' => $input['inclusions'],
                  'learn' => $input['learn'],
                  'requirement' => $input['requirement'],
                  'category_id' => strip_tags($input['category_id']),
                  'status' => strip_tags($input['status']),
                  'timer' => strip_tags($input['timer']),
                  'rating' => strip_tags($input['rating']),
                  'total_students' => strip_tags($input['total_students']),
                  'featured' => strip_tags($featured),
                  'image' => $name
            ]);

            AccessLevel::create([
                'name'              => $input['access_slug'],
                'display_name'      => $input['title'],
                'reg_price'         => $input['orig_price'],
                'discount_price'    => $input['discount_price'],
                'short_description' => $input['short_description'],
                'type'              => 'single'
            ]);

        } 
        else {
            $course = Course::create([
                  'title' => strip_tags($input['title']),
                  'short_description' => strip_tags($input['short_description']),
                  'description' => $input['description'],
                  'orig_price' => strip_tags($input['orig_price']),
                  'discount_price' => strip_tags($input['discount_price']),
                  'inclusions' => $input['inclusions'],
                  'learn' => $input['learn'],
                  'requirement' => $input['requirement'],
                  'category_id' => strip_tags($input['category_id']),
                   'timer' => strip_tags($input['timer']),
                  'status' => strip_tags($input['status']),
                  'rating' => strip_tags($input['rating']),
                  'total_students' => strip_tags($input['total_students']),
                  'featured' => strip_tags($featured)
            ]);

            AccessLevel::create([
                'name'              => $input['access_slug'],
                'display_name'      => $input['title'],
                'reg_price'         => $input['orig_price'],
                'discount_price'    => $input['discount_price'],
                'short_description' => $input['short_description'],
                'type'              => 'single'
            ]);
      }

    	return response()->json([
    		"course" => $course
    	], 200);
    }


    public function update($id,Request $request)
    {
        $course = Course::find($id);

        if( $request->get('image') ) {
                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
                
        } 

        $input = $request->course;

        if(  $request->get('image') ) {
            $course->update([
                  'title' => strip_tags($input['title']),
                  'short_description' => strip_tags($input['short_description']),
                  'description' => $input['description'],
                  'orig_price' => strip_tags($input['orig_price']),
                  'discount_price' => strip_tags($input['discount_price']),
                  'inclusions' => $input['inclusions'],
                  'learn' => $input['learn'],
                  'requirement' => $input['requirement'],
                  'category_id' => strip_tags($input['category_id']),
                  'status' => strip_tags($input['status']),
                  'timer' => strip_tags($input['timer']),
                  'rating' => strip_tags($input['rating']),
                  'total_students' => strip_tags($input['total_students']),
                  'passing_score' => $input['passing_score'],
                  'featured' => strip_tags($input['featured']),
                  'image' => $name
            ]);
        } 
        else {
            $course->update([
                  'title' => strip_tags($input['title']),
                  'short_description' => strip_tags($input['short_description']),
                  'description' => $input['description'],
                  'orig_price' => strip_tags($input['orig_price']),
                  'discount_price' => strip_tags($input['discount_price']),
                  'inclusions' => $input['inclusions'],
                  'learn' => $input['learn'],
                  'requirement' => $input['requirement'],
                  'category_id' => strip_tags($input['category_id']),
                  'timer' => strip_tags($input['timer']),
                  'rating' => strip_tags($input['rating']),
                  'total_students' => strip_tags($input['total_students']),
                  'passing_score' => $input['passing_score'],
                  'status' => strip_tags($input['status']),
                  'featured' => strip_tags($input['featured'])
            ]);
        }
   

        return response()->json([
            "course" => $course,

        ], 200);
    }

    /**
     * Get User's courses
     * @param  [type] $id  User Role ID
     * @return json        Courses
     */
    public function getMyCourses($id)
    {


        $access_items = DB::table('access_items')
                            ->join('access_levels', 'access_items.access_id', '=', 'access_levels.id') 
                            ->select('access_levels.*') 
                            ->where('access_items.user_id','=', $id)
                            ->get();

        $access = [];     
        $count = 0;               

        foreach( $access_items as $item ) {
            
            $courses = DB::table('trainings')
                     ->join('courses', 'courses.id', '=', 'trainings.course_id')
                     ->select('courses.title','courses.short_description','courses.id','courses.image')
                     ->where('trainings.access_id', '=', $item->id)
                     ->get();  

            $access[$count]['training'] = $item->display_name;
            $access[$count]['courses'] = $courses;
     
            $count++;  
        }                   



        return response()->json([
            "access" => $access,
            "access_items" => $access_items
        ], 200);
    }

    /**
     * Get All Free Courses
     * @return Json  Collections of free courses
     */
    public function getFreeCourses()
    {
        // $courses = DB::table('courses')
        //       ->join('course_permissions', 'courses.id', '=', 'course_permissions.course_id')
        //       ->select('courses.*','course_permissions.role_id')
        //       ->where('course_permissions.role_id', '=', 6) // Is equal to Free Member or Free Videos
        //       ->get();


        $courses = DB::table('courses')
              ->join('trainings', 'courses.id', '=', 'trainings.course_id')
              ->select('courses.*','trainings.access_id')
              ->where('trainings.access_id', '=', 7) // Is equal to Free Member or Free Videos
              ->get();



        return response()->json([
            "courses" => $courses
        ], 200);
    }

    /**
     * Get courses with a spefic category id
     * @param  [type] $id  Category Id
     * @return json        Courses
     */
    public function getCoursesById($id)
    {   
        $courses = DB::table('courses')
                        ->where('category_id', $id)
                        ->get();

        return response()->json([
                "courses" => $courses 
        ], 200);                
    }

    public function getFeaturedCourses() {

        $courses = DB::table('courses')
                        ->where('featured', 1)
                        ->get();

        return response()->json([
                "courses" => $courses 
        ], 200); 

    }

    public function getVACourses() {

        $courses = Training::with(['course'])->where('access_id', 1)->get();

        $training = DB::table('access_levels')->where('id', 1)->first();

        return response()->json([
                "courses" => $courses,
                "training" => $training 
        ], 200); 

    }

    public function searchCourses(Request $request) {

        if($request->search == '') {
            return response()->json([
                    "courses" => '',
            ], 200); 
        }
        $courses = DB::table('courses')
                        ->where('title', 'LIKE', '%'. strip_tags( $request->search ) . '%')
                        ->orWhere('description', 'LIKE', '%'. strip_tags( $request->search ) . '%')
                        ->where( function($query) {
                            $query->where('status', 'publish');
                        })
                        ->paginate(5);

        return response()->json([
                "courses" => $courses,
                "search" => $request->search 
        ], 200); 

    }

    public function delete($id) 
    {
        $course = Course::find($id)->delete();


        return response()->json([
            'message' => 'Course deleted successfully!'
        ]);
    }

}
