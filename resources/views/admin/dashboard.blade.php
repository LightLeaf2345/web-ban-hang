<x-admin.layout>
    <div class="flex flex-col h-full gap-3" x-data="{
        exporting: false,
        chartLoaded: false,
        timeRange: 'week', 
        startDate: '2026-06-01', 
        endDate: '2026-06-07',
        chartInstance: null, 
        
        mockData: {
            week: {
                labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
                data: [15, 22, 18, 35, 28, 42, 38]
            },
            month: {
                labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
                data: [120, 155, 110, 185]
            },
            year: {
                labels: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'],
                data: [1200, 1500, 1100, 1800, 2200, 1900, 2500, 2100, 1800, 2400, 2800, 3200]
            },
            custom: {
                labels: ['01/06', '02/06', '03/06', '04/06', '05/06', '06/06', '07/06'],
                data: [10, 25, 15, 30, 20, 45, 40]
            }
        },

        exportReport() {
            this.exporting = true;
            setTimeout(() => { this.exporting = false; }, 1000);
        },

        // Hàm xử lý khi người dùng tương tác trực tiếp với ô nhập ngày
        handleDateChange() {
            this.timeRange = 'custom'; // Tự động chuyển select box về 'Tùy chọn ngày'
            this.renderChartRefresh(); // Vẽ lại biểu đồ theo data khoảng ngày
        },

        renderChartRefresh() {
            this.chartLoaded = false;
            if (this.chartInstance) {
                this.chartInstance.destroy();
            }

            setTimeout(() => {
                this.chartLoaded = true;
                this.$nextTick(() => {
                    const ctx = document.getElementById('mainChart').getContext('2d');
                    let gradient = ctx.createLinearGradient(0, 0, 0, 250);
                    gradient.addColorStop(0, 'rgba(193, 18, 31, 0.12)'); 
                    gradient.addColorStop(1, 'rgba(193, 18, 31, 0)');

                    const activeSource = this.timeRange === 'custom' ? this.mockData.custom : this.mockData[this.timeRange];

                    this.chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: activeSource.labels,
                            datasets: [{
                                data: activeSource.data,
                                borderColor: '#C1121F',
                                backgroundColor: gradient,
                                borderWidth: 2,
                                fill: true,
                                tension: 0.35, 
                                pointRadius: 0,
                                pointHoverRadius: 4,
                                pointBackgroundColor: '#C1121F'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { 
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(30, 41, 59, 0.95)', 
                                    titleColor: '#94a3b8',
                                    titleFont: { family: 'Inter', size: 10, weight: 'normal' },
                                    bodyColor: '#ffffff',
                                    bodyFont: { family: 'Inter', size: 12, weight: 'normal' }, 
                                    padding: { font: 8, top: 6, bottom: 6, left: 10, right: 10 }, 
                                    cornerRadius: 6,
                                    displayColors: false,
                                    callbacks: {
                                        title: context => 'Ngày: ' + context[0].label,
                                        label: context => 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.raw * 1000000) + ' đ'
                                    }
                                }
                            },
                            scales: {
                                x: { grid: { display: false }, ticks: { font: { family: 'Nunito', size: 11, weight: 'bold' }, color: '#94a3b8' } },
                                y: { 
                                    beginAtZero: true,
                                    grid: { borderDash: [4, 4], color: '#f1f5f9' }, 
                                    ticks: { 
                                        callback: v => v >= 1000 ? (v / 1000) + ' Tỷ' : v + 'M', 
                                        font: { family: 'Nunito', size: 11, weight: 'bold' }, 
                                        color: '#94a3b8',
                                        stepSize: this.timeRange === 'year' ? 1000 : 10
                                    } 
                                }
                            },
                            interaction: { mode: 'index', intersect: false }
                        }
                    });
                });
            }, 300);
        }
    }" x-init="renderChartRefresh()">

        <div class="flex items-center justify-between shrink-0">
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Tổng Quan</h1>
            
            <button @click="exportReport()" class="flex items-center gap-1.5 bg-[#C1121F] text-white font-bold text-[12px] px-4 py-2 rounded-full hover:bg-[#9D0208] transition-colors shadow-sm active:scale-95" :disabled="exporting">
                <svg x-show="!exporting" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <svg x-show="exporting" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span>Xuất Báo Cáo</span>
            </button>
        </div>

        <div class="grid grid-cols-4 gap-4 shrink-0">
            <div class="bg-white rounded-[16px] p-4 shadow-sm border border-slate-100 flex flex-col gap-2">
                <div class="flex justify-between items-center text-slate-500">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Doanh Thu Thuần</span>
                    <div class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                </div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">145.8M đ</div>
                <div class="flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50/50 w-fit px-2 py-0.5 rounded-full mt-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span>+12.5% vs tháng trước</span>
                </div>
            </div>

            <div class="bg-white rounded-[16px] p-4 shadow-sm border border-slate-100 flex flex-col gap-2">
                <div class="flex justify-between items-center text-slate-500">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Đơn Hàng Mới</span>
                    <div class="w-7 h-7 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></div>
                </div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">342</div>
                <div class="flex items-center gap-1 text-[10px] font-bold text-blue-600 bg-blue-50/50 w-fit px-2 py-0.5 rounded-full mt-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span>+8.2% tuần này</span>
                </div>
            </div>

            <div class="bg-white rounded-[16px] p-4 shadow-sm border border-slate-100 flex flex-col gap-2">
                <div class="flex justify-between items-center text-slate-500">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Khách Hàng</span>
                    <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                </div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">1,245</div>
                <div class="flex items-center gap-1 text-[10px] font-bold text-slate-500 mt-1">
                    <span>Tài khoản đã đăng ký</span>
                </div>
            </div>

            <div class="bg-white rounded-[16px] p-4 shadow-sm border border-red-100 flex flex-col gap-2">
                <div class="flex justify-between items-center text-slate-500">
                    <span class="text-[11px] font-bold uppercase tracking-wider">Cảnh Báo Kho</span>
                    <div class="w-7 h-7 rounded-full bg-red-50 text-[#C1121F] flex items-center justify-center"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                </div>
                <div class="text-2xl font-black text-[#C1121F] tracking-tight">14</div>
                <a href="/admin/products?stock=low" class="flex items-center gap-1 text-[10px] font-bold text-[#C1121F] hover:underline w-fit mt-1">
                    Xem sản phẩm sắp hết <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <div class="flex-1 min-h-0 flex gap-4">
            
            <div class="flex-[3] bg-white rounded-[16px] shadow-sm border border-slate-100 flex flex-col p-4 relative">
                <div class="flex justify-between items-center mb-2 shrink-0 relative z-10">
                    <h2 class="text-[15px] font-black text-slate-900">Biểu Đồ Doanh Thu</h2>
                    
                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 p-1.5 rounded-full shadow-sm">
                        <select x-model="timeRange" @change="renderChartRefresh()" class="text-[11px] font-bold bg-white border border-slate-200 rounded-full px-3 py-1 outline-none text-slate-700 cursor-pointer focus:border-[#C1121F]/40 transition-colors">
                            <option value="week">Tuần này</option>
                            <option value="month">Tháng này</option>
                            <option value="year">Năm nay</option>
                            <option value="custom">Tùy chọn ngày</option>
                        </select>
                        
                        <div class="w-px h-4 bg-slate-200 mx-0.5"></div>

                        <div class="flex items-center gap-1.5">
                            <input type="date" x-model="startDate" @change="handleDateChange()" class="text-[11px] font-bold text-slate-700 bg-white border border-slate-200 rounded-full px-2.5 py-1 outline-none focus:border-[#C1121F]/40">
                            <span class="text-[10px] text-slate-400 font-bold">đến</span>
                            <input type="date" x-model="endDate" @change="handleDateChange()" class="text-[11px] font-bold text-slate-700 bg-white border border-slate-200 rounded-full px-2.5 py-1 outline-none focus:border-[#C1121F]/40">
                        </div>
                    </div>
                </div>
                
                <div class="w-full h-full flex-1 relative mt-2">
                    <canvas x-show="chartLoaded" id="mainChart" class="absolute inset-0"></canvas>
                    <div x-show="!chartLoaded" class="absolute inset-0 flex items-center justify-center text-[11px] font-bold text-slate-400 bg-slate-50/50 rounded-xl border border-dashed border-slate-100 animate-pulse">Đang nạp dữ liệu vùng chọn...</div>
                </div>
            </div>

            <div class="flex-[2] bg-white rounded-[16px] shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                <div class="p-4 pb-2 border-b border-slate-50 flex justify-between items-center shrink-0">
                    <h2 class="text-[15px] font-black text-slate-900">Đơn Chờ Xử Lý</h2>
                    <a href="/admin/orders" class="text-[10px] font-bold text-[#C1121F] bg-red-50 px-2.5 py-1 rounded-full hover:bg-red-100">Xem Tất Cả</a>
                </div>
                
                <div class="flex-1 overflow-y-auto hide-scroll p-2">
                    <div class="flex flex-col gap-1">
                        <template x-for="i in 6">
                            <div class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 border border-transparent transition-all cursor-pointer">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-black text-[10px] flex items-center justify-center shrink-0" x-text="i % 2 === 0 ? 'KN' : 'RC'"></div>
                                    <div>
                                        <div class="font-black text-[12px] text-slate-900" x-text="'#RC-998' + i"></div>
                                        <div class="text-[10px] font-bold text-slate-400" x-text="i * 2 + ' phút trước'"></div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-black text-[12px] text-[#C1121F]" x-text="i % 2 === 0 ? '459.000đ' : '899.000đ'"></div>
                                    <span class="inline-block px-1.5 py-0.5 mt-0.5 rounded-full text-[9px] font-bold bg-[#FFB703] text-slate-900">Chờ duyệt</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layout>