<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\blogs;
use Carbon\Carbon;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Facades\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\User;
use App\Models\likes;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Validation\Rule;

class apicontroller extends Controller
{
    public function index(){
        $blogs = blogs::all();
        $data = [
            'status'=>200,
            'blogs' => $blogs
        ];
        return response()->json($data,200);
    }

    public function addblog(Request $request)  {
        if (request()->user()->tokenCan('add')){
            $validator = FacadesValidator::make($request->all(),[
                'title' => 'required',
                'body' => 'required'
            ]);
            if($validator->fails()){
                $data=[
                    'status'=>422,
                    'message'=>$validator->messages()
                ];
                return response()->json($data, 422);
            }
            else{
                $blog = new blogs;
                $blog->title = $request->title;
                $blog->body = $request->body;
                $blog->author = $request->user()->name;
                $blog->date = Carbon::now()->toDateTimeString();
                $blog->user_id = $request->user()->id;
    
                $blog->save();
    
                $data=[
                    'status'=>200,
                    'message'=>'uploaded with ease'
                ];
                return response()->json($data,200);
            }
        }
        else{
            return response()->json(['status'=>422, 'message'=>'access denied'],422);
        }
        
        }

        public function editblog(Request $request, blogs $id){
            $user = $request->user();
            if ($request->user()->tokenCan('edit') && $user->id == $id->user_id){
                $validator = FacadesValidator::make($request->all(),[
                    'title' => 'required',
                    'body' => 'required'
                ]);
                if($validator->fails()){
                    $data=[
                        'status'=>422,
                        'message'=>$validator->messages()
                    ];
                    return response()->json($data, 422);
                }
                else{
                    $blog = blogs::find($id->id);
                    $blog->title = $request->title;
                    $blog->body = $request->body;
                    $blog->save();
        
                    $data=[
                        'status'=>200,
                        'message'=>'updated with ease'
                    ];
                    return response()->json($data,200);
            }
            
            
            }
            else{
                return response()->json(['status'=>422, 'message'=>'access denied'],422);
            }
        }

        public function deleteblog(Request $request, blogs $id){
            $user = $request->user();
            if ($request->user()->tokenCan('delete') && $user->id == $id->user_id){
            $blog = blogs::find($id->id);
            $blog->delete();

            return response()->json(['status'=>200,'message'=>'murked him' ], 200);
        }
        else{
            return response()->json(['status'=>422, 'message'=>'access denied'],422);
        }
    }

        public function register(Request $request){
            $validated = FacadesValidator::make($request->all(),[
                'name' => ['required','min:3', 'max:10',Rule::unique('users', 'name')],
                'email' => ['required', 'email',Rule::unique('users', 'email')],
                'password' => ['required', 'min:8', 'max:16']
            ]);

            if($validated->fails()){
                $data=[
                    'status'=>422,
                    'message'=>$validated->messages()
                ];
                return response()->json($data, 422);
            }
            else{
                $user = new User;
                $user['name'] = $request->name;
                $user['email'] = $request->email;
                $user['password'] = bcrypt($request->password);
                $user->save();

                $token = $user->createToken('Token',['add','edit','delete'])->plainTextToken;

            $data=[
                'status'=>200,
                'message'=>'registered with ease',
                'token'=>$token
            ];
            return response()->json($data,200);
            
            }
           
            
        }
        
        public function ability(Request $request){
                $ability = $request->user()->currentAccessToken()->abilities;
                FacadesLog::info('token abilities: ', $ability);
                return response()->json(['status'=>422, 'message'=>'check logs, gang'], 422);
        }

       
            public function addlike(Request $request, blogs $blog){
                $userId =  $request->user()->id;
                if($blog->islikedby($userId)){
                    return response()->json(["status"=>422, "message"=>"you already like this post"],422);
                }
                else{
                    $like = new likes;
                    $like->user_id = $request->user()->id;
                    $like->blogs_id = $blog->id;
                    $like->liked_by = $request->user()->name;
                    $like->save();
                    return response()->json(["status"=>200, "message"=>"you liked this post"],200);
                }
                
                    
                    
            }
            public function unlike(Request $request, blogs $blog){
                $user =  $request->user();
                if($blog->islikedby($user->id)){
                    $user->unlike($blog->id);
                    return response()->json(["status"=>422, "message"=>"like removed"],200);
                }
                else{
                    response()->json(["status"=>422, "message"=>"you never liked this post"],422);
                }
            }
}
