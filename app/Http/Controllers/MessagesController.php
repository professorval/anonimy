<?php
    namespace App\Http\Controllers;

    use Validator;
    use App\Http\Controllers\Controller;
    use App\Models\Thread;
    use App\Models\Message;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    class MessagesController extends Controller {
        public function __construct()
        {
            $this->middleware('guest');
        }

        protected function create(Request $request){
            $data = $request->all();

            $validation = Validator::make($data, [
                'slug' => ['required', 'string', 'max:512'],
                'content' => ['required', 'string', 'min:5'],
            ]);

            $thread = Thread::where('slug', '=', $request->slug)->firstOrFail();

            if ($validation->fails()) {
                return [
                    'status' => false,
                    'errors' => $validation->errors()
                ];
            }
            else{
                try {
                    $message = new Message();
                    $message->thread_id = $thread->id;
                    $message->content = $request->content;
                    $message->save();

                    return response()->json([
                        'status' => true,
                        'message' => trans('general.message_saved'),
                    ]);

                }
                catch (\Exception $e) {
                    return ['status' => false];
                }
            }
        }
    }
        