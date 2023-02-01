<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticatePin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($request->has('pin') && $request->get('pin') === $user->pin) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'pin' => trans('auth.pin_invalid')
            ]
        ], 401);

    }
}
