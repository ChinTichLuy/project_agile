<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function plans()
    {
        $plans = [
            [
                'id' => 'basic',
                'name' => 'Gói Cơ Bản',
                'price' => 99000,
                'duration' => '1 tháng',
                'features' => [
                    'Xem phim không quảng cáo',
                    'Chất lượng HD',
                    'Tải xuống giới hạn',
                    'Hỗ trợ 24/7'
                ]
            ],
            [
                'id' => 'premium',
                'name' => 'Gói Premium',
                'price' => 199000,
                'duration' => '1 tháng',
                'features' => [
                    'Tất cả tính năng gói Cơ Bản',
                    'Chất lượng 4K',
                    'Tải xuống không giới hạn',
                    'Xem phim trên nhiều thiết bị',
                    'Ưu tiên hỗ trợ'
                ],
                'popular' => true
            ],
            [
                'id' => 'family',
                'name' => 'Gói Gia Đình',
                'price' => 299000,
                'duration' => '1 tháng',
                'features' => [
                    'Tất cả tính năng gói Premium',
                    'Tối đa 4 tài khoản',
                    'Hồ sơ riêng cho mỗi thành viên',
                    'Kiểm soát nội dung cho trẻ em'
                ]
            ]
        ];

        return view('subscription.plans', compact('plans'));
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng ký gói VIP');
        }

        $plan = $request->input('plan');
        $plans = [
            'basic' => 99000,
            'premium' => 199000,
            'family' => 299000
        ];

        if (!array_key_exists($plan, $plans)) {
            return redirect()->route('subscription.plans')->with('error', 'Gói đăng ký không hợp lệ');
        }

        return view('subscription.checkout', [
            'plan' => $plan,
            'price' => $plans[$plan]
        ]);
    }

    public function processPayment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng ký gói VIP');
        }

        $request->validate([
            'plan' => 'required|in:basic,premium,family',
            'card_number' => 'required|string|min:16|max:19',
            'expiry' => 'required|string|regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
            'cvc' => 'required|string|min:3|max:4'
        ]);

        try {
            // TODO: Xử lý thanh toán thực tế
            $user = Auth::user();
            $plan = $request->input('plan');

            // Giả lập thanh toán thành công
            $user->update([
                'subscription_plan' => $plan,
                'subscription_expires_at' => now()->addMonth()
            ]);

            return redirect()->route('profile')->with('success', 'Đăng ký gói VIP thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý thanh toán. Vui lòng thử lại sau.');
        }
    }
}
