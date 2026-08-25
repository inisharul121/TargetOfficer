@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-b from-indigo-900 via-slate-900 to-slate-950 text-white pt-16 pb-24 md:py-28">
    <!-- Glow effects -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-indigo-500/20 blur-3xl pointer-events-none rounded-full"></div>
    <div class="absolute -top-24 right-10 w-80 h-80 bg-violet-500/20 blur-3xl pointer-events-none rounded-full"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-400/20 text-indigo-300 text-xs font-semibold uppercase tracking-wider mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>বিসিএস ও ব্যাংক নিয়োগ পরীক্ষার আধুনিক প্রস্তুতি প্ল্যাটফর্ম</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight leading-tight sm:leading-none">
                Precision Preparation for <br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-300 via-violet-300 to-amber-300">Public Service.</span>
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto">
                <strong class="text-white">Aim High. Aim Officer.</strong> প্রশ্নকর্তা প্যাটার্ন বিশ্লেষণ (BUET, IBA, BPSC, Arts), রিয়েল-টাইম লাইভ মডেল টেস্ট ও স্মার্ট নেগেটিভ মার্কিং অ্যানালিটিক্স।
            </p>

            <!-- CTA Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('exams.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold text-base shadow-lg shadow-indigo-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2">
                    <span>মডেল টেস্ট শুরু করুন</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('demo.login', 'student') }}" class="w-full sm:w-auto px-6 py-4 rounded-2xl bg-slate-800/80 hover:bg-slate-800 text-slate-200 border border-slate-700 font-bold text-base transition flex items-center justify-center space-x-2">
                    <span>🚀 ডেমো ক্যান্ডিডেট ট্রায়াল</span>
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="mt-14 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto pt-8 border-t border-slate-800/80">
                <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/50 backdrop-blur-xs">
                    <div class="text-2xl sm:text-3xl font-extrabold text-white">{{ $totalQuestions }}+</div>
                    <div class="text-xs text-slate-400 font-medium mt-1">ব্যাখ্যাত্মক প্রশ্ন ব্যাংক</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/50 backdrop-blur-xs">
                    <div class="text-2xl sm:text-3xl font-extrabold text-indigo-400">০.৫০ / ০.২৫</div>
                    <div class="text-xs text-slate-400 font-medium mt-1">স্ট্যান্ডার্ড নেগেটিভ মার্কিং</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/50 backdrop-blur-xs">
                    <div class="text-2xl sm:text-3xl font-extrabold text-amber-400">BUET / IBA</div>
                    <div class="text-xs text-slate-400 font-medium mt-1">প্রশ্নকর্তা প্যাটার্ন ট্যাগিং</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/50 backdrop-blur-xs">
                    <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">100%</div>
                    <div class="text-xs text-slate-400 font-medium mt-1">অফলাইন-রেজিলিয়েন্ট অটো-সেভ</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Question-Setter Pattern Breakdown Section -->
