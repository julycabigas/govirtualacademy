<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use DB;

class VideosController extends Controller
{
    public function all(Request $request)
    {

        $keyword = '';
        if($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
        }

        if($keyword) {
            $videos = Video::with('course')
                ->where(function($query) use($keyword){
                if($keyword) {
                    $query->orWhere(\DB::raw('title'), 'LIKE', '%' . $keyword . '%');
                    $query->orWhere(\DB::raw('description'), 'LIKE', '%' . $keyword . '%');
                }
            })
            ->orderBy('id', 'desc')->paginate(10);
        }
        else {
            $videos = Video::with('course')->orderBy('id', 'desc')->paginate(10);
        }
    	
    
    	return response()->json([
    		"videos" => $videos
    	], 200);
    }

    public function get($id)
    {
    	$video = Video::where('id',$id)->first();

      	return response()->json([
    		"video" => $video
    	], 200);
    }

    public function new(Request $request)
    {
    	$video = Video::create($request->only(["title","description","file","course_id","time", "menu_order"]));

    	return response()->json([
    		"video" => $video
    	], 200);
    }

    public function update($id, Request $request)
    {

        $video = Video::find($id);

        $video->update($request->all());

        return response()->json([
                'video' => $video
        ], 200);

    }


    public function getVideosByCourse($id) {

        $videos = Video::where('course_id', $id)->get();

        return response()->json([
                "videos" => $videos
        ], 200);
    }


    /**
     * Get User's courses
     * @param  [type] $id  User Role ID
     * @return json        Courses
     */
    public function getMyLessons( $id )
    {

        $course      = DB::table('courses')->where('id', $id)->first();
        $category_id = DB::table('courses')->where('id', $id)->value('category_id');

        $lessons = DB::table('videos')
                    ->join('courses', 'videos.course_id', '=', 'courses.id')
                    ->select('videos.*')
                    ->where('videos.course_id', '=', $id)
                    ->orderby('menu_order', 'asc')
                    ->get();

        $category_name = DB::table('categories')->where('id', $category_id)->value('name');            
      
        return response()->json([
            "lessons" => $lessons,
            "course"  => $course,
            "category" => $category_name
        ], 200);
    }

    public function delete($id) 
    {
        $video = Video::find($id)->delete();

        return response()->json([
            'message' => 'Video deleted successfully!'
        ]);
    }
}
