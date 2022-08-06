<?php

namespace App\Http\Middleware;

use App\Models\Ads;
use Closure;
use Illuminate\Http\Request;
use App\Traits\CheckIp;

class VisitCount
{
    use CheckIp;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
         $ip = $request->ip();
        $this->getIp($ip, $request->route('ad')->id);
        return $next($request);
    }
}
