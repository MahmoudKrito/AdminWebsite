<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->headers->has('lang') && $request->header('lang')) {
            $lang = $request->header('lang');
            $langs = collect(['en', 'ar']);
            if($langs->contains($lang)){
                // set the local language
                App::setLocale($lang);
                return $next($request);
            }else{
                return response()->json([
                    'message' => 'You must send language.',
                    'status'  => 403,
                ]);
            }
        }else {
            return response()->json([
                'message' => 'You must send language.',
                'status'  => 403,
            ]);
        }
    }
}
