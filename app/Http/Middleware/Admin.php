<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Allow both 'admin' and 'superadmin' users to proceed
        if (!in_array(Auth()->user()->usertype, ['admin', 'superadmin'])) {
            abort(403, 'Only Admin or Super Admin can do that.');
        }

        return $next($request);
    }
}
