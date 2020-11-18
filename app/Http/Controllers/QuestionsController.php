<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Models\Question;
use Validator;

class QuestionsController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('created_at', 'desc')->get();
        return response()->json([
            'questions' => $questions,
            'status' => 200
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
        'question' => 'required',
        'categories' => 'required',
        'choice_1' => 'required',
        'is_correct_choice_1' => 'required',
        'choice_2' => 'nullable',
        'is_correct_choice_2' => 'required',
        'choice_3' => 'nullable',
        'is_correct_choice_3' => 'required',
        'choice_4' => 'nullable',
        'is_correct_choice_4' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $question = new Question();
        $question->question = $request->input('question');
        $question->categories = $request->input('categories');
        $question->choice_1 = $request->input('choice_1');
        $question->is_correct_choice_1 = $request->input('is_correct_choice_1');
        $question->choice_2 = $request->input('choice_2');
        $question->is_correct_choice_2 = $request->input('is_correct_choice_2');
        $question->choice_3 = $request->input('choice_3');
        $question->is_correct_choice_3 = $request->input('is_correct_choice_3');
        $question->choice_4 = $request->input('choice_4');
        $question->is_correct_choice_4 = $request->input('is_correct_choice_4');

        if($question->save()){
            return response()->json([
                'status' => 200,
                'question' => $question,
                'message' => 'Record created'
            ]);
        }
        return response()->json([
            'status'=> 400,
            'message'=> 'An error occured.'
        ]);

        $token = JWTAuth::fromQuestion($question);

        return response()->json(compact('question','token'),201);

    }

    public function show($id)
    {
        $question = Question::find($id);
        return response()->json(['question' => $question]);
    }

    // public function edit($id)
    // {
    //     $question = Question::find($request->id);
        
    //     return response()->json(['question' => $question]);
    // }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
        'question' => 'required',
        'categories' => 'required',
        'choice_1' => 'required',
        'is_correct_choice_1' => 'required',
        'choice_2' => 'nullable',
        'is_correct_choice_2' => 'required',
        'choice_3' => 'nullable',
        'is_correct_choice_3' => 'required',
        'choice_4' => 'nullable',
        'is_correct_choice_4' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $question = Question::find($request->id);
        $question->question = $request->input('question');
        $question->categories = $request->input('categories');
        $question->choice_1 = $request->input('choice_1');
        $question->is_correct_choice_1 = $request->input('is_correct_choice_1');
        $question->choice_2 = $request->input('choice_2');
        $question->is_correct_choice_2 = $request->input('is_correct_choice_2');
        $question->choice_3 = $request->input('choice_3');
        $question->is_correct_choice_3 = $request->input('is_correct_choice_3');
        $question->choice_4 = $request->input('choice_4');
        $question->is_correct_choice_4 = $request->input('is_correct_choice_4');

        if($question->save()){
            return response()->json([
                'status' => 200,
                'question' => $question,
                'message' => 'Record created'
            ]);
        }
        return response()->json([
            'status'=> 400,
            'message'=> 'An error occured.'
        ]);
    }

    public function destroy($id)
    {
        $question = Question::find($id);

        if($question->delete()){
            return response()->json([
                'status' => 200,
                'message' => 'Record deleted'
            ]);
        }
        return response()->json([
            'status'=> 400,
            'message'=> 'An error occured.'
        ]);
    }
}
