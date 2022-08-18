<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function registerCompany(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required',
            'address' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }


        // $input = $request->all();
        $company = new User();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->password = bcrypt($request->password);
        $company->phone = $request->phone;
        $company->address = $request->address;
        
        if ($request->hasFile('image')) {
    		$file = $request->file('image');
    		$filename = date('YmdHi').$file->getClientOriginalName();
    		$file->move(public_path('upload/company_images'),$filename);
    		$company->avatar = $filename;
    	}

        $company->save();
        // $company = User::create($input);
        $role = Role::findById(2);
        $company->assignRole($role);

        $success['token'] = $company->createToken('MyApp')->plainTextToken;
        $success['name'] = $company->name;
        $success['role'] = $role->name;
       
        

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'Company successfully Register',
            'user'  => $company,
        ];
        return response()->json($response, 200);
    }
}
