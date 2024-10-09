<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogs extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'user_id', 'author', 'date'];
    
    protected $attributes =[
        'user_id' => 1
    ];
}
