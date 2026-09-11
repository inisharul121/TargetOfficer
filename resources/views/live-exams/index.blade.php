@extends('layouts.student-layout')

@section('title', __t('লাইভ মডেল টেস্ট – TargetOfficer', 'Live Model Tests – TargetOfficer'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs font-black uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                    <span>{{ __t('জাতীয় লাইভ মডেল টেস্ট হাব', 'National Live Test Hub') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    {{ __t('সারাদেশের পরীক্ষার্থীদের সাথে রিয়েল-টাইম প্রতিযোগিতা', 'Real-Time Synchronized Competition Across Bangladesh') }}
                </h1>
                <p class="text-sm text-indigo-200/90 leading-relaxed">
                    {{ __t('রুটিন অনুযায়ী প্রতিদিন নির্ধারিত সময়ে শুরু হওয়া লাইভ মডেল টেস্টে অংশ নিন। নেগেটিভ মার্কিং সহ পরীক্ষা শেষে স্বয়ংক্রিয়ভাবে প্রকাশিত হবে আপনার জাতীয় র‍্যাংক ও মেরিট লিস্ট।', 'Compete with thousands of candidates simultaneously. Accurate negative marking, national percentile, and automated merit ranking.') }}
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                <a href="{{ route('exams.custom') }}"
                   class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs text-center backdrop-blur-xs transition">
                    ⚡ {{ __t('নিজস্ব কাস্টম টেস্ট', 'Custom Test') }}
                </a>
            </div>
        </div>
        {{-- Background decorative shapes --}}
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-16 w-56 h-56 rounded-full bg-rose-500/15 blur-2xl pointer-events-none"></div>
    </div>

    {{-- 1. Active & Upcoming Live Model Tests --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                <span>{{ __t('আজকের ও আসন্ন লাইভ পরীক্ষাসমূহ', 'Active & Upcoming Live Exams') }}</span>
            </h2>
            <span class="text-xs font-bold text-slate-400">মোট {{ $liveExams->count() }}টি পরীক্ষা</span>
        </div>

        @if($liveExams->isEmpty())
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 text-center border border-slate-200 dark:border-slate-800 shadow-xs">
                <p class="text-slate-500 text-sm font-semibold">বর্তমানে কোনো শিডিউলড লাইভ পরীক্ষা নেই। পরবর্তী পরীক্ষার শিডিউল শীঘ্রই প্রকাশ করা হবে।</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($liveExams as $exam)
                    @php
                        $isLiveNow = $exam->scheduled_start_at && $exam->scheduled_end_at && now()->between($exam->scheduled_start_at, $exam->scheduled_end_at);
                        $isUpcoming = $exam->scheduled_start_at && now()->lt($exam->scheduled_start_at);
                        $hasAttempted = isset($myAttemptIds[$exam->id]);
                    @endphp
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border transition shadow-xs hover:shadow-md
                                {{ $isLiveNow ? 'border-rose-300 dark:border-rose-900/60 ring-2 ring-rose-500/10' : 'border-slate-200 dark:border-slate-800' }}">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="space-y-1">
                                <div class="flex items-center space-x-2">
                                    @if($isLiveNow)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 animate-pulse">
                                            🔴 {{ __t('লাইভ চলছে', 'Live Now') }}
                                        </span>
                                    @elseif($isUpcoming)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                            ⏳ {{ __t('আসন্ন শিডিউল', 'Upcoming') }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                            ⚡ {{ __t('ওপেন টেস্ট', 'Open') }}
                                        </span>
                                    @endif

                                    @if($hasAttempted)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            ✓ {{ __t('অংশগ্রহণ সম্পন্ন', 'Completed') }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-base font-black text-slate-900 dark:text-white group-hover:text-indigo-600 transition pt-1">
                                    {{ $exam->title_bn }}
                                </h3>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-5">
                            {{ $exam->description_bn }}
                        </p>

                        {{-- Metadata grid --}}
                        <div class="grid grid-cols-3 gap-2 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 text-center mb-5 text-xs font-semibold">
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase">প্রশ্ন</span>
                                <span class="text-slate-800 dark:text-slate-200 font-black">{{ $exam->questions_count }}টি</span>
                            </div>
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase">সময়</span>
                                <span class="text-slate-800 dark:text-slate-200 font-black">{{ $exam->duration_minutes }} মি.</span>
                            </div>
                            <div>
                                <span class="block text-[10px] text-slate-400 font-bold uppercase">নেগেটিভ</span>
                                <span class="text-rose-600 dark:text-rose-400 font-black">-{{ $exam->negative_mark_per_question }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-between gap-3 pt-2">
                            <a href="{{ route('live-exams.leaderboard', $exam->slug) }}"
                               class="flex items-center space-x-1.5 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-bold transition">
                                <span>🏆</span>
                                <span>{{ __t('মেধা তালিকা', 'Merit List') }}</span>
                            </a>

                            @if($hasAttempted)
                                <a href="{{ route('exams.result', $myAttemptIds[$exam->id]) }}"
                                   class="flex-1 text-center px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition">
                                    {{ __t('ফলাফল ও সমাধান', 'Result & Solution') }}
                                </a>
                            @elseif($isUpcoming)
                                <button disabled
                                        class="flex-1 text-center px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 text-xs font-bold cursor-not-allowed">
                                    {{ $exam->scheduled_start_at ? $exam->scheduled_start_at->format('h:i A, d M') : 'আসন্ন' }}
                                </button>
                            @else
                                <a href="{{ route('exams.room', $exam->slug) }}"
                                   class="flex-1 text-center px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition flex items-center justify-center space-x-1.5">
                                    <span>🔴</span>
                                    <span>{{ __t('পরীক্ষা শুরু করুন', 'Start Exam') }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- 2. Past Live Model Tests & National Merit Archives --}}
    <div class="space-y-4 pt-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-900 dark:text-white">
                    {{ __t('সম্পন্ন হওয়া লাইভ পরীক্ষার জাতীয় মেধা তালিকা', 'Past Live Exams & National Merit Archive') }}
                </h2>
                <p class="text-xs text-slate-400">বিগত জাতীয় পরীক্ষার র‍্যাঙ্কিং ও বিস্তারিত বিশ্লেষণ</p>
            </div>
        </div>

        @if($pastExams->isEmpty())
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 text-center border border-slate-200 dark:border-slate-800 shadow-xs">
                <p class="text-slate-500 text-xs font-semibold">কোনো অতীত লাইভ পরীক্ষার রেকর্ড নেই।</p>
            </div>
        @else
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200 dark:border-slate-800">
                            <tr>
                                <th class="py-3.5 px-5">পরীক্ষার নাম</th>
                                <th class="py-3.5 px-4">তারিখ</th>
                                <th class="py-3.5 px-4 text-center">অংশগ্রহণকারী</th>
                                <th class="py-3.5 px-4 text-center">পূর্ণমান</th>
                                <th class="py-3.5 px-5 text-right">মেধা তালিকা ও অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-200 font-semibold">
                            @foreach($pastExams as $pExam)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-4 px-5">
                                        <div class="font-black text-slate-900 dark:text-white">{{ $pExam->title_bn }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $pExam->questions_count }}টি প্রশ্ন • {{ $pExam->duration_minutes }} মিনিট</div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                        {{ $pExam->scheduled_start_at ? $pExam->scheduled_start_at->format('d M, Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2.5 py-1 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 font-bold text-xs">
                                            {{ $pExam->attempts_count }} জন
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center font-bold">
                                        {{ (int)$pExam->total_marks }} নম্বর
                                    </td>
                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('live-exams.leaderboard', $pExam->slug) }}"
                                               class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition">
                                                🏆 মেধা তালিকা
                                            </a>
                                            <a href="{{ route('export.exam', $pExam->id) }}"
                                               class="px-2.5 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-xs transition"
                                               title="প্রশ্নপত্র প্রিন্ট বা PDF ডাউনলোড">
                                                🖨️ PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pt-2">
                {{ $pastExams->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
