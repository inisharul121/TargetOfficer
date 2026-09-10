<nav class="bg-white/95 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80 shadow-xs" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Logo and Primary Links -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-2.5 shrink-0 group">
                    <span class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-xs group-hover:scale-105 transition-transform">T</span>
                    <div class="flex flex-col">
                        <span class="text-lg font-black text-slate-900 tracking-tight leading-tight">Target<span class="text-indigo-600">Officer</span></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Public Service Prep</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center space-x-1 font-medium text-sm">
                    <a href="{{ route('exams.index') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 transition {{ request()->routeIs('exams.index', 'exams.show', 'exams.room', 'exams.result') ? 'text-slate-900 font-semibold bg-slate-100' : '' }}">
                        {{ __t('মডেল টেস্ট', 'Model Tests') }}
                    </a>
                    <a href="{{ route('practice.index') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 transition {{ request()->routeIs('practice.*') ? 'text-slate-900 font-semibold bg-slate-100' : '' }}">
                        {{ __t('অনুশীলন (রিডিং)', 'Practice Mode') }}
                    </a>
                    <a href="{{ route('question-bank.index') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 transition {{ request()->routeIs('question-bank.*') ? 'text-slate-900 font-semibold bg-slate-100' : '' }}">
                        {{ __t('প্রশ্ন ব্যাংক', 'Question Bank') }}
                    </a>
                    <a href="{{ route('student.progress') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 transition {{ request()->routeIs('student.progress') ? 'text-slate-900 font-semibold bg-slate-100' : '' }}">
                        {{ __t('অগ্রগতি', 'Progress') }}
                    </a>
                    <a href="{{ route('student.mistakes') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 transition {{ request()->routeIs('student.mistakes') ? 'text-slate-900 font-semibold bg-slate-100' : '' }}">
                        {{ __t('ভুল ব্যাংক', 'Mistake Bank') }}
                    </a>
                    <a href="{{ route('exams.custom') }}" class="px-3 py-2 rounded-lg text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition font-semibold text-xs flex items-center space-x-1 border border-indigo-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>{{ __t('কাস্টম টেস্ট', 'Custom Test') }}</span>
                    </a>
                </div>
            </div>

            <!-- Right: Language Toggle & Auth State / Dashboard -->
            <div class="hidden md:flex items-center space-x-3">
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs font-bold shadow-2xs">
                    <a href="{{ route('lang.switch', 'bn') }}" class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'bn' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                        <span>🇧🇩</span><span>বাংলা</span>
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 rounded-lg transition flex items-center space-x-1 {{ app()->getLocale() === 'en' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                        <span>🇬🇧</span><span>English</span>
                    </a>
                </div>

                @auth
                    <div class="flex items-center space-x-2 bg-slate-100/90 rounded-full px-3 py-1 text-xs font-semibold text-slate-700 border border-slate-200">
                        <span class="flex items-center text-amber-600" title="Daily Streak"><span class="mr-1">🔥</span> {{ auth()->user()->daily_streak }} {{ __t('দিন', 'Days') }}</span>
                        <span class="text-slate-300">|</span>
                        <span class="flex items-center text-indigo-600" title="Coins"><span class="mr-1">🪙</span> {{ auth()->user()->coins }}</span>
                    </div>

                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 text-sm font-semibold text-slate-700 hover:text-slate-900 p-1.5 rounded-xl hover:bg-slate-100 transition">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-xs text-slate-400">{{ __t('লগইন করা আছে', 'Logged in as') }}</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                {{ __t('ক্যান্ডিডেট ড্যাশবোর্ড', 'Candidate Dashboard') }}
                            </a>

                            <a href="{{ route('student.progress') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                <span class="w-4 h-4 mr-2.5 flex items-center justify-center text-xs">📊</span>
                                {{ __t('পারফরম্যান্স ও অগ্রগতি', 'My Progress & Mastery') }}
                            </a>

                            <a href="{{ route('student.mistakes') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                <span class="w-4 h-4 mr-2.5 flex items-center justify-center text-xs">🎯</span>
                                {{ __t('ভুল উত্তরের ব্যাংক', 'Mistake Bank') }}
                            </a>

                            <a href="{{ route('student.bookmarks') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                <span class="w-4 h-4 mr-2.5 flex items-center justify-center text-xs">⭐</span>
                                {{ __t('সংরক্ষিত প্রশ্নাবলি', 'Bookmarked Questions') }}
                            </a>

                            @if(auth()->user()->isSetter())
                                <div class="px-4 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">{{ __t('অ্যাডমিন ও কনটেন্ট প্যানেল', 'Admin Panel') }}</div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    {{ __t('অ্যাডমিন ড্যাশবোর্ড', 'Admin Dashboard') }}
                                </a>
                                <a href="{{ route('admin.exams.index') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    {{ __t('পরীক্ষা ও শিডিউলার', 'Exams & Scheduler') }}
                                </a>
                                <a href="{{ route('admin.questions.index') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ __t('প্রশ্ন ব্যাংক CMS', 'Question Bank CMS') }}
                                </a>
                                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    {{ __t('প্রশ্ন ত্রুটি রিপোর্ট কিউ', 'Question Reports Queue') }}
                                </a>
                            @endif

                            <div class="border-t border-slate-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    {{ __t('লগআউট', 'Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 px-3 py-2 rounded-lg hover:bg-slate-100 transition">{{ __t('লগইন', 'Login') }}</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl shadow-xs transition active:scale-95">{{ __t('ফ্রি রেজিস্ট্রেশন', 'Free Register') }}</a>
                    </div>
                @endauth
            </div>

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

    <div x-show="mobileOpen" x-transition class="md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-6 space-y-2">
        <a href="{{ route('exams.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900">{{ __t('মডেল টেস্ট', 'Model Tests') }}</a>
        <a href="{{ route('practice.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900">{{ __t('অনুশীলন (রিডিং)', 'Practice Mode') }}</a>
        <a href="{{ route('question-bank.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900">{{ __t('প্রশ্ন ব্যাংক', 'Question Bank') }}</a>
        <a href="{{ route('student.progress') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900">{{ __t('অগ্রগতি বিশ্লেষণ', 'Progress') }}</a>
        <a href="{{ route('student.mistakes') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900">{{ __t('ভুল উত্তরের ব্যাংক', 'Mistake Bank') }}</a>
        <a href="{{ route('exams.custom') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-indigo-700 bg-indigo-50">{{ __t('কাস্টম টেস্ট জেনারেটর', 'Custom Test Generator') }}</a>te-50 hover:text-slate-900">{{ __t('প্রশ্ন ব্যাংক', 'Question Bank') }}</a>
        <a href="{{ route('leaderboard.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900">{{ __t('লিডারবোর্ড', 'Leaderboard') }}</a>
        <a href="{{ route('exams.custom') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-indigo-700 bg-indigo-50">{{ __t('কাস্টম টেস্ট জেনারেটর', 'Custom Test Generator') }}</a>

        @auth
            <div class="pt-4 border-t border-slate-100 flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg font-bold text-slate-900 bg-slate-100">{{ __t('ক্যান্ডিডেট ড্যাশবোর্ড', 'Candidate Dashboard') }}</a>
                @if(auth()->user()->isSetter())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg font-bold text-slate-700 bg-slate-100">{{ __t('অ্যাডমিন ড্যাশবোর্ড', 'Admin Dashboard') }}</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg font-semibold text-rose-600 hover:bg-rose-50">{{ __t('লগআউট', 'Logout') }}</button>
                </form>
            </div>
        @else
            <div class="pt-4 border-t border-slate-100 flex flex-col space-y-2">
                <a href="{{ route('login') }}" class="block text-center py-2.5 rounded-xl border border-slate-200 font-bold text-slate-700">{{ __t('লগইন', 'Login') }}</a>
                <a href="{{ route('register') }}" class="block text-center py-2.5 rounded-xl bg-indigo-600 text-white font-bold">{{ __t('রেজিস্ট্রেশন', 'Register') }}</a>
            </div>
        @endauth
    </div>
</nav>
