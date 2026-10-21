<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();

            $restrictedRoutes = [
                'dafac' => 0,
                'pwd' => 1,
                'soloparent' => 2,
                'womens' => 3,
                'vawc' => 5,
            ];

            $currentRoute = $request->route()->getName();

            foreach ($restrictedRoutes as $route => $index) {
                if (strpos($currentRoute, $route) !== false) {
                    $access = explode(',', $user->access);
                    if (isset($access[$index]) && $access[$index] == '0') {
                        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page');
                    }
                }
            }
        } else {
            return redirect()->route('getLogin')->with('error', 'You have to Sign In first to access this page');
        }

        return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma', 'no-cache')
                              ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
    }
}
