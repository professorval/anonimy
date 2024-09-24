<?php
    namespace App\Http\Controllers;

    use Validator;
    use App\Http\Controllers\Controller;
    use App\Models\Thread;
    use App\Models\Message;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    class ThreadsController extends Controller {
        
        public function __construct()
        {
            //-- make get_thread available for all users but other methods need authentication
            $this->middleware('auth')->except(['get_thread']);
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

        public function get_threads() {
            //-- get all threads belonging to this user
            try {
                $user = Auth::user();
                $threads = Thread::where('user_id', $user->id)->get()->toArray();
                
                return response()->json([
                    'status' => true,
                    'data' => $threads
                ]);

            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ]);
            }
        }

        public function get_thread(Request $request){
            try{
                $user = Auth::user();
                $thread = Thread::where('slug', '=', $request->slug)
                    ->join('users', 'threads.user_id', '=', 'users.id')
                    ->select('threads.*', 'users.name as user_name')
                    ->firstOrFail();

                if(Auth::user() && Auth::user()->id === $thread->user_id){
                    return response()->json([
                        'status' => true,
                        'owner' => true,
                        'data' => [
                            'thread' => $thread,
                            'messages' => Message::where('thread_id', '=', $thread->id)->get(),
                        ]
                    ]);
                }
                else{
                    return response()->json([
                        'status' => true,
                        'data' => [
                            'thread' => $thread,
                        ]
                    ]);
                }

                
                
            }
            catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ]);
            }
        }
    }