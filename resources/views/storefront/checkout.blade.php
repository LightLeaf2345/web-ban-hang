<x-storefront.layout>
    <div class="max-w-5xl mx-auto px-4 mt-1 pb-4" x-data="checkoutProcess()">
        
        <nav class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2.5">
            <a href="/cart" class="hover:text-[#C1121F] transition-colors">Giỏ Hàng</a>
            <span>/</span>
            <span class="text-[#C1121F]">Thanh Toán</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">
            
            <div class="lg:col-span-7 flex flex-col gap-3.5">
                
                <section class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 relative">
                    <h2 class="text-xs sm:text-[13px] font-black text-slate-900 mb-3 border-b border-slate-100 pb-1.5 flex items-center justify-between">
                        1. Thông tin giao hàng
                        <span x-show="autoFilled" style="display: none;" class="text-[9px] font-bold text-[#C1121F] bg-red-50 px-2 py-0.5 rounded uppercase tracking-wider">Đã điền tự động</span>
                    </h2>
                    
                    <div class="grid grid-cols-2 gap-x-3 gap-y-2.5">
                        
                        <div class="col-span-2 sm:col-span-1 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.name" placeholder="Nhập họ và tên..." class="w-full h-9 bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors shadow-sm">
                        </div>
                        
                        <div class="col-span-2 sm:col-span-1 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="tel" x-model="form.phone" placeholder="Nhập số điện thoại..." class="w-full h-9 bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors shadow-sm">
                        </div>

                        <div class="col-span-2 sm:col-span-1 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Email <span class="text-slate-400 font-normal text-[10px]">(Không bắt buộc)</span></label>
                            <input type="email" x-model="form.email" placeholder="Nhập email..." class="w-full h-9 bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors shadow-sm">
                        </div>

                        <div class="col-span-2 sm:col-span-1 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Địa chỉ cụ thể <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.address" placeholder="Số nhà, tên đường..." class="w-full h-9 bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors shadow-sm">
                        </div>
                        
                        <div class="col-span-2 sm:col-span-1 space-y-1 relative">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Tỉnh / Thành phố <span class="text-red-500">*</span></label>
                            <select x-model="form.city" class="w-full h-9 bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors shadow-sm appearance-none cursor-pointer">
                                <option value="" disabled selected>Chọn Tỉnh / Thành phố</option>
                                <option value="sg">Hồ Chí Minh</option>
                                <option value="hn">Hà Nội</option>
                                <option value="dn">Đà Nẵng</option>
                            </select>
                            <svg class="absolute right-3 top-[28px] w-3.5 h-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        
                        <div class="col-span-2 sm:col-span-1 space-y-1 relative">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Quận / Huyện <span class="text-red-500">*</span></label>
                            <select x-model="form.district" class="w-full h-9 bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors shadow-sm appearance-none cursor-pointer">
                                <option value="" disabled selected>Chọn Quận / Huyện</option>
                                <option value="q1">Quận 1</option>
                                <option value="q3">Quận 3</option>
                                <option value="tb">Quận Tân Bình</option>
                            </select>
                            <svg class="absolute right-3 top-[28px] w-3.5 h-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        <div class="col-span-2 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Ghi chú đơn hàng (Tùy chọn)</label>
                            <input type="text" x-model="form.note" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi đến..." class="w-full h-9 bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors shadow-sm">
                        </div>

                    </div>

                    <p x-show="!isFormValid" style="display: none;" class="text-[10px] text-red-500 font-bold mt-2 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Vui lòng điền đầy đủ thông tin bắt buộc (*)
                    </p>
                </section>

                <section class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                    <h2 class="text-sm font-black text-slate-900 mb-3 border-b border-slate-100 pb-1.5">2. Phương thức thanh toán</h2>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="payment" value="cod" x-model="paymentMethod" class="peer sr-only">
                            <div class="rounded-xl p-2.5 border-2 transition-all flex items-center gap-2 peer-checked:border-[#C1121F] peer-checked:bg-red-50/50 h-full">
                                <div class="w-7 h-7 rounded-md bg-slate-100 flex items-center justify-center shrink-0 peer-checked:bg-[#C1121F] peer-checked:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-black text-[11px] text-slate-900 leading-tight">Thanh toán nhận hàng (COD)</h4>
                                </div>
                                <div class="hidden sm:flex w-3.5 h-3.5 rounded-full border-2 border-slate-300 items-center justify-center shrink-0 peer-checked:border-[#C1121F]">
                                    <div class="w-1.5 h-1.5 rounded-full bg-[#C1121F] scale-0 transition-transform" :class="paymentMethod === 'cod' ? 'scale-100' : ''"></div>
                                </div>
                            </div>
                        </label>

                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="payment" value="zalopay" x-model="paymentMethod" class="peer sr-only">
                            <div class="rounded-xl p-2.5 border-2 transition-all flex items-center gap-2 peer-checked:border-[#0068FF] peer-checked:bg-blue-50/50 h-full">
                                <div class="w-7 h-7 rounded-md bg-slate-100 flex items-center justify-center shrink-0 peer-checked:bg-[#0068FF] peer-checked:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-black text-[11px] text-[#0068FF] leading-tight">Thanh toán ZaloPay (QR Code)</h4>
                                </div>
                                <div class="hidden sm:flex w-3.5 h-3.5 rounded-full border-2 border-slate-300 items-center justify-center shrink-0 peer-checked:border-[#0068FF]">
                                    <div class="w-1.5 h-1.5 rounded-full bg-[#0068FF] scale-0 transition-transform" :class="paymentMethod === 'zalopay' ? 'scale-100' : ''"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </section>
            </div>

            <div class="lg:col-span-5 lg:sticky lg:top-24">
                <div class="bg-slate-900 rounded-[1.5rem] p-5 shadow-xl text-white flex flex-col gap-4">
                    
                    <div class="flex justify-between items-end border-b border-white/10 pb-2.5">
                        <h2 class="font-black text-base">Đơn hàng</h2>
                        <span class="text-[9px] font-black px-2 py-1 rounded" 
                              :class="paymentMethod === 'cod' ? 'bg-slate-700 text-slate-300' : (qrStatus === 'success' ? 'bg-emerald-500 text-white' : 'bg-[#FFB703] text-black')"
                              x-text="paymentMethod === 'cod' ? 'CHƯA THANH TOÁN' : (qrStatus === 'success' ? 'ĐÃ THANH TOÁN ZALOPAY' : 'CHỜ THANH TOÁN')">
                        </span>
                    </div>

                    <div class="flex flex-col gap-2.5 border-b border-white/10 pb-3">
                        <div class="flex gap-3 items-center">
                            <div class="w-10 h-10 rounded-lg bg-slate-800 overflow-hidden shrink-0 relative border border-white/10">
                                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=200" class="w-full h-full object-cover opacity-90">
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-[#C1121F] text-[8px] font-black rounded-full flex items-center justify-center">1</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-xs line-clamp-1">Áo Jacket Leather Đen</h3>
                                <p class="text-[9px] text-slate-400 mt-0.5">Nâu Bò / S</p>
                            </div>
                            <span class="font-black text-xs">899.000đ</span>
                        </div>
                        
                        <div class="flex gap-3 items-center">
                            <div class="w-10 h-10 rounded-lg bg-slate-800 overflow-hidden shrink-0 relative border border-white/10">
                                <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=200" class="w-full h-full object-cover opacity-90">
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-[#C1121F] text-[8px] font-black rounded-full flex items-center justify-center">1</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-xs line-clamp-1">Quần Cargo Phong Cách</h3>
                                <p class="text-[9px] text-slate-400 mt-0.5">Đen / M</p>
                            </div>
                            <span class="font-black text-xs">459.000đ</span>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <input type="text" x-model="promoCode" placeholder="Mã giảm giá (Thử: RC50)" class="w-full bg-white/5 border border-white/10 text-[11px] font-bold text-white rounded-lg px-3 py-2 outline-none focus:border-[#C1121F] transition-colors pr-20 uppercase placeholder:text-slate-500">
                            <button @click="applyPromo" class="absolute right-1.5 top-1/2 -translate-y-1/2 text-[9px] font-black bg-white text-slate-900 px-2 py-1 rounded hover:bg-slate-200 transition-colors">ÁP DỤNG</button>
                        </div>
                        <p x-show="promoApplied" style="display: none;" class="text-[9px] font-bold text-emerald-400 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Đã giảm 50.000đ</p>
                        <p x-show="promoError" style="display: none;" class="text-[9px] font-bold text-red-400 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Mã không hợp lệ</p>
                    </div>

                    <div class="space-y-1.5 text-[11px] font-semibold border-b border-white/10 pb-3 mt-1">
                        <div class="flex justify-between text-slate-400">
                            <span>Tạm tính</span><span class="text-white">1.358.000đ</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-400" x-show="discount > 0" style="display: none;">
                            <span>Giảm giá</span>
                            <span class="font-black text-emerald-400" x-text="'-' + formatPrice(discount)"></span>
                        </div>
                        <div class="flex justify-between text-slate-400">
                            <span>Phí vận chuyển</span><span class="text-emerald-400">Miễn phí</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-end">
                        <span class="font-bold text-slate-400 uppercase text-[10px]">Thành tiền</span>
                        <span class="font-black text-[#FFB703] text-xl tracking-tight leading-none" x-text="formatPrice(total)"></span>
                    </div>

                    <button @click="submitOrder()" 
                            class="w-full h-11 bg-gradient-to-r from-[#C1121F] to-[#9D0208] text-white font-black rounded-xl transition-all uppercase tracking-widest text-[11px] shadow-lg shadow-red-500/20 hover:scale-[1.01] active:scale-95 flex items-center justify-center mt-1 disabled:opacity-50 disabled:grayscale cursor-pointer disabled:cursor-not-allowed" 
                            :disabled="!isFormValid || (paymentMethod === 'zalopay' && qrStatus === 'success')">
                        <span x-text="buttonText"></span>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="isQrModalOpen" style="display: none;" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
            <div x-show="isQrModalOpen" x-transition.opacity @click="isQrModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm cursor-pointer"></div>
            
            <div x-show="isQrModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 overflow-hidden z-10 flex flex-col items-center border border-[#0068FF]/20">
                
                <button @click="isQrModalOpen = false" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-red-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <h3 class="text-lg font-black text-[#0068FF] mb-1">Thanh toán ZaloPay</h3>
                <p class="text-xs font-semibold text-slate-500 mb-4">Vui lòng quét mã QR bên dưới để thanh toán.</p>

                <div class="relative w-48 h-48 bg-slate-50 p-3 rounded-xl border border-slate-200 transition-opacity duration-300" :class="(qrStatus === 'expired' || qrStatus === 'success') ? 'opacity-20 pointer-events-none' : ''">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=RedCherryZaloPayMock" alt="QR" class="w-full h-full object-contain">
                </div>

                <div x-show="qrStatus === 'pending'" class="mt-4 text-center">
                    <p class="text-xs font-bold text-slate-500">Mã QR hết hạn sau:</p>
                    <p class="text-2xl font-black text-[#C1121F]" x-text="formatTime()"></p>
                    <button @click.prevent="simulateScan()" class="mt-3 text-[11px] font-bold bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-black transition-colors">Giả lập quét thành công</button>
                </div>

                <div x-show="qrStatus === 'expired'" style="display: none;" class="absolute inset-0 flex flex-col items-center justify-center bg-white/90 backdrop-blur-sm z-10">
                    <p class="text-base font-black text-slate-800">Mã QR đã hết hạn</p>
                    <button @click.prevent="startTimer()" class="mt-3 text-xs bg-[#0068FF] text-white px-5 py-2 rounded-lg font-bold shadow-sm">Tạo mã mới</button>
                </div>

                <div x-show="qrStatus === 'success'" style="display: none;" class="absolute inset-0 flex flex-col items-center justify-center bg-emerald-500/95 text-white backdrop-blur-md z-10">
                    <svg class="w-12 h-12 mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-base font-black">Thanh toán thành công!</p>
                </div>

            </div>
        </div>

    </div>

    <script>
        function checkoutProcess() {
            return {
                form: { name: '', phone: '', email: '', address: '', city: '', district: '', note: '' },
                autoFilled: false,
                paymentMethod: 'cod',
                
                promoCode: '', discount: 0, promoApplied: false, promoError: false,
                subtotal: 1358000, shippingFee: 0,

                isQrModalOpen: false, qrTimer: 180, timerInterval: null, qrStatus: 'pending', 
                
                init() {
                    // Cơ chế đồng bộ hóa luồng dữ liệu tự động điền khi tải trang
                    this.$nextTick(() => {
                        const authStore = Alpine.store('auth');
                        if (authStore && authStore.isLoggedIn) {
                            const user = authStore.user || {};
                            this.form.name = user.name || 'Bùi Thị Kiều Ngân';
                            this.form.phone = user.phone || '0901234567';
                            this.form.email = user.email || 'ngan.bui@example.com';
                            this.form.address = user.address || '123 Nguyễn Văn Linh, Phường 1';
                            this.form.city = user.city || 'sg';
                            this.form.district = user.district || 'tb';
                            this.autoFilled = true;
                        } else {
                            // Dữ liệu fallback kích hoạt sẵn giúp form luôn đầy đủ
                            this.form.name = 'Bùi Thị Kiều Ngân';
                            this.form.phone = '0901234567';
                            this.form.email = 'ngan.bui@example.com';
                            this.form.address = '123 Nguyễn Văn Linh, Phường 1';
                            this.form.city = 'sg';
                            this.form.district = 'tb';
                            this.autoFilled = true;
                        }
                    });

                    this.$watch('paymentMethod', val => {
                        if(val !== 'zalopay') this.resetTimer();
                    });
                },

                get isFormValid() {
                    return this.form.name.trim() !== '' && 
                           this.form.phone.trim() !== '' && 
                           this.form.address.trim() !== '' && 
                           this.form.city !== '' && 
                           this.form.district !== '';
                },

                get total() {
                    return Math.max(0, this.subtotal + this.shippingFee - this.discount);
                },

                get buttonText() {
                    if (!this.isFormValid) return 'VUI LÒNG ĐIỀN ĐỦ THÔNG TIN';
                    if (this.paymentMethod === 'cod') return 'HOÀN TẤT ĐẶT HÀNG (COD)';
                    if (this.qrStatus === 'success') return 'ĐÃ THANH TOÁN THÀNH CÔNG';
                    return 'MỞ BẢNG QUÉT MÃ ZALOPAY';
                },

                submitOrder() {
                    if (!this.isFormValid) return;
                    if (this.paymentMethod === 'zalopay' && this.qrStatus !== 'success') {
                        this.isQrModalOpen = true;
                        this.startTimer();
                    } else if (this.paymentMethod === 'cod' || this.qrStatus === 'success') {
                       window.location.href = '/order-success?payment=' + this.paymentMethod;
                    }
                },

                applyPromo() {
                    if(this.promoCode.toUpperCase() === 'RC50') {
                        this.discount = 50000;
                        this.promoApplied = true;
                        this.promoError = false;
                    } else {
                        this.discount = 0;
                        this.promoApplied = false;
                        this.promoError = true;
                    }
                },

                formatPrice(price) { return new Intl.NumberFormat('vi-VN').format(price) + 'đ'; },

                startTimer() {
                    this.resetTimer();
                    this.timerInterval = setInterval(() => {
                        if(this.qrTimer > 0) this.qrTimer--;
                        else { this.qrStatus = 'expired'; clearInterval(this.timerInterval); }
                    }, 1000);
                },

                resetTimer() {
                    clearInterval(this.timerInterval);
                    this.qrTimer = 180;
                    this.qrStatus = 'pending';
                },

                formatTime() {
                    let m = Math.floor(this.qrTimer / 60).toString().padStart(2, '0');
                    let s = (this.qrTimer % 60).toString().padStart(2, '0');
                    return `${m} : ${s}`;
                },

               simulateScan() {
                    this.qrStatus = 'success'; // Kích hoạt màn hình màu xanh hiển thị lên
                    clearInterval(this.timerInterval);
                    
                    // Giữ màn hình xanh lại 1.5 giây để khách hàng kịp nhìn thông báo thành công bừng sáng
                    setTimeout(() => {
                        this.isQrModalOpen = false;
                        
                        // ĐÃ SỬA: Ép cứng tham số 'zalopay' để đảm bảo không bao giờ bị mất chữ
                        window.location.href = '/order-success?payment=zalopay';
                    }, 1500); 
                }
            }
        }
    </script>
</x-storefront.layout> 