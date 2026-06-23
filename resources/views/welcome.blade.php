<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->profile_name ?? 'INXDVI Link' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|syne:700,800" rel="stylesheet" />

    <!-- Tailwind CSS (Vite bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom CSS for 3D and Animations -->
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            overflow-x: hidden;
            perspective: 1000px;
        }

        .font-heading {
            font-family: 'Syne', sans-serif;
        }

        /* 3D tilt core styling */
        .tilt-3d {
            transform-style: preserve-3d;
            transition: transform 0.25s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.2s ease;
            will-change: transform;
        }

        .tilt-3d:hover {
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.4);
        }

        .theme-light .tilt-3d:hover {
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.05);
        }

        .tilt-3d-child {
            transform: translateZ(15px);
        }

        .tilt-3d-child-lg {
            transform: translateZ(30px);
        }

        /* Shine Reflection overlay */
        .shine-glow {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 65%);
            pointer-events: none;
            border-radius: inherit;
            z-index: 10;
        }

        /* Border highlights for cyber theme */
        .theme-cyber .cyber-glow-card {
            box-shadow: 0 0 25px rgba(6, 182, 212, 0.1), inset 0 0 15px rgba(6, 182, 212, 0.05);
        }
    </style>
</head>
<body class="min-h-screen relative flex items-center justify-center py-20 px-4 transition-colors duration-500 overflow-y-auto
    @if(($settings->theme ?? '') === 'inxdvi-light')
        bg-[#FAF9F6] text-neutral-800 theme-light
    @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
        bg-[#020204] text-cyan-400 theme-cyber
    @elseif(($settings->theme ?? '') === 'inxdvi-mono')
        bg-[#000000] text-white theme-mono
    @else
        bg-[#070709] text-slate-100 theme-dark
    @endif
">

    <!-- Premium Noise & Grid Background Systems -->
    <div class="noise-overlay"></div>
    <div class="absolute inset-0 z-0 pointer-events-none
        @if(($settings->theme ?? '') === 'inxdvi-mono')
            hidden
        @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
            bg-wireframe
        @else
            bg-dot-grid
        @endif
    "></div>

    <!-- Branding Agency Header -->
    <div class="absolute top-10 left-0 right-0 flex justify-center z-10 select-none pointer-events-none">
        <span class="font-heading text-[10px] uppercase tracking-[0.4em] font-extrabold opacity-30">
            INXDVI™ Studio
        </span>
    </div>

    <!-- Main Card Container -->
    <div class="w-full max-w-md z-10 my-auto">
        
        <!-- Elegant Profile Card -->
        <div class="tilt-3d p-8 rounded-[2rem] backdrop-blur-2xl transition-all duration-300 relative border flex flex-col items-center w-full
            @if(($settings->theme ?? '') === 'inxdvi-light')
                bg-white border-neutral-200/80 shadow-[0_15px_40px_rgba(0,0,0,0.015)]
            @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                bg-black/95 border-cyan-500/20 cyber-glow-card rounded-2xl
            @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                bg-black border border-neutral-800 rounded-none
            @else
                bg-neutral-900/40 border-neutral-800/40 shadow-[0_20px_50px_rgba(0,0,0,0.4)]
            @endif
        ">
            <div class="shine-glow"></div>

            <!-- Avatar Frame with Geometric Dash Ring -->
            <div class="relative group mb-6 tilt-3d-child-lg">
                <!-- Rotating dash ring -->
                <div class="absolute -inset-2.5 rounded-full border-2 border-dashed animate-spin-slow opacity-25 group-hover:opacity-60 transition-opacity duration-500
                    @if(($settings->theme ?? '') === 'inxdvi-light')
                        border-neutral-900
                    @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                        border-cyan-400
                    @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                        border-white
                    @else
                        border-violet-500
                    @endif
                "></div>
                
                <!-- Subtle secondary ring -->
                <div class="absolute -inset-1 rounded-full border opacity-50
                    @if(($settings->theme ?? '') === 'inxdvi-light')
                        border-neutral-200
                    @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                        border-cyan-500/30
                    @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                        border-neutral-800
                    @else
                        border-white/10
                    @endif
                "></div>
                
                <!-- Inner avatar container -->
                <div class="relative w-28 h-28 rounded-full overflow-hidden border bg-neutral-950
                    @if(($settings->theme ?? '') === 'inxdvi-light')
                        border-neutral-200
                    @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                        border-cyan-500/50 rounded-2xl
                    @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                        border-white rounded-none
                    @else
                        border-neutral-800
                    @endif
                ">
                    <img src="{{ $settings->profile_avatar ?? '/images/default-avatar.png' }}" 
                         alt="{{ $settings->profile_name }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
            </div>

            <!-- Name and Bio -->
            <div class="text-center tilt-3d-child-lg w-full mb-8">
                <h1 class="font-heading text-2xl font-black tracking-tight flex items-center justify-center gap-1.5 uppercase">
                    {{ $settings->profile_name }}
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-white bg-blue-600" title="Verified Account">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-3.07a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </h1>
                <p class="text-xs mt-3.5 px-4 font-normal leading-relaxed tracking-wide
                    @if(($settings->theme ?? '') === 'inxdvi-light')
                        text-neutral-500
                    @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                        text-cyan-300/80
                    @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                        text-neutral-400
                    @else
                        text-slate-400
                    @endif
                ">
                    {{ $settings->profile_bio }}
                </p>
            </div>

            <!-- Social handles grid -->
            @php
                $socialLinks = $settings->social_links ?? [];
                $socialPlatforms = [
                    'instagram' => ['url' => 'https://instagram.com/', 'color' => 'hover:text-pink-500'],
                    'tiktok' => ['url' => 'https://tiktok.com/@', 'color' => 'hover:text-cyan-400'],
                    'github' => ['url' => 'https://github.com/', 'color' => 'hover:text-purple-400'],
                    'linkedin' => ['url' => 'https://linkedin.com/in/', 'color' => 'hover:text-blue-500'],
                    'twitter' => ['url' => 'https://twitter.com/', 'color' => 'hover:text-sky-400'],
                    'youtube' => ['url' => 'https://youtube.com/', 'color' => 'hover:text-red-500'],
                    'whatsapp' => ['url' => 'https://wa.me/', 'color' => 'hover:text-green-500'],
                ];
                $activeSocials = collect($socialLinks)->filter(fn($val) => !empty($val))->all();
            @endphp

            @if(count($activeSocials) > 0)
                <div class="flex flex-wrap items-center justify-center gap-3.5 mb-8 tilt-3d-child w-full">
                    @foreach($activeSocials as $platform => $handle)
                        @if(isset($socialPlatforms[$platform]))
                            @php
                                $cfg = $socialPlatforms[$platform];
                                $linkUrl = str_starts_with($handle, 'http') ? $handle : $cfg['url'] . $handle;
                            @endphp
                            <a href="{{ $linkUrl }}" target="_blank" rel="noopener noreferrer" 
                               class="tilt-3d flex items-center justify-center w-11 h-11 rounded-xl transition-all duration-300 border
                                   @if(($settings->theme ?? '') === 'inxdvi-light')
                                       bg-neutral-50 hover:bg-neutral-100 border-neutral-200 text-neutral-500 hover:text-neutral-900
                                   @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                                       bg-black border-cyan-950 text-cyan-400 hover:border-pink-500 hover:text-pink-400 rounded-lg
                                   @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                                       bg-black border border-neutral-800 text-neutral-400 hover:text-white rounded-none
                                   @else
                                       bg-neutral-950/40 hover:bg-neutral-900/60 border-neutral-800/80 text-neutral-400 hover:text-violet-400 hover:border-violet-500/30
                                   @endif
                               "
                               title="{{ ucfirst($platform) }}">
                                @if($platform === 'instagram')
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                @elseif($platform === 'tiktok')
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                                @elseif($platform === 'github')
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                @elseif($platform === 'linkedin')
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                @elseif($platform === 'twitter')
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                @elseif($platform === 'youtube')
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                                @elseif($platform === 'whatsapp')
                                    <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Links list -->
            <div class="w-full space-y-4 tilt-3d-child-lg">
                @forelse($links as $link)
                    @php
                        // Dynamically determine high-end tag/category
                        $tag = 'LINK';
                        $lowered = strtolower($link->title);
                        if (str_contains($lowered, 'website') || str_contains($lowered, 'official') || str_contains($lowered, 'main')) {
                            $tag = 'WEBSITE';
                        } elseif (str_contains($lowered, 'work') || str_contains($lowered, 'portfolio') || str_contains($lowered, 'case')) {
                            $tag = 'PORTFOLIO';
                        } elseif (str_contains($lowered, 'hire') || str_contains($lowered, 'contact') || str_contains($lowered, 'quote') || str_contains($lowered, 'mail')) {
                            $tag = 'CONNECT';
                        }
                    @endphp

                    <a href="{{ route('links.click', $link) }}" target="_blank" rel="noopener"
                       class="tilt-3d w-full py-4.5 px-6 rounded-2xl border flex items-center justify-between group transition-all duration-300 relative overflow-hidden
                           @if(($settings->theme ?? '') === 'inxdvi-light')
                               bg-neutral-50 hover:bg-white border-neutral-200/80 text-neutral-800 hover:border-neutral-400 shadow-[0_4px_12px_rgba(0,0,0,0.01)]
                           @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                               bg-black/90 border-cyan-950/80 text-cyan-400 hover:border-cyan-400/80 rounded-xl
                           @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                               bg-black border border-neutral-800 text-white hover:bg-white hover:text-black rounded-none
                           @else
                               bg-neutral-950/45 hover:bg-neutral-900/60 border-neutral-800/40 text-neutral-200 hover:border-violet-500/25
                           @endif
                       ">
                       
                       <div class="flex items-center gap-4">
                           <!-- Link Icon -->
                           <div class="flex items-center justify-center w-9.5 h-9.5 rounded-xl transition-all duration-300
                               @if(($settings->theme ?? '') === 'inxdvi-light')
                                   bg-neutral-100 group-hover:bg-neutral-200 text-neutral-600
                               @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                                   bg-cyan-950/50 text-cyan-400 group-hover:text-pink-400 rounded-lg
                               @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                                   bg-neutral-900 text-white rounded-none border border-neutral-800
                               @else
                                   bg-neutral-900/60 group-hover:bg-violet-950/30 text-neutral-400 group-hover:text-violet-400
                               @endif
                           ">
                               <i data-lucide="{{ $link->icon ?? 'link' }}" class="w-4.5 h-4.5"></i>
                           </div>
                           
                           <!-- Link Title & Tag -->
                           <div class="text-left">
                               <span class="text-[9px] font-bold tracking-[0.2em] uppercase opacity-35 mb-0.5 block">
                                   {{ $tag }}
                               </span>
                               <span class="font-bold text-sm tracking-wide block">
                                   {{ $link->title }}
                               </span>
                           </div>
                       </div>

                       <!-- Arrow Indicator -->
                       <div class="text-neutral-500 group-hover:text-neutral-300 transition-colors duration-300">
                           <i data-lucide="chevron-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform duration-300"></i>
                       </div>
                    </a>
                @empty
                    <div class="text-center py-8 text-neutral-500 text-sm">
                        No links available yet.
                    </div>
                @endforelse
            </div>

            <!-- Footer Branding -->
            <div class="mt-12 text-center tilt-3d-child text-[9px] tracking-[0.2em] uppercase opacity-30 hover:opacity-80 transition-opacity duration-300">
                <a href="{{ route('login') }}" class="flex items-center gap-1.5 justify-center hover:underline font-bold">
                    <span>INXDVI™ LINK</span>
                    <i data-lucide="lock" class="w-2.5 h-2.5"></i>
                </a>
            </div>
            
        </div>
    </div>

    <!-- Script for 3D Tilt Effect and Dynamic Interactivity -->
    <script>
        // Init lucide icons
        lucide.createIcons();

        // 3D Mouse Tilt Effect
        const init3DTilt = () => {
            const elements = document.querySelectorAll('.tilt-3d');
            
            elements.forEach(el => {
                el.addEventListener('mousemove', e => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const width = rect.width;
                    const height = rect.height;
                    
                    const xc = width / 2;
                    const yc = height / 2;
                    
                    // Math logic for rotation angle (very subtle, refined rotation)
                    const maxRotate = 5; // Refined from 8 down to 5 to avoid feeling like a game
                    const rotateY = ((x - xc) / xc) * maxRotate;
                    const rotateX = ((yc - y) / yc) * maxRotate;
                    
                    el.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.008, 1.008, 1.008)`;
                });
                
                el.addEventListener('mouseleave', () => {
                    el.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
                });
            });
        };

        // Run after load
        document.addEventListener('DOMContentLoaded', init3DTilt);
    </script>
</body>
</html>
