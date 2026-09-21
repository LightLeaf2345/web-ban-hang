<x-storefront.layout>
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-6" x-data="{ email: '', submitted: false }">
        <div class="w-full max-w-[380px] bg-white rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-100">
            
            <div x-show="!submitted">
                <div class="w-12 h-12 bg-red-50 text-[#C1121F] rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h1 class="text-lg font-black text-slate-900 leading-tight">Khôi phục mật khẩu</h1>
                <p class="text-xs font-semibold text-slate-500 mt-1.5 mb-5">Nhập email đăng ký của bạn. Chúng tôi sẽ gửi một liên kết để tạo mật khẩu mới.</p>

                <form @submit.prevent="if(email !== '') submitted = true" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700 ml-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" required x-model="email" placeholder="Nhập email..." class="w-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 py-2.5 outline-none focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] transition-colors">
                    </div>

                    <button type="submit" class="w-full h-11 bg-[#C1121F] text-white font-black rounded-xl transition-all uppercase tracking-widest text-xs hover:bg-red-800 disabled:opacity-50" :disabled="email === ''">
                        Gửi Yêu Cầu
                    </button>
                </form>
            </div>

            <div x-show="submitted" style="display: none;" class="text-center py-4">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-lg font-black text-slate-900">Kiểm tra Email</h2>
                <p class="text-xs font-semibold text-slate-500 mt-2 mb-6 leading-relaxed">Chúng tôi đã gửi hướng dẫn khôi phục đến <br><span class="font-black text-slate-800" x-text="email"></span></p>
                <button @click="submitted = false; email = ''" class="text-xs font-bold text-[#C1121F] hover:underline">Thử lại email khác</button>
            </div>

            <div class="mt-6 text-center border-t border-slate-100 pt-5">
                <a href="/login" class="text-xs font-bold text-slate-500 hover:text-slate-900 inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Quay lại đăng nhập
                </a>
            </div>
        </div>
    </div>
</x-storefront.layout>