<?php

use App\Http\Controllers\Admin\profileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin/index');
});  

Route::get('/profile',[profileController::class,'index']);
