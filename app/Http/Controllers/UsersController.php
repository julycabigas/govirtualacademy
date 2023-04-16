<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Mail\ForgotPassword;
use App\Token;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidEmail;
use App\AccessItem;
use App\Mail\WelcomeStudent;
use App\Mail\InformAdminNewUser;

class UsersController extends Controller
{
    public function new(Request $request)
    {
        $v = validator::make($request->all(), [
              'email' => 'bail|required|unique:users',
              'password' => 'required|min:6',
              'firstname' => 'required',
              'lastname' => 'required'
        ]);

        if($v->fails()) {
            return response([
                'success' => false,
                'data' => $v->errors()], 200
            );
        }

    	$student = User::create([

    			'email' => strip_tags($request->email),
    			'firstname' => strip_tags($request->firstname),
    			'lastname' => strip_tags($request->lastname),
    			'password' => bcrypt($request->password),
    			'phone' => strip_tags($request->phone),
    			'address' => strip_tags($request->address),
    			'zipcode' => strip_tags($request->zipcode),
    			'municipality' => strip_tags($request->municipality),
    			'role' => strip_tags($request->role),
                'show_profile' => '0',
                'position' => strip_tags($request->position),

        ]);


        if($student) {
            $permission = new AccessItem;
            $permission->user_id = $student->id;
            $permission->access_id = 7;
            $permission->save();
            //Mail::to($student)->send(new WelcomeStudent($student));
        }

        //Send email confirmation to students    
        Mail::to($student->email)->send(new WelcomeStudent($student));

        //Send admin notification    
        Mail::to('support@virtualacademy.ph')->send(new InformAdminNewUser($student));

    	if($student) {
    		return response()->json([
	    		"success" => true,
                "data" => "You have succesfully registered!"
	    	], 200);
    	}

    }

    public function createInPurchase(Request $request)
    {
        $v = validator::make($request->all(), [
              'email' => 'bail|required|unique:users',
              'password' => 'required|min:6',
        ]);

        if($v->fails()) {
            return response([
                'success' => false,
                'data' => $v->errors()], 200
            );
        }

    	$student = User::create([

    			'email' => strip_tags($request->email),
    			'password' => bcrypt($request->password),
    			'role' => 2,
                'show_profile' => '0',

        ]);


        if($student) {
            $permission = new AccessItem;
            $permission->user_id = $student->id;
            $permission->access_id = 7;
            $permission->save();
        }

    	if($student) {
    		return response()->json([
                "success" => true,
                "student" => $student,
                "data" => "You have succesfully registered! Please inform us with your purchased on Facebook messenger."
	    	], 200);
    	}

    }


    /**
     * Handling the forgot password email request    
     */
    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if( !$user ) {
            return response([
                'success' => false,
                'data' => 'This email is not a registered user!'], 200
            );
        }

        $token = Token::create([
                'user_id' => $user->id,
                'token' => uniqid(),
                'expire_at' => Carbon::now()->addHour()
        ]);

        Mail::to($user)->send(new ForgotPassword($token, $request));

        return response([
            'success' => true, 
            'data' => 'Email Sent.'
        ], 200);
    }

    /**
     * Handling the reset password email request    
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        if( $validator->fails()) {
            return response([
                'success' => false,
                'input' => true,
                'data' => $validator->errors()], 200
            );
        }

        $token = $request->input('token');

        $dbToken = DB::table('tokens')
                    ->where('token', $token)
                    ->where('expire_at', '>', Carbon::now())
                    ->first();

        if(!$dbToken) {
            return response([
                'success' => false,
                'token' => true,
                'data' => 'Invalid token. Please request another one!'], 200
            );
        }        

        $user = User::where('id', $dbToken->user_id)->first();

        $user->password = bcrypt($request->input('password'));

        $user->save();

        //Delete token after a successfull password reset.
        DB::table('tokens')
                    ->where('token', $token)
                    ->delete();

        return response([
            'success' => true, 
            'data'=>'Password was successfully changed!'
        ], 200);    
    }

}
