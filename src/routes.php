<?php

use Illuminate\Support\Facades\Route;
use Lorey\Spotify\Spotify;


Route::middleware('web')->prefix('spotify')->group(function() {
    Route::prefix('authorize')->group(function() {
        Route::get('/', 'Lorey\Spotify\Http\Controllers\AuthController@authorize')->name('spotify.oauth.authorize');
        Route::get('/callback', 'Lorey\Spotify\Http\Controllers\AuthController@authorize')->name('spotify.oauth.redirect');
    });

    Route::namespace('Lorey\Spotify\Http\Controllers\Api')->prefix('api')->group(function() {
        Route::prefix('/search')->group(function() {
            Route::get('/artist/{query}', 'SearchController@searchArtist');
            Route::get('/{query}', 'SearchController@search');
        });
    });
});
