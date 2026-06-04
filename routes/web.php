<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashBoardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashBoardController::class, 'index']);