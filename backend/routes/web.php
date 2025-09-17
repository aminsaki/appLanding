<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/music-results/{uid}', [\App\Http\Controllers\UserResultController::class, 'show']);



