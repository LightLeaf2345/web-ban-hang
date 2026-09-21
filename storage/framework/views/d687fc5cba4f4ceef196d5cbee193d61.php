<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatbotAI', () => ({
            openChat: false,
            suggestionVisible: false,
            allSuggestions: [
                'Chào bạn! Tôi có thể giúp gì cho bạn? ✨', 
                'Bạn cần tìm trang phục gì nhỉ? 🍒', 
                'Có món đồ nào bạn đang phân vân không?'
            ],
            currentSuggIndex: 0,
            displayText: '',
            typewriterInterval: null,

            initChat() {
                // Hiển thị bóng thoại sau 3 giây
                setTimeout(() => {
                    if(!this.openChat) {
                        this.suggestionVisible = true;
                        this.startTypewriter();
                    }
                }, 3000); 
            },

            startTypewriter() {
                let fullText = this.allSuggestions[this.currentSuggIndex];
                let i = 0;
                clearInterval(this.typewriterInterval);
                
                this.typewriterInterval = setInterval(() => {
                    this.displayText = fullText.substring(0, i);
                    i++;
                    if (i > fullText.length) {
                        clearInterval(this.typewriterInterval);
                        // Chờ 3 giây rồi đổi sang câu gợi ý tiếp theo
                        setTimeout(() => {
                            if(!this.openChat) {
                                this.currentSuggIndex = (this.currentSuggIndex + 1) % this.allSuggestions.length;
                                this.startTypewriter();
                            }
                        }, 3000);
                    }
                }, 50); // Tốc độ gõ 50ms/chữ
            }
        }));
    });
</script>