<div class="py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">ইনোভেশন ও স্পেশালাইজেশন</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-3">প্রশ্নকর্তা সংস্থাভিত্তিক প্যাটার্ন বিশ্লেষণ</h2>
            <p class="text-slate-600 mt-2 text-sm">বিসিএস ও ব্যাংক পরীক্ষায় প্রতিটি পরীক্ষা গ্রহণকারী সংস্থার নিজস্ব প্রশ্ন করার স্টাইল থাকে। টার্গেট অফিসারে সংস্থা অনুযায়ী স্পেশালাইজড প্রস্তুতি নিন।</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($setterBodies as $setter)
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-lg hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 font-black text-sm flex items-center justify-center border border-indigo-100 mb-4">
                            {{ $setter->code }}
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $setter->name_bn }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $setter->name_en }}</p>
                        <p class="text-xs text-slate-600 mt-3 leading-relaxed">{{ $setter->description }}</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">{{ $setter->setter_questions_count }} প্রশ্ন সংরক্ষিত</span>
                        <a href="{{ route('question-bank.index', ['setter' => $setter->id]) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1">
                            <span>অনুশীলন</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Exams Section -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">রিয়েল-টাইম টেস্ট</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-3">জনপ্রিয় ও আসন্ন মডেল টেস্ট</h2>
                <p class="text-slate-600 mt-1 text-sm">অফিসিয়াল সময় ও প্রশ্ন কাঠামোর সাথে সংগতিপূর্ণ পূর্ণাঙ্গ মডেল টেস্ট।</p>
            </div>
            <a href="{{ route('exams.index') }}" class="mt-4 md:mt-0 inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 space-x-1">
                <span>সকল মডেল টেস্ট দেখুন</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredExams as $exam)
                <div class="bg-slate-50/80 hover:bg-white rounded-2xl p-6 border border-slate-200 hover:border-indigo-200 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-lg {{ $exam->exam_mode === 'timed_mock' ? 'bg-indigo-100 text-indigo-700' : ($exam->exam_mode === 'practice' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ $exam->exam_mode === 'timed_mock' ? '⏱️ Timed Mock' : ($exam->exam_mode === 'practice' ? '💡 Practice Mode' : '⚡ Daily Quiz') }}
                            </span>
                            @if($exam->organization)
                                <span class="text-xs font-semibold text-slate-500 bg-slate-200/70 px-2 py-0.5 rounded">{{ $exam->organization->code }}</span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition leading-snug">{{ $exam->title_bn }}</h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $exam->description_bn }}</p>

                        <div class="grid grid-cols-3 gap-2 mt-6 pt-4 border-t border-slate-200/70 text-center">
                            <div class="bg-white rounded-xl p-2 border border-slate-100">
                                <div class="text-xs font-bold text-slate-800">{{ $exam->total_questions }} টি</div>
                                <div class="text-[10px] text-slate-400 font-medium">প্রশ্ন</div>
                            </div>
                            <div class="bg-white rounded-xl p-2 border border-slate-100">
                                <div class="text-xs font-bold text-slate-800">{{ $exam->duration_minutes > 0 ? $exam->duration_minutes . ' মিনিট' : 'আনলিমিটেড' }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">সময়</div>
                            </div>
                            <div class="bg-white rounded-xl p-2 border border-slate-100">
                                <div class="text-xs font-bold text-rose-600">-{{ $exam->negative_mark_per_question }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">নেগেটিভ</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('exams.show', $exam->slug) }}" class="w-full py-2.5 rounded-xl bg-indigo-600 group-hover:bg-indigo-700 text-white font-bold text-sm flex items-center justify-center space-x-2 shadow-xs transition">
                            <span>অংশগ্রহণ করুন</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Subjects Taxonomy Section -->
<div class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">সিলেবাস কভারেজ</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-3">বিষয়ভিত্তিক সম্পূর্ণ সিলেবাস ও প্রস্তুতি</h2>
            <p class="text-slate-600 mt-2 text-sm">বিসিএস প্রিলিমিনারি ও ব্যাংক পরীক্ষার ১০টি বিষয়ের টপিক-ভিত্তিক প্রশ্ন ও সমাধান।</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($subjects as $subj)
                <a href="{{ route('practice.index', ['subject' => $subj->slug]) }}" class="group bg-white p-5 rounded-2xl border border-slate-200/80 hover:border-indigo-400 hover:shadow-md transition duration-200 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center font-bold text-white shadow-sm" style="background-color: {{ $subj->color }}">
                            {{ mb_substr($subj->name_bn, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 group-hover:text-indigo-600 transition text-sm">{{ $subj->name_bn }}</h3>
                            <p class="text-xs text-slate-400">{{ $subj->questions_count }} প্রশ্ন সংগৃহীত</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA Banner -->
<div class="bg-indigo-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold tracking-tight">আপনার সরকারি চাকরির স্বপ্নকে দিন নিখুঁত রূপ</h2>
        <p class="mt-3 text-indigo-200 text-base max-w-xl mx-auto">টার্গেট অফিসারের সাথে আজই আপনার প্র্যাকটিস শুরু করুন এবং পরীক্ষার হলে শতভাগ আত্মবিশ্বাসী থাকুন।</p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold text-sm shadow-md transition">বিনামূল্যে শুরু করুন</a>
            <a href="{{ route('demo.login', 'admin') }}" class="px-6 py-3.5 rounded-xl bg-indigo-800 hover:bg-indigo-700 text-white font-bold text-sm border border-indigo-700 transition">এডমিন ডেমো এক্সেস</a>
        </div>
    </div>
</div>
@endsection
