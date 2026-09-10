<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isSetter()) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। এই পৃষ্ঠাটি কেবল অ্যাডমিন ও প্রশ্নকর্তাদের জন্য প্রযোজ্য।');
        }

        return $next($request);
    }
}
