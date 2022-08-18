<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Normal user
    public function register(Request $request){
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
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
       

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'user successfully Login',
        ];
        return response()->json($response, 200);
    }
    
    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth::user();
            $user_id = Auth::user()->id;
            $role_id = DB::table('model_has_roles')->where('model_id', $user_id)->first();
            
            $role = Role::findById($role_id->role_id);
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;
            $success['role'] = $role->name;
            
    
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Login successfully ',
                'user'  => $user
            ];
            return response()->json($response, 200);

        }else{
            $response = [
                'success' => false,
                'message' => 'unauthroized',
            ];
            return response()->json($response, 402);
        }
    }

    public function autUser(){
        $user =  auth()->user();
        $roleId = DB::table('model_has_roles')->where('model_id',auth()->user()->id)->first();
        $role = Role::findorFail($roleId->role_id);
        $role_name =  $role->name;

        return response()->json([
            'status'=> true,
            'role'=> $role_name,
            'message'=> "Authenticated user details!",
            'user'=> $user,
        ]);
    }
}
