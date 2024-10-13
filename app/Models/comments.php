<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $fillable = ['comment'];
    protected $attributes =[
        'written_by' => 'unknown'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function blogs(){
        return $this->belongsTo(blogs::class);
    }
}
