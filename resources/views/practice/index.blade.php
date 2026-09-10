@extends('layouts.app')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen" x-data x-init="
    $nextTick(() => {
        document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
    });
">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __t('বিষয়ভিত্তিক অনুশীলন (Practice Mode)', 'Topic Practice Mode') }}</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __t('সময়সীমা ছাড়া তাৎক্ষণিক ব্যাখ্যা ও সমাধানসহ অধ্যায়ভিত্তিক প্রস্তুতি নিন।', 'Untimed topic-wise practice with instant explanations & solutions.') }}</p>
            </div>
            <a href="{{ route('exams.custom') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition space-x-1 shrink-0">
                <span>⚡ {{ __t('কাস্টম কুইজ বানান', 'Build Custom Quiz') }}</span>
            </a>
        </div>

        <!-- Active Filter Alert (If filtering by Exam, Setter, or Tag) -->
        @if($selectedExam || $selectedSetter || $selectedTag)
            <div class="bg-indigo-50/80 border border-indigo-200/80 rounded-2xl p-4 flex flex-wrap items-center justify-between gap-3 shadow-2xs">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold text-indigo-900 uppercase tracking-wider">{{ __t('সক্রিয় ফিল্টার:', 'Active Filter:') }}</span>
                    @if($selectedExam)
                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-xl text-xs font-extrabold bg-indigo-600 text-white shadow-xs">
                            <span>🎓</span>
                            <span>{{ $selectedExam->title_bn }}</span>
                        </span>
                    @endif
                    @if($selectedSetter)
                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-xl text-xs font-extrabold bg-indigo-700 text-white shadow-xs">
                            <span>🏛️</span>
                            <span>{{ $selectedSetter->name_bn }} ({{ $selectedSetter->code }})</span>
                        </span>
                    @endif
                    @if($selectedTag)
                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-xl text-xs font-extrabold bg-sky-600 text-white shadow-xs">
                            <span>🏷️</span>
                            <span>{{ $selectedTag }}</span>
                        </span>
                    @endif
                    @if($selectedSubject)
                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-xl text-xs font-extrabold bg-emerald-600 text-white shadow-xs">
                            <span>📖</span>
                            <span>{{ __t($selectedSubject->name_bn, $selectedSubject->name_en) }}</span>
                        </span>
                    @endif
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-extrabold text-indigo-950">{{ $questions->total() }} {{ __t('টি প্রশ্ন পাওয়া গেছে', 'questions found') }}</span>
                    <a href="{{ route('practice.index') }}" class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 transition shadow-2xs">
                        ✕ {{ __t('রিসেট ফিল্টার', 'Clear Filter') }}
                    </a>
                </div>
            </div>
        @endif

        <!-- Subjects Horizontal Pills -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none">
            <!-- All Subjects Pill -->
            <a href="{{ route('practice.index', request()->except(['subject', 'topic', 'page'])) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold shrink-0 transition border {{ !isset($selectedSubject) ? 'bg-indigo-600 text-white border-indigo-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                {{ __t('সকল বিষয়', 'All Subjects') }}
            </a>

            @foreach($subjects as $subj)
                <a href="{{ route('practice.index', array_merge(request()->except(['page', 'topic']), ['subject' => $subj->slug])) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold shrink-0 transition border {{ (isset($selectedSubject) && $selectedSubject->id === $subj->id) ? 'bg-indigo-600 text-white border-indigo-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                    {{ __t($subj->name_bn, $subj->name_en) }}
                </a>
            @endforeach
        </div>

        @if($selectedSubject || $selectedExam || $selectedSetter || $selectedTag || $questions->isNotEmpty())
            <!-- Topic Filter & Questions List -->
            <div class="space-y-6">
                
                @if($selectedSubject && $selectedSubject->topics->isNotEmpty())
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 flex-wrap gap-y-2">
                            <span class="text-xs font-bold text-slate-400">{{ __t('টপিক ফিল্টার:', 'Topic Filter:') }}</span>
                            <a href="{{ route('practice.index', array_merge(request()->except(['page', 'topic']))) }}" 
                               class="px-2.5 py-1 rounded-lg text-xs font-bold {{ !request('topic') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ __t('সকল', 'All') }}
                            </a>
                            @foreach($selectedSubject->topics as $topic)
                                <a href="{{ route('practice.index', array_merge(request()->except(['page']), ['topic' => $topic->slug])) }}" 
                                   class="px-2.5 py-1 rounded-lg text-xs font-bold {{ request('topic') === $topic->slug ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                    {{ __t($topic->name_bn, $topic->name_en) }}
                                </a>
                            @endforeach
                        </div>
                        <span class="text-xs font-bold text-slate-500">{{ $questions->total() }} {{ __t('টি প্রশ্ন পাওয়া গেছে', 'questions found') }}</span>
                    </div>
                @endif

                <!-- Questions -->
                <div class="space-y-5">
                    @forelse($questions as $index => $q)
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4" x-data="{ selected: null, revealed: false }">
                            
                            <!-- Question Header with Clickable Source Badges -->
                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
                                <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                    <!-- Serial Number -->
                                    <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                        {{ $questions->firstItem() + $index }}
                                    </span>

                                    <!-- Subject Badge (Clickable) -->
                                    <a href="{{ route('practice.index', array_merge(request()->except(['page', 'topic']), ['subject' => $q->subject->slug])) }}" 
                                       title="{{ __t('এই বিষয়ের সকল প্রশ্ন দেখুন', 'View all questions of this subject') }}"
                                       class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-2.5 py-1 rounded-lg transition shrink-0">
                                        {{ __t($q->subject->name_bn, $q->subject->name_en) }}
                                    </a>

                                    <!-- Clickable Source References: Exams, Setter Orgs, Tags -->
                                    @foreach($q->sources as $source)
                                        <a href="{{ $source['url'] }}" 
                                           title="{{ $source['full_title'] }} - {{ __t('সম্পর্কিত সকল প্রশ্ন দেখতে ক্লিক করুন', 'Click to view all questions from this source') }}"
                                           class="inline-flex items-center space-x-1 text-xs font-bold border px-2.5 py-1 rounded-lg transition hover:scale-105 shrink-0 shadow-2xs {{ $source['badge_color'] }}">
                                            <span>{{ $source['icon'] }}</span>
                                            <span>{{ $source['title'] }}</span>
                                        </a>
                                    @endforeach
                                </div>

                                <button type="button" @click="revealed = !revealed" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 shrink-0">
                                    <span x-text="revealed ? '{{ __t('ব্যাখ্যা লুকান', 'Hide Explanation') }}' : '{{ __t('উত্তর ও ব্যাখ্যা দেখুন', 'Show Answer & Explanation') }}'"></span>
                                </button>
                            </div>

                            <div class="math-tex text-base font-bold text-slate-900 leading-relaxed">
                                {!! app()->getLocale() === 'en' && !empty($q->stem_en) ? $q->stem_en : $q->stem_bn !!}
                            </div>

                            <!-- Options with interactive click -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                @foreach($q->options as $opt)
                                    <button type="button" 
                                            @click="selected = {{ $opt->id }}; revealed = true" 
                                            :class="revealed ? ({{ $opt->is_correct ? 'true' : 'false' }} ? 'bg-emerald-50/80 border-emerald-500 text-emerald-950 ring-1 ring-emerald-500/20' : (selected == {{ $opt->id }} ? 'bg-rose-50 border-rose-400 text-rose-950 ring-1 ring-rose-400/20' : 'bg-slate-50 border-slate-200')) : (selected == {{ $opt->id }} ? 'bg-indigo-50 border-indigo-600' : 'bg-slate-50 hover:bg-slate-100 border-slate-200')"
                                            class="w-full text-left flex items-center p-3.5 rounded-2xl border text-sm font-semibold transition select-none">
                                        
                                        <div :class="revealed ? ({{ $opt->is_correct ? 'true' : 'false' }} ? 'bg-emerald-600 text-white' : (selected == {{ $opt->id }} ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 border border-slate-300')) : (selected == {{ $opt->id }} ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 border border-slate-300')"
                                             class="w-7 h-7 rounded-xl font-bold text-xs flex items-center justify-center mr-3 shrink-0">
                                            {{ $opt->option_letter }}
                                        </div>

                                        <div class="math-tex flex-1">
                                            {!! app()->getLocale() === 'en' && !empty($opt->option_text_en) ? $opt->option_text_en : $opt->option_text_bn !!}
                                        </div>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Explanation Box -->
                            <div x-show="revealed" x-transition class="p-4 rounded-2xl bg-slate-50/60 border border-slate-100 text-xs space-y-2">
                                <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                                    <span>💡</span>
                                    <span>{{ __t('ব্যাখ্যা ও রেফারেন্স:', 'Explanation & Reference:') }}</span>
                                </div>
                                <div class="math-tex text-slate-700 leading-relaxed">
                                    {!! $q->explanation_bn !!}
                                </div>
                                @if($q->reference_source)
                                    <div class="pt-2 border-t border-slate-100/80 text-[11px] text-indigo-700 font-semibold">
                                        📚 {{ __t('সূত্র:', 'Source:') }} {{ $q->reference_source }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-200">
                            <p class="text-sm font-bold text-slate-700">{{ __t('এই ফিল্টারে এখনও কোনো প্রশ্ন পাওয়া যায়নি।', 'No questions found with this filter.') }}</p>
                        </div>
                    @endforelse

                    <div>
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Subject Selection Prompt -->
            <div class="bg-white rounded-3xl p-10 border border-slate-200 text-center space-y-4">
                <span class="text-4xl">📚</span>
                <h2 class="text-xl font-black text-slate-900">{{ __t('অনুশীলনের জন্য উপরের যেকোনো একটি বিষয় বা পরীক্ষা নির্বাচন করুন', 'Select any subject or exam above to start practice') }}</h2>
                <p class="text-xs text-slate-500 max-w-md mx-auto">{{ __t('বিসিএস, ব্যাংক বা অন্যান্য পরীক্ষার অধ্যায়ভিত্তিক প্রশ্ন ও বিস্তারিত সমাধান পেয়ে যান নিমেষেই।', 'Get instant access to questions & explanations for BCS, Bank and other exams.') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
