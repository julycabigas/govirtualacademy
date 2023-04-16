<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccessLevel;
use App\Course;
use App\Video;
use App\User;
use App\Purchase;

class StatController extends Controller
{
    
    public function allTraining()
    {
        $accesslevels = AccessLevel::where('type', 'bundle')->count();
    
        return response()->json([
            "total" => $accesslevels
        ], 200);
    }

    public function allCourses()
    {
        $totals = Course::where('status', 'publish')->count();
    
        return response()->json([
            "total" => $totals
        ], 200);
    }

    public function allVideos()
    {
        $totals = Video::count();
    
        return response()->json([
            "total" => $totals
        ], 200);
    }


    public function allStudents()
    {
        $totals = User::where('role','!=', 1)->count();
    
        return response()->json([
            "total" => $totals
        ], 200);
    }

    public function allPurchased()
    {
        $purchases = Purchase::where('status','=','approved')->get();
        $totals = 0;

        foreach($purchases as $purchase) {
        	$totals = $totals + $purchase['amount'];
        }
    
        return response()->json([
            "total" => $totals
        ], 200);
    }


    public function allPendingPurchased()
    {
        $purchases = Purchase::where('status','=','pending')->get();
        $totals = 0;

        if( $purchases ) {
            foreach($purchases as $purchase) {
                $totals = $totals + $purchase['amount'];
            }
        } 
        else {
            $totals = 0;
        }
    
        return response()->json([
            "total" => $totals
        ], 200);
    }

}
