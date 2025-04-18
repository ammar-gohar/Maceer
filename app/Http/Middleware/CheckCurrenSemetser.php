<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Semesters\Models\Semester;
use Symfony\Component\HttpFoundation\Response;

class CheckCurrenSemetser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Semester::where('is_current')->first()){
            return redirect()->route('semester');
        }
        return $next($request);
    }
}
