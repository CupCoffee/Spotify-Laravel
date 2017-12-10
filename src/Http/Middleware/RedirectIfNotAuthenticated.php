<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 7/27/2017
 * Time: 7:28 PM
 */

namespace Lorey\Spotify\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!$this->isAuthorized($request) && !$request->routeIs('spotify.oauth.authorize')) {
            return redirect(route('spotify.oauth.authorize'));
        }

        return $next($request);
    }

    private function isAuthorized(Request $request)
    {
        if (!$request->session()->has('spotify.auth.token')) {
            return false;
        }

        $token = $request->session()->get('spotify.auth.token');

        try {
            return !$token->hasExpired();
        } catch (Exception $exception) {
            return false;
        }
    }
}