<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->subscribed(env('STRIPE_PRODUCT_ID')))
            return redirect()->route('dashboard');

        // user will only access the page (ex: plans, select_plan) case it has no subscription
        return $next($request);
    }
}
