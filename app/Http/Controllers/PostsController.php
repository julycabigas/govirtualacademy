<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function all()
    {
    	$posts = Post::paginate(2);
    
    	return response()->json([
    		"posts" => $posts
    	], 200);
    }

    public function get($id)
    {
    	$post = Post::where('id',$id)->first();

      	return response()->json([
    		"post" => $post
    	], 200);
    }

    public function new(Request $request)
    {
    	$post = Post::create($request->only(["title","content","status"]));

    	return response()->json([
    		"post" => $post
    	], 200);
    }

    public function update($id, Request $request)
    {

        $post = Post::find($id);

        $post->update($request->all());

        return response()->json([
                'post' => $post
        ], 200);

    }

    public function delete($id) 
    {
        $post = Post::find($id)->delete();

        return response()->json([
            'message' => 'Post deleted successfully!'
        ]);
    }
}
