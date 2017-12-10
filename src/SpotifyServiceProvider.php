<?php

namespace Lorey\Spotify;


use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Schema;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Contracts\Container\Container;
use League\OAuth2\Client\Token\AccessToken;
use Lorey\Spotify\Api\Http\Client as ApiClient;
use Illuminate\Support\ServiceProvider;
use Lorey\Spotify\GraphQL\Query\SearchQuery;
use Lorey\Spotify\Http\Auth\OAuthProvider;

class SpotifyServiceProvider extends ServiceProvider
{
    protected $provides = [Spotify::class];

    public function register()
    {
        $this->app->when(ApiClient::class)->needs(HttpClient::class)->give(function () {
            return new HttpClient([
                'base_uri' => config('spotify.api.base_uri')
            ]);
        });

        $this->app->when(ApiClient::class)->needs(AccessToken::class)->give(function () {
            return session('spotify.auth.token');
        });

        $this->app->singleton(OAuthProvider::class, function () {
            return new OAuthProvider([
                'clientId' => config('spotify.oauth.client.id'),
                'clientSecret' => config('spotify.oauth.client.secret'),
                'redirectUri' => route('spotify.oauth.redirect'),
                'state' => url()->previous()
            ]);
        });

        $this->app->singleton(Spotify::class, function (Container $app) {
            return new Spotify($app->make(ApiClient::class));
        });
    }

    public function boot()
    {
        $this->publishes([__DIR__ . '/config.php' => config_path('spotify.php')]);

        $this->mergeConfigFrom(__DIR__ . '/config.php', 'spotify');

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}