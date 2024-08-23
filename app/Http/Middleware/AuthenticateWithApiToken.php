<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponses;

class AuthenticateWithApiToken
{
    use ApiResponses;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorisation');

        if (!$token || !User::where('api_token', $token)->exists()) {
            return $this->errorResponse(['error' => 'Unauthorized'],'', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
