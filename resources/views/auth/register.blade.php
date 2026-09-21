<x-storefront.layout>
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-6" x-data="registerForm()">
        <div class="w-full max-w-[420px] bg-white rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-100">
            
            </div>

            <form @submit.prevent="submit" method="POST" action="/register" class="space-y-3">
                @csrf
                
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-[11px] font-bold px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700 ml-1">Họ và tên <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="name" placeholder="Tên..." class="w-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 rounded-xl px-3 py-2.5 outline-none focus:border-[#C1121F]">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700 ml-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" x-model="email" @input="validate" placeholder="Email..." class="w-full bg-slate-50 border text-xs font-semibold text-slate-800 rounded-xl px-3 py-2.5 outline-none" :class="errors.email ? 'border-red-500' : 'border-slate-200 focus:border-[#C1121F]'">
                    </div>
                </div>
                <p x-show="errors.email" x-text="errors.email" class="text-[10px] text-red-500 font-bold ml-1"></p>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700 ml-1">Mật khẩu <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" x-model="password" @input="validate" placeholder="Tối thiểu 8 ký tự, có Hoa, Thường, Số & Ký tự đặc biệt" class="w-full bg-slate-50 border text-xs font-semibold text-slate-800 rounded-xl pl-3 pr-10 py-2.5 outline-none" :class="errors.password ? 'border-red-500' : 'border-slate-200 focus:border-[#C1121F]'">
                        <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="showPass" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <p x-show="errors.password" x-text="errors.password" class="text-[10px] text-red-500 font-bold ml-1 leading-tight"></p>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700 ml-1">Xác nhận mật khẩu <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showPassConfirm ? 'text' : 'password'" name="password_confirmation" x-model="password_confirm" @input="validate" placeholder="Nhập lại mật khẩu..." class="w-full bg-slate-50 border text-xs font-semibold text-slate-800 rounded-xl pl-3 pr-10 py-2.5 outline-none" :class="errors.password_confirm ? 'border-red-500' : 'border-slate-200 focus:border-[#C1121F]'">
                        <button type="button" @click="showPassConfirm = !showPassConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                            <svg x-show="!showPassConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="showPassConfirm" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <p x-show="errors.password_confirm" x-text="errors.password_confirm" class="text-[10px] text-red-500 font-bold ml-1"></p>
                </div>

                <button type="submit" class="w-full h-11 bg-gradient-to-r from-[#C1121F] to-[#9D0208] text-white font-black rounded-xl transition-all uppercase tracking-widest text-xs hover:scale-[1.01] active:scale-95 flex items-center justify-center mt-4 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="!isValid">
                    Đăng Ký Ngay
                </button>
            </form>

            <p class="text-center text-[11px] font-bold text-slate-500 mt-5">
                Đã có tài khoản? <a href="/login" class="text-[#C1121F] hover:underline">Đăng nhập</a>
            </p>
        </div>
    </div>

    <script>
        function registerForm() {
            return {
                name: '', email: '', password: '', password_confirm: '',
                showPass: false, showPassConfirm: false,
                errors: { email: '', password: '', password_confirm: '' },
                
                get isValid() {
                    return this.name !== '' && this.email !== '' && this.password !== '' && this.password_confirm !== '' && 
                           this.errors.email === '' && this.errors.password === '' && this.errors.password_confirm === '';
                },

                validate() {
                    this.errors.email = '';
                    this.errors.password = '';
                    this.errors.password_confirm = '';

                    if(this.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                        this.errors.email = 'Định dạng email không hợp lệ.';
                    }
                    const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\\$%\\^&\\*])(?=.{8,})");
                    if(this.password && !strongRegex.test(this.password)) {
                        this.errors.password = 'Mật khẩu phải từ 8 ký tự, gồm chữ hoa, thường, số và ký tự đặc biệt (!@#...).';
                    }
                    if(this.password_confirm && this.password !== this.password_confirm) {
                        this.errors.password_confirm = 'Mật khẩu xác nhận không trùng khớp.';
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
    </script>ông!');
                        Alpine.store('auth').login();
                    }
                }
            }
        }
    </script>
</x-storefront.layout>