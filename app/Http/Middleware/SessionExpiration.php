<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('last_request_time')){
            $last_request_time = $request->session()->get('last_request_time');
            $diff = time() - $last_request_time;
            if ($diff <=   900) {
                $request->session()->put('last_request_time', time());
                return $next($request);
            }
            else {
                $request->session()->forget('last_request_time');
                auth()->user()->currentAccessToken()->delete();
                return ApiResponse::apiSendResponse(
                440,
                'Session Has Been Expired.'
            );
            }
        } else {

            session(['last_request_time' => time()]);
            return $next($request);
        }
    }
}
