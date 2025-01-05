<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\auth\authController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\Admin\profileController;
use App\Http\Controllers\Admin\homeBannerController;





Route::middleware([AdminAuth::class])->group(function() {
    Route::get('/', function () {
        return view('admin/index');
    });
    
});



Route::get('/login', function () {
    return view('auth/signIn');
});

Route::post('/login_user',[authController::class,'loginUser']);
Route::get('/profile', [profileController::class, 'index'])->name('profile.index');

Route::post('/admin/saveProfile', [ProfileController::class, 'store'])->name('profile.store');

Route::get('admin/home_banners',[homeBannerController::class,'index']);


Route::post('/admin/updateHomebanner', [homeBannerController::class, 'store'])->name('admin.updateHomebanner');

// Delet fuunction

Route::delete('/deletData/{id}/{table}', [HomeBannerController::class, 'deletData']);



Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
});
