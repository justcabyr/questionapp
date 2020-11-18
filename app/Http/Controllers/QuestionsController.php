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


    // Consuming endpoint

    public function createData(Request $request)
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

       

		$client = new Client([
			'headers' => [
				"Content-Type" => "application/json",
				"Authorization" => "Bearer ".Auth::User()->access_token
			],
		]);

		try{
			$response = $client->request($method, config('app.api_base_url').'store',
				[
				'json' => [
                  
                    'question' => $request->input('question'),
                    'categories' => $request->input('categories'),
                    'choice_1' => $request->input('choice_1'),
                    'is_correct_choice_1' => $request->input('is_correct_choice_1'),
                    'choice_2' => $request->input('choice_2'),
                    'is_correct_choice_2' => $request->input('is_correct_choice_2'),
                    'choice_3' => $request->input('choice_3'),
                    'is_correct_choice_3' => $request->input('is_correct_choice_3'),
                    'choice_4' => $request->input('choice_4'),
                    'is_correct_choice_4' => $request->input('is_correct_choice_4'),
                ]
				]
			);
			$statusCode = $response->getStatusCode();
			$body = $response->getBody()->getContents();
			$result = json_decode($body);

		} catch(\Exception $e){
			// Auth::logout();
			// return redirect('')->with('error', 'Token is Expired');
		}
        if ($result->status == 200) {
            return  view('welcome');
        }

        return redirect()->back()->with('error', 'Oops! Something went wrong');

	}

	public function updateData($method, $body, $url)
	{
		$client = new Client([
			'headers' => [
				"Content-Type" => "application/json",
				"Authorization" => "Bearer ".Auth::User()->access_token
			],
		]);

		try{
			$response = $client->request($method, config('app.api_base_url').$url,
				[
				'json' => $body
				]
			);
			$statusCode = $response->getStatusCode();
			$body = $response->getBody()->getContents();
			$result = json_decode($body);

		} catch(\Exception $e) {
			
			Auth::logout();
			return redirect('security/login')->with('error', 'Token is Expired');
        }
        
        if ($result->status == 200) {
            return  view('welcome');
        }

        return redirect()->back()->with('error', 'Oops! Something went wrong');

		
	}

	public function listData($method, $body, $url)
	{
		$client = new Client([
			'headers' => [
				"Content-Type" => "application/json",
				"Authorization" => "Bearer ".Auth::User()->access_token
			],
		]);

		try{
			$response = $client->request($method, config('app.api_base_url').$url,
				[
				'json' => $body
				]
			);
			$statusCode = $response->getStatusCode();
			$body = $response->getBody()->getContents();
			$result = json_decode($body);
			
		} catch(\Exception $e) {
			Auth::logout();
		
			return redirect('security/login')->with('error', 'Token is Expired');
			
		}
		
		return $result;
	}

	public function findById($method, $body, $url)
	{
		$client = new Client([
			'headers' => [
				"Content-Type" => "application/json",
				"Authorization" => "Bearer ".Auth::User()->access_token
			],
		]);

		try{
			$response = $client->request($method, config('app.api_base_url').$url,
				[
				'json' => $body
				]
			);
			$statusCode = $response->getStatusCode();
			$body = $response->getBody()->getContents();
			$result = json_decode($body);

		} catch(\Exception $e) {
			Auth::logout();
			return redirect('security/login')->with('error', 'Token is Expired');
		}
		
		return $result;
    }
    
    public function deleteById($method, $body, $url)
    {
		$client = new Client([
			'headers' => [
				"Content-Type" => "application/json",
				"Authorization" => "Bearer ".Auth::User()->access_token
			],
		]);

		try{
			$response = $client->request($method, config('app.api_base_url').$url,
				[
				'json' => $body
				]
			);
			$statusCode = $response->getStatusCode();
			$body = $response->getBody()->getContents();
			$result = json_decode($body);

		} catch(\Exception $e) {
			Auth::logout();
			return redirect('security/login')->with('error', 'Token is Expired');
		}
		
		return $result;
	}
	
	public function viewData($method, $body, $url)
	{
		$client = new Client([
			'headers' => [
				"Content-Type" => "application/json",
				"Authorization" => "Bearer ".Auth::User()->access_token
			],
		]);
		
		try{
			$response = $client->request($method, config('app.api_base_url').$url,
				[
				'json' => $body
				]
        	);
			$statusCode = $response->getStatusCode();
			$body = $response->getBody()->getContents();
			
			$result = json_decode($body);
		
		} catch(\Exception $e) {
			Auth::logout();
			return redirect('security/login')->with('error', 'Token is Expired');
		}	
		return $result;
    }
}
