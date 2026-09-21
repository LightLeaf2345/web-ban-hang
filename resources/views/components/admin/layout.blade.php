<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RedCherry | Admin System</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-slate-800 antialiased h-screen w-screen overflow-hidden flex" x-data="{ sidebarOpen: true }">

    <!-- SIDEBAR: Thu hẹp độ rộng từ 280px xuống 220px -->
    <aside class="bg-white shrink-0 flex flex-col transition-all duration-300 z-20 h-full shadow-[2px_0_12px_rgba(0,0,0,0.02)] border-r border-slate-100" :class="sidebarOpen ? 'w-[220px]' : 'w-[70px]'">
        
        <div class="h-[60px] flex items-center px-5 shrink-0 border-b border-slate-50">
            <div class="flex items-center gap-2.5 w-full overflow-hidden" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                <div class="w-8 h-8 bg-[#C1121F] text-white rounded-[8px] flex items-center justify-center font-black text-[12px] shrink-0">RC</div>
                <span x-show="sidebarOpen" class="font-black text-[16px] tracking-tight text-slate-900 whitespace-nowrap">RedCherry</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 flex flex-col gap-1 hide-scroll">
            
            <!-- Đổi tên thành Tổng quan, thu nhỏ padding -->
            <a href="/admin" class="flex items-center gap-3 px-3 py-2.5 transition-all duration-200 {{ request()->is('admin') ? 'bg-[#C1121F]/10 text-[#C1121F] font-bold rounded-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-xl' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span x-show="sidebarOpen" class="text-[13px] whitespace-nowrap">Tổng quan</span>
            </a>

            <a href="/admin/products" class="flex items-center gap-3 px-3 py-2.5 transition-all duration-200 {{ request()->is('admin/products*') ? 'bg-[#C1121F]/10 text-[#C1121F] font-bold rounded-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-xl' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span x-show="sidebarOpen" class="text-[13px] whitespace-nowrap">Sản Phẩm</span>
            </a>

            <a href="/admin/categories" class="flex items-center gap-3 px-3 py-2.5 transition-all duration-200 {{ request()->is('admin/categories*') ? 'bg-[#C1121F]/10 text-[#C1121F] font-bold rounded-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-xl' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <span x-show="sidebarOpen" class="text-[13px] whitespace-nowrap">Danh Mục</span>
            </a>

            <a href="/admin/orders" class="flex items-center justify-between px-3 py-2.5 transition-all duration-200 {{ request()->is('admin/orders*') ? 'bg-[#C1121F]/10 text-[#C1121F] font-bold rounded-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-xl' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span x-show="sidebarOpen" class="text-[13px] whitespace-nowrap">Đơn Hàng</span>
                </div>
                <span x-show="sidebarOpen" class="bg-[#FFB703] text-slate-900 text-[10px] font-black px-1.5 py-0.5 rounded-full">12</span>
            </a>

            <a href="/admin/customers" class="flex items-center gap-3 px-3 py-2.5 transition-all duration-200 {{ request()->is('admin/customers*') ? 'bg-[#C1121F]/10 text-[#C1121F] font-bold rounded-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-xl' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-show="sidebarOpen" class="text-[13px] whitespace-nowrap">Khách Hàng</span>
            </a>
            
            <a href="/admin/promotions" class="flex items-center gap-3 px-3 py-2.5 transition-all duration-200 {{ request()->is('admin/promotions*') ? 'bg-[#C1121F]/10 text-[#C1121F] font-bold rounded-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold rounded-xl' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span x-show="sidebarOpen" class="text-[13px] whitespace-nowrap">Flash Sale</span>
            </a>
        </nav>
        
        <div class="p-3 mt-auto border-t border-slate-50">
            <a href="/" class="flex items-center justify-center gap-2 w-full bg-slate-900 text-white font-bold text-[12px] py-2.5 rounded-xl hover:bg-black transition-colors">
                <svg x-show="sidebarOpen" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span x-show="sidebarOpen">Về Cửa Hàng</span>
                <svg x-show="!sidebarOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">
        <x-admin.header />
        <main class="flex-1 p-4 overflow-hidden flex flex-col">
            <div class="w-full h-full flex flex-col">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>
</html>