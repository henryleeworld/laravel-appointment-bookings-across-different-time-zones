<?php

namespace App\Services;

use Http;

class TimezoneService
{
    public static function guess()
    {
        $ip = Http::get('https://ipecho.net/json');
        if ($ip->json('timezone')) {
            return $ip->json('timezone');
        }
        return null;
    }
}
