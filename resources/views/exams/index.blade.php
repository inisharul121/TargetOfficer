@extends('layouts.app')

@section('content')
<div class="py-8 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __t('সকল মডেল টেস্ট ও পরীক্ষা', 'All Model Tests & Exams') }}</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __t('বিসিএস প্রিলিমিনারি, ব্যাংক অফিসার, এবং স্পেশালাইজড নিয়োগের জন্য সাজানো টেস্ট প্যাকেজ।', 'Curated test packages for BCS Preliminary, Bank Officer, and specialized recruitments.') }}</p>
            </div>
            <a href="{{ route('exams.custom') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-xs transition space-x-2 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span>⚡ {{ __t('কাস্টম টেস্ট জেনারেটর', 'Custom Test Generator') }}</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('exams.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="মডেল টেস্ট খুঁজুন..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">
                </div>

                <div>
                    <select name="mode" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white">
                        <option value="">সকল মোড (All Modes)</option>
                        <option value="timed_mock" {{ request('mode') === 'timed_mock' ? 'selected' : '' }}>⏱️ Timed Mock Test</option>
                        <option value="practice" {{ request('mode') === 'practice' ? 'selected' : '' }}>💡 Practice (Untimed)</option>
                        <option value="daily_quiz" {{ request('mode') === 'daily_quiz' ? 'selected' : '' }}>⚡ Daily Speed Quiz</option>
                    </select>
                </div>

                <div>
                    <select name="org" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white">
                        <option value="">সকল প্রশ্নকর্তা সংস্থা</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ request('org') == $org->id ? 'selected' : '' }}>{{ $org->code ?? $org->name_en }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition">
                        ফিল্টার প্রয়োগ করুন
                    </button>
                    @if(request()->anyFilled(['search', 'mode', 'org']))
                        <a href="{{ route('exams.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-xs transition">
                            রিসেট
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Exams Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($exams as $exam)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs hover:border-slate-300 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg {{ $exam->exam_mode === 'timed_mock' ? 'bg-indigo-50 text-indigo-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $exam->exam_mode === 'timed_mock' ? '⏱️ Timed Mock' : ($exam->exam_mode === 'practice' ? '💡 Practice' : '⚡ Daily Quiz') }}
                            </span>
                            @if($exam->organization)
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $exam->organization->code }}</span>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition leading-snug">{{ $exam->title_bn }}</h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ $exam->description_bn }}</p>

                        <div class="grid grid-cols-3 gap-2 mt-6 pt-4 border-t border-slate-100 text-center">
                            <div class="bg-slate-50 rounded-xl p-2">
                                <div class="text-xs font-bold text-slate-800">{{ $exam->total_questions }} টি</div>
                                <div class="text-[10px] text-slate-400 font-medium">প্রশ্ন</div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-2">
                                <div class="text-xs font-bold text-slate-800">{{ $exam->duration_minutes > 0 ? $exam->duration_minutes . ' মি.' : 'আনলিমিটেড' }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">সময়</div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-2">
                                <div class="text-xs font-bold text-rose-600">-{{ $exam->negative_mark_per_question }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">নেগেটিভ</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('exams.show', $exam->slug) }}" class="w-full py-2.5 rounded-xl bg-indigo-600 group-hover:bg-indigo-700 text-white font-bold text-xs flex items-center justify-center space-x-1.5 shadow-xs transition">
                            <span>টেস্ট শুরু করুন</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <span class="text-3xl">🔍</span>
                    <h3 class="text-base font-bold text-slate-800 mt-2">কোনো মডেল টেস্ট পাওয়া যায়নি</h3>
                    <p class="text-xs text-slate-400 mt-1">অন্য কোনো ফিল্টার বা অনুসন্ধান শব্দ দিয়ে চেষ্টা করুন।</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $exams->links() }}
        </div>
    </div>
</div>
@endsection
