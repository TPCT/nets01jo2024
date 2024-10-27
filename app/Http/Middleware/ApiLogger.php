<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Log;

class ApiLogger
{
    public function handle($request, Closure $next)
    {
        // Log the API request details
        Log::info('API Request:', [
            'URL'  => $request->fullUrl(),
            'Method' => $request->method(),
            'ip_address' => $request->ip(),
            'user-agent' => $request->header('user-agent'),
            'headers' => $request->headers->all(),
            // 'query_parameters' => $request->query->all(),
            // 'all_parameters' => $request->all(),
            'user_id' => auth()->check() ? auth('api')->id() : 0,
            'Data' => $request->all(),
        ]);

        return $next($request);
    }

}