<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class HasRoleMiddleware
{

    public function handle(Request $request, Closure $next,string $role)
    {
        if (!auth()->user() && !auth()->user()->user_role($role)) {
            return response()->json([
                "status"=>Response::HTTP_UNAUTHORIZED,
                'message'=>'authenticated',
            ]);
        }
        return $next($request);
    }
}
