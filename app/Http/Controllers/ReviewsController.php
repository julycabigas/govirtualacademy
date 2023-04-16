<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use DB;

class ReviewsController extends Controller
{
    public function all()
    {
    	$reviews = Review::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
    
    	return response()->json([
    		"reviews" => $reviews
    	], 200);
    }

    public function allApprove()
    {
        $reviews = Review::with('user')
            ->where('approve', 1)
            ->orderBy('created_at', 'desc')
            ->get();
    
        return response()->json([
            "reviews" => $reviews
        ], 200);
    }

    public function get($id)
    {
    	$review = Review::where('id',$id)->first();

        if( !$review["image"] ) {
            $user_firstname = DB::table('users')->where('id', $id)->value('firstname');
            $user_image     = DB::table('users')->where('id', $id)->value('image');


            $review['name'] = $user_firstname;
            $review['image'] = $user_image;
        } 

      	return response()->json([
    		"review" => $review
    	], 200);
    }

    public function new(Request $request)
    {
    	$review = Review::create($request->only(["user_id","content","approve","course_id"]));

    	return response()->json([
    		"review" => $review,
            "message" => "Thank you! You're message has been sent successfully"
    	], 200);
    }

    public function create(Request $request)
    {
        $input    = $request->review;

        if( $request->get('image') ) {

                // Upload and Save File
                $image = $request->get('image');
                $img_name = $input['name'] . '-' . time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$img_name);
                
        } 
        

        $review = Review::create([
                  'name' => $input['name'],
                  'image' => $img_name,
                  'content' => $input['content'],
                  'user_id' => 1,
                  'approve' => 1

        ]);

        return response()->json([
            "review" => $review,
            "status" => true,
            "message" => "Review has been successfully added!"
        ], 200);

    }

    public function update($id, Request $request)
    {
        $input    = $request->review;

        if( $request->get('image') ) {

                // Upload and Save File
                $image = $request->get('image');
                $img_name = $input['name'] . '-' . time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$img_name);
                
        } 

        if(  $request->get('image') ) {


            $review = Review::find($id);

            $review->name = $input['name'];
            $review->content = $input['content'];
            $review->image = $img_name;
            $review->save();

        }
        else {

            $review = Review::find($id);
            $review->name = $input['name'];
            $review->content = $input['content'];
            $review->save();
        }



        return response()->json([
                'review' => $review
        ], 200);

    }

    public function approve($id)
    {

        $review = Review::find($id);

        $review->update([
            'approve' => 1
        ]);

        return response()->json([
                'review' => $review
        ], 200);

    }

    public function delete($id) 
    {
        $review = Review::find($id)->delete();

        return response()->json([
            'message' => 'Review deleted successfully!'
        ]);
    }
}
