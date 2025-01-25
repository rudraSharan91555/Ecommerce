<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Validator;
class authController extends Controller
{
    function loginUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string'
        ]);
        // EMail not present in DB
        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => $validation->errors()->first()]);
        } else {
            $cred = array('email' => $request->email, 'password' => $request->password);
            // Right Auth
            if(Auth::attempt($cred)) {
                if(Auth::User()->hasrole('admin')){
                return response()->json(['status' => 200, 'message' => "Admin User"]);                    
                }else{
                    return response()->json(["status"=> 200, "message"=> "Non User"]);
                }
            }else{
                return response()->json(['status'=> 404,'message'=> 'Wrong Cred']);
            }
        }
    }
}
