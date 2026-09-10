@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" x-data x-init="
    @if($attempt->total_score > 0)
        setTimeout(() => {
            if (window.confetti) {
                window.confetti({ particleCount: 80, spread: 70, origin: { y: 0.6 } });
            }
        }, 300);
    @endif
    $nextTick(() => {
        document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
    });
">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Scorecard Header Banner -->
        <div class="rounded-3xl bg-white text-slate-900 p-6 sm:p-10 shadow-xs border border-slate-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase">
                        {{ __t('পরীক্ষার অফিসিয়াল ফলাফল', 'Official Exam Result Scorecard') }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900">{{ __t($attempt->exam->title_bn, $attempt->exam->title_en ?? $attempt->exam->title_bn) }}</h1>
                    <p class="text-xs sm:text-sm text-slate-500">
                        {{ __t('সম্পন্ন হয়েছে:', 'Completed at:') }} {{ $attempt->completed_at ? $attempt->completed_at->format('d M, Y h:i A') : $attempt->updated_at->format('d M, Y') }}
                    </p>
                </div>

                <!-- Big Score Badge -->
                <div class="flex items-center space-x-4 bg-indigo-50 p-4 sm:p-5 rounded-2xl border border-indigo-200">
                    <div class="text-right">
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __t('প্রাপ্ত মোট স্কোর', 'Total Score Achieved') }}</div>
                        <div class="text-3xl sm:text-4xl font-black text-indigo-600">{{ number_format($attempt->total_score, 2) }}</div>
                        <div class="text-[11px] text-slate-500">{{ __t('মোট মার্কস:', 'Total Marks:') }} {{ $attempt->exam->total_marks }}</div>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black shadow-xs">
                        🎯
                    </div>
                </div>
            </div>

            <!-- Key Metrics Grid -->
            <div class="mt-8 pt-6 border-t border-slate-200 grid grid-cols-2 sm:grid-cols-5 gap-4 text-center">
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <span class="text-[11px] text-slate-500 font-bold block">{{ __t('সঠিক উত্তর', 'Correct') }}</span>
                    <span class="text-lg font-black text-emerald-600">{{ $attempt->total_correct }}</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <span class="text-[11px] text-slate-500 font-bold block">{{ __t('ভুল উত্তর', 'Incorrect') }}</span>
                    <span class="text-lg font-black text-rose-600">{{ $attempt->total_incorrect }}</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <span class="text-[11px] text-slate-500 font-bold block">{{ __t('নেগেティブ মার্কস', 'Negative Marks') }}</span>
                    <span class="text-lg font-black text-rose-600">-{{ number_format($attempt->total_negative_marks, 2) }}</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <span class="text-[11px] text-slate-500 font-bold block">{{ __t('নির্ভুলতা (Accuracy)', 'Accuracy') }}</span>
                    <span class="text-lg font-black text-indigo-600">{{ number_format($attempt->accuracy_percentage, 1) }}%</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <span class="text-[11px] text-slate-500 font-bold block">{{ __t('সময় ব্যয়', 'Time Spent') }}</span>
                    <span class="text-lg font-black text-slate-700">{{ floor($attempt->time_taken_seconds / 60) }}মি {{ $attempt->time_taken_seconds % 60 }}সে</span>
                </div>
            </div>
        </div>

        <!-- Comparative Standing & Anti-Cheat Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">তুলনামূলক অবস্থান (Percentile)</span>
                    <div class="text-2xl font-black text-indigo-600 mt-1">শীর্ষ {{ $rank }} নম্বর স্থান</div>
                    <p class="text-xs text-slate-500 mt-0.5">আপনি {{ $totalTestTakers }} জন পরীক্ষার্থীর মধ্যে {{ number_format($attempt->percentile_rank, 1) }}% প্রার্থীর চেয়ে এগিয়ে আছেন।</p>
                </div>
                <div class="text-3xl">🏅</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">অ্যান্টি-চিট ও ইনটেগ্রিটি স্ট্যাটাস</span>
                    <div class="text-2xl font-black {{ $attempt->tab_switch_count > 0 ? 'text-amber-600' : 'text-emerald-600' }} mt-1">
                        {{ $attempt->tab_switch_count > 0 ? $attempt->tab_switch_count . ' বার ট্যাব সুইচ' : '১০০% পরিষ্কার (No Blur)' }}
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">পরীক্ষার সময় স্ক্রিন ও ট্যাবের বিশ্বস্ততা অডিট রেকর্ড।</p>
                </div>
                <div class="text-3xl">🛡️</div>
            </div>
        </div>

        <!-- Action Links -->
        <div class="flex flex-wrap items-center justify-between gap-3 no-print">
            <h2 class="text-xl font-black text-slate-900">প্রশ্নোত্তর ও সমাধান পর্যালোচনা (Detailed Solutions)</h2>
            <div class="flex items-center space-x-2">
                <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>🖨️ রেজাল্ট শিট প্রিন্ট / PDF</span>
                </button>
                <a href="{{ route('exams.room', $attempt->exam->slug) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    পুনরায় পরীক্ষা দিন
                </a>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    ড্যাশবোর্ড
                </a>
            </div>
        </div>

        <!-- Question Review List -->
        <div class="space-y-6">
            @foreach($attempt->answers as $index => $ans)
                @php
                    $q = $ans->question;
                    $selectedOpt = $ans->selectedOption;
                    $correctOpt = $q->options->firstWhere('is_correct', true);
                    $isCorrect = $ans->is_correct;
                    $isUnanswered = is_null($ans->selected_option_id);
                @endphp

                <div class="bg-white rounded-3xl p-6 sm:p-8 border {{ $isCorrect ? 'border-slate-200 shadow-xs' : ($isUnanswered ? 'border-slate-200' : 'border-rose-200 shadow-xs') }} space-y-5">
                    
                    <!-- Question Header & Status -->
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="w-7 h-7 rounded-lg {{ $isCorrect ? 'bg-emerald-600' : ($isUnanswered ? 'bg-slate-400' : 'bg-rose-600') }} text-white font-black text-xs flex items-center justify-center">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                {{ $q->subject->name_bn }}
                            </span>
                            @if($q->setterOrganization)
                                <span class="text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded">
                                    {{ $q->setterOrganization->code }}
                                </span>
                            @endif
                        </div>

                        <!-- Result Tag -->
                        <div>
                            @if($isCorrect)
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-black">
                                    ✓ {{ __t('সঠিক', 'Correct') }} (+{{ $ans->marks_awarded }})
                                </span>
                            @elseif($isUnanswered)
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                                    – {{ __t('উত্তর করা হয়নি (০.০০)', 'Not Answered (0.00)') }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-black">
                                    ✗ {{ __t('ভুল', 'Incorrect') }} ({{ $ans->marks_awarded }})
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Question Stem -->
                    <div class="math-tex text-base font-bold text-slate-900 leading-relaxed">
                        {!! $q->stem_bn !!}
                    </div>

                    @if($q->stem_en)
                        <div class="math-tex text-xs text-slate-500 font-medium italic">
                            {!! $q->stem_en !!}
                        </div>
                    @endif

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        @foreach($q->options as $opt)
                            @php
                                $isThisSelected = ($selectedOpt && $selectedOpt->id === $opt->id);
                                $isThisCorrect = $opt->is_correct;
                            @endphp

                            <div class="flex items-center p-3.5 rounded-2xl border text-sm font-semibold select-none
                                {{ $isThisCorrect ? 'bg-emerald-50/80 border-emerald-500 text-emerald-950 ring-1 ring-emerald-500/20' : ($isThisSelected && !$isThisCorrect ? 'bg-rose-50 border-rose-400 text-rose-950 ring-1 ring-rose-400/20' : 'bg-slate-50 border-slate-200 text-slate-700') }}">
                                
                                <div class="w-7 h-7 rounded-xl font-bold text-xs flex items-center justify-center mr-3 shrink-0
                                    {{ $isThisCorrect ? 'bg-emerald-600 text-white' : ($isThisSelected && !$isThisCorrect ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 border border-slate-300') }}">
                                    {{ $opt->option_letter }}
                                </div>

                                <div class="math-tex flex-1">
                                    {!! $opt->option_text_bn !!}
                                </div>

                                @if($isThisCorrect)
                                    <span class="text-xs font-bold text-emerald-700 ml-2">✓ সঠিক উত্তর</span>
                                @elseif($isThisSelected)
                                    <span class="text-xs font-bold text-rose-700 ml-2">✗ আপনার উত্তর</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Solution & Explanation Box -->
                    @if($q->explanation_bn)
                        <div class="p-4 rounded-2xl bg-slate-50/60 border border-slate-100 text-xs space-y-2">
                            <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                                <span>💡</span>
                                <span>বিস্তারিত ব্যাখ্যা ও সমাধান:</span>
                            </div>
                            <div class="math-tex text-slate-700 leading-relaxed">
                                {!! $q->explanation_bn !!}
                            </div>
                            @if($q->reference_source)
                                <div class="pt-2 border-t border-slate-100/80 text-[11px] text-indigo-700 font-semibold">
                                    📚 সূত্র / রেফারেন্স: {{ $q->reference_source }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="text-center py-8">
            <a href="{{ route('exams.index') }}" class="px-8 py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm shadow-xs transition">
                আরেকটি মডেল টেস্ট দিন →
            </a>
        </div>
    </div>
</div>
@endsection
