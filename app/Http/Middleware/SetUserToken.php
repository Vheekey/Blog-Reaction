<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

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
        $cookie = $request->cookie('guest_token');

        if(is_null($cookie)){
            $token = $this->generateToken();

            Cookie::create('guest_token', $token);
        }

        return $next($request);
    }

    protected function generateToken()
    {
        do {
            $token = strtoupper(Str::random());

            $exists = User::where('guest_token', $token)->exists();
        } while ($exists);

        return $token;
    }
}
