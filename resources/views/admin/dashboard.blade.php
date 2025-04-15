@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Thống kê tổng quan -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Thống kê người dùng -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-users text-2xl text-yellow-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tổng số người dùng
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $totalUsers }}
                                </div>
                                <div class="ml-2 text-sm text-green-500">
                                    + 2 tháng này
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.users') }}" class="font-medium text-yellow-500 hover:text-yellow-400">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>

        <!-- Thống kê phim -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-film text-2xl text-blue-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tổng số phim
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ $totalMovies }}
                                </div>
                                <div class="ml-2 text-sm text-green-500">
                                    + 100 tháng này
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.movies') }}" class="font-medium text-blue-500 hover:text-blue-400">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>

        <!-- Thống kê danh mục -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 p-3 rounded-full">
                        <i class="fas fa-list text-2xl text-green-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tổng số danh mục
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    1000000$
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-green-500 hover:text-green-400">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>

        <!-- Thống kê comment -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-comments text-2xl text-purple-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Tổng số bình luận
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    99999
                                </div>
                                <div class="ml-2 text-sm text-green-500">
                                    +999 hôm nay
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-purple-500 hover:text-purple-400">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Các chức năng nhanh -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Quản lý danh mục -->
        <a href="#" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <div class="bg-green-100 p-4 rounded-full inline-block">
                            <i class="fas fa-list text-3xl text-green-500"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Quản lý danh mục</h3>
                        <p class="mt-1 text-sm text-gray-500">Thêm, sửa, xóa danh mục phim</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Quản lý bình luận -->
        <a href="#" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <div class="bg-purple-100 p-4 rounded-full inline-block">
                            <i class="fas fa-comments text-3xl text-purple-500"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Quản lý bình luận</h3>
                        <p class="mt-1 text-sm text-gray-500">Kiểm duyệt và quản lý bình luận</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Thêm phim mới -->
        <a href="#" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <div class="bg-blue-100 p-4 rounded-full inline-block">
                            <i class="fas fa-plus text-3xl text-blue-500"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Thêm phim mới</h3>
                        <p class="mt-1 text-sm text-gray-500">Thêm phim mới vào hệ thống</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Xem báo cáo -->
        <a href="#" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <div class="bg-yellow-100 p-4 rounded-full inline-block">
                            <i class="fas fa-chart-bar text-3xl text-yellow-500"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Báo cáo thống kê</h3>
                        <p class="mt-1 text-sm text-gray-500">Xem các báo cáo chi tiết</p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Biểu đồ thống kê -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Biểu đồ người dùng mới -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Người dùng mới trong 7 ngày qua</h3>
                <canvas id="newUsersChart"></canvas>
            </div>
        </div>

        <!-- Biểu đồ phim mới -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Phim mới trong 7 ngày qua</h3>
                <canvas id="newMoviesChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ người dùng mới
    new Chart(document.getElementById('newUsersChart'), {
        type: 'line',
        data: {
            labels: newUsersChart
            datasets: [{
                label: 'Người dùng mới',
                data: newUsersChart,
                borderColor: '#f59e0b',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Biểu đồ phim mới
    new Chart(document.getElementById('newMoviesChart'), {
        type: 'line',
        data: {
            labels: newMoviesChart,
            datasets: [{
                label: 'Phim mới',
                data: newMoviesChart,
                borderColor: '#3b82f6',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
@endsection
