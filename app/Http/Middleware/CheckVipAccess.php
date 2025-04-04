<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckVipAccess
{
    public function handle(Request $request, Closure $next)
    {
        $movieId = $request->route('id');
        $apiKey = config('services.tmdb.api_key');

        if (!$apiKey) {
            Log::error('TMDB API key not found');
            return redirect()->route('movies.index')->with('error', 'Lỗi hệ thống');
        }

        try {
            $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
                'api_key' => $apiKey,
                'language' => 'vi-VN'
            ]);

            if (!$response->successful()) {
                return redirect()->route('movies.index')->with('error', 'Không tìm thấy thông tin phim');
            }

            $movie = $response->json();

            // Kiểm tra nếu phim có rating >= 8.5
            if ($movie['vote_average'] >= 8.5) {
                // Nếu user là admin hoặc có role VIP thì cho phép truy cập
                if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'vip')) {
                    return redirect()->route('vip.packages')->with('error', 'Bạn cần nâng cấp tài khoản VIP để xem phim này.');
                }
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Error checking VIP access: ' . $e->getMessage());
            return redirect()->route('movies.index')->with('error', 'Lỗi hệ thống');
        }
    }
}
