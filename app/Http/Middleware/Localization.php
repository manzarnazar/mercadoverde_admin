<?php

namespace App\Http\Middleware;

use App\CentralLogics\Helpers;
use Closure;
use Illuminate\Support\Facades\App;


class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang ='en';
        $direction ='ltr';
        try {
            $language =  Helpers::get_business_settings('system_language') ;
            if($language){
                foreach ($language as $key => $data) {
                    if ($data['default']) {
                        $lang= $data['code'];
                        $direction= $data['direction'];
                    }
                }
            }
        } catch (\Exception $exception) {
            info($exception->getMessage());
        }
        // Resolve locale to one that has translation files (e.g. es -> es-MX)
        $resolveLocale = function ($code) {
            return function_exists('getLocaleForTranslations') ? getLocaleForTranslations($code) : $code;
        };

        if ($request->is('vendor-panel*')) {
            if (session()->has('vendor_local')) {
                $lang = session()->get('vendor_local');
                App::setLocale($resolveLocale($lang));
            }
            else{
                session()->put('vendor_site_direction', $direction);
                App::setLocale($resolveLocale($lang));
            }
        }elseif($request->is('admin*')){
            if (session()->has('local')) {
                $lang = session()->get('local');
                App::setLocale($resolveLocale($lang));
            }
            else{
                session()->put('site_direction', $direction);
                App::setLocale($resolveLocale($lang));
            }
        }else{
            if (session()->has('landing_local')) {
                $lang = session()->get('landing_local');
                App::setLocale($resolveLocale($lang));
            }else{
                session()->put('landing_site_direction', $direction);
                App::setLocale($resolveLocale($lang));
            }
        }
        return $next($request);
    }
}
