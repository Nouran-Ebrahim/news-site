<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->guard('web')->check() && auth()->guard('web')->user()->status==0){
            return redirect()->route('frontend.waitPage');
        }
        if(auth()->guard('sanctum')->check() && auth()->guard('sanctum')->user()->status==0){
            auth()->guard('sanctum')->user()->currentAccessToken()->delete();
            return apiResponse(403,'user not active');
        }
        return $next($request);
    }
}
