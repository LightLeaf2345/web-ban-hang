<x-storefront.layout>
    <div class="w-full pb-24" x-data>
        
        <div class="relative w-full h-[50vh] sm:h-[60vh] bg-slate-900 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1920" class="w-full h-full object-cover opacity-70">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 mt-10">
                <span class="text-white text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-3 border border-white/30 px-4 py-1.5 rounded-full backdrop-blur-md">Collection</span>
                <h1 class="text-4xl sm:text-6xl font-black text-white mb-4 uppercase tracking-tighter">Fall/Winter <span class="text-[#C1121F]">2026</span></h1>
                <p class="text-slate-200 text-sm font-semibold max-w-lg mb-6 leading-relaxed">
                    Định hình phong cách đường phố thành thị kết hợp sự tối giản tinh tế. Những thiết kế giới hạn được tạo ra để giữ ấm và làm nổi bật cá tính của bạn trong những ngày se lạnh.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 mt-8">
            
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
                <nav class="flex items-center gap-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider w-full sm:w-auto">
                    <a href="/collections" class="hover:text-[#C1121F] transition-colors">Bộ Sưu Tập</a>
                    <span>/</span>
                    <span class="text-slate-800">Fall/Winter 2026</span>
                </nav>

                <div class="flex items-center justify-between w-full sm:w-auto gap-4">
                    <span class="text-xs font-bold text-slate-500"><span class="text-slate-900">8</span> sản phẩm</span>
                    <select class="bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 rounded-lg px-3 py-2 outline-none focus:border-[#C1121F] cursor-pointer">
                        <option value="new">Mới nhất</option>
                        <option value="price_asc">Giá tăng dần</option>
                        <option value="price_desc">Giá giảm dần</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                <template x-for="i in 8">
                    <div class="bg-white rounded-2xl p-3 sm:p-3.5 shadow-sm hover:shadow-lg transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer" @click="window.location.href='/products/detail'">
                        
                        <div class="relative overflow-hidden rounded-xl bg-slate-50 aspect-[4/5] mb-3 shrink-0">
                            <span class="absolute top-2.5 left-2.5 bg-slate-900 text-white text-[9px] font-black px-2 py-1 rounded shadow-sm z-10 uppercase">Exclusive</span>
                            
                            <button x-data="{ liked: false }" @click.stop="liked = !liked" 
                                    class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md z-10 transition-all" 
                                    :class="liked ? 'text-[#C1121F]' : 'text-slate-500 hover:text-[#C1121F]'">
                                
                                <svg x-show="!liked" class="w-4 h-4 transition-transform hover:scale-110" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                
                                <svg x-show="liked" style="display: none;" class="w-4 h-4 scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                                </svg>
                            </button>
                            
                            <img :src="i % 2 === 0 ? 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400' : 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=400'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute inset-x-0 bottom-0 p-2 flex gap-1.5 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-10">
                                <button @click.stop="flyToCart($event)" class="w-8 h-8 bg-white text-slate-900 rounded-lg hover:bg-slate-100 flex justify-center items-center shrink-0 shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></button>
                                <button @click.stop="window.location.href='/checkout'" class="flex-1 bg-[#C1121F] text-white font-black text-[10px] py-1.5 rounded-lg hover:bg-red-800 shadow-sm uppercase tracking-wide">Mua Ngay</button>
                            </div>
                        </div>

                        <div class="px-1 flex flex-col flex-grow justify-end">
                            <h3 class="font-bold text-slate-800 text-xs sm:text-[13px] line-clamp-1 mb-1 group-hover:text-[#C1121F] transition-colors" x-text="i % 2 === 0 ? 'Áo Jacket Leather Đen Premium' : 'Áo Khoác Dù Windbreaker FW26'"></h3>
                            <div class="flex items-end gap-2 mt-1">
                                <span class="text-[#C1121F] font-black text-sm sm:text-[15px]" x-text="i % 2 === 0 ? '899.000đ' : '650.000đ'"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-12 flex justify-center">
                <button class="bg-white border-2 border-slate-200 text-slate-700 font-bold text-xs px-10 py-3 rounded-full hover:border-slate-900 hover:text-slate-900 transition-colors uppercase tracking-widest">
                    Xem Thêm
                </button>
            </div>

        </div>
    </div>
</x-storefront.layout>