@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-gray-700/50">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-6">
                <h2 class="text-center text-3xl font-extrabold text-white tracking-tight">
                    Thanh toán
                </h2>
                <p class="mt-2 text-center text-sm text-yellow-100">
                    Hoàn tất đăng ký gói VIP của bạn
                </p>
            </div>

            <div class="p-8">
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-white mb-4">Thông tin đơn hàng</h3>
                    <div class="bg-gray-700/30 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-300">Gói đăng ký:</span>
                            <span class="text-white font-medium">{{ ucfirst($plan) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Tổng tiền:</span>
                            <span class="text-yellow-500 font-bold text-xl">{{ number_format($price) }}đ</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('subscription.process') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $plan }}">

                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-300 mb-1">
                            Số thẻ
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-credit-card text-gray-400"></i>
                            </div>
                            <input id="card_number" name="card_number" type="text" required
                                   class="appearance-none block w-full pl-10 pr-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                   placeholder="1234 5678 9012 3456">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expiry" class="block text-sm font-medium text-gray-300 mb-1">
                                Ngày hết hạn
                            </label>
                            <div class="mt-1">
                                <input id="expiry" name="expiry" type="text" required
                                       class="appearance-none block w-full px-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                       placeholder="MM/YY">
                            </div>
                        </div>

                        <div>
                            <label for="cvc" class="block text-sm font-medium text-gray-300 mb-1">
                                Mã CVC
                            </label>
                            <div class="mt-1">
                                <input id="cvc" name="cvc" type="text" required
                                       class="appearance-none block w-full px-3 py-2.5 border border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-700/50 text-white transition duration-150 ease-in-out"
                                       placeholder="123">
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out transform hover:scale-[1.02]">
                            <i class="fas fa-lock mr-2"></i>
                            Thanh toán
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
