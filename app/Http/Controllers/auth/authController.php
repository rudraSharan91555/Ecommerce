<?php
namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => 200,
                'message' => 'Successfully logged in'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid credentials'
            ]);
        }
    }
}

