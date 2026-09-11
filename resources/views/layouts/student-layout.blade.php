<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-slate-50 dark:bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? __t('ক্যান্ডিডেট ড্যাশবোর্ড – TargetOfficer', 'Candidate Dashboard – TargetOfficer') }}</title>
    <meta name="description" content="Bangladesh's premier preparation platform for BCS, Bank, and Government Job exams.">

    <!-- Zero-FOUC Dark Mode Initializer -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 relative overflow-x-hidden selection:bg-indigo-600 selection:text-white transition-colors duration-200"
      x-data="{ 
          sidebarOpen: false, 
          searchOpen: false, 
          darkMode: document.documentElement.classList.contains('dark'),
          toggleTheme() {
              this.darkMode = !this.darkMode;
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('theme', 'light');
              }
          }
      }"
      @keydown.window.cmd.k.prevent="searchOpen = true"
      @keydown.window.ctrl.k.prevent="searchOpen = true">

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
               class="fixed inset-y-0 left-0 z-50 w-72 p-5 flex flex-col justify-between lg:hidden overflow-y-auto bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 shadow-2xl">
            <div class="space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-xs bg-indigo-600">T</div>
                        <div>
                            <span class="text-base font-black tracking-tight text-slate-900 dark:text-white">Target<span class="text-indigo-600 dark:text-indigo-400">Officer</span></span>
                            <span class="block text-[9px] font-bold uppercase tracking-widest text-slate-400">{{ __t('প্রস্তুতি হাব', 'Student Hub') }}</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @include('layouts.partials.student-sidebar-nav-items')
            </div>

            @auth
                <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-800/80 p-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-200 mb-3">
                        <span class="flex items-center text-amber-600 dark:text-amber-400 font-bold"><span class="mr-1">🔥</span> {{ auth()->user()->daily_streak }} {{ __t('দিন', 'Days') }}</span>
                        <span class="text-slate-300 dark:text-slate-600">|</span>
                        <span class="flex items-center text-indigo-600 dark:text-indigo-400 font-bold"><span class="mr-1">🪙</span> {{ auth()->user()->coins }} {{ __t('কয়েন', 'Coins') }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-white dark:bg-slate-800 border border-rose-200 dark:border-rose-900/40 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>{{ __t('লগআউট', 'Logout') }}</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        {{-- Desktop persistent sidebar --}}
        <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 sticky top-0 h-screen p-5 justify-between overflow-y-auto bg-white dark:bg-slate-900 border-r border-slate-200/90 dark:border-slate-800 shadow-xs z-30">
            <div class="space-y-5">
                {{-- Brand --}}
                <div class="pb-4 border-b border-slate-200/80 dark:border-slate-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-xs bg-indigo-600 group-hover:bg-indigo-700 transition">T</div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="text-lg font-black tracking-tight text-slate-900 dark:text-white">Target<span class="text-indigo-600 dark:text-indigo-400">Officer</span></span>
                                <span class="px-1.5 py-0.2 text-[8px] font-black uppercase tracking-wider rounded bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800">STUDENT</span>
                            </div>
                            <span class="block text-[10px] font-bold text-slate-400 tracking-wider">{{ __t('বিসিএস ও সরকারি চাকরি হাব', 'Public Service Prep') }}</span>
                        </div>
                    </a>

                    {{-- Quick streak & coins preview --}}
                    @auth
                        <div class="mt-3.5 px-3 py-2 rounded-2xl flex items-center justify-between text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200/70 dark:border-slate-700 font-bold">
                            <span class="flex items-center text-amber-600 dark:text-amber-400" title="Daily Streak">
                                <span class="mr-1 text-sm">🔥</span> {{ auth()->user()->daily_streak }} {{ __t('দিন', 'd') }}
                            </span>
                            <span class="text-slate-300 dark:text-slate-600">|</span>
                            <span class="flex items-center text-indigo-600 dark:text-indigo-400" title="Coins">
                                <span class="mr-1 text-sm">🪙</span> {{ auth()->user()->coins }}
                            </span>
                        </div>
                    @endauth
                </div>

                @include('layouts.partials.student-sidebar-nav-items')
            </div>

            {{-- User card at bottom --}}
            @auth
                <div class="pt-4 border-t border-slate-200/80 dark:border-slate-800 space-y-2">
                    <div class="flex items-center space-x-3 p-2 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800">
                        <div class="w-9 h-9 rounded-xl font-bold text-xs flex items-center justify-center bg-indigo-600 text-white shadow-xs shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-slate-900 dark:text-white truncate leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition border border-transparent hover:border-rose-200 dark:hover:border-rose-900/50">
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
            <header class="sticky top-0 z-30 px-4 sm:px-6 py-3 flex items-center justify-between gap-4 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 shadow-2xs">

                {{-- Left: hamburger + fast search trigger --}}
                <div class="flex items-center space-x-3 flex-1 max-w-xl">
                    <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    {{-- Search Input Button --}}
                    <button @click="searchOpen = true"
                            class="flex-1 max-w-md hidden sm:flex items-center justify-between px-3.5 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:border-slate-300 transition text-xs font-semibold">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span>{{ __t('স্মার্ট সার্চ (চর্যাপদ, mukti, সংবিধান)...', 'Smart search questions...') }}</span>
                        </span>
                        <kbd class="px-1.5 py-0.5 text-[10px] font-mono bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded text-slate-500 dark:text-slate-300">⌘K</kbd>
                    </button>
                </div>

                {{-- Right: theme toggle, custom test button & language toggle --}}
                <div class="flex items-center space-x-2 sm:space-x-3">
                    {{-- Dark Mode Toggle --}}
                    <button @click="toggleTheme()"
                            class="p-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-amber-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition"
                            title="Toggle Dark/Light Mode">
                        <template x-if="darkMode">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </template>
                        <template x-if="!darkMode">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </template>
                    </button>

                    <a href="{{ route('exams.custom') }}"
                       class="hidden sm:flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-sm shadow-amber-500/20 transition">
                        <span>⚡</span>
                        <span>{{ __t('কাস্টম পরীক্ষা', 'Custom Test') }}</span>
                    </a>

                    {{-- Language toggle --}}
                    <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold shadow-2xs">
                        <a href="{{ route('lang.switch', 'bn') }}"
                           class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'bn' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-slate-100' }}">
                            <span>🇧🇩</span><span class="hidden sm:inline">বাংলা</span>
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}"
                           class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'en' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-slate-100' }}">
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
            <footer class="py-4 px-6 text-center text-[11px] text-slate-400 dark:text-slate-500 border-t border-slate-200/80 dark:border-slate-800 bg-white/60 dark:bg-slate-900/60">
                <span>© 2026 TargetOfficer — Precision Public Service Preparation Platform</span>
            </footer>
        </div>
    </div>

    {{-- Global Smart Instant Search Modal (Cmd+K) --}}
    <div x-show="searchOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20 bg-slate-900/60 backdrop-blur-xs flex items-start justify-center"
         @keydown.escape.window="searchOpen = false"
         style="display: none;">
        <div @click.away="searchOpen = false"
             class="w-full max-w-xl bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden transform transition-all">
            <form action="{{ route('question-bank.index') }}" method="GET" class="p-4 border-b border-slate-200 dark:border-slate-800">
                <div class="relative flex items-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 absolute left-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text"
                           name="q"
                           autofocus
                           placeholder="প্রশ্ন বা বিষয় খুঁজুন (e.g. চর্যাপদ, mukti, সংবিধান, লাভ-ক্ষতি)..."
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 rounded-2xl border-none text-sm font-semibold focus:ring-2 focus:ring-indigo-500">
                </div>
            </form>
            <div class="p-4 bg-slate-50/50 dark:bg-slate-800/40">
                <p class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">জনপ্রিয় সার্চ কি-ওয়ার্ড (ফোনেটিক সাপোর্টেড)</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach(['চর্যাপদ', 'charyapad', 'মুক্তিযুদ্ধ', 'mukti', 'সংবিধান', 'shondhi', 'রবীন্দ্রনাথ', 'লাভ-ক্ষতি'] as $kw)
                        <a href="{{ route('question-bank.index', ['q' => $kw]) }}"
                           class="px-2.5 py-1 text-xs font-bold rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:text-indigo-600 transition">
                            {{ $kw }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="px-4 py-2.5 bg-white dark:bg-slate-900 text-right text-[10px] text-slate-400 border-t border-slate-100 dark:border-slate-800">
                <span>ESC চেপে বন্ধ করুন</span>
            </div>
        </div>
    </div>
</body>
</html>
