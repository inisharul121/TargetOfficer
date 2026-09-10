@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto animate-fade-up">

    <!-- Top Header & Admin Welcome -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
        <div class="space-y-1.5">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-200">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span>TargetOfficer Admin & Content Hub</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ __t('অ্যাডমিন ড্যাশবোর্ড ও ওভারভিউ', 'Admin Dashboard & Overview') }}</h1>
            <p class="text-xs sm:text-sm text-slate-500">{{ __t('সিস্টেম কনটেন্ট, প্রশ্নকর্তা প্যাটার্ন, লাইভ পরীক্ষা ও ক্যান্ডিডেট অ্যানালিটিক্স পরিচালনা করুন।', 'Manage system content, question setter patterns, live exams, and candidate analytics.') }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.exams.create') }}" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>{{ __t('নতুন পরীক্ষা তৈরি', 'Create New Exam') }}</span>
            </a>
            <a href="{{ route('admin.questions.create') }}" class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition flex items-center space-x-1.5 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>{{ __t('প্রশ্ন সংযোজন', 'Add Question') }}</span>
            </a>
        </div>
    </div>

    <!-- Navigation Tabs Bar -->
    <div class="flex items-center space-x-2 overflow-x-auto pb-2 border-b border-slate-200 text-xs font-bold">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white shadow-xs">{{ __t('ড্যাশবোর্ড', 'Dashboard') }}</a>
        <a href="{{ route('admin.exams.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">{{ __t('পরীক্ষা ও মডেল টেস্ট', 'Exams & Mocks') }} ({{ $totalExams }})</a>
        <a href="{{ route('admin.questions.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">{{ __t('প্রশ্ন ব্যাংক', 'Question Bank') }} ({{ $totalQuestions }})</a>
        <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition flex items-center space-x-1">
            <span>{{ __t('ত্রুটি রিপোর্ট', 'Error Reports') }}</span>
            @if($pendingReports > 0)
                <span class="px-1.5 py-0.2 rounded-full bg-rose-600 text-white text-[10px]">{{ $pendingReports }}</span>
            @endif
        </a>
        <a href="{{ route('admin.taxonomies.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">{{ __t('বিষয় ও সংস্থা', 'Subjects & Setter Bodies') }}</a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">{{ __t('ব্যবহারকারী', 'Users') }} ({{ $totalCandidates }})</a>
        <a href="{{ route('admin.analytics.index') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">{{ __t('অ্যানালিটিক্স', 'Analytics') }}</a>
        <a href="{{ route('admin.questions.duplicates') }}" class="px-4 py-2 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 transition border border-amber-200">{{ __t('ডুপ্লিকেট চেকার', 'Duplicate Checker') }}</a>
    </div>

    <!-- Metric Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Questions -->
        <div class="bg-white border border-slate-200 p-5 rounded-3xl shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __t('মোট প্রশ্ন ভাণ্ডার', 'Total Question Repository') }}</span>
                <span class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ number_format($totalQuestions) }}</div>
            <div class="flex items-center space-x-2 text-[11px] text-slate-500 font-medium">
                <span class="text-emerald-600 font-bold">● {{ $publishedQuestions }} {{ __t('প্রকাশিত', 'Published') }}</span>
                <span>•</span>
                <span>{{ $draftQuestions }} {{ __t('ড্রাফট', 'Draft') }}</span>
            </div>
        </div>

        <!-- Total Exams -->
        <div class="bg-white border border-slate-200 p-5 rounded-3xl shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __t('মোট পরীক্ষা ও টেস্ট', 'Total Exams & Tests') }}</span>
                <span class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ number_format($totalExams) }}</div>
            <div class="flex items-center space-x-2 text-[11px] text-slate-500 font-medium">
                <span class="text-indigo-600 font-bold">{{ $liveModelTests }} {{ __t('টি লাইভ মডেল টেস্ট', 'Live Model Tests') }}</span>
            </div>
        </div>

        <!-- Total Attempts -->
        <div class="bg-white border border-slate-200 p-5 rounded-3xl shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __t('মোট পরীক্ষা অংশগ্রহণ', 'Total Exam Attempts') }}</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ number_format($totalAttempts) }}</div>
            <div class="flex items-center space-x-2 text-[11px] text-slate-500 font-medium">
                <span class="text-emerald-600 font-bold">{{ __t('আজকে:', 'Today:') }} {{ $todayAttempts }} {{ __t('টি সম্পন্ন', 'Completed') }}</span>
            </div>
        </div>

        <!-- Candidates & Reports -->
        <div class="bg-white border border-slate-200 p-5 rounded-3xl shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __t('ক্যান্ডিডেট ও রিভিউ', 'Candidates & Reports') }}</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ number_format($totalCandidates) }}</div>
            <div class="flex items-center space-x-2 text-[11px] text-slate-500 font-medium">
                @if($pendingReports > 0)
                    <span class="text-rose-600 font-bold">⚠️ {{ $pendingReports }} {{ __t('টি রিপোর্ট পেন্ডিং', 'Reports Pending') }}</span>
                @else
                    <span class="text-emerald-600 font-bold">✓ {{ __t('সকল রিপোর্ট সমাধানকৃত', 'All Reports Resolved') }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Setter Pattern & Subject Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Question Setter Breakdown -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-black text-slate-900">{{ __t('প্রশ্নকর্তা সংস্থা বিশ্লেষণ', 'Setter Body Pattern Analysis') }}</h2>
                    <p class="text-xs text-slate-400">Setter Body Pattern Breakdown</p>
                </div>
                <a href="{{ route('admin.taxonomies.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">{{ __t('ম্যানেজ →', 'Manage →') }}</a>
            </div>

            <div class="space-y-3">
                @forelse($setterStats as $setter)
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-800 flex items-center space-x-1.5">
                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px]">{{ $setter->code }}</span>
                                <span>{{ __t($setter->name_bn ?? $setter->name_en, $setter->name_en) }}</span>
                            </span>
                            <span class="text-slate-500">{{ $setter->questions_count }} {{ __t('টি প্রশ্ন', 'Questions') }}</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $totalQuestions > 0 ? ($setter->questions_count / $totalQuestions) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">{{ __t('কোনো প্রশ্নকর্তা তথ্য পাওয়া যায়নি।', 'No setter data found.') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Subject-wise Distribution -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4 lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-black text-slate-900">{{ __t('বিষয়ভিত্তিক প্রশ্ন বিন্যাস', 'Subject Question Distribution') }}</h2>
                    <p class="text-xs text-slate-400">Subject Distribution & Question Count</p>
                </div>
                <a href="{{ route('admin.questions.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">{{ __t('সকল প্রশ্ন →', 'All Questions →') }}</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($subjectStats as $subject)
                    <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50/60 flex items-center justify-between hover:bg-slate-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $subject->color }}"></div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ __t($subject->name_bn, $subject->name_en) }}</h4>
                                <p class="text-[10px] text-slate-400">{{ $subject->name_en }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-xl bg-white border border-slate-200 text-xs font-black text-slate-800 shadow-2xs">
                            {{ $subject->questions_count }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Attempts & Pending Reports Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Attempts -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden lg:col-span-2">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-slate-900">{{ __t('সাম্প্রতিক পরীক্ষা অংশগ্রহণ (Live Feed)', 'Recent Exam Attempts (Live Feed)') }}</h3>
                    <p class="text-xs text-slate-400">{{ __t('সর্বশেষ সম্পন্ন হওয়া মডেল টেস্ট ও কুইজের তালিকা', 'Latest completed model tests & quizzes') }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <th class="py-3 px-4">{{ __t('ক্যান্ডিডেট', 'Candidate') }}</th>
                            <th class="py-3 px-4">{{ __t('পরীক্ষার নাম', 'Exam Title') }}</th>
                            <th class="py-3 px-4">{{ __t('প্রাপ্ত স্কোর', 'Score') }}</th>
                            <th class="py-3 px-4">{{ __t('নির্ভুলতা', 'Accuracy') }}</th>
                            <th class="py-3 px-4">{{ __t('সময়', 'Time') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($recentAttempts as $att)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900">{{ $att->user->name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $att->user->email }}</div>
                                </td>
                                <td class="py-3 px-4 max-w-[200px] truncate font-semibold text-slate-800">
                                    {{ __t($att->exam->title_bn, $att->exam->title_en ?? $att->exam->title_bn) }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-black text-indigo-600">{{ number_format($att->total_score, 2) }}</span>
                                    <span class="text-[10px] text-slate-400">/ {{ $att->exam->total_marks }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full {{ $att->accuracy_percentage >= 70 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($att->accuracy_percentage >= 40 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }} font-bold text-[10px]">
                                        {{ number_format($att->accuracy_percentage, 0) }}%
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-500 text-[11px]">
                                    {{ $att->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">{{ __t('এখনো কোনো পরীক্ষা সম্পন্ন হয়নি।', 'No completed exams yet.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Error Reports Queue -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-slate-900">{{ __t('প্রশ্ন ত্রুটি রিপোর্ট কিউ', 'Question Error Reports Queue') }}</h3>
                    <p class="text-xs text-slate-400">Student Error Reports Queue</p>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">{{ __t('সকল রিপোর্ট →', 'All Reports →') }}</a>
            </div>

            <div class="space-y-3">
                @forelse($recentReports as $rep)
                    <div class="p-3 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 font-bold text-[10px] uppercase">
                                {{ str_replace('_', ' ', $rep->report_type) }}
                            </span>
                            <span class="text-[10px] text-slate-400">{{ $rep->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="font-bold text-slate-900 line-clamp-2">
                            {!! strip_tags(__t($rep->question->stem_bn, $rep->question->stem_en ?? $rep->question->stem_bn)) !!}
                        </div>
                        @if($rep->comment)
                            <p class="text-[11px] text-slate-600 italic bg-white p-2 rounded-xl border border-slate-200">
                                "{{ $rep->comment }}"
                            </p>
                        @endif
                        <div class="flex items-center justify-between pt-1">
                            <span class="text-[10px] text-slate-400">{{ $rep->user?->name ?? 'Candidate' }}</span>
                            <a href="{{ route('admin.questions.edit', $rep->question_id) }}" class="text-indigo-600 hover:underline font-bold text-[11px]">
                                {{ __t('প্রশ্ন এডিট করুন →', 'Edit Question →') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 space-y-2">
                        <div class="text-2xl">🎉</div>
                        <p class="text-xs font-bold text-slate-700">{{ __t('কোনো পেন্ডিং ত্রুটি রিপোর্ট নেই!', 'No pending error reports!') }}</p>
                        <p class="text-[11px] text-slate-400">{{ __t('সকল প্রশ্ন নির্ভুল রয়েছে।', 'All questions are verified.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
