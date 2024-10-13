<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likes extends Model
{
    use HasFactory;
    protected $fillable =['liked_by'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function blogs(){
        return $this->belongsTo(blogs::class);
    }
}
