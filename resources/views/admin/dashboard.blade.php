<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Linktree Admin Dashboard</title>
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
        }

        /* 3D elements */
        .tilt-3d {
            transform-style: preserve-3d;
            transition: transform 0.2s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.2s ease;
            will-change: transform;
        }
        
        .tilt-3d:hover {
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.3);
        }

        /* Phone mockup styling */
        .phone-frame {
            border: 12px solid #1e293b;
            box-shadow: 0 25px 60px -15px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.05);
            border-radius: 44px;
            overflow: hidden;
            width: 320px;
            height: 640px;
            position: relative;
        }

        .phone-notch {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 110px;
            height: 24px;
            background: #1e293b;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phone-camera {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #0f172a;
            margin-right: 8px;
        }
        
        .phone-speaker {
            width: 35px;
            height: 4px;
            border-radius: 2px;
            background: #334155;
        }

        /* Hide scrollbars */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Tabs styling */
        .tab-btn.active {
            background-color: rgba(147, 51, 234, 0.15);
            color: #c084fc;
            border-color: rgba(147, 51, 234, 0.4);
        }
    </style>
</head>
<body class="min-h-screen bg-[#090b11] text-slate-100 flex flex-col">

    <!-- Header / Navbar -->
    <header class="w-full backdrop-blur-md bg-slate-950/60 border-b border-slate-800/40 px-6 py-4 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-purple-500/20">
                <i data-lucide="layers" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <span class="font-bold text-lg tracking-tight">Linktree Dashboard</span>
                <span class="text-[10px] text-purple-400 bg-purple-950/50 px-2 py-0.5 rounded-full ml-2 font-mono uppercase">Admin</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-900 border border-slate-800">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-xs font-semibold text-slate-300">{{ Auth::user()->name }}</span>
            </div>
            
            <a href="{{ route('profile') }}" target="_blank" class="flex items-center gap-2 text-xs font-semibold px-4 py-2 rounded-xl bg-indigo-600/10 hover:bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 transition-all duration-300 cursor-pointer">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>View Public Site</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-xs font-semibold px-4 py-2 rounded-xl bg-red-600/10 hover:bg-red-600/20 text-red-400 border border-red-500/20 transition-all duration-300 cursor-pointer">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Sign Out</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 lg:p-8 max-w-7xl w-full mx-auto">
        
        <!-- Left Side: Config Panel (8 Columns) -->
        <div class="lg:col-span-8 flex flex-col space-y-6">
            
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/40 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Clicks</span>
                        <h3 class="text-2xl font-bold mt-1 text-purple-400">{{ $totalClicks }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-purple-950/60 flex items-center justify-center text-purple-400">
                        <i data-lucide="trending-up" class="w-5 h-5"></i>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/40 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Active Links</span>
                        <h3 class="text-2xl font-bold mt-1 text-emerald-400">{{ $links->where('is_active', true)->count() }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-950/60 flex items-center justify-center text-emerald-400">
                        <i data-lucide="link" class="w-5 h-5"></i>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/40 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Social Handles</span>
                        <h3 class="text-2xl font-bold mt-1 text-cyan-400">
                            {{ collect($settings->social_links ?? [])->filter(fn($val) => !empty($val))->count() }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-cyan-950/60 flex items-center justify-center text-cyan-400">
                        <i data-lucide="share-2" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-950/40 border border-emerald-500/20 text-emerald-300 text-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="flex items-center gap-2 p-1.5 bg-slate-950/80 rounded-2xl border border-slate-800/40 self-start">
                <button onclick="switchTab('links-manager')" id="btn-links-manager" class="tab-btn active px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 border border-transparent flex items-center gap-2 cursor-pointer">
                    <i data-lucide="link-2" class="w-4 h-4"></i>
                    <span>Links Manager</span>
                </button>
                <button onclick="switchTab('profile-designer')" id="btn-profile-designer" class="tab-btn px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 border border-transparent flex items-center gap-2 cursor-pointer">
                    <i data-lucide="palette" class="w-4 h-4"></i>
                    <span>Profile & Theme</span>
                </button>
            </div>

            <!-- TAB 1: Links Manager -->
            <div id="tab-links-manager" class="tab-content space-y-6">
                
                <!-- Add New Link Form -->
                <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/40">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-4 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4 text-purple-400"></i>
                        <span>Add New Custom Link</span>
                    </h3>
                    <form action="{{ route('admin.links.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-4 space-y-1.5">
                            <label class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">Link Title</label>
                            <input type="text" name="title" required placeholder="e.g. 🌟 Work Portfolio"
                                   class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 placeholder-slate-600 text-sm">
                        </div>

                        <div class="md:col-span-5 space-y-1.5">
                            <label class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">Destination URL</label>
                            <input type="url" name="url" required placeholder="https://github.com/myusername"
                                   class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 placeholder-slate-600 text-sm">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">Icon</label>
                            <select name="icon" class="w-full px-3 py-2.5 bg-slate-950/60 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 text-sm">
                                <option value="link">Link</option>
                                <option value="globe">Globe</option>
                                <option value="briefcase">Briefcase</option>
                                <option value="book-open">Blog Book</option>
                                <option value="mail">Mail</option>
                                <option value="video">Video</option>
                                <option value="music">Music</option>
                                <option value="shopping-cart">Shop</option>
                                <option value="message-circle">Chat</option>
                                <option value="download">Download</option>
                            </select>
                        </div>

                        <div class="md:col-span-1">
                            <button type="submit" class="w-full py-2.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl font-bold text-sm transition-all duration-300 flex items-center justify-center cursor-pointer" title="Add Link">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Existing Links List -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                        <i data-lucide="list" class="w-4 h-4 text-purple-400"></i>
                        <span>Manage Links ({{ $links->count() }})</span>
                    </h3>

                    <div class="space-y-3" id="links-container">
                        @forelse($links as $index => $link)
                            <div class="p-4 rounded-2xl bg-slate-900/40 border border-slate-800/40 hover:border-slate-700/60 transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-4" data-id="{{ $link->id }}">
                                
                                <!-- Sort, Icon and Title Info -->
                                <div class="flex items-center gap-3">
                                    <!-- Simple reorder buttons -->
                                    <div class="flex flex-col gap-1">
                                        <button onclick="reorderLink({{ $link->id }}, 'up')" class="p-1 hover:text-purple-400 text-slate-500 transition-colors cursor-pointer" title="Move Up">
                                            <i data-lucide="chevron-up" class="w-4 h-4"></i>
                                        </button>
                                        <button onclick="reorderLink({{ $link->id }}, 'down')" class="p-1 hover:text-purple-400 text-slate-500 transition-colors cursor-pointer" title="Move Down">
                                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                        </button>
                                    </div>

                                    <div class="w-9 h-9 rounded-xl bg-slate-950 flex items-center justify-center text-purple-400 border border-slate-800">
                                        <i data-lucide="{{ $link->icon ?? 'link' }}" class="w-4 h-4"></i>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-sm text-slate-200">{{ $link->title }}</h4>
                                            @if(!$link->is_active)
                                                <span class="px-1.5 py-0.5 text-[8px] font-bold bg-slate-800 text-slate-400 rounded-full border border-slate-700 uppercase">Hidden</span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-slate-500 truncate max-w-xs block mt-0.5">{{ $link->url }}</span>
                                    </div>
                                </div>

                                <!-- Clicks, Status and Actions -->
                                <div class="flex items-center justify-between md:justify-end gap-6 border-t md:border-t-0 border-slate-800 pt-3 md:pt-0">
                                    
                                    <!-- Analytics click counter -->
                                    <div class="flex items-center gap-1.5 text-xs text-slate-400" title="Click statistics">
                                        <i data-lucide="eye" class="w-4 h-4 text-purple-400"></i>
                                        <span class="font-semibold">{{ $link->clicks_count }} clicks</span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <!-- Edit inline toggle button (triggers form show) -->
                                        <button onclick="toggleEditForm({{ $link->id }})" class="p-2 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-xl text-slate-400 hover:text-white transition-colors cursor-pointer" title="Edit details">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </button>

                                        <!-- Delete Link Form -->
                                        <form action="{{ route('admin.links.destroy', $link) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this link?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-950/20 hover:bg-red-950/50 border border-red-900/30 hover:border-red-800/40 rounded-xl text-red-400 hover:text-red-300 transition-colors cursor-pointer" title="Delete Link">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>

                            </div>

                            <!-- Inline Edit Form (Hidden by default) -->
                            <div id="edit-form-{{ $link->id }}" class="hidden p-5 rounded-2xl bg-slate-950 border border-slate-800/60 space-y-4">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Edit Link Properties</h4>
                                <form action="{{ route('admin.links.update', $link) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="md:col-span-4 space-y-1.5">
                                        <label class="text-[10px] font-bold tracking-wider text-slate-500 uppercase">Title</label>
                                        <input type="text" name="title" value="{{ $link->title }}" required
                                               class="w-full px-4 py-2 bg-slate-900 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 text-sm">
                                    </div>

                                    <div class="md:col-span-4 space-y-1.5">
                                        <label class="text-[10px] font-bold tracking-wider text-slate-500 uppercase">Destination URL</label>
                                        <input type="url" name="url" value="{{ $link->url }}" required
                                               class="w-full px-4 py-2 bg-slate-900 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 text-sm">
                                    </div>

                                    <div class="md:col-span-2 space-y-1.5">
                                        <label class="text-[10px] font-bold tracking-wider text-slate-500 uppercase">Icon</label>
                                        <select name="icon" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 text-sm">
                                            <option value="link" {{ $link->icon === 'link' ? 'selected' : '' }}>Link</option>
                                            <option value="globe" {{ $link->icon === 'globe' ? 'selected' : '' }}>Globe</option>
                                            <option value="briefcase" {{ $link->icon === 'briefcase' ? 'selected' : '' }}>Briefcase</option>
                                            <option value="book-open" {{ $link->icon === 'book-open' ? 'selected' : '' }}>Blog Book</option>
                                            <option value="mail" {{ $link->icon === 'mail' ? 'selected' : '' }}>Mail</option>
                                            <option value="video" {{ $link->icon === 'video' ? 'selected' : '' }}>Video</option>
                                            <option value="music" {{ $link->icon === 'music' ? 'selected' : '' }}>Music</option>
                                            <option value="shopping-cart" {{ $link->icon === 'shopping-cart' ? 'selected' : '' }}>Shop</option>
                                            <option value="message-circle" {{ $link->icon === 'message-circle' ? 'selected' : '' }}>Chat</option>
                                            <option value="download" {{ $link->icon === 'download' ? 'selected' : '' }}>Download</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-2 flex items-center justify-between gap-4 pt-1.5 md:pt-0">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="is_active" id="active_{{ $link->id }}" value="1" {{ $link->is_active ? 'checked' : '' }}
                                                   class="w-4 h-4 text-purple-600 bg-slate-900 border-slate-800 rounded focus:ring-purple-500">
                                            <label for="active_{{ $link->id }}" class="text-xs text-slate-400 select-none cursor-pointer">Visible</label>
                                        </div>
                                        
                                        <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-500 text-white rounded-xl font-bold text-xs transition-all duration-300 cursor-pointer">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <div class="text-center p-8 bg-slate-900/20 border border-slate-800/40 rounded-2xl text-slate-500 text-sm">
                                <i data-lucide="link" class="w-8 h-8 mx-auto mb-2 text-slate-600"></i>
                                <p>No custom links created yet. Add your first link above!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- TAB 2: Profile & Theme Designer -->
            <div id="tab-profile-designer" class="tab-content hidden">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Bio & Identity Card -->
                    <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/40 space-y-6">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-purple-400"></i>
                            <span>Profile Details</span>
                        </h3>

                        <div class="flex flex-col sm:flex-row gap-6 items-start">
                            
                            <!-- Avatar upload frame -->
                            <div class="relative group self-center sm:self-start">
                                <div class="w-24 h-24 rounded-full overflow-hidden border border-slate-700 bg-slate-950 relative">
                                    <img id="avatar-preview-element" src="{{ $settings->profile_avatar ?? '/images/default-avatar.png' }}" 
                                         alt="Preview" class="w-full h-full object-cover">
                                    <label class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition-opacity duration-300 text-[10px] font-bold text-slate-300 uppercase select-none">
                                        Upload
                                        <input type="file" name="profile_avatar" id="avatar-upload-input" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                                    </label>
                                </div>
                            </div>

                            <!-- Name and Bio inputs -->
                            <div class="flex-1 w-full space-y-4">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">Profile Display Name</label>
                                    <input type="text" name="profile_name" id="profile-name-input" value="{{ $settings->profile_name }}" required
                                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 text-sm">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">Bio / Description</label>
                                    <textarea name="profile_bio" id="profile-bio-input" rows="3" placeholder="Tell visitors about yourself..."
                                              class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 text-sm resize-none">{{ $settings->profile_bio }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Theme Config Card -->
                    <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/40 space-y-4">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4 text-purple-400"></i>
                            <span>Select 3D Aesthetic Theme</span>
                        </h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- inxdvi-dark -->
                            <label class="cursor-pointer group relative">
                                <input type="radio" name="theme" value="inxdvi-dark" class="sr-only peer" onchange="previewTheme(this.value)" {{ ($settings->theme ?? 'inxdvi-dark') === 'inxdvi-dark' ? 'checked' : '' }}>
                                <div class="p-4 rounded-xl border border-slate-800 bg-[#070709] group-hover:border-purple-500/40 peer-checked:border-purple-500 peer-checked:bg-purple-950/20 text-center transition-all duration-300">
                                    <div class="w-8 h-8 rounded-full bg-neutral-900/40 border border-purple-500/30 mx-auto mb-2 flex items-center justify-center">
                                        <div class="w-4 h-4 rounded-full bg-violet-600"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-300">Midnight Dark</span>
                                </div>
                            </label>

                            <!-- inxdvi-light -->
                            <label class="cursor-pointer group relative">
                                <input type="radio" name="theme" value="inxdvi-light" class="sr-only peer" onchange="previewTheme(this.value)" {{ ($settings->theme ?? '') === 'inxdvi-light' ? 'checked' : '' }}>
                                <div class="p-4 rounded-xl border border-slate-800 bg-[#FAF9F6] group-hover:border-purple-500/40 peer-checked:border-purple-500 peer-checked:bg-purple-50 text-center transition-all duration-300">
                                    <div class="w-8 h-8 rounded-full bg-white border border-neutral-300 mx-auto mb-2 flex items-center justify-center">
                                        <div class="w-4 h-4 rounded-full bg-neutral-900"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-800">Editorial Light</span>
                                </div>
                            </label>

                            <!-- inxdvi-cyber -->
                            <label class="cursor-pointer group relative">
                                <input type="radio" name="theme" value="inxdvi-cyber" class="sr-only peer" onchange="previewTheme(this.value)" {{ ($settings->theme ?? '') === 'inxdvi-cyber' ? 'checked' : '' }}>
                                <div class="p-4 rounded-xl border border-slate-800 bg-[#020204] group-hover:border-cyan-500/40 peer-checked:border-cyan-500 peer-checked:bg-cyan-950/20 text-center transition-all duration-300">
                                    <div class="w-8 h-8 rounded-full bg-cyan-950/60 border border-cyan-400 mx-auto mb-2 flex items-center justify-center">
                                        <div class="w-4 h-4 rounded-full bg-cyan-400"></div>
                                    </div>
                                    <span class="text-xs font-bold text-cyan-400">Obsidian Tech</span>
                                </div>
                            </label>

                            <!-- inxdvi-mono -->
                            <label class="cursor-pointer group relative">
                                <input type="radio" name="theme" value="inxdvi-mono" class="sr-only peer" onchange="previewTheme(this.value)" {{ ($settings->theme ?? '') === 'inxdvi-mono' ? 'checked' : '' }}>
                                <div class="p-4 rounded-xl border border-slate-800 bg-[#000000] group-hover:border-slate-500/40 peer-checked:border-white peer-checked:bg-neutral-900 text-center transition-all duration-300">
                                    <div class="w-8 h-8 rounded-full bg-black border border-white mx-auto mb-2 flex items-center justify-center">
                                        <div class="w-4 h-4 rounded-full bg-white"></div>
                                    </div>
                                    <span class="text-xs font-bold text-white">Nordic Mono</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Social Media Links Config Card -->
                    <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800/40 space-y-4">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-300 flex items-center gap-2">
                            <i data-lucide="share-2" class="w-4 h-4 text-purple-400"></i>
                            <span>Social Media Profiles</span>
                        </h3>
                        
                        @php
                            $socialLinks = $settings->social_links ?? [];
                            $socialFields = [
                                'instagram' => ['label' => 'Instagram Username', 'icon' => 'instagram', 'placeholder' => 'zyrexxx.code'],
                                'tiktok' => ['label' => 'TikTok Username', 'icon' => 'music', 'placeholder' => 'zyrexxx.code'],
                                'github' => ['label' => 'GitHub Username', 'icon' => 'github', 'placeholder' => 'zyrexxx'],
                                'linkedin' => ['label' => 'LinkedIn Handle', 'icon' => 'linkedin', 'placeholder' => 'zyrexxx-code'],
                                'twitter' => ['label' => 'Twitter/X Username', 'icon' => 'twitter', 'placeholder' => 'zyrexxx'],
                                'youtube' => ['label' => 'YouTube Channel URL/Handle', 'icon' => 'youtube', 'placeholder' => '@zyrexxx'],
                                'whatsapp' => ['label' => 'WhatsApp Number (with country code)', 'icon' => 'phone', 'placeholder' => '6281234567890'],
                            ];
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($socialFields as $key => $field)
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold tracking-wider text-slate-400 uppercase flex items-center gap-1.5">
                                        @if($key === 'instagram')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                        @elseif($key === 'tiktok')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                                        @elseif($key === 'github')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                        @elseif($key === 'linkedin')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                        @elseif($key === 'twitter')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        @elseif($key === 'youtube')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                                        @elseif($key === 'whatsapp')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        @endif
                                        <span>{{ $field['label'] }}</span>
                                    </label>
                                    <input type="text" name="social_links[{{ $key }}]" data-social="{{ $key }}" value="{{ $socialLinks[$key] ?? '' }}" placeholder="{{ $field['placeholder'] }}" oninput="previewSocial('{{ $key }}', this.value)"
                                           class="w-full px-4 py-2 bg-slate-950/60 border border-slate-800 focus:border-purple-500 rounded-xl focus:outline-none text-slate-200 text-sm">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Save changes button -->
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-purple-900/30 flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Save Profile & Theme Configuration</span>
                    </button>

                </form>
            </div>

        </div>

        <!-- Right Side: Live Phone Preview (4 Columns) -->
        <div class="lg:col-span-4 flex flex-col items-center justify-start sticky top-24 self-start">
            
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-1.5">
                <i data-lucide="smartphone" class="w-4 h-4 text-purple-400"></i>
                <span>Live 3D Preview</span>
            </span>

            <!-- Phone Frame -->
            <div class="phone-frame tilt-3d">
                <div class="phone-notch">
                    <div class="phone-camera"></div>
                    <div class="phone-speaker"></div>
                </div>

                <!-- Preview Webpage Inner Container (Simulates welcome.blade.php) -->
                <div id="preview-viewport" class="w-full h-full p-6 pt-12 overflow-y-auto no-scrollbar flex flex-col items-center relative transition-all duration-500 select-none
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
                    <!-- Noise & Grid Overlays inside mockup -->
                    <div class="noise-overlay" style="position: absolute; border-radius: inherit;"></div>
                    <div id="preview-grid" class="absolute inset-0 z-0 pointer-events-none
                        @if(($settings->theme ?? '') === 'inxdvi-mono')
                            hidden
                        @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                            bg-wireframe
                        @else
                            bg-dot-grid
                        @endif
                    "></div>

                    <!-- Inner Mockup Card -->
                    <div id="preview-card" class="w-full p-6 rounded-3xl backdrop-blur-xl border flex flex-col items-center z-10 transition-all duration-300
                        @if(($settings->theme ?? '') === 'inxdvi-light')
                            bg-white border-neutral-200/80 shadow-[0_10px_30px_rgba(0,0,0,0.015)]
                        @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                            bg-black/95 border-cyan-500/20 shadow-[0_0_15px_rgba(6,182,212,0.1)] rounded-2xl
                        @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                            bg-black border border-neutral-800 rounded-none
                        @else
                            bg-neutral-900/40 border-neutral-800/40 shadow-[0_10px_30px_rgba(0,0,0,0.3)]
                        @endif
                    ">
                        <!-- Preview Avatar -->
                        <div class="relative mb-4">
                            <!-- Rotating dash ring -->
                            <div id="preview-avatar-dash" class="absolute -inset-2 rounded-full border border-dashed animate-spin-slow opacity-25
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
                            
                            <div id="preview-avatar-glow" class="absolute -inset-0.5 rounded-full border opacity-50
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

                            <div class="relative w-20 h-20 rounded-full overflow-hidden border bg-slate-950 border-slate-800
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
                                <img id="preview-avatar-image" src="{{ $settings->profile_avatar ?? '/images/default-avatar.png' }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Name and Bio Preview -->
                        <div class="text-center w-full mb-5">
                            <h4 id="preview-name" class="text-base font-bold flex items-center justify-center gap-1">
                                {{ $settings->profile_name }}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-blue-500 inline-block">
                                    <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-3.07a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                </svg>
                            </h4>
                            <p id="preview-bio" class="text-[11px] mt-2 px-2 font-normal leading-relaxed
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

                        <!-- Social Grid Preview -->
                        <div id="preview-socials" class="flex flex-wrap items-center justify-center gap-2.5 mb-5 w-full">
                            @foreach($socialFields as $key => $field)
                                @php
                                    $hasVal = !empty($socialLinks[$key] ?? '');
                                @endphp
                                <div data-prev-soc="{{ $key }}" class="w-8 h-8 rounded-lg border text-slate-400 flex items-center justify-center transition-all duration-300 {{ $hasVal ? '' : 'hidden' }}
                                    @if(($settings->theme ?? '') === 'inxdvi-light')
                                        bg-neutral-50 border-neutral-200
                                    @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                                        bg-black border-cyan-950/80
                                    @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                                        bg-black border border-neutral-800 rounded-none
                                    @else
                                        bg-neutral-950/40 border-neutral-800/80
                                    @endif
                                ">
                                    @if($key === 'instagram')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                    @elseif($key === 'tiktok')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                                    @elseif($key === 'github')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                    @elseif($key === 'linkedin')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                                    @elseif($key === 'twitter')
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    @elseif($key === 'youtube')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                                    @elseif($key === 'whatsapp')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Links Stack Preview -->
                        <div class="w-full space-y-2.5">
                            @forelse($links->where('is_active', true) as $link)
                                <div class="w-full py-2.5 px-4 rounded-xl border flex items-center justify-between text-xs
                                    @if(($settings->theme ?? '') === 'inxdvi-light')
                                        bg-neutral-50 border-neutral-200/80 text-neutral-800 shadow-sm
                                    @elseif(($settings->theme ?? '') === 'inxdvi-cyber')
                                        bg-black/90 border-cyan-950/80 text-cyan-400 rounded-lg
                                    @elseif(($settings->theme ?? '') === 'inxdvi-mono')
                                        bg-black border border-neutral-800 text-white rounded-none
                                    @else
                                        bg-neutral-950/45 border-neutral-800/40 text-neutral-200
                                    @endif
                                ">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-slate-950 flex items-center justify-center text-purple-400 border border-slate-800">
                                            <i data-lucide="{{ $link->icon ?? 'link' }}" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <span class="font-semibold">{{ $link->title }}</span>
                                    </div>
                                    <i data-lucide="chevron-right" class="w-3 h-3 text-slate-500"></i>
                                </div>
                            @empty
                                <div class="text-center py-4 text-slate-500 text-[10px]">
                                    No custom links visible.
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Scripts for Tab Switching, Live Sync, and AJAX Reordering -->
    <script>
        lucide.createIcons();

        // 1. Switch between tabs
        const switchTab = (tabId) => {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            
            document.getElementById(`tab-${tabId}`).classList.remove('hidden');
            document.getElementById(`btn-${tabId}`).classList.add('active');
        };

        // 2. Toggle edit forms
        const toggleEditForm = (id) => {
            const el = document.getElementById(`edit-form-${id}`);
            el.classList.toggle('hidden');
        };

        // 3. Reorder custom links (AJAX reorder)
        const reorderLink = (id, direction) => {
            const container = document.getElementById('links-container');
            const items = Array.from(container.children).filter(el => el.hasAttribute('data-id'));
            const currentIndex = items.findIndex(el => parseInt(el.getAttribute('data-id')) === id);
            
            if (direction === 'up' && currentIndex > 0) {
                // swap in array
                const currentEl = items[currentIndex];
                const targetEl = items[currentIndex - 1];
                container.insertBefore(currentEl, targetEl);
            } else if (direction === 'down' && currentIndex < items.length - 1) {
                // swap in array
                const currentEl = items[currentIndex];
                const targetEl = items[currentIndex + 1];
                container.insertBefore(targetEl, currentEl);
            } else {
                return; // Nothing to do
            }
            
            // Collect new IDs list
            const newOrder = Array.from(container.children)
                .filter(el => el.hasAttribute('data-id'))
                .map(el => parseInt(el.getAttribute('data-id')));
                
            // Send AJAX reorder request
            fetch('{{ route("admin.links.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ ids: newOrder })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    console.log('Reordered links successfully!');
                }
            })
            .catch(err => console.error('Error reordering links:', err));
        };

        // 4. Live Sync Preview Script (Vanilla JS)
        const profileNameInput = document.getElementById('profile-name-input');
        const profileBioInput = document.getElementById('profile-bio-input');
        const prevName = document.getElementById('preview-name');
        const prevBio = document.getElementById('preview-bio');

        // Profile Display Name Live update
        profileNameInput.addEventListener('input', (e) => {
            prevName.innerHTML = `${e.target.value} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-blue-500 inline-block"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-3.07a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>`;
        });

        // Profile Bio Live update
        profileBioInput.addEventListener('input', (e) => {
            prevBio.innerText = e.target.value;
        });

        // Preview Theme Live update
        const previewTheme = (themeName) => {
            const viewport = document.getElementById('preview-viewport');
            const card = document.getElementById('preview-card');
            const grid = document.getElementById('preview-grid');
            const avatarDash = document.getElementById('preview-avatar-dash');
            const avatarGlow = document.getElementById('preview-avatar-glow');
            const avatarImgContainer = document.querySelector('#preview-avatar-glow + div');

            // Reset classes
            viewport.className = 'w-full h-full p-6 pt-12 overflow-y-auto no-scrollbar flex flex-col items-center relative transition-all duration-500 select-none';
            card.className = 'w-full p-6 rounded-3xl backdrop-blur-xl border flex flex-col items-center z-10 transition-all duration-300';
            grid.className = 'absolute inset-0 z-0 pointer-events-none';
            avatarDash.className = 'absolute -inset-2 rounded-full border border-dashed animate-spin-slow opacity-25';
            avatarGlow.className = 'absolute -inset-0.5 rounded-full border opacity-50';
            avatarImgContainer.className = 'relative w-20 h-20 rounded-full overflow-hidden border bg-slate-950';

            // Apply new classes
            if (themeName === 'inxdvi-light') {
                viewport.classList.add('bg-[#FAF9F6]', 'text-neutral-800', 'theme-light');
                card.classList.add('bg-white', 'border-neutral-200/80', 'shadow-[0_10px_30px_rgba(0,0,0,0.015)]');
                grid.classList.add('bg-dot-grid');
                avatarDash.classList.add('border-neutral-900');
                avatarGlow.classList.add('border-neutral-200');
                avatarImgContainer.classList.add('border-neutral-200');
                prevBio.className = 'text-[11px] mt-2 px-2 font-normal leading-relaxed text-neutral-500';
            } else if (themeName === 'inxdvi-cyber') {
                viewport.classList.add('bg-[#020204]', 'text-cyan-400', 'theme-cyber');
                card.classList.add('bg-black/95', 'border-cyan-500/20', 'shadow-[0_0_15px_rgba(6,182,212,0.1)]', 'rounded-2xl');
                grid.classList.add('bg-wireframe');
                avatarDash.classList.add('border-cyan-400');
                avatarGlow.classList.add('border-cyan-500/30');
                avatarImgContainer.classList.add('border-cyan-500/50', 'rounded-2xl');
                prevBio.className = 'text-[11px] mt-2 px-2 font-normal leading-relaxed text-cyan-300/80';
            } else if (themeName === 'inxdvi-mono') {
                viewport.classList.add('bg-[#000000]', 'text-white', 'theme-mono');
                card.classList.add('bg-black', 'border', 'border-neutral-800', 'rounded-none');
                grid.classList.add('hidden');
                avatarDash.classList.add('border-white');
                avatarGlow.classList.add('border-neutral-800');
                avatarImgContainer.classList.add('border-white', 'rounded-none');
                prevBio.className = 'text-[11px] mt-2 px-2 font-normal leading-relaxed text-neutral-400';
            } else {
                // inxdvi-dark (Default)
                viewport.classList.add('bg-[#070709]', 'text-slate-100', 'theme-dark');
                card.classList.add('bg-neutral-900/40', 'border-neutral-800/40', 'shadow-[0_10px_30px_rgba(0,0,0,0.3)]');
                grid.classList.add('bg-dot-grid');
                avatarDash.classList.add('border-violet-500');
                avatarGlow.classList.add('border-white/10');
                avatarImgContainer.classList.add('border-neutral-800');
                prevBio.className = 'text-[11px] mt-2 px-2 font-normal leading-relaxed text-slate-400';
            }
            
            // Reapply link theme classes inside preview viewport
            const previewLinks = viewport.querySelectorAll('.w-full.py-2\\.5.px-4');
            previewLinks.forEach(lnk => {
                lnk.className = 'w-full py-2.5 px-4 rounded-xl border flex items-center justify-between text-xs transition-colors duration-300';
                if (themeName === 'inxdvi-light') {
                    lnk.classList.add('bg-neutral-50', 'border-neutral-200/80', 'text-neutral-800', 'shadow-sm');
                } else if (themeName === 'inxdvi-cyber') {
                    lnk.classList.add('bg-black/90', 'border-cyan-950/80', 'text-cyan-400', 'rounded-lg');
                } else if (themeName === 'inxdvi-mono') {
                    lnk.classList.add('bg-black', 'border', 'border-neutral-800', 'text-white', 'rounded-none');
                } else {
                    lnk.classList.add('bg-neutral-950/45', 'border-neutral-800/40', 'text-neutral-200');
                }
            });

            // Reapply social icons background classes
            const previewSocs = document.querySelectorAll('#preview-socials > div');
            previewSocs.forEach(soc => {
                const isHidden = soc.classList.contains('hidden');
                soc.className = 'w-8 h-8 rounded-lg border text-slate-400 flex items-center justify-center transition-all duration-300 ' + (isHidden ? 'hidden' : '');
                if (themeName === 'inxdvi-light') {
                    soc.classList.add('bg-neutral-50', 'border-neutral-200');
                } else if (themeName === 'inxdvi-cyber') {
                    soc.classList.add('bg-black', 'border-cyan-950/80');
                } else if (themeName === 'inxdvi-mono') {
                    soc.classList.add('bg-black', 'border', 'border-neutral-800', 'rounded-none');
                } else {
                    soc.classList.add('bg-neutral-950/40', 'border-neutral-800/80');
                }
            });
        };

        // Profile Avatar Upload Live update
        const previewAvatar = (input) => {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('avatar-preview-element').src = e.target.result;
                    document.getElementById('preview-avatar-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        };

        // Social handles live sync
        const previewSocial = (platform, value) => {
            const element = document.querySelector(`[data-prev-soc="${platform}"]`);
            if (value.trim() === '') {
                element.classList.add('hidden');
            } else {
                element.classList.remove('hidden');
            }
        };

        // 3D Phone Tilt Effect
        const phone = document.querySelector('.phone-frame');
        phone.addEventListener('mousemove', e => {
            const rect = phone.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xc = rect.width / 2;
            const yc = rect.height / 2;
            const angleX = (yc - y) / 10;
            const angleY = (x - xc) / 10;
            phone.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) scale3d(1.02, 1.02, 1.02)`;
        });
        phone.addEventListener('mouseleave', () => {
            phone.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    </script>
</body>
</html>
