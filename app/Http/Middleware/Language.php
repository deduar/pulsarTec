<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locales = config('app.locales');
        $locale = $request->get('_locale');
        if(!is_null($locale) && is_array($locales) && array_key_exists($locale, $locales)){
            app()->setLocale($locale);
            session(['_locale'=>$locale]);
        }elseif(!is_null(session('_locale'))){
            app()->setLocale(session('_locale'));
        }
        return $next($request);
    }
}
