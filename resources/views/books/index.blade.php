@extends('layouts.student-layout')

@section('title', __t('বিষয়ভিত্তিক ডিজিটাল ই-বুক সমগ্র – TargetOfficer', 'Topic-Based Digital Books Library – TargetOfficer'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-xs font-black uppercase tracking-wider">
                    <span>📚</span>
                    <span>{{ __t('টার্গেট অফিসার বিষয়ভিত্তিক বুক সিরিজ', 'TargetOfficer Digital Book Series') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    {{ __t('বিসিএস প্রিলিমিনারি ও লিখিত ডিজিটাল বই সমগ্র', 'BCS Preliminary MCQ & Written Master Volumes') }}
                </h1>
                <p class="text-sm text-indigo-200/90 leading-relaxed">
                    {{ __t('প্রতিটি বিষয়ের টপিকভিত্তিক সুবিন্যস্ত বই। প্রিলিমিনারি বিগত বছরের নির্ভুল MCQ সমাধান এবং বিসিএস লিখিত পরীক্ষার জন্য সম্পূর্ণ মডেল উত্তর, প্রমাণ, ব্যাকরণ বিধি ও সংক্ষিপ্ত টিকা।', 'Topic-wise structured books for both Preliminary MCQ mastery and Written descriptive exam preparation.') }}
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 text-center min-w-[200px] shrink-0">
                <span class="text-[10px] font-black uppercase tracking-wider text-indigo-200 block mb-1">মোট বই কালেকশন</span>
                <div class="text-3xl font-black text-amber-300">{{ $books->count() }}টি ভলিউম</div>
                <span class="text-[11px] text-indigo-200 mt-1 block font-semibold">MCQ ও লিখিত সমন্বিত</span>
            </div>
        </div>
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
    </div>

    {{-- Books Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($books as $book)
            @php
                $totalMcqs = $book->chapters->sum('questions_count');
                $totalWritten = $book->chapters->sum('written_contents_count');
            @endphp
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                {{-- Book Cover Header --}}
                <div class="p-6 bg-gradient-to-br {{ $book->cover_theme }} text-white relative overflow-hidden">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-xs text-white border border-white/20">
                            {{ $book->edition }}
                        </span>
                        <span class="text-2xl">{{ $book->icon }}</span>
                    </div>

                    <h2 class="text-lg sm:text-xl font-black tracking-tight leading-snug">
                        {{ $book->title_bn }}
                    </h2>
                    <p class="text-xs text-white/80 font-medium mt-1">
                        {{ $book->title_en }}
                    </p>

                    <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                </div>

                {{-- Book Body Details --}}
                <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                        {{ $book->description_bn }}
                    </p>

                    {{-- Stats Bar --}}
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 text-center text-xs font-semibold">
                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase">অধ্যায়</span>
                            <span class="text-slate-800 dark:text-slate-200 font-black">{{ $book->chapters->count() }}টি</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase">MCQ প্রশ্ন</span>
                            <span class="text-indigo-600 dark:text-indigo-400 font-black">{{ $totalMcqs }}টি</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase">লিখিত বিষয়</span>
                            <span class="text-emerald-600 dark:text-emerald-400 font-black">{{ $totalWritten }}টি</span>
                        </div>
                    </div>

                    {{-- Chapters Preview --}}
                    <div class="space-y-1.5 pt-1">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">সূচিপত্র নমুনা:</span>
                        <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1">
                            @foreach($book->chapters->take(2) as $ch)
                                <li class="truncate flex items-center space-x-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shrink-0"></span>
                                    <span class="truncate">{{ $ch->title_bn }}</span>
                                </li>
                            @endforeach
                            @if($book->chapters->count() > 2)
                                <li class="text-[11px] text-indigo-600 dark:text-indigo-400 font-semibold">
                                    + আরও {{ $book->chapters->count() - 2 }}টি অধ্যায়...
                                </li>
                            @endif
                        </ul>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                        <a href="{{ route('books.show', $book->slug) }}"
                           class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-bold transition">
                            সূচিপত্র
                        </a>

                        <a href="{{ route('books.read', [$book->slug, 1]) }}"
                           class="flex-1 py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black text-center shadow-md shadow-indigo-600/20 transition flex items-center justify-center space-x-1.5">
                            <span>📖</span>
                            <span>বইটি পড়ুন →</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
