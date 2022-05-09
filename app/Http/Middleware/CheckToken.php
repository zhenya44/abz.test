<?php

namespace App\Http\Middleware;

use App\Token;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->headers->get('token');
        if(!$token)
        {
            abort(Response::HTTP_UNAUTHORIZED, "The token expired.");
        }

        $token = Token::where('token', '=', $token)->first();
        if(!$token)
        {
            abort(Response::HTTP_UNAUTHORIZED, "The token expired.");
        }

        if($token->isExpired())
        {
            $token->delete();
            abort(Response::HTTP_UNAUTHORIZED, "The token expired.");
        }

        $token->delete();

        return $next($request);
    }
}
