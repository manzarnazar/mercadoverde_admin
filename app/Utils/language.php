<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

if (!function_exists('getLocaleForTranslations')) {
    /**
     * Resolve the locale used for loading translation files.
     * e.g. "es" has no lang file, so use "es-MX" for Spanish.
     */
    function getLocaleForTranslations(string $locale): string
    {
        $langPath = base_path('resources/lang/' . $locale . '/messages.php');
        if (file_exists($langPath)) {
            return $locale;
        }
        if ($locale === 'es') {
            return file_exists(base_path('resources/lang/es-MX/messages.php')) ? 'es-MX' : $locale;
        }
        return $locale;
    }
}

if (!function_exists('translate')) {
    function translate($key): string
    {
        $local = getDefaultLanguage();
        $loadLocale = getLocaleForTranslations($local);
        App::setLocale($loadLocale);

        try {
            $lang_array = include(base_path('resources/lang/' . $loadLocale . '/messages.php'));
            $processed_key = ucfirst(str_replace('_', ' ', removeSpecialCharacters($key)));
            $key = removeSpecialCharacters($key);
            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $loadLocale . '/messages.php'), $str);
                $result = $processed_key;
            } else {
                $result = __('messages.' . $key);
            }
        } catch (\Exception $exception) {
            $result = __('messages.' . $key);
        }

        return $result;
    }
}


if (!function_exists('removeSpecialCharacters')) {

    function removeSpecialCharacters(string $text): string
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', preg_replace('/\s\s+/', ' ', $text));
    }
}

if (!function_exists('getDefaultLanguage')) {
    function getDefaultLanguage(): string
    {
        if (strpos(url()->current(), '/api')) {
            $lang = App::getLocale();
        } elseif (session()->has('local')) {
            $lang = session('local');
        } else {
            $data = getWebConfig('language');
            $code = 'en';
            $direction = 'ltr';
            foreach ($data as $ln) {
                if (array_key_exists('default', $ln) && $ln['default']) {
                    $code = $ln['code'];
                    if (array_key_exists('direction', $ln)) {
                        $direction = $ln['direction'];
                    }
                }
            }
            session()->put('local', $code);
            Session::put('direction', $direction);
            $lang = $code;
        }
        return $lang;
    }
}
