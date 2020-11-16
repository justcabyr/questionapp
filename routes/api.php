<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;
use App\Http\Controllers\QuestionsController;

Route::get('/questions', [QuestionsController::class, 'index']);
Route::post('/store', [QuestionsController::class, 'store']);
Route::get('/show/{id}', [QuestionsController::class, 'show']);
// Route::get('/edit', [QuestionsController::class, 'edit']);
Route::patch('/update/{id}', [QuestionsController::class, 'update']);
Route::delete('/delete/{id}', [QuestionsController::class, 'destroy']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
