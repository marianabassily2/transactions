<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseFormat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $perPage =  min($request->query('perPage', config('dayra.PER_PAGE')),config('dayra.PER_PAGE'));
        $expanded = $request->query('expanded') ?? false;
        request()->merge([
            'per_page' => $perPage,
            'expanded' => ($expanded == 1)
        ]);
        return $next($request);
    }
}
