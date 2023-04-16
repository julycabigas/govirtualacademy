<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{

    public function all()
    {
    	$settings = Setting::all();

    	return response()->json([
    		 'settings' => $settings
    	], 200);
    }

    public function update(Request $request)
    {

        $setting = User::find($id);

        $setting->update($request->all());

        return response()->json([
                'setting' => $setting
        ], 200);	
    }

}
