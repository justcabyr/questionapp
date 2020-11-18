<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ExcelUploadController;

// Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group( function(){
    Route::get('/questions', [QuestionsController::class, 'index']);
    Route::post('/store', [QuestionsController::class, 'store']);
    Route::get('/show/{id}', [QuestionsController::class, 'show']);
    Route::patch('/update/{id}', [QuestionsController::class, 'update']);
    Route::delete('/delete/{id}', [QuestionsController::class, 'destroy']);    
});
