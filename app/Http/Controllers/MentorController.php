<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mentorship;
use DB;

class MentorController extends Controller
{
    public function all()
    {
    	$mentors = User::where('role', '=', 8)->paginate(20);
    
    	return response()->json([
    		"mentors" => $mentors
    	], 200);
    }

    public function get($id)
    {
    	$mentor = User::where('role', '=', 8)
    				->where('id',$id)->first();

      	return response()->json([
    		"mentor" => $mentor
    	], 200);
    }

    public function getAllStudents($id)
    {
    	$students = Mentorship::where('mentor_id', '=', $id)->count();

      	return response()->json([
    		"total_students" => $students
    	], 200);
	}
	
	public function updateByAdmin($id, Request $request)
    {
        $input      = $request->student;
        $image      = $request->image;

        $about = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input['about']);


        if(  $image  ) {
            // Upload and Save File

            $image_link = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('image'))->save(public_path('users/').$image_link);   
        } 
        if(  $image ) {

            $student = DB::table('users')
            ->where('id', $id)
            ->update([
                        'firstname' => strip_tags($input['firstname']),
                        'lastname' => strip_tags($input['lastname']),
                        'email' => strip_tags($input['email']),
                        'address' => strip_tags($input['address']),
                        'address_2' => strip_tags($input['address_2']),
                        'zipcode' => strip_tags($input['zipcode']),
                        'municipality' => strip_tags($input['municipality']),
                        'phone' => strip_tags($input['phone']),
						'about' => $about,
						'position' => strip_tags($input['position']),
                        'role' => 8,
                        'show_profile' => $input['show_profile'],
                        'image' => $image_link
            ]);
        }
        else {

            $student = DB::table('users')
            ->where('id', $id)
            ->update([
                        'firstname' => strip_tags($input['firstname']),
                        'lastname' => strip_tags($input['lastname']),
                        'email' => strip_tags($input['email']),
                        'address' => strip_tags($input['address']),
                        'address_2' => strip_tags($input['address_2']),
                        'zipcode' => strip_tags($input['zipcode']),
                        'municipality' => strip_tags($input['municipality']),
						'phone' => strip_tags($input['phone']),
						'position' => strip_tags($input['position']),
                        'about' => $about,
                        'role' => 8,
                        'show_profile' => $input['show_profile']
            ]);
        }



    

        return response()->json([
                'student' => $input['firstname']
         
        ], 200);

    }

}
