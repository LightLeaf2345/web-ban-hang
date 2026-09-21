<?php if (isset($component)) { $__componentOriginal7651faf8e4a1e278424aad70c82de3ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="flex flex-col h-full gap-3" x-data="orderManager()" x-cloak>
        
        <div class="flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Quản Lý Đơn Hàng</h1>
                <div class="bg-amber-100 text-amber-700 text-[11px] font-black px-2.5 py-1 rounded-full border border-amber-200 shadow-sm">
                    12 Đơn Mới
                </div>
            </div>
            
            <div class="flex gap-2">
                <button @click="exportCSV()" class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600 font-bold text-[11px] px-4 py-2 rounded-full hover:bg-slate-50 transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Xuất CSV</span>
                </button>
                
                <button @click="alert('Đang chuyển hướng sang giao diện máy bán hàng POS...')" class="flex items-center gap-2 bg-[#C1121F] text-white font-bold text-[11px] px-5 py-2 rounded-full hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tạo Đơn POS</span>
                </button>
            </div>
        </div>

        <div class="flex-1 min-h-0 flex gap-4">
            
            <div class="flex-1 min-w-0 flex flex-col gap-3">
                
                <div class="bg-white rounded-[20px] p-2.5 shadow-sm border border-slate-100 flex items-center justify-between shrink-0 transition-all min-h-[52px]">
                    <div x-show="selectedItems.length === 0" class="flex items-center gap-2 w-full overflow-x-auto hide-scroll">
                        <div class="relative w-[260px] shrink-0">
                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="searchQuery" placeholder="Tìm mã đơn, tên, SĐT..." class="w-full bg-slate-50 border border-slate-100 text-[11px] font-bold text-slate-800 rounded-full pl-8 pr-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                        </div>
                        <div class="w-px h-4 bg-slate-200 shrink-0 mx-0.5"></div>
                        <select x-model="statusFilter" class="text-[11px] font-bold bg-slate-50 border border-slate-100 rounded-full px-3 py-1.5 outline-none text-slate-700 cursor-pointer">
                            <option value="all">Tất cả trạng thái</option>
                            <option value="pending">Chờ xác nhận (12)</option>
                            <option value="shipping">Đang giao hàng</option>
                            <option value="completed">Đã hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                        <select class="text-[11px] font-bold bg-slate-50 border border-slate-100 rounded-full px-3 py-1.5 outline-none text-slate-700 cursor-pointer">
                            <option>Hôm nay</option>
                            <option>7 ngày qua</option>
                            <option>Tháng này</option>
                        </select>
                    </div>

                    <div x-show="selectedItems.length > 0" style="display: none;" class="flex items-center gap-3 w-full">
                        <div class="flex items-center gap-1.5 text-[11px] font-black text-[#C1121F] bg-red-50 px-3 py-1 rounded-full border border-red-100">
                            <span x-text="`Đã chọn ${selectedItems.length} đơn hàng`"></span>
                        </div>
                        <button @click="bulkUpdateStatus('shipping')" class="px-4 py-1 rounded-full bg-blue-600 text-white text-[11px] font-bold hover:bg-blue-700 transition-colors shadow-sm">Duyệt & Giao hàng</button>
                    </div>
                </div>

                <div class="flex-1 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                    <div class="flex-1 overflow-x-auto overflow-y-scroll hide-scroll relative">
                        <table class="w-full text-left border-collapse table-fixed min-w-[650px]">
                            <thead class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-slate-100 z-10 shadow-sm">
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                                    <th class="px-3 py-3 w-10 text-center"><input type="checkbox" x-model="selectAll" @change="toggleAll()" class="w-3.5 h-3.5 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] cursor-pointer"></th>
                                    <th class="px-3 py-3 w-[20%]">Mã Đơn</th>
                                    <th class="px-3 py-3 w-[30%]">Khách Hàng</th>
                                    <th class="px-3 py-3 w-[15%]">Tổng Tiền</th>
                                    <th class="px-3 py-3 w-[20%] text-center">Trạng Thái</th>
                                    <th class="px-3 py-3 w-[10%] text-right">Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody class="text-[12px] divide-y divide-slate-50">
                                <template x-for="order in filteredOrders()" :key="order.id">
                                    <tr @click="selectedOrder = order" class="transition-colors group cursor-pointer" :class="(selectedOrder && selectedOrder.id === order.id) || selectedItems.includes(order.id) ? 'bg-red-50/40' : 'hover:bg-slate-50/60'">
                                        <td class="px-3 py-3 text-center" @click.stop=""><input type="checkbox" :value="order.id" x-model="selectedItems" @change="checkItem()" class="w-3.5 h-3.5 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] cursor-pointer"></td>
                                        
                                        <td class="px-3 py-3">
                                            <div class="font-black text-[12px] text-slate-900 group-hover:text-[#C1121F] transition-colors truncate" x-text="order.code"></div>
                                            <div class="text-[10px] font-bold text-slate-400 mt-0.5" x-text="order.date"></div>
                                        </td>
                                        
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 shrink-0 uppercase" x-text="order.customerName.charAt(0)"></div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-bold text-[12px] text-slate-800 truncate" x-text="order.customerName"></div>
                                                    <div class="text-[10px] font-bold text-slate-400 truncate" x-text="order.customerPhone"></div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-3 py-3 font-black text-slate-900 truncate" x-text="order.total"></td>
                                        
                                        <td class="px-3 py-3 text-center">
                                            <span class="inline-block text-[9px] font-black uppercase tracking-wide px-2 py-0.5 rounded" 
                                                  :class="{
                                                      'bg-amber-100 text-amber-700': order.status === 'pending',
                                                      'bg-blue-100 text-blue-700': order.status === 'shipping',
                                                      'bg-emerald-100 text-emerald-700': order.status === 'completed',
                                                      'bg-slate-100 text-slate-500': order.status === 'cancelled'
                                                  }" 
                                                  x-text="getStatusText(order.status)"></span>
                                        </td>
                                        
                                        <td class="px-3 py-3 text-right">
                                            <button class="p-1 text-slate-400 hover:text-[#C1121F] hover:bg-red-50 transition-colors rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredOrders().length === 0" style="display: none;">
                                    <td colspan="6" class="px-4 py-8 text-center text-[12px] font-bold text-slate-400">Không tìm thấy đơn hàng nào.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="w-[340px] shrink-0 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden p-4">
                <template x-if="selectedOrder">
                    <div class="flex flex-col flex-1 min-h-0">
                        
                        <div class="border-b border-slate-100 pb-2.5 mb-2.5 shrink-0 flex justify-between items-start">
                            <div>
                                <h3 class="text-[15px] font-black text-slate-900 tracking-tight" x-text="selectedOrder.code"></h3>
                                <p class="text-[10px] text-slate-400 font-bold mt-0.5" x-text="selectedOrder.date"></p>
                            </div>
                            <span class="inline-block text-[9px] font-black uppercase tracking-wide px-2 py-1 rounded" 
                                :class="{ 'bg-amber-100 text-amber-700': selectedOrder.status === 'pending', 'bg-blue-100 text-blue-700': selectedOrder.status === 'shipping', 'bg-emerald-100 text-emerald-700': selectedOrder.status === 'completed', 'bg-slate-100 text-slate-500': selectedOrder.status === 'cancelled' }" 
                                x-text="getStatusText(selectedOrder.status)"></span>
                        </div>

                        <div class="bg-slate-50/70 rounded-xl p-3 border border-slate-100 mb-2.5 shrink-0 flex flex-col gap-2">
                            <div class="flex items-start gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <div class="text-[12px] font-black text-slate-800 leading-tight" x-text="selectedOrder.customerName + ' - ' + selectedOrder.customerPhone"></div>
                            </div>
                            <div class="flex items-start gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <div class="text-[11px] font-bold text-slate-600 leading-relaxed" x-text="selectedOrder.address"></div>
                            </div>
                            <div class="flex items-start gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <div class="text-[11px] font-bold text-blue-600 leading-snug" x-text="selectedOrder.paymentMethod"></div>
                            </div>
                            <template x-if="selectedOrder.note">
                                <div class="mt-1 pt-2 border-t border-slate-200/60">
                                    <p class="text-[11px] text-amber-700 font-bold bg-amber-100/50 px-2 py-1 rounded" x-text="'Ghi chú: ' + selectedOrder.note"></p>
                                </div>
                            </template>
                        </div>

                        <div class="flex-1 min-h-0 overflow-y-auto hide-scroll flex flex-col gap-1.5 relative border border-slate-100 rounded-xl p-1.5 bg-white">
                            <template x-for="(item, idx) in selectedOrder.items" :key="idx">
                                <div class="flex items-center gap-2.5 p-1 hover:bg-slate-50 rounded-lg transition-colors">
                                    <img :src="item.img" class="w-9 h-9 rounded-lg object-cover border border-slate-100 shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[11px] font-black text-slate-800 truncate" x-text="item.name"></div>
                                        <div class="text-[10px] font-bold text-slate-400 truncate" x-text="item.variant"></div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="text-[11px] font-black text-slate-900" x-text="item.price"></div>
                                        <div class="text-[10px] font-bold text-slate-400" x-text="'x' + item.qty"></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="border-t border-slate-100 pt-3 mt-3 shrink-0 flex flex-col gap-2">
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="font-bold text-slate-500">Tạm tính:</span>
                                <span class="font-bold text-slate-800" x-text="selectedOrder.subtotal"></span>
                            </div>
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="font-bold text-slate-500">Phí vận chuyển:</span>
                                <span class="font-bold text-slate-800" x-text="selectedOrder.shippingFee"></span>
                            </div>
                            <div class="flex justify-between items-center text-[13px] mt-1 pt-1.5 border-t border-slate-50">
                                <span class="font-black text-slate-900">Tổng cộng:</span>
                                <span class="font-black text-[#C1121F]" x-text="selectedOrder.total"></span>
                            </div>

                            <div class="mt-2 flex gap-2">
                                <template x-if="selectedOrder.status === 'pending'">
                                    <div class="flex w-full gap-2">
                                        <button @click="updateStatus('cancelled')" class="flex-[1] py-2 rounded-xl text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-colors">Hủy Đơn</button>
                                        <button @click="updateStatus('shipping')" class="flex-[2.5] py-2 rounded-xl text-[11px] font-bold text-white bg-[#C1121F] hover:bg-[#9D0208] transition-colors shadow-sm">Xác Nhận Giao</button>
                                    </div>
                                </template>
                                
                                <template x-if="selectedOrder.status === 'shipping'">
                                    <div class="flex w-full gap-2">
                                        <button @click="printInvoice()" class="flex-[1] py-2 rounded-xl text-[11px] font-bold text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">In Đơn</button>
                                        <button @click="updateStatus('completed')" class="flex-[2.5] py-2 rounded-xl text-[11px] font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">Đã Giao Xong</button>
                                    </div>
                                </template>

                                <template x-if="selectedOrder.status === 'completed' || selectedOrder.status === 'cancelled'">
                                    <div class="flex w-full gap-2">
                                        <button @click="printInvoice()" class="flex-[1] py-2 rounded-xl text-[11px] font-bold text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">In Đơn</button>
                                        <button class="flex-[2.5] py-2 rounded-xl text-[11px] font-bold text-slate-400 bg-slate-100 cursor-not-allowed border border-slate-200">Đơn Hàng Đã Đóng</button>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </template>

                <template x-if="!selectedOrder">
                    <div class="flex flex-col items-center justify-center flex-1 opacity-50">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="text-[11px] font-bold text-slate-500">Chọn một đơn hàng để xem</span>
                    </div>
                </template>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderManager', () => ({
                searchQuery: '',
                statusFilter: 'all',
                selectAll: false,
                selectedItems: [],
                
                orders: [
                    { 
                        id: 1, code: '#ORD-260601', date: '05/06/2026 10:30', 
                        customerName: 'Nguyễn Văn A', customerPhone: '0901234567', 
                        address: 'Số 15, Đường Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh',
                        note: 'Giao hàng sau 5h chiều (Gọi trước 30p)',
                        paymentMethod: 'Thanh toán tiền mặt (COD)',
                        subtotal: '598.000đ', shippingFee: '30.000đ', total: '628.000đ', status: 'pending',
                        items: [
                            { name: 'Áo Thun Polo Basic', variant: 'Đen / M', qty: 2, price: '299.000đ', img: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=100&auto=format&fit=crop' }
                        ]
                    },
                    { 
                        id: 2, code: '#ORD-260602', date: '04/06/2026 15:45', 
                        customerName: 'Trần Thị B', customerPhone: '0987654321', 
                        address: 'Tòa nhà Landmark 81, Phường 22, Quận Bình Thạnh, TP. Hồ Chí Minh',
                        note: '',
                        paymentMethod: 'Đã thanh toán qua ZaloPay',
                        subtotal: '850.000đ', shippingFee: '0đ', total: '850.000đ', status: 'shipping',
                        items: [
                            { name: 'Áo Khoác Dạ Bomber', variant: 'Rêu / S', qty: 1, price: '850.000đ', img: 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?q=80&w=100&auto=format&fit=crop' },
                            { name: 'Áo Thun Trơn Nữ', variant: 'Trắng / M', qty: 1, price: '150.000đ', img: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=100&auto=format&fit=crop' }
                        ]
                    },
                    { 
                        id: 3, code: '#ORD-260603', date: '01/06/2026 09:15', 
                        customerName: 'Lê Văn C', customerPhone: '0912345678', 
                        address: '120 Thái Hà, Phường Trung Liệt, Quận Đống Đa, Hà Nội',
                        note: '',
                        paymentMethod: 'Đã thanh toán qua ZaloPay',
                        subtotal: '1.299.000đ', shippingFee: '35.000đ', total: '1.334.000đ', status: 'completed',
                        items: [
                            { name: 'Giày Sneaker Chạy Bộ', variant: 'Xám / 40', qty: 1, price: '1.299.000đ', img: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=100&auto=format&fit=crop' }
                        ]
                    },
                    { 
                        id: 4, code: '#ORD-260604', date: '05/06/2026 11:00', 
                        customerName: 'Phạm Thanh D', customerPhone: '0933333333', 
                        address: 'Khu dân cư Ehome 3, Phường An Lạc, Bình Tân, TP. HCM',
                        note: 'Khách đổi ý không mua nữa',
                        paymentMethod: 'Thanh toán tiền mặt (COD)',
                        subtotal: '450.000đ', shippingFee: '30.000đ', total: '480.000đ', status: 'cancelled',
                        items: [
                            { name: 'Quần Jean Slimfit', variant: 'Xanh Đậm / 30', qty: 1, price: '450.000đ', img: 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=100&auto=format&fit=crop' }
                        ]
                    }
                ],
                selectedOrder: null,

                init() {
    // 1. Kiểm tra xem có ai truyền số điện thoại (search) từ trang khác sang không
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('search')) {
        this.searchQuery = urlParams.get('search'); // Tự động điền SĐT vào ô tìm kiếm
    }

    // 2. Mặc định focus vào đơn pending đầu tiên (nếu có)
    const pendingOrder = this.filteredOrders().find(o => o.status === 'pending');
    this.selectedOrder = pendingOrder || this.filteredOrders()[0] || null;
},

                filteredOrders() {
                    let result = this.orders;
                    if (this.statusFilter !== 'all') {
                        result = result.filter(o => o.status === this.statusFilter);
                    }
                    if (this.searchQuery !== '') {
                        const q = this.searchQuery.toLowerCase();
                        result = result.filter(o => 
                            o.code.toLowerCase().includes(q) || 
                            o.customerName.toLowerCase().includes(q) ||
                            o.customerPhone.includes(q)
                        );
                    }
                    return result;
                },

                toggleAll() { this.selectAll ? this.selectedItems = this.filteredOrders().map(o => o.id) : this.selectedItems = []; },
                checkItem() { this.selectAll = this.filteredOrders().length > 0 && this.selectedItems.length === this.filteredOrders().length; },

                getStatusText(status) {
                    const map = { 'pending': 'Chờ Xác Nhận', 'shipping': 'Đang Giao Hàng', 'completed': 'Hoàn Thành', 'cancelled': 'Đã Hủy' };
                    return map[status] || status;
                },

                updateStatus(newStatus) {
                    if(this.selectedOrder) {
                        this.selectedOrder.status = newStatus;
                        let index = this.orders.findIndex(o => o.id === this.selectedOrder.id);
                        if(index !== -1) this.orders[index] = this.selectedOrder;
                    }
                },

                bulkUpdateStatus(newStatus) {
                    if(confirm(`Xác nhận chuyển ${this.selectedItems.length} đơn hàng sang trạng thái: ${this.getStatusText(newStatus)}?`)) {
                        this.orders = this.orders.map(o => {
                            if(this.selectedItems.includes(o.id)) o.status = newStatus;
                            return o;
                        });
                        this.selectedItems = [];
                        this.selectAll = false;
                        if(this.selectedOrder && this.selectedItems.includes(this.selectedOrder.id)) {
                             this.selectedOrder.status = newStatus;
                        }
                    }
                },

                // --- TÍNH NĂNG 1: XUẤT CSV ---
                exportCSV() {
                    let dataToExport = this.selectedItems.length > 0
                        ? this.orders.filter(o => this.selectedItems.includes(o.id))
                        : this.filteredOrders();

                    if (dataToExport.length === 0) {
                        alert('Không có dữ liệu để xuất!');
                        return;
                    }

                    let csvContent = "Mã Đơn,Ngày Đặt,Khách Hàng,Số Điện Thoại,Tổng Tiền,Trạng Thái\n";
                    dataToExport.forEach(o => {
                        // Đóng gói dữ liệu trong dấu nháy kép để tránh lỗi dấu phẩy
                        let row = `"${o.code}","${o.date}","${o.customerName}","${o.customerPhone}","${o.total}","${this.getStatusText(o.status)}"`;
                        csvContent += row + "\n";
                    });

                    // Mã hóa UTF-8 BOM để Excel hiển thị đúng Tiếng Việt
                    const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' }); 
                    const link = document.createElement("a");
                    const url = URL.createObjectURL(blob);
                    link.setAttribute("href", url);
                    link.setAttribute("download", "DanhSachDonHang_RedCherry.csv");
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },

                // --- TÍNH NĂNG 2: IN ĐƠN HÀNG (HÓA ĐƠN ĐIỆN TỬ) ---
                printInvoice() {
                    if (!this.selectedOrder) return;
                    
                    const printWindow = window.open('', '_blank', 'width=800,height=600');
                    
                    // Tạo mã HTML giao diện in hóa đơn đơn giản, sắc nét
                    let html = `
                        <html>
                        <head>
                            <title>In Hóa Đơn ${this.selectedOrder.code}</title>
                            <style>
                                body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 30px; color: #1e293b; line-height: 1.5; }
                                .header { text-align: center; border-bottom: 2px dashed #cbd5e1; padding-bottom: 20px; margin-bottom: 20px; }
                                .header h1 { margin: 0; color: #C1121F; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
                                .info-box { display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 14px; }
                                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                                th { border-bottom: 2px solid #1e293b; padding: 10px 5px; text-align: left; font-size: 13px; text-transform: uppercase; }
                                td { border-bottom: 1px solid #e2e8f0; padding: 12px 5px; font-size: 14px; }
                                .text-right { text-align: right; }
                                .totals { width: 300px; float: right; font-size: 14px; }
                                .totals p { display: flex; justify-content: space-between; margin: 8px 0; }
                                .totals .grand-total { font-size: 18px; font-weight: bold; border-top: 2px solid #1e293b; padding-top: 10px; color: #C1121F; }
                            </style>
                        </head>
                        <body>
                            <div class="header">
                                <h1>RedCherry</h1>
                                <p>HÓA ĐƠN MUA HÀNG - ${this.selectedOrder.code}</p>
                                <small>Ngày in: ${new Date().toLocaleString('vi-VN')}</small>
                            </div>
                            
                            <div class="info-box">
                                <div>
                                    <strong>KHÁCH HÀNG:</strong><br>
                                    ${this.selectedOrder.customerName}<br>
                                    ${this.selectedOrder.customerPhone}<br>
                                    ${this.selectedOrder.address}
                                </div>
                                <div style="text-align: right;">
                                    <strong>THÔNG TIN ĐƠN:</strong><br>
                                    Ngày đặt: ${this.selectedOrder.date}<br>
                                    Thanh toán: ${this.selectedOrder.paymentMethod}<br>
                                    Ghi chú: ${this.selectedOrder.note || 'Không có'}
                                </div>
                            </div>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Phân loại</th>
                                        <th class="text-right">Đơn giá</th>
                                        <th class="text-right">SL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${this.selectedOrder.items.map(item => `
                                        <tr>
                                            <td><strong>${item.name}</strong></td>
                                            <td>${item.variant}</td>
                                            <td class="text-right">${item.price}</td>
                                            <td class="text-right">${item.qty}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>

                            <div class="totals">
                                <p><span>Tạm tính:</span> <span>${this.selectedOrder.subtotal}</span></p>
                                <p><span>Phí vận chuyển:</span> <span>${this.selectedOrder.shippingFee}</span></p>
                                <p class="grand-total"><span>Tổng cộng:</span> <span>${this.selectedOrder.total}</span></p>
                            </div>
                            
                            <div style="clear: both;"></div>
                            
                            <script>
                                window.onload = function() { 
                                    window.print(); 
                                    setTimeout(() => window.close(), 500);
                                }
                            <\/script>
                        </body>
                        </html>
                    `;
                    printWindow.document.write(html);
                    printWindow.document.close();
                }
            }));
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $attributes = $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $component = $__componentOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?><?php /**PATH C:\Users\ASUS\Downloads\projectphp\HopTacXaPHP_CuaHangQuanAoOnline-main\resources\views/admin/orders.blade.php ENDPATH**/ ?>