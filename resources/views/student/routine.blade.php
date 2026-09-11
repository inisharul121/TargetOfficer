@extends('layouts.student-layout')

@section('title', __t('সাপ্তাহিক স্টাডি রুটিন ও সিলেবাস – TargetOfficer', 'Weekly Study Routine – TargetOfficer'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto" x-data="routineManager()">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-800 via-teal-800 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-black uppercase tracking-wider">
                    <span>📅</span>
                    <span>{{ __t('বিসিএস ও সরকারি চাকরি স্টাডি প্ল্যানার', 'BCS & Govt Job Weekly Planner') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    {{ __t('সাপ্তাহিক সিলেবাস ট্র্যাকার ও ডেইলি টার্গেট', 'Weekly Syllabus Tracker & Daily Targets') }}
                </h1>
                <p class="text-sm text-emerald-100/90 leading-relaxed">
                    {{ __t('প্রতিদিনের নির্দিষ্ট বিষয়ভিত্তিক সিলেবাস শেষ করে চেকমার্ক দিন। ধারাবাহিক অনুশীলনে প্রতিটি টপিক শেষ করলে পাবেন বোনাস রিওয়ার্ড কয়েন।', 'Structured Monday-Sunday syllabus. Check off topics as you study, earn daily coins, and stay ahead.') }}
                </p>
            </div>
            
            {{-- Weekly Completion Card --}}
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 text-center min-w-[200px] shrink-0">
                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-200 block mb-1">চলতি সপ্তাহের অগ্রগতি</span>
                <div class="text-3xl font-black text-white" x-text="completionRate + '%'">{{ $completionPercentage }}%</div>
                <div class="w-full bg-white/20 rounded-full h-2 mt-2.5 overflow-hidden">
                    <div class="bg-emerald-400 h-full rounded-full transition-all duration-500" :style="'width: ' + completionRate + '%'"></div>
                </div>
                <span class="text-[11px] text-emerald-200 mt-2 block font-semibold">
                    <span x-text="completedCount">{{ $completedCount }}</span> / {{ $totalRoutines }} টপিক সম্পন্ন
                </span>
            </div>
        </div>
        {{-- Decorative background glow --}}
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>
    </div>

    {{-- Routine Days List --}}
    <div class="space-y-4">
        @foreach($routines as $routine)
            @php
                $isToday = $routine->day_of_week === (int)$todayDayOfWeek;
                $isCompleted = in_array($routine->id, $completedRoutineIds);
            @endphp
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-5 sm:p-6 border transition shadow-xs hover:shadow-md
                        {{ $isToday ? 'border-emerald-300 dark:border-emerald-800 ring-2 ring-emerald-500/10' : 'border-slate-200 dark:border-slate-800' }}">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    {{-- Left: Checkbox + Topic Details --}}
                    <div class="flex items-start space-x-4">
                        <button @click="toggleTopic({{ $routine->id }})"
                                class="w-8 h-8 rounded-xl border-2 flex items-center justify-center transition shrink-0 mt-0.5"
                                :class="completedIds.includes({{ $routine->id }}) 
                                    ? 'bg-emerald-600 border-emerald-600 text-white' 
                                    : 'border-slate-300 dark:border-slate-600 hover:border-emerald-500 text-transparent'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </button>

                        <div class="space-y-1 min-w-0">
                            <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider
                                             {{ $isToday ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 font-bold' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                                    {{ $routine->day_name_bn }}
                                    @if($isToday)
                                        (আজ)
                                    @endif
                                </span>

                                @if($routine->subject)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/40">
                                        {{ $routine->subject->name_bn }}
                                    </span>
                                @endif

                                <span class="text-[11px] text-slate-400 font-semibold flex items-center space-x-1">
                                    <span>⏱️ {{ $routine->target_minutes }} মিনিট</span>
                                    <span>•</span>
                                    <span>🎯 {{ $routine->target_questions }}টি প্রশ্ন</span>
                                </span>
                            </div>

                            <h3 class="text-base font-black text-slate-900 dark:text-white"
                                :class="completedIds.includes({{ $routine->id }}) ? 'line-through text-slate-400 dark:text-slate-500' : ''">
                                {{ $routine->topic_title_bn }}
                            </h3>

                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed pt-0.5">
                                {{ $routine->syllabus_details_bn }}
                            </p>
                        </div>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center space-x-2 shrink-0 sm:self-center pl-12 sm:pl-0">
                        @if($routine->subject_id)
                            <a href="{{ route('question-bank.index', ['subject' => $routine->subject_id]) }}"
                               class="px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition flex items-center space-x-1.5">
                                <span>📖</span>
                                <span>{{ __t('প্রশ্নব্যাংক', 'Questions') }}</span>
                            </a>
                        @endif

                        <a href="{{ route('exams.custom', ['subject_id' => $routine->subject_id]) }}"
                           class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition flex items-center space-x-1.5">
                            <span>⚡</span>
                            <span>{{ __t('অনুশীলন শুরু', 'Practice') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
function routineManager() {
    return {
        completedIds: @json($completedRoutineIds),
        totalRoutines: {{ $totalRoutines }},
        get completedCount() {
            return this.completedIds.length;
        },
        get completionRate() {
            return this.totalRoutines > 0 ? Math.round((this.completedCount / this.totalRoutines) * 100) : 0;
        },
        async toggleTopic(routineId) {
            try {
                const response = await fetch(`/routine/${routineId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    if (data.completed) {
                        if (!this.completedIds.includes(routineId)) {
                            this.completedIds.push(routineId);
                        }
                    } else {
                        this.completedIds = this.completedIds.filter(id => id !== routineId);
                    }
                }
            } catch (err) {
                console.error(err);
            }
        }
    };
}
</script>
@endpush
@endsection
