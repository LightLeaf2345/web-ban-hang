<div class="fixed top-2 left-0 right-0 z-50 px-4 flex justify-center w-full">
    <header class="w-full max-w-7xl bg-[#F6F5F2]/90 backdrop-blur-xl shadow-lg shadow-slate-200/50 rounded-full px-4 py-2.5 flex items-center justify-between border border-white/60">

        <a href="/" class="flex items-center gap-3 shrink-0 ml-2">
            <div class="w-10 h-10 bg-[#C1121F] text-white rounded-[14px] flex items-center justify-center font-black text-lg shadow-md">RC</div>
            <span class="text-xl font-black text-slate-900 tracking-tight hidden lg:block">RedCherry</span>
        </a>

        <nav class="hidden md:flex items-center gap-8 font-bold text-[15px] ml-8 shrink-0 relative">
            
            <a href="/" class="transition-colors <?php echo e(request()->is('/') ? 'text-[#C1121F]' : 'text-slate-700 hover:text-[#C1121F]'); ?>">
                Trang Chủ
            </a>

            <div class="group py-4 -my-4">
                <a href="/products" class="flex items-center gap-1.5 transition-colors cursor-pointer group-hover:text-[#C1121F] <?php echo e(request()->is('products*') ? 'text-[#C1121F]' : 'text-slate-700 hover:text-[#C1121F]'); ?>">
                    Sản Phẩm
                    <svg class="w-4 h-4 transition-transform group-hover:rotate-180 duration-300 <?php echo e(request()->is('products*') ? 'text-[#C1121F]' : 'text-slate-500 group-hover:text-[#C1121F]'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </a>

                <div class="absolute top-[calc(100%+0px)] -left-[200px] w-[820px] bg-white rounded-3xl shadow-2xl shadow-slate-200/50 border border-slate-100 p-7 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-4 group-hover:translate-y-0 flex gap-8 cursor-default z-50">

                    <div class="absolute -top-4 left-0 right-0 h-4 bg-transparent"></div>

                    <div class="flex-1">
                        <a href="/products?category=ao" class="flex items-center gap-2 text-[#C1121F] font-black mb-5 hover:opacity-80 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l4-4h10l4 4v2a2 2 0 01-2 2h-1v8a2 2 0 01-2 2H8a2 2 0 01-2-2v-8H5a2 2 0 01-2-2V8z"></path></svg>
                            Áo
                        </a>
                        <ul class="space-y-4 text-[14px] font-semibold text-slate-500">
                            <li><a href="/products?category=ao-polo" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Áo Polo</a></li>
                            <li><a href="/products?category=ao-thun" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Áo Thun</a></li>
                            <li><a href="/products?category=ao-so-mi" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Áo Sơ Mi</a></li>
                            <li><a href="/products?category=ao-khoac" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Áo Khoác</a></li>
                            <li><a href="/products?category=ao-hoodie" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Áo Hoodie</a></li>
                        </ul>
                    </div>

                    <div class="flex-1">
                        <a href="/products?category=quan" class="flex items-center gap-2 text-[#C1121F] font-black mb-5 hover:opacity-80 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12l-1.5 16h-3l-1.5-8-1.5 8h-3L6 4z"></path></svg>
                            Quần
                        </a>
                        <ul class="space-y-4 text-[14px] font-semibold text-slate-500">
                            <li><a href="/products?category=quan-jean" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Quần Jean</a></li>
                            <li><a href="/products?category=quan-kaki" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Quần Kaki</a></li>
                            <li><a href="/products?category=quan-short" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Quần Short</a></li>
                            <li><a href="/products?category=quan-jogger" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Quần Jogger</a></li>
                            <li><a href="/products?category=quan-tay" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Quần Tây</a></li>
                        </ul>
                    </div>

                    <div class="flex-1">
                        <a href="/products?category=phu-kien" class="flex items-center gap-2 text-[#C1121F] font-black mb-5 hover:opacity-80 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Phụ Kiện
                        </a>
                        <ul class="space-y-4 text-[14px] font-semibold text-slate-500">
                            <li><a href="/products?category=tui-xach" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Túi Xách</a></li>
                            <li><a href="/products?category=giay" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Giày Sneaker</a></li>
                            <li><a href="/products?category=mu-non" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Mũ & Nón</a></li>
                            <li><a href="/products?category=that-lung" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Thắt Lưng</a></li>
                            <li><a href="/products?category=trang-suc" class="hover:text-[#C1121F] hover:translate-x-1.5 transition-all inline-block">Trang Sức</a></li>
                        </ul>
                    </div>

                    <div class="flex-[1.2]">
                        <div class="bg-[#9D0208] rounded-[1.5rem] p-6 text-white flex flex-col justify-between h-full relative overflow-hidden group/promo">
                            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-[#C1121F] rounded-full blur-2xl opacity-60 group-hover/promo:opacity-90 transition-opacity duration-500"></div>
                            
                            <div class="relative z-10">
                                <div class="text-[#FFB703] font-black text-xs mb-3 flex items-center gap-1.5 tracking-widest uppercase">
                                    <span>⚡</span> FLASH SALE
                                </div>
                                <h4 class="font-black text-2xl leading-tight mb-2">Giảm đến 70% <br>toàn bộ</h4>
                            </div>
                            <a href="/flash-sale" class="relative z-10 bg-white text-[#9D0208] text-center font-black tracking-wide py-3 rounded-xl text-sm hover:bg-slate-100 hover:scale-[1.02] active:scale-95 transition-all mt-6 shadow-md">
                                Xem Ngay
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <a href="/collections" class="transition-colors <?php echo e(request()->is('collections*') || request()->is('flash-sale*') ? 'text-[#C1121F]' : 'text-slate-700 hover:text-[#C1121F]'); ?>">
                Bộ Sưu Tập
            </a>
            
        </nav>

        <div class="flex-1 max-w-xl mx-8 relative hidden sm:block" 
             x-data="{ 
                 searchQuery: '', 
                 showSuggestions: false,
                 suggestions: [
                     { name: 'Áo Jacket Leather Đen', type: 'Sản phẩm' },
                     { name: 'Quần Cargo Túi Hộp', type: 'Sản phẩm' },
                     { name: 'Áo Thun Oversize Nam Nữ', type: 'Sản phẩm' },
                     { name: 'Áo Polo', type: 'Danh mục' },
                     { name: 'Quần Jean Nam', type: 'Danh mục' },
                     { name: 'Giày Sneaker', type: 'Danh mục' }
                 ],
                 get filteredSuggestions() {
                     if(this.searchQuery.trim() === '') return [];
                     return this.suggestions.filter(s => s.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
                 },
                 submitSearch() {
                     if(this.searchQuery.trim() !== '') {
                         window.location.href = '/products?q=' + encodeURIComponent(this.searchQuery.trim());
                     }
                 }
             }"
             @click.outside="showSuggestions = false">
            
            <input type="text" 
                   x-model="searchQuery" 
                   @input="showSuggestions = true"
                   @focus="if(searchQuery !== '') showSuggestions = true"
                   @keydown.enter="submitSearch"
                   placeholder="Tìm áo polo, quần jean..." 
                   class="w-full bg-white rounded-full py-2.5 pl-12 pr-12 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-[#C1121F]/30 outline-none shadow-sm border border-slate-100 transition-all">
            
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            
            <button @click="submitSearch" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-[#C1121F] text-white rounded-full flex items-center justify-center hover:bg-red-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>

            <div x-show="showSuggestions && searchQuery.length > 0" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 style="display: none;"
                 class="absolute top-[calc(100%+8px)] left-0 right-0 bg-white rounded-2xl shadow-xl border border-slate-100 py-3 z-50 overflow-hidden">
                
                <div x-show="filteredSuggestions.length > 0">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-4 mb-2">Gợi ý cho bạn</h4>
                    <ul>
                        <template x-for="item in filteredSuggestions">
                            <li>
                                <a :href="'/products?q=' + encodeURIComponent(item.name)" class="flex items-center justify-between px-4 py-2 hover:bg-red-50 transition-colors group">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#C1121F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <span class="text-sm font-bold text-slate-700 group-hover:text-[#C1121F]" x-text="item.name"></span>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded" :class="item.type === 'Sản phẩm' ? 'bg-red-100 text-[#C1121F]' : 'bg-slate-100 text-slate-500'" x-text="item.type"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>

                <div x-show="filteredSuggestions.length === 0" class="px-4 py-4 text-center">
                    <p class="text-xs font-bold text-slate-500">Không tìm thấy kết quả cho "<span class="text-slate-800" x-text="searchQuery"></span>"</p>
                </div>
            </div>

        </div>

<div class="flex items-center gap-6 shrink-0 mr-4" x-data>
            
            <button class="relative text-slate-700 hover:text-[#C1121F] transition-colors group">
                <a href="/cart" class="relative text-slate-700 hover:text-[#C1121F] transition-all duration-300 group" id="header-cart-icon" @click.prevent="if(!$store.auth.isLoggedIn) { alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location.href='/login'; } else { window.location.href='/cart'; }">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span x-show="$store.auth.isLoggedIn && $store.cart.count > 0" x-text="$store.cart.count" style="display: none;" class="absolute -top-1.5 -right-2.5 w-[22px] h-[22px] bg-[#FFB703] text-black text-[11px] font-black rounded-full flex items-center justify-center border-2 border-white group-hover:scale-110 transition-transform"></span>
                </a>
            </button>

            <template x-if="!$store.auth.isLoggedIn">
                <a href="/login" class="text-slate-700 hover:text-[#C1121F] transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </template>

            <template x-if="$store.auth.isLoggedIn">
                <div class="relative group cursor-pointer flex items-center gap-2">
                    
                    <a href="/profile?tab=profile" class="flex items-center gap-2">
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-bold text-slate-400 leading-none">Xin chào,</span>
                            <span class="text-[13px] font-black text-slate-800" x-text="$store.auth.user.name"></span>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-black text-sm border-2 border-transparent group-hover:border-[#C1121F] transition-all overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=K+N&background=C1121F&color=fff" class="w-full h-full object-cover">
                        </div>
                    </a>

                    <div class="absolute top-[120%] right-0 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        <a href="/profile?tab=profile" class="block px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-[#C1121F] rounded-xl transition-colors">Tài khoản của tôi</a>
                        <a href="/profile?tab=orders" class="block px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-[#C1121F] rounded-xl transition-colors">Đơn hàng của tôi</a>
                        <a href="/profile?tab=wishlist" class="block px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-[#C1121F] rounded-xl transition-colors">Sản phẩm yêu thích</a>
                        <div class="h-px bg-slate-100 my-1"></div>
                        <button @click="$store.auth.logout()" class="w-full text-left px-4 py-2.5 text-sm font-bold text-red-500 hover:bg-red-50 rounded-xl transition-colors">Đăng xuất</button>
                    </div>
                </div>
            </template>

        </div>
    </header>
</div><?php /**PATH C:\Users\ASUS\Downloads\projectphp\HopTacXaPHP_CuaHangQuanAoOnline-main\resources\views/components/storefront/header.blade.php ENDPATH**/ ?>