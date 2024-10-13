<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\blogs;
use App\Models\comments;
use App\Models\likes;

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
        $comments = comments::where('blogs_id', $blog->id)->get();
        if ($blog['user_id'] == Auth::id()){
            return view('mybloginfo', ['post' => $blog]);
        }
        return view('bloginfo', ['post'=> $blog, 'comments'=>$comments]);

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
    public function comment(Request $request, blogs $blog){
        $id = $blog['id'];
        $data = $request->validate([
            'comment' => 'required'
        ]);
        $comment = new comments;
        $comment->comment = $data['comment'];
        $comment->user_id = Auth::id();
        $comment->blogs_id = $id;
        $comment->written_by = Auth::user()->name;
        $comment->save();
        return redirect("/bloginfo/{$id}",);
    }
    public function editcomment(comments $comment){
        if(Auth::id() != $comment['user_id']){
            return redirect()->back();
        }
        return view('editcomment', ['comment'=>$comment]);
    }
    public function actuallyEdit(Request $request, comments $comment){
        if(Auth::id() != $comment['user_id']){
            return redirect()->back();
        }
        $data = $request->validate([
            'comment' => 'required'
        ]);
        $comment->update(['comment'=>$data['comment']]);
        return redirect()->back()->with('message', 'comment edit successful');
    }
    
        
}
    


