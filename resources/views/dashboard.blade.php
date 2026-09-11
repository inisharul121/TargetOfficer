@extends('layouts.student-layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-up">
    
    {{-- ================================================================ --}}
    {{-- 1. HERO WELCOME BANNER                                           --}}
    {{-- ================================================================ --}}
    <div class="rounded-3xl p-6 sm:p-8 shadow-xs bg-white border border-slate-200">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    @if($user->target_exam)
                        <span class="px-3 py-1 rounded-full text-xs font-bold flex items-center space-x-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200">
                            <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                            <span>🎯 {{ __t('টার্গেট পরীক্ষা:', 'Target Exam:') }} {{ $user->target_exam }}</span>
                        </span>
                    @endif
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        🇧🇩 {{ __t('বিসিএস ও সরকারি চাকরি প্রস্তুতি হাব', 'Public Service Prep Hub') }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight text-slate-900">
                    {{ __t('স্বাগতম,', 'Welcome,') }}
                    <span class="text-indigo-600">{{ $user->name }}</span>!
                </h1>

                <p class="text-xs sm:text-sm max-w-2xl leading-relaxed text-slate-600">
                    {{ __t('বিসিএস, বাংলাদেশ ব্যাংক ও সরকারি চাকরির পরীক্ষা প্রস্তুতিতে আপনার দুর্বলতা শনাক্ত করুন এবং প্রশ্নকর্তা প্যাটার্ন অনুযায়ী অগ্রগতি বৃদ্ধি করুন।', 'Track your preparation, practice by setter patterns (BPSC/BUET/IBA), and turn mistakes into strengths.') }}
                </p>
            </div>

            {{-- Action Shortcuts --}}
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('exams.custom') }}" class="px-4 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs shadow-md shadow-amber-500/20 transition flex items-center space-x-1.5">
                    <span>⚡</span>
                    <span>{{ __t('কাস্টম পরীক্ষা', 'Custom Test') }}</span>
                </a>
                <a href="{{ route('student.progress') }}" class="px-4 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs shadow-md shadow-indigo-600/20 transition flex items-center space-x-1.5">
                    <span>📊</span>
                    <span>{{ __t('অগ্রগতি রিপোর্ট', 'Progress Report') }}</span>
                </a>
                <a href="{{ route('student.mistakes') }}" class="px-4 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs transition flex items-center space-x-1.5">
                    <span>🎯</span>
                    <span>{{ __t('ভুল ব্যাংক', 'Mistake Bank') }} ({{ $mistakeCount }})</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- 2. CORE METRICS GRID (4 STAT CARDS)                             --}}
    {{-- ================================================================ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        {{-- Total Exams --}}
        <div class="stat-card bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('মোট পরীক্ষা সম্পন্ন', 'Total Exams') }}</span>
                <div class="text-2xl sm:text-3xl font-black mt-1 text-slate-900">{{ $totalAttemptsCount }} {{ __t('টি', '') }}</div>
                <span class="text-[10px] font-bold text-emerald-600">✓ {{ $totalQuestionsAnswered }} {{ __t('প্রশ্ন সমাধান', 'questions solved') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-indigo-50 text-indigo-600 border border-indigo-100">📝</div>
        </div>

        {{-- Average Score --}}
        <div class="stat-card bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('গড় স্কোর', 'Average Score') }}</span>
                <div class="text-2xl sm:text-3xl font-black mt-1 text-indigo-600">{{ number_format($avgScore, 1) }}</div>
                <span class="text-[10px] font-bold text-slate-500">{{ __t('জাতীয় গড়ের উপরে', 'Above National Avg.') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-blue-50 text-blue-600 border border-blue-100">📊</div>
        </div>

        {{-- Accuracy --}}
        <div class="stat-card bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('নির্ভুলতার হার', 'Accuracy Rate') }}</span>
                <div class="text-2xl sm:text-3xl font-black mt-1 text-emerald-600">{{ number_format($avgAccuracy, 1) }}%</div>
                <span class="text-[10px] font-bold text-teal-600">{{ __t('টার্গেট: ৮০%+', 'Target: 80%+') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-emerald-50 text-emerald-600 border border-emerald-100">🎯</div>
        </div>

        {{-- Mistake Bank / Streak --}}
        <div class="stat-card bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('ভুল করা প্রশ্ন (রিভিশন)', 'Mistake Bank') }}</span>
                <div class="text-2xl sm:text-3xl font-black mt-1 text-rose-600">{{ $mistakeCount }} {{ __t('টি', '') }}</div>
                <a href="{{ route('student.mistakes') }}" class="text-[10px] font-bold text-rose-600 hover:underline">
                    ⚡ {{ __t('রিভিশন টেস্ট দিন →', 'Retake Mistakes →') }}
                </a>
            </div>
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-rose-50 text-rose-600 border border-rose-100">⚠️</div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- 2.5 SPECIAL FEATURE HUB (LIVE EXAM, ROUTINE, DUEL, FLASHCARDS)  --}}
    {{-- ================================================================ --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
        {{-- Live Exam Tile --}}
        <a href="{{ route('live-exams.index') }}"
           class="p-4 rounded-3xl bg-gradient-to-br from-rose-50 to-rose-100/60 dark:from-slate-900 dark:to-rose-950/30 border border-rose-200 dark:border-rose-900/40 hover:shadow-md transition group flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-2xl">🔴</span>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-rose-600 text-white animate-pulse">LIVE</span>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-rose-600 transition">লাইভ মডেল টেস্ট</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">জাতীয় মেধা তালিকা</p>
            </div>
        </a>

        {{-- 1v1 Battle Tile --}}
        <a href="{{ route('battle.index') }}"
           class="p-4 rounded-3xl bg-gradient-to-br from-orange-50 to-orange-100/60 dark:from-slate-900 dark:to-orange-950/30 border border-orange-200 dark:border-orange-900/40 hover:shadow-md transition group flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-2xl">⚔️</span>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-orange-500 text-white">NEW</span>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-orange-600 transition">১ বনাম ১ ব্যাটেল</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">কুইজ চ্যালেঞ্জ ও কয়েন</p>
            </div>
        </a>

        {{-- Study Routine Tile --}}
        <a href="{{ route('routine.index') }}"
           class="p-4 rounded-3xl bg-gradient-to-br from-emerald-50 to-emerald-100/60 dark:from-slate-900 dark:to-emerald-950/30 border border-emerald-200 dark:border-emerald-900/40 hover:shadow-md transition group flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-2xl">📅</span>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-emerald-600 text-white">রুটিন</span>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-emerald-600 transition">স্টাডি রুটিন</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">দৈনিক সিলেবাস চেকমার্ক</p>
            </div>
        </a>

        {{-- Flashcards Tile --}}
        <a href="{{ route('flashcards.index') }}"
           class="p-4 rounded-3xl bg-gradient-to-br from-purple-50 to-purple-100/60 dark:from-slate-900 dark:to-purple-950/30 border border-purple-200 dark:border-purple-900/40 hover:shadow-md transition group flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-2xl">🧠</span>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-purple-600 text-white">মুখস্থ</span>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-purple-600 transition">স্মার্ট ফ্ল্যাশ কার্ড</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">সংবিধান ও শব্দভাণ্ডার</p>
            </div>
        </a>

        {{-- Current Affairs Tile --}}
        <a href="{{ route('current-affairs.index') }}"
           class="p-4 rounded-3xl bg-gradient-to-br from-blue-50 to-blue-100/60 dark:from-slate-900 dark:to-blue-950/30 border border-blue-200 dark:border-blue-900/40 hover:shadow-md transition group flex flex-col justify-between space-y-3 col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between">
                <span class="text-2xl">📰</span>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-blue-600 text-white">দৈনিক</span>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition">সাম্প্রতিক তথ্য (GK)</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">মাসিক ও দৈনিক ক্যাপসুল</p>
            </div>
        </a>
    </div>

    {{-- ================================================================ --}}
    {{-- 3. EXAM TAKER (SETTER) BREAKDOWN (BPSC, BUET, IBA)              --}}
    {{-- ================================================================ --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center space-x-2">
                    <span class="text-indigo-600">🏛️</span>
                    <span>{{ __t('প্রশ্নকর্তা সংস্থা অনুযায়ী পারফরম্যান্স (Exam Taker / Setter Mastery)', 'Exam Taker / Setter Mastery') }}</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ __t('বিসিএস (BPSC), ব্যাংক রিক্রুটমেন্ট (BUET/IBA) ইত্যাদি প্যাটার্নে আপনার নির্ভুলতা।', 'Analyze your strengths across major examination conducting bodies.') }}</p>
            </div>
            <a href="{{ route('student.progress') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                {{ __t('পূর্ণাঙ্গ অ্যানালিটিক্স রিপোর্ট →', 'Full Analytics Report →') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($setterPerformances as $setp)
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-indigo-300 transition-all space-y-3 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-slate-900 flex items-center space-x-1.5">
                            <span>🏛️</span>
                            <span>{{ $setp->code ?: $setp->name_bn }}</span>
                        </span>
                        @if(!is_null($setp->user_accuracy))
                            <span class="text-xs font-black px-2 py-0.5 rounded-md border 
                                {{ $setp->user_accuracy >= 70 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($setp->user_accuracy >= 45 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                {{ $setp->user_accuracy }}%
                            </span>
                        @else
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">{{ __t('অংশ নেননি', 'Not Attempted') }}</span>
                        @endif
                    </div>

                    <div class="w-full h-2 rounded-full overflow-hidden bg-slate-200">
                        <div class="h-full rounded-full transition-all duration-500
                                    {{ ($setp->user_accuracy ?? 0) >= 70 ? 'bg-emerald-500' : (($setp->user_accuracy ?? 0) >= 45 ? 'bg-amber-500' : 'bg-rose-500') }}"
                             style="width: {{ max($setp->user_accuracy ?? 0, 4) }}%"></div>
                    </div>

                    <div class="flex items-center justify-between text-[11px] pt-1">
                        <span class="text-slate-500">{{ $setp->total_answered }} {{ __t('টি উত্তর দেওয়া হয়েছে', 'answered') }}</span>
                        <a href="{{ route('practice.index', ['setter' => $setp->slug]) }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                            {{ __t('অনুশীলন →', 'Practice →') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- 4. SUBJECT-WISE PERFORMANCE HEATMAP                            --}}
    {{-- ================================================================ --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center space-x-2">
                    <span class="text-indigo-600">📊</span>
                    <span>{{ __t('বিষয়ভিত্তিক পারফরম্যান্স ও দুর্বলতা অ্যানালিটিক্স', 'Subject-wise Performance & Weakness Analytics') }}</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ __t('আপনার সবল ও দুর্বল বিষয়গুলো চিহ্নিত করুন', 'Identify your strongest and weakest subjects to focus practice.') }}</p>
            </div>
            <a href="{{ route('practice.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                {{ __t('সব বিষয়ভিত্তিক রিডিং মোড →', 'Topic Reading Mode →') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($subjectPerformances as $sp)
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-indigo-200 transition-all space-y-3 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-900 flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $sp->color }}"></span>
                            <span class="truncate">{{ __t($sp->name_bn, $sp->name_en) }}</span>
                        </span>

                        @if(!is_null($sp->user_accuracy))
                            <span class="text-xs font-black px-2 py-0.5 rounded-md border 
                                {{ $sp->user_accuracy >= 70 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($sp->user_accuracy >= 45 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                {{ $sp->user_accuracy }}%
                            </span>
                        @else
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">{{ __t('অংশ নেননি', 'Not Attempted') }}</span>
                        @endif
                    </div>

                    <div class="w-full h-2 rounded-full overflow-hidden bg-slate-200">
                        <div class="h-full rounded-full transition-all duration-500
                                    {{ ($sp->user_accuracy ?? 0) >= 70 ? 'bg-emerald-500' : (($sp->user_accuracy ?? 0) >= 45 ? 'bg-amber-500' : 'bg-rose-500') }}"
                             style="width: {{ max($sp->user_accuracy ?? 0, 4) }}%"></div>
                    </div>

                    <div class="flex items-center justify-between text-[11px] pt-1">
                        <span class="text-slate-500">{{ $sp->total_answered }} {{ __t('টি উত্তর দেওয়া হয়েছে', 'answered') }}</span>
                        <a href="{{ route('practice.index', ['subject' => $sp->slug]) }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                            {{ __t('অনুশীলন করুন →', 'Practice →') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- 5. PAST-YEAR BCS ARCHIVES TRACKER                               --}}
    {{-- ================================================================ --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center space-x-2">
                    <span class="text-amber-500">🎓</span>
                    <span>{{ __t('বিসিএস বিগত সালের পরীক্ষা স্থিতি (BCS Archives)', 'BCS Past-Year Exam Archives') }}</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ __t('১০ম ও ১১তম বিসিএস পরীক্ষার প্রশ্ন সমাধান পড়ুন অথবা পূর্ণাঙ্গ ১০০ নম্বরের পরীক্ষা দিন।', 'Take real 100-mark simulations or study answers in reading mode.') }}</p>
            </div>
            <a href="{{ route('exams.index', ['mode' => 'previous_year']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                {{ __t('সকল আর্কাইভ পরীক্ষা →', 'All Archives →') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($bcsArchives as $bcs)
                <div class="p-5 rounded-2xl border {{ $bcs->is_completed ? 'border-emerald-300 bg-emerald-50/20' : 'border-slate-200 bg-slate-50/40' }} flex flex-col justify-between space-y-4 shadow-2xs">
                    <div class="flex items-start justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded uppercase {{ $bcs->is_completed ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                {{ $bcs->is_completed ? '✓ টেস্ট সম্পন্ন' : 'অসম্পন্ন' }}
                            </span>
                            <h3 class="text-sm font-extrabold text-slate-900 mt-1">
                                {{ $bcs->title_bn }}
                            </h3>
                        </div>
                        <span class="text-2xl">{{ $bcs->is_completed ? '🏆' : '📝' }}</span>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-100 pt-3 text-xs">
                        <span class="text-slate-500 font-medium">১০০ প্রশ্ন • ৬০ মিনিট</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('practice.index', ['exam' => $bcs->slug]) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-bold hover:bg-slate-100 transition">
                                {{ __t('রিডিং মোড', 'Read') }}
                            </a>
                            <a href="{{ route('exams.show', $bcs->slug) }}" class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition">
                                {{ $bcs->is_completed ? __t('পুনরায় পরীক্ষা', 'Retake') : __t('পরীক্ষা দিন', 'Start Exam') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- 6. RECENT EXAMS & BADGES                                         --}}
    {{-- ================================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- Left: Recent Exams (2 cols) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 animate-pulse"></span>
                    <h2 class="text-base sm:text-lg font-black text-slate-900">{{ __t('সাম্প্রতিক পরীক্ষার ফলাফল ও রিপোর্ট', 'Recent Exam Results & Reports') }}</h2>
                </div>
                <a href="{{ route('exams.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                    {{ __t('নতুন মডেল টেস্ট', 'New Model Test') }}
                </a>
            </div>

            @if($recentAttempts->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($recentAttempts as $attempt)
                        <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/60 p-2 rounded-2xl transition">
                            <div class="space-y-1.5">
                                <div class="flex items-center space-x-2">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                        {{ $attempt->exam->exam_mode }}
                                    </span>
                                    <h3 class="text-sm font-bold text-slate-900 leading-snug">
                                        {{ __t($attempt->exam->title_bn, $attempt->exam->title_en ?? $attempt->exam->title_bn) }}
                                    </h3>
                                </div>
                                <div class="flex items-center space-x-4 text-xs text-slate-500 font-medium">
                                    <span>📅 {{ $attempt->created_at->format('d M, Y h:i A') }}</span>
                                    <span>⏱️ {{ floor($attempt->time_taken_seconds / 60) }}{{ __t('মি', 'm') }} {{ $attempt->time_taken_seconds % 60 }}{{ __t('সে', 's') }}</span>
                                    @if($attempt->tab_switch_count > 0)
                                        <span class="font-bold text-amber-600">⚠️ {{ $attempt->tab_switch_count }} {{ __t('বার ট্যাব সুইচ', 'Tab Switches') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 shrink-0">
                                <div class="text-right">
                                    <div class="text-base font-black {{ $attempt->total_score >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ number_format($attempt->total_score, 2) }}
                                    </div>
                                    <div class="text-[10px] font-bold text-slate-400">{{ __t('নির্ভুলতা', 'Accuracy') }} {{ number_format($attempt->accuracy_percentage, 0) }}%</div>
                                </div>
                                <a href="{{ route('exams.result', $attempt->id) }}" class="btn-steel px-3.5 py-2 text-xs">
                                    {{ __t('রিপোর্ট ও সমাধান', 'Report & Solution') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto text-xl mb-3 bg-indigo-50 text-indigo-600">📋</div>
                    <p class="text-sm font-bold text-slate-800">{{ __t('আপনি এখনও কোনো পরীক্ষায় অংশ নেননি', 'You have not taken any exams yet') }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ __t('প্রথম মডেল টেস্ট দিয়ে আপনার অবস্থান মূল্যায়ন করুন!', 'Take a test to evaluate your national standing!') }}</p>
                    <a href="{{ route('exams.index') }}" class="btn-primary inline-block mt-4 text-xs">
                        {{ __t('মডেল টেস্ট শুরু করুন', 'Start Model Test') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Right: Earned Badges & Shortcuts --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-base font-black text-slate-900 flex items-center space-x-2">
                        <span>🎖️</span>
                        <span>{{ __t('অর্জিত ব্যাজ', 'Earned Badges') }}</span>
                    </h2>
                    <a href="{{ route('leaderboard.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                        {{ __t('মেধা তালিকা', 'Leaderboard') }}
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($user->badges as $badge)
                        <div class="flex items-center space-x-3 p-3 rounded-2xl bg-amber-50/60 border border-amber-200/70">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl shrink-0 bg-white border border-amber-200 shadow-2xs">🎖️</div>
                            <div>
                                <div class="text-xs font-bold text-slate-900">{{ __t($badge->name_bn, $badge->name_en) }}</div>
                                <div class="text-[10px] text-slate-500">{{ __t($badge->description_bn, $badge->description_en ?? $badge->description_bn) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50">
                            <span class="text-2xl">🏆</span>
                            <p class="text-xs font-bold text-slate-800 mt-2">{{ __t('পরীক্ষা সম্পন্ন করুন!', 'Complete exams!') }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ __t('মডেল টেস্টের সাথে আনলক হবে বিশেষ ব্যাজ।', 'Unlock badges as you practice.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
