<x-storefront.layout>
    <style>
        /* Ẩn thanh cuộn nhưng vẫn cho phép vuốt/scroll ngang */
        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>

    <div class="max-w-5xl mx-auto px-4 mt-2 space-y-6 sm:space-y-8" 
         x-data="{ 
            selectedColor: 'Nâu Bò',
            selectedSize: 'S',
            quantity: 1,
            activeTab: 'detail',
            showSizeGuide: false, // Biến bật/tắt Bảng số đo
            
            gallery: {
                'Đen': [
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800',
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800',
                    'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?q=80&w=800'
                ],
                'Nâu Bò': [
                    'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=800',
                    'https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=800',
                    'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800'
                ]
            },
            mainImg: '',
            
            init() {
                this.mainImg = this.gallery['Nâu Bò'][0];
                this.$watch('selectedColor', value => this.mainImg = this.gallery[value][0]);
            }
         }">
        
        <nav class="flex items-center gap-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
            <a href="/" class="hover:text-[#C1121F] transition-colors">Trang Chủ</a>
            <span>/</span>
            <a href="/products?category=ao-khoac" class="hover:text-[#C1121F] transition-colors">Áo Khoác</a>
            <span>/</span>
            <span class="text-slate-500">Jacket Leather V2</span>
        </nav>

        <section class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-10 items-start">
            
            <div class="md:col-span-5 flex flex-col gap-3 w-full max-w-[360px] mx-auto md:mx-0 md:ml-auto md:sticky md:top-24">
                <div class="w-full aspect-square rounded-2xl bg-slate-50 overflow-hidden shadow-sm border border-slate-100 relative group">
                    <span class="absolute top-3 left-3 bg-[#C1121F] text-[10px] font-black px-2 py-1 rounded-md shadow-sm uppercase tracking-wider text-white z-10">-30%</span>
                    <img id="main-product-img" :src="mainImg" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                
                <div class="grid grid-cols-4 gap-2">
                    <template x-for="(img, index) in gallery[selectedColor]" :key="index">
                        <button 
                            @click="mainImg = img" 
                            class="aspect-square rounded-xl overflow-hidden bg-slate-50 border-2 transition-all"
                            :class="mainImg === img ? 'border-[#C1121F] shadow-sm' : 'border-transparent hover:border-slate-300 opacity-70 hover:opacity-100'"
                        >
                            <img :src="img" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>

            <div class="md:col-span-7 flex flex-col gap-4">
                
                <div class="space-y-1">
                    <div class="flex items-center gap-1.5 mb-1.5">
                        <span class="bg-[#FFB703] text-black text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded">Best Seller</span>
                        <span class="bg-red-50 text-[#C1121F] text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded">Limited</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight tracking-tight">Áo Jacket Leather Đen Streetwear Premium V2</h1>
                    <p class="text-[11px] font-bold text-slate-400">Mã: <span class="text-slate-600">RC-JK024</span></p>
                </div>

                <div class="bg-white rounded-xl p-3 border border-slate-100 shadow-sm flex items-baseline gap-3">
                    <span class="text-[#C1121F] font-black text-2xl sm:text-3xl tracking-tight">899.000đ</span>
                    <span class="text-slate-400 line-through font-bold text-xs sm:text-sm">1.290.000đ</span>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-black text-slate-700 uppercase tracking-wider block">Màu sắc: <span class="text-[#C1121F]" x-text="selectedColor"></span></label>
                    <div class="flex items-center gap-2">
                        <button @click="selectedColor = 'Đen'" class="w-7 h-7 rounded-full bg-slate-900 border transition-all flex items-center justify-center text-white" :class="selectedColor === 'Đen' ? 'border-[#C1121F] ring-2 ring-red-500/20 scale-110' : 'border-transparent'">
                            <svg x-show="selectedColor === 'Đen'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                        <button @click="selectedColor = 'Nâu Bò'" class="w-7 h-7 rounded-full bg-amber-800 border transition-all flex items-center justify-center text-white" :class="selectedColor === 'Nâu Bò' ? 'border-[#C1121F] ring-2 ring-red-500/20 scale-110' : 'border-transparent'">
                            <svg x-show="selectedColor === 'Nâu Bò'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="text-[11px] font-black text-slate-700 uppercase tracking-wider block">Kích cỡ: <span class="text-[#C1121F]" x-text="selectedSize"></span></label>
                        <button @click="showSizeGuide = true" class="text-[11px] font-bold text-slate-400 hover:text-[#C1121F] underline transition-colors">Bảng số đo</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <template x-for="size in ['S', 'M', 'L', 'XL']">
                            <button 
                                @click="selectedSize = size" 
                                class="w-9 h-9 rounded-lg font-black text-sm border transition-all flex items-center justify-center"
                                :class="selectedSize === size ? 'border-[#C1121F] bg-[#C1121F] text-white shadow-sm' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-400'"
                                x-text="size"
                            ></button>
                        </template>
                    </div>
                </div>

                <div class="space-y-2.5 pt-1">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center bg-white border border-slate-200 rounded-xl px-1 h-11 shadow-sm shrink-0">
                            <button @click="if(quantity > 1) quantity--" class="w-8 h-8 text-slate-400 hover:text-[#C1121F] font-black transition-colors">-</button>
                            <span class="w-8 text-center font-black text-slate-800 text-sm" x-text="quantity"></span>
                            <button @click="quantity++" class="w-8 h-8 text-slate-400 hover:text-[#C1121F] font-black transition-colors">+</button>
                        </div>
                        <button @click.stop="flyToCart($event)" class="flex-1 h-11 bg-white border border-[#C1121F] text-[#C1121F] hover:bg-red-50 font-black rounded-xl transition-all uppercase tracking-widest text-[11px] shadow-sm active:scale-95">
                            Thêm Vào Giỏ
                        </button>
                    </div>

                    <button @click.stop="if(!$store.auth.isLoggedIn) { alert('Vui lòng đăng nhập hoặc tạo tài khoản để mua sắm!'); window.location.href='/login'; } else { $store.cart.count += quantity; window.location.href='/checkout'; }" 
        class="w-full h-11 bg-gradient-to-r from-[#C1121F] to-[#9D0208] text-white font-black rounded-xl transition-all uppercase tracking-widest text-xs shadow-md shadow-red-500/20 hover:shadow-red-500/40 hover:scale-[1.01] active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
    Mua Ngay 
</button>
                </div>
                <div class="grid grid-cols-3 gap-2 pt-0">
                    <div class="bg-white rounded-xl p-2 border border-slate-100 shadow-sm flex items-center gap-2">
                        <div class="w-7 h-7 rounded-md bg-red-50 text-[#C1121F] flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"></path></svg>
                        </div>
                        <h4 class="font-black text-slate-800 text-[10px] sm:text-[11px] leading-tight">Đổi Trả 7 Ngày</h4>
                    </div>
                    <div class="bg-white rounded-xl p-2 border border-slate-100 shadow-sm flex items-center gap-2">
                        <div class="w-7 h-7 rounded-md bg-red-50 text-[#C1121F] flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h4 class="font-black text-slate-800 text-[10px] sm:text-[11px] leading-tight">Chính Hãng</h4>
                    </div>
                    <div class="bg-white rounded-xl p-2 border border-slate-100 shadow-sm flex items-center gap-2">
                        <div class="w-7 h-7 rounded-md bg-red-50 text-[#C1121F] flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h4 class="font-black text-slate-800 text-[10px] sm:text-[11px] leading-tight">Freeship 299k</h4>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-t border-slate-200 pt-1 flex flex-col text-xs">
            <div class="border-b border-slate-100 py-2">
                <button @click="activeTab = activeTab === 'detail' ? '' : 'detail'" class="w-full flex justify-between items-center font-black text-slate-800 uppercase tracking-wider py-1">
                    <span>Mô tả chi tiết sản phẩm</span>
                    <svg class="w-4 h-4 text-[#C1121F] transition-transform duration-300" :class="activeTab === 'detail' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="activeTab === 'detail'" x-collapse class="text-sm font-semibold text-slate-500 space-y-2 pt-3 pb-2 leading-relaxed">
                    <p>🔹 Chất liệu da PU phân tầng cao cấp, mang lại bề mặt lỳ sang trọng, chống thấm và chống nổ da tuyệt đối ngay cả khi đi mưa nhẹ.</p>
                    <p>🔹 Lớp lót gió bên trong mềm mịn, thấm hút mồ hôi tốt, tạo cảm giác thoải mái khi vận động cả ngày dài.</p>
                    <p>🔹 Thiết kế form Unisex chuẩn Streetwear thời thượng, cổ bẻ thanh lịch kết hợp bo chun gấu tay áo và vạt áo giữ ấm tốt.</p>
                    <p>🔹 Khóa kéo YKK hợp kim đúc khối siêu lỳ, trơn tru. Logo RedCherry thêu sắc nét đằng sau lưng khẳng định đẳng cấp Local Brand.</p>
                </div>
            </div>
        </section>

        <!-- SECTION: CÓ THỂ BẠN CŨNG THÍCH (1 HÀNG 6 THẺ) -->
        <section class="relative z-10 pt-0 border-t border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-1 h-6 bg-[#C1121F] rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900">Có Thể Bạn Cũng Thích</h2>
            </div>

            <!-- Sử dụng CSS Grid 6 cột lấp đầy hàng ngang -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 pb-4">
                
                <!-- Card 1 -->
                <div onclick="window.location.href='/products/quan-cargo'" class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer w-full">
                    <div class="relative overflow-hidden rounded-xl bg-slate-50 aspect-square mb-2">
                        <span class="absolute top-1.5 left-1.5 bg-red-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded z-10">HOT</span>
                        <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="px-0.5 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-xs line-clamp-1 group-hover:text-[#C1121F] transition-colors">Quần Cargo Túi Hộp</h3>
                        <span class="text-[#C1121F] font-black text-[13px] mt-0.5">459.000đ</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div onclick="window.location.href='/products/sneaker'" class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer w-full">
                    <div class="relative overflow-hidden rounded-xl bg-slate-50 aspect-square mb-2">
                        <span class="absolute top-1.5 left-1.5 bg-[#FFB703] text-black text-[9px] font-black px-1.5 py-0.5 rounded z-10">SALE</span>
                        <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="px-0.5 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-xs line-clamp-1 group-hover:text-[#C1121F] transition-colors">Sneaker Urban Trend</h3>
                        <span class="text-[#C1121F] font-black text-[13px] mt-0.5">699.000đ</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer w-full">
                    <div class="relative overflow-hidden rounded-xl bg-slate-50 aspect-square mb-2">
                        <img src="https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="px-0.5 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-xs line-clamp-1 group-hover:text-[#C1121F] transition-colors">Quần Jean Nam Rộng</h3>
                        <span class="text-[#C1121F] font-black text-[13px] mt-0.5">350.000đ</span>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer w-full">
                    <div class="relative overflow-hidden rounded-xl bg-slate-50 aspect-square mb-2">
                        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="px-0.5 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-xs line-clamp-1 group-hover:text-[#C1121F] transition-colors">Áo Thun Đen Basic</h3>
                        <span class="text-[#C1121F] font-black text-[13px] mt-0.5">199.000đ</span>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer w-full">
                    <div class="relative overflow-hidden rounded-xl bg-slate-50 aspect-square mb-2">
                        <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="px-0.5 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-xs line-clamp-1 group-hover:text-[#C1121F] transition-colors">Áo Thun Trắng Tay Ngắn</h3>
                        <span class="text-[#C1121F] font-black text-[13px] mt-0.5">180.000đ</span>
                    </div>
                </div>

                <!-- Card 6: Nút Xem tất cả -->
                <div onclick="window.location.href='/products'" class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer w-full">
                    <div class="relative overflow-hidden rounded-xl bg-slate-50 aspect-square flex items-center justify-center h-full">
                        <div class="flex flex-col items-center justify-center text-slate-400 group-hover:text-[#C1121F] transition-colors gap-2">
                            <div class="w-10 h-10 rounded-full border-2 border-dashed border-current flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                            <span class="font-bold text-[11px] tracking-wide">Xem thêm</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div 
            x-show="showSizeGuide" 
            style="display: none;" 
            class="fixed inset-0 z-[200] flex items-center justify-center p-4"
        >
            <div 
                x-show="showSizeGuide" 
                x-transition.opacity.duration.300ms
                @click="showSizeGuide = false" 
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm cursor-pointer"
            ></div>
            
            <div 
                x-show="showSizeGuide" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-md p-6 sm:p-8 overflow-hidden z-10"
            >
                <button @click="showSizeGuide = false" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-[#C1121F] hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <h3 class="text-xl font-black text-slate-900 mb-2">Bảng Số Đo Tiêu Chuẩn</h3>
                <p class="text-[11px] font-semibold text-slate-500 mb-6">Áp dụng cho các dòng sản phẩm Áo Khoác / Jacket form Unisex.</p>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-700 text-[11px] uppercase tracking-wider font-black">
                            <tr>
                                <th class="px-4 py-3 border-b border-slate-200 text-center">Size</th>
                                <th class="px-4 py-3 border-b border-slate-200 border-l">Chiều Cao (cm)</th>
                                <th class="px-4 py-3 border-b border-slate-200 border-l">Cân Nặng (kg)</th>
                            </tr>
                        </thead>
                        <tbody class="font-semibold text-slate-600 text-xs">
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="px-4 py-3 border-b border-slate-100 text-center text-[#C1121F] font-black">S</td>
                                <td class="px-4 py-3 border-b border-slate-100 border-l">&lt; 165</td>
                                <td class="px-4 py-3 border-b border-slate-100 border-l">&lt; 55</td>
                            </tr>
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="px-4 py-3 border-b border-slate-100 text-center text-[#C1121F] font-black">M</td>
                                <td class="px-4 py-3 border-b border-slate-100 border-l">165 - 172</td>
                                <td class="px-4 py-3 border-b border-slate-100 border-l">55 - 65</td>
                            </tr>
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="px-4 py-3 border-b border-slate-100 text-center text-[#C1121F] font-black">L</td>
                                <td class="px-4 py-3 border-b border-slate-100 border-l">170 - 178</td>
                                <td class="px-4 py-3 border-b border-slate-100 border-l">65 - 75</td>
                            </tr>
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="px-4 py-3 text-center text-[#C1121F] font-black">XL</td>
                                <td class="px-4 py-3 border-l border-slate-100">&gt; 175</td>
                                <td class="px-4 py-3 border-l border-slate-100">&gt; 75</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <p class="text-[10px] text-slate-400 mt-4 text-center italic">* Bảng size chỉ mang tính chất tham khảo. Vui lòng chat với <span class="font-bold text-[#C1121F]">RC AI</span> để được tư vấn chính xác nhất.</p>
            </div>
        </div>

    </div>
</x-storefront.layout>