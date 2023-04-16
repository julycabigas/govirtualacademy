<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\CoursePermissions;

class RolesController extends Controller
{
    public function all()
    {
    	$roles = Role::all();

    	return response()->json([
    			'roles' => $roles
    	], 200);
    }

}
