<x-storefront.layout>
    <div class="w-full pb-24" x-data="{
        flashsaleTime: { h: 02, m: 38, s: 50 },
        activeTimeline: 'now', // 'past', 'now', 'future'
        init() {
            setInterval(() => {
                if (this.flashsaleTime.s > 0) this.flashsaleTime.s--;
                else {
                    this.flashsaleTime.s = 59;
                    if (this.flashsaleTime.m > 0) this.flashsaleTime.m--;
                    else { this.flashsaleTime.m = 59; this.flashsaleTime.h--; }
                }
            }, 1000);
        }
    }">
        
        <div class="bg-gradient-to-r from-[#9D0208] to-[#C1121F] w-full py-8 px-4 shadow-md">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 bg-white/10 border border-white/20 px-3 py-1 rounded-full w-fit mb-3">
                        <span class="text-[#FFB703] animate-pulse">⚡</span>
                        <span class="text-white text-xs font-black uppercase tracking-wider">CHƯƠNG TRÌNH LỚN NHẤT TRONG NGÀY</span>
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-black text-white italic uppercase tracking-tighter">
                        XẢ KHO <span class="text-[#FFB703]">GIẢM 70%</span>
                    </h1>
                    <p class="text-red-100 text-xs sm:text-sm font-semibold mt-1">Số lượng sản phẩm có hạn, ưu tiên khách hàng thanh toán trước.</p>
                </div>
                
                <div class="bg-slate-900/40 backdrop-blur-md border border-white/10 p-3 sm:p-4 rounded-2xl flex flex-col items-center shrink-0 w-full sm:w-auto">
                    <span class="text-white text-[10px] font-bold uppercase tracking-widest mb-2">Thời gian kết thúc còn</span>
                    <div class="flex items-center gap-2 text-slate-900 font-black text-xl sm:text-2xl">
                        <div class="bg-white w-12 h-12 flex items-center justify-center rounded-xl shadow-md" x-text="String(flashsaleTime.h).padStart(2, '0')"></div>
                        <span class="text-white">:</span>
                        <div class="bg-white w-12 h-12 flex items-center justify-center rounded-xl shadow-md" x-text="String(flashsaleTime.m).padStart(2, '0')"></div>
                        <span class="text-white">:</span>
                        <div class="bg-white w-12 h-12 flex items-center justify-center rounded-xl shadow-md text-[#C1121F]" x-text="String(flashsaleTime.s).padStart(2, '0')"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full bg-white border-b border-slate-100 sticky top-[72px] z-40 shadow-sm">
            <div class="max-w-3xl mx-auto flex justify-between text-center font-bold">
                <button @click="activeTimeline = 'past'" class="flex-1 py-3 border-b-2 transition-all flex flex-col items-center gap-0.5" :class="activeTimeline === 'past' ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-400 hover:text-slate-600'">
                    <span class="text-sm font-black">09:00</span>
                    <span class="text-[9px] uppercase tracking-wider">Đã kết thúc</span>
                </button>
                <button @click="activeTimeline = 'now'" class="flex-1 py-3 border-b-2 transition-all flex flex-col items-center gap-0.5 relative" :class="activeTimeline === 'now' ? 'border-[#C1121F] text-[#C1121F]' : 'border-transparent text-slate-400 hover:text-slate-600'">
                    <span class="text-base font-black">12:00</span>
                    <span class="text-[9px] uppercase tracking-wider font-extrabold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-[#C1121F] rounded-full animate-ping"></span> Đang diễn ra</span>
                </button>
                <button @click="activeTimeline = 'future'" class="flex-1 py-3 border-b-2 transition-all flex flex-col items-center gap-0.5" :class="activeTimeline === 'future' ? 'border-slate-900 text-slate-900' : 'border-transparent text-slate-400 hover:text-slate-600'">
                    <span class="text-sm font-black">21:00</span>
                    <span class="text-[9px] uppercase tracking-wider">Sắp diễn ra</span>
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 mt-8">
            
            <div x-show="activeTimeline === 'now'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                <template x-for="i in 12">
                    <div class="bg-white rounded-xl p-2 sm:p-2.5 shadow-sm hover:shadow-xl transition-all duration-300 border border-red-50 flex flex-col relative cursor-pointer group min-w-0" @click="window.location.href='/products/detail'">
                        
                        <span class="absolute top-2 left-2 bg-[#FFB703] text-black text-[9px] font-black px-1.5 py-0.5 rounded shadow-sm z-10 animate-pulse">-50%</span>
                        
                        <div class="relative overflow-hidden rounded-lg bg-slate-50 aspect-[4/5] mb-2 shrink-0">
                            
                            <button x-data="{ liked: false }" @click.stop="liked = !liked" 
                                    class="absolute top-1.5 right-1.5 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow-md z-10 transition-all" 
                                    :class="liked ? 'text-[#C1121F]' : 'text-slate-500 hover:text-[#C1121F]'">
                                <svg x-show="!liked" class="w-3.5 h-3.5 transition-transform hover:scale-110" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                <svg x-show="liked" style="display: none;" class="w-3.5 h-3.5 scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                                </svg>
                            </button>
                            
                            <img :src="i % 2 === 0 ? 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400' : 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=400'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute inset-x-0 bottom-0 p-1.5 flex gap-1 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-8">
                                <button @click.stop="flyToCart($event)" class="w-7 h-7 bg-white text-slate-900 rounded-md hover:bg-slate-100 flex justify-center items-center shrink-0 shadow-sm"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></button>
                                <button @click.stop="window.location.href='/checkout'" class="flex-1 bg-[#C1121F] text-white font-black text-[9px] py-1 rounded-md hover:bg-red-800 shadow-sm uppercase tracking-wide">Mua Ngay</button>
                            </div>
                        </div>

                        <div class="px-0.5 flex flex-col flex-grow justify-end">
                            <h3 class="font-bold text-slate-800 text-[11px] sm:text-xs line-clamp-1 mb-1 group-hover:text-[#C1121F] transition-colors" x-text="i % 2 === 0 ? 'Áo Polo RedCherry' : 'Quần Short Jean' "></h3>
                            
                            <div class="flex items-center gap-1.5 mb-1.5">
                                <span class="text-[#C1121F] font-black text-[13px] sm:text-[14px]" x-text="i % 2 === 0 ? '199.000đ' : '220.000đ'"></span>
                                <span class="text-slate-400 line-through text-[9px] font-semibold" x-text="i % 2 === 0 ? '399.000đ' : '440.000đ'"></span>
                            </div>

                            <div class="mt-auto pt-1">
                                <div class="w-full bg-red-100 rounded-full h-2 relative overflow-hidden flex items-center justify-center">
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#9D0208] to-[#C1121F] rounded-full" :style="`width: ${95 - (i * 6)}%`"></div>
                                    <span class="relative z-10 text-[7px] font-black text-white uppercase tracking-wider hidden sm:block" x-text=" 95 - (i * 6) > 20 ? '🔥 Sắp cháy' : 'Vừa mở' "></span>
                                </div>
                                <p class="text-[8px] sm:text-[9px] font-bold text-slate-400 mt-1 flex justify-between items-center">
                                    <span>Đã bán: <span class="text-slate-700 font-extrabold" x-text="95 - (i * 6)"></span></span>
                                    <span>Còn: <span x-text="5 + (i * 6)"></span></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="activeTimeline !== 'now'" style="display: none;" class="bg-white border border-slate-100 rounded-2xl py-16 flex flex-col items-center justify-center text-center p-6 shadow-sm">
                <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center text-xl mb-4">⏰</div>
                <h3 class="font-black text-slate-800 text-base mb-1">Khung giờ chưa kích hoạt hoặc đã kết thúc</h3>
                <p class="text-xs font-semibold text-slate-400 max-w-xs">Vui lòng quay lại tab khung giờ 12:00 để tiến hành săn những sản phẩm đang giảm giá sâu trong ngày.</p>
            </div>

        </div>
    </div>
</x-storefront.layout>