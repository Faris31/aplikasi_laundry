<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$level): Response
    {
        if (!$request->user() || !$request->user()->hasAnyRole($level))
        {
            return redirect()->to('dashborad');
            Alert::error('Maaf!', 'Anda tidak memiliki akses');
        }
        return $next($request);
    }
}
