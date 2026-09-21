<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo các danh mục mặc định
        $cat1 = Category::create(['name' => 'Áo Nam', 'description' => 'Các loại áo dành cho nam']);
        $cat2 = Category::create(['name' => 'Quần Nam', 'description' => 'Các loại quần dành cho nam']);
        $cat3 = Category::create(['name' => 'Áo Nữ', 'description' => 'Các loại áo dành cho nữ']);
        $cat4 = Category::create(['name' => 'Phụ Kiện', 'description' => 'Các loại phụ kiện thời trang']);

        // 2. Tạo tài khoản mẫu
        $customer = User::create([
            'name' => 'Bùi Thị Kiều Ngân',
            'email' => 'ngan.bui@example.com',
            'password' => Hash::make('123456'),
            'phone' => '0901234567',
            'address' => '123 Nguyễn Văn Linh, Phường 1, Quận Tân Bình, Hồ Chí Minh',
            'role' => 'customer'
        ]);

        $admin = User::create([
            'name' => 'Quản trị viên',
            'email' => 'admin@redcherry.vn',
            'password' => Hash::make('123456'),
            'phone' => '0999999999',
            'address' => 'Trụ sở chính RedCherry',
            'role' => 'admin'
        ]);

        // 3. Tạo các sản phẩm mẫu
        $p1 = Product::create([
            'category_id' => $cat1->id,
            'sku' => 'RC-POLO-001',
            'name' => 'Áo Jacket Leather Đen Premium',
            'description' => 'Chất liệu da PU phân tầng cao cấp, mang lại bề mặt lỳ sang trọng, chống thấm.',
            'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400',
            'price' => 899000,
            'quantity' => 145,
            'status' => 'active'
        ]);

        $p2 = Product::create([
            'category_id' => $cat2->id,
            'sku' => 'RC-CARGO-002',
            'name' => 'Quần Cargo Túi Hộp',
            'description' => 'Quần túi hộp phong cách cá tính năng động.',
            'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=400',
            'price' => 459000,
            'quantity' => 20,
            'status' => 'active'
        ]);

        $p3 = Product::create([
            'category_id' => $cat1->id,
            'sku' => 'RC-TSHIRT-003',
            'name' => 'Áo Thun Trắng Basic',
            'description' => 'Áo thun cotton 100% thoáng mát.',
            'image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=400',
            'price' => 180000,
            'quantity' => 100,
            'status' => 'active'
        ]);

        $p4 = Product::create([
            'category_id' => $cat2->id,
            'sku' => 'RC-JEAN-004',
            'name' => 'Quần Jean Ống Rộng',
            'description' => 'Quần jean chất denim cao cấp.',
            'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=400',
            'price' => 350000,
            'quantity' => 0, // Hết hàng
            'status' => 'inactive'
        ]);

        $p5 = Product::create([
            'category_id' => $cat1->id,
            'sku' => 'RC-WIND-005',
            'name' => 'Áo Khoác Windbreaker',
            'description' => 'Áo gió chống nước nhẹ, cản gió cực tốt.',
            'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=400',
            'price' => 650000,
            'quantity' => 12,
            'status' => 'active'
        ]);

        // 4. Tạo Wishlists mẫu cho người dùng Kiều Ngân
        $customer->wishlistProducts()->attach([$p1->id, $p2->id, $p3->id]);

        // 5. Tạo đơn hàng mẫu cho người dùng Kiều Ngân
        // Đơn 1: Chờ xác nhận (processing / pending)
        $o1 = Order::create([
            'id' => 889922, // Tương đương RC-889922
            'user_id' => $customer->id,
            'order_date' => '2026-06-12 14:30:00',
            'shipping_address' => $customer->address,
            'total_amount' => 899000,
            'status' => 'pending'
        ]);
        OrderItem::create([
            'order_id' => $o1->id,
            'product_id' => $p1->id,
            'quantity' => 1,
            'price' => 899000,
            'subtotal' => 899000
        ]);

        // Đơn 2: Đang giao hàng (shipping)
        $o2 = Order::create([
            'id' => 552211, // Tương đương RC-552211
            'user_id' => $customer->id,
            'order_date' => '2026-06-10 09:15:00',
            'shipping_address' => $customer->address,
            'total_amount' => 459000,
            'status' => 'shipping'
        ]);
        OrderItem::create([
            'order_id' => $o2->id,
            'product_id' => $p2->id,
            'quantity' => 1,
            'price' => 459000,
            'subtotal' => 459000
        ]);

        // Đơn 3: Hoàn thành (completed)
        $o3 = Order::create([
            'id' => 443322, // Tương đương RC-443322
            'user_id' => $customer->id,
            'order_date' => '2026-06-05 18:20:00',
            'shipping_address' => $customer->address,
            'total_amount' => 360000,
            'status' => 'completed'
        ]);
        OrderItem::create([
            'order_id' => $o3->id,
            'product_id' => $p3->id,
            'quantity' => 2,
            'price' => 180000,
            'subtotal' => 360000
        ]);

        // Đơn 4: Đã hủy (cancelled)
        $o4 = Order::create([
            'id' => 112233, // Tương đương RC-112233
            'user_id' => $customer->id,
            'order_date' => '2026-06-01 10:00:00',
            'shipping_address' => $customer->address,
            'total_amount' => 650000,
            'status' => 'cancelled'
        ]);
        OrderItem::create([
            'order_id' => $o4->id,
            'product_id' => $p5->id,
            'quantity' => 1,
            'price' => 650000,
            'subtotal' => 650000
        ]);
    }
}
