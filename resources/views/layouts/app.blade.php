<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Wonder Shope | Premium Electronics')</title>
    
    <!-- Tailwind & Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- FontAwesome fallback if needed -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-card:hover {
            border-color: rgba(172, 199, 255, 0.3);
            box-shadow: 0 0 40px rgba(172, 199, 255, 0.1);
        }
        .hero-glow {
            background: radial-gradient(circle at 50% 50%, rgba(80, 143, 248, 0.15) 0%, transparent 70%);
        }
        body {
            background-color: #101415;
            color: #e0e3e5;
            overflow-x: hidden;
        }
    </style>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-highest": "#323537",
                    "surface-container-high": "#272a2c",
                    "on-primary-container": "#00285b",
                    "secondary-fixed": "#63f7ff",
                    "inverse-primary": "#005bbf",
                    "on-error": "#690005",
                    "surface-tint": "#acc7ff",
                    "outline": "#8c909e",
                    "on-background": "#e0e3e5",
                    "surface-container-lowest": "#0b0f10",
                    "tertiary-container": "#8c90a4",
                    "on-secondary-container": "#006c71",
                    "on-tertiary-fixed-variant": "#414658",
                    "tertiary": "#c2c6db",
                    "surface": "#101415",
                    "surface-bright": "#363a3b",
                    "secondary-container": "#00f4fe",
                    "tertiary-fixed": "#dee1f7",
                    "on-error-container": "#ffdad6",
                    "outline-variant": "#424753",
                    "on-secondary-fixed": "#002021",
                    "background": "#101415",
                    "surface-dim": "#101415",
                    "on-primary": "#002f68",
                    "surface-container": "#1d2022",
                    "primary-fixed-dim": "#acc7ff",
                    "secondary-fixed-dim": "#00dce5",
                    "surface-variant": "#323537",
                    "on-tertiary-fixed": "#161b2b",
                    "on-surface-variant": "#c2c6d5",
                    "secondary": "#e6feff",
                    "on-surface": "#e0e3e5",
                    "inverse-on-surface": "#2d3133",
                    "on-primary-fixed": "#001a40",
                    "on-secondary": "#003739",
                    "error-container": "#93000a",
                    "on-primary-fixed-variant": "#004492",
                    "on-secondary-fixed-variant": "#004f53",
                    "primary": "#acc7ff",
                    "surface-container-low": "#191c1e",
                    "on-tertiary-container": "#242939",
                    "tertiary-fixed-dim": "#c2c6db",
                    "primary-container": "#508ff8",
                    "inverse-surface": "#e0e3e5",
                    "error": "#ffb4ab",
                    "on-tertiary": "#2b3040",
                    "primary-fixed": "#d7e2ff"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "base": "8px",
                    "container-max": "1440px",
                    "margin-mobile": "20px",
                    "gutter": "24px",
                    "margin-desktop": "80px"
            },
            "fontFamily": {
                    "body-lg": ["Inter"],
                    "display-xl": ["Outfit"],
                    "headline-lg-mobile": ["Outfit"],
                    "headline-md": ["Outfit"],
                    "label-md": ["Inter"],
                    "headline-lg": ["Outfit"],
                    "body-md": ["Inter"]
            }
          }
        }
      }
    </script>
</head>
<body class="font-body-md text-on-surface selection:bg-primary-container selection:text-on-primary-container flex flex-col min-h-screen">

    <!-- Top Navigation Bar -->
    <header class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-xl border-b border-white/10 shadow-[0_0_40px_rgba(172,199,255,0.15)] flex items-center justify-between px-8 md:px-margin-desktop py-4">
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="font-display-xl text-headline-md bg-gradient-to-r from-primary-container to-secondary-container bg-clip-text text-transparent hover:brightness-110 transition">Wonder Shope</a>
            <nav class="hidden md:flex items-center gap-6">
                <a class="font-label-md text-label-md {{ request()->routeIs('home') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant hover:text-on-surface' }} transition-all" href="{{ route('home') }}">Home</a>
                <a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" href="{{ route('home') }}">Catalog</a>
            </nav>
        </div>
        
        <div class="flex items-center gap-4">
            <!-- Search Form -->
            <form action="{{ route('home') }}" method="GET" class="hidden md:flex items-center bg-surface-container-highest/50 rounded-full px-4 py-2 border border-white/10 focus-within:border-primary/50 transition-all">
                <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
                <input name="search" value="{{ request('search') }}" class="bg-transparent border-none focus:ring-0 text-label-md text-on-surface placeholder:text-on-surface-variant/50 w-48 outline-none" placeholder="Search gadgets..." type="text"/>
            </form>
            
            <div class="flex items-center gap-2">
                @auth
                    @if(in_array(Auth::user()->role, ['admin', 'superadmin']))
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-full border border-primary/30 text-primary font-label-md text-xs hover:bg-primary/10 transition-all hidden sm:block">Admin</a>
                    @endif
                    <a href="{{ route('cart.index') }}" class="p-2 rounded-full hover:bg-white/5 transition-all duration-300 active:scale-95 text-primary relative">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        @if(count(session('cart', [])) > 0)
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border border-surface"></span>
                        @endif
                    </a>
                    <a href="{{ route('member.pesanan') }}" class="p-2 rounded-full hover:bg-white/5 transition-all duration-300 active:scale-95 text-primary relative" title="Pesanan Saya">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </a>
                    
                    <div class="relative group cursor-pointer p-2 rounded-full hover:bg-white/5 transition-all duration-300 text-primary flex items-center justify-center">
                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-primary-container to-secondary-container text-on-primary-container flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="absolute right-0 top-full mt-2 w-48 glass-card rounded-xl shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 font-label-md text-sm text-error hover:bg-white/5 transition flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">logout</span> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="font-label-md text-label-md text-on-surface hover:text-primary transition">Masuk</a>
                    <a href="{{ route('register') }}" class="ml-2 px-5 py-2 rounded-full bg-primary text-on-primary font-label-md text-sm font-bold hover:brightness-110 active:scale-95 transition-all">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl font-label-md flex items-center space-x-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl font-label-md flex items-center space-x-2">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer Component -->
    <footer class="bg-surface-container-lowest w-full mt-auto flex flex-col items-center gap-6 py-12 px-8 md:px-margin-desktop border-t border-outline-variant">
        <div class="w-full flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div class="flex flex-col gap-2">
                <span class="font-display-xl text-headline-md text-on-surface">Wonder Shope</span>
                <p class="text-on-surface-variant font-label-md text-label-md max-w-xs">Premium Electronics for the Modern Lifestyle. Cutting-edge technology at your fingertips.</p>
            </div>
            <div class="flex flex-wrap gap-x-8 gap-y-4">
                <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors opacity-80 hover:opacity-100" href="#">Privacy Policy</a>
                <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors opacity-80 hover:opacity-100" href="#">Terms of Service</a>
                <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors opacity-80 hover:opacity-100" href="#">Contact Us</a>
            </div>
        </div>
        <div class="w-full pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="font-body-md text-body-md text-on-surface-variant opacity-60">© 2026 Wonder Shope Premium Electronics. All rights reserved.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
