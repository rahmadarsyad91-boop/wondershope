<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('app.name', 'Wonder Shope') }}</title>
    
    <!-- Tailwind & Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .hero-glow {
            background: radial-gradient(circle at 50% 50%, rgba(80, 143, 248, 0.15) 0%, transparent 70%);
        }
        body { background-color: #101415; color: #e0e3e5; }
    </style>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-highest": "#323537",
                    "surface-container-high": "#272a2c",
                    "surface-container-lowest": "#0b0f10",
                    "surface": "#101415",
                    "surface-bright": "#363a3b",
                    "background": "#101415",
                    "surface-dim": "#101415",
                    "surface-container": "#1d2022",
                    "surface-variant": "#323537",
                    "surface-container-low": "#191c1e",
                    "on-surface": "#e0e3e5",
                    "on-surface-variant": "#c2c6d5",
                    "primary": "#acc7ff",
                    "on-primary": "#002f68",
                    "primary-container": "#508ff8",
                    "on-primary-container": "#00285b",
                    "secondary-fixed": "#63f7ff",
                    "secondary-fixed-dim": "#00dce5",
                    "error": "#ffb4ab",
                    "on-error": "#690005"
            },
            "fontFamily": {
                    "body-lg": ["Inter"],
                    "display-xl": ["Outfit"],
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
<body class="font-body-md text-on-surface antialiased flex flex-col min-h-screen relative overflow-hidden">
    <!-- Animated Glow Background -->
    <div class="absolute inset-0 hero-glow z-0 pointer-events-none"></div>
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/20 rounded-full blur-[100px] z-0 pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-secondary-fixed/20 rounded-full blur-[100px] z-0 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; animation-delay: 2s;"></div>

    <!-- Navigation -->
    <nav class="absolute top-0 w-full p-6 z-20">
        <a href="{{ route('home') }}" class="font-display-xl text-headline-md bg-gradient-to-r from-primary-container to-secondary-fixed bg-clip-text text-transparent hover:brightness-110 transition flex items-center justify-center sm:justify-start gap-2">
            <span class="material-symbols-outlined text-primary text-3xl">token</span> Wonder Shope
        </a>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col sm:justify-center items-center pt-24 sm:pt-0 z-10 px-4">
        <div class="w-full sm:max-w-md mt-6 glass-card px-8 py-10 shadow-2xl overflow-hidden rounded-[2rem] border-primary/20 relative">
            <!-- Inner subtle glow -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>
    </main>
</body>
</html>
