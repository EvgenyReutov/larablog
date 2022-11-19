<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckAge
{
    private const AGE = 18;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $age = $request->input('age');
        if ($age === null || $age < self::AGE) {
            abort(403);
        } else {

        }
        return $next($request);
    }

    public function temrinate(Request $request, Response $response)
    {

    }
}
