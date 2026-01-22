<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncreaseUploadSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Increase PHP upload limits for file uploads
        ini_set('post_max_size', '1024M');
        ini_set('upload_max_filesize', '1024M');
        ini_set('max_execution_time', '300');
        ini_set('max_input_time', '300');
        ini_set('memory_limit', '512M');

        return $next($request);
    }
}
