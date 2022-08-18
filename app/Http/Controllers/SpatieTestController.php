<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class SpatieTestController extends Controller
{
    //
    public function index(){

    //     $role = Role::create([
    //         // 'name' => 'admin',
    //         // 'name' => 'company',
    //         // 'name' => 'employee'
    // ]);
        // $permission = Permission::create([
        //     'name' => 'add Company',
        //     // 'name' => 'add employee',   
        // ]);

        $role = Role::findById(2);
        $permission = permission::findById(1);

        $role->givePermissionTo($permission);
    }
}
