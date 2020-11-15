<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;

Route::group(['middleware' => 'api'], function(){
    Route::get('/index', 'QuestionsController@index');
    Route::post('/create', 'QuestionsController@store');
    Route::get('/edit', 'QuestionsController@edit');
    Route::patch('/update', 'QuestionsController@update');
    Route::delete('/delete', 'QuestionsController@destroy');

});

// Route::group(['middleware' => 'api'], function(){
//     //Fetch Questions
//     Route::get('questions', function(){
//         return Question::latest()->orderBy('created_at', 'desc')->get();
//     });

//     //Get Single Question
//     Route::get('question/{id}', function(){
//         return Question::findOrFail($id);
//     });

//     //Add Question
//     Route::post('question/store', function(Request $request){
//         return Question::create(['name' => $request->input(['name']), 'email' => $request->input(['email']), 'phone' => $request->input(['phone'])]);
//     });

//     //Update Question
//     Route::patch('question/{id}', function(Request $request, $id){
//         Question::findOrFail($id)->update(['name' => $request->input(['name']), 'email' => $request->input(['email']), 'phone' => $request->input(['phone'])]);
//     });

//     //Delete Question
//     Route::delete('question/{id}', function($id){
//         return Question::destroy($id);
//     });
// });


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
