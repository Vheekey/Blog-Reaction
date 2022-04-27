<?php

use App\Models\User;

function getCookieImmediately()
{
    $cookies = [];
    $headers = headers_list();

    foreach($headers as $header) {
        if (strpos($header, 'Set-Cookie: ') === 0) {
            $value = str_replace('&', urlencode('&'), substr($header, 12));
            parse_str(current(explode(';', $value, 1)), $pair);
            $cookies = array_merge_recursive($cookies, $pair);
        }
    }
    $token = explode(';', $cookies['guest_token']);

    return $token[0];
}

function guestUser()
{
    $token = $_COOKIE['guest_token'] ?? getCookieImmediately();

    return $user = User::where('guest_token', $token)->sole();
}
