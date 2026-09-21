<?php if (isset($component)) { $__componentOriginal67967efac4ca6c61395bad5dff563dcf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal67967efac4ca6c61395bad5dff563dcf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.storefront.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <style>
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 15s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
        /* Mẹo nhỏ chặn hiện tượng kẹt touch khi vuốt slide */
        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 mt-2 space-y-6">
        
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <div class="lg:col-span-7 bg-slate-900 rounded-[2rem] overflow-hidden relative shadow-sm group min-h-[400px]" 
                 x-data="{ active: 0, slides: [
                    { img: 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?q=80&w=1000', title: 'Tự Tin Thể Hiện <br> Chất Riêng', subtitle: 'BỘ SƯU TẬP MỚI' },
                    { img: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000', title: 'Định Hình <br> Phong Cách', subtitle: 'STREETWEAR 2026' },
                    { img: 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1000', title: 'Mùa Hè <br> Rực Rỡ', subtitle: 'XU HƯỚNG MỚI' }
                 ] }" 
                 x-init="setInterval(() => active = active === slides.length - 1 ? 0 : active + 1, 4000)">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="active === index" x-transition.opacity.duration.700ms class="absolute inset-0 w-full h-full">
                        <img :src="slide.img" class="w-full h-full object-cover opacity-80">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent flex flex-col justify-end p-8 md:p-10">
                            <span class="text-white font-bold text-xs tracking-widest uppercase mb-2" x-text="slide.subtitle"></span>
                            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 leading-tight" x-html="slide.title"></h2>
                            <a href="/collections" class="bg-[#C1121F] text-white font-bold px-8 py-3 rounded-full w-fit hover:bg-red-800 transition-colors">Khám Phá Ngay →</a>
                        </div>
                    </div>
                </template>
                <div class="absolute bottom-6 right-8 flex gap-2 z-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="active = index" class="w-2.5 h-2.5 rounded-full transition-all" :class="active === index ? 'bg-[#C1121F] w-6' : 'bg-white/50 hover:bg-white'"></button>
                    </template>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="flex gap-4">
                    <a href="/flash-sale" class="flex-1 bg-[#9D0208] rounded-[2rem] p-6 text-white relative overflow-hidden shadow-sm flex flex-col justify-center hover:shadow-lg hover:-translate-y-1 transition-all group block cursor-pointer min-h-[220px]" x-data="{ time: 84545 }">
                        <div class="relative z-10">
                            <div class="flex items-center gap-2 text-[#FFB703] font-black text-xl italic mb-1 uppercase tracking-wider group-hover:scale-105 transition-transform origin-left">
                                <span>⚡</span> FLASH SALE
                            </div>
                            <h3 class="text-5xl font-black italic mb-2 tracking-tight">Giảm 70%</h3>
                            <p class="text-[12px] font-medium text-white/80 mb-4">Chỉ hôm nay - Số lượng có hạn</p>
                            <div class="flex items-center gap-1.5 font-black text-lg" x-init="setInterval(() => time--, 1000)">
                                <div class="bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-lg" x-text="Math.floor(time / 3600).toString().padStart(2, '0')"></div><span class="opacity-70">:</span>
                                <div class="bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-lg" x-text="Math.floor((time % 3600) / 60).toString().padStart(2, '0')"></div><span class="opacity-70">:</span>
                                <div class="bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-lg" x-text="(time % 60).toString().padStart(2, '0')"></div>
                            </div>
                        </div>
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#C1121F] rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    </a>

                    <a href="/collections" class="w-[140px] bg-white rounded-[2rem] p-4 flex flex-col items-center justify-center text-center shadow-sm border border-slate-100 hover:border-[#C1121F] hover:shadow-md transition-all group shrink-0 min-h-[220px]">
                        <div class="w-12 h-12 bg-[#FDF0F2] text-[#C1121F] rounded-full flex items-center justify-center text-xl mb-3 group-hover:bg-[#C1121F] group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="font-bold text-sm text-slate-800">Sự Kiện<br>Sắp Tới</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <a href="/products?category=nam" class="rounded-[2rem] relative overflow-hidden group shadow-sm aspect-square">
                        <img src="https://images.unsplash.com/photo-1617137968427-85924c800a22?q=80&w=600" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent flex items-end p-5">
                            <span class="text-white font-black text-lg">Thời Trang Nam</span>
                        </div>
                    </a>
                    <a href="/products?category=nu" class="rounded-[2rem] relative overflow-hidden group shadow-sm aspect-square">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent flex items-end p-5">
                            <span class="text-white font-black text-lg">Thời Trang Nữ</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="relative z-10 flex flex-col gap-3">
            <div class="relative w-full overflow-hidden bg-[#C1121F] text-white rounded-2xl flex items-center py-3.5 group cursor-default shadow-sm border border-red-800">
                <div class="absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-[#C1121F] to-transparent z-10 pointer-events-none"></div>
                <div class="absolute inset-y-0 right-0 w-8 bg-gradient-to-l from-[#C1121F] to-transparent z-10 pointer-events-none"></div>
                
                <div class="flex whitespace-nowrap animate-marquee w-max items-center">
                    <div class="flex items-center text-sm font-black tracking-widest uppercase px-4">
                        <span>✦ FLASH SALE</span> <span class="mx-6">✦ NEW ARRIVALS</span> <span class="mx-6">✦ FREE SHIP</span> <span class="mx-6">✦ ĐỘC QUYỀN</span> <span class="mx-6">✦ LIMITED EDITION</span> <span class="mx-6">✦ STREETWEAR</span> <span class="mx-6">✦ TRENDY</span>
                    </div>
                    <div class="flex items-center text-sm font-black tracking-widest uppercase px-4">
                        <span>✦ FLASH SALE</span> <span class="mx-6">✦ NEW ARRIVALS</span> <span class="mx-6">✦ FREE SHIP</span> <span class="mx-6">✦ ĐỘC QUYỀN</span> <span class="mx-6">✦ LIMITED EDITION</span> <span class="mx-6">✦ STREETWEAR</span> <span class="mx-6">✦ TRENDY</span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3">
                <a href="/products?category=ao" class="bg-white rounded-[1.25rem] p-4 flex flex-col items-center justify-center gap-3 shadow-sm hover:shadow-lg hover:scale-105 transition-all duration-300 border border-slate-100 group">
                    <div class="w-12 h-12 rounded-xl bg-[#FDF0F2] group-hover:bg-[#C1121F] flex items-center justify-center text-[#C1121F] group-hover:text-white transition-colors duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l4-4h10l4 4v2a2 2 0 01-2 2h-1v8a2 2 0 01-2 2H8a2 2 0 01-2-2v-8H5a2 2 0 01-2-2V8z"></path></svg>
                    </div>
                    <span class="font-bold text-[13px] text-slate-800">Áo</span>
                </a>
                <a href="/products?category=quan" class="bg-white rounded-[1.25rem] p-4 flex flex-col items-center justify-center gap-3 shadow-sm hover:shadow-lg hover:scale-105 transition-all duration-300 border border-slate-100 group">
                    <div class="w-12 h-12 rounded-xl bg-[#FDF0F2] group-hover:bg-[#C1121F] flex items-center justify-center text-[#C1121F] group-hover:text-white transition-colors duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 4h12l-1.5 16h-3l-1.5-8-1.5 8h-3L6 4z"></path></svg>
                    </div>
                    <span class="font-bold text-[13px] text-slate-800">Quần</span>
                </a>
                <a href="/products?category=giay-dep" class="bg-white rounded-[1.25rem] p-4 flex flex-col items-center justify-center gap-3 shadow-sm hover:shadow-lg hover:scale-105 transition-all duration-300 border border-slate-100 group">
                    <div class="w-12 h-12 rounded-xl bg-[#FDF0F2] group-hover:bg-[#C1121F] flex items-center justify-center text-[#C1121F] group-hover:text-white transition-colors duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16h16v2H4zM6 16v-3a3 3 0 013-3h3l4 3h2a2 2 0 012 2v1H6z"/></svg>
                    </div>
                    <span class="font-bold text-[13px] text-slate-800">Giày Dép</span>
                </a>
                <a href="/products?category=tui-xach" class="bg-white rounded-[1.25rem] p-4 flex flex-col items-center justify-center gap-3 shadow-sm hover:shadow-lg hover:scale-105 transition-all duration-300 border border-slate-100 group">
                    <div class="w-12 h-12 rounded-xl bg-[#FDF0F2] group-hover:bg-[#C1121F] flex items-center justify-center text-[#C1121F] group-hover:text-white transition-colors duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8h12v12H6zM9 8V5a3 3 0 016 0v3"></path></svg>
                    </div>
                    <span class="font-bold text-[13px] text-slate-800">Túi Xách</span>
                </a>
                <a href="/products?category=ao-khoac" class="bg-white rounded-[1.25rem] p-4 flex flex-col items-center justify-center gap-3 shadow-sm hover:shadow-lg hover:scale-105 transition-all duration-300 border border-slate-100 group">
                    <div class="w-12 h-12 rounded-xl bg-[#FDF0F2] group-hover:bg-[#C1121F] flex items-center justify-center text-[#C1121F] group-hover:text-white transition-colors duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22V6M12 6L8 2H5l-3 6h3v14h7M12 6l4-4h3l3 6h-3v14h-7"/></svg>
                    </div>
                    <span class="font-bold text-[13px] text-slate-800">Áo Khoác</span>
                </a>
                <a href="/products?category=new" class="bg-white rounded-[1.25rem] p-4 flex flex-col items-center justify-center gap-3 shadow-sm hover:shadow-lg hover:scale-105 transition-all duration-300 border border-slate-100 group">
                    <div class="w-12 h-12 rounded-xl bg-[#FDF0F2] group-hover:bg-[#C1121F] flex items-center justify-center text-[#C1121F] group-hover:text-white transition-colors duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143Z"/></svg>
                    </div>
                    <span class="font-bold text-[13px] text-slate-800">Sản Phẩm Mới</span>
                </a>
                <a href="/products?category=khac" class="bg-white rounded-[1.25rem] p-4 flex flex-col items-center justify-center gap-3 shadow-sm hover:shadow-lg hover:scale-105 transition-all duration-300 border border-slate-100 group">
                    <div class="w-12 h-12 rounded-xl bg-[#FDF0F2] group-hover:bg-[#C1121F] flex items-center justify-center text-[#C1121F] group-hover:text-white transition-colors duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/></svg>
                    </div>
                    <span class="font-bold text-[13px] text-slate-800">Khác</span>
                </a>
            </div>
        </section>

        <section class="relative z-10 pt-0">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-8 bg-[#C1121F] rounded-full"></div>
                    <h2 class="text-2xl font-black text-slate-900">Hàng Mới Lên Kệ</h2>
                    <span class="hidden sm:inline-block bg-[#FFB703] text-black text-xs font-black px-3 py-1.5 rounded-full shadow-sm"><?php echo e($products->count()); ?> sản phẩm mới</span>
                </div>
                <a href="/products" class="text-sm font-bold text-[#C1121F] hover:text-red-800 transition-colors flex items-center gap-1">
                    Xem tất cả <span>→</span>
                </a>
            </div>

            <div class="flex overflow-x-auto gap-4 md:gap-5 pb-8 hide-scroll snap-x">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $imageUrl = $product->image;
                        if (empty($imageUrl)) {
                            $imageUrl = 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400';
                        } elseif (!\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])) {
                            $imageUrl = asset($imageUrl);
                        }
                    ?>
                    <div onclick="window.location.href='/products/<?php echo e($product->id); ?>'" class="cursor-pointer min-w-[250px] w-[250px] bg-white rounded-[2rem] p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 group flex flex-col snap-start shrink-0">
                        <div class="relative overflow-hidden rounded-[1.5rem] bg-slate-100 aspect-[4/5] mb-4">
                            <div class="absolute top-3 left-3 flex gap-1.5 z-10">
                                <span class="bg-[#C1121F] text-white text-[11px] font-black px-2.5 py-1 rounded-lg shadow-sm">NEW</span>
                            </div>

                            <button x-data="{ liked: false }" @click.stop="liked = !liked" class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm z-10 transition-colors" :class="liked ? 'text-[#C1121F]' : 'text-slate-400 hover:text-[#C1121F]'">
                                <svg class="w-4 h-4 transition-transform duration-300" :class="liked ? 'scale-110' : ''" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>

                            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400';">

                            <div class="absolute inset-x-0 bottom-0 p-3 flex gap-2 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-12">
                                <button @click.stop="alert('Đã thêm vào giỏ!')" class="flex-1 bg-white text-slate-900 font-bold text-[13px] py-2.5 rounded-xl hover:bg-slate-100 transition-colors">Thêm Giỏ</button>
                                <button class="flex-1 bg-[#C1121F] text-white font-bold text-[13px] py-2.5 rounded-xl hover:bg-red-800 shadow-md transition-colors">Mua Ngay</button>
                            </div>
                        </div>
                        <div class="px-2 pb-2 flex flex-col flex-grow justify-end">
                            <h3 class="font-bold text-slate-800 text-[15px] line-clamp-1 mb-1.5 group-hover:text-[#C1121F] transition-colors"><?php echo e($product->name); ?></h3>
                            <p class="text-[12px] text-slate-400 mb-1.5 line-clamp-1"><?php echo e($product->category?->name ?? 'Chưa phân loại'); ?></p>
                            <div class="flex items-end gap-2">
                                <span class="text-[#C1121F] font-black text-xl"><?php echo e(number_format($product->price, 0, ',', '.')); ?>đ</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="w-full rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm text-slate-500">
                        Chưa có sản phẩm mới nào.
                    </div>
                <?php endif; ?>

                <a href="/products" class="cursor-pointer min-w-[250px] w-[250px] bg-white rounded-[2rem] p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 group flex flex-col snap-start shrink-0">
                    <div class="relative overflow-hidden rounded-[1.5rem] bg-slate-50 aspect-[4/5] mb-4 flex items-center justify-center">
                        <div class="flex flex-col items-center justify-center text-slate-400 hover:text-[#C1121F] transition-colors gap-3 w-full h-full">
                            <div class="w-14 h-14 rounded-full border-[2.5px] border-dashed border-current flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                            <span class="font-bold text-sm tracking-wide">Xem tất cả</span>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section class="relative z-10 pt-0">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-8 bg-[#FFB703] rounded-full"></div>
                    <h2 class="text-2xl font-black text-slate-900">Sản Phẩm Bán Chạy</h2>
                    <span class="hidden sm:inline-block bg-[#C1121F] text-white text-xs font-black px-3 py-1.5 rounded-full shadow-sm">Top Trending</span>
                </div>
                <a href="/products?sort=bestseller" class="text-sm font-bold text-[#C1121F] hover:text-red-800 transition-colors flex items-center gap-1">
                    Xem tất cả <span>→</span>
                </a>
            </div>

            <div class="flex overflow-x-auto gap-4 md:gap-5 pb-8 hide-scroll snap-x">
                
                <div onclick="window.location.href='/products/ao-jacket-leather-den'" class="cursor-pointer min-w-[250px] w-[250px] bg-white rounded-[2rem] p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 group flex flex-col snap-start shrink-0">
                    <div class="relative overflow-hidden rounded-[1.5rem] bg-slate-100 aspect-[4/5] mb-4">
                        <div class="absolute top-3 left-3 flex gap-1.5 z-10">
                            <span class="bg-[#FFB703] text-black text-[11px] font-black px-2.5 py-1 rounded-lg shadow-sm">BEST SELLER</span>
                        </div>
                        
                        <button x-data="{ liked: false }" @click.stop="liked = !liked" class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm z-10 transition-colors" :class="liked ? 'text-[#C1121F]' : 'text-slate-400 hover:text-[#C1121F]'">
                            <svg class="w-4 h-4 transition-transform duration-300" :class="liked ? 'scale-110' : ''" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                        
                        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute inset-x-0 bottom-0 p-3 flex gap-2 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-12">
                            <button @click.stop="alert('Đã thêm vào giỏ!')" class="flex-1 bg-white text-slate-900 font-bold text-[13px] py-2.5 rounded-xl hover:bg-slate-100 transition-colors">Thêm Giỏ</button>
                            <button class="flex-1 bg-[#C1121F] text-white font-bold text-[13px] py-2.5 rounded-xl hover:bg-red-800 shadow-md transition-colors">Mua Ngay</button>
                        </div>
                    </div>
                    <div class="px-2 pb-2 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-[15px] line-clamp-1 mb-1.5 group-hover:text-[#C1121F] transition-colors cursor-pointer">Áo Thun Đen Basic Cotton</h3>
                        <div class="flex items-end gap-2">
                            <span class="text-[#C1121F] font-black text-xl">199.000đ</span>
                        </div>
                    </div>
                </div>

                <div onclick="window.location.href='/products/ao-jacket-leather-den'" class="cursor-pointer min-w-[250px] w-[250px] bg-white rounded-[2rem] p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 group flex flex-col snap-start shrink-0">
                    <div class="relative overflow-hidden rounded-[1.5rem] bg-slate-100 aspect-[4/5] mb-4">
                        <div class="absolute top-3 left-3 flex gap-1.5 z-10">
                            <span class="bg-red-500 text-white text-[11px] font-black px-2.5 py-1 rounded-lg shadow-sm">HOT</span>
                            <span class="bg-purple-500 text-white text-[11px] font-black px-2.5 py-1 rounded-lg shadow-sm">-15%</span>
                        </div>
                        
                        <button x-data="{ liked: false }" @click.stop="liked = !liked" class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm z-10 transition-colors" :class="liked ? 'text-[#C1121F]' : 'text-slate-400 hover:text-[#C1121F]'">
                            <svg class="w-4 h-4 transition-transform duration-300" :class="liked ? 'scale-110' : ''" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>

                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-x-0 bottom-0 p-3 flex gap-2 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-12">
                            <button @click.stop="alert('Đã thêm vào giỏ!')" class="flex-1 bg-white text-slate-900 font-bold text-[13px] py-2.5 rounded-xl hover:bg-slate-100 transition-colors">Thêm Giỏ</button>
                            <button class="flex-1 bg-[#C1121F] text-white font-bold text-[13px] py-2.5 rounded-xl hover:bg-red-800 shadow-md transition-colors">Mua Ngay</button>
                        </div>
                    </div>
                    <div class="px-2 pb-2 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-[15px] line-clamp-1 mb-1.5 group-hover:text-[#C1121F] transition-colors cursor-pointer">Áo Khoác Dù Windbreaker</h3>
                        <div class="flex items-end gap-2">
                            <span class="text-[#C1121F] font-black text-xl">380.000đ</span>
                            <span class="text-slate-400 line-through text-xs font-semibold pb-1">450.000đ</span>
                        </div>
                    </div>
                </div>

                <div onclick="window.location.href='/products/ao-jacket-leather-den'" class="cursor-pointer min-w-[250px] w-[250px] bg-white rounded-[2rem] p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 group flex flex-col snap-start shrink-0">
                    <div class="relative overflow-hidden rounded-[1.5rem] bg-slate-100 aspect-[4/5] mb-4">
                        <div class="absolute top-3 left-3 flex gap-1.5 z-10">
                            <span class="bg-[#FFB703] text-black text-[11px] font-black px-2.5 py-1 rounded-lg shadow-sm">BEST SELLER</span>
                        </div>

                        <button x-data="{ liked: false }" @click.stop="liked = !liked" class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm z-10 transition-colors" :class="liked ? 'text-[#C1121F]' : 'text-slate-400 hover:text-[#C1121F]'">
                            <svg class="w-4 h-4 transition-transform duration-300" :class="liked ? 'scale-110' : ''" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>

                        <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-x-0 bottom-0 p-3 flex gap-2 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-12">
                            <button @click.stop="alert('Đã thêm vào giỏ!')" class="flex-1 bg-white text-slate-900 font-bold text-[13px] py-2.5 rounded-xl hover:bg-slate-100 transition-colors">Thêm Giỏ</button>
                            <button class="flex-1 bg-[#C1121F] text-white font-bold text-[13px] py-2.5 rounded-xl hover:bg-red-800 shadow-md transition-colors">Mua Ngay</button>
                        </div>
                    </div>
                    <div class="px-2 pb-2 flex flex-col flex-grow justify-end">
                        <h3 class="font-bold text-slate-800 text-[15px] line-clamp-1 mb-1.5 group-hover:text-[#C1121F] transition-colors cursor-pointer">Quần Jean Xanh Đậm Skinny</h3>
                        <div class="flex items-end gap-2">
                            <span class="text-[#C1121F] font-black text-xl">420.000đ</span>
                        </div>
                    </div>
                </div>

                <div onclick="window.location.href='/products?sort=bestseller'" class="cursor-pointer min-w-[250px] w-[250px] bg-white rounded-[2rem] p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 group flex flex-col snap-start shrink-0">
                    <div class="relative overflow-hidden rounded-[1.5rem] bg-slate-50 aspect-[4/5] mb-4 flex items-center justify-center">
                        <div class="flex flex-col items-center justify-center text-slate-400 hover:text-[#FFB703] transition-colors gap-3 w-full h-full">
                            <div class="w-14 h-14 rounded-full border-[2.5px] border-dashed border-current flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                            <span class="font-bold text-sm tracking-wide">Xem tất cả</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="relative z-10 pt-0 pb-4 text-center">
            <a href="/products" class="inline-flex items-center justify-center gap-3 px-12 py-4 rounded-full border-2 border-[#C1121F] text-[#C1121F] font-black text-[15px] uppercase tracking-widest hover:bg-[#C1121F] hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:shadow-red-500/30 group">
                <span>Khám Phá Thêm</span>
                <svg class="w-5 h-5 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal67967efac4ca6c61395bad5dff563dcf)): ?>
<?php $attributes = $__attributesOriginal67967efac4ca6c61395bad5dff563dcf; ?>
<?php unset($__attributesOriginal67967efac4ca6c61395bad5dff563dcf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal67967efac4ca6c61395bad5dff563dcf)): ?>
<?php $component = $__componentOriginal67967efac4ca6c61395bad5dff563dcf; ?>
<?php unset($__componentOriginal67967efac4ca6c61395bad5dff563dcf); ?>
<?php endif; ?><?php /**PATH C:\Users\ASUS\Downloads\projectphp\HopTacXaPHP_CuaHangQuanAoOnline-main\resources\views/storefront/home.blade.php ENDPATH**/ ?>