<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để xem thông tin.');
        }

        // Tải đơn hàng thực tế
        $orders = Order::with('items.product')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        $ordersFormatted = $orders->map(function ($order) {
            $status = $order->status;
            $statusText = 'Chờ xác nhận';
            $color = 'text-[#FFB703] bg-amber-50';
            $icon = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
            
            if ($status === 'shipping') {
                $statusText = 'Đang giao hàng';
                $color = 'text-[#0068FF] bg-blue-50';
                $icon = 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4';
            } elseif ($status === 'completed') {
                $statusText = 'Đã giao thành công';
                $color = 'text-emerald-500 bg-emerald-50';
                $icon = 'M5 13l4 4L19 7';
            } elseif ($status === 'cancelled') {
                $statusText = 'Đã hủy';
                $color = 'text-red-500 bg-red-50';
                $icon = 'M6 18L18 6M6 6l12 12';
            }
            
            $firstItem = $order->items->first();
            $productName = $firstItem && $firstItem->product ? $firstItem->product->name : 'Sản phẩm';
            $productImage = $firstItem && $firstItem->product ? $firstItem->product->image : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=200';
            $productPrice = $firstItem ? number_format($firstItem->price, 0, ',', '.') . 'đ' : '0đ';
            $qty = $firstItem ? $firstItem->quantity : 0;
            
            return [
                'id' => 'RC-' . $order->id,
                'db_id' => $order->id,
                'date' => $order->order_date ? date('d/m/Y - H:i', strtotime($order->order_date)) : $order->created_at->format('d/m/Y - H:i'),
                'status' => ($status === 'pending') ? 'processing' : $status,
                'statusText' => $statusText,
                'color' => $color,
                'icon' => $icon,
                'name' => $productName,
                'variant' => 'Mặc định',
                'qty' => $qty,
                'price' => $productPrice,
                'total' => number_format($order->total_amount, 0, ',', '.') . 'đ',
                'payment' => 'Thanh toán nhận hàng (COD)',
                'isPaid' => $status === 'completed',
                'img' => $productImage
            ];
        });

        // Tải danh sách yêu thích thực tế
        $wishlist = $user->wishlistProducts()->get();
        $wishlistFormatted = $wishlist->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => number_format($product->price, 0, ',', '.') . 'đ',
                'img' => $product->image
            ];
        });

        return view('storefront.profile', [
            'user' => $user,
            'orders' => $ordersFormatted,
            'wishlist' => $wishlistFormatted
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Chưa đăng nhập!'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'user' => $user
        ]);
    }

    public function toggleWishlist(Request $request, int $productId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để yêu thích sản phẩm!'], 401);
        }

        $product = Product::findOrFail($productId);
        
        if ($user->wishlistProducts()->where('product_id', $productId)->exists()) {
            $user->wishlistProducts()->detach($productId);
            $favorited = false;
            $message = 'Đã xóa sản phẩm khỏi danh sách yêu thích!';
        } else {
            $user->wishlistProducts()->attach($productId);
            $favorited = true;
            $message = 'Đã thêm sản phẩm vào danh sách yêu thích!';
        }

        return response()->json([
            'success' => true,
            'favorited' => $favorited,
            'message' => $message
        ]);
    }

    public function cancelOrder(Request $request, int $orderId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Chưa đăng nhập!'], 401);
        }

        $order = Order::where('user_id', $user->id)->where('id', $orderId)->firstOrFail();
        
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json(['success' => false, 'message' => 'Không thể hủy đơn hàng ở trạng thái này!'], 400);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Đơn hàng đã được hủy thành công!'
        ]);
    }
}
