@php
    $currentRoute = request()->route()?->getName() ?? '';

    $studentNav = [
        [
            'route' => 'dashboard',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'label_bn' => 'ড্যাশবোর্ড',
            'label_en' => 'Dashboard',
            'active_check' => 'dashboard',
        ],
        [
            'route' => 'live-exams.index',
            'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
            'label_bn' => 'লাইভ মডেল টেস্ট',
            'label_en' => 'Live Model Tests',
            'active_check' => 'live-exams.',
            'badge' => '🔴 LIVE',
            'badge_color' => 'bg-rose-100 text-rose-700 border-rose-200 animate-pulse',
        ],
        [
            'route' => 'battle.index',
            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'label_bn' => 'কুইজ ব্যাটেল (১ বনাম ১)',
            'label_en' => '1v1 Quiz Battle',
            'active_check' => 'battle.',
            'badge' => '🔥 NEW',
            'badge_color' => 'bg-orange-100 text-orange-700 border-orange-200',
        ],
        [
            'route' => 'routine.index',
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
            'label_bn' => 'স্টাডি রুটিন ও সিলেবাস',
            'label_en' => 'Study Routine',
            'active_check' => 'routine.',
            'badge' => 'রুটিন',
            'badge_color' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
        ],
        [
            'route' => 'flashcards.index',
            'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            'label_bn' => 'স্মার্ট ফ্ল্যাশ কার্ড',
            'label_en' => 'Flashcards',
            'active_check' => 'flashcards.',
            'badge' => '🧠 মুখস্থ',
            'badge_color' => 'bg-purple-100 text-purple-700 border-purple-200',
        ],
        [
            'route' => 'current-affairs.index',
            'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
            'label_bn' => 'সাম্প্রতিক ঘটনাবলী (GK)',
            'label_en' => 'Current Affairs',
            'active_check' => 'current-affairs.',
            'badge' => 'দৈনিক',
            'badge_color' => 'bg-blue-100 text-blue-700 border-blue-200',
        ],
        [
            'route' => 'exams.custom',
            'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4',
            'label_bn' => 'কাস্টম পরীক্ষা ইঞ্জিন',
            'label_en' => 'Custom Exam',
            'active_check' => 'exams.custom',
            'badge' => '⚡ PRO',
            'badge_color' => 'bg-amber-100 text-amber-800 border-amber-200',
        ],
        [
            'route' => 'exams.index',
            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
            'label_bn' => 'সকল মডেল টেস্ট',
            'label_en' => 'Model Tests',
            'active_check' => 'exams.index',
        ],
        [
            'route' => 'practice.index',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'label_bn' => 'অনুশীলন ও রিডিং মোড',
            'label_en' => 'Practice & Reading',
            'active_check' => 'practice.',
        ],
        [
            'route' => 'question-bank.index',
            'icon' => 'M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7c0-2-1.5-3-3.5-3h-9C5.5 4 4 5 4 7zm0 3h16',
            'label_bn' => 'প্রশ্ন ব্যাংক ও আর্কাইভ',
            'label_en' => 'Question Bank',
            'active_check' => 'question-bank.',
        ],
        [
            'route' => 'books.index',
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'label_bn' => 'বিষয়ভিত্তিক টেক্সট ই-বুক',
            'label_en' => 'Topic Textbooks (Theory & Written)',
            'active_check' => 'books.',
            'badge' => '📚 E-BOOK',
            'badge_color' => 'bg-indigo-100 text-indigo-700 border-indigo-200 font-black',
        ],
        [
            'route' => 'student.progress',
            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'label_bn' => 'পারফরম্যান্স ও অগ্রগতি',
            'label_en' => 'Progress & Mastery',
            'active_check' => 'student.progress',
        ],
        [
            'route' => 'student.mistakes',
            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
            'label_bn' => 'ভুল উত্তরের ব্যাংক',
            'label_en' => 'Mistake Bank',
            'active_check' => 'student.mistakes',
            'badge' => 'রিভিশন',
            'badge_color' => 'bg-rose-100 text-rose-700 border-rose-200',
        ],
        [
            'route' => 'student.bookmarks',
            'icon' => 'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z',
            'label_bn' => 'সংরক্ষিত প্রশ্নাবলি',
            'label_en' => 'Bookmarks',
            'active_check' => 'student.bookmarks',
        ],
        [
            'route' => 'leaderboard.index',
            'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
            'label_bn' => 'জাতীয় মেধা তালিকা',
            'label_en' => 'Leaderboard',
            'active_check' => 'leaderboard.',
        ],
    ];
@endphp

<nav class="space-y-1.5">
    <p class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
        {{ __t('শিক্ষার্থী মূল মেন্যু', 'Student Menu') }}
    </p>

    @foreach($studentNav as $item)
        @php
            $isActive = str_starts_with($currentRoute, $item['active_check'] ?? $item['route']);
        @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-xs font-bold transition group
                  {{ $isActive
                     ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20'
                     : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
            <div class="flex items-center space-x-3 min-w-0">
                <svg class="w-4 h-4 shrink-0 transition {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-600' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                </svg>
                <span class="truncate">{{ __t($item['label_bn'], $item['label_en']) }}</span>
            </div>

            @if(!empty($item['badge']))
                <span class="px-2 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-md border shrink-0
                             {{ $isActive ? 'bg-white/20 text-white border-white/30' : ($item['badge_color'] ?? 'bg-slate-100 text-slate-600 border-slate-200') }}">
                    {{ $item['badge'] }}
                </span>
            @endif
        </a>
    @endforeach

    @if(auth()->check() && auth()->user()->isSetter())
        <div class="pt-4 mt-3 border-t border-slate-200/80">
            <p class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
                {{ __t('কনটেন্ট ও অ্যাডমিন প্যানেল', 'Staff & Content') }}
            </p>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition">
                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="truncate">{{ __t('অ্যাডমিন ড্যাশবোর্ড', 'Admin CMS') }}</span>
            </a>
        </div>
    @endif
</nav>
