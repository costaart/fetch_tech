<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'title' => 'required|string',
        ]);

        $user = auth()->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('url', $request->url)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'url' => $request->url,
                'image' => $request->image,
                'source' => $request->source,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function index()
    {
        $favorites = auth()->user()->favorites;
        return view('favorites', compact('favorites'));
    }
}
