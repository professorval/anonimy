<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Providers\RouteServiceProvider;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Validator;


    class RegistrationController extends Controller
    {
        public function __construct()
        {
            $this->middleware('guest');
        }

        protected function create(Request $request)
        {
            $data = $request->all();
            $validation = Validator::make($data, [
                'name' => ['required', 'string', 'max:64'],
                'email' => ['required', 'string', 'email', 'max:128', 'unique:users'],
                'dob' => ['required','string', 'max:32'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validation->fails()) {
                return [
                    'status' => false,
                    'errors' => $validation->errors()
                ];
            }
            else{
                //-- generate a random string to use as username
                $randomString = Str::random(10);

                //-- ensure $randomString does not exist in the database
                while(User::where('username', $randomString)->exists()){
                    $randomString = Str::random(10);
                }

                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'dob' => $data['dob'],
                    'username' => $randomString,
                    'password' => Hash::make($data['password']),
                ]);

                return response()->json([
                    'status' => true,
                    'message' => trans('general.reg_complete'),
                    //'data' => $user
                ]);
                
            }
        }
    }