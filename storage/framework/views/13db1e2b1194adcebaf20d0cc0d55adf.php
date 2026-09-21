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
        /* Ẩn thanh cuộn của sidebar để giao diện gọn gàng */
        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>

    <div class="max-w-[1400px] w-full mx-auto px-4 sm:px-6 mt-4 pb-24" 
         x-data="{ 
            mobileFilterOpen: false, 
            
            /* Logic Sắp xếp Đồng thời */
            isNewest: true, 
            priceSortState: 0, 
            
            /* Logic Bộ lọc Danh mục */
            genderFilter: 'all', 
            selectedCategories: [], 
            openCategories: {
                ao: false,
                quan: false
            },
            
            /* Logic Khoảng giá */
            minPrice: '',
            maxPrice: '',

            /* Hàm Reset tất cả bộ lọc */
            resetFilters() {
                this.genderFilter = 'all';
                this.selectedCategories = [];
            }
         }">
        
        <nav class="flex items-center gap-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-5">
            <a href="/" class="hover:text-[#C1121F] transition-colors">Trang Chủ</a>
            <span>/</span>
            <span class="text-[#C1121F]">Tất Cả Sản Phẩm</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-5 lg:gap-6 items-start relative">
            
            <!-- SIDEBAR BỘ LỌC -->
            <aside class="hidden lg:flex flex-col w-[230px] shrink-0 bg-white rounded-xl p-4 shadow-sm border border-slate-100 sticky top-24">
                
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2 mb-3">
                    <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"></path></svg>
                    <h2 class="font-black text-[12px] uppercase tracking-wider text-slate-900">BỘ LỌC</h2>
                </div>
                
                <div class="mb-4">
                    
                    <!-- ĐÃ SỬA: Nút "Tất cả sản phẩm" tích hợp Checkbox đồng bộ -->
                    <label class="flex items-center gap-2.5 cursor-pointer py-1.5 mb-2 group border-b border-slate-50">
                        <input type="checkbox" 
                               :checked="genderFilter === 'all' && selectedCategories.length === 0"
                               @click="resetFilters()"
                               class="w-3.5 h-3.5 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] accent-[#C1121F]">
                        <span class="font-black text-xs transition-colors"
                              :class="genderFilter === 'all' && selectedCategories.length === 0 ? 'text-[#C1121F]' : 'text-slate-700 group-hover:text-[#C1121F]'">
                            Tất cả sản phẩm
                        </span>
                    </label>
                    
                    <!-- Lọc Nam / Nữ -->
                    <div class="grid grid-cols-2 gap-2 my-2.5">
                        <label class="cursor-pointer relative">
                            <input type="radio" name="gender" value="nam" x-model="genderFilter" class="peer sr-only">
                            <div class="py-1 text-center rounded-md border text-[11px] font-bold transition-all peer-checked:bg-[#0068FF] peer-checked:text-white peer-checked:border-[#0068FF] border-slate-200 text-slate-600 hover:border-[#0068FF]">Nam</div>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="gender" value="nu" x-model="genderFilter" class="peer sr-only">
                            <div class="py-1 text-center rounded-md border text-[11px] font-bold transition-all peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 border-slate-200 text-slate-600 hover:border-pink-500">Nữ</div>
                        </label>
                    </div>

                    <!-- Danh sách Checkbox đa lựa chọn -->
                    <ul class="space-y-1 text-[11px] font-bold text-slate-700 mt-3">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li>
                                <label class="flex items-center gap-2 cursor-pointer py-1 group">
                                    <input type="checkbox" value="<?php echo e($category->id); ?>" x-model="selectedCategories" class="w-3.5 h-3.5 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] accent-[#C1121F]">
                                    <span class="group-hover:text-[#C1121F] transition-colors" :class="selectedCategories.includes('<?php echo e($category->id); ?>') ? 'text-[#C1121F]' : ''"><?php echo e($category->name); ?></span>
                                </label>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="text-[11px] text-slate-400 font-semibold">Chưa có danh mục nào.</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="h-px w-full bg-slate-100 mb-4"></div>

                <!-- KHOẢNG GIÁ -->
                <div>
                    <h3 class="font-black text-[10px] text-slate-400 uppercase tracking-wider mb-2">Khoảng giá (đ)</h3>
                    <div class="flex items-center gap-1.5 mb-2.5">
                        <input type="number" x-model="minPrice" placeholder="Từ" class="w-full bg-slate-50 border border-slate-200 text-[10px] font-bold text-slate-800 rounded-md px-2 py-1.5 outline-none focus:border-[#C1121F] transition-colors">
                        <span class="text-slate-400 font-bold">-</span>
                        <input type="number" x-model="maxPrice" placeholder="Đến" class="w-full bg-slate-50 border border-slate-200 text-[10px] font-bold text-slate-800 rounded-md px-2 py-1.5 outline-none focus:border-[#C1121F] transition-colors">
                    </div>
                    <button class="w-full bg-slate-900 hover:bg-black text-white text-[10px] font-black uppercase tracking-widest py-1.5 rounded-md transition-colors">
                        Áp Dụng
                    </button>
                </div>
            </aside>

            <!-- KHU VỰC HIỂN THỊ SẢN PHẨM BÊN PHẢI -->
            <div class="flex-1 w-full min-w-0">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Danh sách sản phẩm <span class="text-sm text-slate-400 font-bold ml-1">(<?php echo e($products->count()); ?>)</span></h1>
                    
                    <div class="flex items-center gap-2 self-end sm:self-auto w-full sm:w-auto">
                        <button @click="mobileFilterOpen = true" class="lg:hidden flex items-center justify-center gap-1.5 bg-white border border-slate-200 text-slate-700 font-bold text-xs px-3 py-2 rounded-xl flex-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"></path></svg>
                            Bộ lọc
                        </button>
                        
                        <div class="flex items-center gap-2">
                            <button @click="isNewest = !isNewest" 
                                    class="px-3 py-2 rounded-lg text-xs font-bold border transition-colors flex items-center justify-center whitespace-nowrap select-none"
                                    :class="isNewest ? 'bg-[#C1121F] text-white border-[#C1121F] shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300'">
                                Mới nhất
                            </button>
                            
                            <button @click="priceSortState = (priceSortState + 1) % 3" 
                                    class="flex items-center justify-between w-[60px] px-2.5 py-2 rounded-lg text-xs font-bold border transition-colors whitespace-nowrap select-none"
                                    :class="priceSortState !== 0 ? 'bg-[#C1121F] text-white border-[#C1121F] shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300'">
                                <span>Giá</span>
                                <span class="flex items-center justify-center w-3 h-3">
                                    <template x-if="priceSortState === 0">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"></path></svg>
                                    </template>
                                    <template x-if="priceSortState === 1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18"></path></svg>
                                    </template>
                                    <template x-if="priceSortState === 2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3"></path></svg>
                                    </template>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $imageUrl = $product->image;
                            if (empty($imageUrl)) {
                                $imageUrl = 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400';
                            } elseif (!\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                $imageUrl = asset($imageUrl);
                            }
                        ?>
                        <div @click="window.location.href='/products/<?php echo e($product->id); ?>'" class="bg-white rounded-xl p-2 sm:p-2.5 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 group flex flex-col cursor-pointer min-w-0">
                            <div class="relative overflow-hidden rounded-lg bg-slate-50 aspect-[4/5] mb-2 shrink-0">
                                <span class="absolute top-1.5 left-1.5 bg-[#C1121F] text-white text-[9px] font-black px-1.5 py-0.5 rounded shadow-sm z-10">Hot</span>

                                <button x-data="{ liked: false }" @click.stop="liked = !liked"
                                        class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md z-10 transition-all"
                                        :class="liked ? 'text-[#C1121F]' : 'text-slate-500 hover:text-[#C1121F]'">
                                    <svg x-show="!liked" class="w-4 h-4 transition-transform hover:scale-110" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                    <svg x-show="liked" style="display: none;" class="w-4 h-4 scale-110" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                                    </svg>
                                </button>

                                <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400';">

                                <div class="absolute inset-x-0 bottom-0 p-1 flex gap-1 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-8">
                                    <button @click.stop="flyToCart($event)" class="w-7 h-7 bg-white text-slate-900 rounded-md hover:bg-slate-100 flex justify-center items-center shrink-0 shadow-sm"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></button>
                                    <button @click.stop="if(!$store.auth.isLoggedIn) { alert('Vui lòng đăng nhập!'); window.location.href='/login'; } else { $store.cart.count++; window.location.href='/checkout'; }" class="flex-1 bg-[#C1121F] text-white font-black text-[9px] py-1 rounded-md hover:bg-red-800 shadow-sm uppercase tracking-wide">Mua Ngay</button>
                                </div>
                            </div>

                            <div class="px-0.5 flex flex-col flex-grow justify-end min-w-0">
                                <h3 class="font-bold text-slate-800 text-[11px] line-clamp-1 mb-1 group-hover:text-[#C1121F] transition-colors"><?php echo e($product->name); ?></h3>
                                <p class="text-[10px] text-slate-400 mb-1 line-clamp-2"><?php echo e($product->category?->name ?? 'Chưa phân loại'); ?></p>
                                <div class="flex flex-col leading-none">
                                    <span class="text-[#C1121F] font-black text-[13px]"><?php echo e(number_format($product->price, 0, ',', '.')); ?>đ</span>
                                    <span class="text-slate-400 text-[9px] font-semibold mt-0.5"><?php echo e($product->quantity); ?> còn hàng</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full rounded-xl border border-dashed border-slate-200 bg-white p-8 text-center text-sm text-slate-500">
                            Chưa có sản phẩm nào để hiển thị.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-8 flex items-center justify-center gap-1.5">
                    <button class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 disabled:opacity-50"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg></button>
                    <button class="w-7 h-7 flex items-center justify-center rounded-lg bg-[#C1121F] text-white font-black text-[11px] shadow-sm">1</button>
                    <button class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-700 font-bold text-[11px] hover:border-[#C1121F] hover:text-[#C1121F] hover:bg-red-50 transition-colors cursor-pointer">2</button>
                    <span class="text-slate-400 font-bold px-0.5 text-xs">...</span>
                    <button class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-[#C1121F] hover:border-[#C1121F] hover:bg-red-50 transition-colors cursor-pointer"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></button>
                </div>
            </div>
        </div>
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
<?php endif; ?><?php /**PATH C:\Users\ASUS\Downloads\projectphp\HopTacXaPHP_CuaHangQuanAoOnline-main\resources\views/storefront/products/index.blade.php ENDPATH**/ ?>