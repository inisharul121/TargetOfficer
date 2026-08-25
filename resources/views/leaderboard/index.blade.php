@extends('layouts.app')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-100 px-3 py-1 rounded-full border border-amber-200">লিডারবোর্ড ও অর্জন</span>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">শীর্ষ ক্যান্ডিডেট র‍্যাংকিং</h1>
            <p class="text-xs sm:text-sm text-slate-500">নিয়মিত অনুশীলন ও মডেল টেস্টে নির্ভুল স্কোরের ভিত্তিতে জাতীয় পর্যায়ের মেধা তালিকা।</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Exam Performance Leaderboard -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl">🏆</span>
                            <h2 class="text-lg font-bold text-slate-900">মডেল টেস্ট টপ পারফরমার</h2>
                        </div>
                        <span class="text-xs font-semibold text-slate-400">সর্বমোট অর্জিত স্কোর</span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($examLeaders as $index => $lead)
                            <div class="py-3.5 flex items-center justify-between gap-4">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs shrink-0
                                        {{ $index === 0 ? 'bg-amber-400 text-slate-950 shadow-md' : ($index === 1 ? 'bg-slate-300 text-slate-900' : ($index === 2 ? 'bg-amber-700 text-white' : 'bg-slate-100 text-slate-600')) }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900">{{ $lead->name }}</h3>
                                        <div class="flex items-center space-x-2 text-[11px] text-slate-400">
                                            <span>{{ $lead->target_exam ?? 'BCS Aspirant' }}</span>
                                            <span>•</span>
                                            <span class="text-indigo-600 font-medium">{{ $lead->attempts_count }} পরীক্ষা</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="text-sm font-black text-indigo-600">{{ number_format($lead->total_exam_points, 1) }} স্কোর</div>
                                    <div class="text-[10px] text-slate-400 font-semibold">গড় নির্ভুলতা {{ number_format($lead->avg_accuracy, 0) }}%</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-400 text-xs font-semibold">
                                এখনও কোনো কমপ্লিট পরীক্ষার ডেটা নেই।
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Streak Leaders -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl">🔥</span>
                            <h2 class="text-lg font-bold text-slate-900">ধারাবাহিক স্টাডি স্ট্রাইক</h2>
                        </div>
                        <span class="text-xs font-semibold text-slate-400">টানা অধ্যবসায়</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($streakLeaders as $sIdx => $sLead)
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="flex items-center space-x-3 truncate">
                                    <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 font-bold text-xs flex items-center justify-center shrink-0">
                                        #{{ $sIdx + 1 }}
                                    </div>
                                    <div class="truncate">
                                        <div class="text-xs font-bold text-slate-800 truncate">{{ $sLead->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $sLead->coins }} কয়েন</div>
                                    </div>
                                </div>
                                <div class="text-xs font-black text-rose-600 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full shrink-0">
                                    🔥 {{ $sLead->daily_streak }} দিন
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Col: Badges & Rewards Showcase -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                        <span class="text-xl">🎖️</span>
                        <h2 class="text-base font-bold text-slate-900">প্ল্যাটফর্ম ব্যাজ ও মেডেল</h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($badges as $bdg)
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start space-x-3 group">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl shrink-0">
                                    ⭐
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition">{{ $bdg->name_bn }}</h3>
                                    <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">{{ $bdg->description_bn }}</p>
                                    <span class="inline-block mt-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                                        +{{ $bdg->reward_coins }} রিওয়ার্ড কয়েন
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