<div x-data="chatbotAI" x-init="initChat()" class="fixed bottom-6 right-6 z-[100] flex flex-col items-end gap-2">
    
    <div 
        x-show="openChat" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 scale-95"
        class="bg-white w-[320px] sm:w-[360px] h-[500px] max-h-[85vh] rounded-[2rem] shadow-2xl shadow-slate-300/50 border border-slate-100 flex flex-col overflow-hidden origin-bottom-right"
        style="display: none;"
    >
        <div class="bg-gradient-to-r from-[#C1121F] to-[#9D0208] p-4 flex items-center justify-between text-white shadow-sm z-10">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M15 12h.01M19 8H5a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2v-6a2 2 0 00-2-2zM12 4v4m-4-4h8"></path></svg>
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-[#9D0208] rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-black text-[15px] tracking-wide">RedCherry AI</h3>
                    <p class="text-[11px] font-medium opacity-80">Trợ lý thời trang số</p>
                </div>
            </div>
            <button @click="openChat = false" class="text-white/80 hover:text-white hover:rotate-90 transition-all p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 bg-slate-50 p-4 overflow-y-auto flex flex-col gap-4 hide-scroll">
            
            <div class="flex gap-2 justify-start">
                <div class="w-8 h-8 rounded-full bg-[#C1121F] flex items-center justify-center text-white shrink-0 shadow-sm mt-auto">
                    <span class="text-[10px] font-black">AI</span>
                </div>
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-sm text-slate-700 max-w-[85%] leading-relaxed">
                    Chào bạn! Mình là trợ lý AI của RedCherry. Bạn đang tìm món đồ nào không? ✨
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <div class="bg-slate-900 p-3 rounded-2xl rounded-tr-none shadow-sm text-sm text-white max-w-[85%] leading-relaxed">
                    Cho mình xem mẫu áo jacket ngầu ngầu để đi chơi cuối tuần.
                </div>
            </div>

            <div class="flex gap-2 justify-start">
                <div class="w-8 h-8 rounded-full bg-[#C1121F] flex items-center justify-center text-white shrink-0 shadow-sm">
                    <span class="text-[10px] font-black">AI</span>
                </div>
                <div class="flex flex-col gap-2 max-w-[85%]">
                    
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-sm text-slate-700 leading-relaxed">
                        Chắc chắn rồi! Mẫu Jacket Leather đen này cực kỳ hợp với phong cách đường phố cuối tuần. Bạn xem thử nhé:
                    </div>
                    
                    <a href="/products/ao-jacket-leather-den" class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 hover:border-[#C1121F] hover:shadow-md transition-all group flex gap-3 items-center decoration-transparent">
                        <div class="w-14 h-14 rounded-xl bg-slate-100 overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=200" alt="Jacket" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-[13px] text-slate-800 line-clamp-1 group-hover:text-[#C1121F] transition-colors">Áo Jacket Leather Đen</h4>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[#C1121F] font-black text-[13px]">899.000đ</span>
                            </div>
                        </div>
                        <div class="w-7 h-7 rounded-full bg-red-50 text-[#C1121F] flex items-center justify-center shrink-0 mr-1.5 group-hover:bg-[#C1121F] group-hover:text-white transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="p-3 bg-white border-t border-slate-100 flex gap-2 items-end z-10">
            <textarea rows="1" placeholder="Nhập câu hỏi của bạn..." class="w-full bg-slate-100 text-sm text-slate-800 rounded-2xl px-4 py-3 outline-none focus:ring-1 focus:ring-[#C1121F] resize-none overflow-hidden max-h-[100px]"></textarea>
            <button class="w-11 h-11 shrink-0 bg-[#C1121F] text-white rounded-full flex items-center justify-center hover:bg-red-800 transition-colors shadow-sm">
                <svg class="w-5 h-5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </div>
    </div>

    <div class="relative flex items-center gap-3">
        
        <div 
            x-show="suggestionVisible && !openChat"
            x-transition:enter="transition ease-out duration-500 delay-100"
            x-transition:enter-start="opacity-0 translate-x-4 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="relative mb-0 hidden sm:block cursor-pointer group/msg z-20" 
            @click="openChat = true; suggestionVisible = false"
        >
            <div class="bg-white text-slate-800 text-[13px] font-bold px-4 py-3 rounded-2xl rounded-br-sm shadow-lg border border-slate-100 z-10 min-w-[50px] group-hover/msg:border-[#C1121F] group-hover/msg:text-[#C1121F] transition-colors">
                <span x-text="displayText" class="whitespace-nowrap"></span>
                <span class="inline-block w-[1.5px] h-3.5 bg-[#C1121F] animate-pulse ml-0.5" x-show="displayText.length < allSuggestions[currentSuggIndex].length"></span>
            </div>
            <div class="absolute -right-1 bottom-1 w-2.5 h-2.5 bg-white rotate-45 border-r border-b border-slate-100 group-hover/msg:border-[#C1121F] transition-colors"></div>
        </div>

        <div class="relative group cursor-pointer" @click="openChat = !openChat; suggestionVisible = false; clearInterval(typewriterInterval)">
            <div x-show="!openChat" class="absolute inset-0 rounded-full bg-red-500 animate-ping opacity-60 group-hover:animate-none group-hover:scale-110 transition-all duration-300"></div>
            <div x-show="!openChat" class="absolute -inset-2 rounded-full border border-red-500/30 group-hover:border-transparent transition-colors"></div>

            <button class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-tr from-[#C1121F] to-[#9D0208] text-white flex flex-col items-center justify-center shadow-xl shadow-red-500/30 transition-all duration-300 z-50 group-hover:shadow-red-500/50">
                <div x-show="!openChat" class="flex flex-col items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M15 12h.01M19 8H5a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2v-6a2 2 0 00-2-2zM12 4v4m-4-4h8"></path>
                    </svg>
                    <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-widest mt-0.5">RC AI</span>
                </div>
                <svg x-show="openChat" style="display: none;" class="w-8 h-8 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

</div><?php /**PATH C:\Users\ASUS\Downloads\projectphp\HopTacXaPHP_CuaHangQuanAoOnline-main\resources\views/components/storefront/chatbot.blade.php ENDPATH**/ ?>