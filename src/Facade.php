<?php

namespace Lorey\Spotify;


class Facade extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return Spotify::class;
    }
}