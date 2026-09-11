@extends('layouts.student-layout')

@section('title', __t('সাম্প্রতিক ঘটনাবলী ও ডেইলি জিকে – TargetOfficer', 'Current Affairs & Daily GK – TargetOfficer'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto" x-data="{ quizState: {} }">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-500/30 text-blue-300 text-xs font-black uppercase tracking-wider">
                    <span>📰</span>
                    <span>{{ __t('মাসিক ও দৈনিক কারেন্ট অ্যাফেয়ার্স', 'Daily & Monthly GK Capsule') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    {{ __t('সাম্প্রতিক বাংলাদেশ ও আন্তর্জাতিক তথ্যভাণ্ডার', 'Current Affairs & High-Yield GK Capsule') }}
                </h1>
                <p class="text-sm text-blue-200/90 leading-relaxed">
                    {{ __t('বিসিএস ও ব্যাংক নিয়োগ পরীক্ষায় সাম্প্রতিক বিষয়াবলী থেকে আসা সর্বোচ্চ গুরুত্বপূর্ণ তথ্যাবলীর নিয়মিত ক্যাপসুল। প্রতিটি সংবাদের সাথে রয়েছে সেলফ-অ্যাসেসমেন্ট কুইজ।', 'Curated monthly and daily capsules on Bangladesh, economy, and global affairs with embedded practice mini-quizzes.') }}
                </p>
            </div>

            {{-- Month Archive Selector --}}
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shrink-0">
                <label class="block text-[10px] font-black uppercase tracking-wider text-blue-200 mb-1.5">আর্কাইভ মাস নির্বাচন</label>
                <form method="GET" action="{{ route('current-affairs.index') }}">
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    <select name="month" onchange="this.form.submit()" class="w-full bg-slate-900/80 text-white text-xs font-bold px-3.5 py-2 rounded-xl border border-white/20 focus:ring-2 focus:ring-blue-400">
                        @foreach($availableMonths as $month)
                            <option value="{{ $month }}" {{ $selectedMonth === $month ? 'selected' : '' }}>
                                {{ date('F Y', strtotime($month . '-01')) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
    </div>

    {{-- Category Pills --}}
    <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none">
        @foreach($categories as $catKey => $catLabel)
            <a href="{{ route('current-affairs.index', ['category' => $catKey, 'month' => $selectedMonth]) }}"
               class="px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition border
                      {{ $selectedCategory === $catKey
                         ? 'bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-600/20'
                         : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:border-blue-300' }}">
                {{ $catLabel }}
            </a>
        @endforeach
    </div>

    {{-- Featured Article --}}
    @if($featured && $articles->currentPage() === 1)
        <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-slate-900 dark:via-blue-950/40 dark:to-slate-900 rounded-3xl p-6 sm:p-8 border border-blue-200 dark:border-blue-900/50 shadow-sm space-y-4">
            <div class="flex items-center space-x-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-blue-600 text-white">
                    ⭐ বিশেষ সাম্প্রতিক ক্যাপসুল
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">
                    {{ $featured->published_date ? $featured->published_date->format('d F, Y') : '' }}
                </span>
            </div>

            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white leading-tight">
                {{ $featured->title_bn }}
            </h2>

            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-semibold">
                {{ $featured->summary_bn }}
            </p>

            @if($featured->details_bn)
                <div class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed bg-white/80 dark:bg-slate-800/80 p-4 rounded-2xl border border-blue-100 dark:border-slate-700">
                    {{ $featured->details_bn }}
                </div>
            @endif

            {{-- Mini-Quiz --}}
            @if(!empty($featured->mini_quiz))
                <div class="pt-4 border-t border-blue-200/60 dark:border-slate-800 space-y-3">
                    <span class="text-xs font-black uppercase tracking-wider text-blue-700 dark:text-blue-300 flex items-center space-x-1.5">
                        <span>🎯</span>
                        <span>দ্রুত রিভিশন কুইজ (ট্যাপ করে উত্তর দেখুন)</span>
                    </span>

                    <div class="space-y-3">
                        @foreach($featured->mini_quiz as $qIdx => $quiz)
                            <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 space-y-2.5">
                                <p class="text-xs font-bold text-slate-900 dark:text-white">
                                    {{ $qIdx + 1 }}. {{ $quiz['question'] }}
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($quiz['options'] as $opt)
                                        <button type="button"
                                                @click="quizState['f_{{ $qIdx }}'] = '{{ $opt }}'"
                                                class="px-3 py-2 rounded-xl text-left text-xs font-semibold border transition"
                                                :class="quizState['f_{{ $qIdx }}'] === '{{ $opt }}' 
                                                    ? ('{{ $opt }}' === '{{ $quiz['correct_answer'] }}' ? 'bg-emerald-100 border-emerald-500 text-emerald-900 font-bold' : 'bg-rose-100 border-rose-500 text-rose-900')
                                                    : 'bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-700 hover:border-blue-400 text-slate-700 dark:text-slate-300'">
                                            {{ $opt }}
                                        </button>
                                    @endforeach
                                </div>
                                <template x-if="quizState['f_{{ $qIdx }}']">
                                    <p class="text-[11px] font-bold mt-1"
                                       :class="quizState['f_{{ $qIdx }}'] === '{{ $quiz['correct_answer'] }}' ? 'text-emerald-600' : 'text-rose-600'">
                                        <span x-text="quizState['f_{{ $qIdx }}'] === '{{ $quiz['correct_answer'] }}' ? '✓ সঠিক উত্তর!' : '✗ ভুল উত্তর! সঠিক উত্তর: {{ $quiz['correct_answer'] }}'"></span>
                                    </p>
                                </template>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Articles Stream --}}
    <div class="space-y-4">
        @forelse($articles as $art)
            @if($featured && $art->id === $featured->id && $articles->currentPage() === 1)
                @continue
            @endif
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3 hover:border-blue-300 transition">
                <div class="flex items-center justify-between gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-900/40">
                        {{ $art->category_bn }}
                    </span>
                    <span class="text-xs text-slate-400 font-semibold">
                        {{ $art->published_date ? $art->published_date->format('d F, Y') : '' }}
                    </span>
                </div>

                <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white leading-tight">
                    {{ $art->title_bn }}
                </h3>

                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-semibold">
                    {{ $art->summary_bn }}
                </p>

                @if($art->details_bn)
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed bg-slate-50 dark:bg-slate-800/60 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800">
                        {{ $art->details_bn }}
                    </p>
                @endif

                {{-- Embedded Mini Quiz --}}
                @if(!empty($art->mini_quiz))
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-2.5">
                        <span class="text-xs font-bold text-slate-500 flex items-center space-x-1">
                            <span>🎯</span>
                            <span>দ্রুত সেলফ-টেস্ট:</span>
                        </span>

                        @foreach($art->mini_quiz as $qIdx => $quiz)
                            <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 space-y-2">
                                <p class="text-xs font-bold text-slate-900 dark:text-white">
                                    {{ $quiz['question'] }}
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($quiz['options'] as $opt)
                                        <button type="button"
                                                @click="quizState['a_{{ $art->id }}_{{ $qIdx }}'] = '{{ $opt }}'"
                                                class="px-2.5 py-1.5 rounded-xl text-left text-xs font-semibold border transition"
                                                :class="quizState['a_{{ $art->id }}_{{ $qIdx }}'] === '{{ $opt }}'
                                                    ? ('{{ $opt }}' === '{{ $quiz['correct_answer'] }}' ? 'bg-emerald-100 border-emerald-500 text-emerald-900 font-bold' : 'bg-rose-100 border-rose-500 text-rose-900')
                                                    : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 hover:border-blue-400 text-slate-700 dark:text-slate-300'">
                                            {{ $opt }}
                                        </button>
                                    @endforeach
                                </div>
                                <template x-if="quizState['a_{{ $art->id }}_{{ $qIdx }}']">
                                    <p class="text-[11px] font-bold mt-1"
                                       :class="quizState['a_{{ $art->id }}_{{ $qIdx }}'] === '{{ $quiz['correct_answer'] }}' ? 'text-emerald-600' : 'text-rose-600'">
                                        <span x-text="quizState['a_{{ $art->id }}_{{ $qIdx }}'] === '{{ $quiz['correct_answer'] }}' ? '✓ সঠিক উত্তর!' : '✗ ভুল উত্তর! সঠিক উত্তর: {{ $quiz['correct_answer'] }}'"></span>
                                    </p>
                                </template>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-800 shadow-xs">
                <p class="text-slate-400 text-sm font-semibold">এই মাসে বা ক্যাটাগরিতে কোনো সাম্প্রতিক তথ্য পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <div>
        {{ $articles->links() }}
    </div>
</div>
@endsection
