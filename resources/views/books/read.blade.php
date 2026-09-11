@extends('layouts.student-layout')

@section('title', $activeChapter->title_bn . ' – ' . $book->title_bn)

@section('content')
<div class="space-y-6 max-w-7xl mx-auto" 
     x-data="{ 
         tocOpen: false, 
         activeTab: '{{ $activeTab }}', 
         fontSize: 15,
         revealedAnswers: {}
     }">
    
    {{-- Top Book Navigation & Reading Controls Bar --}}
    <div class="sticky top-16 z-20 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl p-3 sm:p-4 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center space-x-3 min-w-0">
            <a href="{{ route('books.show', $book->slug) }}" 
               class="p-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 shrink-0 transition"
               title="সূচিপত্রে ফিরুন">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>

            <div class="min-w-0">
                <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider block truncate">
                    {{ $book->title_bn }}
                </span>
                <h1 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white truncate">
                    {{ $activeChapter->title_bn }}
                </h1>
            </div>
        </div>

        <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
            {{-- Font Size Controls --}}
            <div class="hidden sm:flex items-center space-x-1 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold">
                <button type="button" @click="fontSize = Math.max(13, fontSize - 1)" class="px-2 py-0.5 rounded text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 transition" title="ফন্ট ছোট করুন">
                    A-
                </button>
                <span class="text-[10px] font-mono text-slate-400 px-1" x-text="fontSize + 'px'">15px</span>
                <button type="button" @click="fontSize = Math.min(22, fontSize + 1)" class="px-2 py-0.5 rounded text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 transition" title="ফন্ট বড় করুন">
                    A+
                </button>
            </div>

            {{-- PDF Chapter Export --}}
            <a href="{{ route('books.export', [$book->slug, $activeChapter->chapter_number]) }}"
               target="_blank"
               class="px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition flex items-center space-x-1.5"
               title="অধ্যায়টি প্রিন্ট বা PDF ডাউনলোড">
                <span>🖨️</span>
                <span class="hidden sm:inline">প্রিন্ট / PDF</span>
            </a>

            {{-- Mobile TOC Toggle Button --}}
            <button type="button" 
                    @click="tocOpen = !tocOpen"
                    class="lg:hidden px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center space-x-1">
                <span>📑</span>
                <span>সূচিপত্র</span>
            </button>
        </div>
    </div>

    {{-- Main Reader Layout: Left TOC + Center Reading Pane --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
        
        {{-- Left: Desktop Persistent Table of Contents --}}
        <aside class="hidden lg:block lg:col-span-1 bg-white dark:bg-slate-900 rounded-3xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs sticky top-36 space-y-4 max-h-[calc(100vh-160px)] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white flex items-center space-x-2">
                    <span>📑</span>
                    <span>সূচিপত্র (Chapters)</span>
                </h2>
                <span class="text-[10px] font-bold text-slate-400">{{ $book->chapters->count() }}টি অধ্যায়</span>
            </div>

            <nav class="space-y-1.5">
                @foreach($book->chapters as $ch)
                    @php
                        $isActive = $ch->id === $activeChapter->id;
                    @endphp
                    <a href="{{ route('books.read', [$book->slug, $ch->chapter_number, 'tab' => request('tab', 'mcq')]) }}"
                       class="block p-3 rounded-2xl text-xs font-bold transition {{ $isActive 
                            ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' 
                            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        <div class="flex items-start space-x-2">
                            <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0 text-[10px] {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }}">
                                {{ $ch->chapter_number }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <span class="truncate block">{{ $ch->title_bn }}</span>
                                <span class="text-[10px] block opacity-80 mt-0.5">
                                    🎯 {{ $ch->questions_count }} MCQ • ✍️ {{ $ch->written_contents_count }} লিখিত
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </nav>
        </aside>

        {{-- Mobile Drawer Table of Contents --}}
        <div x-show="tocOpen" 
             class="fixed inset-0 z-50 lg:hidden bg-slate-900/60 backdrop-blur-xs flex"
             @click.self="tocOpen = false"
             style="display: none;">
            <div class="w-80 bg-white dark:bg-slate-900 h-full p-5 overflow-y-auto space-y-4 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="text-xs font-black uppercase text-slate-900 dark:text-white">বইয়ের সূচিপত্র</span>
                    <button @click="tocOpen = false" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>
                <nav class="space-y-1.5">
                    @foreach($book->chapters as $ch)
                        @php
                            $isActive = $ch->id === $activeChapter->id;
                        @endphp
                        <a href="{{ route('books.read', [$book->slug, $ch->chapter_number, 'tab' => request('tab', 'mcq')]) }}"
                           class="block p-3 rounded-2xl text-xs font-bold transition {{ $isActive ? 'bg-indigo-600 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            {{ $ch->title_bn }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- Right / Center: Reading Pane --}}
        <main class="lg:col-span-3 space-y-6">
            
            {{-- Mode Switcher Tabs --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-2 border border-slate-200 dark:border-slate-800 shadow-xs flex items-center">
                <button type="button"
                        @click="activeTab = 'mcq'"
                        :class="activeTab === 'mcq' 
                            ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' 
                            : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                        class="flex-1 py-3 rounded-2xl text-xs font-black transition flex items-center justify-center space-x-2">
                    <span>🎯</span>
                    <span>প্রিলিমিনারি MCQ অংশ ({{ $questions->count() }}টি)</span>
                </button>

                <button type="button"
                        @click="activeTab = 'written'"
                        :class="activeTab === 'written' 
                            ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' 
                            : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                        class="flex-1 py-3 rounded-2xl text-xs font-black transition flex items-center justify-center space-x-2">
                    <span>✍️</span>
                    <span>লিখিত প্রস্তুতি ও মডেল উত্তর ({{ $writtenContents->count() }}টি)</span>
                </button>
            </div>

            {{-- 1. MCQ MODE SECTION --}}
            <div x-show="activeTab === 'mcq'" class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                        বিসিএস প্রিলিমিনারি বিগত বছরের প্রশ্নাবলি ও ব্যাখ্যা
                    </span>
                    <button type="button" 
                            @click="revealedAnswers = Object.fromEntries(@json($questions->pluck('id')).map(id => [id, true]))"
                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                        সব উত্তর একসাথে দেখুন
                    </button>
                </div>

                @forelse($questions as $index => $q)
                    @php
                        $correctOpt = $q->options->firstWhere('is_correct', true);
                    @endphp
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                        {{-- Question Header --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start space-x-3">
                                <span class="w-7 h-7 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 font-black text-xs flex items-center justify-center shrink-0 mt-0.5">
                                    {{ $index + 1 }}
                                </span>
                                <h3 class="font-bold text-slate-900 dark:text-white leading-relaxed"
                                    :style="'font-size: ' + fontSize + 'px'">
                                    {{ $q->stem_bn }}
                                </h3>
                            </div>
                            
                            {{-- Source Tags --}}
                            <div class="flex items-center space-x-1 shrink-0">
                                @foreach($q->exams as $ex)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200/60">
                                        {{ $ex->title_bn }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Options Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pl-10">
                            @foreach($q->options as $optIdx => $opt)
                                @php
                                    $letter = ['(ক)', '(খ)', '(গ)', '(ঘ)'][$optIdx] ?? ('(' . ($optIdx + 1) . ')');
                                @endphp
                                <div class="p-3 rounded-2xl border text-xs font-semibold flex items-center space-x-2 transition"
                                     :class="revealedAnswers[{{ $q->id }}] 
                                         ? ('{{ $opt->is_correct }}' ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-500 text-emerald-900 dark:text-emerald-200 font-bold' : 'bg-slate-50 dark:bg-slate-800/40 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400')
                                         : 'bg-slate-50 dark:bg-slate-800/40 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300'">
                                    <span class="font-bold {{ $opt->is_correct ? 'text-emerald-600' : 'text-slate-400' }}">{{ $letter }}</span>
                                    <span>{{ $opt->option_text_bn }}</span>
                                    @if($opt->is_correct)
                                        <span x-show="revealedAnswers[{{ $q->id }}]" class="text-emerald-600 ml-auto font-black text-xs">✓</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Answer & Explanation Trigger --}}
                        <div class="pl-10 pt-1">
                            <button type="button"
                                    @click="revealedAnswers[{{ $q->id }}] = !revealedAnswers[{{ $q->id }}]"
                                    class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center space-x-1">
                                <span x-text="revealedAnswers[{{ $q->id }}] ? 'উত্তর ও ব্যাখ্যা লুকান ▲' : '💡 উত্তর ও বিশদ ব্যাখ্যা দেখুন ▼'"></span>
                            </button>

                            {{-- Explanation Box --}}
                            <div x-show="revealedAnswers[{{ $q->id }}]"
                                 x-transition
                                 class="mt-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700 space-y-2 text-xs leading-relaxed">
                                <div class="text-emerald-800 dark:text-emerald-300 font-bold">
                                    সঠিক উত্তর: {{ $correctOpt ? $correctOpt->option_text_bn : 'নির্ধারিত নয়' }}
                                </div>
                                @if($q->explanation_bn)
                                    <div class="text-slate-700 dark:text-slate-300"
                                         :style="'font-size: ' + (fontSize - 1) + 'px'">
                                        {!! $q->explanation_bn !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-800 shadow-xs">
                        <p class="text-slate-400 text-xs font-semibold">এই অধ্যায়ের সাথে সম্পর্কিত প্রিলিমিনারি প্রশ্নাবলি শিগগিরই যুক্ত হচ্ছে।</p>
                    </div>
                @endforelse
            </div>

            {{-- 2. WRITTEN MODE SECTION --}}
            <div x-show="activeTab === 'written'" class="space-y-4" style="display: none;">
                <div class="px-1">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                        বিসিএস লিখিত পরীক্ষার মডেল প্রশ্নোত্তর, ব্যকরণ নিয়মাবলী ও প্রমাণ
                    </span>
                </div>

                @forelse($writtenContents as $index => $wc)
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                        {{-- Written Item Header --}}
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div class="flex items-center space-x-2">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300">
                                    {{ $wc->content_type === 'theory_and_rules' ? 'নিয়মাবলী ও সূত্র' : ($wc->content_type === 'math_step_solution' ? 'ধাপসহ গাণিতিক সমাধান' : 'রচনামূলক প্রশ্নোত্তর') }}
                                </span>
                                @if($wc->bcs_reference)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        {{ $wc->bcs_reference }}
                                    </span>
                                @endif
                            </div>

                            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400">
                                মান: {{ $wc->marks }} নম্বর
                            </span>
                        </div>

                        {{-- Question Stem --}}
                        @if($wc->question_bn)
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">লিখিত প্রশ্ন:</span>
                                <h3 class="font-bold text-slate-900 dark:text-white"
                                    :style="'font-size: ' + fontSize + 'px'">
                                    {{ $wc->question_bn }}
                                </h3>
                            </div>
                        @else
                            <h3 class="font-black text-slate-900 dark:text-white text-base">
                                {{ $wc->title_bn }}
                            </h3>
                        @endif

                        {{-- Model Answer / Notes --}}
                        <div class="pt-2 text-slate-700 dark:text-slate-300 leading-relaxed space-y-3"
                             :style="'font-size: ' + fontSize + 'px'">
                            {!! $wc->content_bn !!}
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-800 shadow-xs">
                        <p class="text-slate-400 text-xs font-semibold">এই অধ্যায়ের লিখিত মডেল প্রশ্নোত্তর প্রস্তুত হচ্ছে।</p>
                    </div>
                @endforelse
            </div>

            {{-- Prev / Next Chapter Footer Navigation --}}
            @php
                $prevChapter = $book->chapters->where('chapter_number', '<', $activeChapter->chapter_number)->last();
                $nextChapter = $book->chapters->where('chapter_number', '>', $activeChapter->chapter_number)->first();
            @endphp
            <div class="pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between gap-4">
                @if($prevChapter)
                    <a href="{{ route('books.read', [$book->slug, $prevChapter->chapter_number, 'tab' => request('tab', 'mcq')]) }}"
                       class="px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition flex items-center space-x-2">
                        <span>← পূর্ববর্তী অধ্যায়: {{ $prevChapter->chapter_number }}</span>
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextChapter)
                    <a href="{{ route('books.read', [$book->slug, $nextChapter->chapter_number, 'tab' => request('tab', 'mcq')]) }}"
                       class="px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black shadow-md transition flex items-center space-x-2">
                        <span>পরবর্তী অধ্যায়: {{ $nextChapter->chapter_number }} →</span>
                    </a>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
