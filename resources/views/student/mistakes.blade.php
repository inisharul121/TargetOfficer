@extends('layouts.student-layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-8" x-data x-init="
    $nextTick(() => {
        document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
    });
">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold border border-rose-200">
                    <span>🎯</span>
                    <span>{{ __t('ভুল উত্তরের ব্যাংক (Mistake Bank)', 'Mistake Bank & Error Revision') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-2">
                    {{ __t('আমার ভুল করা প্রশ্ন ও রিভিশন তালিকা', 'My Mistake Questions & Revision List') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    {{ __t('বিভিন্ন মডেল টেস্ট ও কাস্টম পরীক্ষায় যে প্রশ্নগুলো আপনি ভুল উত্তর দিয়েছিলেন, সেগুলোর সঠিক ব্যাখ্যা পড়ুন এবং রিভিশন টেস্ট দিয়ে দুর্বলতা দূর করুন।', 'Review questions you answered incorrectly in past tests. Read explanations and retake them until perfected.') }}
                </p>
            </div>

            @if($questions->total() > 0)
                <form action="{{ route('student.mistakes.retake') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="px-5 py-3 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-lg shadow-rose-600/30 transition flex items-center space-x-2">
                        <span>⚡</span>
                        <span>{{ __t('ভুল প্রশ্নের রিভিশন পরীক্ষা দিন', 'Retake Mistakes as Quiz') }} ({{ min(20, $questions->total()) }} {{ __t('টি', '') }})</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('student.mistakes') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __t('প্রশ্ন বা বিষয় দিয়ে খুঁজুন...', 'Search question...') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">
                </div>

                <div>
                    <select name="subject" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white">
                        <option value="">{{ __t('সকল বিষয় (All Subjects)', 'All Subjects') }}</option>
                        @foreach($subjects as $sb)
                            <option value="{{ $sb->id }}" {{ request('subject') == $sb->id ? 'selected' : '' }}>{{ __t($sb->name_bn, $sb->name_en) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="setter" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white">
                        <option value="">{{ __t('সকল প্রশ্নকর্তা সংস্থা (BPSC, BUET, IBA)', 'All Setters') }}</option>
                        @foreach($setters as $st)
                            <option value="{{ $st->id }}" {{ request('setter') == $st->id ? 'selected' : '' }}>{{ $st->name_bn }} ({{ $st->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">
                        {{ __t('ফিল্টার করুন', 'Filter') }}
                    </button>
                    @if(request()->anyFilled(['q', 'subject', 'setter']))
                        <a href="{{ route('student.mistakes') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-xs transition">
                            {{ __t('রিসেট', 'Reset') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Questions List -->
        <div class="space-y-5">
            @forelse($questions as $index => $q)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4" x-data="{ revealed: true }">
                    
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                            <span class="w-7 h-7 rounded-lg bg-rose-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                {{ $questions->firstItem() + $index }}
                            </span>
                            <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">
                                {{ __t($q->subject->name_bn, $q->subject->name_en) }}
                            </span>
                            @foreach($q->sources as $source)
                                <a href="{{ $source['url'] }}" 
                                   title="{{ $source['full_title'] }}"
                                   class="inline-flex items-center space-x-1 text-xs font-bold border px-2 py-0.5 rounded transition shadow-2xs {{ $source['badge_color'] }}">
                                    <span>{{ $source['icon'] }}</span>
                                    <span>{{ $source['title'] }}</span>
                                </a>
                            @endforeach
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200">
                                ⚠️ {{ $q->mistake_count }} বার ভুল হয়েছে
                            </span>
                        </div>

                        <button type="button" @click="revealed = !revealed" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 shrink-0">
                            <span x-text="revealed ? '{{ __t('ব্যাখ্যা লুকান', 'Hide Explanation') }}' : '{{ __t('ব্যাখ্যা দেখুন', 'Show Explanation') }}'"></span>
                        </button>
                    </div>

                    <div class="math-tex text-base font-bold text-slate-900 leading-relaxed">
                        {!! app()->getLocale() === 'en' && !empty($q->stem_en) ? $q->stem_en : $q->stem_bn !!}
                    </div>

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        @foreach($q->options as $opt)
                            <div class="w-full text-left flex items-center p-3.5 rounded-2xl border text-sm font-semibold transition select-none
                                        {{ $opt->is_correct ? 'bg-emerald-50/90 border-emerald-500 text-emerald-950 ring-1 ring-emerald-500/30' : 'bg-slate-50 border-slate-200 text-slate-600' }}">
                                <div class="w-7 h-7 rounded-xl font-bold text-xs flex items-center justify-center mr-3 shrink-0
                                            {{ $opt->is_correct ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-300' }}">
                                    {{ $opt->option_letter }}
                                </div>
                                <div class="math-tex flex-1">
                                    {!! app()->getLocale() === 'en' && !empty($opt->option_text_en) ? $opt->option_text_en : $opt->option_text_bn !!}
                                </div>
                                @if($opt->is_correct)
                                    <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded ml-2">✓ সঠিক উত্তর</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Explanation -->
                    <div x-show="revealed" class="p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100 text-xs space-y-2">
                        <div class="font-bold text-indigo-900 flex items-center space-x-1.5">
                            <span>💡</span>
                            <span>{{ __t('সঠিক ব্যাখ্যা ও বিশ্লেষণ:', 'Correct Explanation & Analysis:') }}</span>
                        </div>
                        <div class="math-tex text-slate-700 leading-relaxed">
                            {!! $q->explanation_bn !!}
                        </div>
                        @if($q->reference_source)
                            <div class="pt-2 border-t border-indigo-100 text-[11px] text-indigo-700 font-semibold">
                                📚 {{ __t('রেফারেন্স সূত্র:', 'Reference Source:') }} {{ $q->reference_source }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200 space-y-3">
                    <span class="text-4xl">🎉</span>
                    <h3 class="text-lg font-black text-slate-800">{{ __t('দারুণ! আপনার কোনো অমীমাংসিত ভুল প্রশ্ন নেই', 'Awesome! No mistake questions found') }}</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">{{ __t('মডেল টেস্ট দিতে থাকুন; ভুল হওয়া প্রশ্নগুলো স্বয়ংক্রিয়ভাবে এখানে সংগৃহীত হবে যাতে পরে রিভিশন দিতে পারেন।', 'Keep taking exams! Any question you miss will automatically appear here for focused revision.') }}</p>
                    <a href="{{ route('exams.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-xs hover:bg-indigo-700 transition mt-2">
                        {{ __t('মডেল টেস্ট শুরু করুন', 'Browse Model Tests') }}
                    </a>
                </div>
            @endforelse

            <div>
                {{ $questions->links() }}
            </div>
        </div>
    </div>
@endsection
