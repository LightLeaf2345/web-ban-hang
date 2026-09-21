<?php
use Illuminate\Support\Str;

$formattedProducts = $products->map(function($p) {
    $image = $p->image;
    if (empty($image)) {
        $image = 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=200';
    } elseif (!Str::startsWith($image, ['http://', 'https://'])) {
        $image = asset($image);
    }

    return [
        'id' => $p->id,
        'category_id' => $p->category_id,
        'category' => $p->category ? $p->category->name : 'Chưa phân loại',
        'sku' => $p->sku,
        'name' => $p->name,
        'description' => $p->description ?? '',
        'price' => number_format($p->price, 0, ',', '.') . 'đ',
        'raw_price' => $p->price,
        'total_stock' => $p->quantity,
        'status' => $p->quantity == 0 ? 'danger' : ($p->quantity <= 15 ? 'warning' : 'active'),
        'alert' => $p->quantity == 0 ? 'Cháy hàng' : ($p->quantity <= 15 ? 'Sắp hết hàng' : 'Sẵn sàng'),
        'img' => $image,
        'matrix' => [
            ['color' => 'Mặc định', 'size' => 'F', 'stock' => $p->quantity]
        ]
    ];
});
?>

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
    <input type="hidden" id="safe-products-json" value='<?php echo json_encode($formattedProducts, 15, 512) ?>'>

    <div class="flex flex-col h-full gap-3" x-data="{ 
        showAddModal: false, 
        showAddDropdown: false,
        showExcelModal: false,
        isEdit: false,
        selectAll: false,
        selectedItems: [],
        searchQuery: '',
        showDeleteModal: false,
        deleteMode: 'single', 
        productToDelete: null,

        editingItem: { id: null, name: '', sku: '', category: 'Áo Nam', price: '0', total_stock: 0, status: 'active', alert: 'Sẵn sàng', images: [], matrix: [] },
        
        products: [],
        selectedProduct: null,

        // 2. Khởi tạo và nạp dữ liệu an toàn tại đây
        init() {
            const jsonInput = document.getElementById('safe-products-json');
            if (jsonInput) {
                try {
                    this.products = JSON.parse(jsonInput.value);
                } catch (e) {
                    console.error('Lỗi phân tích dữ liệu sản phẩm:', e);
                }
            }
            if (this.products && this.products.length > 0) {
                this.selectedProduct = this.products[0];
            }
        },

        filteredProducts() {
            if (this.searchQuery === '') return this.products;
            const q = this.searchQuery.toLowerCase();
            return this.products.filter(p => p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q));
        },

        toggleAll() { 
            this.selectAll ? this.selectedItems = this.filteredProducts().map(p => p.id) : this.selectedItems = []; 
        },
        
        checkItem() { 
            this.selectAll = this.filteredProducts().length > 0 && this.selectedItems.length === this.filteredProducts().length; 
        },
        
        confirmDelete(id) { 
            this.deleteMode = 'single'; 
            this.productToDelete = id; 
            this.showDeleteModal = true; 
        },
        
        confirmBulkDelete() { 
            this.deleteMode = 'bulk'; 
            this.showDeleteModal = true; 
        },

        executeDelete() {
            if (this.deleteMode === 'single') {
                fetch('/admin/products/' + this.productToDelete, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.products = this.products.filter(p => p.id !== this.productToDelete);
                        this.selectedItems = this.selectedItems.filter(itemId => itemId !== this.productToDelete);
                        this.selectedProduct = this.products.length > 0 ? this.products[0] : null;
                    } else {
                        alert(data.message || 'Lỗi khi xóa sản phẩm!');
                    }
                });
            } else {
                Promise.all(this.selectedItems.map(id => {
                    return fetch('/admin/products/' + id, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' }
                    }).then(res => res.json());
                }))
                .then(results => {
                    this.products = this.products.filter(p => !this.selectedItems.includes(p.id));
                    this.selectedItems = [];
                    this.selectAll = false;
                    this.selectedProduct = this.products.length > 0 ? this.products[0] : null;
                });
            }
            this.showDeleteModal = false;
        },

        openCreate() {
            this.isEdit = false;
            this.editingItem = { id: null, name: '', sku: '', category: 'Áo Nam', price: '0', total_stock: 0, status: 'active', alert: 'Sẵn sàng', images: [], matrix: [{ color: 'Mặc định', size: 'F', stock: 10 }] };
            this.showAddModal = true;
        },

        openEdit(product) {
            this.isEdit = true;
            let clone = JSON.parse(JSON.stringify(product));
            if (!clone.images) {
                clone.images = clone.img ? [{ preview: clone.img, file: null, isLocal: false }] : [];
            }
            clone.price = clone.raw_price ? clone.raw_price.toString() : '0';
            this.editingItem = clone;
            this.showAddModal = true;
        },

        saveProduct() {
            if (!this.editingItem.name || !this.editingItem.sku) { alert('Vui lòng điền tên và mã SKU!'); return; }
            let total = 0;
            this.editingItem.matrix.forEach(v => total += parseInt(v.stock || 0));
            this.editingItem.total_stock = total;

            let formData = new FormData();
            formData.append('name', this.editingItem.name);
            formData.append('sku', this.editingItem.sku);
            formData.append('price', parseFloat(this.editingItem.price) || 0);
            formData.append('quantity', this.editingItem.total_stock);
            formData.append('status', this.editingItem.total_stock > 0 ? 'active' : 'inactive');
            formData.append('description', this.editingItem.description || '');

            let categoryMap = {
                'Áo Nam': 1,
                'Quần Nam': 2,
                'Áo Nữ': 3,
                'Phụ Kiện': 4
            };
            let catId = categoryMap[this.editingItem.category] || 1;
            formData.append('category_id', catId);

            let fileInput = document.querySelector('input[x-ref=fileInput]');
            if (fileInput && fileInput.files.length > 0) {
                formData.append('image_file', fileInput.files[0]);
            } else if (this.editingItem.images && this.editingItem.images.length > 0) {
                let firstImage = this.editingItem.images[0];
                if (firstImage && firstImage.file) {
                    formData.append('image_file', firstImage.file);
                }
            }

            formData.append('_token', '<?php echo e(csrf_token()); ?>');

            let url = '/admin/products';
            if (this.isEdit) {
                url = '/admin/products/' + this.editingItem.id;
            }

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    let formattedPrice = new Intl.NumberFormat('vi-VN').format(data.product.price) + 'đ';
                    let savedProduct = {
                        id: data.product.id,
                        category_id: data.product.category_id,
                        category: this.editingItem.category,
                        sku: data.product.sku,
                        name: data.product.name,
                        description: data.product.description,
                        price: formattedPrice,
                        raw_price: data.product.price,
                        total_stock: data.product.quantity,
                        status: data.product.quantity == 0 ? 'danger' : (data.product.quantity <= 15 ? 'warning' : 'active'),
                        alert: data.product.quantity == 0 ? 'Cháy hàng' : (data.product.quantity <= 15 ? 'Sắp hết hàng' : 'Sẵn sàng'),
                        img: data.product.image,
                        matrix: this.editingItem.matrix
                    };

                    if (this.isEdit) {
                        let index = this.products.findIndex(p => p.id === this.editingItem.id);
                        this.products[index] = savedProduct;
                    } else {
                        this.products.unshift(savedProduct);
                    }
                    this.selectedProduct = savedProduct;
                    this.showAddModal = false;
                } else {
                    alert(data.message || 'Lỗi khi lưu sản phẩm!');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Lỗi kết nối máy chủ!');
            });
        },

        importExcel(event) {
            const form = document.getElementById('excel-import-form');
            if (!form) return;
            const formData = new FormData(form);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');

            fetch('/admin/products/import', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Nhập sản phẩm thành công!');
                    window.location.reload();
                } else {
                    alert(data.message || 'Lỗi khi nhập file Excel');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Lỗi khi gửi file Excel');
            });
        }
    }">
        
        <div class="flex items-center justify-between shrink-0">
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Quản Lý Sản Phẩm</h1>
            
            <div class="relative" @click.outside="showAddDropdown = false">
                <button @click="showAddDropdown = !showAddDropdown" class="flex items-center gap-2 bg-[#C1121F] text-white font-bold text-[12px] px-5 py-2.5 rounded-full hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    <span>Thêm Sản Phẩm</span>
                    <svg class="w-3.5 h-3.5 transition-transform" :class="showAddDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="showAddDropdown" x-transition.opacity.duration.150ms class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-lg border border-slate-100 py-1.5 z-50 overflow-hidden" style="display: none;">
                    <button @click="openCreate(); showAddDropdown = false" class="w-full text-left px-4 py-2 text-[12px] font-bold text-slate-700 hover:bg-red-50 hover:text-[#C1121F] flex items-center gap-2 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Thêm sản phẩm thủ công
                    </button>
                    <button @click="showExcelModal = true; showAddDropdown = false" class="w-full text-left px-4 py-2 text-[12px] font-bold text-slate-700 hover:bg-red-50 hover:text-[#C1121F] flex items-center gap-2 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Nhập từ file Excel
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[20px] p-3 shadow-sm border border-slate-100 flex items-center justify-between shrink-0 transition-all min-h-[56px]">
            <div x-show="selectedItems.length === 0" class="flex items-center gap-2.5 w-full overflow-x-auto hide-scroll">
                <div class="relative w-[280px] shrink-0">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="searchQuery" placeholder="Gõ để tìm tên, mã SKU..." class="w-full bg-slate-50 border border-slate-100 text-[12px] font-bold text-slate-800 rounded-full pl-9 pr-4 py-2 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                </div>
                <div class="w-px h-4 bg-slate-200 shrink-0 mx-0.5"></div>
                <select class="text-[11px] font-bold bg-slate-50 border border-slate-100 rounded-full px-3 py-2 outline-none text-slate-700 cursor-pointer">
                    <option value="">Tất cả danh mục</option>
                    <option>Áo Nam</option> <option>Quần Nam</option>
                </select>
                <select class="text-[11px] font-bold bg-slate-50 border border-slate-100 rounded-full px-3 py-2 outline-none text-[#C1121F] cursor-pointer">
                    <option>Sắp xếp: Mới nhất</option>
                    <option>Tồn kho: Sắp hết trước</option>
                </select>
            </div>

            <div x-show="selectedItems.length > 0" style="display: none;" class="flex items-center gap-4 w-full">
                <div class="flex items-center gap-2 text-[12px] font-black text-[#C1121F] bg-red-50 px-3 py-1.5 rounded-full border border-red-100">
                    <span x-text="`Đã chọn ${selectedItems.length} sản phẩm`"></span>
                </div>
                <button @click="confirmBulkDelete()" class="px-4 py-1.5 rounded-full bg-slate-900 text-white text-[11px] font-bold hover:bg-black transition-colors shadow-sm">Xóa hàng loạt</button>
            </div>
        </div>

        <div class="flex-1 min-h-0 flex gap-4">
            
            <div class="flex-1 min-w-0 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                <div class="flex-1 overflow-x-auto overflow-y-scroll hide-scroll relative">
                    
                    <table class="w-full text-left border-collapse table-fixed min-w-[500px]">
                        <thead class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-slate-100 z-10 shadow-sm">
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-wider">
                                <th class="px-3 py-3.5 w-12 text-center"><input type="checkbox" x-model="selectAll" @change="toggleAll()" class="w-4 h-4 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] cursor-pointer"></th>
                                <th class="px-3 py-3.5 w-[38%]">Thông tin sản phẩm</th>
                                <th class="px-3 py-3.5 w-[14%]">Danh mục</th>
                                <th class="px-3 py-3.5 w-[14%]">Giá bán</th>
                                <th class="px-3 py-3.5 w-[18%]">Tồn kho tổng</th>
                                <th class="px-3 py-3.5 w-[12%] text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="text-[13px] divide-y divide-slate-50">
                            <template x-for="product in filteredProducts()" :key="product.id">
                                <tr @click="selectedProduct = product" class="transition-colors group cursor-pointer" :class="(selectedProduct && selectedProduct.id === product.id) || selectedItems.includes(product.id) ? 'bg-red-50/40' : 'hover:bg-slate-50/60'">
                                    <td class="px-3 py-3 text-center" @click.stop=""><input type="checkbox" :value="product.id" x-model="selectedItems" @change="checkItem()" class="w-4 h-4 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] cursor-pointer"></td>
                                    
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-10 h-10 rounded-[10px] bg-slate-50 overflow-hidden shrink-0 border border-slate-100 relative">
                                                <template x-if="product.img"><img :src="product.img" class="w-full h-full object-cover"></template>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-black text-[13px] text-slate-900 group-hover:text-[#C1121F] transition-colors truncate" x-text="product.name" :title="product.name"></div>
                                                <div class="text-[10px] font-bold text-slate-400 mt-0.5 truncate" x-text="'SKU: ' + product.sku"></div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-3 py-3 font-bold text-slate-500 truncate" x-text="product.category"></td>
                                    <td class="px-3 py-3 font-black text-slate-900 truncate" x-text="product.price"></td>
                                    <td class="px-3 py-3 truncate">
                                        <div class="font-black text-slate-900" x-text="product.total_stock + ' sp'"></div>
                                        <span class="inline-block text-[9px] font-black uppercase tracking-wide mt-1 px-1.5 py-0.5 rounded truncate max-w-full" :class="product.status === 'danger' ? 'bg-red-50 text-[#C1121F]' : product.status === 'warning' ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500'" x-text="product.alert || 'Sẵn sàng'"></span>
                                    </td>
                                    <td class="px-3 py-3 text-right" @click.stop="">
                                        <button title="Sửa sản phẩm" @click="openEdit(product)" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                        <button title="Xóa sản phẩm" @click="confirmDelete(product.id)" class="p-1.5 text-slate-400 hover:text-[#C1121F] hover:bg-red-50 transition-colors rounded-lg ml-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </td>
                                </tr>
                            </template>
                            
                            <tr x-show="filteredProducts().length === 0" style="display: none;">
                                <td colspan="6" class="px-4 py-12 text-center text-[13px] font-bold text-slate-400">Không tìm thấy sản phẩm nào phù hợp.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-[280px] shrink-0 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden p-4">
                <div class="border-b border-slate-50 pb-3 shrink-0">
                    <h3 class="text-[14px] font-black text-slate-900 tracking-tight">Ma Trận Kiểm Kho</h3>
                    <p class="text-[11px] text-slate-400 font-bold mt-0.5">Sản phẩm: <span class="text-[#C1121F]" x-text="selectedProduct?.name || 'Chưa chọn'"></span></p>
                </div>

                <div class="flex-1 overflow-y-auto hide-scroll py-3 flex flex-col gap-2">
                    <template x-if="selectedProduct">
                        <template x-for="(item, idx) in selectedProduct?.matrix || []" :key="idx">
                            <div class="flex items-center justify-between p-2.5 rounded-2xl border transition-all" :class="item.stock === 0 ? 'bg-red-50/40 border-red-100' : item.stock <= 15 ? 'bg-amber-50/40 border-amber-100' : 'bg-slate-50/40 border-slate-100/70'">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-white border border-slate-200 text-[10px] font-black text-slate-700 flex items-center justify-center shadow-sm" x-text="item.size"></div>
                                    <div class="text-[11px] font-black text-slate-800" x-text="'Màu: ' + item.color"></div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[13px] font-black" :class="item.stock === 0 ? 'text-[#C1121F]' : 'text-slate-900'" x-text="item.stock + ' cái'"></div>
                                    <span class="text-[9px] font-black uppercase tracking-wider" :class="item.stock === 0 ? 'text-[#C1121F]' : item.stock <= 15 ? 'text-amber-600' : 'text-emerald-600'" x-text="item.stock === 0 ? 'Cháy hàng' : item.stock <= 15 ? 'Sắp hết' : 'Sẵn sàng'"></span>
                                </div>
                            </div>
                        </template>
                    </template>
                </div>
            </div>

        </div>

        <?php if (isset($component)) { $__componentOriginal44b5fada032c579c55167c6e07840b7e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal44b5fada032c579c55167c6e07840b7e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.product-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.product-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal44b5fada032c579c55167c6e07840b7e)): ?>
