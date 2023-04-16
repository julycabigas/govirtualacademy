<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\AccessItem;
use App\StudentBadges;
use DB;
use App\FreeTrial;
use Mail;
use App\Events\RegisterConfirmation;
use App\Mail\WelcomeStudent;
use App\Mail\InformAdminNewUser;

class StudentsController extends Controller
{
    public function all(Request $request)
    {

        $keyword = '';
        if($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
        }

        if($keyword) {
            $students = User::
                        where('role', '!=', 1)
                        ->where(function($query) use($keyword){
                            if($keyword) {
                                $query->orWhere(\DB::raw('firstname'), 'LIKE', '%' . $keyword . '%');
                                $query->orWhere(\DB::raw('lastname'), 'LIKE', '%' . $keyword . '%');
                                $query->orWhere(\DB::raw('phone'), 'LIKE', '%' . $keyword . '%');
                            }
                        })
                        ->orderBy('id', 'desc')->paginate(10); 

        } else {
            $students = User::where('role', '!=', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        }
    
    	return response()->json([
            "students" => $students,
            "keyword" => $keyword
    	], 200);
    }

    public function allVisibleProfile()
    {
        $students = User::where('role', '!=', 1)
                        ->where(function($query) {
                            $query->where('role', '!=', 8);
                        }) 
                        ->where(function($query) {
                            $query->where('show_profile', '=', 1);
                        }) 
                        ->orderBy('created_at', 'desc')
                        ->paginate(16);
    

                        
    	return response()->json([
    		"students" => $students
    	], 200);
    }

    public function allMentorship($id)
    {
        $students = DB::table('users')
                        ->leftJoin('mentorships', 'mentorships.student_id', '=', 'users.id')
                        ->where('mentorships.mentor_id', '=', $id)
                        ->select('users.id','users.email', 'users.firstname', 'users.lastname', 'users.image', 'users.phone')
                        ->paginate(10);
    
        return response()->json([
            "students" => $students
        ], 200);

    }

    public function allList()
    {
        $students = User::where('role', '!=', 1)->get();
    
        return response()->json([
            "students" => $students
        ], 200);
    }

    public function get($id)
    {
    	$student = User::with('trials')->where('id',$id)->first();

      	return response()->json([
    		"student" => $student
    	], 200);
    }

    public function getVisibleStudent($id)
    {
        $student = User::where('id',$id)
                        ->where(function($query) {
                            $query->where('role', '!=', 1);
                        })  
                        ->where(function($query) {
                            $query->where('show_profile', '=', 1);
                        })
                        ->first();

        $badges = StudentBadges::with('badges')
            ->where('student_id','=', $id)
            ->orderBy('id', 'desc')
            ->get();

        $student->badges = $badges;    


      	return response()->json([
    		"student" => $student
    	], 200);
    }

    public function new(Request $request)
    {

        $student = new User;
        $student->firstname = strip_tags($request->firstname);
        $student->lastname = strip_tags($request->lastname);
        $student->password = Hash::make($request->password);
        $student->email = strip_tags($request->email);
        $student->address = strip_tags($request->address);
        $student->address_2 = strip_tags($request->address_2);
        $student->zipcode = strip_tags($request->zipcode);
        $student->municipality = strip_tags($request->municipality);
        $student->phone = strip_tags($request->phone);
        $student->role = 2;
        $student->save();
       
  
        $permission = new AccessItem;
        $permission->user_id = $student->id;
        $permission->access_id = 7;
        $permission->save();

        //Send email confirmation to students    
        Mail::to($student->email)->send(new WelcomeStudent($user));

        //Send admin notification    
        Mail::to('support@virtualacademy.ph')->send(new InformAdminNewUser($user));

    	return response()->json([
    		"student" => $student
    	], 200);
    }

    public function update($id, Request $request)
    {

        $student = User::find($id);

        $student->update($request->all());

        return response()->json([
                'student' => $student
        ], 200);

    }

    public function updatePrivacy($id, Request $request)
    {

        $student = User::find($id);

        $student->update([ 'show_profile' => $request->privacy]);

        return response()->json([
                'privacy' => $request->privacy
        ], 200);

    }

    public function updateInfo($id, Request $request)
    {
        $input = $request->student;
        $about = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input['about']);


        if( $request->get('image') ) {
                // Upload and Save File
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('users/').$name);   
        }  


        if(  $request->get('image') ) {

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
                        'role' => strip_tags($input['role']),
                        'position' => strip_tags($input['position']),
                        'website' => strip_tags($input['website']),
                        'image' => $name
                ]);

        } else {
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
                        'website' => strip_tags($input['website']),
                        'role' => strip_tags($input['role']),
                ]);
        }

        return response()->json([
                'student' => $student,
        ], 200);

    }

    public function updateByAdmin($id, Request $request)
    {
        $user = User::find($id);

        //Mail::to('julyninocabigas@gmail.com')->send(new WelcomeStudent($user));

        //event(new RegisterConfirmation($user));
        
        //  $to_name = "RECEIVER_NAME";
        //  $to_email = "julycabigas@yahoo.com";
        //  $data = array("name"=>"Ogbonna Vitalis(sender_name)", "body" => "A test mail");
        //  Mail::send("mails.welcome", $data, function($message) use ($to_name, $to_email) {
        //  $message->to($to_email, $to_name)
        //  ->subject("Laravel Test Mail");
        //  $message->from("xss@gmail.com","Test Mail");
        //  });

        $input      = $request->student;
        $trialGroup = $request->trialGroup;
        $limit      = $request->limit;
        $image      = $request->image;
        $password   = $request->password;


        $about = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input['about']);


        if(  $image  ) {
            // Upload and Save File

            $image_link = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('image'))->save(public_path('users/').$image_link);   
        } 


        if(  $image ) {

            if($password) {
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
                            'role' => 2,
                            'image' => $image_link,
                            'password' => bcrypt($password)
                ]); 
            } else {

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
                            'role' => 2,
                            'image' => $image_link
                ]); 
            }
            
        }
        else {
            

            if($password) {

    
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
                            'role' => 2,
                            'password' => bcrypt($password)
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
                            'about' => $about,
                            'role' => 2,
                            
                ]);

            }
            
        }

        if($trialGroup == 0) {
            $hasEntry = FreeTrial::where('user_id', $id)->delete();
        }
        else if($trialGroup != null && $limit != null ) {

           $hasEntry = FreeTrial::where('user_id', $id)->delete();

                $trial = new FreeTrial;
                $trial->step_limit = $limit;
                $trial->user_id  = $id;
                $trial->group_id = $trialGroup;
                $trial->save();

        } else {
            $hasEntry = FreeTrial::where('user_id', $id)->delete();
        }
    

        return response()->json([
                'student' => $input,
                'trial' => $trialGroup,
                'limit' => $limit
         
        ], 200);

    }

    public function updatePassword($id, Request $request)
    {
        $input = $request->password;
  
        $student = DB::table('users')
                ->where('id', $id)
                ->update([
                    'password' => Hash::make($input),
            ]);
        
        return response()->json([
                'student' => $student,
        ], 200);

    }


    public function delete($id)
    {
        $user = User::find($id)->delete();

        return response()->json([
            'message' => 'User has been successfully deleted!'
        ], 200);
    }
}
