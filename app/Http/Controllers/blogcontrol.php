<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class blogcontrol extends Controller
{
    public function blogs(){
        if (!Auth::check()){
            return redirect('/');
        }
        $posts = Http::get('http://localhost:3000/blogs')->json();
        return view('mainPage', ['posts'=>$posts, ]);
    }

    public function myblogs(){
        if (!Auth::check()){
            return redirect('/');
        }
        $posts = Http::get('http://localhost:3000/blogs')->json();
        $myposts = [];
        for ($i=0;$i<count($posts);$i++){
            if ($posts[$i]['author'] == Auth::user()->name){
                $myposts[] = $posts[$i];
            }
        }
        return view('myblogs',['myposts' => $myposts]);
    }

    public function addblog(Request $request)  {
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $author = Auth::user()->name;
        $date = Carbon::now()->toDateTimeString();
        $response = Http::post('http://localhost:3000/blogs', [
            'title' => $data['title'],
            'body' => $data['body'],
            'author' => $author,
            'date' => $date
        ]);
        if ($response->successful()){
            return redirect('/myblogs');
        }
        else{
            return response()->json(['message'=>'failed to add post.'], $response->status());
        }
    }
    public function bloginfo($id){
        $post =  Http::get("http://localhost:3000/blogs/{$id}")->json();
        if ($post['author'] == Auth::user()->name){
            return view('mybloginfo', ['post' => $post]);
        }
        return view('bloginfo', ['post'=> $post]);

    }
    public function deleteblog($id){
        $post =  Http::get("http://localhost:3000/blogs/{$id}")->json(); //just doing this to check for author name
        if(Auth::user()->name != $post['author']){
            return redirect('/blogs');
        }
        else{
            $response=Http::delete("http://localhost:3000/blogs/{$id}")->json();
            return redirect('/myblogs');
        
        }
        
        }
    

}
