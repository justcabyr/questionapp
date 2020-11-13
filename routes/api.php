<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
