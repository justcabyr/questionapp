<?php

namespace App\Http\Controllers;

use App\Models\User;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers{
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials) == false) {
            return response()->json(['status' => 'error', 'message' => 'We cannot find an account with this email or password. Please check your details'], 401);
        }


        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => 'error', 'message' => 'We want to keep your account safe. Please check your email to verify your email address.'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Oops! we could not create token'], 500);
        }
        $user = User::where('email', $credentials['email'])->first();

        return response()->json(compact('token', 'user'));
    }


    // Consuming endpoint
    public function authenticateAdmin(Request $request)
    {
        $validator = Validator::make($request->all(),[
             'email' => 'required',
             'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
 
        $client = new Client();
        $response = $client->request('POST', config('app.api_base_url').'login',
            [
               'form_params' => [
                   'email' => $request->email,
                   'password' => $request->password
               ] 
            ]
        );
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $result = json_decode($body);
         
        $user = User::where('email',$result->user->email)->first();

        $credentials = $request->only('email', 'password');

        $user = User::updateOrCreate(['email' =>  $result->user->email],
        [  
            'user_id' =>  $result->user->id,
            'name' =>  $result->user->name,
            'access_token' =>  $result->token,
            'password' =>   bcrypt($request->get('password')),
          
        ]);

        Auth::attempt($credentials);

        return redirect(url('/dashboard'));
    }
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return view('auth.login');
    }

}