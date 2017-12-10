<?php

return [
    'oauth' => [
        'client' => [
            'id' => 'f3ecb8e277b74efa9c33783b807920e6',
            'secret' => '664fe3565d54414e82d4f37df30f884d'
        ],

        'url' => [
            'authorize' => 'https://accounts.spotify.com/authorize',
            'token' => 'https://accounts.spotify.com/api/token',
            'owner' => 'https://api.spotify.com/v1/me'
        ],

        'scope' => [
            'user-read-playback-state',
            'user-modify-playback-state',
            'user-read-currently-playing',
            'user-read-recently-played'
        ]
    ],

    'api' => [
        'base_uri' => 'https://api.spotify.com/',
        'version' => 'v1'
    ]
];