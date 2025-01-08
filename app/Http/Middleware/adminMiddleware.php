<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){
                    /**
         * @var App\Models\user
         */

            $user=Auth::user();
            $allowedRoles=DB::table('roles')->pluck('name')->toarray();

            if($user->hasRole($allowedRoles)){
                return $next($request);
            }
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');

    }
}
