<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Models\User;


class GNewsService
{

    public function fetchNews(string $language, int $max = 5)
    {
        $response = Http::get("https://gnews.io/api/v4/top-headlines", [
            'token' => config('services.gnews.key'),
            'lang' => $language,
            'topic' => 'technology',
            'max' => $max,
        ]);

        if ($response->failed()) {
            throw new \Exception('Erro ao buscar notícias da GNews');
        }

        return $response->json('articles');
    }
}