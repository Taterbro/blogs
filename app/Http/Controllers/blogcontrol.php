<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\blogs;

class blogcontrol extends Controller
{
    public function blogs(){
        if (!Auth::check()){
            return redirect('/');
        }
        $posts = blogs::all();
        return view('mainPage', ['posts'=>$posts, ]);
    }

    public function myblogs(){
        if (!Auth::check()){
            return redirect('/');
        }
        $posts = blogs::where('user_id', Auth::id())->get();
        return view('myblogs',['myposts' => $posts]);
    }

    public function addblog(Request $request)  {
        $author = Auth::user()->name;
        $date = Carbon::now()->toDateTimeString();

        $data = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $data['user_id'] = Auth::id();
        $data['date'] = $date;
        $data['author'] = $author;
        blogs::create($data);

            return redirect('/myblogs');
        }
     
    public function bloginfo(blogs $blog){
        if ($blog['user_id'] == Auth::id()){
            return view('mybloginfo', ['post' => $blog]);
        }
        return view('bloginfo', ['post'=> $blog]);

    }
    public function deleteblog(blogs $blog){
        if($blog['author'] = Auth::id()){
            $blog->delete();
            return redirect('/blogs');
        }
        else{
            return redirect('/blogs');
        
        }
        
        }
    

}
