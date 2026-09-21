<x-storefront.layout>
    <div class="max-w-6xl mx-auto px-4 mt-4 sm:mt-6 pb-20" 
         x-data="{ 
            activeMenu: new URLSearchParams(window.location.search).get('tab') || 'profile', 
            orderTab: 'all',
            
            profileName: @json($user->name),
            profilePhone: @json($user->phone ?? ''),
            profileAddress: @json($user->address ?? ''),

            wishlist: @json($wishlist),
            orders: @json($orders),

            isCancelModalOpen: false,
            orderToCancel: null,
            
            isDetailModalOpen: false,
            selectedOrder: null,

            isSuccessModalOpen: false,
            successMessage: '',

            openCancelModal(id) {
                this.orderToCancel = id;
                this.isCancelModalOpen = true;
            },
            confirmCancel() {
                let order = this.orders.find(o => o.id === this.orderToCancel);
                if(order) {
                    fetch('/profile/order/cancel/' + order.db_id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            order.status = 'cancelled';
                            order.statusText = 'Đã hủy';
                            order.color = 'text-red-500 bg-red-50';
                            order.icon = 'M6 18L18 6M6 6l12 12';
                            
                            this.successMessage = data.message;
                            this.isSuccessModalOpen = true;
                            setTimeout(() => { this.isSuccessModalOpen = false; }, 2000);
                        } else {
                            alert(data.message || 'Không thể hủy đơn.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Lỗi kết nối máy chủ!');
                    });
                }
                this.isCancelModalOpen = false;
                this.orderToCancel = null;
            },
            openDetailModal(order) {
                this.selectedOrder = order;
                this.isDetailModalOpen = true;
            },
            saveProfile() {
                fetch('/profile/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: this.profileName,
                        phone: this.profilePhone,
                        address: this.profileAddress
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Alpine.store('auth').user.name = this.profileName;
                        Alpine.store('auth').user.phone = this.profilePhone;
                        Alpine.store('auth').user.address = this.profileAddress;
                        
                        this.successMessage = data.message;
                        this.isSuccessModalOpen = true;
                        setTimeout(() => { this.isSuccessModalOpen = false; }, 2000);
                    } else {
                        alert(data.message || 'Có lỗi xảy ra.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Lỗi kết nối máy chủ!');
                });
            }
         }">
        
        <nav class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-4">
            <a href="/" class="hover:text-[#C1121F] transition-colors">Trang Chủ</a>
            <span>/</span>
            <span class="text-[#C1121F]" x-text="activeMenu === 'orders' ? 'Đơn hàng của tôi' : (activeMenu === 'wishlist' ? 'Sản phẩm yêu thích' : 'Tài khoản của tôi')"></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
            
            <aside class="lg:col-span-3 flex flex-col gap-3 sticky top-24 self-start z-30">
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#C1121F] to-[#9D0208] text-white flex items-center justify-center font-black text-lg shadow-sm shrink-0" x-text="profileName ? profileName.charAt(0).toUpperCase() : 'U'">N</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tài khoản</p>
                        <h2 class="font-black text-sm text-slate-900 break-words leading-tight mt-0.5" x-text="profileName"></h2>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-2.5 shadow-sm border border-slate-100 flex flex-col gap-0.5">
                    <button @click="activeMenu = 'profile'; window.history.pushState({}, '', '/profile?tab=profile');" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-bold transition-all w-full text-left" :class="activeMenu === 'profile' ? 'bg-red-50 text-[#C1121F]' : 'text-slate-600 hover:bg-slate-50'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Tài khoản của tôi
                    </button>
                    
                    <button @click="activeMenu = 'orders'; window.history.pushState({}, '', '/profile?tab=orders');" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-[13px] font-bold transition-all w-full text-left" :class="activeMenu === 'orders' ? 'bg-red-50 text-[#C1121F]' : 'text-slate-600 hover:bg-slate-50'">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Đơn hàng của tôi
                        </div>
                    </button>

                    <button @click="activeMenu = 'wishlist'; window.history.pushState({}, '', '/profile?tab=wishlist');" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-[13px] font-bold transition-all w-full text-left" :class="activeMenu === 'wishlist' ? 'bg-red-50 text-[#C1121F]' : 'text-slate-600 hover:bg-slate-50'">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            Sản phẩm yêu thích
                        </div>
                        <span class="text-[10px] font-black text-slate-400" x-text="wishlist.length"></span>
                    </button>

                    <div class="h-px bg-slate-100 my-1 mx-2"></div>

                    <button @click="if(confirm('Bạn có chắc chắn muốn đăng xuất?')) { Alpine.store('auth').logout(); }" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-bold text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all w-full text-left">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Đăng xuất
                    </button>
                </div>
            </aside>

            <div class="lg:col-span-9 flex flex-col gap-4">
                
                <div x-show="activeMenu === 'profile'" style="display: none;" x-transition.opacity.duration.300ms class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
                    <h1 class="text-lg font-black text-slate-900 tracking-tight mb-4 border-b border-slate-100 pb-3">Hồ sơ cá nhân</h1>
                    
                    <form class="grid grid-cols-2 gap-3 sm:gap-4 max-w-2xl">
                        <div class="col-span-2 sm:col-span-1 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" x-model="profileName" class="w-full h-10 bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 rounded-lg px-3 outline-none focus:border-[#C1121F]">
                        </div>
                        <div class="col-span-2 sm:col-span-1 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="tel" x-model="profilePhone" class="w-full h-10 bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 rounded-lg px-3 outline-none focus:border-[#C1121F]">
                        </div>
                        <div class="col-span-2 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Email liên hệ</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full h-10 bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-500 rounded-lg px-3 outline-none cursor-not-allowed">
                        </div>

                        <div class="col-span-2 space-y-1">
                            <label class="text-[11px] font-bold text-slate-700 ml-1">Địa chỉ cụ thể <span class="text-red-500">*</span></label>
                            <input type="text" x-model="profileAddress" class="w-full h-10 bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-800 rounded-lg px-3 outline-none focus:border-[#C1121F]">
                        </div>
                        
                        <div class="col-span-2 pt-2">
                            <button type="button" @click="saveProfile()" class="bg-slate-900 text-white font-black text-xs px-8 py-3 rounded-xl hover:bg-black transition-colors shadow-sm">Lưu Thay Đổi</button>
                        </div>
                    </form>
                </div>

                <div x-show="activeMenu === 'orders'" style="display: none;" x-transition.opacity.duration.300ms>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-1 flex overflow-x-auto hide-scroll mb-4">
                        <button @click="orderTab = 'all'" class="flex-1 min-w-[80px] text-center text-[11px] font-bold py-2 rounded-lg transition-colors" :class="orderTab === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'">Tất cả</button>
                        <button @click="orderTab = 'processing'" class="flex-1 min-w-[90px] text-center text-[11px] font-bold py-2 rounded-lg transition-colors" :class="orderTab === 'processing' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'">Chờ xác nhận</button>
                        <button @click="orderTab = 'shipping'" class="flex-1 min-w-[80px] text-center text-[11px] font-bold py-2 rounded-lg transition-colors" :class="orderTab === 'shipping' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'">Đang giao</button>
                        <button @click="orderTab = 'completed'" class="flex-1 min-w-[80px] text-center text-[11px] font-bold py-2 rounded-lg transition-colors" :class="orderTab === 'completed' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'">Hoàn thành</button>
                        <button @click="orderTab = 'cancelled'" class="flex-1 min-w-[80px] text-center text-[11px] font-bold py-2 rounded-lg transition-colors" :class="orderTab === 'cancelled' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'">Đã hủy</button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="order in orders" :key="order.id">
                            <div x-show="orderTab === 'all' || orderTab === order.status" x-transition.opacity class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                                
                                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5 mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-black text-slate-800" x-text="order.id"></span>
                                        <span class="text-[9px] font-bold text-slate-400" x-text="'| ' + order.date"></span>
                                    </div>
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider flex items-center gap-1" :class="order.color">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" :d="order.icon"></path></svg>
                                        <span x-text="order.statusText"></span>
                                    </span>
                                </div>

                                <div class="flex gap-3 items-center">
                                    <div class="w-14 h-14 rounded-lg bg-slate-50 overflow-hidden shrink-0 border border-slate-100">
                                        <img :src="order.img" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-[13px] text-slate-800 line-clamp-1" x-text="order.name"></h3>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Phân loại: <span x-text="order.variant"></span> | Số lượng: <span x-text="order.qty"></span></p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="font-black text-xs text-[#C1121F]" x-text="order.price"></span>
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Thành tiền:</span>
                                        <span class="text-base font-black text-[#C1121F]" x-text="order.total"></span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <template x-if="order.status === 'processing'">
                                            <button @click="openCancelModal(order.id)" class="flex-1 sm:flex-none px-4 py-2 rounded-lg border border-slate-200 text-slate-600 font-bold text-[10px] hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors uppercase tracking-wider text-center">Hủy đơn</button>
                                        </template>

                                        <template x-if="order.status === 'completed' || order.status === 'cancelled'">
                                            <button @click="window.location.href='/products/detail'" class="flex-1 sm:flex-none px-4 py-2 rounded-lg border border-slate-200 text-slate-600 font-bold text-[10px] hover:bg-slate-50 hover:text-slate-900 transition-colors uppercase tracking-wider text-center">Mua lại</button>
                                        </template>

                                        <button @click="openDetailModal(order)" class="flex-1 sm:flex-none px-4 py-2 rounded-lg bg-[#C1121F] text-white font-bold text-[10px] hover:bg-red-800 shadow-sm transition-colors uppercase tracking-wider text-center">Xem chi tiết</button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div x-show="activeMenu === 'wishlist'" style="display: none;" x-transition.opacity.duration.300ms>
                    <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                        <h1 class="text-lg font-black text-slate-900 tracking-tight">Sản phẩm yêu thích (<span class="text-[#C1121F]" x-text="wishlist.length"></span>)</h1>
                    </div>
                    
                    <div x-show="wishlist.length === 0" style="display: none;" class="text-center py-12 text-slate-400 font-bold text-sm bg-white rounded-2xl border border-slate-100">
                        Chưa có sản phẩm nào trong danh sách.
                    </div>

                    <div x-show="wishlist.length > 0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                        <template x-for="item in wishlist" :key="item.id">
                            <div class="bg-white rounded-xl p-2 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col relative group cursor-pointer" @click="window.location.href='/products/detail'">
                                
                                <button @click.stop="
                                    fetch('/profile/wishlist/toggle/' + item.id, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            wishlist = wishlist.filter(w => w.id !== item.id);
                                        }
                                    });
                                " class="absolute top-2 right-2 w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-md z-10 text-[#C1121F] hover:scale-110 transition-transform">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
                                </button>
                                
                                <div class="relative overflow-hidden rounded-lg bg-slate-50 aspect-[4/5] mb-2 shrink-0">
                                    <img :src="item.img" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-x-0 bottom-0 p-1.5 flex gap-1 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out bg-gradient-to-t from-black/60 to-transparent pt-8">
                                        <button @click.stop="alert('Đã thêm vào giỏ!')" class="w-7 h-7 bg-white text-slate-900 rounded-md hover:bg-slate-100 flex justify-center items-center shrink-0 shadow-sm"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></button>
                                        <button @click.stop="window.location.href='/checkout'" class="flex-1 bg-[#C1121F] text-white font-black text-[9px] py-1 rounded-md hover:bg-red-800 shadow-sm uppercase tracking-wide">Mua</button>
                                    </div>
                                </div>
                                <div class="px-0.5 flex flex-col flex-grow justify-end">
                                    <h3 class="font-bold text-slate-800 text-[11px] line-clamp-1 mb-1 group-hover:text-[#C1121F] transition-colors" x-text="item.name"></h3>
                                    <p class="text-[#C1121F] font-black text-sm" x-text="item.price"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

        <div x-show="isCancelModalOpen" style="display: none;" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
            <div x-show="isCancelModalOpen" x-transition.opacity @click="isCancelModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm cursor-pointer"></div>
            <div x-show="isCancelModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 overflow-hidden z-10 flex flex-col text-center">
                 <div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </div>
                 <h3 class="text-lg font-black text-slate-900 mb-2">Xác nhận hủy đơn hàng</h3>
                 <p class="text-xs font-semibold text-slate-500 mb-6">Bạn có chắc chắn muốn hủy đơn hàng <span class="font-bold text-slate-800" x-text="orderToCancel"></span> không? Quá trình này không thể hoàn tác.</p>
                 <div class="flex gap-3">
                     <button @click="isCancelModalOpen = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50 transition-colors">Đóng</button>
                     <button @click="confirmCancel()" class="flex-1 py-2.5 rounded-xl bg-[#C1121F] text-white font-bold text-xs hover:bg-red-800 shadow-sm transition-colors">Xác nhận hủy</button>
                 </div>
            </div>
        </div>

        <div x-show="isSuccessModalOpen" style="display: none;" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
            <div x-show="isSuccessModalOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm pointer-events-none"></div>
            <div x-show="isSuccessModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xs p-6 overflow-hidden z-10 flex flex-col items-center text-center border border-emerald-100">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mb-3 shadow-inner">
                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-sm font-black text-slate-900" x-text="successMessage"></h3>
            </div>
        </div>

        <div x-show="isDetailModalOpen" style="display: none;" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
            <div x-show="isDetailModalOpen" x-transition.opacity @click="isDetailModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm cursor-pointer"></div>
            <div x-show="isDetailModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg p-5 sm:p-6 overflow-hidden z-10 flex flex-col text-left">
                
                <button @click="isDetailModalOpen = false" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-red-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-lg font-black text-slate-900 mb-4 border-b border-slate-100 pb-3">Chi tiết đơn hàng</h3>
                
                <template x-if="selectedOrder">
                   <div class="space-y-4">
                      
                      <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                          <div>
                              <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Mã đơn hàng</p>
                              <p class="text-sm font-black text-slate-800" x-text="selectedOrder.id"></p>
                          </div>
                          <div class="text-right flex flex-col items-end gap-1">
                              <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider flex items-center gap-1" :class="selectedOrder.color">
                                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" :d="selectedOrder.icon"></path></svg>
                                  <span x-text="selectedOrder.statusText"></span>
                              </span>
                          </div>
                      </div>

                      <div>
                          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Địa chỉ nhận hàng</p>
                          <div class="border border-slate-100 rounded-xl p-3">
                              <p class="font-black text-xs text-slate-800 mb-0.5">Bùi Thị Kiều Ngân| 0901234567</p>
                              <p class="text-[11px] font-semibold text-slate-500 leading-tight">123 Nguyễn Văn Linh, Phường 1, Quận Tân Bình, Hồ Chí Minh</p>
                          </div>
                      </div>

                      <div>
                          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Phương thức thanh toán</p>
                          <div class="border border-slate-100 rounded-xl p-3 flex items-center justify-between">
                              <p class="font-bold text-xs text-slate-800" x-text="selectedOrder.payment"></p>
                              <span class="text-[9px] font-black px-2 py-1 rounded tracking-wide uppercase"
                                    :class="selectedOrder.isPaid ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500'"
                                    x-text="selectedOrder.isPaid ? 'Đã thanh toán' : 'Chưa thanh toán'">
                              </span>
                          </div>
                      </div>

                      <div>
                          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Sản phẩm</p>
                          <div class="flex gap-3 items-center border border-slate-100 p-3 rounded-xl">
                               <img :src="selectedOrder.img" class="w-14 h-14 rounded-lg object-cover">
                               <div class="flex-1 min-w-0">
                                   <h3 class="font-bold text-[13px] text-slate-800 line-clamp-1" x-text="selectedOrder.name"></h3>
                                   <p class="text-[10px] text-slate-500 mt-0.5">Phân loại: <span x-text="selectedOrder.variant"></span> | Số lượng: <span class="font-bold text-slate-800" x-text="selectedOrder.qty"></span></p>
                               </div>
                               <div class="text-right shrink-0">
                                   <span class="font-black text-xs text-[#C1121F]" x-text="selectedOrder.price"></span>
                               </div>
                          </div>
                      </div>

                      <div class="border-t border-slate-100 pt-3 flex flex-col gap-1.5">
                           <div class="flex justify-between items-center text-[11px] font-bold text-slate-500">
                               <span>Tạm tính</span><span x-text="selectedOrder.total"></span>
                           </div>
                           <div class="flex justify-between items-center text-[11px] font-bold text-slate-500">
                               <span>Phí vận chuyển</span><span class="text-emerald-500">Miễn phí</span>
                           </div>
                           <div class="flex justify-between items-center mt-1">
                               <span class="text-xs font-black text-slate-700">Tổng thanh toán:</span>
                               <span class="text-xl font-black text-[#C1121F]" x-text="selectedOrder.total"></span>
                           </div>
                      </div>
                   </div>
                </template>
            </div>
        </div>

    </div>
</x-storefront.layout>