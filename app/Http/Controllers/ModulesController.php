<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;

class ModulesController extends Controller
{
    public function all()
    {
        $modules = Module::with('group')
            ->orderBy('menu_order', 'menu_order')->get();

    	return response()->json([
    		"modules" => $modules
    	], 200);
    }

    public function list()
    {
        $modules = Module::with('group')
            ->orderBy('name', 'desc')->paginate(10);

    	return response()->json([
    		"modules" => $modules
    	], 200);
    }

    public function get($id)
    {
        $module = Module::find($id);

    	return response()->json([
    		"module" => $module
    	], 200);
    }

    /** Get modules by group id **/
    public function getModules($id)
    {

        $modules = Module::where('group_id','=', $id)
            ->orderBy('menu_order', 'asc')->get();

    	return response()->json([
    		"modules" => $modules
    	], 200);
    }

    public function add(Request $request) {

        $input = $request->module;

        $module = new Module;
        $module->name = strip_tags($input['name']);
        $module->menu_order = strip_tags($input['menu_order']);
        $module->status = strip_tags($input['status']);
        $module->group_id = strip_tags($input['group_id']);
        $module->save();
    
        return response()->json([
                  'module' => $module,
                  'success' => true
          ], 200);

    }

    public function update(Request $request, $id) {

        $module = Module::find($id);
        $input = $request->module;

        $module->name = strip_tags($input['name']);
        $module->menu_order = strip_tags($input['menu_order']);
        $module->status = strip_tags($input['status']);
        $module->group_id = strip_tags($input['group_id']);
        $module->save();
    
        return response()->json([
                  'module' => $module,
                  'success' => true
          ], 200);
    }


    public function delete($id) {

        $module = Module::find($id)->delete();

        return response()->json([
                'success' => true
        ], 200);
    }


}
