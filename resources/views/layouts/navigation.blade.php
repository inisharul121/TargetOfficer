<nav class="bg-white/95 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80 shadow-xs" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Logo and Primary Links -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-2.5 shrink-0 group">
                    <span class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-700 to-violet-600 flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform">T</span>
                    <div class="flex flex-col">
                        <span class="text-lg font-black text-slate-900 tracking-tight leading-tight">Target<span class="text-indigo-600">Officer</span></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Public Service Prep</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center space-x-1 font-medium text-sm">
                    <a href="{{ route('exams.index') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 transition {{ request()->routeIs('exams.*') ? 'text-indigo-600 font-semibold bg-indigo-50/80' : '' }}">
                        মডেল টেস্ট
                    </a>
                    <a href="{{ route('practice.index') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 transition {{ request()->routeIs('practice.*') ? 'text-indigo-600 font-semibold bg-indigo-50/80' : '' }}">
                        অনুশীলন
                    </a>
                    <a href="{{ route('question-bank.index') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 transition {{ request()->routeIs('question-bank.*') ? 'text-indigo-600 font-semibold bg-indigo-50/80' : '' }}">
                        প্রশ্ন ব্যাংক
                    </a>
                    <a href="{{ route('leaderboard.index') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/60 transition {{ request()->routeIs('leaderboard.*') ? 'text-indigo-600 font-semibold bg-indigo-50/80' : '' }}">
                        লিডারবোর্ড
                    </a>
                    <a href="{{ route('exams.custom') }}" class="px-3 py-2 rounded-lg text-amber-700 bg-amber-50 hover:bg-amber-100 transition font-semibold text-xs flex items-center space-x-1 border border-amber-200/60">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>কাস্টম টেস্ট</span>
                    </a>
                </div>
            </div>

            <!-- Right: Auth State / Dashboard -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <!-- Streak & Coins Pill -->
                    <div class="flex items-center space-x-2 bg-slate-100/90 rounded-full px-3 py-1 text-xs font-semibold text-slate-700 border border-slate-200">
                        <span class="flex items-center text-amber-600" title="Daily Streak">
                            <span class="mr-1">🔥</span> {{ auth()->user()->daily_streak }} দিন
                        </span>
                        <span class="text-slate-300">|</span>
                        <span class="flex items-center text-emerald-600" title="Coins">
                            <span class="mr-1">🪙</span> {{ auth()->user()->coins }}
                        </span>
                    </div>

                    <!-- User Menu Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 text-sm font-semibold text-slate-700 hover:text-indigo-600 p-1.5 rounded-xl hover:bg-slate-100 transition">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-xs text-slate-400">লগইন করা আছে</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 font-bold uppercase">{{ auth()->user()->role }}</span>
                            </div>

                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium">
                                <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                ক্যান্ডিডেট ড্যাশবোর্ড
                            </a>

                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.questions.index') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                    এডমিন CMS প্যানেল
                                </a>
                            @endif

                            <div class="border-t border-slate-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    লগআউট
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-slate-100 transition">
                            লগইন
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 px-4 py-2 rounded-xl shadow-sm shadow-indigo-200 hover:shadow-md transition-all transform active:scale-95">
                            ফ্রি রেজিস্ট্রেশন
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer -->
    <div x-show="mobileOpen" x-transition class="md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-6 space-y-2">
        <a href="{{ route('exams.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">মডেল টেস্ট</a>
        <a href="{{ route('practice.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">অনুশীলন</a>
        <a href="{{ route('question-bank.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">প্রশ্ন ব্যাংক</a>
        <a href="{{ route('leaderboard.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">লিডারবোর্ড</a>
        <a href="{{ route('exams.custom') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-amber-700 bg-amber-50">কাস্টম টেস্ট জেনারেটর</a>

        @auth
            <div class="pt-4 border-t border-slate-100 flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg font-bold text-indigo-600 bg-indigo-50">ড্যাশবোর্ড</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg font-semibold text-rose-600 hover:bg-rose-50">লগআউট</button>
                </form>
            </div>
        @else
            <div class="pt-4 border-t border-slate-100 flex flex-col space-y-2">
                <a href="{{ route('login') }}" class="block text-center py-2.5 rounded-xl border border-slate-200 font-bold text-slate-700">লগইন</a>
                <a href="{{ route('register') }}" class="block text-center py-2.5 rounded-xl bg-indigo-600 text-white font-bold">রেজিস্ট্রেশন</a>
            </div>
        @endauth
    </div>
</nav>
