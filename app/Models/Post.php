<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

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
}
