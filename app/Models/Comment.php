<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        "reactions" => "array"
    ];

    protected static function booted()
    {
        $token = $_COOKIE['guest_token'] ?? getCookieImmediately();

        static::creating(function($comment) use($token){
            $comment->user_id = User::where('guest_token', $token)->value('id');
        });

        static::updating(function($comment_update) use($token){
            $comment_update->user_id = User::where('guest_token', $token)->value('id');
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
