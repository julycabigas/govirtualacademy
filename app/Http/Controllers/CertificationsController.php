<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certification;
use DB;
use App\Result;
use App\User;
use App\Mail\CourseCertificate;
use Illuminate\Support\Facades\Mail;

class CertificationsController extends Controller
{
    public function all()
    {
    	$certifications = Certification::with(['result','user','course'])->paginate(1);
    
    	return response()->json([
    		"certifications" => $certifications
    	], 200);
    }

    public function allRequest()
    {
        $certifications = Certification::with(['result','user','course'])
                                ->where('emailed', '=', 0)
                                ->paginate(5);
    
        return response()->json([
            "certifications" => $certifications
        ], 200);
    }
 
    public function get($id)
    {
    	$certification = Certification::with(['result','user','course'])->where('id',$id)->first();

      	return response()->json([
    		"certification" => $certification
    	], 200);
    }

    public function new(Request $request)
    {

        $check_result = DB::table('certifications')->where('result_id', $request->result_id)->get();

        if(!count($check_result)) {
            $certification = Certification::create($request->only(["result_id","emailed","course_id","user_id"]));
            //Mail::to($request->student['email'])->send(new CourseCertificate($request->student));
        } else {
            $certification = false;
        }
    	
    	return response()->json([
    		"certification" => $certification
    	], 200);
    }

    public function update($id, Request $request)
    {

        $certification = Certification::find($id);

        $certification->update($request->all());

        if($certification) {
            $updated = true;
        }

        return response()->json([
                'updated' => $updated
        ], 200);

    }

    public function delete($id) 
    {
        $certification = Certification::find($id)->delete();

        return response()->json([
            'message' => 'Certification deleted successfully!',
        ]);
    }
}
