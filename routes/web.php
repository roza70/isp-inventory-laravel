<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloIspController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-isp', [HelloIspController::class, 'index']);