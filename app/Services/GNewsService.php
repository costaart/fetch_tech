<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Models\User;


class GNewsService
{
    private string $base_url = 'https://gnews.io/api/v4';

    public function fetchNews(string $query = 'technology', string $language, int $max = 5)
    {
        $response = Http::get("{$this->base_url}/search", [
            'q' => $query,
            'token' => config('services.gnews.key'),
            'lang' => $language,
            'max' => $max,
        ]);

        if ($response->failed()) {
            throw new \Exception('Erro ao buscar notícias da GNews');
        }

        return $response->json('articles');
    }
}