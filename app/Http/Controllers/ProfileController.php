<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

class ProfileController extends Controller
{
    //
    public function EditProfile(Request $request){
        // return $request;
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        
        if ($request->File('image')) {
            $imageName = date('YmdHis') . '.' . $request->image->getClientOriginalName();
            $path = public_path('upload/company_images');
        //    return public_path('upload/company_images');
            $request->image->move($path, $imageName);
            $user->avatar =  $imageName;
    	}

        $user->update();

        
        return response()->json([
            'message' => 'sucessfully update',
            'user' => $user
        ]);
    }

    public function changePass(Request $request){
        $validator = Validator::make($request->all(),[
       
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'c_password' => 'required|same:new_password',
        ]);
        if($validator->fails()){
            $response = [
                'status' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        
         $password = auth('sanctum')->user()->password;
        $old_pass = Hash::make($request->old_password);
        $new_pass = Hash::make($request->new_password);

        if(Hash::check($request->old_password, auth('sanctum')->user()->password)){
            $user = User::find(auth('sanctum')->user()->id);
            $user->password = Hash::make(\request('new_password'));
            $user->update();
            Auth::logout();

            return response([
                'message' => 'password change successfully',
            ]);
        }else{
            return response([
                'message' => 'Old Password Does Not Match!!!',
            ]);
        }

  

    }
}
