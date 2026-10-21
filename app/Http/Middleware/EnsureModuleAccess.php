<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Usage: ->middleware('module:senior'). Module names are the keys of App\Models\User::MODULES.
 */
class EnsureModuleAccess
{
    public function handle(Request $request, Closure $next, string $module)
    {
        if (! $request->user()?->canAccessModule($module)) {
            $message = 'You do not have permission to access this page';

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 403);
            }

            return redirect()->route('dashboard')->with('error', $message);
        }

        return $next($request);
    }
}
