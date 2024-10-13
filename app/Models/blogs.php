<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogs extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'user_id', 'author', 'date'];
    
    
    public function user() {
        return $this->belongsTo(User::class);
        
    }
    public function comments(){
        return $this->hasMany(comments::class);
    }
    public function userswholiked(){
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
    public function islikedby($userid){
        return $this->userswholiked()->where('user_id', $userid)->exists();
    }
}
