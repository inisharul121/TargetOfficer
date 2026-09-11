@extends('layouts.student-layout')

@section('title', $exam->title_bn . ' – ' . __t('জাতীয় মেধা তালিকা', 'National Merit List'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- Top Back & Title Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('live-exams.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>{{ __t('লাইভ পরীক্ষার তালিকায় ফিরুন', 'Back to Live Exams') }}</span>
            </a>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white flex items-center space-x-2.5">
                <span>🏆</span>
                <span>{{ $exam->title_bn }} — {{ __t('জাতীয় মেধা তালিকা', 'National Merit List') }}</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                মোট অংশগ্রহণকারী: <strong class="text-slate-700 dark:text-slate-200">{{ $totalParticipants }} জন</strong> • পূর্ণমান: {{ (int)$exam->total_marks }} • নেগেটিভ মার্কিং: ০.৫০
            </p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('export.exam', $exam->id) }}"
               class="px-4 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs hover:bg-slate-50 dark:hover:bg-slate-700 transition flex items-center space-x-1.5">
                <span>🖨️</span>
                <span>{{ __t('প্রশ্নপত্র প্রিন্ট / PDF', 'Print / PDF') }}</span>
            </a>
        </div>
    </div>

    {{-- User Rank Card if attempted --}}
    @if($userAttempt)
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-3xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/20 flex flex-col items-center justify-center font-black text-white shrink-0">
                    <span class="text-[10px] uppercase tracking-wider text-indigo-200">জাতীয় র‍্যাংক</span>
                    <span class="text-2xl leading-none">#{{ $userRank }}</span>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20 text-white border border-white/30">
                        আপনার অবস্থান
                    </span>
                    <h2 class="text-lg font-black mt-1">{{ auth()->user()->name }}</h2>
                    <p class="text-xs text-indigo-200">
                        স্কোর: <strong class="text-white">{{ $userAttempt->total_score }}</strong> • সঠিক: {{ $userAttempt->total_correct }}টি • ভুল: {{ $userAttempt->total_incorrect }}টি (-{{ $userAttempt->total_negative_marks }}) • নির্ভুলতা: {{ $userAttempt->accuracy_percentage }}%
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('exams.result', $userAttempt->id) }}"
                   class="px-5 py-2.5 rounded-xl bg-white text-indigo-700 font-black text-xs hover:bg-indigo-50 shadow-md transition">
                    ফলাফল ও সমাধান দেখুন →
                </a>
            </div>
        </div>
    @endif

    {{-- Search Filter & Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
        <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">
                চূড়ান্ত মেধা তালিকা (Top Rankers)
            </h2>
            <form method="GET" action="{{ route('live-exams.leaderboard', $exam->slug) }}" class="flex items-center space-x-2 w-full sm:w-72">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="পরীক্ষার্থীর নাম খুঁজুন..."
                       class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold focus:ring-2 focus:ring-indigo-500">
                <button type="submit" class="px-3 py-2 rounded-xl bg-slate-800 dark:bg-slate-700 text-white font-bold text-xs hover:bg-slate-900 transition">
                    সার্চ
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-5 text-center w-20">র‍্যাংক</th>
                        <th class="py-3.5 px-4">পরীক্ষার্থীর নাম</th>
                        <th class="py-3.5 px-4 text-center">স্কোর</th>
                        <th class="py-3.5 px-4 text-center">সঠিক / ভুল</th>
                        <th class="py-3.5 px-4 text-center">পেনাল্টি</th>
                        <th class="py-3.5 px-4 text-center">নির্ভুলতা</th>
                        <th class="py-3.5 px-5 text-right">ব্যয়িত সময়</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-200 font-semibold">
                    @forelse($allAttempts as $index => $attempt)
                        @php
                            $rankNumber = ($allAttempts->currentPage() - 1) * $allAttempts->perPage() + ($index + 1);
                            $isCurrentUser = auth()->check() && $attempt->user_id === auth()->id();
                        @endphp
                        <tr class="{{ $isCurrentUser ? 'bg-indigo-50/70 dark:bg-indigo-950/40 font-bold' : 'hover:bg-slate-50/80 dark:hover:bg-slate-800/40' }} transition">
                            <td class="py-3.5 px-5 text-center">
                                @if($rankNumber === 1)
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-400 font-black text-sm">🥇</span>
                                @elseif($rankNumber === 2)
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-black text-sm">🥈</span>
                                @elseif($rankNumber === 3)
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-500 font-black text-sm">🥉</span>
                                @else
                                    <span class="font-bold text-slate-400">#{{ $rankNumber }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-indigo-600/10 dark:bg-indigo-400/10 text-indigo-600 dark:text-indigo-400 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($attempt->user->name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-bold text-slate-900 dark:text-white truncate block">
                                            {{ $attempt->user->name ?? 'Unknown Candidate' }}
                                            @if($isCurrentUser)
                                                <span class="ml-1 px-1.5 py-0.2 text-[9px] rounded bg-indigo-600 text-white font-black">আপনি</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="font-black text-sm text-indigo-600 dark:text-indigo-400">{{ $attempt->total_score }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center text-xs">
                                <span class="text-emerald-600 font-bold">{{ $attempt->total_correct }}</span>
                                <span class="text-slate-300">/</span>
                                <span class="text-rose-600 font-bold">{{ $attempt->total_incorrect }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center text-rose-600 font-bold">
                                -{{ $attempt->total_negative_marks }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center space-x-1">
                                    <span class="font-bold">{{ $attempt->accuracy_percentage }}%</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-right font-mono text-slate-500 dark:text-slate-400">
                                {{ floor($attempt->time_taken_seconds / 60) }}:{{ str_pad($attempt->time_taken_seconds % 60, 2, '0', STR_PAD_LEFT) }} মি.
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                কোনো ফলাফল পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $allAttempts->links() }}
    </div>
</div>
@endsection
