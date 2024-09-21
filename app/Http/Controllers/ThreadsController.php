<?php
    namespace App\Http\Controllers;

    use Validator;
    use App\Http\Controllers\Controller;
    use App\Models\Thread;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    class ThreadsController extends Controller {
        
        public function __construct()
        {
            $this->middleware('auth');
        }

        protected function create(Request $request){
            $data = $request->all();

            $validation = Validator::make($data, [
                'title' => ['required', 'string', 'max:512'],
            ]);

            if ($validation->fails()) {
                return [
                    'status' => false,
                    'errors' => $validation->errors()
                ];
            }
            else{
                try {

                    //-- generate a random string to use as username
                    $randomString = Str::random(8);

                    //-- ensure $randomString does not exist in the database
                    while(Thread::where('slug', $randomString)->exists()){
                        $randomString = Str::random(8);
                    }

                    $thread = new Thread();
                    $thread->title = $data['title'];
                    $thread->slug = $randomString;
                    $thread->user_id = Auth::user()->id;
                    $thread->save();

                    return response()->json([
                        'status' => true,
                        'message' => trans('general.thread_created'),
                        'thread' => $thread
                    ]);

                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => false,
                        'message' => $th->getMessage()
                    ]);
                }
            }
        }
    }