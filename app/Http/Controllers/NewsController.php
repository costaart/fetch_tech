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

        $trending = cache()->remember("news_trending_{$language}", 3600, function () use ($gnews, $language) {
            return $gnews->fetchNews($language, 2);
        });

        $recent = cache()->remember("news_recent_{$language}", 3600, function () use ($gnews, $language) {
            return $gnews->fetchNews($language, 10);
        });

        $formatDates = function(array $items) {
            foreach ($items as &$item) {
                if (isset($item['publishedAt'])) {
                    $item['formatted_date'] = \Carbon\Carbon::parse($item['publishedAt'])
                        ->format('d/m/Y - H:i');
                }
            }
            unset($item);
            return $items;
        };

        $trending = $formatDates($trending);
        $recent = $formatDates($recent);

        return view('news', compact('trending', 'recent'));
    }

}
