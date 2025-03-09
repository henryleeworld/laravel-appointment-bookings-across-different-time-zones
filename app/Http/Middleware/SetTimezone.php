<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use DateTimeZone;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            date_default_timezone_set(auth()->user()->timezone);
            $locale = new DateTimeZone(auth()->user()->timezone);
            $localeCode = $locale->getLocation()['country_code'] ?? 'zh_TW';
            Carbon::setLocale($localeCode);
        }

        return $next($request);
    }
}
