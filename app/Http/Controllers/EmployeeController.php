<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
        // Empoyee 
        public function registerEmployee(Request $request){

            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'c_password' => 'required|same:password',
            ]);
            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => $validator->errors()
                ];
                return response()->json($response, 400);
            }
            //$input = $request->all();
            $employee = new User();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password);
            $employee->phone = $request->phone;
            $employee->address = $request->address;

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('upload/company_images'),$filename);
                $employee['avatar'] = $filename;
            }
            $employee->save();
            // $input['password'] = Hash::make($input['password']);
            // $empoyee = User::create($input);
            $role = Role::findById(3);
            $employee->assignRole($role);
    
            $success['token'] = $employee->createToken('MyApp')->plainTextToken;
            $success['name'] = $employee->name;
            $success['role'] = $role->name;
          
           
            
    
            $response = [
                'success' => true,
                'user' => $employee,
                'data' => $success,
                'message' => 'Employee successfully Register',
            ];
            return response()->json($response, 200);
        }
}
