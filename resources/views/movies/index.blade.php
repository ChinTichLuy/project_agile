@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Loading State -->
    <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)">
        <div x-show="loading" class="fixed inset-0 bg-black/50 flex items-center justify-center">
            <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-red-600"></div>
        </div>

        <!-- Hero Image Slider -->
        <div x-data="{
            currentSlide: 0,
            slides: {{ json_encode($randomMovies) }},
            init() {
                setInterval(() => {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                }, 4500);
            }
        }" class="relative h-[70vh] md:h-[85vh] overflow-hidden">
            <!-- Back Button -->
            <div class="absolute top-4 left-4 z-10">
                <a href="{{ route('movies.index') }}"
                   class="flex items-center px-4 py-2 bg-gray-800/50 text-white rounded-lg hover:bg-gray-800 transition duration-300">
                    <i class="fas fa-home mr-2"></i>
                    Trang chủ
                </a>
            </div>

            <!-- Slides -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index"
                     x-transition:enter="transition ease-in-out duration-1000"
                     x-transition:enter-start="opacity-0 transform scale-110"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in-out duration-1000"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="absolute inset-0 w-full">
                    <img x-bind:src="'https://image.tmdb.org/t/p/original' + slide.backdrop_path"
                         class="w-full h-full object-cover transition-transform duration-1000"
                         style="width: 100vw; height: 100vh; object-fit: cover;"
                         alt="Movie backdrop">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
                </div>
            </template>

            <!-- Movie Info Overlay -->
            <div class="absolute bottom-0 left-0 right-0">
                <div class="container mx-auto px-4 pb-12">
                    <div class="max-w-3xl">
                        <template x-for="(slide, index) in slides" :key="index">
                            <div x-show="currentSlide === index"
                                 x-transition:enter="transition ease-in-out duration-1000"
                                 x-transition:enter-start="opacity-0 transform translate-y-8"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in-out duration-1000"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform translate-y-8"
                                 class="transform transition-all duration-1000">
                                <h1 x-text="slide.title" class="text-4xl md:text-6xl font-bold text-white mb-4"></h1>
                                <div class="flex flex-wrap items-center gap-4 mb-6">
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star text-2xl mr-2"></i>
                                        <span x-text="slide.vote_average.toFixed(1) + '/10'" class="text-2xl font-bold"></span>
                                    </div>
                                    <span class="text-gray-300">|</span>
                                    <span x-text="new Date(slide.release_date).getFullYear()" class="text-gray-300"></span>
                                </div>
                                <p x-text="slide.overview" class="text-gray-300 text-lg mb-8"></p>
                                <div class="flex items-center space-x-4">
                                    <a x-bind:href="'/movies/' + slide.id"
                                       class="group inline-flex items-center px-8 py-3 bg-red-600 text-white rounded-lg transition-all duration-300 hover:bg-red-700 hover:scale-105 hover:shadow-lg">
                                        <i class="fas fa-play mr-2 transform transition-transform duration-300 group-hover:scale-110"></i>
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Navigation Dots -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="currentSlide = index"
                            class="w-3 h-3 rounded-full transition-all duration-300 transform hover:scale-125"
                            :class="currentSlide === index ? 'bg-red-600 scale-125' : 'bg-gray-600 hover:bg-gray-500'">
                    </button>
                </template>
            </div>
        </div>

        <!-- Movie Categories -->
        <div class="container mx-auto px-4 py-12">
            @foreach($categories as $category)
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-white">{{ $category['name'] }}</h2>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            Xem tất cả <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                        @foreach($category['movies'] as $movie)
                            <div class="relative group">
                                <a href="{{ route('movies.detail', $movie['id']) }}" class="block">
                                    <img src="{{ $movie['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'] : 'https://via.placeholder.com/500x750' }}"
                                         alt="{{ $movie['title'] }}"
                                         class="w-full h-auto rounded-lg transition duration-300 group-hover:opacity-75">

                                    @if($movie['vote_average'] >= 8.5)
                                        <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-sm font-bold">
                                            VIP
                                        </div>
                                    @endif
                                </a>
                                <div class="mt-2">
                                    <h3 class="text-lg font-semibold text-white">{{ $movie['title'] }}</h3>
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
