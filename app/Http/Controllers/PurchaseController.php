<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\AccessItem;
use App\Mail\CoursePurchase;
use Mail;
use DB;

class PurchaseController extends Controller
{

	public function all()
    {
    	$purchases = Purchase::with(['user'])
                    ->where('status', '!=', 'deleted' )
                    ->orderby('created_at', 'DESC')->paginate(5);
    
    	return response()->json([
    		"purchases" => $purchases
    	], 200);
        
    }


    public function allApproved()
    {
        $purchases = Purchase::with(['user'])
                     ->where('status', '=', 'approved')
                     ->orderby('created_at', 'DESC')
                     ->paginate(10);
    
        return response()->json([
            "purchases" => $purchases
        ], 200);
    }

    public function allPending()
    {
        $purchases = Purchase::with(['user'])
                    ->where('status',  '=','pending')
                    ->orderby('created_at', 'DESC')
                    ->paginate(5);
    
        return response()->json([
            "purchases" => $purchases
        ], 200);
    }

    /**
     * Get purchase
     * @param  [type] $id purchase id
     * @return [type]     json array
     */
    public function get($id)
    {
        $purchase = Purchase::with(['user', 'access'])->where('id', $id)->first();
    
        return response()->json([
            "purchase" => $purchase
        ], 200);
    }

    /**
     * Get User's purchases
     * @param  [type] $id user id
     * @return [type]     json array
     */
    public function getMyPurchases($id)
    {
        $purchases = DB::table('purchases')
                        ->leftjoin('access_levels' ,'access_levels.id','=','purchases.access_id') 
                        ->select('purchases.*', 'access_levels.display_name')   
                        ->where('purchases.user_id', $id)
                        ->orderby('created_at', 'DESC')
                        ->get();
    
        return response()->json([
            "purchases" => $purchases
        ], 200);
    }



    public function new(Request $request) 
    {
      $purchase = Purchase::create($request->only(["user_id","amount","status","payment_method","access_id","notes"]));

        return response()->json([
            "purchase" => $purchase,
            "message" => "Thank you! Purchase has been saved successfully"
        ], 200); 

    }

    public function delete($id) 
    {
        $purchase = Purchase::find($id)->delete();

        return response()->json([
            'message' => 'Purchase deleted successfully!'
        ]);
    }

    public function update($id, Request $request)
    {

        $purchase = Purchase::find($id);

        $purchase->update([
            'user_id'        => $request->user_id,
            'amount'         => $request->amount,
            'status'         => $request->status,
            'payment_method' => $request->payment_method,
            'access_id'      => $request->access_id,
            'notes'          => $request->notes
        ]);


        if($request->status === 'approved') {

        	$access = AccessItem::create([
        			'user_id' => $request->user_id,
        			'access_id' => $request->access_id
        	]);

            $user_email = DB::table('users')->where('id', $request->user_id)->value('email');

            Mail::to($user_email)->send(new CoursePurchase($purchase));
        }


    	return response()->json([
    		"purchase" => $purchase,
            "message" => "Thank you! Purchase has been updated successfully"
    	], 200);
    }


    public function approvePayment($id, Request $request)
    {


            $purchase = Purchase::find($id);

            $purchase->update([
                'status'         => $request->status,
            ]);

            $access = AccessItem::create([
                    'user_id' => $request->user_id,
                    'access_id' => $request->access_id
            ]);

            $user_email = DB::table('users')->where('id', $request->user_id)->value('email');

            Mail::to($user_email)->send(new CoursePurchase($purchase));
        

            return response()->json([
                "message" => "Thank you! Purchase has been updated successfully"
            ], 200);
    }

}
