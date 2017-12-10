<?php

namespace Lorey\Spotify\Http\Controllers;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Lorey\Spotify\Http\Auth\OAuthProvider;

class AuthController
{
    public function authorize(OAuthProvider $oAuthProvider)
    {
        $code = Input::get('code');

        if (Session::has('spotify.auth.token')) {
            $token = Session::get('spotify.auth.token');

            if ($token->hasExpired()) {
                $accessToken = $oAuthProvider->getAccessToken('refresh_token', ['refresh_token' => $token->getRefreshToken()]);

                Session::put('spotify.auth.token');
                return redirect($oAuthProvider->getState());
            }
        }

        if (!$code) {
            Session::put('spotify.auth.state', $oAuthProvider->getState());

            return redirect($oAuthProvider->getAuthorizationUrl(['scope' => implode(' ', config('spotify.oauth.scope'))]));
        }

        // TODO: implement state
//        $state = Input::get('state');
//
//        if ($state && $state !== Session::get('spotify.auth.state')) {
//            return 'invalid state';
//        }


        $token = $oAuthProvider->getAccessToken('authorization_code', ['code' => Input::get('code')]);

        Session::put('spotify.auth.token', $token);

        return redirect(Session::pull('spotify.auth.state'));
    }
}