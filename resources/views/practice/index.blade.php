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
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">বিষয়ভিত্তিক অনুশীলন (Practice Mode)</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">সময়সীমা ছাড়া তাৎক্ষণিক ব্যাখ্যা ও সমাধানসহ অধ্যায়ভিত্তিক প্রস্তুতি নিন।</p>
            </div>
            <a href="{{ route('exams.custom') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm transition space-x-1 shrink-0">
                <span>⚡ কাস্টম কুইজ বানান</span>
            </a>
        </div>

        <!-- Subjects Horizontal Pills -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none">
            @foreach($subjects as $subj)
                <a href="{{ route('practice.index', ['subject' => $subj->slug]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold shrink-0 transition border {{ (isset($selectedSubject) && $selectedSubject->id === $subj->id) ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                    {{ $subj->name_bn }}
                </a>
            @endforeach
        </div>

        @if($selectedSubject)
            <!-- Topic Filter & Questions List -->
            <div class="space-y-6">
                
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-xs font-bold text-slate-400">টপিক ফিল্টার:</span>
                        <a href="{{ route('practice.index', ['subject' => $selectedSubject->slug]) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ !request('topic') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600' }}">সকল</a>
                        @foreach($selectedSubject->topics as $topic)
                            <a href="{{ route('practice.index', ['subject' => $selectedSubject->slug, 'topic' => $topic->slug]) }}" 
                               class="px-2.5 py-1 rounded-lg text-xs font-bold {{ request('topic') === $topic->slug ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                {{ $topic->name_bn }}
                            </a>
                        @endforeach
                    </div>
                    <span class="text-xs font-bold text-slate-500">{{ $questions->total() }} টি প্রশ্ন পাওয়া গেছে</span>
                </div>

                <!-- Questions -->
                <div class="space-y-5">
                    @forelse($questions as $index => $q)
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4" x-data="{ selected: null, revealed: false }">
                            
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div class="flex items-center space-x-2">
                                    <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-black text-xs flex items-center justify-center">
                                        {{ $questions->firstItem() + $index }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                        {{ $q->subject->name_bn }}
                                    </span>
                                    @if($q->setterOrganization)
                                        <span class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded">
                                            {{ $q->setterOrganization->code }}
                                        </span>
                                    @endif
                                </div>

                                <button type="button" @click="revealed = !revealed" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                    <span x-text="revealed ? 'ব্যাখ্যা লুকান' : 'উত্তর ও ব্যাখ্যা দেখুন'"></span>
                                </button>
                            </div>

                            <div class="math-tex text-base font-bold text-slate-900 leading-relaxed">
                                {!! $q->stem_bn !!}
                            </div>

                            <!-- Options with interactive click -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                @foreach($q->options as $opt)
                                    <button type="button" 
                                            @click="selected = {{ $opt->id }}; revealed = true" 
                                            :class="revealed ? ({{ $opt->is_correct ? 'true' : 'false' }} ? 'bg-emerald-50 border-emerald-500 text-emerald-950 ring-2 ring-emerald-500/20' : (selected == {{ $opt->id }} ? 'bg-rose-50 border-rose-500 text-rose-950 ring-2 ring-rose-500/20' : 'bg-slate-50/70 border-slate-200')) : (selected == {{ $opt->id }} ? 'bg-indigo-50 border-indigo-600' : 'bg-slate-50 hover:bg-slate-100 border-slate-200')"
                                            class="w-full text-left flex items-center p-3.5 rounded-2xl border text-sm font-semibold transition select-none">
                                        
                                        <div :class="revealed ? ({{ $opt->is_correct ? 'true' : 'false' }} ? 'bg-emerald-600 text-white' : (selected == {{ $opt->id }} ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 border border-slate-300')) : (selected == {{ $opt->id }} ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 border border-slate-300')"
                                             class="w-7 h-7 rounded-xl font-bold text-xs flex items-center justify-center mr-3 shrink-0">
                                            {{ $opt->option_letter }}
                                        </div>

                                        <div class="math-tex flex-1">
                                            {!! $opt->option_text_bn !!}
                                        </div>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Explanation Box -->
                            <div x-show="revealed" x-transition class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 text-xs space-y-2">
                                <div class="font-bold text-indigo-900 flex items-center space-x-1.5">
                                    <span>💡</span>
                                    <span>ব্যাখ্যা ও রেফারেন্স:</span>
                                </div>
                                <div class="math-tex text-slate-700 leading-relaxed">
                                    {!! $q->explanation_bn !!}
                                </div>
                                @if($q->reference_source)
                                    <div class="pt-2 border-t border-indigo-100/80 text-[11px] text-indigo-700 font-semibold">
                                        📚 সূত্র: {{ $q->reference_source }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-200">
                            <p class="text-sm font-bold text-slate-700">এই বিষয়ে এখনও কোনো প্রশ্ন আপলোড করা হয়নি।</p>
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
                <h2 class="text-xl font-black text-slate-900">অনুশীলনের জন্য উপরের যেকোনো একটি বিষয় নির্বাচন করুন</h2>
                <p class="text-xs text-slate-500 max-w-md mx-auto">বাংলা, ইংরেজি, গণিত বা সাধারণ জ্ঞানের অধ্যায়ভিত্তিক প্রশ্ন ও বিস্তারিত সমাধান পেয়ে যান নিমেষেই।</p>
            </div>
        @endif
    </div>
</div>
@endsection
