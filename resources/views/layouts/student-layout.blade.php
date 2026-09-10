<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? __t('ক্যান্ডিডেট ড্যাশবোর্ড – TargetOfficer', 'Candidate Dashboard – TargetOfficer') }}</title>
    <meta name="description" content="Bangladesh's premier preparation platform for BCS, Bank, and Government Job exams.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-slate-50 text-slate-800 relative overflow-x-hidden selection:bg-indigo-600 selection:text-white"
      x-data="{ sidebarOpen: false }">

    <div class="min-h-full w-full flex flex-col lg:flex-row relative z-10">

        {{-- Mobile backdrop --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-50 lg:hidden bg-slate-800/40 backdrop-blur-xs"></div>

        {{-- Mobile sidebar drawer --}}
        <aside x-show="sidebarOpen"
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-72 p-5 flex flex-col justify-between lg:hidden overflow-y-auto bg-white border-r border-slate-200 shadow-2xl">
            <div class="space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-xs bg-indigo-600">T</div>
                        <div>
                            <span class="text-base font-black tracking-tight text-slate-900">Target<span class="text-indigo-600">Officer</span></span>
                            <span class="block text-[9px] font-bold uppercase tracking-widest text-slate-400">{{ __t('প্রস্তুতি হাব', 'Student Hub') }}</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @include('layouts.partials.student-sidebar-nav-items')
            </div>

            @auth
                <div class="mt-6 pt-4 border-t border-slate-200">
                    <div class="flex items-center justify-between bg-slate-50 p-2.5 rounded-2xl border border-slate-200 text-xs font-semibold text-slate-700 mb-3">
                        <span class="flex items-center text-amber-600 font-bold"><span class="mr-1">🔥</span> {{ auth()->user()->daily_streak }} {{ __t('দিন', 'Days') }}</span>
                        <span class="text-slate-300">|</span>
                        <span class="flex items-center text-indigo-600 font-bold"><span class="mr-1">🪙</span> {{ auth()->user()->coins }} {{ __t('কয়েন', 'Coins') }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 bg-white border border-rose-200 hover:bg-rose-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>{{ __t('লগআউট', 'Logout') }}</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        {{-- Desktop persistent sidebar --}}
        <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 sticky top-0 h-screen p-5 justify-between overflow-y-auto bg-white border-r border-slate-200/90 shadow-xs z-30">
            <div class="space-y-5">
                {{-- Brand --}}
                <div class="pb-4 border-b border-slate-200/80">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-xs bg-indigo-600 group-hover:bg-indigo-700 transition">T</div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-lg font-black tracking-tight text-slate-900">Target<span class="text-indigo-600">Officer</span></span>
                                <span class="px-1.5 py-0.2 text-[8px] font-black uppercase tracking-wider rounded bg-indigo-50 text-indigo-700 border border-indigo-200/60">STUDENT</span>
                            </div>
                            <span class="block text-[10px] font-bold text-slate-400 tracking-wider">{{ __t('বিসিএস ও সরকারি চাকরি হাব', 'Public Service Prep') }}</span>
                        </div>
                    </a>

                    {{-- Quick streak & coins preview --}}
                    @auth
                        <div class="mt-3.5 px-3 py-2 rounded-2xl flex items-center justify-between text-xs bg-slate-50 border border-slate-200/70 font-bold">
                            <span class="flex items-center text-amber-600" title="Daily Streak">
                                <span class="mr-1 text-sm">🔥</span> {{ auth()->user()->daily_streak }} {{ __t('দিন', 'd') }}
                            </span>
                            <span class="text-slate-300">|</span>
                            <span class="flex items-center text-indigo-600" title="Coins">
                                <span class="mr-1 text-sm">🪙</span> {{ auth()->user()->coins }}
                            </span>
                        </div>
                    @endauth
                </div>

                @include('layouts.partials.student-sidebar-nav-items')
            </div>

            {{-- User card at bottom --}}
            @auth
                <div class="pt-4 border-t border-slate-200/80 space-y-2">
                    <div class="flex items-center space-x-3 p-2 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-9 h-9 rounded-xl font-bold text-xs flex items-center justify-center bg-indigo-600 text-white shadow-xs shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-slate-900 truncate leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition border border-transparent hover:border-rose-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>{{ __t('লগআউট', 'Sign out') }}</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        {{-- Main content area --}}
        <div class="flex-1 flex flex-col min-w-0 min-h-screen w-full">

            {{-- Sticky top bar --}}
            <header class="sticky top-0 z-30 px-4 sm:px-6 py-3 flex items-center justify-between gap-4 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-2xs">

                {{-- Left: hamburger for mobile + quick context --}}
                <div class="flex items-center space-x-3 flex-1 max-w-xl">
                    <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl text-slate-600 border border-slate-200 bg-white hover:bg-slate-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    <div class="hidden sm:flex items-center space-x-2 text-xs text-slate-500 font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>{{ __t('টার্গেট অফিসার শিক্ষার্থী ড্যাশবোর্ড', 'TargetOfficer Student Hub') }}</span>
                    </div>
                </div>

                {{-- Right: language switch + fast actions --}}
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ route('exams.custom') }}"
                       class="hidden sm:flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-sm shadow-amber-500/20 transition">
                        <span>⚡</span>
                        <span>{{ __t('কাস্টম পরীক্ষা', 'Custom Test') }}</span>
                    </a>

                    {{-- Language toggle --}}
                    <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs font-bold shadow-2xs">
                        <a href="{{ route('lang.switch', 'bn') }}"
                           class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'bn' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                            <span>🇧🇩</span><span class="hidden sm:inline">বাংলা</span>
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}"
                           class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'en' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                            <span>🇬🇧</span><span class="hidden sm:inline">English</span>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Flash Notifications --}}
            @if(session('success'))
                <div class="px-4 sm:px-6 lg:px-8 mt-4 w-full" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 shadow-xs flex items-center justify-between text-emerald-900">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold text-xs">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="px-4 sm:px-6 lg:px-8 mt-4 w-full" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 shadow-xs flex items-center justify-between text-rose-800">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="text-xs font-bold">
                                {{ session('error') ?? $errors->first() }}
                            </div>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Main Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="py-4 px-6 text-center text-[11px] text-slate-400 border-t border-slate-200/80 bg-white/60">
                <span>© 2026 TargetOfficer — Precision Public Service Preparation Platform</span>
            </footer>
        </div>
    </div>

</body>
</html>
