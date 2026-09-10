@extends('layouts.app')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200">{{ __t('লিডারবোর্ড ও অর্জন', 'Leaderboard & Achievements') }}</span>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ __t('শীর্ষ ক্যান্ডিডেট র‍্যাংকিং (Multi-Tier)', 'Top Candidate Rankings (Multi-Tier)') }}</h1>
            <p class="text-xs sm:text-sm text-slate-500">{{ __t('সার্বিক মেধা তালিকা, সংস্থাভিত্তিক (BUET, IBA, BPSC) পারফরম্যান্স ও অধ্যবসায়ের স্বীকৃতি।', 'Overall merit list, organization-based performance (BUET, IBA, BPSC), and streak recognition.') }}</p>
        </div>

        <!-- Tier Switcher Navigation -->
        <div class="flex flex-wrap items-center justify-center gap-2">
            <a href="{{ route('leaderboard.index', ['tab' => 'global']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab === 'global' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                🌐 {{ __t('জাতীয় মেধা তালিকা (Global)', 'National Merit List (Global)') }}
            </a>
            <a href="{{ route('leaderboard.index', ['tab' => 'org', 'org_id' => $organizations->first()?->id]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab === 'org' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                🏛️ {{ __t('সংস্থাভিত্তিক র‍্যাংকিং (By Setter)', 'Rankings By Setter Body') }}
            </a>
            <a href="{{ route('leaderboard.index', ['tab' => 'streaks']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab === 'streaks' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                🔥 {{ __t('স্টাডি স্ট্রাইক হল অব ফেম', 'Study Streak Hall of Fame') }}
            </a>
        </div>

        <!-- Organization Selector Filter (When tab is org) -->
        @if($tab === 'org')
            <div class="flex flex-wrap items-center justify-center gap-2 bg-white p-3 rounded-2xl border border-slate-200 shadow-2xs max-w-xl mx-auto">
                <span class="text-xs font-bold text-slate-400 mr-1">{{ __t('সংস্থা সিলেক্ট করুন:', 'Select Setter Body:') }}</span>
                @foreach($organizations as $org)
                    <a href="{{ route('leaderboard.index', ['tab' => 'org', 'org_id' => $org->id]) }}" class="px-3 py-1 rounded-lg text-xs font-bold transition {{ $orgId == $org->id ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ $org->code }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Leaderboard Table -->
            <div class="lg:col-span-2 space-y-6">
                
                @if($tab !== 'streaks')
                    <!-- Exam Score Leaders -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-xl">🏆</span>
                                <h2 class="text-lg font-bold text-slate-900">
                                    {{ $tab === 'org' ? __t('সংস্থাভিত্তিক টপ পারফরমার', 'Setter Body Top Performers') : __t('মডেল টেস্ট টপ পারফরমার', 'Model Test Top Performers') }}
                                </h2>
                            </div>
                            <span class="text-xs font-semibold text-slate-400">{{ __t('অর্জিত স্কোর ও নির্ভুলতা', 'Score & Accuracy') }}</span>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @forelse($examLeaders as $index => $lead)
                                <div class="py-3.5 flex items-center justify-between gap-4">
                                    <div class="flex items-center space-x-3.5">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs shrink-0
                                            {{ $index === 0 ? 'bg-amber-500 text-white shadow-xs' : ($index === 1 ? 'bg-slate-400 text-white' : ($index === 2 ? 'bg-amber-700 text-white' : 'bg-slate-100 text-slate-600')) }}">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-900">{{ $lead->name }}</h3>
                                            <div class="flex items-center space-x-2 text-[11px] text-slate-400">
                                                <span>{{ $lead->target_exam ?? 'BCS Aspirant' }}</span>
                                                <span>•</span>
                                                <span class="text-slate-500 font-medium">{{ $lead->attempts_count }} {{ __t('টি পরীক্ষা', 'exams taken') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <div class="text-sm font-black text-indigo-600">{{ number_format($lead->total_exam_points, 1) }} {{ __t('স্কোর', 'Pts') }}</div>
                                        <div class="text-[10px] text-slate-400 font-semibold">{{ __t('গড় নির্ভুলতা', 'Avg Accuracy') }} {{ number_format($lead->avg_accuracy, 0) }}%</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-slate-400 text-xs font-semibold">
                                    {{ __t('এই বিভাগে এখনও কোনো কমপ্লিট পরীক্ষার ডেটা নেই।', 'No completed exam data in this category yet.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                @else
                    <!-- Streaks Hall of Fame -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-xl">🔥</span>
                                <h2 class="text-lg font-bold text-slate-900">{{ __t('ধারাবাহিক স্টাডি স্ট্রাইক হল অব ফেম', 'Study Streak Hall of Fame') }}</h2>
                            </div>
                            <span class="text-xs font-semibold text-slate-400">{{ __t('টানা অনুশীলনের স্বীকৃতি', 'Daily Streak Recognition') }}</span>
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
                                            <div class="text-[10px] text-slate-400">{{ $sLead->coins }} {{ __t('কয়েন', 'Coins') }}</div>
                                        </div>
                                    </div>
                                    <div class="text-xs font-black text-rose-600 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full shrink-0">
                                        🔥 {{ $sLead->daily_streak }} {{ __t('দিন', 'Days') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Col: Badges & Rewards Showcase -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                        <span class="text-xl">🎖️</span>
                        <h2 class="text-base font-bold text-slate-900">{{ __t('প্ল্যাটফর্ম ব্যাজ ও মেডেল', 'Platform Badges & Medals') }}</h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($badges as $bdg)
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start space-x-3 group">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center text-xl shrink-0">
                                    ⭐
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition">{{ __t($bdg->name_bn, $bdg->name_en) }}</h3>
                                    <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">{{ __t($bdg->description_bn, $bdg->description_en ?? $bdg->description_bn) }}</p>
                                    <span class="inline-block mt-1 text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded">
                                        +{{ $bdg->reward_coins }} {{ __t('রিওয়ার্ড কয়েন', 'Reward Coins') }}
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
