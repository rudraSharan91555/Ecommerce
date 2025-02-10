<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponse;
use Hash;
use Illuminate\Support\Facades\Validator;
class authController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
{
    $validation = Validator::make($request->all(), [
        'name'    => 'required|string|max:255',
        'email'   => 'required|string|email|unique:users,email',
        'password' => 'required|string|min:6'
    ]);

    if ($validation->fails()) {
        return $this->error($validation->errors()->first(), 400, []);
    }

    $user = User::create([
        'name' => $request->name,
        'password' => bcrypt($request->password),
        'email' => $request->email
    ]);

    $customer = Role::where('slug', 'customer')->first();
    $user->roles()->attach($customer);

    return $this->success([
        'token' => $user->createToken('API Token')->plainTextToken
    ], 'Registration successful');
}




    function loginUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string'
        ]);
        
        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => $validation->errors()->first()]);
        } else {
            $cred = array('email' => $request->email, 'password' => $request->password);
           
            if (Auth::attempt($cred, false)) {
                if (Auth::User()->hasRole('admin')) {
                    return response()->json(['status' => 200, 'message' => 'Admin User', 'url' => 'admin/dashboard']);
                } else {
            
                    $user = User::where('id',Auth::User()->id)->first();
                    $user['token'] = $user->createToken('API Token')->plainTextToken;
                    // return response()->json(['status'=>200,'message'=>'Succesfull login']);
                    return $this->success(
                        ['user' => $user],
                        'succesfull login'
                    );
                }
            } else {
                return response()->json(['status' => 404, 'message' => 'Wrong Cred']);
            }
        }
    }

   
}
