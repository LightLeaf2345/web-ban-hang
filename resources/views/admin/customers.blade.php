<x-admin.layout>
    <div class="flex flex-col h-full gap-3" x-data="customerManager()" x-cloak>
        
        <!-- HEADER -->
        <div class="flex items-center justify-between shrink-0">
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Quản Lý Khách Hàng</h1>
            
            <button @click="exportCSV()" class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600 font-bold text-[12px] px-4 py-2 rounded-full hover:bg-slate-50 transition-colors shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Xuất Danh Sách (CSV)</span>
            </button>
        </div>

        <!-- CẤU TRÚC LẠI BỐ CỤC 2 CỘT -->
        <div class="flex-1 min-h-0 flex gap-4">
            
            <!-- CỘT TRÁI: BỘ LỌC + DANH SÁCH KHÁCH HÀNG -->
            <div class="flex-1 min-w-0 flex flex-col gap-3">
                
                <!-- BỘ LỌC TÌM KIẾM (Đã gộp vào cột trái để bằng chiều rộng bảng) -->
                <div class="bg-white rounded-[20px] p-2.5 shadow-sm border border-slate-100 flex items-center justify-between shrink-0 transition-all min-h-[52px]">
                    <div class="flex items-center gap-2 w-full overflow-x-auto hide-scroll">
                        <div class="relative w-[320px] shrink-0">
                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="searchQuery" placeholder="Tìm tên, SĐT, Email..." class="w-full bg-slate-50 border border-slate-100 text-[11px] font-bold text-slate-800 rounded-full pl-8 pr-3 py-1.5 outline-none focus:border-[#C1121F]/40 focus:bg-white transition-all">
                        </div>
                        <div class="w-px h-4 bg-slate-200 shrink-0 mx-0.5"></div>
                        <select x-model="statusFilter" class="text-[11px] font-bold bg-slate-50 border border-slate-100 rounded-full px-3 py-1.5 outline-none text-slate-700 cursor-pointer">
                            <option value="all">Tất cả trạng thái</option>
                            <option value="active">Đang hoạt động</option>
                            <option value="blocked">Đã bị chặn</option>
                        </select>
                        <select class="text-[11px] font-bold bg-slate-50 border border-slate-100 rounded-full px-3 py-1.5 outline-none text-slate-700 cursor-pointer">
                            <option>Sắp xếp: Mới nhất</option>
                            <option>Chi tiêu: Nhiều nhất</option>
                        </select>
                    </div>
                </div>

                <!-- BẢNG DANH SÁCH -->
                <div class="flex-1 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                    <div class="flex-1 overflow-x-auto overflow-y-scroll hide-scroll relative">
                        <table class="w-full text-left border-collapse table-fixed min-w-[650px]">
                            <thead class="sticky top-0 bg-white/95 backdrop-blur-sm border-b border-slate-100 z-10 shadow-sm">
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                                    <th class="px-4 py-3 w-[8%] text-center">ID</th>
                                    <th class="px-4 py-3 w-[32%]">Khách Hàng</th>
                                    <th class="px-4 py-3 w-[20%] text-center">Tổng Đơn</th>
                                    <th class="px-4 py-3 w-[20%] text-right">Đã Chi Tiêu</th>
                                    <th class="px-4 py-3 w-[20%] text-center">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody class="text-[12px] divide-y divide-slate-50">
                                <template x-for="customer in filteredCustomers()" :key="customer.id">
                                    <tr @click="selectedCustomer = customer" class="transition-colors group cursor-pointer" :class="(selectedCustomer && selectedCustomer.id === customer.id) ? 'bg-red-50/40' : 'hover:bg-slate-50/60'">
                                        
                                        <td class="px-4 py-3 text-center font-bold text-slate-400" x-text="'#' + customer.id"></td>
                                        
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black shrink-0 uppercase" 
                                                     :class="customer.status === 'blocked' ? 'bg-red-100 text-[#C1121F]' : 'bg-slate-100 text-slate-500'" 
                                                     x-text="customer.name.charAt(0)"></div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-bold text-[12px] text-slate-800 truncate group-hover:text-[#C1121F] transition-colors" x-text="customer.name"></div>
                                                    <div class="text-[10px] font-bold text-slate-400 truncate" x-text="customer.phone"></div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-4 py-3 text-center font-black text-slate-600" x-text="customer.totalOrders + ' đơn'"></td>
                                        <td class="px-4 py-3 text-right font-black text-emerald-600" x-text="customer.totalSpent"></td>
                                        
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block text-[9px] font-black uppercase tracking-wide px-2 py-0.5 rounded" 
                                                  :class="{
                                                      'bg-emerald-50 text-emerald-600': customer.status === 'active',
                                                      'bg-red-50 text-[#C1121F]': customer.status === 'blocked'
                                                  }" 
                                                  x-text="customer.status === 'active' ? 'Hoạt Động' : 'Đã Chặn'"></span>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredCustomers().length === 0" style="display: none;">
                                    <td colspan="5" class="px-4 py-8 text-center text-[12px] font-bold text-slate-400">Không tìm thấy khách hàng nào.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CỘT PHẢI: HỒ SƠ KHÁCH HÀNG (CUSTOMER PROFILE) -->
            <div class="w-[340px] shrink-0 bg-white rounded-[24px] shadow-sm border border-slate-100 flex flex-col overflow-hidden p-4">
                <template x-if="selectedCustomer">
                    <div class="flex flex-col flex-1 min-h-0">
                        
                        <!-- 1. Header (Avatar & Tên) -->
                        <div class="flex flex-col items-center justify-center pt-2 pb-4 border-b border-slate-100 shrink-0">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-[20px] font-black uppercase mb-3 shadow-sm"
                                 :class="selectedCustomer.status === 'blocked' ? 'bg-red-50 text-[#C1121F] border-2 border-red-100' : 'bg-slate-100 text-slate-600 border-2 border-slate-200'" 
                                 x-text="selectedCustomer.name.charAt(0)"></div>
                            <h3 class="text-[16px] font-black text-slate-900 tracking-tight text-center" x-text="selectedCustomer.name"></h3>
                            <p class="text-[11px] font-bold text-slate-400 mt-0.5" x-text="'Thành viên từ: ' + selectedCustomer.registeredAt"></p>
                            
                            <span class="inline-block text-[9px] font-black uppercase tracking-wide px-2.5 py-1 rounded mt-2" 
                                  :class="selectedCustomer.status === 'blocked' ? 'bg-[#C1121F] text-white' : 'bg-emerald-500 text-white'" 
                                  x-text="selectedCustomer.status === 'blocked' ? 'Tài Khoản Đang Bị Khóa' : 'Tài Khoản Hợp Lệ'"></span>
                        </div>

                        <!-- 2. Thông Tin Liên Hệ -->
                        <div class="flex-1 min-h-0 overflow-y-auto hide-scroll py-4 flex flex-col gap-4">
                            
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2 px-1">Thông Tin Liên Hệ</h4>
                                <div class="bg-slate-50/70 rounded-xl p-3 border border-slate-100 flex flex-col gap-2.5">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <div class="text-[12px] font-bold text-slate-700" x-text="selectedCustomer.phone"></div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <div class="text-[12px] font-bold text-slate-700" x-text="selectedCustomer.email"></div>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <div class="text-[12px] font-bold text-slate-700 leading-relaxed" x-text="selectedCustomer.address"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Thống Kê Mua Hàng -->
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2 px-1">Lịch Sử Mua Hàng</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-white border border-slate-100 rounded-xl p-3 flex flex-col items-center justify-center text-center shadow-sm">
                                        <span class="text-[20px] font-black text-blue-600 leading-none mb-1" x-text="selectedCustomer.totalOrders"></span>
                                        <span class="text-[10px] font-bold text-slate-400">Đơn hàng</span>
                                    </div>
                                    <div class="bg-white border border-slate-100 rounded-xl p-3 flex flex-col items-center justify-center text-center shadow-sm">
                                        <span class="text-[14px] font-black text-emerald-600 leading-none mb-1 mt-1" x-text="selectedCustomer.totalSpent"></span>
                                        <span class="text-[10px] font-bold text-slate-400">Tổng chi tiêu</span>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <button class="text-[11px] font-bold text-blue-600 hover:underline">Xem tất cả đơn hàng của khách này</button>
                                </div>
                            </div>

                        </div>

                        <!-- 4. Nút Khóa / Mở Khóa Tài Khoản -->
                        <div class="border-t border-slate-100 pt-4 mt-2 shrink-0">
                            <button x-show="selectedCustomer.status === 'active'" @click="confirmToggleBlock()" class="w-full py-2.5 rounded-xl text-[12px] font-bold text-[#C1121F] bg-red-50 hover:bg-red-100 border border-red-100 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                Chặn Khách Hàng Này
                            </button>
                            
                            <button x-show="selectedCustomer.status === 'blocked'" @click="confirmToggleBlock()" class="w-full py-2.5 rounded-xl text-[12px] font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                Mở Khóa Tài Khoản
                            </button>
                        </div>

                    </div>
                </template>

                <!-- Trạng thái trống -->
                <template x-if="!selectedCustomer">
                    <div class="flex flex-col items-center justify-center flex-1 opacity-50">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="text-[11px] font-bold text-slate-500">Chọn một khách hàng để xem</span>
                    </div>
                </template>
            </div>
        </div>

        <!-- POPUP THÔNG BÁO XÁC NHẬN CHẶN/MỞ CHẶN KHÁCH HÀNG -->
        <div x-show="showConfirmModal" style="display: none;" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
            <div class="bg-white rounded-[24px] w-full max-w-sm flex flex-col shadow-2xl overflow-hidden text-center p-6" @click.outside="showConfirmModal = false" x-transition.scale.origin.bottom>
                
                <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm"
                     :class="selectedCustomer?.status === 'active' ? 'bg-red-50 text-[#C1121F]' : 'bg-emerald-50 text-emerald-600'">
                    <span x-show="selectedCustomer?.status === 'active'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </span>
                    <span x-show="selectedCustomer?.status === 'blocked'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                    </span>
                </div>

                <h2 class="text-[16px] font-black text-slate-900 mb-2" 
                    x-text="selectedCustomer?.status === 'active' ? 'Chặn khách hàng này?' : 'Mở khóa tài khoản?'"></h2>
                
                <p class="text-[12px] font-bold text-slate-500 mb-6" 
                   x-text="selectedCustomer?.status === 'active' ? 'Khách hàng sẽ không thể đặt hàng mới trên hệ thống nhưng vẫn xem được lịch sử.' : 'Khách hàng sẽ có thể giao dịch bình thường trở lại.'"></p>
                
                <div class="flex items-center gap-2.5 w-full">
                    <button @click="showConfirmModal = false" class="flex-1 py-2.5 rounded-full text-[12px] font-bold text-slate-600 bg-slate-50 hover:bg-slate-200 transition-colors">Hủy Bỏ</button>
                    
                    <button @click="executeToggleBlock()" class="flex-1 py-2.5 rounded-full text-white text-[12px] font-bold transition-colors shadow-md active:scale-95"
                            :class="selectedCustomer?.status === 'active' ? 'bg-[#C1121F] hover:bg-[#9D0208]' : 'bg-emerald-600 hover:bg-emerald-700'"
                            x-text="selectedCustomer?.status === 'active' ? 'Xác Nhận Chặn' : 'Xác Nhận Mở'"></button>
                </div>
            </div>
        </div>

    </div>

    <!-- LOGIC ALPINE CHO QUẢN LÝ KHÁCH HÀNG -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('customerManager', () => ({
                searchQuery: '',
                statusFilter: 'all',
                showConfirmModal: false, 
                
                customers: [
                    { id: 101, name: 'Nguyễn Văn A', phone: '0901234567', email: 'nguyenvana@gmail.com', address: 'Số 15, Đường Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh', registeredAt: '12/01/2026', totalOrders: 5, totalSpent: '2.500.000đ', status: 'active' },
                    { id: 102, name: 'Trần Thị B', phone: '0987654321', email: 'tranb@yahoo.com', address: 'Tòa nhà Landmark 81, Quận Bình Thạnh, TP. HCM', registeredAt: '05/03/2026', totalOrders: 1, totalSpent: '850.000đ', status: 'active' },
                    { id: 103, name: 'Lê Cường (Boom Hàng)', phone: '0933333333', email: 'bomhang@spam.com', address: 'Địa chỉ ảo không có thực', registeredAt: '20/05/2026', totalOrders: 3, totalSpent: '0đ', status: 'blocked' },
                    { id: 104, name: 'Phạm Thu Thảo', phone: '0912345678', email: 'thuthao.pham@company.vn', address: '120 Thái Hà, Quận Đống Đa, Hà Nội', registeredAt: '01/06/2026', totalOrders: 12, totalSpent: '15.400.000đ', status: 'active' }
                ],
                selectedCustomer: null,

                init() {
                    this.selectedCustomer = this.customers[0];
                },

                filteredCustomers() {
                    let result = this.customers;
                    if (this.statusFilter !== 'all') {
                        result = result.filter(c => c.status === this.statusFilter);
                    }
                    if (this.searchQuery !== '') {
                        const q = this.searchQuery.toLowerCase();
                        result = result.filter(c => 
                            c.name.toLowerCase().includes(q) || 
                            c.phone.includes(q) || 
                            c.email.toLowerCase().includes(q)
                        );
                    }
                    return result;
                },

                confirmToggleBlock() {
                    if (!this.selectedCustomer) return;
                    this.showConfirmModal = true;
                },

                executeToggleBlock() {
                    const isCurrentlyBlocked = this.selectedCustomer.status === 'blocked';
                    const newStatus = isCurrentlyBlocked ? 'active' : 'blocked';
                    
                    let index = this.customers.findIndex(c => c.id === this.selectedCustomer.id);
                    if(index !== -1) {
                        this.customers[index] = { ...this.customers[index], status: newStatus };
                        this.customers = [...this.customers];
                        this.selectedCustomer = this.customers[index];
                    }
                    
                    this.showConfirmModal = false;
                },

                exportCSV() {
                    let dataToExport = this.filteredCustomers();
                    if (dataToExport.length === 0) { alert('Không có dữ liệu!'); return; }

                    let csvContent = "ID,Tên Khách Hàng,Số Điện Thoại,Email,Ngày Đăng Ký,Tổng Đơn,Tổng Chi Tiêu,Trạng Thái\n";
                    dataToExport.forEach(c => {
                        let statusText = c.status === 'active' ? 'Hoạt Động' : 'Đã Chặn';
                        let row = `"${c.id}","${c.name}","${c.phone}","${c.email}","${c.registeredAt}","${c.totalOrders}","${c.totalSpent}","${statusText}"`;
                        csvContent += row + "\n";
                    });

                    const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' }); 
                    const link = document.createElement("a");
                    link.setAttribute("href", URL.createObjectURL(blob));
                    link.setAttribute("download", "DanhSachKhachHang_RedCherry.csv");
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }));
        });
    </script>
</x-admin.layout>