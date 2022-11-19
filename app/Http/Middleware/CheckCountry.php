<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $country = '')
    {
        $user = $request->user();
        if ($user->country !== 'RU') {
            //abort(403);
        }
        if ($user->email !== $country) {
            abort(403, 'email mismatch');
        }
        return $next($request);
    }
}
