@extends('layouts.app')

@section('title', $movie['title'])

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Phần xem phim -->
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl mb-8">
            <div class="aspect-w-16 aspect-h-9">
                <video
                    class="w-full h-full object-cover"
                    controls
                    poster="https://image.tmdb.org/t/p/original{{ $movie['backdrop_path'] }}"
                >
                    <source src="https://storage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ phát video.
                </video>
            </div>
        </div>

        <!-- Thông tin phim -->
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl">
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <!-- Poster phim -->
                    <div class="md:w-1/3 mb-6 md:mb-0 md:mr-6">
                        <img
                            src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                            alt="{{ $movie['title'] }}"
                            class="w-full rounded-lg shadow-lg"
                        >
                    </div>

                    <!-- Chi tiết phim -->
                    <div class="md:w-2/3">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $movie['title'] }}</h1>

                        <div class="flex items-center mb-4">
                            <div class="flex items-center text-yellow-500 mr-4">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-white">{{ $movie['vote_average'] }}/10</span>
                            </div>
                            <span class="text-gray-400">{{ \Carbon\Carbon::parse($movie['release_date'])->format('d/m/Y') }}</span>
                        </div>

                        <div class="mb-4">
                            <h2 class="text-xl font-semibold text-white mb-2">Tóm tắt</h2>
                            <p class="text-gray-300">{{ $movie['overview'] }}</p>
                        </div>

                        <div class="mb-4">
                            <h2 class="text-xl font-semibold text-white mb-2">Thông tin thêm</h2>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-400">Đạo diễn</p>
                                    <p class="text-white">
                                        @foreach($credits['crew'] ?? [] as $crew)
                                            @if($crew['job'] === 'Director')
                                                {{ $crew['name'] }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-400">Thể loại</p>
                                    <p class="text-white">
                                        @foreach($movie['genres'] ?? [] as $genre)
                                            {{ $genre['name'] }}@if(!$loop->last), @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($movie['vote_average'] > 8.0 && !auth()->check())
                            <div class="mt-6">
                                <a href="{{ route('plans') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">
                                    <i class="fas fa-crown mr-2"></i>
                                    Đăng ký VIP để xem phim
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Movie Details -->
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Cast -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-6">Diễn viên</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(array_slice($credits['cast'] ?? [], 0, 8) as $cast)
                        <div class="text-center">
                            <img src="https://image.tmdb.org/t/p/w200{{ $cast['profile_path'] }}"
                                 alt="{{ $cast['name'] }}"
                                 class="w-32 h-32 object-cover rounded-full mx-auto mb-2">
                            <h3 class="font-semibold">{{ $cast['name'] }}</h3>
                            <p class="text-gray-400 text-sm">{{ $cast['character'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Videos -->
            @if(!empty($videos['results']))
                <div class="mb-12">
                    <h2 class="text-2xl font-bold mb-6">Trailer & Video</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(array_slice($videos['results'], 0, 2) as $video)
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe src="https://www.youtube.com/embed/{{ $video['key'] }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                        class="w-full h-full rounded-lg"></iframe>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Similar Movies -->
            @if(!empty($similarMovies))
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-6">Phim tương tự</h2>
                    <div class="space-y-4">
                        @foreach(array_slice($similarMovies, 0, 5) as $similar)
                            <a href="{{ route('movies.show', $similar['id']) }}" class="flex items-center space-x-4 group">
                                <img src="https://image.tmdb.org/t/p/w200{{ $similar['poster_path'] }}"
                                     alt="{{ $similar['title'] }}"
                                     class="w-20 h-30 object-cover rounded-lg">
                                <div>
                                    <h3 class="font-semibold group-hover:text-red-600 transition">{{ $similar['title'] }}</h3>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <span class="text-yellow-400 mr-1">
                                            <i class="fas fa-star"></i>
                                        </span>
                                        {{ round($similar['vote_average'], 1) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Movie Info -->
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Thông tin phim</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-400">Đạo diễn:</span>
                        <p class="font-semibold">
                            @foreach($credits['crew'] ?? [] as $crew)
                                @if($crew['job'] === 'Director')
                                    {{ $crew['name'] }}
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-400">Thể loại:</span>
                        <p class="font-semibold">
                            @foreach($movie['genres'] ?? [] as $genre)
                                {{ $genre['name'] }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-400">Ngôn ngữ:</span>
                        <p class="font-semibold">{{ $movie['original_language'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
