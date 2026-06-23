<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Linktree</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS (Vite bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            perspective: 1000px;
        }
        .tilt-3d {
            transform-style: preserve-3d;
            transition: transform 0.2s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.2s ease;
            will-change: transform;
        }
        .ambient-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.35;
            pointer-events: none;
            z-index: 0;
            animation: float 20s infinite alternate ease-in-out;
        }
        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50px, 40px) scale(1.15); }
            100% { transform: translate(-30px, -20px) scale(0.9); }
        }
    </style>
</head>
<body class="min-h-screen bg-[#090b11] text-slate-100 flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Blobs -->
    <div class="ambient-blob w-[400px] h-[400px] bg-purple-900/30 top-1/4 left-1/4"></div>
    <div class="ambient-blob w-[350px] h-[350px] bg-indigo-900/25 bottom-1/4 right-1/4" style="animation-delay: -5s;"></div>

    <div class="w-full max-w-md z-10">
        
        <!-- Back to site link -->
        <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 text-xs text-slate-400 hover:text-white mb-6 transition-colors duration-300">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Profile</span>
        </a>

        <!-- 3D Login Card -->
        <div class="tilt-3d p-8 md:p-10 bg-slate-900/60 border border-slate-700/30 rounded-3xl backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.4)]">
            
            <div class="flex flex-col items-center mb-8">
                <!-- Lock Icon badge -->
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center shadow-lg shadow-purple-500/20 mb-4">
                    <i data-lucide="lock" class="w-6 h-6 text-white"></i>
                </div>
                <h2 class="text-2xl font-bold tracking-tight">Admin Portal</h2>
                <p class="text-sm text-slate-400 mt-2 text-center">Enter credentials to manage your Linktree links</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-950/40 border border-red-500/20 text-red-300 text-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-semibold tracking-wider text-slate-300 uppercase">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@linktree.local"
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-950/50 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 transition-colors duration-300 placeholder-slate-600 text-sm">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-xs font-semibold tracking-wider text-slate-300 uppercase">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                            <i data-lucide="key-round" class="w-4 h-4"></i>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-950/50 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 transition-colors duration-300 placeholder-slate-600 text-sm">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600 peer-checked:after:bg-white relative"></div>
                        <span class="ml-3 text-xs text-slate-400 select-none">Remember this device</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-purple-900/30 hover:shadow-purple-700/40 text-sm mt-2 flex items-center justify-center gap-2 cursor-pointer">
                    <span>Sign In</span>
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                </button>
            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-500 mt-8">
            &copy; {{ date('Y') }} Linktree. All rights reserved.
        </p>

    </div>

    <script>
        lucide.createIcons();

        // 3D Card Tilt
        const card = document.querySelector('.tilt-3d');
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xc = rect.width / 2;
            const yc = rect.height / 2;
            const angleX = (yc - y) / 15;
            const angleY = (x - xc) / 15;
            card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) scale3d(1.01, 1.01, 1.01)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    </script>
</body>
</html>
