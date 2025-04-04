@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-gray-700/50">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-6">
                <h2 class="text-center text-3xl font-extrabold text-white tracking-tight">
                    Thông tin cá nhân
                </h2>
            </div>

            <div class="p-8">
                @if(session('success'))
                <div class="mb-4 bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">
                            Họ tên
                        </label>
                        <div class="mt-1">
                            <input type="text" value="{{ Auth::user()->name }}" disabled
                                   class="appearance-none block w-full px-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-700/50 text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">
                            Email
                        </label>
                        <div class="mt-1">
                            <input type="email" value="{{ Auth::user()->email }}" disabled
                                   class="appearance-none block w-full px-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-700/50 text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">
                            Gói đăng ký
                        </label>
                        <div class="mt-1">
                            @if(Auth::user()->subscription_plan)
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/10 text-yellow-500">
                                    {{ ucfirst(Auth::user()->subscription_plan) }}
                                </span>
                                <span class="text-gray-400">
                                    Hết hạn: {{ Auth::user()->subscription_expires_at->format('d/m/Y') }}
                                </span>
                            </div>
                            @else
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-500/10 text-gray-400">
                                    Chưa đăng ký
                                </span>
                                <a href="{{ route('subscription.plans') }}" class="text-yellow-500 hover:text-yellow-400 transition duration-150 ease-in-out">
                                    Đăng ký ngay
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('movies.index') }}" class="px-4 py-2 border border-gray-600 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                        Quay lại
                    </a>
                    <a href="{{ route('favorites') }}" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                        <i class="fas fa-heart mr-2"></i>
                        Phim yêu thích
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
