@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-gray-700/50">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-6">
                <h2 class="text-center text-3xl font-extrabold text-white tracking-tight">
                    Đăng ký tài khoản
                </h2>
                <p class="mt-2 text-center text-sm text-red-100">
                    Tham gia cộng đồng yêu phim của chúng tôi
                </p>
            </div>
            <div class="p-8">
                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-200 px-4 py-3 rounded-lg relative mb-6">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">
                            Họ và tên
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input id="name" name="name" type="text" required
                                   class="appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                   value="{{ old('name') }}"
                                   placeholder="Nhập họ và tên của bạn">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">
                            Email
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" required
                                   class="appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                   value="{{ old('email') }}"
                                   placeholder="Nhập email của bạn">
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
                                   class="appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                   placeholder="Nhập mật khẩu của bạn">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">
                            Xác nhận mật khẩu
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                   class="appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                   placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out transform hover:scale-[1.02]">
                            <i class="fas fa-user-plus mr-2"></i>
                            Đăng ký tài khoản miễn phí
                        </button>

                        <a href="{{ route('subscription.plans') }}"
                           class="w-full flex justify-center py-3 px-4 border border-yellow-500 rounded-lg shadow-sm text-sm font-medium text-yellow-500 bg-transparent hover:bg-yellow-500/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out transform hover:scale-[1.02]">
                            <i class="fas fa-crown mr-2"></i>
                            Đăng ký gói VIP ngay
                        </a>
                    </div>
                </form>
            </div>
            <div class="px-8 py-6 bg-gray-800/30 border-t border-gray-700/50">
                <p class="text-center text-sm text-gray-400">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="font-medium text-red-400 hover:text-red-300 transition duration-150 ease-in-out">
                        Đăng nhập
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
