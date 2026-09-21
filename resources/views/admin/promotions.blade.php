<x-admin.layout>
    <div class="flex flex-col h-full gap-3" x-data="flashSaleManager()" x-cloak>
        
        <div class="flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Chiến Dịch Flash Sale</h1>
            </div>
            
            <button @click="openCreateModal()" class="flex items-center gap-2 bg-[#C1121F] text-white font-bold text-[12px] px-5 py-2.5 rounded-full hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span>Tạo Chiến Dịch Mới</span>
            </button>
        </div>

        <div class="flex-1 min-h-0 flex gap-4">
            
            <div class="flex-1 min-w-0 flex flex-col gap-3">
                
                <div class="bg-white rounded-[20px] p-2.5 shadow-sm border border-slate-100 flex items-center justify-between shrink-0 transition-all min-h-[52px]">
                    <div class="flex items-center gap-2 w-full overflow-x-auto hide-scroll">
                        <div class="relative w-[320px] shrink-0">
                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="searchQuery" placeholder="Tìm tên chiến dịch..." class="w-full bg-slate-50 border border-slate-100 text-[11px] font-bold text-slate-800 rounded-full pl-8 pr-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                        </div>
                        <div class="w-px h-4 bg-slate-200 shrink-0 mx-0.5"></div>
                        <select x-model="statusFilter" class="text-[11px] font-bold bg-slate-50 border border-slate-100 rounded-full px-3 py-1.5 outline-none text-slate-700 cursor-pointer">
                            <option value="all">Tất cả trạng thái</option>
                            <option value="upcoming">Sắp diễn ra</option>
                            <option value="active">Đang chạy</option>
                            <option value="ended">Đã kết thúc</option>
                        </select>
                    </div>
                </div>

                <div class="flex-1 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                    <div class="flex-1 overflow-x-auto overflow-y-scroll hide-scroll relative">
                        <table class="w-full text-left border-collapse table-fixed min-w-[600px]">
                            <thead class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-slate-100 z-10 shadow-sm">
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                                    <th class="px-4 py-3 w-[40%]">Chiến Dịch</th>
                                    <th class="px-4 py-3 w-[25%] text-center">Thời Gian</th>
                                    <th class="px-4 py-3 w-[15%] text-center">Sản Phẩm</th>
                                    <th class="px-4 py-3 w-[20%] text-center">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody class="text-[12px] divide-y divide-slate-50">
                                <template x-for="campaign in filteredCampaigns()" :key="campaign.id">
                                    <tr @click="selectedCampaign = campaign" class="transition-colors group cursor-pointer" :class="(selectedCampaign && selectedCampaign.id === campaign.id) ? 'bg-red-50/40' : 'hover:bg-slate-50/60'">
                                        <td class="px-4 py-3">
                                            <div class="font-black text-[13px] text-slate-900 group-hover:text-[#C1121F] transition-colors truncate" x-text="campaign.name"></div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="text-[10px] font-bold text-slate-600" x-text="campaign.startTime"></div>
                                            <div class="text-[10px] font-bold text-slate-400" x-text="'đến ' + campaign.endTime"></div>
                                        </td>
                                        <td class="px-4 py-3 text-center font-black text-slate-600" x-text="campaign.items.length + ' sản phẩm '"></td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block text-[9px] font-black uppercase tracking-wide px-2 py-0.5 rounded" 
                                                  :class="{
                                                      'bg-blue-50 text-blue-600': campaign.status === 'upcoming',
                                                      'bg-emerald-50 text-emerald-600': campaign.status === 'active',
                                                      'bg-slate-100 text-slate-500': campaign.status === 'ended'
                                                  }" 
                                                  x-text="getStatusText(campaign.status)"></span>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredCampaigns().length === 0" style="display: none;">
                                    <td colspan="4" class="px-4 py-8 text-center text-[12px] font-bold text-slate-400">Không tìm thấy chiến dịch nào.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="w-[360px] shrink-0 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden p-4">
                <template x-if="selectedCampaign">
                    <div class="flex flex-col flex-1 min-h-0">
                        
                        <div class="flex flex-col gap-2 pb-3 border-b border-slate-100 shrink-0">
                            <div class="flex justify-between items-start">
                                <h3 class="text-[16px] font-black text-slate-900 tracking-tight leading-tight" x-text="selectedCampaign.name"></h3>
                                <span class="inline-block text-[9px] font-black uppercase tracking-wide px-2 py-1 rounded shrink-0 ml-2" 
                                      :class="{ 'bg-blue-50 text-blue-600': selectedCampaign.status === 'upcoming', 'bg-emerald-50 text-emerald-600': selectedCampaign.status === 'active', 'bg-slate-100 text-slate-500': selectedCampaign.status === 'ended' }" 
                                      x-text="getStatusText(selectedCampaign.status)"></span>
                            </div>
                            
                            <div class="bg-slate-50 rounded-xl p-2.5 flex items-center justify-between border border-slate-100">
                                <div>
                                    <p class="text-[9px] font-black uppercase text-slate-400">Bắt đầu</p>
                                    <p class="text-[11px] font-bold text-slate-800" x-text="selectedCampaign.startTime"></p>
                                </div>
                                <div class="w-px h-6 bg-slate-200"></div>
                                <div>
                                    <p class="text-[9px] font-black uppercase text-slate-400">Kết thúc</p>
                                    <p class="text-[11px] font-bold text-[#C1121F]" x-text="selectedCampaign.endTime"></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between py-2 shrink-0">
                            <h4 class="text-[11px] font-black uppercase tracking-wider text-slate-400">Sản Phẩm Sale</h4>
                            
                            <button @click="openAddProductModal()" class="text-[10px] font-black text-blue-600 bg-blue-50 px-2.5 py-1.5 rounded hover:bg-blue-100 transition-colors shadow-sm">+ Thêm Sản Phẩm</button>
                        </div>

                        <div class="flex-1 min-h-0 overflow-y-auto hide-scroll flex flex-col gap-2 relative">
                            <template x-for="(item, idx) in selectedCampaign.items" :key="item.id || idx">
                                <div class="flex flex-col gap-2 p-2.5 border border-slate-100 rounded-xl bg-white hover:border-slate-200 transition-colors group">
                                    <div class="flex items-start justify-between gap-2.5">
                                        <div class="flex items-center gap-2.5 flex-1 min-w-0">
                                            <img :src="item.img" class="w-10 h-10 rounded-lg object-cover border border-slate-50 shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-[12px] font-black text-slate-800 truncate" x-text="item.name"></div>
                                                <div class="flex items-center gap-1.5 mt-0.5">
                                                    <span class="text-[11px] font-black text-[#C1121F]" x-text="item.salePrice"></span>
                                                    <span class="text-[10px] font-bold text-slate-400 line-through" x-text="item.originalPrice"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button @click="removeItemFromCampaign(idx)" class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-red-50 hover:text-[#C1121F] transition-all shrink-0">✕</button>
                                    </div>
                                    
                                    <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100 flex flex-col gap-1 mt-1">
                                        <div class="flex justify-between text-[9px] font-black text-slate-500 uppercase">
                                            <span>Đã bán: <span class="text-slate-800" x-text="item.sold"></span></span>
                                            <span>Giới hạn: <span x-text="item.limit"></span></span>
                                        </div>
                                        <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-[#C1121F] rounded-full transition-all" :style="'width: ' + (item.limit > 0 ? (item.sold / item.limit * 100) : 0) + '%'"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="selectedCampaign.items.length === 0">
                                <div class="text-center py-6 text-[11px] font-bold text-slate-400">Chiến dịch này chưa có sản phẩm nào.</div>
                            </template>
                        </div>

                        <div class="border-t border-slate-100 pt-3 mt-1 shrink-0">
                            <button @click="openEditModal()" class="w-full py-2.5 rounded-xl text-[12px] font-bold text-slate-700 bg-slate-50 border border-slate-200 hover:bg-slate-100 transition-colors shadow-sm">Sửa Cấu Hình Chiến Dịch</button>
                        </div>

                    </div>
                </template>

                <template x-if="!selectedCampaign">
                    <div class="flex flex-col items-center justify-center flex-1 opacity-50">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="text-[11px] font-bold text-slate-500">Chọn chiến dịch để xem chi tiết</span>
                    </div>
                </template>
            </div>
        </div>

        <div x-show="showCampaignModal" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
            <div class="bg-white rounded-[24px] w-full max-w-md flex flex-col shadow-2xl overflow-hidden p-6" @click.outside="showCampaignModal = false" x-transition.scale.origin.bottom>
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-[18px] font-black text-slate-900" x-text="isEdit ? 'Sửa Chiến Dịch' : 'Tạo Chiến Dịch Mới'"></h2>
                    <button @click="showCampaignModal = false" class="text-slate-400 hover:text-[#C1121F] bg-slate-50 hover:bg-red-50 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="flex flex-col gap-4 mb-6">
                    <div>
                        <label class="text-[11px] font-black text-slate-800 mb-1 block">Tên chiến dịch</label>
                        <input type="text" x-model="editingCampaign.name" placeholder="Ví dụ: Siêu Sale Giữa Tháng..." class="w-full bg-slate-50 border border-slate-200 text-[13px] font-bold text-slate-800 rounded-xl px-3 py-2.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[11px] font-black text-slate-800 mb-1 block">Bắt đầu</label>
                            <input type="text" x-model="editingCampaign.startTime" placeholder="DD/MM/YYYY HH:mm" class="w-full bg-slate-50 border border-slate-200 text-[12px] font-bold text-slate-800 rounded-xl px-3 py-2.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all text-center">
                        </div>
                        <div>
                            <label class="text-[11px] font-black text-slate-800 mb-1 block">Kết thúc</label>
                            <input type="text" x-model="editingCampaign.endTime" placeholder="DD/MM/YYYY HH:mm" class="w-full bg-slate-50 border border-slate-200 text-[12px] font-bold text-slate-800 rounded-xl px-3 py-2.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all text-center">
                        </div>
                    </div>
                    <div>
                        <label class="text-[11px] font-black text-slate-800 mb-1 block">Trạng thái</label>
                        <select x-model="editingCampaign.status" class="w-full bg-slate-50 border border-slate-200 text-[13px] font-bold text-slate-800 rounded-xl px-3 py-2.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all cursor-pointer">
                            <option value="upcoming">Sắp diễn ra</option>
                            <option value="active">Đang chạy</option>
                            <option value="ended">Đã kết thúc</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full">
                    <button @click="showCampaignModal = false" class="flex-1 py-2.5 rounded-full text-[13px] font-bold text-slate-600 bg-slate-50 hover:bg-slate-200 transition-colors">Hủy Bỏ</button>
                    <button @click="saveCampaign()" class="flex-1 py-2.5 rounded-full bg-[#C1121F] text-white text-[13px] font-bold hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">Lưu Chiến Dịch</button>
                </div>
            </div>
        </div>

        <div x-show="showAddProductModal" style="display: none;" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
            <div class="bg-white rounded-[28px] w-full max-w-4xl flex flex-col shadow-2xl overflow-hidden h-[85vh]" @click.outside="showAddProductModal = false" x-transition.scale.origin.bottom>
                
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center shrink-0 bg-slate-50/50">
                    <div>
                        <h2 class="text-[18px] font-black text-slate-900">Chọn Sản Phẩm Khuyến Mãi</h2>
                        <p class="text-[11px] font-bold text-slate-500 mt-1">Đang thêm vào: <span class="text-[#C1121F]" x-text="selectedCampaign?.name"></span></p>
                    </div>
                    <button @click="showAddProductModal = false" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#C1121F] hover:bg-red-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-4 border-b border-slate-50 shrink-0">
                    <div class="relative w-[350px]">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" x-model="productSearchQuery" placeholder="Tìm tên sản phẩm trong kho..." class="w-full bg-slate-50 border border-slate-100 text-[12px] font-bold text-slate-800 rounded-full pl-9 pr-4 py-2 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto hide-scroll bg-slate-50/30 p-4">
                    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50/80 border-b border-slate-100">
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                                    <th class="px-4 py-3 w-12 text-center">Chọn</th>
                                    <th class="px-4 py-3 w-[45%]">Sản Phẩm Trong Kho</th>
                                    <th class="px-4 py-3 w-[25%] text-center">Set Giá Sale</th>
                                    <th class="px-4 py-3 w-[20%] text-center">Giới Hạn SL</th>
                                </tr>
                            </thead>
                            <tbody class="text-[12px] divide-y divide-slate-50">
                                <template x-for="prod in filteredModalProducts()" :key="prod.id">
                                    <tr class="transition-colors hover:bg-slate-50 cursor-pointer" @click="prod.selected = !prod.selected" :class="prod.selected ? 'bg-red-50/30' : ''">
                                        <td class="px-4 py-3 text-center" @click.stop="">
                                            <input type="checkbox" x-model="prod.selected" class="w-4 h-4 rounded border-slate-300 text-[#C1121F] focus:ring-[#C1121F] cursor-pointer">
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <img :src="prod.img" class="w-10 h-10 rounded-lg object-cover border border-slate-100">
                                                <div>
                                                    <div class="font-black text-[12px] text-slate-800 truncate max-w-[200px]" x-text="prod.name"></div>
                                                    <div class="font-bold text-[10px] text-slate-400 mt-0.5" x-text="'Giá gốc: ' + prod.originalPrice"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center" @click.stop="">
                                            <div class="relative w-[120px] mx-auto">
                                                <input type="text" x-model="prod.salePrice" :disabled="!prod.selected" placeholder="VD: 199.000đ" class="w-full text-[11px] font-bold text-center border rounded-lg px-2 py-1.5 outline-none transition-colors" :class="prod.selected ? 'border-[#C1121F]/40 bg-white text-[#C1121F]' : 'border-slate-200 bg-slate-50 text-slate-400'">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center" @click.stop="">
                                            <input type="number" x-model.number="prod.limit" :disabled="!prod.selected" class="w-[80px] text-[11px] font-bold text-center border rounded-lg px-2 py-1.5 outline-none transition-colors mx-auto" :class="prod.selected ? 'border-[#C1121F]/40 bg-white text-slate-900' : 'border-slate-200 bg-slate-50 text-slate-400'">
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredModalProducts().length === 0" style="display: none;">
                                    <td colspan="4" class="px-4 py-8 text-center text-[12px] font-bold text-slate-400">Không tìm thấy sản phẩm trong kho.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50 shrink-0">
                    <div class="text-[12px] font-black text-slate-500">
                        Đã chọn: <span class="text-[#C1121F]" x-text="modalProducts.filter(p => p.selected).length + ' sản phẩm'"></span>
                    </div>
                    <div class="flex gap-3">
                        <button @click="showAddProductModal = false" class="px-6 py-2.5 rounded-full text-[13px] font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors shadow-sm">Hủy</button>
                        <button @click="confirmAddProducts()" class="px-6 py-2.5 rounded-full bg-[#C1121F] text-white text-[13px] font-bold hover:bg-[#9D0208] transition-colors shadow-md active:scale-95">Xác Nhận Thêm Sản Phẩm</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('flashSaleManager', () => ({
                searchQuery: '',
                statusFilter: 'all',
                
                showCampaignModal: false,
                showAddProductModal: false,
                isEdit: false,
                editingCampaign: { id: null, name: '', startTime: '', endTime: '', status: 'upcoming', items: [] },

                productSearchQuery: '',
                modalProducts: [], // Mảng tạm thời phục vụ cho bảng Popup Chọn Sản Phẩm

                // Database kho hàng tổng (giả lập)
                inventoryDB: [
                    { id: 101, name: 'Áo Thun Polo Basic', originalPrice: '299.000đ', img: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=100&auto=format&fit=crop' },
                    { id: 102, name: 'Quần Jean Slimfit', originalPrice: '450.000đ', img: 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=100&auto=format&fit=crop' },
                    { id: 103, name: 'Áo Khoác Dạ Bomber', originalPrice: '850.000đ', img: 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?q=80&w=100&auto=format&fit=crop' },
                    { id: 104, name: 'Giày Sneaker Chạy Bộ', originalPrice: '1.299.000đ', img: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=100&auto=format&fit=crop' },
                    { id: 105, name: 'Áo Sơ Mi Trắng Form Rộng', originalPrice: '350.000đ', img: 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?q=80&w=100&auto=format&fit=crop' },
                    { id: 106, name: 'Kính Râm Phản Quang', originalPrice: '199.000đ', img: 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=100&auto=format&fit=crop' },
                ],

                campaigns: [
                    { 
                        id: 1, name: 'Siêu Sale 6/6 - Nửa Năm Nhìn Lại', 
                        startTime: '06/06/2026 00:00', endTime: '06/06/2026 23:59', status: 'active',
                        items: [
                            { id: 101, name: 'Áo Thun Polo Basic', originalPrice: '299.000đ', salePrice: '199.000đ', limit: 100, sold: 85, img: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=100&auto=format&fit=crop' },
                            { id: 102, name: 'Quần Jean Slimfit', originalPrice: '450.000đ', salePrice: '350.000đ', limit: 50, sold: 50, img: 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=100&auto=format&fit=crop' }
                        ]
                    },
                    { 
                        id: 2, name: 'Xả Kho Đón Hè 2026', 
                        startTime: '15/06/2026 08:00', endTime: '20/06/2026 23:59', status: 'upcoming',
                        items: [
                            { id: 103, name: 'Áo Khoác Dạ Bomber', originalPrice: '850.000đ', salePrice: '500.000đ', limit: 30, sold: 0, img: 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?q=80&w=100&auto=format&fit=crop' }
                        ]
                    }
                ],
                selectedCampaign: null,

                init() {
                    this.selectedCampaign = this.campaigns[0];
                },

                filteredCampaigns() {
                    let result = this.campaigns;
                    if (this.statusFilter !== 'all') result = result.filter(c => c.status === this.statusFilter);
                    if (this.searchQuery !== '') {
                        const q = this.searchQuery.toLowerCase();
                        result = result.filter(c => c.name.toLowerCase().includes(q));
                    }
                    return result;
                },

                getStatusText(status) {
                    const map = { 'upcoming': 'Sắp diễn ra', 'active': 'Đang chạy', 'ended': 'Đã kết thúc' };
                    return map[status] || status;
                },

                // Logic Modal Cấu Hình
                openCreateModal() {
                    this.isEdit = false;
                    this.editingCampaign = { id: Date.now(), name: '', startTime: '10/06/2026 00:00', endTime: '15/06/2026 23:59', status: 'upcoming', items: [] };
                    this.showCampaignModal = true;
                },
                openEditModal() {
                    if (!this.selectedCampaign) return;
                    this.isEdit = true;
                    this.editingCampaign = JSON.parse(JSON.stringify(this.selectedCampaign));
                    this.showCampaignModal = true;
                },
                saveCampaign() {
                    if (!this.editingCampaign.name.trim()) { alert('Vui lòng điền tên chiến dịch!'); return; }
                    if (this.isEdit) {
                        let index = this.campaigns.findIndex(c => c.id === this.editingCampaign.id);
                        if (index !== -1) this.campaigns[index] = this.editingCampaign;
                    } else {
                        this.campaigns.unshift(this.editingCampaign);
                    }
                    this.campaigns = [...this.campaigns];
                    this.selectedCampaign = this.editingCampaign;
                    this.showCampaignModal = false;
                },

                // Logic Modal Thêm Sản Phẩm Mới
                openAddProductModal() {
                    if (!this.selectedCampaign) return;
                    this.productSearchQuery = '';
                    
                    // Lọc kho: Chỉ hiển thị những sản phẩm chưa nằm trong danh sách Sale hiện tại
                    const currentItemIds = this.selectedCampaign.items.map(item => item.id);
                    this.modalProducts = this.inventoryDB
                        .filter(p => !currentItemIds.includes(p.id))
                        .map(p => ({ ...p, selected: false, salePrice: '', limit: 10, sold: 0 }));
                        
                    this.showAddProductModal = true;
                },

                filteredModalProducts() {
                    if (this.productSearchQuery === '') return this.modalProducts;
                    const q = this.productSearchQuery.toLowerCase();
                    return this.modalProducts.filter(p => p.name.toLowerCase().includes(q));
                },

                confirmAddProducts() {
                    // Lấy ra các sản phẩm đã tick chọn
                    const toAdd = this.modalProducts.filter(p => p.selected);
                    
                    if (toAdd.length === 0) {
                        alert('Vui lòng chọn ít nhất 1 sản phẩm bằng cách đánh dấu tick!');
                        return;
                    }

                    // Kiểm tra xem đã gõ giá sale chưa
                    for (let p of toAdd) {
                        if (!p.salePrice.trim()) {
                            alert(`Vui lòng nhập giá Sale cho: ${p.name}`);
                            return;
                        }
                        if (p.limit <= 0) {
                            alert(`Giới hạn số lượng bán cho ${p.name} phải lớn hơn 0!`);
                            return;
                        }
                    }

                    // Đẩy sản phẩm mới vào campaign hiện tại
                    this.selectedCampaign.items.push(...toAdd);
                    
                    // Đồng bộ lại Vue/Alpine reactivity
                    let index = this.campaigns.findIndex(c => c.id === this.selectedCampaign.id);
                    if (index !== -1) {
                        this.campaigns[index] = this.selectedCampaign;
                        this.campaigns = [...this.campaigns];
                    }
                    
                    this.showAddProductModal = false;
                },
                
                removeItemFromCampaign(idx) {
                    if(confirm('Bạn có muốn gỡ sản phẩm này khỏi Flash Sale không?')) {
                        this.selectedCampaign.items.splice(idx, 1);
                        let index = this.campaigns.findIndex(c => c.id === this.selectedCampaign.id);
                        if(index !== -1) {
                            this.campaigns[index] = this.selectedCampaign;
                            this.campaigns = [...this.campaigns];
                        }
                    }
                }
            }));
        });
    </script>
</x-admin.layout>