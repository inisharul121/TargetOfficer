@extends('layouts.student-layout')

@section('title', $activeChapter->title_bn . ' – ' . $book->title_bn . ' – TargetOfficer ই-বুক')

@section('content')
<div x-data="{
        fontSize: localStorage.getItem('ebook_font_size') || 'text-base',
        readingTheme: localStorage.getItem('ebook_theme') || 'theme-light',
        tocOpen: false,
        scrollProgress: 0,
        updateProgress() {
            const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            this.scrollProgress = height > 0 ? Math.min(100, Math.round((winScroll / height) * 100)) : 0;
        },
        setFont(size) {
            this.fontSize = size;
            localStorage.setItem('ebook_font_size', size);
        },
        setTheme(theme) {
            this.readingTheme = theme;
            localStorage.setItem('ebook_theme', theme);
        }
    }" 
    x-init="window.addEventListener('scroll', () => updateProgress()); updateProgress();"
    class="max-w-7xl mx-auto space-y-6">

    {{-- Top Reading Progress Bar (Fixed on top) --}}
    <div class="fixed top-0 left-0 right-0 z-50 h-1 bg-slate-200 dark:bg-slate-800">
        <div class="h-full bg-indigo-600 transition-all duration-150" :style="`width: ${scrollProgress}%`"></div>
    </div>

    {{-- Top Action & Reading Controls Toolbar --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-4 sm:p-5 border border-slate-200/90 dark:border-slate-800 shadow-xs flex flex-wrap items-center justify-between gap-4">
        {{-- Breadcrumb & Back --}}
        <div class="flex items-center space-x-3">
            <a href="{{ route('books.show', $book->slug) }}"
               class="px-3.5 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 transition flex items-center space-x-1">
                <span>←</span>
                <span class="hidden sm:inline">সূচিপত্রে ফিরে যান</span>
            </a>
            <div class="text-xs">
                <span class="text-slate-400 font-medium">{{ $book->title_bn }} / </span>
                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $activeChapter->title_bn }}</span>
            </div>
        </div>

        {{-- Reader Customization Tools (Font Scaling + Themes) --}}
        <div class="flex items-center space-x-3">
            
            {{-- Reading Theme Picker --}}
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold">
                <button type="button" 
                        @click="setTheme('theme-light')"
                        :class="readingTheme === 'theme-light' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900'"
                        class="px-2.5 py-1 rounded-xl transition flex items-center space-x-1"
                        title="দিন / স্বাভাবিক মোড">
                    <span>☀️</span>
                    <span class="hidden md:inline text-[11px]">লাইট</span>
                </button>
                <button type="button" 
                        @click="setTheme('theme-sepia')"
                        :class="readingTheme === 'theme-sepia' ? 'bg-[#f4ebd0] text-[#433422] shadow-xs' : 'text-slate-500 hover:text-slate-900'"
                        class="px-2.5 py-1 rounded-xl transition flex items-center space-x-1"
                        title="বই পড়ার আরামদায়ক সেপিয়া মোড">
                    <span>📖</span>
                    <span class="hidden md:inline text-[11px]">সেপিয়া</span>
                </button>
                <button type="button" 
                        @click="setTheme('theme-dark')"
                        :class="readingTheme === 'theme-dark' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:text-slate-300'"
                        class="px-2.5 py-1 rounded-xl transition flex items-center space-x-1"
                        title="রাতের ডার্ক মোড">
                    <span>🌙</span>
                    <span class="hidden md:inline text-[11px]">ডার্ক</span>
                </button>
            </div>

            {{-- Font Sizing Buttons --}}
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-black">
                <button type="button" 
                        @click="setFont('text-sm')"
                        :class="fontSize === 'text-sm' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-300 shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'"
                        class="px-2.5 py-1 rounded-xl transition"
                        title="ছোট ফন্ট (Small)">
                    A-
                </button>
                <button type="button" 
                        @click="setFont('text-base')"
                        :class="fontSize === 'text-base' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-300 shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'"
                        class="px-2.5 py-1 rounded-xl transition"
                        title="স্বাভাবিক ফন্ট (Medium)">
                    A
                </button>
                <button type="button" 
                        @click="setFont('text-lg')"
                        :class="fontSize === 'text-lg' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-300 shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'"
                        class="px-2.5 py-1 rounded-xl transition"
                        title="বড় ফন্ট (Large)">
                    A+
                </button>
                <button type="button" 
                        @click="setFont('text-xl')"
                        :class="fontSize === 'text-xl' ? 'bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-300 shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'"
                        class="px-2.5 py-1 rounded-xl transition"
                        title="খুব বড় ফন্ট (Extra Large)">
                    A++
                </button>
            </div>

            {{-- PDF / Print Button --}}
            <a href="{{ route('books.export', [$book->slug, $activeChapter->chapter_number]) }}"
               target="_blank"
               class="px-3.5 py-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex items-center space-x-1.5"
               title="অধ্যায় প্রিন্ট অথবা অফলাইন PDF সংরক্ষণ">
                <span>🖨️</span>
                <span class="hidden sm:inline">প্রিন্ট / PDF</span>
            </a>

            {{-- Mobile Drawer TOC Button --}}
            <button type="button"
                    @click="tocOpen = true"
                    class="lg:hidden p-2 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                    title="সূচিপত্র খুলুন">
                📑
            </button>
        </div>
    </div>

    {{-- Main Reading Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- Left Sticky Sidebar: Table of Contents --}}
        <aside class="hidden lg:block lg:col-span-1 space-y-4">
            <div class="sticky top-24 bg-white dark:bg-slate-900 rounded-3xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                {{-- Book Meta --}}
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-3xl">{{ $book->icon ?? '📖' }}</span>
                    <div>
                        <h3 class="text-xs font-black text-slate-900 dark:text-white leading-tight">
                            {{ $book->title_bn }}
                        </h3>
                        <span class="text-[10px] text-slate-400 font-bold block mt-0.5">
                            {{ $book->chapters->count() }}টি অধ্যায় • পূর্ণাঙ্গ থিওরি
                        </span>
                    </div>
                </div>

                {{-- Chapters List --}}
                <div class="space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 px-2 block mb-2">
                        বইয়ের অধ্যায়সমূহ
                    </span>
                    <div class="space-y-1 max-h-[65vh] overflow-y-auto pr-1">
                        @foreach($book->chapters as $ch)
                            @php
                                $isActive = $ch->id === $activeChapter->id;
                            @endphp
                            <a href="{{ route('books.read', [$book->slug, $ch->chapter_number]) }}"
                               class="flex items-center justify-between p-2.5 rounded-2xl text-xs font-bold transition group {{ $isActive ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <div class="flex items-center space-x-2 min-w-0">
                                    <span class="w-5 h-5 rounded-lg flex items-center justify-center text-[10px] font-black shrink-0 {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }}">
                                        {{ $ch->chapter_number }}
                                    </span>
                                    <span class="truncate">{{ $ch->title_bn }}</span>
                                </div>
                                <span class="text-[10px] px-1.5 py-0.5 rounded font-bold shrink-0 ml-1 {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}">
                                    {{ $ch->written_contents_count }} পাঠ
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
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
                        <a href="{{ route('books.read', [$book->slug, $ch->chapter_number]) }}"
                           class="block p-3 rounded-2xl text-xs font-bold transition {{ $isActive ? 'bg-indigo-600 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            {{ $ch->title_bn }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- Center Reading Container (Book Page Style) --}}
        <main class="lg:col-span-3 space-y-6">
            
            <article :class="{
                'bg-white text-slate-900 border-slate-200/90': readingTheme === 'theme-light',
                'bg-[#fcf7ed] text-[#3b2e20] border-[#ecdcc2]': readingTheme === 'theme-sepia',
                'bg-slate-900 text-slate-100 border-slate-800': readingTheme === 'theme-dark'
            }" class="rounded-3xl p-6 sm:p-10 border shadow-md transition-colors duration-200 space-y-8">
                
                {{-- Chapter Header --}}
                <header class="border-b pb-6 space-y-3"
                        :class="readingTheme === 'theme-sepia' ? 'border-[#e4d0b0]' : (readingTheme === 'theme-dark' ? 'border-slate-800' : 'border-slate-100')">
                    
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200/60 dark:bg-indigo-950/60 dark:text-indigo-400 dark:border-indigo-800">
                            {{ $book->title_bn }} • অধ্যায় {{ $activeChapter->chapter_number }}
                        </span>
                        
                        <div class="flex items-center space-x-3 text-xs text-slate-400">
                            <span>⏱️ পড়ার সময়: ~৮ মিনিট</span>
                            <span>•</span>
                            <span>{{ $writtenContents->count() }}টি টপিক/সেকশন</span>
                        </div>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                        {{ $activeChapter->title_bn }}
                    </h1>

                    @if($activeChapter->summary_bn)
                        <p class="text-sm font-medium leading-relaxed italic opacity-85"
                           :class="readingTheme === 'theme-sepia' ? 'text-[#6e5841]' : (readingTheme === 'theme-dark' ? 'text-slate-400' : 'text-slate-600')">
                            "{{ $activeChapter->summary_bn }}"
                        </p>
                    @endif
                </header>

                {{-- Book Text Contents --}}
                @if($writtenContents->isEmpty())
                    <div class="text-center py-16 space-y-3">
                        <span class="text-5xl">✍️</span>
                        <h3 class="text-base font-bold text-slate-700 dark:text-slate-300">এই অধ্যায়ের টেক্সট কন্টেন্ট দ্রুত যুক্ত করা হচ্ছে</h3>
                        <p class="text-xs text-slate-400">আমাদের বিশেষজ্ঞ প্যানেল বিসিএস প্রিলিমিনারি ও লিখিত পাঠ্যক্রম অনুযায়ী বইটি হালনাগাদ করছেন।</p>
                    </div>
                @else
                    <div class="space-y-10">
                        @foreach($writtenContents as $index => $wc)
                            <section id="section-{{ $wc->id }}" class="space-y-4 pt-4 first:pt-0">
                                
                                {{-- Section Title & Metadata Badges --}}
                                <div class="flex flex-wrap items-center justify-between gap-2 pb-2 border-b"
                                     :class="readingTheme === 'theme-sepia' ? 'border-[#ebd9be]' : (readingTheme === 'theme-dark' ? 'border-slate-800' : 'border-slate-100')">
                                    
                                    <div class="flex items-center space-x-2.5">
                                        <span class="w-7 h-7 rounded-xl bg-indigo-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-xs">
                                            {{ $index + 1 }}
                                        </span>
                                        <h2 class="text-lg font-black tracking-tight leading-snug">
                                            {{ $wc->title_bn }}
                                        </h2>
                                    </div>

                                    <div class="flex items-center space-x-2 text-xs font-bold">
                                        @if($wc->marks)
                                            <span class="px-2.5 py-0.5 rounded-lg bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20 font-mono">
                                                মান: {{ (int)$wc->marks }} নম্বর
                                            </span>
                                        @endif
                                        @if($wc->bcs_reference)
                                            <span class="px-2.5 py-0.5 rounded-lg bg-purple-500/10 text-purple-700 dark:text-purple-400 border border-purple-500/20">
                                                🏛️ {{ $wc->bcs_reference }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Question or Focus Prompt if present --}}
                                @if($wc->question_bn)
                                    <div class="p-4 rounded-2xl border text-sm font-bold leading-relaxed"
                                         :class="readingTheme === 'theme-sepia' ? 'bg-[#f5ecda] border-[#e2d0b5] text-[#4a3a29]' : (readingTheme === 'theme-dark' ? 'bg-slate-800/60 border-slate-700 text-slate-200' : 'bg-slate-50 border-slate-200 text-slate-800')">
                                        <span class="text-xs font-black uppercase tracking-wider block mb-1"
                                              :class="readingTheme === 'theme-sepia' ? 'text-[#846b4e]' : 'text-indigo-600 dark:text-indigo-400'">
                                            📌 বিসিএস লিখিত মডেল প্রশ্ন:
                                        </span>
                                        {{ $wc->question_bn }}
                                    </div>
                                @endif

                                {{-- Formatted Body Text --}}
                                <div class="leading-relaxed space-y-4 font-normal"
                                     :class="fontSize">
                                    <div class="ebook-text-body space-y-3"
                                         :class="readingTheme === 'theme-sepia' ? 'text-[#382b1d]' : (readingTheme === 'theme-dark' ? 'text-slate-200' : 'text-slate-800')">
                                        {!! $wc->content_bn !!}
                                    </div>
                                </div>
                            </section>
                        @endforeach
                    </div>
                @endif

                {{-- Bottom Navigation Controls --}}
                <div class="pt-8 border-t flex flex-wrap items-center justify-between gap-4"
                     :class="readingTheme === 'theme-sepia' ? 'border-[#ebd9be]' : (readingTheme === 'theme-dark' ? 'border-slate-800' : 'border-slate-100')">
                    
                    @if($previousChapter)
                        <a href="{{ route('books.read', [$book->slug, $previousChapter->chapter_number]) }}"
                           class="px-5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-bold transition flex items-center space-x-2">
                            <span>← পূর্ববর্তী অধ্যায়: {{ $previousChapter->chapter_number }}</span>
                        </a>
                    @else
                        <div></div>
                    @endif

                    <a href="{{ route('books.show', $book->slug) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold text-slate-400 hover:text-slate-600 transition">
                        সূচিপত্র
                    </a>

                    @if($nextChapter)
                        <a href="{{ route('books.read', [$book->slug, $nextChapter->chapter_number]) }}"
                           class="px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black shadow-md transition flex items-center space-x-2">
                            <span>পরবর্তী অধ্যায়: {{ $nextChapter->chapter_number }} →</span>
                        </a>
                    @endif
                </div>

            </article>

        </main>
    </div>

</div>

<style>
    /* Rich text reader styling */
    .ebook-text-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.25rem 0;
        font-size: 0.9em;
    }
    .ebook-text-body th, .ebook-text-body td {
        border: 1px solid rgba(148, 163, 184, 0.4);
        padding: 8px 12px;
        text-align: left;
    }
    .ebook-text-body th {
        background-color: rgba(99, 102, 241, 0.08);
        font-weight: bold;
    }
    .ebook-text-body ul, .ebook-text-body ol {
        margin-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .ebook-text-body ul {
        list-style-type: disc;
    }
    .ebook-text-body ol {
        list-style-type: decimal;
    }
    .ebook-text-body strong {
        font-weight: 700;
    }
</style>
@endsection
