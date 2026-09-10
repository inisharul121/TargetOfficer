@php
    $currentRoute = request()->route()?->getName() ?? '';
    $locale = app()->getLocale();

    $adminLinks = [
        [
            'route' => 'admin.dashboard',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'label_bn' => 'ড্যাশবোর্ড ওভারভিউ',
            'label_en' => 'Dashboard Overview',
        ],
        [
            'route' => 'admin.exams.index',
            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'label_bn' => 'পরীক্ষা ও মক টেস্ট',
            'label_en' => 'Exams & Mock Tests',
            'active_check' => 'admin.exams.',
        ],
        [
            'route' => 'admin.questions.index',
            'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'label_bn' => 'প্রশ্ন ব্যাংক রিপোজিটরি',
            'label_en' => 'Question Repository',
            'active_check' => 'admin.questions.',
        ],
        [
            'route' => 'admin.taxonomies.index',
            'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            'label_bn' => 'বিষয় ও প্রশ্নকর্তা সংস্থা',
            'label_en' => 'Subjects & Setters',
        ],
        [
            'route' => 'admin.reports.index',
            'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
            'label_bn' => 'ত্রুটি রিপোর্ট কিউ',
            'label_en' => 'Error Reports Queue',
        ],
        [
            'route' => 'admin.users.index',
            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
            'label_bn' => 'ব্যবহারকারী ও রোল',
            'label_en' => 'Users & Roles',
        ],
        [
            'route' => 'admin.analytics.index',
            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'label_bn' => 'ক্যালিব্রেশন অ্যানালিটিক্স',
            'label_en' => 'Platform Analytics',
        ],
        [
            'route' => 'admin.questions.duplicates',
            'icon' => 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z',
            'label_bn' => 'ডুপ্লিকেট প্রশ্ন চেকার',
            'label_en' => 'Duplicate Checker',
        ],
    ];
@endphp

<nav class="space-y-1">
    <p class="px-3 pb-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
        {{ __t('অ্যাডমিন কনসোল', 'Admin Console') }}
    </p>

    @foreach($adminLinks as $lnk)
        @if(Route::has($lnk['route']))
            @php
                $isActive = $currentRoute === $lnk['route'] || (isset($lnk['active_check']) && str_starts_with($currentRoute, $lnk['active_check']));
            @endphp
            <a href="{{ route($lnk['route']) }}"
               class="flex items-center px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group {{ $isActive ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                <svg class="w-4 h-4 mr-3 shrink-0 {{ $isActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $lnk['icon'] }}"/>
                </svg>
                <span>{{ __t($lnk['label_bn'], $lnk['label_en']) }}</span>
                @if($isActive)
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                @endif
            </a>
        @endif
    @endforeach

    <div class="pt-4 border-t border-slate-200/80 mt-4 space-y-1">
        <p class="px-3 pb-1 text-[10px] font-black uppercase tracking-wider text-slate-400">
            {{ __t('কুইক একসেস', 'Quick Access') }}
        </p>
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100/80 transition">
            <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>{{ __t('ক্যান্ডিডেট ড্যাশবোর্ড', 'Student Dashboard') }}</span>
        </a>
        <a href="{{ route('home') }}"
           class="flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100/80 transition">
            <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>{{ __t('মূল প্ল্যাটফর্ম', 'TargetOfficer Home') }}</span>
        </a>
    </div>
</nav>
