<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class IsAdmin extends Middleware
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
        
        if (Auth::user()->roles == 1) {
            return $next($request);
        } else {
            return json_encode(["MSG"=>"You Can't Access..."]);
        }
        
    }
}
