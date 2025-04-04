@extends('layouts.app')

@section('title', 'Tìm kiếm phim')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Kết quả tìm kiếm cho: "{{ $query }}"</h1>

    @if(isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endif

    @if(empty($movies))
        <div class="text-center py-8">
            <p class="text-gray-600">Không tìm thấy kết quả nào phù hợp.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($movies as $movie)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <a href="{{ route('movies.show', $movie['id']) }}">
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                             alt="{{ $movie['title'] }}"
                             class="w-full h-64 object-cover">
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('movies.show', $movie['id']) }}" class="hover:text-blue-600">
                                {{ $movie['title'] }}
                            </a>
                        </h3>
                        <div class="flex items-center text-gray-600 text-sm">
                            <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ round($movie['vote_average'], 1) }}/10</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($totalPages > 1)
            <div class="mt-8 flex justify-center">
                <div class="flex space-x-2">
                    @if($currentPage > 1)
                        <a href="{{ route('movies.search', ['query' => $query, 'page' => $currentPage - 1]) }}"
                           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Trước
                        </a>
                    @endif

                    @for($i = 1; $i <= $totalPages; $i++)
                        <a href="{{ route('movies.search', ['query' => $query, 'page' => $i]) }}"
                           class="px-4 py-2 {{ $i === $currentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded">
                            {{ $i }}
                        </a>
                    @endfor

                    @if($currentPage < $totalPages)
                        <a href="{{ route('movies.search', ['query' => $query, 'page' => $currentPage + 1]) }}"
                           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Sau
                        </a>
                    @endif
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
