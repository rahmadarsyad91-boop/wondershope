<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Admin Dashboard - Wonder Shope')</title>
    
    <!-- Tailwind & Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- FontAwesome fallback -->
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
        body {
            background-color: #101415;
            color: #e0e3e5;
            overflow-x: hidden;
        }
        /* Admin Sidebar Scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(172, 199, 255, 0.2); border-radius: 10px; }
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
<body class="font-body-md text-on-surface bg-surface selection:bg-primary-container selection:text-on-primary-container min-h-screen flex">

    <!-- SIDEBAR (Glassmorphism Cyber-Premium) -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-surface-container-low/80 backdrop-blur-xl border-r border-white/10 flex flex-col z-40 transition-transform duration-300 transform -translate-x-full md:translate-x-0" id="sidebar">
        <!-- Logo -->
        <div class="h-20 flex items-center justify-center border-b border-white/10 px-6">
            <a href="{{ route('home') }}" class="font-display-xl text-xl bg-gradient-to-r from-primary to-secondary-fixed-dim bg-clip-text text-transparent hover:brightness-110 transition w-full text-center truncate">Wonder Shope<span class="block text-[10px] text-on-surface-variant tracking-widest mt-1">ADMIN PANEL</span></a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto sidebar-scroll py-6 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 text-primary border border-primary/30 shadow-[0_0_15px_rgba(172,199,255,0.15)]' : 'text-on-surface-variant hover:text-on-surface hover:bg-white/5 border border-transparent' }}">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span>Dashboard</span>
            </a>

            @if(in_array(Auth::user()->role, ['admin', 'superadmin']))
            <p class="px-4 pt-4 pb-2 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Katalog</p>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-sm transition-all {{ request()->routeIs('admin.products.index') || request()->routeIs('products.*') ? 'bg-primary/20 text-primary border border-primary/30 shadow-[0_0_15px_rgba(172,199,255,0.15)]' : 'text-on-surface-variant hover:text-on-surface hover:bg-white/5 border border-transparent' }}">
                <span class="material-symbols-outlined text-xl">inventory_2</span>
                <span>Kelola Produk</span>
            </a>

            <p class="px-4 pt-4 pb-2 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Transaksi</p>
            <a href="{{ route('admin.pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-sm transition-all {{ request()->routeIs('admin.pesanan.*') ? 'bg-primary/20 text-primary border border-primary/30 shadow-[0_0_15px_rgba(172,199,255,0.15)]' : 'text-on-surface-variant hover:text-on-surface hover:bg-white/5 border border-transparent' }}">
                <span class="material-symbols-outlined text-xl">list_alt</span>
                <span>Pesanan Masuk</span>
            </a>
            <a href="{{ route('admin.terjual.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-sm transition-all {{ request()->routeIs('admin.terjual.*') ? 'bg-primary/20 text-primary border border-primary/30 shadow-[0_0_15px_rgba(172,199,255,0.15)]' : 'text-on-surface-variant hover:text-on-surface hover:bg-white/5 border border-transparent' }}">
                <span class="material-symbols-outlined text-xl">price_check</span>
                <span>Barang Terjual</span>
            </a>
            <a href="{{ route('admin.retur.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-sm transition-all {{ request()->routeIs('admin.retur.*') ? 'bg-primary/20 text-primary border border-primary/30 shadow-[0_0_15px_rgba(172,199,255,0.15)]' : 'text-on-surface-variant hover:text-on-surface hover:bg-white/5 border border-transparent' }}">
                <span class="material-symbols-outlined text-xl">assignment_return</span>
                <span>Barang Retur</span>
            </a>
            @endif
            
            @if(Auth::user()->role === 'superadmin')
            <p class="px-4 pt-4 pb-2 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Sistem</p>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-sm transition-all text-on-surface-variant hover:text-on-surface hover:bg-white/5 border border-transparent">
                <span class="material-symbols-outlined text-xl">manage_accounts</span>
                <span>Kelola Admin</span>
            </a>
            @endif
        </nav>

        <!-- User Info / Logout -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 px-2 py-2 mb-2">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-container to-secondary-container text-on-primary-container flex items-center justify-center font-bold text-sm shadow-[0_0_15px_rgba(80,143,248,0.3)] border border-primary/30">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-bold text-on-surface truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-label-md text-primary uppercase tracking-widest">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 mb-2 rounded-xl font-label-md text-sm text-primary hover:bg-primary/10 border border-transparent transition-all">
                <span class="material-symbols-outlined text-xl">storefront</span>
                <span>Ke Halaman Toko</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-label-md text-sm text-error hover:bg-error/10 hover:border-error/20 border border-transparent transition-all">
                    <span class="material-symbols-outlined text-xl">logout</span>
                    <span>Logout (Keluar)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div class="fixed inset-0 bg-black/50 z-30 hidden md:hidden backdrop-blur-sm" id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col md:ml-64 min-h-screen transition-all duration-300">
        
        <!-- Top Header Mobile (Visible only on small screens) -->
        <header class="md:hidden flex items-center justify-between px-6 h-20 bg-surface-container-low/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="text-on-surface hover:text-primary transition p-2 bg-white/5 rounded-lg border border-white/10">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <span class="font-display-xl text-lg bg-gradient-to-r from-primary to-secondary-fixed-dim bg-clip-text text-transparent truncate">Wonder Shope Admin</span>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="flex-1 p-6 md:p-10 max-w-[1440px] w-full mx-auto">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-xl font-label-md flex items-center space-x-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-error/10 border border-error/20 text-error rounded-xl font-label-md flex items-center space-x-2">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')

        </main>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
            } else {
                overlay.classList.remove('hidden');
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
