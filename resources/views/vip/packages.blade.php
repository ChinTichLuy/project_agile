@extends('layouts.app')

@section('title', 'Gói VIP')

@section('content')
<div class="min-h-screen bg-gray-900 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-white mb-8 text-center">Nâng cấp tài khoản VIP</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Gói Basic -->
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Gói Basic</h2>
                <div class="text-3xl font-bold text-white mb-4">199.000đ<span class="text-sm text-gray-400">/tháng</span></div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Xem phim chất lượng HD
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Không quảng cáo
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Xem phim VIP
                    </li>
                </ul>
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Đăng ký ngay
                </button>
            </div>

            <!-- Gói Premium -->
            <div class="bg-gray-800 rounded-lg p-6 border-2 border-yellow-500">
                <div class="absolute top-0 right-0 bg-yellow-500 text-white px-3 py-1 rounded-bl-lg">
                    Phổ biến
                </div>
                <h2 class="text-xl font-semibold text-white mb-4">Gói Premium</h2>
                <div class="text-3xl font-bold text-white mb-4">399.000đ<span class="text-sm text-gray-400">/tháng</span></div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Xem phim chất lượng 4K
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Không quảng cáo
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Xem phim VIP
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Tải phim về xem offline
                    </li>
                </ul>
                <button class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition">
                    Đăng ký ngay
                </button>
            </div>

            <!-- Gói Family -->
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Gói Family</h2>
                <div class="text-3xl font-bold text-white mb-4">699.000đ<span class="text-sm text-gray-400">/tháng</span></div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Xem phim chất lượng 4K
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Không quảng cáo
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Xem phim VIP
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Tải phim về xem offline
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Tối đa 4 thiết bị cùng lúc
                    </li>
                </ul>
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Đăng ký ngay
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
