@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-slate-50 border-b border-slate-200 text-slate-900 pt-16 pb-20 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-6">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span>{{ __t('বিসিএস ও ব্যাংক নিয়োগ পরীক্ষার আধুনিক প্রস্তুতি প্ল্যাটফর্ম', 'Premier Online Preparation Engine for BCS & Public Exams') }}</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight leading-tight text-slate-900">
                Precision Preparation for <br>
                <span class="text-indigo-600">Public Service.</span>
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto font-medium">
                <strong class="text-slate-900">Aim High. Aim Officer.</strong> {{ __t('প্রশ্নকর্তা প্যাটার্ন বিশ্লেষণ (BUET, IBA, BPSC, Arts), রিয়েল-টাইম লাইভ মডেল টেস্ট ও স্মার্ট নেগেটিভ মার্কিং অ্যানালিটিক্স।', 'Question-setter pattern analysis (BUET, IBA, BPSC, Arts), real-time live model tests & smart negative marking analytics.') }}
            </p>

            <!-- CTA Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('exams.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-base shadow-xs transition flex items-center justify-center space-x-2">
                    <span>{{ __t('মডেল টেস্ট শুরু করুন', 'Start Model Test') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('demo.login', 'student') }}" class="w-full sm:w-auto px-6 py-4 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 font-bold text-base transition flex items-center justify-center space-x-2">
                    <span>🚀 {{ __t('ডেমো ক্যান্ডিডেট ট্রায়াল', 'Demo Candidate Login') }}</span>
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="mt-14 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto pt-8 border-t border-slate-200">
                <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ $totalQuestions }}+</div>
                    <div class="text-xs text-slate-500 font-medium mt-1">{{ __t('ব্যাখ্যাত্মক প্রশ্ন ব্যাংক', 'Explanatory Question Bank') }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900">0.50 / 0.25</div>
                    <div class="text-xs text-slate-500 font-medium mt-1">{{ __t('স্ট্যান্ডার্ড নেগেটিভ মার্কিং', 'Standard Negative Marking') }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
                    <div class="text-2xl sm:text-3xl font-black text-indigo-600">BUET / IBA</div>
                    <div class="text-xs text-slate-500 font-medium mt-1">{{ __t('প্রশ্নকর্তা প্যাটার্ন ট্যাগিং', 'Setter Body Pattern Tagging') }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600">100%</div>
                    <div class="text-xs text-slate-500 font-medium mt-1">{{ __t('অফলাইন-রেজিলিয়েন্ট অটো-সেভ', 'Offline-Resilient Auto-Save') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Question Setter Bodies Section -->
<div class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200">{{ __t('প্রশ্নকর্তা ভিত্তিক প্রস্তুতি', 'Setter-Specific Engine') }}</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-3">{{ __t('কোন সংস্থা প্রশ্ন করছে? প্যাটার্ন অনুযায়ী প্রস্তুতি নিন', 'Targeted Setter Body Patterns') }}</h2>
            <p class="text-slate-600 mt-2 text-sm">{{ __t('বুয়েট, আইবিএ ও বিপিএসসি এর অতীত প্রশ্নের প্যাটার্ন, কাঠিন্য ও টপিক অগ্রাধিকার বিশ্লেষণ করে তৈরি পরীক্ষা।', 'Analyze previous questions, difficulty, and priority topics from major exam bodies.') }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach(($setterBodies ?? $setterOrganizations ?? []) as $setter)
                <a href="{{ route('question-bank.index', ['setter' => $setter->id]) }}" class="group bg-slate-50 hover:bg-indigo-50 p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 transition duration-200 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-black text-sm text-slate-800 group-hover:text-indigo-600 shadow-2xs">
                            {{ $setter->code }}
                        </div>
                        <h3 class="font-bold text-slate-900 mt-3 text-sm group-hover:text-indigo-700 transition leading-snug">{{ __t($setter->name_bn, $setter->name_en) }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $setter->description_bn }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-indigo-600">
                        <span>{{ $setter->setter_questions_count ?? $setter->questions_count ?? 0 }} {{ __t('টি প্রশ্ন', 'Questions') }}</span>
                        <span>→</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Live & Timed Mock Tests Section -->
<div class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200">{{ __t('লাইভ ও প্র্যাকটিস টেস্ট', 'Live & Practice Exams') }}</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">{{ __t('জনপ্রিয় মডেল টেস্টসমূহ', 'Popular Model Tests') }}</h2>
            </div>
            <a href="{{ route('exams.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center space-x-1">
                <span>{{ __t('সবগুলো দেখুন', 'View All Tests') }}</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredExams as $exam)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs hover:border-slate-300 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg {{ $exam->exam_mode === 'timed_mock' ? 'bg-indigo-50 text-indigo-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $exam->exam_mode === 'timed_mock' ? '⏱️ Timed Mock' : '💡 Practice Mode' }}
                            </span>
                            @if($exam->organization)
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $exam->organization->code }}</span>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition leading-snug">{{ $exam->title_bn }}</h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $exam->description_bn }}</p>

                        <div class="grid grid-cols-3 gap-2 mt-6 pt-4 border-t border-slate-100 text-center">
                            <div class="bg-slate-50 rounded-xl p-2 border border-slate-100">
                                <div class="text-xs font-bold text-slate-800">{{ $exam->total_questions }} {{ __t('টি', '') }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ __t('প্রশ্ন', 'Questions') }}</div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-2 border border-slate-100">
                                <div class="text-xs font-bold text-slate-800">{{ $exam->duration_minutes > 0 ? $exam->duration_minutes . ' ' . __t('মিনিট', 'm') : __t('আনলিমিটেড', 'Unlimited') }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ __t('সময়', 'Time') }}</div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-2 border border-slate-100">
                                <div class="text-xs font-bold text-rose-600">-{{ $exam->negative_mark_per_question }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ __t('নেগেটিভ', 'Negative') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('exams.show', $exam->slug) }}" class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm flex items-center justify-center space-x-2 shadow-xs transition">
                            <span>{{ __t('অংশগ্রহণ করুন', 'Take Exam') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Subjects Taxonomy Section -->
<div class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200">{{ __t('সিলেবাস কভারেজ', 'Syllabus Coverage') }}</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-3">{{ __t('বিষয়ভিত্তিক সম্পূর্ণ সিলেবাস ও প্রস্তুতি', 'Subject-wise Complete Syllabus & Practice') }}</h2>
            <p class="text-slate-600 mt-2 text-sm">{{ __t('বিসিএস প্রিলিমিনারি ও ব্যাংক পরীক্ষার ১০টি বিষয়ের টপিক-ভিত্তিক প্রশ্ন ও সমাধান।', 'Topic-wise questions & solutions across core public exam subjects.') }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($subjects as $subj)
                <a href="{{ route('practice.index', ['subject' => $subj->slug]) }}" class="group bg-slate-50 hover:bg-indigo-50 p-4 rounded-2xl border border-slate-200 hover:border-indigo-300 transition duration-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white shadow-xs" style="background-color: {{ $subj->color }}">
                            {{ mb_substr($subj->name_bn, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 group-hover:text-indigo-700 transition text-sm">{{ __t($subj->name_bn, $subj->name_en) }}</h3>
                            <p class="text-xs text-slate-500">{{ $subj->questions_count }} {{ __t('প্রশ্ন সংগৃহীত', 'questions archived') }}</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA Banner -->
<div class="bg-indigo-50 border-t border-indigo-200 py-16 text-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold tracking-tight">{{ __t('আপনার সরকারি চাকরির স্বপ্নকে দিন নিখুঁত রূপ', 'Fulfill Your Dream of Public Service') }}</h2>
        <p class="mt-3 text-slate-600 text-base max-w-xl mx-auto">{{ __t('টার্গেট অফিসারের সাথে আজই আপনার প্র্যাকটিস শুরু করুন এবং পরীক্ষার হলে শতভাগ আত্মবিশ্বাসী থাকুন।', 'Start your practice on TargetOfficer today and face your exams with 100% confidence.') }}</p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm shadow-xs transition">{{ __t('বিনামূল্যে শুরু করুন', 'Start for Free') }}</a>
            <a href="{{ route('demo.login', 'admin') }}" class="px-6 py-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-sm border border-slate-300 transition">{{ __t('এডমিন ডেমো এক্সেস', 'Admin Demo Access') }}</a>
        </div>
    </div>
</div>
@endsection
