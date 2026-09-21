<x-storefront.layout>
    <div class="max-w-2xl mx-auto px-4 flex flex-col items-center justify-center min-h-[calc(100vh-100px)] py-6"
         x-data="{
            /* Đã sửa: Bắt chính xác param trên thanh địa chỉ */
            payment: new URLSearchParams(window.location.search).get('payment') || 'cod'
         }">
        
        <div class="relative w-16 h-16 mb-4">
            <div class="absolute inset-0 bg-emerald-100 rounded-full animate-ping opacity-70"></div>
            <div class="relative w-full h-full bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-md shadow-emerald-500/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mb-1.5">Đặt Hàng Thành Công!</h1>
        <p class="text-xs font-semibold text-slate-500 mb-5 max-w-md text-center">
            Cảm ơn bạn đã tin tưởng <span class="font-bold text-[#C1121F]">RedCherry</span>. Đơn hàng đang được hệ thống xử lý.
        </p>

        <div class="w-full bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 text-left mb-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Mã đơn hàng</p>
                    <p class="text-base font-black text-[#C1121F]">#RC-889922</p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Ngày đặt</p>
                    <p class="text-xs font-bold text-slate-800">12/10/2023</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-xs">
                
                <div class="space-y-4">
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Thông tin nhận hàng</p>
                        <p class="font-black text-slate-800 text-[13px]">Bùi Thị Kiều Ngân</p>
                        <p class="font-semibold text-slate-500 mt-0.5">0901234567</p>
                        <p class="font-semibold text-slate-500 mt-0.5">123 Nguyễn Văn Linh, P. Tân Bình, TP. HCM</p>
                    </div>
                    
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ghi chú đơn hàng</p>
                        <p class="font-semibold text-slate-500 italic bg-slate-50 p-2 rounded-lg border border-slate-100">"Giao vào giờ hành chính, gọi trước khi giao"</p>
                    </div>
                </div>
                
                <div class="space-y-4 sm:text-right">
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Phương thức thanh toán</p>
                        <p class="font-black text-[13px]" 
                           :class="payment === 'zalopay' ? 'text-[#0068FF]' : 'text-slate-800'" 
                           x-text="payment === 'zalopay' ? 'Thanh toán ZaloPay (Đã thanh toán)' : 'Thanh toán nhận hàng (COD)'"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tổng thanh toán</p>
                        <p class="text-lg font-black text-[#C1121F]">1.358.000đ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 w-full">
            <a href="/products" class="w-full sm:w-auto bg-slate-900 text-white font-black text-[11px] px-8 py-3 rounded-xl hover:bg-black transition-colors shadow-sm uppercase tracking-wider text-center">
                Tiếp tục mua sắm
            </a>
            <a href="#" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 font-bold text-[11px] px-8 py-3 rounded-xl hover:border-[#C1121F] hover:text-[#C1121F] transition-colors uppercase tracking-wider text-center">
                Lịch sử đơn hàng
            </a>
        </div>

    </div>
</x-storefront.layout>