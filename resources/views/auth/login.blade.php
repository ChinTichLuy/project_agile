@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-gray-700/50">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-6">
                <h2 class="text-center text-3xl font-extrabold text-white tracking-tight">
                    Đăng nhập
                </h2>
                <p class="mt-2 text-center text-sm text-yellow-100">
                    Đăng nhập để tiếp tục
                </p>
            </div>

            <div class="p-8">
                @if($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">
                            Email
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" required
                                   class="appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                   placeholder="you@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">
                            Mật khẩu
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                   class="appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                   class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-gray-600 rounded bg-gray-700/50">
                            <label for="remember" class="ml-2 block text-sm text-gray-300">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out transform hover:scale-[1.02]">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Đăng nhập
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-400">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="font-medium text-yellow-500 hover:text-yellow-400 transition duration-150 ease-in-out">
                            Đăng ký ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
