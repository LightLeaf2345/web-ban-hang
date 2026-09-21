<x-storefront.layout>
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-6" x-data="loginForm()">
        <div class="w-full max-w-[380px] bg-white rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-100">
            
            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-[#C1121F] text-white rounded-2xl flex items-center justify-center font-black text-xl shadow-md mx-auto mb-3">RC</div>
                <h1 class="text-xl font-black text-slate-900">Đăng Nhập</h1>
            </div>

            <button class="w-full flex items-center justify-center gap-2 bg-white border-2 border-slate-200 text-slate-700 font-bold text-xs py-2.5 rounded-xl hover:bg-slate-50 transition-colors mb-5">
                <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Tiếp tục với Google
            </button>

            <div class="relative flex items-center py-1 mb-5">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="shrink-0 px-3 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Hoặc dùng Email</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <form @submit.prevent="submit" method="POST" action="/login" class="space-y-4">
                @csrf
                
                <!-- Báo lỗi khi sai tài khoản/mật khẩu từ backend -->
                @if (session('error') || $errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-[11px] font-bold px-4 py-3 rounded-xl flex flex-col gap-1">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ session('error') ?: 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin.' }}</span>
                    </div>
                    @if ($errors->any())
                        <ul class="list-disc list-inside pl-4 text-[10px] font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @endif

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700 ml-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" x-model="email" @input="validate" placeholder="Ví dụ: admin@redcherry.vn" class="w-full bg-slate-50 border text-xs font-semibold text-slate-800 rounded-xl px-3 py-2.5 outline-none transition-colors" :class="errors.email ? 'border-red-500' : 'border-slate-200 focus:border-[#C1121F]'">
                    <p x-show="errors.email" x-text="errors.email" class="text-[10px] text-red-500 font-bold ml-1"></p>
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-xs font-bold text-slate-700">Mật khẩu <span class="text-red-500">*</span></label>
                        <a href="/forgot-password" class="text-[10px] font-bold text-[#C1121F] hover:underline">Quên mật khẩu?</a>
                    </div>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" x-model="password" @input="validate" placeholder="Mật khẩu là: 123456" class="w-full bg-slate-50 border text-xs font-semibold text-slate-800 rounded-xl pl-3 pr-10 py-2.5 outline-none transition-colors" :class="errors.password ? 'border-red-500' : 'border-slate-200 focus:border-[#C1121F]'">
                        <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 focus:outline-none">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="showPass" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <p x-show="errors.password" x-text="errors.password" class="text-[10px] text-red-500 font-bold ml-1 leading-tight"></p>
                </div>

                <button type="submit" class="w-full h-11 bg-gradient-to-r from-[#C1121F] to-[#9D0208] text-white font-black rounded-xl transition-all uppercase tracking-widest text-xs hover:scale-[1.01] active:scale-95 flex items-center justify-center mt-2 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="!isValid">
                    Đăng Nhập
                </button>
            </form>
            
            <p class="text-center text-[11px] font-bold text-slate-500 mt-5">
                Chưa có tài khoản? <a href="/register" class="text-[#C1121F] hover:underline">Đăng ký ngay</a>
            </p>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                email: '',
                password: '',
                showPass: false,
                errors: { email: '', password: '' },
                
                get isValid() {
                    return this.email !== '' && this.password !== '' && this.errors.email === '' && this.errors.password === '';
                },

                validate() {
                    this.errors.email = '';
                    this.errors.password = '';

                    if(this.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                        this.errors.email = 'Định dạng email không hợp lệ.';
                    }
                },

                submit() {
                    this.validate();
                    if(this.isValid) {
                        this.$el.submit();
                    }
                }
            }
        }
    </script>
</x-storefront.layout>