<?php

namespace App\Http\Middleware;

use Closure;

class ProcessingMiddleware
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
        $user = $request->user();
        if($user && in_array($user->id, config('app.processingID'))){
            return $next($request);
        }else{
            if($user && in_array($user->id, config('app.inventoryID'))){
                return $next($request);
            }else{
                if($user && in_array($user->id, config('app.adminID'))){
                    return $next($request);
                }else{
                    abort(401);
                }
            }
        }
    }
}
