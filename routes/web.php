<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\CursoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashBoardController::class, 'index']);
Route::resource('curso', CursoController::class);