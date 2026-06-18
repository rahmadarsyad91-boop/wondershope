<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <defs>
        <linearGradient id="cyber-grad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#4F8EF7" />
            <stop offset="100%" stop-color="#00F5FF" />
        </linearGradient>
        <filter id="glow">
            <feGaussianBlur stdDeviation="2.5" result="coloredBlur"/>
            <feMerge>
                <feMergeNode in="coloredBlur"/>
                <feMergeNode in="SourceGraphic"/>
            </feMerge>
        </filter>
    </defs>

    <!-- Outer glowing high-tech circle -->
    <circle cx="50" cy="50" r="45" fill="none" stroke="url(#cyber-grad)" stroke-width="2" stroke-dasharray="4 8" opacity="0.8" filter="url(#glow)" />
    
    <!-- Inner solid ring -->
    <circle cx="50" cy="50" r="38" fill="none" stroke="rgba(79, 142, 247, 0.3)" stroke-width="1" />

    <!-- Central Tech/Gadget Emblem -->
    <path d="M50 25 L75 38 L75 62 L50 75 L25 62 L25 38 Z" fill="rgba(0, 245, 255, 0.1)" stroke="url(#cyber-grad)" stroke-width="3" stroke-linejoin="round" filter="url(#glow)"/>
    
    <!-- Core CPU/Chip element -->
    <rect x="42" y="42" width="16" height="16" rx="4" fill="url(#cyber-grad)" />
    <path d="M42 50 L35 50 M58 50 L65 50 M50 42 L50 35 M50 58 L50 65" stroke="url(#cyber-grad)" stroke-width="2" stroke-linecap="round" />
</svg>
