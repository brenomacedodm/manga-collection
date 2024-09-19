<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;


class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = [];

        if($request->hasHeader('Authorization')){
            $token = PersonalAccessToken::findToken(str_replace('Bearer ', '' , $request->header('Authorization')));
            $user = $token->tokenable;
        }
        
        $request->merge([
            "isAuthenticated" => $user ? true : false,
            "isAdmin" => isset($user->is_admin) ? $user->is_admin : false,
            "isVerified" => isset($user->email_verified_at) && $user->email_verified_at != null ? true : false,
        ]);
        
        return $next($request);
    }
}
