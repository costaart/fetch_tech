<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
    <title>News | FetchTech</title>
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
<div class="max-w-7xl mx-auto px-6 py-8"
    x-data="{
        search: '',
        selectedTag: '',
        page: 1,
        perPage: 6,
        articles: {{ Js::from($recent) }},
        favorites: {{ Js::from(auth()->user()->favorites->pluck('url')) }},

        get filteredArticles() {
            return this.articles.filter(a => {
                const matchesSearch = this.search === '' 
                    || (a.title && a.title.toLowerCase().includes(this.search.toLowerCase()))
                    || (a.description && a.description.toLowerCase().includes(this.search.toLowerCase()));

                const matchesTag = this.selectedTag === '' 
                    || (a.tags && a.tags.includes(this.selectedTag));

                return matchesSearch && matchesTag;
            });
        },

        get paginatedArticles() {
            return this.filteredArticles.slice(0, this.page * this.perPage);
        },

        canLoadMore() {
            return this.paginatedArticles.length < this.filteredArticles.length;
        },

        loadMore() {
            if (this.canLoadMore()) this.page++;
        },

        selectTag(tag) {
            this.selectedTag = this.selectedTag === tag ? '' : tag;
            this.page = 1;
        },

        toggleFavorite(item) {
            fetch('{{ route('favorite.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    url: item.url,
                    title: item.title,
                    image: item.image,
                    source: item.source.name
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'added') {
                    this.favorites.push(item.url);
                } else if (data.status === 'removed') {
                    this.favorites = this.favorites.filter(url => url !== item.url);
                }
            });
        },

        isFavorite(item) {
            return this.favorites.includes(item.url);
        },

        init() {
            window.addEventListener('scroll', () => {
                const bottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 100;
                if (bottom && this.canLoadMore()) {
                    this.loadMore();
                }
            });
        }
    }">

    <!-- TITLE -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold mb-2">{!! __('messages.title') !!}</h1>
        <p class="text-[#6B7280]">
            {{ __('messages.subtitle') }}
        </p>
    </div>

    <!-- TRENDING -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">{{ __('messages.trending_news') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($trending as $item)
                <div class="bg-white rounded-md shadow-md overflow-hidden flex flex-col h-full">
                    <img src="{{ $item['image'] }}" alt="News Image" class="w-full h-60 object-cover">
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-bold mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm text-[#6B7280] mb-3 flex-1">{{ $item['description'] }}</p>

                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                            <button 
                                class="text-lg"
                                :class="favorites.includes('{{ $item['url'] }}') ? 'text-yellow-400' : 'text-[#636AE8]'"
                                @click="toggleFavorite({ 
                                    url: '{{ $item['url'] }}', 
                                    title: '{{ $item['title'] }}', 
                                    image: '{{ $item['image'] }}', 
                                    source: { name: '{{ $item['source']['name'] }}' } 
                                })"
                                title="Toggle Favorite">
                                <svg xmlns="http://www.w3.org/2000/svg" :fill="favorites.includes('{{ $item['url'] }}') ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17.25l-6.16 3.73 1.64-7.03L2 9.77l7.19-.62L12 2.5l2.81 6.65 7.19.62-5.48 4.18 1.64 7.03z"/>
                                </svg>
                            </button>
                            <div class="flex flex-col text-right">
                                <span class="text-[#636AE8] text-sm">{{ $item['source']['name'] }}</span>
                                <span class="text-[#9CA3AF] text-xs">{{ $item['formatted_date'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- SEARCH -->
    <div class="flex justify-between items-center mt-12 mb-6">
        <input 
            type="text" 
            x-model="search"
            placeholder="{{ __('messages.search_placeholder') }}" 
            class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
    </div>

    <!-- TAGS -->
    <div class="flex flex-wrap gap-2 mb-8">
        @foreach(['AI','Machine Learning','Space','Cybersecurity','Blockchain','Google','Apple','IBM','AR','VR','Crypto','Quantum Computing'] as $tag)
            <button 
                @click="selectTag('{{ $tag }}')"
                :class="selectedTag === '{{ $tag }}' ? 'bg-[#636AE8] text-white' : 'border border-[#636AE8] text-[#636AE8] hover:bg-[#ECECFE]'"
                class="px-4 py-1 rounded-full text-sm"
            >
                {{ $tag }}
            </button>
        @endforeach
    </div>

    <!-- RECENT ARTICLES -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">{{ __('messages.recent_articles') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="item in paginatedArticles" :key="item.title">
                <div class="bg-white rounded-md shadow-md overflow-hidden flex flex-col h-full">
                    <img :src="item.image" alt="News Image" class="w-full h-48 object-cover">
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-bold mb-2" x-text="item.title"></h3>
                        <p class="text-sm text-[#6B7280] mb-3 flex-1" x-text="item.description"></p>

                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                            <button 
                                :class="isFavorite(item) ? 'text-yellow-400' : 'text-[#636AE8]'"
                                @click="toggleFavorite(item)"
                                title="Toggle Favorite">
                                <svg xmlns="http://www.w3.org/2000/svg" :fill="isFavorite(item) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17.25l-6.16 3.73 1.64-7.03L2 9.77l7.19-.62L12 2.5l2.81 6.65 7.19.62-5.48 4.18 1.64 7.03z"/>
                                </svg>
                            </button>
                            <div class="flex flex-col text-right">
                                <span class="text-[#636AE8] text-sm" x-text="item.source.name"></span>
                                <span class="text-[#9CA3AF] text-xs" x-text="item.formatted_date"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- LOAD MORE -->
    <div class="flex justify-center mt-8" x-show="canLoadMore()">
        <button 
            @click="loadMore()" 
            class="bg-[#636AE8] hover:bg-[#4b52c9] text-white px-6 py-2 rounded-md font-semibold">
            {{ __('messages.load_more') }}
        </button>
    </div>

</div>

</body>
</html>
