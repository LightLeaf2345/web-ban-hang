<?php if (isset($component)) { $__componentOriginal7651faf8e4a1e278424aad70c82de3ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="flex flex-col h-full gap-3" x-data="categoryManager(<?php echo \Illuminate\Support\Js::from($categories->toArray())->toHtml() ?>)" x-cloak>
        
        <!-- HEADER -->
        <div class="flex items-center justify-between shrink-0">
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Quản Lý Danh Mục</h1>
            <button @click="openCreate()" class="flex items-center gap-2 bg-[#C1121F] text-white font-bold text-[12px] px-5 py-2.5 rounded-full hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span>Thêm Danh Mục Mới</span>
            </button>
        </div>

        <!-- BỐ CỤC CHIA 2 CỘT -->
        <div class="flex-1 min-h-0 flex gap-4">
            
            <!-- CỘT TRÁI: BẢNG DANH SÁCH -->
            <div class="flex-1 min-w-0 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                
                <!-- Thanh tìm kiếm nội bộ -->
                <div class="p-3 border-b border-slate-50 shrink-0">
                    <div class="relative w-[300px]">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" x-model="searchQuery" placeholder="Tìm tên danh mục..." class="w-full bg-slate-50 border border-slate-100 text-[12px] font-bold text-slate-800 rounded-full pl-9 pr-4 py-2 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                    </div>
                </div>

                <div class="flex-1 overflow-y-scroll hide-scroll relative">
                    <table class="w-full text-left border-collapse table-fixed min-w-[400px]">
                        <thead class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-slate-100 z-10 shadow-sm">
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-wider">
                                <th class="px-5 py-3.5 w-[15%]">ID</th>
                                <th class="px-5 py-3.5 w-[45%]">Tên Danh Mục</th>
                                <th class="px-5 py-3.5 w-[20%] text-center">Trạng Thái</th>
                                <th class="px-5 py-3.5 w-[20%] text-right">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody class="text-[13px] divide-y divide-slate-50">
                            <template x-for="cat in filteredCategories()" :key="cat.id">
                                <tr class="hover:bg-slate-50/60 transition-colors group">
                                    <td class="px-5 py-4 font-bold text-slate-400" x-text="'#' + cat.id"></td>
                                    <td class="px-5 py-4 font-black text-slate-900" x-text="cat.name"></td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-block text-[10px] font-black uppercase tracking-wide px-2.5 py-1 rounded-full" 
                                              :class="cat.status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500'" 
                                              x-text="cat.status === 'active' ? 'Hoạt động' : 'Đã Ẩn'"></span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <button @click="openEdit(cat)" title="Sửa" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        <button @click="deleteCategory(cat.id)" title="Xóa" class="p-2 text-slate-400 hover:text-[#C1121F] hover:bg-red-50 transition-colors rounded-lg ml-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredCategories().length === 0" style="display: none;">
                                <td colspan="4" class="px-4 py-12 text-center text-[13px] font-bold text-slate-400">Không tìm thấy danh mục nào.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CỘT PHẢI: KHUNG ĐIỀN THÔNG TIN THÊM/SỬA (Hiển thị ngay trên màn hình) -->
            <div class="w-[340px] shrink-0 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden p-5 transition-all duration-300 relative"
                 :class="isFormOpen ? 'translate-x-0 opacity-100' : 'translate-x-4 opacity-50 pointer-events-none'">
                
                <div class="border-b border-slate-50 pb-4 mb-4 shrink-0 flex justify-between items-center">
                    <h3 class="text-[15px] font-black text-slate-900 tracking-tight" x-text="isEdit ? 'Chỉnh Sửa' : 'Thêm Mới'"></h3>
                    <button @click="isFormOpen = false" class="text-slate-400 hover:text-[#C1121F]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <div class="flex-1 overflow-y-auto hide-scroll flex flex-col gap-4">
                    <div>
                        <label class="text-[12px] font-black text-slate-800 mb-1.5 block">Tên Danh Mục</label>
                        <input type="text" x-model="editingItem.name" placeholder="Ví dụ: Áo Sơ Mi Nam..." class="w-full bg-slate-50 border border-slate-200 text-[13px] font-bold text-slate-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label class="text-[12px] font-black text-slate-800 mb-1.5 block">Trạng thái</label>
                        <select x-model="editingItem.status" class="w-full bg-slate-50 border border-slate-200 text-[13px] font-bold text-slate-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all cursor-pointer">
                            <option value="active">Hoạt động (Hiển thị)</option>
                            <option value="hidden">Đã ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center gap-3 shrink-0">
                    <button @click="isFormOpen = false" class="flex-1 py-2.5 rounded-full text-[13px] font-bold text-slate-600 bg-slate-50 hover:bg-slate-200 transition-colors">Hủy</button>
                    <button @click="saveCategory()" class="flex-1 py-2.5 rounded-full bg-[#C1121F] text-white text-[13px] font-bold hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">Lưu Lại</button>
                </div>
                
                <!-- Overlay chặn thao tác khi form đóng -->
                <div x-show="!isFormOpen" class="absolute inset-0 bg-white/50 backdrop-blur-[2px] z-10 flex items-center justify-center">
                    <p class="text-[12px] font-bold text-slate-400">Chọn "Thêm mới" hoặc "Sửa" để thao tác</p>
                </div>
            </div>

        </div>
    </div>

    <!-- LOGIC ALPINE.JS CHUYÊN BIỆT CHO DANH MỤC -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('categoryManager', (initialCategories = []) => ({
                isFormOpen: false,
                isEdit: false,
                searchQuery: '',
                
                editingItem: { id: null, name: '', status: 'active' },
                
                categories: [],

                init() {
                    this.categories = initialCategories;
                },

                filteredCategories() {
                    if (this.searchQuery === '') return this.categories;
                    const q = this.searchQuery.toLowerCase();
                    return this.categories.filter(c => c.name.toLowerCase().includes(q));
                },

                openCreate() {
                    this.isEdit = false;
                    this.editingItem = { id: null, name: '', status: 'active' };
                    this.isFormOpen = true;
                },

                openEdit(category) {
                    this.isEdit = true;
                    this.editingItem = JSON.parse(JSON.stringify(category));
                    this.isFormOpen = true;
                },

                async deleteCategory(id) {
                    if(!confirm("Bạn có chắc chắn muốn xóa danh mục này?")) return;

                    try {
                        const response = await fetch(`/admin/categories/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Xóa danh mục thất bại');

                        this.categories = this.categories.filter(c => c.id !== id);
                        if (this.editingItem.id === id) this.isFormOpen = false;
                        alert(data.message);
                    } catch (error) {
                        alert(error.message);
                    }
                },

                async saveCategory() {
                    if(!this.editingItem.name.trim()) { alert('Vui lòng điền tên danh mục!'); return; }

                    try {
                        const url = this.isEdit ? `/admin/categories/${this.editingItem.id}` : '/admin/categories';
                        const method = this.isEdit ? 'PUT' : 'POST';

                        const response = await fetch(url, {
                            method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                name: this.editingItem.name,
                                status: this.editingItem.status,
                                description: this.editingItem.description || null
                            })
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'Lưu danh mục thất bại');

                        if (this.isEdit) {
                            let index = this.categories.findIndex(c => c.id === this.editingItem.id);
                            if (index !== -1) this.categories[index] = { ...this.categories[index], ...data.category };
                        } else {
                            this.categories.unshift(data.category);
                        }

                        this.isFormOpen = false;
                        alert(data.message);
                    } catch (error) {
                        alert(error.message);
                    }
                }
            }));
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $attributes = $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $component = $__componentOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?><?php /**PATH C:\Users\ASUS\Downloads\projectphp\HopTacXaPHP_CuaHangQuanAoOnline-main\resources\views/admin/categories.blade.php ENDPATH**/ ?>