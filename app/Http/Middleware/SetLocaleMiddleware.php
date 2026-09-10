<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang') && in_array($request->get('lang'), ['bn', 'en'])) {
            Session::put('locale', $request->get('lang'));
        }

        $locale = Session::get('locale', config('app.locale', 'bn'));
        App::setLocale($locale);

        return $next($request);
    }
}
