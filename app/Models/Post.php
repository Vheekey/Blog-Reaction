<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        $token = $_COOKIE['guest_token'] ?? getCookieImmediately();

        static::creating(function($post) use($token){
            $post->user_id = User::where('guest_token', $token)->value('id');
        });

        static::updating(function($post_update) use($token){
            $post_update->user_id = User::where('guest_token', $token)->value('id');
        });
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
