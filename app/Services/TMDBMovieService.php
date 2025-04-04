<?php

namespace App\Services;

use App\Services\Interfaces\MovieServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TMDBMovieService implements MovieServiceInterface
{
    protected string $apiKey;
    protected string $baseUrl;
    protected int $cacheTime;

    public function __construct()
    {
        Log::info('Initializing TMDBMovieService');

        $this->apiKey = config('services.tmdb.api_key');
        $this->baseUrl = config('services.tmdb.api_url');
        $this->cacheTime = 60 * 60; // 1 hour

        Log::info('TMDB configuration', [
            'api_key_length' => strlen($this->apiKey),
            'base_url' => $this->baseUrl,
            'cache_time' => $this->cacheTime
        ]);

        if (empty($this->apiKey)) {
            Log::error('TMDB API key is not configured');
            throw new \RuntimeException('TMDB API key is not configured. Please set TMDB_API_KEY in your .env file.');
        }

        Log::info('TMDBMovieService initialized successfully');
    }

    protected function makeRequest(string $endpoint, array $params = []): array
    {
        $params['api_key'] = $this->apiKey;
        $params['language'] = 'vi-VN';

        try {
            $url = $this->baseUrl . $endpoint;
            Log::info('Making TMDB API request', [
                'url' => $url,
                'endpoint' => $endpoint,
                'params' => array_merge($params, ['api_key' => '***']),
                'api_key_length' => strlen($this->apiKey)
            ]);

            $response = Http::get($url, $params);

            if (!$response->successful()) {
                Log::error('TMDB API request failed', [
                    'endpoint' => $endpoint,
                    'params' => array_merge($params, ['api_key' => '***']),
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                throw new \Exception('TMDB API request failed: ' . $response->body());
            }

            $data = $response->json();
            Log::info('TMDB API request successful', [
                'endpoint' => $endpoint,
                'response_count' => count($data['results'] ?? []),
                'status' => $response->status()
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('TMDB API error', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function getPopularMovies(int $page = 1): array
    {
        $cacheKey = "popular_movies_page_{$page}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($page) {
            return $this->makeRequest('/movie/popular', ['page' => $page]);
        });
    }

    public function getMovieDetails(int $tmdbId): array
    {
        $cacheKey = "movie_details_{$tmdbId}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($tmdbId) {
            return $this->makeRequest("/movie/{$tmdbId}");
        });
    }

    public function searchMovies(string $query, int $page = 1): array
    {
        $cacheKey = "search_movies_{$query}_page_{$page}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($query, $page) {
            return $this->makeRequest('/search/movie', [
                'query' => $query,
                'page' => $page
            ]);
        });
    }

    public function getMovieCredits(int $tmdbId): array
    {
        $cacheKey = "movie_credits_{$tmdbId}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($tmdbId) {
            return $this->makeRequest("/movie/{$tmdbId}/credits");
        });
    }

    public function getMovieVideos(int $tmdbId): array
    {
        $cacheKey = "movie_videos_{$tmdbId}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($tmdbId) {
            return $this->makeRequest("/movie/{$tmdbId}/videos");
        });
    }

    public function getSimilarMovies(int $tmdbId, int $page = 1): array
    {
        $cacheKey = "similar_movies_{$tmdbId}_page_{$page}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($tmdbId, $page) {
            return $this->makeRequest("/movie/{$tmdbId}/similar", ['page' => $page]);
        });
    }

    public function getTopRatedMovies(int $page = 1): array
    {
        $cacheKey = "top_rated_movies_page_{$page}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($page) {
            return $this->makeRequest('/movie/top_rated', ['page' => $page]);
        });
    }

    public function getUpcomingMovies(int $page = 1): array
    {
        $cacheKey = "upcoming_movies_page_{$page}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($page) {
            return $this->makeRequest('/movie/upcoming', ['page' => $page]);
        });
    }

    public function getMoviesByGenre(int $genreId, int $page = 1): array
    {
        $cacheKey = "movies_by_genre_{$genreId}_page_{$page}";

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($genreId, $page) {
            return $this->makeRequest('/discover/movie', [
                'with_genres' => $genreId,
                'page' => $page
            ]);
        });
    }
}
