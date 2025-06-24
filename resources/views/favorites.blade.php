<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
    <title>Favorites | FetchTech</title>
</head>
<body class="bg-[#F9FAFB] font-[Archivo]">

<!-- NAVBAR -->
<nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <div class="flex items-center gap-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-8 h-8">
        <span class="text-lg font-semibold">FetchTech</span>
        <a href="{{ route('news') }}" class="ml-6 text-[#636AE8] font-medium hover:underline">{{ __('messages.welcome') }}</a>
        <a href="{{ route('favorites') }}" class="text-[#6B7280] hover:text-[#636AE8]">{{ __('messages.favorites') }}</a>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-[#636AE8] hover:bg-[#4b52c9] text-white px-4 py-2 rounded-md font-semibold">
            {{ __('messages.logout') }}
        </button>
    </form>
</nav>

<!-- MAIN -->
<div class="max-w-7xl mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold mb-6">{{ __('messages.favorites') }}</h2>

    @if($favorites->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $item)
                <div class="bg-white rounded-md shadow-md overflow-hidden flex flex-col h-full">
                    <img src="{{ $item->image }}" alt="News Image" class="w-full h-48 object-cover">
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-bold mb-2">{{ $item->title }}</h3>
                        <p class="text-sm text-[#6B7280] mb-3 flex-1">{{ $item->url }}</p>
                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                            <a href="{{ $item->url }}" target="_blank" class="text-[#636AE8] text-sm hover:underline">
                                {{ __('messages.read_more') }}
                            </a>
                            <span class="text-[#636AE8] text-sm">{{ $item->source }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-[#6B7280]">{{ __('messages.no_favorites') }}</p>
    @endif
</div>

</body>
</html>
