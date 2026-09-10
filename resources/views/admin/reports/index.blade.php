@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6">
    
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-black uppercase mb-1 border border-rose-200">
                    Audit & Moderation Queue
                </div>
                <h1 class="text-2xl font-black text-slate-900">{{ __t('প্রশ্ন ত্রুটি ও অভিযোগ রিভিউ কিউ', 'Question Error & Moderation Queue') }}</h1>
                <p class="text-xs text-slate-500">{{ __t('পরীক্ষার্থীদের প্রেরিত ভুল উত্তর, টাইপো ও ব্যাখ্যার অস্পষ্টতা সমাধান করুন।', 'Resolve candidate bug reports, typos, and solution clarifications.') }}</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
                ← {{ __t('ড্যাশবোর্ড', 'Dashboard') }}
            </a>
        </div>

        <!-- Filter Status Tabs -->
        <div class="flex items-center space-x-2 border-b border-slate-200 pb-3 text-xs font-bold">
            <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl transition {{ request('status', 'pending') === 'pending' ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ __t('পেন্ডিং রিভিউ', 'Pending Review') }} ({{ $pendingCount }})
            </a>
            <a href="{{ route('admin.reports.index', ['status' => 'resolved']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'resolved' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ __t('সমাধানকৃত', 'Resolved') }} ({{ $resolvedCount }})
            </a>
            <a href="{{ route('admin.reports.index', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl transition {{ request('status') === 'rejected' ? 'bg-slate-700 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ __t('বাতিলকৃত', 'Rejected') }} ({{ $rejectedCount }})
            </a>
        </div>

        <!-- Reports List -->
        <div class="space-y-4">
            @forelse($reports as $report)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 font-black text-[10px] uppercase">
                                {{ str_replace('_', ' ', $report->report_type) }}
                            </span>
                            <span class="text-xs font-bold text-slate-700">Question #{{ $report->question->id }}</span>
                            <span class="text-xs text-slate-400">({{ $report->question->subject->name_bn }})</span>
                        </div>
                        <div class="text-[11px] text-slate-400">
                            রিপোর্ট করেছেন: <strong class="text-slate-700">{{ $report->user?->name ?? 'Candidate' }}</strong> ({{ $report->created_at->diffForHumans() }})
                        </div>
                    </div>

                    <!-- Question Stem & Options snippet -->
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 space-y-3 text-xs">
                        <div class="font-bold text-slate-900">
                            {!! strip_tags($report->question->stem_bn) !!}
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach($report->question->options as $opt)
                                <div class="p-2 rounded-xl border {{ $opt->is_correct ? 'border-emerald-300 bg-emerald-50/40 font-bold text-slate-800' : 'border-slate-200 bg-white text-slate-600' }}">
                                    {{ $opt->option_letter }}) {{ $opt->option_text_bn }}
                                    @if($opt->is_correct)
                                        <span class="text-[9px] text-emerald-700 block font-bold">(সঠিক উত্তর)</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if($report->question->explanation_bn)
                            <div class="text-[11px] text-slate-500 bg-white p-2.5 rounded-xl border border-slate-100">
                                <strong class="text-slate-700">বর্তমান ব্যাখ্যা:</strong> {{ $report->question->explanation_bn }}
                            </div>
                        @endif
                    </div>

                    <!-- Candidate's Comment -->
                    @if($report->comment)
                        <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-950 space-y-1">
                            <span class="font-bold text-[10px] uppercase text-amber-800 block">ক্যান্ডিডেটের মন্তব্য:</span>
                            <p class="font-medium">"{{ $report->comment }}"</p>
                        </div>
                    @endif

                    <!-- Action Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <a href="{{ route('admin.questions.edit', $report->question_id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition flex items-center space-x-1.5 border border-slate-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span>প্রশ্ন এডিট ও সংশোধন করুন ↗</span>
                        </a>

                        <div class="flex items-center space-x-2">
                            @if($report->status !== 'resolved')
                                <form action="{{ route('admin.reports.status', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="resolved">
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition">
                                        ✓ সমাধান হয়েছে
                                    </button>
                                </form>
                            @endif

                            @if($report->status !== 'rejected')
                                <form action="{{ route('admin.reports.status', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition">
                                        বাতিল করুন
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('রিপোর্টটি মুছে ফেলতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl hover:bg-rose-50 text-rose-500 hover:text-rose-700 transition" title="মুছুন">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-xs space-y-3">
                    <div class="text-4xl">🎉</div>
                    <h3 class="text-base font-black text-slate-900">এই বিভাগে কোনো রিপোর্ট নেই!</h3>
                    <p class="text-xs text-slate-400">সকল ত্রুটি পর্যালোচনা সম্পন্ন হয়েছে।</p>
                </div>
            @endforelse
        </div>

        <div class="p-2">
            {{ $reports->links() }}
        </div>

    </div>
@endsection
