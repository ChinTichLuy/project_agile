<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Movie Website')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-gradient {
            background: linear-gradient(to bottom, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
        }
        .movie-card {
            transition: transform 0.3s ease;
        }
        .movie-card:hover {
            transform: scale(1.05);
        }
        .movie-poster {
            height: 300px;
            object-fit: cover;
        }
        .nav-gradient {
            background: linear-gradient(to bottom, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 nav-gradient">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('movies.index') }}" class="text-3xl font-bold text-red-600">MovieFlix</a>

                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-4">
                        <form action="{{ route('movies.search') }}" method="GET" class="flex items-center">
                            <input type="text" name="query" placeholder="Tìm kiếm phim..."
                                   class="px-4 py-2 rounded-lg bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <button type="submit" class="ml-2 text-gray-400 hover:text-white">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>

                        @guest
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">
                                <i class="fas fa-sign-in-alt mr-1"></i>
                                Đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-gradient-to-r from-yellow-500 to-yellow-600 text-white hover:from-yellow-600 hover:to-yellow-700 transition duration-150 ease-in-out">
                                <i class="fas fa-user-plus mr-1"></i>
                                Đăng ký
                            </a>
                        </div>
                        @else
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('favorites') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">
                                <i class="fas fa-heart mr-1"></i>
                                Yêu thích
                            </a>
                            <a href="{{ route('subscription.plans') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">
                                <i class="fas fa-crown mr-1"></i>
                                Gói đăng ký
                            </a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-gray-300 hover:text-white transition duration-150 ease-in-out">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full">
                                    <span>{{ Auth::user()->name }}</span>
                                </button>

                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                    <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Thông tin tài khoản
                                    </a>
                                    @if(Auth::user()->role === 'admin')
                                        @if(request()->is('admin*'))
                                            <a href="{{ route('movies.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-home mr-2"></i> Trang chủ
                                            </a>
                                        @else
                                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-tachometer-alt mr-2"></i> Trang quản trị
                                            </a>
                                        @endif
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black/90 py-12 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-red-600 mb-4">MovieFlix</h3>
                    <p class="text-gray-400">Website xem phim trực tuyến chất lượng cao</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liên kết</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('movies.index') }}" class="text-gray-400 hover:text-red-600 transition">Trang chủ</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-red-600 transition">Giới thiệu</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-red-600 transition">Trợ giúp</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-600 transition">Điều khoản</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liên hệ</h4>
                    <ul class="space-y-2">
                        <li class="text-gray-400"><i class="fas fa-envelope mr-2"></i>contact@moviefix.com</li>
                        <li class="text-gray-400"><i class="fas fa-phone mr-2"></i>+84 123 456 789</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 MovieFlix. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
