@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Welcome Hero Banner -->
        <div class="rounded-3xl bg-gradient-to-r from-indigo-900 via-indigo-800 to-slate-900 text-white p-6 sm:p-8 shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/30 text-indigo-200 text-xs font-semibold mb-3 border border-indigo-400/30">
                        <span>🎯 টার্গেট:</span>
                        <span class="font-bold text-white">{{ $user->target_exam ?? '৪৭তম বিসিএস প্রিলিমিনারি' }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white">স্বাগতম, {{ $user->name }}!</h1>
                    <p class="text-sm text-indigo-200 mt-1 max-w-xl">আজকের নির্ধারিত দৈনিক রিভিশন ও মডেল টেস্ট সম্পন্ন করে আপনার স্টাডি স্ট্রাইক ধরে রাখুন।</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('exams.custom') }}" class="px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-sm shadow-md transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>কাস্টম টেস্ট বানান</span>
                    </a>
                    <a href="{{ route('exams.index') }}" class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm shadow-md transition">
                        মডেল টেস্ট ব্রাউজ
                    </a>
                </div>
            </div>
        </div>

        <!-- 4-Stat Metric Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">মোট পরীক্ষা</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $totalAttemptsCount }} টি</div>
                    <span class="text-[11px] text-slate-500 font-medium">কমপ্লিট প্রচেষ্টা</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">📝</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">গড় স্কোর</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-indigo-600 mt-1">{{ number_format($avgScore, 1) }}</div>
                    <span class="text-[11px] text-slate-500 font-medium">সর্বশেষ পরীক্ষাসমূহ</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">📊</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">নির্ভুলতার হার</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($avgAccuracy, 1) }}%</div>
                    <span class="text-[11px] text-slate-500 font-medium">সঠিক উত্তর অনুপাত</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">🎯</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">স্টাডি স্ট্রাইক</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-rose-600 mt-1">{{ $user->daily_streak }} দিন 🔥</div>
                    <span class="text-[11px] text-slate-500 font-medium">সর্বোচ্চ: {{ $user->longest_streak }} দিন</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl font-bold">🔥</div>
            </div>
        </div>

        <!-- 2 Column Layout: Recent Attempts & Recommended Exams -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Recent Attempts -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            <h2 class="text-lg font-bold text-slate-900">সাম্প্রতিক পরীক্ষার ফলাফল</h2>
                        </div>
                        <a href="{{ route('exams.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">নতুন পরীক্ষা দিন</a>
                    </div>

                    @if($recentAttempts->count() > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach($recentAttempts as $attempt)
                                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-600 uppercase">{{ $attempt->exam->exam_mode }}</span>
                                            <h3 class="text-sm font-bold text-slate-900">{{ $attempt->exam->title_bn }}</h3>
                                        </div>
                                        <div class="flex items-center space-x-4 text-xs text-slate-400">
                                            <span>📅 {{ $attempt->created_at->format('d M, Y h:i A') }}</span>
                                            <span>⏱️ {{ floor($attempt->time_taken_seconds / 60) }}মি {{ $attempt->time_taken_seconds % 60 }}সে</span>
                                            @if($attempt->tab_switch_count > 0)
                                                <span class="text-amber-600 font-semibold">⚠️ {{ $attempt->tab_switch_count }} বার ট্যাব সুইচ</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <div class="text-right">
                                            <div class="text-sm font-black {{ $attempt->total_score >= 0 ? 'text-indigo-600' : 'text-rose-600' }}">
                                                {{ number_format($attempt->total_score, 2) }}
                                            </div>
                                            <div class="text-[10px] font-bold text-slate-400">নির্ভুলতা {{ number_format($attempt->accuracy_percentage, 0) }}%</div>
                                        </div>
                                        <a href="{{ route('exams.result', $attempt->id) }}" class="px-3 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition">
                                            রিপোর্ট
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl mb-3">📋</div>
                            <p class="text-sm font-bold text-slate-700">আপনি এখনও কোনো পরীক্ষায় অংশ নেননি</p>
                            <p class="text-xs text-slate-400 mt-1">প্রথম মডেল টেস্ট দিয়ে আপনার প্রস্তুতি যাচাই করুন!</p>
                            <a href="{{ route('exams.index') }}" class="inline-block mt-4 px-4 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-xs">মডেল টেস্ট শুরু করুন</a>
                        </div>
                    @endif
                </div>

                <!-- Subjects Quick Practice -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-900">বিষয়ভিত্তিক দ্রুত অনুশীলন</h2>
                        <a href="{{ route('practice.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">সব বিষয় দেখুন</a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($subjects as $subj)
                            <a href="{{ route('practice.index', ['subject' => $subj->slug]) }}" class="p-3 rounded-xl border border-slate-100 hover:border-indigo-300 hover:bg-indigo-50/30 transition flex items-center space-x-3 group">
                                <div class="w-8 h-8 rounded-lg text-white font-black text-xs flex items-center justify-center shrink-0" style="background-color: {{ $subj->color }}">
                                    {{ mb_substr($subj->name_bn, 0, 1) }}
                                </div>
                                <div class="truncate">
                                    <div class="text-xs font-bold text-slate-800 group-hover:text-indigo-600 truncate">{{ $subj->name_bn }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $subj->questions_count }} টি প্রশ্ন</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Col: Badges & Recommended Exams -->
            <div class="space-y-6">
                <!-- Badges Showcase -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-bold text-slate-900">অর্জিত ব্যাজ ও মেডেল</h2>
                        <a href="{{ route('leaderboard.index') }}" class="text-xs font-bold text-indigo-600">লিডারবোর্ড</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($user->badges as $badge)
                            <div class="flex items-center space-x-3 p-2.5 rounded-xl bg-amber-50/60 border border-amber-200/70">
                                <div class="w-10 h-10 rounded-xl bg-amber-400 text-slate-900 font-bold flex items-center justify-center text-lg shrink-0 shadow-xs">
                                    🎖️
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">{{ $badge->name_bn }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $badge->description_bn }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <span class="text-2xl">🏆</span>
                                <p class="text-xs font-bold text-slate-700 mt-2">প্রথম মডেল টেস্ট দিন!</p>
                                <p class="text-[10px] text-slate-400">পরীক্ষা সম্পন্ন করলে আনলক হবে বিশেষ ব্যাজ।</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recommended Exams -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                    <h2 class="text-base font-bold text-slate-900 mb-4">সুপারিশকৃত মডেল টেস্ট</h2>
                    <div class="space-y-3">
                        @foreach($recommendedExams as $rExam)
                            <a href="{{ route('exams.show', $rExam->slug) }}" class="block p-3 rounded-2xl bg-slate-50 hover:bg-indigo-50/60 border border-slate-100 hover:border-indigo-200 transition group">
                                <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 mb-1">
                                    <span>{{ $rExam->total_questions }} প্রশ্ন</span>
                                    <span>{{ $rExam->duration_minutes > 0 ? $rExam->duration_minutes . ' মিনিট' : 'আনলিমিটেড' }}</span>
                                </div>
                                <h3 class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 line-clamp-2">{{ $rExam->title_bn }}</h3>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
