<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class verifyAPI
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
        $key = explode(":", env('APP_KEY'));
        if ($request->header('apikey') === $key[1]) {
            if ($request->method() === "POST") {
                if ($request->header('verify_request') === 'always') {
                    $hmac = hash_hmac('sha256', json_encode($request->all()), env('HMAC_SECERET_KEY'));
                    if (!hash_equals($hmac, $request->header('bodySignature'))) {
                        return response()->json(['message' => 'You are not allowed to perform action'], 500);
                    }
                }
            }
            return $next($request);
        } else {
            return response()->json(['message' => 'Unauthorized'], 500);
        }
    }
}
