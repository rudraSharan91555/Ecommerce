<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\auth\authController as AuthAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('admin/index');
// });

Route::get('/login', function () {
    return view('auth/signIn');
});

Route::post('/login_user',[AuthAuthController::class,'loginUser']);

Route::get('/logout',function (){
    Auth::logout();
    return redirect('/login') ;
});