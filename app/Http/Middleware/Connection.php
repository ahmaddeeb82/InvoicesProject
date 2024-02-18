<?php

namespace App\Http\Middleware;

use App\Helpers\JsonDatabases;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Connection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->id == 1) {
            JsonDatabases::$connection_name = 'sqlsrv_admin';
        } else {
            JsonDatabases::$connection_name = 'sqlsrv_second';
        }
        return $next($request);
    }
}
