<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;

class MovieController extends Controller
{
    public function index()
    {
        try {
            $apiKey = config('services.tmdb.api_key');
            if (!$apiKey) {
                Log::error('TMDB API key not found in config');
                return view('movies.index', ['categories' => []]);
            }

            // Lấy phim phổ biến
            $popularResponse = Http::get('https://api.themoviedb.org/3/movie/popular', [
                'api_key' => $apiKey
            ]);

            if (!$popularResponse->successful()) {
                Log::error('TMDB API Error', [
                    'status' => $popularResponse->status(),
                    'body' => $popularResponse->body()
                ]);
                return view('movies.index', ['categories' => []]);
            }

            $popularMovies = $popularResponse->json()['results'] ?? [];

            // Lấy 5 phim ngẫu nhiên từ danh sách phim phổ biến
            $randomMovies = collect($popularMovies)->shuffle()->take(5)->values()->all();

            // Lấy video cho 5 phim ngẫu nhiên
            foreach ($randomMovies as &$movie) {
                $videoResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}/videos", [
                    'api_key' => $apiKey
                ]);
                if ($videoResponse->successful()) {
                    $movie['videos'] = $videoResponse->json();
                }
            }

            // Lấy phim đánh giá cao
            $topRatedResponse = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
                'api_key' => $apiKey
            ]);

            $topRatedMovies = $topRatedResponse->successful() ? $topRatedResponse->json()['results'] ?? [] : [];

            // Lấy phim sắp chiếu
            $upcomingResponse = Http::get('https://api.themoviedb.org/3/movie/upcoming', [
                'api_key' => $apiKey
            ]);

            $upcomingMovies = $upcomingResponse->successful() ? $upcomingResponse->json()['results'] ?? [] : [];

            $categories = [
                [
                    'name' => 'Phim phổ biến',
                    'movies' => $popularMovies
                ],
                [
                    'name' => 'Phim đánh giá cao',
                    'movies' => $topRatedMovies
                ],
                [
                    'name' => 'Phim sắp chiếu',
                    'movies' => $upcomingMovies
                ]
            ];

            return view('movies.index', compact('categories', 'randomMovies'));
        } catch (\Exception $e) {
            Log::error('Error in MovieController@index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('movies.index', ['categories' => []]);
        }
    }

    public function show($id)
    {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return redirect()->route('movies.index')->with('error', 'ID phim không hợp lệ');
            }

            $apiKey = config('services.tmdb.api_key');
            if (!$apiKey) {
                Log::error('TMDB API key not found in config');
                return redirect()->route('movies.index')->with('error', 'Không thể tải thông tin phim');
            }

            $response = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
                'api_key' => $apiKey,
                'append_to_response' => 'credits,videos,similar'
            ]);

            if (!$response->successful()) {
                Log::error('TMDB API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return redirect()->route('movies.index')->with('error', 'Không thể tải thông tin phim');
            }

            $movie = $response->json();
            $credits = $movie['credits'] ?? [];
            $videos = $movie['videos'] ?? [];
            $similarMovies = $movie['similar']['results'] ?? [];

            // Lấy bình luận của phim
            $comments = Comment::with('user')
                ->where('movie_id', $id)
                ->latest()
                ->get();

            return view('movies.detail', compact('movie', 'credits', 'videos', 'similarMovies', 'comments'));
        } catch (\Exception $e) {
            Log::error('Error in MovieController@show', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('movies.index')->with('error', 'Đã xảy ra lỗi khi tải thông tin phim');
        }
    }

    public function watch($id)
    {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return redirect()->route('movies.index')->with('error', 'ID phim không hợp lệ');
            }

            $apiKey = config('services.tmdb.api_key');
            if (!$apiKey) {
                Log::error('TMDB API key not found in config');
                return redirect()->route('movies.index')->with('error', 'Không thể tải thông tin phim');
            }

            $response = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
                'api_key' => $apiKey,
                'append_to_response' => 'credits,videos,similar'
            ]);

            if (!$response->successful()) {
                Log::error('TMDB API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return redirect()->route('movies.index')->with('error', 'Không thể tải thông tin phim');
            }

            $movie = $response->json();
            $credits = $movie['credits'] ?? [];
            $videos = $movie['videos'] ?? [];
            $similarMovies = $movie['similar']['results'] ?? [];

            // Lấy bình luận của phim
            $comments = Comment::with('user')
                ->where('movie_id', $id)
                ->latest()
                ->get();

            return view('movies.watch', compact('movie', 'credits', 'videos', 'similarMovies', 'comments'));
        } catch (\Exception $e) {
            Log::error('Error in MovieController@watch', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('movies.index')->with('error', 'Đã xảy ra lỗi khi tải thông tin phim');
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->query('query');
            $page = $request->query('page', 1);

            if (empty($query)) {
                return redirect()->route('movies.index');
            }

            $apiKey = config('services.tmdb.api_key');
            if (!$apiKey) {
                return view('movies.search', [
                    'query' => $query,
                    'movies' => [],
                    'currentPage' => 1,
                    'totalPages' => 1,
                    'error' => 'Không thể tìm kiếm phim'
                ]);
            }

            $response = Http::get('https://api.themoviedb.org/3/search/movie', [
                'api_key' => $apiKey,
                'query' => $query,
                'page' => $page
            ]);

            if (!$response->successful()) {
                return view('movies.search', [
                    'query' => $query,
                    'movies' => [],
                    'currentPage' => 1,
                    'totalPages' => 1,
                    'error' => 'Không thể tìm kiếm phim'
                ]);
            }

            $searchResults = $response->json();

            return view('movies.search', [
                'query' => $query,
                'movies' => $searchResults['results'] ?? [],
                'currentPage' => $searchResults['page'] ?? 1,
                'totalPages' => $searchResults['total_pages'] ?? 1,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in MovieController@search', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('movies.search', [
                'query' => $request->query('query'),
                'movies' => [],
                'currentPage' => 1,
                'totalPages' => 1,
                'error' => 'Không thể tìm kiếm phim. Vui lòng thử lại sau.'
            ]);
        }
    }

    public function getMovieDetails($id)
    {
        $apiKey = config('services.tmdb.api_key');
        if (!$apiKey) {
            \Log::error('TMDB API key not found');
            return null;
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get("https://api.themoviedb.org/3/movie/{$id}", [
                'query' => [
                    'api_key' => $apiKey,
                    'language' => 'vi-VN'
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('Error fetching movie details: ' . $e->getMessage());
            return null;
        }
    }
}
