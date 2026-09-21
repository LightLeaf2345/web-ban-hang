<x-storefront.layout>
    <div class="max-w-6xl mx-auto px-4 mt-2 pb-28" 
         x-data="{ 
            cartItems: [
                { id: 1, name: 'Áo Jacket Leather Đen Streetwear Premium V2', variant: 'Nâu Bò / S', price: 899000, img: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400', qty: 1, checked: true },
                { id: 2, name: 'Quần Cargo Phong Cách', variant: 'Đen / M', price: 459000, img: 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=400', qty: 1, checked: false }
            ],
            selectAll: false,
            promoCode: '',
            discount: 0,
            promoApplied: false,
            promoError: false,

            get subtotal() {
                return this.cartItems.filter(i => i.checked).reduce((sum, i) => sum + (i.price * i.qty), 0);
            },
            get shippingFee() {
                if(this.subtotal === 0) return 0;
                return this.subtotal >= 299000 ? 0 : 30000;
            },
            get total() {
                return Math.max(0, this.subtotal + this.shippingFee - this.discount);
            },
            
            toggleAll() {
                this.cartItems.forEach(i => i.checked = this.selectAll);
            },
            checkSelectAll() {
                this.selectAll = this.cartItems.length > 0 && this.cartItems.every(i => i.checked);
            },
            removeItem(id) {
                this.cartItems = this.cartItems.filter(i => i.id !== id);
                this.checkSelectAll();
                $store.cart.count = this.cartItems.reduce((sum, i) => sum + i.qty, 0);
            },
            applyPromo() {
                if(this.promoCode.toUpperCase() === 'RC50' && this.subtotal > 0) {
                    this.discount = 50000;
                    this.promoApplied = true;
                    this.promoError = false;
                } else {
                    this.discount = 0;
                    this.promoApplied = false;
                    this.promoError = true;
                }
            },
            formatPrice(price) {
                return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
            }
         }"
         x-init="checkSelectAll()"
    >
        
        <div class="flex items-end justify-between mb-4 mt-2">
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Giỏ hàng</h1>
            <span class="text-xs font-bold text-slate-500"><span x-text="$store.cart.count"></span> sản phẩm</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <div class="lg:col-span-8 flex flex-col gap-3">
                <div class="bg-white rounded-xl p-3.5 shadow-sm border border-slate-100 flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" x-model="selectAll" @change="toggleAll" class="w-4 h-4 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] cursor-pointer accent-[#C1121F]">
                        <span class="font-bold text-sm text-slate-700 group-hover:text-black">Chọn tất cả</span>
                    </label>
                    <button @click="cartItems = cartItems.filter(i => !i.checked); checkSelectAll(); $store.cart.count = cartItems.reduce((sum, i) => sum + i.qty, 0);" class="text-xs font-bold text-slate-400 hover:text-red-500 transition-colors">
                        Xóa mục đã chọn
                    </button>
                </div>

                <template x-for="item in cartItems" :key="item.id">
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-slate-100 flex gap-3 items-center">
                        <input type="checkbox" x-model="item.checked" @change="checkSelectAll" class="w-4 h-4 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] cursor-pointer accent-[#C1121F] shrink-0">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg bg-slate-50 overflow-hidden shrink-0 border border-slate-100 cursor-pointer">
                            <img :src="item.img" class="w-full h-full object-cover hover:scale-105 transition-transform">
                        </div>
                        <div class="flex-1 flex flex-col justify-between h-full py-0.5">
                            <div class="flex justify-between items-start gap-2">
                                <div>
                                    <h3 class="font-black text-xs sm:text-[13px] text-slate-800 line-clamp-2 leading-snug cursor-pointer hover:text-[#C1121F]" x-text="item.name"></h3>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5" x-text="item.variant"></p>
                                </div>
                                <button @click="removeItem(item.id)" class="text-slate-300 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            <div class="flex items-end justify-between mt-2">
                                <span class="font-black text-[#C1121F] text-sm sm:text-base" x-text="formatPrice(item.price)"></span>
                                <div class="flex items-center bg-slate-50 border border-slate-200 rounded-lg px-1 h-7 shadow-sm">
                                    <button @click="if(item.qty > 1) { item.qty--; $store.cart.count-- }" class="w-6 h-6 text-slate-500 hover:text-black font-black flex items-center justify-center">-</button>
                                    <span class="w-6 text-center font-black text-slate-800 text-[11px]" x-text="item.qty"></span>
                                    <button @click="item.qty++; $store.cart.count++" class="w-6 h-6 text-slate-500 hover:text-black font-black flex items-center justify-center">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="cartItems.length === 0" style="display: none;" class="bg-white rounded-2xl p-8 flex flex-col items-center justify-center text-center shadow-sm border border-slate-100">
                    <h3 class="text-base font-black text-slate-800 mb-1">Giỏ hàng trống</h3>
                    <a href="/products" class="bg-[#C1121F] text-white text-xs font-bold px-6 py-2.5 rounded-full mt-3">Mua sắm ngay</a>
                </div>
            </div>

            <div class="lg:col-span-4 lg:sticky lg:top-24">
                <div class="bg-white rounded-[1.5rem] p-5 shadow-sm border border-slate-100 flex flex-col gap-4">
                    <h2 class="font-black text-base text-slate-900">Tóm tắt đơn hàng</h2>

                    <div>
                        <div class="relative">
                            <input type="text" x-model="promoCode" placeholder="Nhập RC50 để test giảm giá" class="w-full bg-slate-50 border border-slate-200 text-xs font-bold rounded-lg px-3 py-2.5 outline-none focus:border-[#C1121F] transition-colors pr-20 uppercase">
                            <button @click="applyPromo" class="absolute right-1.5 top-1/2 -translate-y-1/2 text-[10px] font-black bg-slate-800 text-white px-2.5 py-1.5 rounded-md hover:bg-black transition-colors disabled:opacity-50" :disabled="subtotal === 0">ÁP DỤNG</button>
                        </div>
                        <p x-show="promoApplied" class="text-[10px] font-bold text-emerald-500 mt-1.5 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Áp dụng thành công</p>
                        <p x-show="promoError" class="text-[10px] font-bold text-red-500 mt-1.5 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Mã không hợp lệ</p>
                    </div>

                    <div class="space-y-2.5 text-xs font-semibold border-t border-slate-100 pt-3">
                        <div class="flex justify-between items-center text-slate-500">
                            <span>Tạm tính</span>
                            <span class="font-black text-slate-800" x-text="formatPrice(subtotal)"></span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500" x-show="discount > 0">
                            <span>Giảm giá</span>
                            <span class="font-black text-[#C1121F]" x-text="'-' + formatPrice(discount)"></span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500">
                            <span>Phí vận chuyển</span>
                            <span class="font-black" :class="shippingFee === 0 ? 'text-emerald-500' : 'text-slate-800'" x-text="shippingFee === 0 ? 'Miễn phí' : formatPrice(shippingFee)"></span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-3 flex justify-between items-end">
                        <span class="font-black text-slate-800 uppercase text-[11px]">Tổng cộng</span>
                        <div class="text-right">
                            <span class="font-black text-[#C1121F] text-2xl tracking-tight block leading-none" x-text="formatPrice(total)"></span>
                        </div>
                    </div>

                    <button @click="window.location.href='/checkout'" class="w-full h-12 bg-gradient-to-r from-[#C1121F] to-[#9D0208] text-white font-black rounded-xl transition-all uppercase tracking-widest text-xs shadow-xl shadow-red-500/20 hover:scale-[1.01] active:scale-95 flex items-center justify-center mt-1 disabled:opacity-50 disabled:pointer-events-none z-10" :disabled="subtotal === 0">
                        Thanh Toán Ngay
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-storefront.layout>