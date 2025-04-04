@extends('layouts.app')

@section('title', 'Gói đăng ký VIP')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl">
                Chọn gói đăng ký phù hợp
            </h1>
            <p class="mt-5 max-w-xl mx-auto text-xl text-gray-300">
                Nâng cấp trải nghiệm xem phim của bạn với các gói VIP đặc biệt
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            @foreach($plans as $plan)
            <div class="relative bg-gray-800/50 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-gray-700/50 transform transition duration-300 hover:scale-105">
                @if(isset($plan['popular']))
                <div class="absolute top-0 right-0 bg-yellow-500 text-white px-4 py-1 rounded-bl-lg text-sm font-semibold">
                    Phổ biến nhất
                </div>
                @endif

                <div class="p-8">
                    <h3 class="text-2xl font-bold text-white mb-2">{{ $plan['name'] }}</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-4xl font-extrabold text-white">{{ number_format($plan['price']) }}</span>
                        <span class="text-gray-400 ml-2">đ/{{ $plan['duration'] }}</span>
                    </div>

                    <ul class="space-y-4 mb-8">
                        @foreach($plan['features'] as $feature)
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-300">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>

                    @if(Auth::check())
                    <form action="{{ route('subscription.checkout') }}" method="GET">
                        <input type="hidden" name="plan" value="{{ $plan['id'] }}">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                            <i class="fas fa-crown mr-2"></i>
                            Chọn gói này
                        </button>
                    </form>
                    @else
                    <div class="space-y-4">
                        <a href="{{ route('login') }}" onclick="sessionStorage.setItem('redirect_to_subscription', 'true')" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Đăng nhập để đăng ký
                        </a>
                        <a href="{{ route('register') }}" onclick="sessionStorage.setItem('redirect_to_subscription', 'true')" class="w-full flex justify-center py-3 px-4 border border-yellow-500 rounded-lg shadow-sm text-sm font-medium text-yellow-500 bg-transparent hover:bg-yellow-500/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                            <i class="fas fa-user-plus mr-2"></i>
                            Đăng ký tài khoản mới
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-400">
                Bạn đã có tài khoản?
                <a href="{{ route('login') }}" class="text-yellow-500 hover:text-yellow-400 transition duration-150 ease-in-out">
                    Đăng nhập
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
