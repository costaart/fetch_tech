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
        <a href="#" class="ml-6 text-[#636AE8] font-medium hover:underline">Home</a>
        {{-- <a href="{{ route('favorites') }}" class="text-[#6B7280] hover:text-[#636AE8]">Favorites</a> --}}
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-[#636AE8] hover:bg-[#4b52c9] text-white px-4 py-2 rounded-md font-semibold">
            Logout
        </button>
    </form>
</nav>

<!-- MAIN -->
<div class="max-w-7xl mx-auto px-6 py-8"
    x-data="{
        search: '',
        selectedTag: '',
        articles: {{ Js::from($recent) }},
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
        selectTag(tag) {
            this.selectedTag = this.selectedTag === tag ? '' : tag;
        }
    }">

    <!-- Title -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold mb-2">Your Daily Dose of <span class="text-[#636AE8]">Tech Insights</span></h1>
        <p class="text-[#6B7280]">Stay ahead with the latest news, analyses, and breakthroughs from the world of technology, curated just for you.</p>
    </div>

    <!-- Trending News -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Trending News</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($trending as $item)
                <div class="bg-white rounded-md shadow-md overflow-hidden">
                    <img src="{{ $item['image'] }}" alt="News Image" class="w-full h-60 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm text-[#6B7280] mb-3">{{ $item['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="flex justify-between items-center mt-12 mb-6">
        <input 
            type="text" 
            x-model="search"
            placeholder="Search news by keyword..." 
            class="w-full max-w-lg border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
    </div>

    <!-- Tags -->
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

    <!-- Recent Articles -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Recent Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="item in filteredArticles" :key="item.title">
                <div class="bg-white rounded-md shadow-md overflow-hidden">
                    <img :src="item.image" alt="News Image" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2" x-text="item.title"></h3>
                        <p class="text-sm text-[#6B7280] mb-3" x-text="item.description"></p>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-[#636AE8]" x-text="item.source"></span>
                            <span class="text-[#9CA3AF]" x-text="item.publishedAt"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

</body>
</html>
