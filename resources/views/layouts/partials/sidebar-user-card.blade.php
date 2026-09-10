@auth
    <div class="mt-6 rounded-2xl p-4 space-y-3 bg-slate-50 border border-slate-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl font-black text-sm flex items-center justify-center text-white shadow-xs bg-indigo-600">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                <span class="inline-block mt-0.5 text-[9px] px-2 py-0.5 rounded font-black uppercase tracking-wider bg-indigo-100 text-indigo-700">{{ auth()->user()->role }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 bg-white border border-rose-200/80 hover:bg-rose-50 hover:border-rose-300 transition shadow-2xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>{{ __t('লগআউট', 'Logout') }}</span>
            </button>
        </form>
    </div>
@endauth
