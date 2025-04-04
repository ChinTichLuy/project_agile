@extends('layouts.app')

@section('title', $movie['title'] ?? 'Xem phim')

@section('content')
<div class="min-h-screen bg-black">
    <!-- Video Player Section -->
    <div class="relative w-full h-screen">
        <div class="absolute inset-0">
            <video id="player" playsinline controls class="w-full h-full">
                <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
            </video>
        </div>

        <!-- Simple Controls -->
        <div class="absolute top-4 left-4 z-10">
            <a href="{{ route('movies.detail', $movie['id']) }}" class="text-white hover:text-gray-300 transition">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
        </div>
    </div>

    <!-- Movie Details Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white mb-4">Giới thiệu về {{ $movie['title'] }}</h2>
                    <p class="text-gray-300">{{ $movie['overview'] }}</p>
                </div>

                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white mb-4">Thông tin thêm</h2>
                    <div class="grid grid-cols-2 gap-4 text-gray-300">
                        <div>
                            <span class="font-semibold">Đạo diễn:</span>
                            <span class="ml-2">
                                @foreach($credits['crew'] ?? [] as $crew)
                                    @if($crew['job'] === 'Director')
                                        {{ $crew['name'] }}
                                    @endif
                                @endforeach
                            </span>
                        </div>
                        <div>
                            <span class="font-semibold">Diễn viên:</span>
                            <span class="ml-2">
                                @foreach(array_slice($credits['cast'] ?? [], 0, 3) as $cast)
                                    {{ $cast['name'] }}@if(!$loop->last), @endif
                                @endforeach
                            </span>
                        </div>
                        <div>
                            <span class="font-semibold">Thể loại:</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($movie['genres'] ?? [] as $genre)
                                    <span class="px-3 py-1 bg-gray-800 text-white rounded-full text-sm">
                                        {{ $genre['name'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <span class="font-semibold">Trạng thái:</span>
                            <span class="ml-2">{{ $movie['status'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1">
                <div class="bg-gray-900 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Thông tin phim</h3>
                    <div class="space-y-4 text-gray-300">
                        <div>
                            <span class="block text-sm text-gray-400">Đánh giá</span>
                            <span class="text-white">{{ round($movie['vote_average'], 1) }}/10 ({{ $movie['vote_count'] }} lượt)</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-400">Doanh thu</span>
                            <span class="text-white">${{ number_format($movie['revenue']) }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-400">Ngân sách</span>
                            <span class="text-white">${{ number_format($movie['budget']) }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-400">Ngôn ngữ gốc</span>
                            <span class="text-white">{{ strtoupper($movie['original_language']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Style cho controls mặc định */
video::-webkit-media-controls {
    display: flex !important;
}

video::-webkit-media-controls-panel {
    background: rgba(0, 0, 0, 0.7) !important;
}

video::-webkit-media-controls-play-button,
video::-webkit-media-controls-timeline,
video::-webkit-media-controls-current-time-display,
video::-webkit-media-controls-time-remaining-display,
video::-webkit-media-controls-mute-button,
video::-webkit-media-controls-volume-slider,
video::-webkit-media-controls-fullscreen-button {
    color: white !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('player');

    // Tự động phát video
    video.play().catch(error => {
        console.log('Auto-play was prevented:', error);
    });

    // Xử lý phím tắt
    document.addEventListener('keydown', (e) => {
        if (e.code === 'Space') {
            e.preventDefault();
            video.paused ? video.play() : video.pause();
        }
        if (e.code === 'ArrowUp') {
            video.volume = Math.min(1, video.volume + 0.1);
        }
        if (e.code === 'ArrowDown') {
            video.volume = Math.max(0, video.volume - 0.1);
        }
    });
});
</script>
@endpush
@endsection
