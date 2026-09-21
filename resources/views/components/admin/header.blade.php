<header class="h-[60px] bg-white flex items-center justify-between px-6 shrink-0 z-10 border-b border-slate-100">
    
    <div class="flex items-center gap-4 w-full max-w-xl">
        <!-- Nút gập Sidebar thu gọn -->
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-[#C1121F] transition-colors focus:outline-none w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </button>
        
        <!-- Thanh tìm kiếm gọn gàng hơn -->
        <div class="hidden sm:flex relative w-full">
            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" placeholder="Tìm đơn hàng, mã sản phẩm..." class="w-full bg-slate-50 border border-slate-100 text-[13px] font-medium text-slate-800 rounded-full pl-10 pr-4 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all placeholder:text-slate-400">
        </div>
    </div>

    <!-- Cụm User (Không còn chuông thông báo) -->
    <div class="flex items-center gap-3 cursor-pointer group">
        <div class="text-right hidden sm:block">
            <p class="text-[11px] text-slate-400 font-semibold leading-none mb-0.5">Xin chào,</p>
            <p class="text-[13px] font-bold text-slate-900 leading-none">Admin</p>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#9D0208] text-white flex items-center justify-center font-bold text-[11px] border-[1.5px] border-[#C1121F] shadow-sm group-hover:scale-105 transition-transform">
            AD
        </div>
    </div>
</header>