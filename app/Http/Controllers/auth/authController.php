<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class authController extends Controller
{
    function loginUser(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|string|email|exists::users,email',
            'password' => 'required|string|min:6'
        ]);

        print_r($validation); die();
    }
}
