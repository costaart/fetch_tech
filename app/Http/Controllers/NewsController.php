<?php

namespace App\Http\Controllers;

use App\Services\GNewsService;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(GNewsService $gnews)
    {
        $user = Auth::user();
        $language = $user->language;

        // Cache por 1 hora (60 minutos) -> teste por enquanto evitar requests
        $trending = cache()->remember("trending_{$language}", 3600, function () use ($gnews, $language) {
            return $gnews->fetchNews($language, 'technology', 2);
        });

        $recent = cache()->remember("recent_{$language}", 3600, function () use ($gnews, $language) {
            return $gnews->fetchNews($language, 'technology', 6);
        });

        return view('news', compact('trending', 'recent'));
    }
}
