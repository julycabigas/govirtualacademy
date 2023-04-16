<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    public function all()
    {
    	$categories = Category::all();
    
    	return response()->json([
    		"categories" => $categories
    	], 200);
    }

    public function get($id)
    {
    	$category = Category::where('id',$id)->first();

      	return response()->json([
    		"category" => $category
    	], 200);
    }

    public function new(Request $request)
    {
    	$category = Category::create($request->only(["name","description"]));

    	return response()->json([
    		"category" => $category
    	], 200);
    }

    public function update($id, Request $request)
    {

        $category = Category::find($id);

        $category->update($request->all());

        return response()->json([
                'category' => $category
        ], 200);

    }
}
