<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? __t('অ্যাডমিন ড্যাশবোর্ড – TargetOfficer', 'Admin Dashboard – TargetOfficer') }}</title>
    <meta name="description" content="Bangladesh's premier preparation platform for BCS, Bank, and Government Job exams.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-slate-50 text-slate-800 relative overflow-x-hidden"
      x-data="{ sidebarOpen: false }">

    <div class="min-h-full w-full flex flex-col lg:flex-row relative z-10">

        {{-- Mobile backdrop --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-50 lg:hidden bg-slate-700/40 backdrop-blur-xs"></div>

        {{-- Mobile sidebar drawer --}}
        <aside x-show="sidebarOpen"
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-72 p-5 flex flex-col justify-between lg:hidden overflow-y-auto bg-white border-r border-slate-200 shadow-2xl">
            <div class="space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-xs bg-indigo-600">T</div>
                        <div>
                            <span class="text-base font-black tracking-tight text-slate-900">Target<span class="text-indigo-600">Officer</span></span>
                            <span class="block text-[9px] font-bold uppercase tracking-widest text-slate-400">{{ __t('অ্যাডমিন হাব', 'Admin Control') }}</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @include('layouts.partials.sidebar-nav-items')
            </div>
            @auth @include('layouts.partials.sidebar-user-card') @endauth
        </aside>

        {{-- Desktop persistent sidebar --}}
        <aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 z-40 p-5 justify-between overflow-y-auto bg-white border-r border-slate-200/90 shadow-xs">
            <div class="space-y-6">
                {{-- Brand --}}
                <div class="pb-5 border-b border-slate-200/80">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-xs bg-indigo-600 group-hover:bg-indigo-700 transition">T</div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-xl font-black tracking-tight text-slate-900">Target<span class="text-indigo-600">Officer</span></span>
                                <span class="px-1.5 py-0.5 text-[9px] font-black uppercase tracking-wider rounded bg-indigo-50 text-indigo-700 border border-indigo-200/60">CMS</span>
                            </div>
                            <span class="block text-[10px] font-bold text-slate-400 tracking-wider">{{ __t('এডমিন ও কনটেন্ট ম্যানেজমেন্ট', 'Admin & Content Management') }}</span>
                        </div>
                    </a>

                    {{-- Live status indicator --}}
                    <div class="mt-4 px-3 py-2 rounded-xl flex items-center justify-between text-[11px] bg-slate-50 border border-slate-200/70">
                        <span class="flex items-center font-bold text-emerald-700">
                            <span class="w-2 h-2 rounded-full mr-2 bg-emerald-500 animate-pulse"></span>
                            {{ __t('সিস্টেম রানিং', 'System Active') }}
                        </span>
                        <span class="text-slate-400 font-bold text-[10px]">v2.5 PRO</span>
                    </div>
                </div>

                @include('layouts.partials.sidebar-nav-items')
            </div>
            @auth @include('layouts.partials.sidebar-user-card') @endauth
        </aside>

        {{-- Main content area --}}
        <div class="flex-1 lg:pl-72 flex flex-col min-w-0 min-h-screen w-full">

            {{-- Sticky top header --}}
            <header class="sticky top-0 z-30 px-4 sm:px-6 py-3 flex items-center justify-between gap-4 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-2xs">

                {{-- Left: hamburger + quick label --}}
                <div class="flex items-center space-x-3 flex-1 max-w-xl">
                    <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl text-slate-600 border border-slate-200 bg-white hover:bg-slate-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    <div class="hidden sm:flex items-center space-x-2 text-xs text-slate-400 font-bold">
                        <span>🎯 {{ __t('বিসিএস ও সরকারি চাকরি প্রস্তুতি হাব', 'BCS & Government Job Prep Hub') }}</span>
                    </div>
                </div>

                {{-- Right: lang toggle + actions + user menu --}}
                <div class="flex items-center space-x-2 sm:space-x-3">
                    {{-- Language toggle --}}
                    <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs font-bold">
                        <a href="{{ route('lang.switch', 'bn') }}"
                           class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'bn' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                            <span>🇧🇩</span><span class="hidden sm:inline">বাংলা</span>
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}"
                           class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'en' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                            <span>🇬🇧</span><span class="hidden sm:inline">English</span>
                        </a>
                    </div>

                    @auth
                        {{-- User menu --}}
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                    class="flex items-center space-x-2 p-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 transition">
                                <div class="w-8 h-8 rounded-xl font-bold text-xs flex items-center justify-center bg-indigo-600 text-white shadow-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline text-xs font-semibold text-slate-700 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 rounded-2xl py-2 z-50 bg-white border border-slate-200 shadow-xl space-y-0.5">
                                <div class="px-4 py-2.5 border-b border-slate-100">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ __t('অ্যাকাউন্ট', 'Account') }}</p>
                                    <p class="text-xs font-bold text-slate-900 truncate mt-0.5">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200/50">{{ auth()->user()->role }}</span>
                                </div>
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">
                                    <svg class="w-4 h-4 mr-2.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    {{ __t('অ্যাডমিন ড্যাশবোর্ড', 'Admin Dashboard') }}
                                </a>
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    {{ __t('ক্যান্ডিডেট ভিউ', 'Student View') }}
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition">
                                        <svg class="w-4 h-4 mr-2.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        {{ __t('লগআউট', 'Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            {{-- Flash notifications --}}
            @if(session('success'))
                <div class="px-4 sm:px-6 pt-4 animate-fade-up">
                    <div class="rounded-2xl p-4 flex items-center justify-between text-xs font-bold bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-2xs">
                        <div class="flex items-center space-x-2">
                            <span>✓</span><span>{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="px-4 sm:px-6 pt-4 animate-fade-up">
                    <div class="rounded-2xl p-4 flex items-center justify-between text-xs font-bold bg-rose-50 border border-rose-200 text-rose-800 shadow-2xs">
                        <div class="flex items-center space-x-2">
                            <span>⚠️</span><span>{{ session('error') ?? $errors->first() }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Main body --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 animate-fade-up w-full">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="py-5 px-6 text-center text-[11px] text-slate-400 border-t border-slate-200/80 bg-white/60">
                <span>© {{ date('Y') }} TargetOfficer Engine — Bangladesh's Precision Public Service Prep Platform</span>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