<?php $attributes = $__attributesOriginal44b5fada032c579c55167c6e07840b7e; ?>
<?php unset($__attributesOriginal44b5fada032c579c55167c6e07840b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal44b5fada032c579c55167c6e07840b7e)): ?>
<?php $component = $__componentOriginal44b5fada032c579c55167c6e07840b7e; ?>
<?php unset($__componentOriginal44b5fada032c579c55167c6e07840b7e); ?>
<?php endif; ?>

        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
            <div class="bg-white rounded-[288px] w-full max-w-sm flex flex-col shadow-2xl overflow-hidden text-center p-6" @click.outside="showDeleteModal = false" x-transition.scale.origin.bottom>
                <div class="w-16 h-16 rounded-full bg-red-50 text-[#C1121F] flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h2 class="text-lg font-black text-slate-900 mb-2">Xác nhận xóa sản phẩm?</h2>
                <p class="text-[13px] font-bold text-slate-500 mb-6">Dữ liệu sẽ bị xóa vĩnh viễn khỏi hệ thống.</p>
                <div class="flex items-center gap-3 w-full">
                    <button @click="showDeleteModal = false" class="flex-1 py-3 rounded-full text-[13px] font-bold text-slate-600 bg-slate-50 hover:bg-slate-200 transition-colors">Hủy Bỏ</button>
                    <button @click="executeDelete()" class="flex-1 py-3 rounded-full bg-[#C1121F] text-white text-[13px] font-bold hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">Xóa Vĩnh Viễn</button>
                </div>
            </div>
        </div>

        <div x-show="showExcelModal" style="display: none;" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
            <div class="bg-white rounded-[28px] w-full max-w-md flex flex-col shadow-2xl overflow-hidden p-6" @click.outside="showExcelModal = false" x-transition.scale.origin.bottom>
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-black text-slate-900">Nhập Sản Phẩm Từ Excel</h2>
                    <button @click="showExcelModal = false" class="text-slate-400 hover:text-[#C1121F] bg-slate-50 hover:bg-red-50 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="excel-import-form" class="w-full" enctype="multipart/form-data" @submit.prevent="importExcel($event)">
                    <div x-data="{ isHover: false, fileName: '' }"
                         @dragover.prevent="isHover = true"
                         @dragleave.prevent="isHover = false"
                         @drop.prevent="isHover = false; if($event.dataTransfer.files.length > 0) { fileName = $event.dataTransfer.files[0].name; $refs.excelInput.files = $event.dataTransfer.files; }"
                         @click="$refs.excelInput.click()"
                         class="border-2 border-dashed rounded-[20px] flex flex-col items-center justify-center p-8 cursor-pointer transition-all mb-4 text-center"
                         :class="isHover ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 bg-slate-50 hover:border-emerald-500/40 hover:bg-emerald-50/30'">
                        
                        <input type="file" x-ref="excelInput" name="excel_file" accept=".xlsx, .xls, .csv" class="hidden" 
                               @change="if($refs.excelInput.files.length > 0) fileName = $refs.excelInput.files[0].name">

                        <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 mb-3" :class="isHover || fileName ? 'text-emerald-500' : ''">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        
                        <template x-if="!fileName">
                            <div>
                                <p class="text-[13px] font-black text-slate-700">Kéo thả file Excel vào đây</p>
                                <p class="text-[11px] font-bold text-slate-400 mt-1">Hỗ trợ định dạng .xlsx, .xls, .csv</p>
                            </div>
                        </template>
                        <template x-if="fileName">
                            <div>
                                <p class="text-[13px] font-black text-emerald-600 truncate max-w-[250px]" x-text="fileName"></p>
                                <p class="text-[11px] font-bold text-slate-400 mt-1">Đã sẵn sàng để tải lên</p>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-between items-center mb-6 px-1">
                        <span class="text-[11px] font-bold text-slate-500">File mẫu nên có cột: tên, sku, giá, số lượng, danh mục</span>
                        <a href="/admin/products/import/sample" class="text-[11px] font-black text-blue-600 hover:text-blue-700 hover:underline" download> Tải File Mẫu </a>
                    </div>

                    <div class="flex items-center gap-3 w-full">
                        <button type="button" @click="showExcelModal = false" class="flex-1 py-2.5 rounded-full text-[13px] font-bold text-slate-600 bg-slate-50 hover:bg-slate-200 transition-colors">Hủy Bỏ</button>
                        <button type="submit" class="flex-1 py-2.5 rounded-full bg-emerald-500 text-white text-[13px] font-bold hover:bg-emerald-600 transition-colors shadow-md active:scale-95">Bắt Đầu Nhập</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $attributes = $__attributesOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__attributesOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba)): ?>
<?php $component = $__componentOriginal7651faf8e4a1e278424aad70c82de3ba; ?>
<?php unset($__componentOriginal7651faf8e4a1e278424aad70c82de3ba); ?>
<?php endif; ?><?php /**PATH C:\Users\ASUS\Downloads\projectphp\HopTacXaPHP_CuaHangQuanAoOnline-main\resources\views/admin/products.blade.php ENDPATH**/ ?>