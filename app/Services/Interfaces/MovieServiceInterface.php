<?php

namespace App\Services\Interfaces;

interface MovieServiceInterface
{
    public function getPopularMovies(int $page = 1): array;
    public function getMovieDetails(int $tmdbId): array;
    public function getMovieCredits(int $tmdbId): array;
    public function getMovieVideos(int $tmdbId): array;
    public function getSimilarMovies(int $tmdbId, int $page = 1): array;
    public function searchMovies(string $query, int $page = 1): array;
    public function getTopRatedMovies(int $page = 1): array;
    public function getUpcomingMovies(int $page = 1): array;
    public function getMoviesByGenre(int $genreId, int $page = 1): array;
}
