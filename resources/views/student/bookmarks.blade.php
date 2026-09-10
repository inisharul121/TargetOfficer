@extends('layouts.student-layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-8" x-data x-init="
    $nextTick(() => {
        document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
    });
">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
                    <span>⭐</span>
                    <span>{{ __t('সংরক্ষিত প্রশ্নাবলি (Bookmarked Questions)', 'Saved Questions Library') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-2">
                    {{ __t('আমার বুকমার্ক করা প্রশ্নসমূহ', 'My Bookmarked Questions') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    {{ __t('গুরুত্বপূর্ণ বা জটিল যেসব প্রশ্ন আপনি পরবর্তী রিভিশনের জন্য সেভ করেছেন।', 'Questions you flagged for quick revision and deep study.') }}
                </p>
            </div>

            @if($questions->total() > 0)
                <a href="{{ route('exams.custom', ['pool' => 'bookmarked']) }}" class="px-5 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs shadow-lg shadow-amber-500/20 transition flex items-center space-x-2 shrink-0">
                    <span>⚡</span>
                    <span>{{ __t('বুকমার্ক করা প্রশ্নের কুইজ দিন', 'Quiz on Bookmarks') }}</span>
                </a>
            @endif
        </div>

        <!-- Filter -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('student.bookmarks') }}" class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center space-x-2 flex-wrap gap-y-2">
                    <span class="text-xs font-bold text-slate-400">{{ __t('বিষয় ফিল্টার:', 'Subject Filter:') }}</span>
                    <a href="{{ route('student.bookmarks') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold {{ !request('subject') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                        {{ __t('সকল বিষয়', 'All') }}
                    </a>
                    @foreach($subjects as $sb)
                        <a href="{{ route('student.bookmarks', ['subject' => $sb->id]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold {{ request('subject') == $sb->id ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ __t($sb->name_bn, $sb->name_en) }}
                        </a>
                    @endforeach
                </div>
                <span class="text-xs font-bold text-slate-500">{{ $questions->total() }} {{ __t('টি সেভ করা প্রশ্ন', 'saved questions') }}</span>
            </form>
        </div>

        <!-- Questions List -->
        <div class="space-y-5">
            @forelse($questions as $index => $q)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4" 
                     x-data="{ 
                        revealed: true,
                        bookmarked: true,
                        toggleBookmark() {
                            fetch('{{ route('questions.bookmark', $q->id) }}', {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                            })
                            .then(r => r.json())
                            .then(data => { this.bookmarked = data.bookmarked; });
                        }
                     }">
                    
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                            <span class="w-7 h-7 rounded-lg bg-amber-500 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                {{ $questions->firstItem() + $index }}
                            </span>
                            <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">
                                {{ __t($q->subject->name_bn, $q->subject->name_en) }}
                            </span>
                            @foreach($q->sources as $source)
                                <a href="{{ $source['url'] }}" 
                                   class="inline-flex items-center space-x-1 text-xs font-bold border px-2 py-0.5 rounded transition shadow-2xs {{ $source['badge_color'] }}">
                                    <span>{{ $source['icon'] }}</span>
                                    <span>{{ $source['title'] }}</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="flex items-center space-x-2">
                            <button type="button" @click="toggleBookmark()" class="p-1.5 rounded-lg border text-xs font-bold transition flex items-center space-x-1 bg-amber-50 border-amber-300 text-amber-700">
                                <span x-text="bookmarked ? '⭐ সেভ করা' : '☆ সেভ করুন'"></span>
                            </button>
                            <button type="button" @click="revealed = !revealed" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                <span x-text="revealed ? '{{ __t('ব্যাখ্যা লুকান', 'Hide') }}' : '{{ __t('ব্যাখ্যা দেখুন', 'Show') }}'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="math-tex text-base font-bold text-slate-900 leading-relaxed">
                        {!! app()->getLocale() === 'en' && !empty($q->stem_en) ? $q->stem_en : $q->stem_bn !!}
                    </div>

                    <!-- Options Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        @foreach($q->options as $opt)
                            <div class="w-full text-left flex items-center p-3.5 rounded-2xl border text-sm font-semibold transition select-none
                                        {{ $opt->is_correct ? 'bg-emerald-50/90 border-emerald-500 text-emerald-950 ring-1 ring-emerald-500/30' : 'bg-slate-50 border-slate-200 text-slate-600' }}">
                                <div class="w-7 h-7 rounded-xl font-bold text-xs flex items-center justify-center mr-3 shrink-0
                                            {{ $opt->is_correct ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-300' }}">
                                    {{ $opt->option_letter }}
                                </div>
                                <div class="math-tex flex-1">
                                    {!! app()->getLocale() === 'en' && !empty($opt->option_text_en) ? $opt->option_text_en : $opt->option_text_bn !!}
                                </div>
                                @if($opt->is_correct)
                                    <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded ml-2">✓ সঠিক উত্তর</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Explanation -->
                    <div x-show="revealed" class="p-4 rounded-2xl bg-amber-50/40 border border-amber-100 text-xs space-y-2">
                        <div class="font-bold text-amber-900 flex items-center space-x-1.5">
                            <span>💡</span>
                            <span>{{ __t('ব্যাখ্যা ও রেফারেন্স:', 'Explanation & Reference:') }}</span>
                        </div>
                        <div class="math-tex text-slate-700 leading-relaxed">
                            {!! $q->explanation_bn !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200 space-y-3">
                    <span class="text-4xl">⭐</span>
                    <h3 class="text-lg font-black text-slate-800">{{ __t('কোনো সংরক্ষিত প্রশ্ন পাওয়া যায়নি', 'No bookmarked questions yet') }}</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">{{ __t('অনুশীলন বা পরীক্ষার সময় যেকোনো প্রশ্নের পাশে থাকা স্টার (☆) আইকনে ক্লিক করে এখানে সেভ করে রাখুন।', 'Click the star icon next to any question while practicing to save it here for review.') }}</p>
                    <a href="{{ route('practice.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-xs hover:bg-indigo-700 transition mt-2">
                        {{ __t('অনুশীলন শুরু করুন', 'Start Practice') }}
                    </a>
                </div>
            @endforelse

            <div>
                {{ $questions->links() }}
            </div>
        </div>
    </div>
@endsection
