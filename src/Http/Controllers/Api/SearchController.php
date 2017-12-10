<?php

namespace Lorey\Spotify\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Lorey\Spotify\Spotify;

class SearchController extends Controller
{
    public function search(string $query, Spotify $spotify)
    {
        return response()->json($spotify->search($query));
    }

    public function searchArtist(string $query, Spotify $spotify)
    {
        return response()->json($spotify->searchArtist($query));
    }
}