@extends('layouts.student-layout')

@section('title', $book->title_bn . ' – সূচিপত্র')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    {{-- Back Link --}}
    <a href="{{ route('books.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>{{ __t('সকল বইয়ের তালিকায় ফিরুন', 'Back to Books') }}</span>
    </a>

    {{-- Book Header Card --}}
    <div class="rounded-3xl p-6 sm:p-8 bg-gradient-to-br {{ $book->cover_theme }} text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 space-y-3 max-w-3xl">
            <div class="flex items-center space-x-2">
                <span class="text-3xl">{{ $book->icon }}</span>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-xs text-white border border-white/20">
                    {{ $book->edition }}
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-snug">
                {{ $book->title_bn }}
            </h1>
            <p class="text-xs sm:text-sm text-white/90 leading-relaxed font-medium">
                {{ $book->description_bn }}
            </p>

            <div class="pt-3 flex items-center space-x-3">
                <a href="{{ route('books.read', [$book->slug, 1]) }}"
                   class="px-6 py-3 rounded-2xl bg-white text-indigo-900 font-black text-xs shadow-md hover:bg-indigo-50 transition flex items-center space-x-2">
                    <span>📖</span>
                    <span>১ম অধ্যায় থেকে পড়া শুরু করুন →</span>
                </a>
            </div>
        </div>
        <div class="absolute -right-8 -bottom-8 w-56 h-56 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
    </div>

    {{-- Table of Contents --}}
    <div class="space-y-4">
        <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center space-x-2">
            <span>📑</span>
            <span>অধ্যায় ও সূচিপত্র (Table of Contents)</span>
        </h2>

        <div class="space-y-3">
            @foreach($book->chapters as $ch)
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-indigo-300 dark:hover:border-indigo-700 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start space-x-4">
                        <span class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 font-black text-sm flex items-center justify-center shrink-0 mt-0.5">
                            {{ $ch->chapter_number }}
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $ch->title_bn }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                {{ $ch->summary_bn }}
                            </p>
                            <div class="flex items-center space-x-3 text-[11px] pt-1">
                                <span class="text-indigo-600 dark:text-indigo-400 font-bold">📚 {{ $ch->written_contents_count }}টি বিশদ পাঠ ও টপিক</span>
                                <span class="text-slate-300 dark:text-slate-600">•</span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">⏱️ ~৮ মিনিট পাঠ</span>
                                <span class="text-slate-300 dark:text-slate-600">•</span>
                                <span class="text-purple-600 dark:text-purple-400 font-bold">🏛️ পূর্ণাঙ্গ থিওরি ও লিখিত গাইড</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 shrink-0 sm:self-center pl-14 sm:pl-0">
                        <a href="{{ route('books.read', [$book->slug, $ch->chapter_number]) }}"
                           class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex items-center space-x-1.5">
                            <span>পড়ুন →</span>
                        </a>
                        <a href="{{ route('books.export', [$book->slug, $ch->chapter_number]) }}"
                           class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-xs transition"
                           title="অধ্যায় প্রিন্ট / PDF">
                            🖨️ PDF
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
