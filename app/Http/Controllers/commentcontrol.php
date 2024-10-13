<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\blogs;
use Carbon\Carbon;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Facades\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Validation\Rule;
use App\Models\comments;


class commentcontrol extends Controller
{
    public function addcomment(Request $request, blogs $blog){
        $id = $blog['id'];
        $data = $request->validate([
            'comment' => 'required'
        ]);
        $comment = new comments;
        $comment->comment = $data['comment'];
        $comment->user_id = $request->user()->id;
        $comment->blogs_id = $id;
        $comment->written_by = $request->user()->name;
        $comment->save();
        return response()->json(['status'=>200, 'message'=> 'comment uploaded']);
    }

    public function getcomment(Request $request, blogs $blog) {
        $comments = comments::where('blogs_id', $blog->id)->get();
        return response()->json(['status'=>200, 'message'=>$comments]);
        
    }

    public function editcomment(Request $request, comments $comment){
        $user = $request->user();
        if ($request->user()->tokenCan('edit') && $user->id == $comment->user_id){
        $data = $request->validate([
            'comment' => 'required'
        ]);
        $comment->update(['comment'=>$data['comment']]);
        return response()->json(['status'=>200,'message'=>'comment edited']);
    }
    else{
        return response()->json(['message'=>'unauthorized', 'status'=>422]);
    }
}

public function deletecomment(Request $request, comments $comment){
    $user = $request->user();
    if ($request->user()->tokenCan('delete') && $user->id == $comment->user_id){
    $comment->delete();
    return response()->json(['status'=>200,'message'=>'murked him']);
}
else{
    return response()->json(['message'=>'unauthorized', 'status'=>422]);
}
}
    
}
