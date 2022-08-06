<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends ApiController
{
    public function index(){
        $permissions = Permission::all();
        $roles=Role::all();
        return $this->successResponse([
            'permissions' => PermissionResource::collection($permissions),'roles'=>RoleResource::collection($roles)
        ], 200);
    
    }


     public function store(Request $request){
         Permission::create([
             'name'=>$request->name,
             'display_name'=>$request->display_name,
             'guard_name'=>'api',
         ]);
         return response('registered');
     }
     public function assignPermission(Request $requset){

         $role =Role::find($requset->role);
         $permissions=$requset->permissions;
        $role->givePermissionTo($permissions);

        return response('registered');
     }
}
