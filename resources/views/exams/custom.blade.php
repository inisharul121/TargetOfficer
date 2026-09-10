@extends('layouts.student-layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-indigo-950 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 space-y-3">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold">
                    <span>⚡</span>
                    <span>{{ __t('স্মার্ট টেস্ট জেনারেটর', 'Smart Test Generator') }}</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black tracking-tight">
                    {{ __t('কাস্টম পরীক্ষা তৈরি করুন', 'Create Custom Exam') }}
                </h1>
                <p class="text-xs sm:text-sm text-indigo-200 max-w-2xl leading-relaxed font-medium">
                    {{ __t('পরীক্ষা ভিত্তিক (১০ম/১১তম বিসিএস), প্রশ্নকর্তা ভিত্তিক (BPSC/BUET/IBA) অথবা বিষয় ও টপিক সিলেক্ট করে নির্দিষ্ট সংখ্যক প্রশ্নের তাৎক্ষণিক পরীক্ষা দিন।', 'Generate tailored practice exams by filtering by Exam, Exam Taker, Subject, or your personal Mistake Bank.') }}
                </p>
            </div>
        </div>

        <!-- Quick Status Pills -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                <div class="text-xs text-slate-400 font-semibold">{{ __t('মোট প্রশ্ন পুলে', 'Total in Bank') }}</div>
                <div class="text-lg font-black text-slate-900 mt-0.5">{{ $totalPublishedQuestions }} {{ __t('টি', '') }}</div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                <div class="text-xs text-slate-400 font-semibold">{{ __t('এখনও না দেওয়া', 'Unattempted') }}</div>
                <div class="text-lg font-black text-indigo-600 mt-0.5">{{ $unattemptedCount }} {{ __t('টি', '') }}</div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                <div class="text-xs text-slate-400 font-semibold">{{ __t('ভুল করা প্রশ্ন', 'Mistakes') }}</div>
                <div class="text-lg font-black text-rose-600 mt-0.5">{{ $mistakeCount }} {{ __t('টি', '') }}</div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                <div class="text-xs text-slate-400 font-semibold">{{ __t('বুকমার্ক করা', 'Bookmarked') }}</div>
                <div class="text-lg font-black text-amber-600 mt-0.5">{{ $bookmarkedCount }} {{ __t('টি', '') }}</div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm"
             x-data="{
                examId: '{{ request('exam_id') ?? '' }}',
                setterId: '{{ request('setter_id') ?? '' }}',
                subjectId: '{{ request('subject_id') ?? '' }}',
                topicId: '',
                poolType: '{{ request('pool') ?? 'all' }}',
                questionCount: '{{ request('count') ?? '20' }}',
                duration: 20,
                negativeMark: '0.50',
                difficulty: 'medium',
                updateDuration() {
                    this.duration = this.questionCount;
                }
             }">

            <form action="{{ route('exams.custom.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Section 1: Exam & Exam Taker Filter -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-xs">১</span>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">{{ __t('পরীক্ষা ও প্রশ্নকর্তা ফিল্টার (Exam & Setter Filter)', 'Exam & Setter Filter') }}</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Exam Selection -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                <span>{{ __t('নির্দিষ্ট পরীক্ষা (Exam Source)', 'Exam Source') }}</span>
                                <span class="text-[11px] text-slate-400 font-normal">{{ __t('ঐচ্ছিক', 'Optional') }}</span>
                            </label>
                            <select name="exam_id" x-model="examId" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white font-medium">
                                <option value="">{{ __t('সকল পরীক্ষা (All Exams)', 'All Exams') }}</option>
                                @foreach($exams as $ex)
                                    <option value="{{ $ex->id }}">🎓 {{ $ex->title_bn }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Setter Organization -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                <span>{{ __t('প্রশ্নকর্তা সংস্থা / প্যাটার্ন (Exam Taker)', 'Exam Taker / Setter') }}</span>
                                <span class="text-[11px] text-slate-400 font-normal">{{ __t('ঐচ্ছিক', 'Optional') }}</span>
                            </label>
                            <select name="setter_organization_id" x-model="setterId" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white font-medium">
                                <option value="">{{ __t('সকল প্যাটার্ন (BUET, IBA, BPSC ইত্যাদি)', 'All Patterns (BUET, IBA, BPSC etc.)') }}</option>
                                @foreach($setters as $setter)
                                    <option value="{{ $setter->id }}">🏛️ {{ $setter->name_bn }} ({{ $setter->code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Subject & Topic Filter -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-xs">২</span>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">{{ __t('বিষয় ও টপিক (Subject & Topic Selection)', 'Subject & Topic Selection') }}</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                {{ __t('বিষয় নির্বাচন করুন', 'Select Subject') }}
                            </label>
                            <select name="subject_id" x-model="subjectId" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white font-medium">
                                <option value="">{{ __t('সকল বিষয় (কম্বাইন্ড / All Subjects)', 'All Subjects') }}</option>
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj->id }}">📖 {{ __t($subj->name_bn, $subj->name_en) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                <span>{{ __t('কাঠিন্যের মাত্রা (Difficulty)', 'Difficulty') }}</span>
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="p-2 rounded-xl border text-center cursor-pointer text-xs font-bold transition"
                                       :class="difficulty === 'easy' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'bg-slate-50 border-slate-200 text-slate-600'">
                                    <input type="radio" name="difficulty" value="easy" x-model="difficulty" class="hidden">
                                    {{ __t('সহজ', 'Easy') }}
                                </label>
                                <label class="p-2 rounded-xl border text-center cursor-pointer text-xs font-bold transition"
                                       :class="difficulty === 'medium' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'bg-slate-50 border-slate-200 text-slate-600'">
                                    <input type="radio" name="difficulty" value="medium" x-model="difficulty" class="hidden">
                                    {{ __t('মাঝারি', 'Medium') }}
                                </label>
                                <label class="p-2 rounded-xl border text-center cursor-pointer text-xs font-bold transition"
                                       :class="difficulty === 'hard' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'bg-slate-50 border-slate-200 text-slate-600'">
                                    <input type="radio" name="difficulty" value="hard" x-model="difficulty" class="hidden">
                                    {{ __t('কঠিন', 'Hard') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Question Pool Selection -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-xs">৩</span>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">{{ __t('প্রশ্নের উৎস / পুল (Question Pool)', 'Question Pool') }}</h2>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <label class="p-3.5 rounded-2xl border cursor-pointer flex flex-col items-center text-center space-y-1 transition"
                               :class="poolType === 'all' ? 'bg-indigo-50/80 border-indigo-600 ring-2 ring-indigo-600/20 text-indigo-900 font-black' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100 font-bold'">
                            <input type="radio" name="pool_type" value="all" x-model="poolType" class="hidden">
                            <span class="text-xl">🌐</span>
                            <span class="text-xs">{{ __t('সকল প্রশ্ন', 'All Questions') }}</span>
                            <span class="text-[10px] text-slate-400 font-normal">র‍্যান্ডম প্রশ্ন পুল</span>
                        </label>

                        <label class="p-3.5 rounded-2xl border cursor-pointer flex flex-col items-center text-center space-y-1 transition"
                               :class="poolType === 'unattempted' ? 'bg-indigo-50/80 border-indigo-600 ring-2 ring-indigo-600/20 text-indigo-900 font-black' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100 font-bold'">
                            <input type="radio" name="pool_type" value="unattempted" x-model="poolType" class="hidden">
                            <span class="text-xl">✨</span>
                            <span class="text-xs">{{ __t('না দেওয়া প্রশ্ন', 'Unattempted') }}</span>
                            <span class="text-[10px] text-slate-400 font-normal">নতুন প্রশ্নসমূহ</span>
                        </label>

                        <label class="p-3.5 rounded-2xl border cursor-pointer flex flex-col items-center text-center space-y-1 transition"
                               :class="poolType === 'mistakes' ? 'bg-rose-50 border-rose-600 ring-2 ring-rose-600/20 text-rose-950 font-black' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100 font-bold'">
                            <input type="radio" name="pool_type" value="mistakes" x-model="poolType" class="hidden">
                            <span class="text-xl">🎯</span>
                            <span class="text-xs">{{ __t('ভুল উত্তরের ব্যাংক', 'Mistake Bank') }}</span>
                            <span class="text-[10px] text-rose-500 font-bold">({{ $mistakeCount }}টি প্রশ্ন)</span>
                        </label>

                        <label class="p-3.5 rounded-2xl border cursor-pointer flex flex-col items-center text-center space-y-1 transition"
                               :class="poolType === 'bookmarked' ? 'bg-amber-50 border-amber-600 ring-2 ring-amber-600/20 text-amber-950 font-black' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100 font-bold'">
                            <input type="radio" name="pool_type" value="bookmarked" x-model="poolType" class="hidden">
                            <span class="text-xl">⭐</span>
                            <span class="text-xs">{{ __t('বুকমার্ক প্রশ্ন', 'Bookmarked') }}</span>
                            <span class="text-[10px] text-amber-600 font-bold">({{ $bookmarkedCount }}টি প্রশ্ন)</span>
                        </label>
                    </div>
                </div>

                <!-- Section 4: Question Count, Time & Negative Marking -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 border-b border-slate-100 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold text-xs">৪</span>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">{{ __t('প্রশ্নের সংখ্যা ও পরীক্ষার নিয়ম (Settings)', 'Test Configuration') }}</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Number of Questions -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __t('প্রশ্নের সংখ্যা', 'Question Count') }}</label>
                            <select name="question_count" x-model="questionCount" @change="updateDuration()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white font-bold text-slate-900">
                                <option value="10">১০ টি প্রশ্ন (10 Questions)</option>
                                <option value="20">২০ টি প্রশ্ন (20 Questions)</option>
                                <option value="25">২৫ টি প্রশ্ন (25 Questions)</option>
                                <option value="50">৫০ টি প্রশ্ন (50 Questions)</option>
                                <option value="100">১০০ টি প্রশ্ন (Full Mock - 100 Q)</option>
                            </select>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __t('সময়সীমা (মিনিট)', 'Duration (Minutes)') }}</label>
                            <select name="duration_minutes" x-model="duration" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white font-bold text-slate-900">
                                <option :value="questionCount" x-text="`${questionCount} মিনিট (১ মিনিট/প্রশ্ন)`"></option>
                                <option value="15">১৫ মিনিট</option>
                                <option value="30">৩০ মিনিট</option>
                                <option value="60">৬০ মিনিট (১ ঘণ্টা)</option>
                                <option value="120">১২০ মিনিট (২ ঘণ্টা)</option>
                            </select>
                        </div>

                        <!-- Negative Marking -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">{{ __t('নেগেটিভ মার্কিং', 'Negative Marking') }}</label>
                            <select name="negative_marking" x-model="negativeMark" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white font-bold text-slate-900">
                                <option value="0.50">০.৫০ মার্ক (বিসিএস স্ট্যান্ডার্ড)</option>
                                <option value="0.25">০.২৫ মার্ক (ব্যাংক স্ট্যান্ডার্ড)</option>
                                <option value="0.00">নেগেটিভ মার্ক নেই (প্র্যাকটিস)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm sm:text-base shadow-lg shadow-indigo-600/30 transition flex items-center justify-center space-x-2">
                        <span>⚡</span>
                        <span>{{ __t('কাস্টম পরীক্ষা তৈরি ও শুরু করুন', 'Generate & Start Custom Exam') }}</span>
                    </button>
                    <p class="text-center text-[11px] text-slate-400 mt-2 font-medium">
                        {{ __t('পরীক্ষার সময় স্বয়ংক্রিয়ভাবে টাইমার এবং ফলাফল ট্র্যাকিং সক্রিয় থাকবে।', 'Timer, instant results, and progress metrics will be recorded automatically.') }}
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
