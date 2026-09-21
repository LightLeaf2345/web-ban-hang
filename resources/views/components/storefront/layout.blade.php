<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RedCherry Fashion | Local Brand Thế Hệ Mới</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    document.addEventListener('alpine:init', () => {
        
        // 1. Quản lý trạng thái Đăng nhập kết hợp với Laravel Session
        Alpine.store('auth', {
            isLoggedIn: @json(Auth::check()),
            user: { 
                name: @json(Auth::check() ? Auth::user()->name : ''),
                email: @json(Auth::check() ? Auth::user()->email : ''),
                id: @json(Auth::check() ? Auth::user()->id : null),
                phone: @json(Auth::check() ? Auth::user()->phone : ''),
                address: @json(Auth::check() ? Auth::user()->address : '')
            },
            logout() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/logout';
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        });

        // 2. Quản lý Giỏ hàng
        Alpine.store('cart', {
            count: 2,
            add() {
                this.count++;
                let cartIcon = document.getElementById('header-cart-icon');
                if(cartIcon) {
                    cartIcon.classList.add('scale-125', 'text-[#C1121F]');
                    setTimeout(() => cartIcon.classList.remove('scale-125', 'text-[#C1121F]'), 300);
                }
            }
        });
    });

    // Hàm tạo hiệu ứng "Hình tròn vàng bay vào giỏ hàng"
    window.flyToCart = function(event) {
        // RÀNG BUỘC: Kiểm tra đăng nhập trước khi cho phép thêm giỏ hàng
        if (!Alpine.store('auth').isLoggedIn) {
            alert('Vui lòng đăng nhập hoặc tạo tài khoản để mua sắm!');
            window.location.href = '/login';
            return;
        }

        const button = event.currentTarget;
        const cartIcon = document.getElementById('header-cart-icon');

        if (!cartIcon) {
            Alpine.store('cart').add(); 
            return; 
        }

        const btnRect = button.getBoundingClientRect();
        const cartRect = cartIcon.getBoundingClientRect();

        const flyingIcon = document.createElement('div');
        flyingIcon.innerHTML = `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>`;

        flyingIcon.style.position = 'fixed';
        flyingIcon.style.top = (btnRect.top + btnRect.height / 2 - 20) + 'px'; 
        flyingIcon.style.left = (btnRect.left + btnRect.width / 2 - 20) + 'px';
        flyingIcon.style.width = '40px';
        flyingIcon.style.height = '40px';
        flyingIcon.style.backgroundColor = '#FFB703'; 
        flyingIcon.style.borderRadius = '50%';
        flyingIcon.style.display = 'flex';
        flyingIcon.style.alignItems = 'center';
        flyingIcon.style.justifyContent = 'center';
        flyingIcon.style.zIndex = '99999';
        flyingIcon.style.transition = 'all 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
        flyingIcon.style.pointerEvents = 'none';
        flyingIcon.style.boxShadow = '0 10px 15px -3px rgba(0,0,0,0.2)';

        document.body.appendChild(flyingIcon);

        setTimeout(() => {
            flyingIcon.style.top = cartRect.top + 'px';
            flyingIcon.style.left = cartRect.left + 'px';
            flyingIcon.style.width = '24px';
            flyingIcon.style.height = '24px';
            flyingIcon.style.opacity = '0'; 
            
            const svg = flyingIcon.querySelector('svg');
            if(svg) {
                svg.style.transform = 'scale(0.5)';
                svg.style.transition = 'all 0.6s ease';
            }
        }, 10);

        setTimeout(() => {
            flyingIcon.remove();
            Alpine.store('cart').add();
        }, 600); 
    }
</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen relative">

    <x-storefront.header />

    <main class="flex-grow pt-18 pb-20">
        {{ $slot }}
    </main>

    <x-storefront.footer />

    <x-storefront.chatbot />

</body>
</html>