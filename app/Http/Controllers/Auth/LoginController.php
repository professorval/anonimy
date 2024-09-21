<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //$this->middleware('guest')->except('logout');
    }


    public function login(Request $request): Mixed
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            //-- return session data as json
            return response()->json([
                'status' => true,
                'session' => $request->session()->all(),
            ]);
        }
 
        return response()->json([
            'status' => false,
            'message' => trans('general.login_invalid')
        ]);
    }

    public function sessionStatus(){

        if(Auth::user()){
            return response()->json([
                'status' => true,
                'user' => Auth::user()
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'user' => null
            ]);
        }
        
    }
  
    public function logout () {

        if( auth()->user() ){
            auth()->logout();
        }
        
        return response()->json([
            'status' => true,
            'message' => trans('general.logged_out')
        ]);
    }

}
