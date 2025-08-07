<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['user_id', 'subject', 'message', 'file_url'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function answer()
    {
        return $this->hasOne(Answer::class);
    }
}
