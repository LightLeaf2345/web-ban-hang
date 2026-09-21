<div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-3" x-transition.opacity>
    
    <div class="bg-white rounded-[28px] w-full max-w-5xl h-[85vh] flex flex-col shadow-2xl overflow-hidden" 
         @click.outside="showAddModal = false" 
         x-transition.scale.origin.bottom>
        
        <div class="px-6 py-3 border-b border-slate-100 flex justify-between items-center shrink-0">
            <h2 class="text-[16px] font-black text-slate-900 tracking-tight" 
                x-text="isEdit ? 'Chỉnh Sửa Sản Phẩm' : 'Thêm Sản Phẩm Mới'"></h2>
            <button @click="showAddModal = false" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-[#C1121F] hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 p-5 grid grid-cols-3 gap-5 min-h-0 overflow-hidden">
            
            <div class="col-span-1 flex flex-col gap-2 min-h-0 overflow-hidden">
                <label class="text-[11px] font-black uppercase tracking-wider text-slate-400">Thư viện hình ảnh</label>
                
                <div x-data="{ isDropping: false }"
                     @dragover.prevent="isDropping = true"
                     @dragleave.prevent="isDropping = false"
                     @drop.prevent="
                         isDropping = false;
                         if($event.dataTransfer.files.length > 0) {
                             Array.from($event.dataTransfer.files).forEach(file => {
                                 if(file.type.startsWith('image/')) {
                                     editingItem.images.push({
                                         preview: URL.createObjectURL(file),
                                         file: file,
                                         isLocal: true
                                     });
                                 }
                             });
                         }
                     "
                     @click="$refs.fileInput.click()"
                     class="border-2 border-dashed rounded-[18px] flex flex-col items-center justify-center p-3 h-28 cursor-pointer transition-all group shrink-0"
                     :class="isDropping ? 'border-[#C1121F] bg-red-50' : 'border-slate-200 bg-slate-50 hover:border-[#C1121F]/40 hover:bg-red-50/30'">
                    
                    <input type="file" x-ref="fileInput" multiple accept="image/*" class="hidden" 
                           @change="
                               Array.from($refs.fileInput.files).forEach(file => {
                                   editingItem.images.push({
                                       preview: URL.createObjectURL(file),
                                       file: file,
                                       isLocal: true
                                   });
                               });
                               $refs.fileInput.value = '';
                           ">

                    <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 group-hover:text-[#C1121F] transition-colors mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-500 text-center" x-text="isDropping ? 'Thả ảnh vào đây!' : 'Kéo thả hoặc Bấm để tải ảnh'"></p>
                </div>

                <div class="flex-1 overflow-y-auto hide-scroll border border-slate-100/80 rounded-[16px] p-2 bg-slate-50/50">
                    <div class="grid grid-cols-3 gap-2">
                        <template x-for="(imgItem, index) in editingItem.images" :key="index">
                            <div class="aspect-square rounded-xl bg-white border border-slate-200 relative overflow-hidden group shadow-sm">
                                <img :src="imgItem.preview || imgItem" class="w-full h-full object-cover" x-on:error="$event.target.src='https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=300'">
                                <button @click="editingItem.images.splice(index, 1)" title="Xóa ảnh này" class="absolute top-1 right-1 w-5 h-5 rounded-full bg-slate-900/60 backdrop-blur-sm text-white flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-opacity hover:bg-[#C1121F]">✕</button>
                            </div>
                        </template>
                        
                        <template x-if="editingItem.images.length === 0">
                            <div class="col-span-3 text-center py-8 text-[11px] font-bold text-slate-400 border border-dashed border-slate-200 rounded-xl bg-white">Chưa có ảnh nào</div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="col-span-1 flex flex-col gap-3 min-h-0 overflow-y-auto hide-scroll border-x border-slate-100 px-3">
                <label class="text-[11px] font-black uppercase tracking-wider text-slate-400">Thông tin cơ bản</label>
                
                <div>
                    <label class="text-[11px] font-bold text-slate-600 mb-1 block">Tên sản phẩm</label>
                    <input type="text" x-model="editingItem.name" placeholder="Nhập tên..." class="w-full bg-slate-50 border border-slate-200 text-[12px] font-bold text-slate-800 rounded-xl px-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                </div>
                
                <div>
                    <label class="text-[11px] font-bold text-slate-600 mb-1 block">Mã định danh SKU</label>
                    <input type="text" x-model="editingItem.sku" placeholder="RC-..." class="w-full bg-slate-50 border border-slate-200 text-[12px] font-bold text-slate-800 rounded-xl px-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="text-[11px] font-bold text-slate-600 mb-1 block">Phân loại danh mục</label>
                    <select x-model="editingItem.category" class="w-full bg-slate-50 border border-slate-200 text-[12px] font-bold text-slate-800 rounded-xl px-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all cursor-pointer">
                        <option value="Áo Nam">Áo Nam</option>
                        <option value="Quần Nam">Quần Nam</option>
                        <option value="Áo Nữ">Áo Nữ</option>
                        <option value="Phụ Kiện">Phụ Kiện</option>
                    </select>
                </div>

                <div>
                    <label class="text-[11px] font-bold text-slate-600 mb-1 block">Giá niêm yết</label>
                    <input type="text" x-model="editingItem.price" placeholder="0 đ" class="w-full bg-slate-50 border border-slate-200 text-[12px] font-bold text-slate-800 rounded-xl px-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                </div>

                <div>
                    <label class="text-[11px] font-bold text-slate-600 mb-1 block">Nhãn tóm tắt kho</label>
                    <input type="text" x-model="editingItem.alert" placeholder="Ví dụ: Hết size M..." class="w-full bg-slate-50 border border-slate-200 text-[12px] font-bold text-slate-800 rounded-xl px-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                </div>
            </div>

            <div class="col-span-1 flex flex-col gap-2 min-h-0 overflow-hidden" x-data="{ newSize: '', newColor: '' }">
                <label class="text-[11px] font-black uppercase tracking-wider text-slate-400 pl-2">Số lượng biến thể lẻ</label>
                
                <div class="flex items-center gap-1.5 mb-1 px-1">
                    <input type="text" x-model="newSize" placeholder="Size (S,M..)" class="w-[30%] bg-slate-50 border border-slate-200 text-[11px] font-bold text-slate-800 rounded-lg px-2 py-1.5 outline-none focus:border-[#C1121F]/40 transition-all uppercase">
                    <input type="text" x-model="newColor" placeholder="Màu sắc..." @keydown.enter="if(newSize && newColor) { editingItem.matrix.push({size: newSize.toUpperCase(), color: newColor, stock: 0}); newSize=''; newColor=''; }" class="flex-1 bg-slate-50 border border-slate-200 text-[11px] font-bold text-slate-800 rounded-lg px-2 py-1.5 outline-none focus:border-[#C1121F]/40 transition-all capitalize">
                    <button @click="if(newSize && newColor) { editingItem.matrix.push({size: newSize.toUpperCase(), color: newColor, stock: 0}); newSize=''; newColor=''; }" class="w-7 h-7 flex shrink-0 items-center justify-center bg-slate-900 text-white rounded-lg hover:bg-black transition-colors font-black shadow-sm pb-0.5">+</button>
                </div>

                <div class="flex-1 overflow-y-auto hide-scroll p-1 flex flex-col gap-2 border border-slate-100 rounded-[16px] bg-slate-50/30">
                    <template x-for="(variant, idx) in editingItem.matrix" :key="idx">
                        <div class="bg-white border border-slate-200/60 p-2.5 rounded-xl flex flex-col gap-2.5 shadow-sm transition-colors hover:border-slate-300 group">
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-slate-50 border border-slate-200 text-[10px] font-black text-slate-700 flex items-center justify-center" x-text="variant.size"></span>
                                    <span class="text-[12px] font-bold text-slate-600" x-text="variant.color"></span>
                                </div>
                                <button @click="editingItem.matrix.splice(idx, 1)" title="Xóa phân loại này" class="text-slate-300 hover:text-[#C1121F] transition-colors opacity-0 group-hover:opacity-100 p-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <div class="flex items-center justify-between border-t border-slate-50 pt-2">
                                <span class="text-[10px] font-bold text-slate-400">Tồn kho:</span>
                                <div class="flex items-center border border-slate-200 rounded-lg bg-white overflow-hidden h-7 w-20 shrink-0 shadow-sm">
                                    <button @click="if(variant.stock > 0) variant.stock--" class="w-6 h-full text-slate-500 hover:bg-slate-50 hover:text-[#C1121F] font-bold text-[12px] transition-colors">-</button>
                                    <input type="number" x-model.number="variant.stock" class="w-full h-full text-center text-[11px] font-black text-slate-800 border-none p-0 focus:ring-0 outline-none appearance-none">
                                    <button @click="variant.stock++" class="w-6 h-full text-slate-500 hover:bg-slate-50 hover:text-emerald-600 font-bold text-[12px] transition-colors">+</button>
                                </div>
                            </div>

                        </div>
                    </template>
                    
                    <template x-if="editingItem.matrix.length === 0">
                        <div class="text-center py-6 text-[11px] text-slate-400 font-bold">Chưa có phân loại hàng nào. <br> Hãy thêm ở trên.</div>
                    </template>
                </div>
            </div>

        </div>

        <div class="px-6 py-3 border-t border-slate-100 flex justify-end gap-2.5 shrink-0 bg-slate-50/50">
            <button @click="showAddModal = false" class="px-5 py-2 rounded-full text-[13px] font-bold text-slate-600 hover:bg-slate-200 transition-colors">Hủy Bỏ</button>
            <button @click="saveProduct()" class="px-7 py-2 rounded-full bg-[#C1121F] text-white text-[13px] font-bold hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">Lưu Thay Đổi</button>
        </div>
    </div>
</div>