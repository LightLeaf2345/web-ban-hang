<header class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-lg border-b border-gray-100 shadow-sm" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 10)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-8">
            
            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 group flex-shrink-0">
                <div class="w-10 h-10 bg-[#C1121F] text-white rounded-[14px] flex items-center justify-center font-black text-xl shadow-md group-hover:-rotate-6 transition-transform duration-300">RC</div>
                <span class="text-2xl font-black tracking-tight text-gray-900 hidden sm:block">Red<span class="text-[#C1121F]">Cherry</span></span>
            </a>

            <!-- Thanh Tìm Kiếm (Chiếm không gian giữa) -->
            <div class="flex-1 max-w-2xl relative hidden md:block">
                <div class="relative flex items-center w-full h-11 rounded-full bg-gray-100/80 focus-within:bg-white focus-within:ring-2 focus-within:ring-[#C1121F]/20 focus-within:shadow-sm border border-transparent focus-within:border-gray-200 transition-all duration-300">
                    <svg class="w-5 h-5 text-gray-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Tìm kiếm áo thun, polo, hoodie..." class="w-full bg-transparent border-none outline-none px-3 text-sm font-medium text-gray-800 placeholder-gray-400">
                    <button class="mr-1 w-9 h-9 bg-[#C1121F] hover:bg-[#9D0208] text-white rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Các nút hành động (Auth & Giỏ hàng trống) -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="/login" class="hidden lg:flex items-center justify-center px-5 py-2.5 text-sm font-bold text-gray-700 hover:text-[#C1121F] hover:bg-red-50 rounded-full transition-colors">
                    Đăng nhập
                </a>
                <a href="/register" class="hidden lg:flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-[#0F172A] hover:bg-[#C1121F] rounded-full shadow-sm hover:shadow-md transition-all">
                    Đăng ký
                </a>
                
                <div class="w-px h-6 bg-gray-200 mx-1 hidden lg:block"></div>

                <button class="relative w-11 h-11 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#C1121F] rounded-full border border-white"></span>
                </button>
            </div>

        </div>
    </div>
</header>