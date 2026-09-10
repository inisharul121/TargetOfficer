@extends('layouts.student-layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-200">
                    <span>📊</span>
                    <span>{{ __t('শিক্ষার্থী অগ্রগতি ট্র্যাকার', 'Student Performance Tracker') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-2">
                    {{ __t('আমার পারফরম্যান্স ও অগ্রগতি বিশ্লেষণ', 'My Performance & Progress Analytics') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    {{ __t('বিষয়ভিত্তিক ও প্রশ্নকর্তা প্যাটার্ন অনুযায়ী আপনার সবল ও দুর্বল দিকগুলো পর্যবেক্ষণ করুন।', 'Monitor your mastery across subjects, exam setters (BPSC/BUET/IBA), and past-year BCS archives.') }}
                </p>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('exams.custom') }}" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex items-center space-x-1.5">
                    <span>⚡</span>
                    <span>{{ __t('কাস্টম পরীক্ষা দিন', 'Take Custom Test') }}</span>
                </a>
                <a href="{{ route('student.mistakes') }}" class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs transition flex items-center space-x-1.5">
                    <span>🎯</span>
                    <span>{{ __t('ভুল উত্তরের ব্যাংক', 'Mistake Bank') }} ({{ $mistakeCount }})</span>
                </a>
            </div>
        </div>

        <!-- 4 Top Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('মোট পরীক্ষা সম্পন্ন', 'Total Exams') }}</span>
                    <div class="text-2xl sm:text-3xl font-black mt-1 text-slate-900">{{ $totalAttempts }} {{ __t('টি', '') }}</div>
                    <span class="text-[10px] font-bold text-emerald-600">✓ {{ $totalAnswersCount }} {{ __t('প্রশ্ন সমাধান', 'questions solved') }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-indigo-50 text-indigo-600 border border-indigo-100">📝</div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('গড় নির্ভুলতা (Accuracy)', 'Avg Accuracy') }}</span>
                    <div class="text-2xl sm:text-3xl font-black mt-1 text-emerald-600">{{ number_format($overallAccuracy, 1) }}%</div>
                    <span class="text-[10px] font-bold text-slate-500">{{ $totalCorrectCount }} {{ __t('টি সঠিক উত্তর', 'correct') }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-emerald-50 text-emerald-600 border border-emerald-100">🎯</div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('স্টাডি স্ট্রাইক', 'Study Streak') }}</span>
                    <div class="text-2xl sm:text-3xl font-black mt-1 text-amber-600">{{ $user->daily_streak }} {{ __t('দিন', 'Days') }} 🔥</div>
                    <span class="text-[10px] font-bold text-slate-500">{{ __t('সর্বোচ্চ:', 'Best:') }} {{ $user->longest_streak }} {{ __t('দিন', 'Days') }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-amber-50 text-amber-600 border border-amber-100">🔥</div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __t('অর্জিত কয়েন', 'Coins Earned') }}</span>
                    <div class="text-2xl sm:text-3xl font-black mt-1 text-indigo-700">🪙 {{ $user->coins }}</div>
                    <span class="text-[10px] font-bold text-teal-600">{{ __t('ফ্রি স্টাডি রিওয়ার্ড', 'Free Study Reward') }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-sky-50 text-sky-600 border border-sky-100">🪙</div>
            </div>
        </div>

        <!-- Section 1: Subject-wise Performance Breakdown -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center space-x-2">
                        <span class="text-indigo-600">📖</span>
                        <span>{{ __t('বিষয়ভিত্তিক প্রস্তুতি ও পারফরম্যান্স (Subject-wise Mastery)', 'Subject-wise Performance') }}</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ __t('আপনার সবল ও দুর্বল বিষয়গুলো পর্যবেক্ষণ করে প্রস্তুতিকে সমৃদ্ধ করুন।', 'Identify your strengths and weaknesses to optimize preparation.') }}</p>
                </div>
                <a href="{{ route('practice.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                    {{ __t('সকল বিষয়ের রিডিং মোড →', 'Browse Reading Mode →') }}
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($subjectPerformances as $sp)
                    <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-indigo-300 transition-all space-y-3 shadow-2xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold text-slate-900 flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $sp->color }}"></span>
                                <span class="truncate">{{ __t($sp->name_bn, $sp->name_en) }}</span>
                            </span>

                            @if(!is_null($sp->accuracy))
                                <span class="text-xs font-black px-2 py-0.5 rounded-md border 
                                    {{ $sp->accuracy >= 70 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($sp->accuracy >= 45 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                    {{ $sp->accuracy }}%
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">{{ __t('এখনও পরীক্ষা দেননি', 'Not Attempted') }}</span>
                            @endif
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full h-2.5 rounded-full overflow-hidden bg-slate-200">
                            <div class="h-full rounded-full transition-all duration-500
                                        {{ ($sp->accuracy ?? 0) >= 70 ? 'bg-emerald-500' : (($sp->accuracy ?? 0) >= 45 ? 'bg-amber-500' : 'bg-rose-500') }}"
                                 style="width: {{ max($sp->accuracy ?? 0, 4) }}%"></div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] pt-1 text-slate-500">
                            <span>✅ {{ $sp->correct_count }} সঠিক • ❌ {{ $sp->wrong_count }} ভুল</span>
                            <a href="{{ route('practice.index', ['subject' => $sp->slug]) }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                                {{ __t('অনুশীলন →', 'Practice →') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section 2: Exam Taker / Setter Breakdown (BPSC, BUET, IBA) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center space-x-2">
                        <span class="text-indigo-600">🏛️</span>
                        <span>{{ __t('প্রশ্নকর্তা সংস্থা ও প্যাটার্ন বিশ্লেষণ (Exam Taker / Setter Mastery)', 'Exam Taker / Setter Mastery') }}</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ __t('বিসিএস (BPSC), ব্যাংক রিক্রুটমেন্ট (BUET/IBA) ইত্যাদি প্রশ্নকর্তা প্যাটার্নে আপনার দক্ষতা।', 'Compare how well you perform on BPSC vs BUET vs IBA question patterns.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($setterPerformances as $setp)
                    <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-indigo-300 transition-all space-y-3 shadow-2xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-slate-900 flex items-center space-x-1.5">
                                <span>🏛️</span>
                                <span>{{ $setp->code ?: $setp->name_bn }}</span>
                            </span>
                            @if(!is_null($setp->accuracy))
                                <span class="text-xs font-black px-2 py-0.5 rounded-md border 
                                    {{ $setp->accuracy >= 70 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($setp->accuracy >= 45 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                    {{ $setp->accuracy }}%
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">{{ __t('অংশ নেননি', 'No Attempt') }}</span>
                            @endif
                        </div>

                        <div class="w-full h-2 rounded-full overflow-hidden bg-slate-200">
                            <div class="h-full rounded-full transition-all duration-500
                                        {{ ($setp->accuracy ?? 0) >= 70 ? 'bg-emerald-500' : (($setp->accuracy ?? 0) >= 45 ? 'bg-amber-500' : 'bg-rose-500') }}"
                                 style="width: {{ max($setp->accuracy ?? 0, 4) }}%"></div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] pt-1">
                            <span class="text-slate-500">{{ $setp->total_answered }} {{ __t('টি উত্তর দেওয়া হয়েছে', 'answered') }}</span>
                            <a href="{{ route('practice.index', ['setter' => $setp->slug]) }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                                {{ __t('প্যাটার্ন পড়ুন →', 'Study →') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section 3: Past-Year BCS Archives Progress -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-base sm:text-lg font-black tracking-tight text-slate-900 flex items-center space-x-2">
                        <span class="text-amber-500">🎓</span>
                        <span>{{ __t('বিসিএস বিগত সালের পরীক্ষা ট্র্যাকার (Past-Year BCS Archives)', 'Past-Year BCS Exam Tracker') }}</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ __t('১০ম থেকে ৪৭তম বিসিএস প্রিলিমিনারি পরীক্ষার সমাধান ও মক টেস্ট স্থিতি।', 'Track your completion of full-length past-year BCS examinations.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($archiveExams as $arch)
                    <div class="p-5 rounded-2xl border {{ $arch->is_completed ? 'border-emerald-300 bg-emerald-50/20' : 'border-slate-200 bg-white' }} shadow-2xs flex flex-col justify-between space-y-4">
                        <div class="flex items-start justify-between gap-2">
                            <div class="space-y-1">
                                <div class="flex items-center space-x-2">
                                    <span class="text-[10px] font-extrabold px-2 py-0.5 rounded uppercase {{ $arch->is_completed ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $arch->is_completed ? '✓ সম্পন্ন' : 'অসম্পন্ন' }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-bold">⏱️ {{ $arch->duration_minutes }} মিনিট</span>
                                </div>
                                <h3 class="text-sm font-extrabold text-slate-900">
                                    {{ $arch->title_bn }}
                                </h3>
                            </div>
                            <span class="text-2xl shrink-0">{{ $arch->is_completed ? '🏆' : '📝' }}</span>
                        </div>

                        <div class="flex items-center justify-between border-t border-slate-100/80 pt-3 text-xs">
                            @if($arch->is_completed)
                                <div class="text-emerald-700 font-bold">
                                    {{ __t('সেরা স্কোর:', 'Best Score:') }} {{ number_format($arch->best_attempt->total_score, 2) }} / {{ $arch->total_marks }}
                                    <span class="text-slate-400 font-normal">({{ number_format($arch->best_attempt->accuracy_percentage, 0) }}% নির্ভুল)</span>
                                </div>
                            @else
                                <span class="text-slate-400">{{ $arch->total_questions }} {{ __t('টি বহুনির্বাচনি প্রশ্ন', 'MCQ Questions') }}</span>
                            @endif

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('practice.index', ['exam' => $arch->slug]) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 font-bold hover:bg-slate-100 transition">
                                    {{ __t('রিডিং মোড', 'Read') }}
                                </a>
                                <a href="{{ route('exams.show', $arch->slug) }}" class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition">
                                    {{ $arch->is_completed ? __t('পুনরায় পরীক্ষা', 'Retake') : __t('পরীক্ষা দিন', 'Start Exam') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8 text-xs text-slate-400">
                        {{ __t('কোনো আর্কাইভ পরীক্ষা পাওয়া যায়নি।', 'No archive exams found.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
