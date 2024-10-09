<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\blogs;
use Carbon\Carbon;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Facades\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;

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
            $blog->author = 'nil';
            $blog->date = Carbon::now()->toDateTimeString();

            $blog->save();

            $data=[
                'status'=>200,
                'message'=>'uploaded with ease'
            ];
            return response()->json($data,200);
        }
        }

        public function editblog(Request $request, $id){

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
                $blog = blogs::find($id);
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

        public function deleteblog($id){
            $blog = blogs::find($id);
            $blog->delete();

            return response()->json(['status'=>200,'message'=>'murked him' ], 200);
        }
}
