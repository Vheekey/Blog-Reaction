<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class SetUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(! isset($_COOKIE['guest_token'])){
            $token = $this->generateToken();

            setcookie('guest_token', $token, time()+3600*24*30, '/');
        }

        return $next($request);
    }

    protected function generateToken()
    {
        do {
            $token = strtoupper(Str::random());

            $exists = User::where('guest_token', $token)->exists();
        } while ($exists);

        User::create(['guest_token' => $token]);

        return $token;
    }
}
