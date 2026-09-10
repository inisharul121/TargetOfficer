@extends('layouts.app')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen" x-data="{ reportModal: false, activeQuestionId: null }" x-init="
    $nextTick(() => {
        document.querySelectorAll('.math-tex').forEach(el => window.renderMathInElement(el));
    });
">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">প্রশ্ন ব্যাংক ও প্রশ্নকর্তা প্যাটার্ন আর্কাইভ</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">বিসিএস, বাংলাদেশ ব্যাংক, বুয়েট ও আইবিএ প্রশ্ন প্যাটার্নের বিস্তারিত কালেকশন।</p>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('question-bank.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="প্রশ্ন বা ব্যাখ্যা দিয়ে খুঁজুন..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">
                </div>

                <div>
                    <select name="exam" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white">
                        <option value="">সকল পরীক্ষা (১০ম বিসিএস, ১১তম...)</option>
                        @foreach($exams as $ex)
                            <option value="{{ $ex->slug }}" {{ request('exam') == $ex->slug ? 'selected' : '' }}>{{ $ex->title_bn }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="setter" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white">
                        <option value="">সকল সংস্থা (BUET, IBA, BPSC)</option>
                        @foreach($setters as $st)
                            <option value="{{ $st->id }}" {{ request('setter') == $st->id ? 'selected' : '' }}>{{ $st->name_bn }} ({{ $st->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="subject" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none bg-white">
                        <option value="">সকল বিষয় (All Subjects)</option>
                        @foreach($subjects as $sb)
                            <option value="{{ $sb->id }}" {{ request('subject') == $sb->id ? 'selected' : '' }}>{{ $sb->name_bn }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">
                        অনুসন্ধান করুন
                    </button>
                    @if(request()->anyFilled(['q', 'exam', 'setter', 'subject', 'tag']))
                        <a href="{{ route('question-bank.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-xs transition">
                            রিসেট
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Questions Grid -->
        <div class="space-y-5">
            @forelse($questions as $index => $q)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4" 
                     x-data="{ 
                        revealed: true,
                        bookmarked: {{ in_array($q->id, $bookmarkedIds) ? 'true' : 'false' }},
                        toggleBookmark() {
                            @auth
                                fetch('{{ route('questions.bookmark', $q->id) }}', {
                                    method: 'POST',
                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                                })
                                .then(r => r.json())
                                .then(data => { this.bookmarked = data.bookmarked; });
                            @else
                                window.location.href = '{{ route('login') }}';
                            @endauth
                        }
                     }">
                    
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                            <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-black text-xs flex items-center justify-center shadow-2xs shrink-0">
                                {{ $questions->firstItem() + $index }}
                            </span>
                            <a href="{{ route('question-bank.index', ['subject' => $q->subject->id]) }}" 
                               class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-2.5 py-1 rounded-lg transition shrink-0">
                                {{ $q->subject->name_bn }}
                            </a>
                            @foreach($q->sources as $source)
                                <a href="{{ route('practice.index', [$source['type'] => $source['slug']]) }}" 
                                   title="{{ $source['full_title'] }} - অনুশীলন করতে ক্লিক করুন"
                                   class="inline-flex items-center space-x-1 text-xs font-bold border px-2.5 py-1 rounded-lg transition hover:scale-105 shadow-2xs {{ $source['badge_color'] }}">
                                    <span>{{ $source['icon'] }}</span>
                                    <span>{{ $source['title'] }}</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Bookmark Button -->
                            <button type="button" @click="toggleBookmark()" class="p-1.5 rounded-lg border text-xs font-bold transition flex items-center space-x-1"
                                    :class="bookmarked ? 'bg-amber-50 border-amber-300 text-amber-700' : 'bg-slate-50 border-slate-200 text-slate-400 hover:text-slate-600'">
                                <span x-text="bookmarked ? '⭐ সেভ করা' : '☆ সেভ করুন'"></span>
                            </button>

                            <!-- Report Error Button -->
                            <button type="button" @click="reportModal = true; activeQuestionId = {{ $q->id }}" class="text-xs text-slate-400 hover:text-rose-500 p-1.5" title="ভুল রিপোর্ট করুন">
                                🚩
                            </button>
                        </div>
                    </div>

                    <div class="math-tex text-base font-bold text-slate-900 leading-relaxed">
                        {!! app()->getLocale() === 'en' && !empty($q->stem_en) ? $q->stem_en : $q->stem_bn !!}
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        @foreach($q->options as $opt)
                            <div class="flex items-center p-3 rounded-2xl border text-sm font-semibold select-none
                                {{ $opt->is_correct ? 'bg-emerald-50/90 border-emerald-500 text-slate-900 ring-1 ring-emerald-500/20' : 'bg-slate-50 border-slate-200 text-slate-700' }}">
                                
                                <div class="w-6 h-6 rounded-lg font-bold text-xs flex items-center justify-center mr-2.5 shrink-0
                                    {{ $opt->is_correct ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-300' }}">
                                    {{ $opt->option_letter }}
                                </div>

                                <div class="math-tex flex-1">
                                    {!! app()->getLocale() === 'en' && !empty($opt->option_text_en) ? $opt->option_text_en : $opt->option_text_bn !!}
                                </div>

                                @if($opt->is_correct)
                                    <span class="text-xs font-bold text-emerald-700 ml-2">✓ {{ __t('সঠিক', 'Correct') }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Solution & Explanation Box -->
                    @if($q->explanation_bn)
                        <div class="p-4 rounded-2xl bg-slate-50/60 border border-slate-100 text-xs space-y-1.5">
                            <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                                <span>💡</span>
                                <span>ব্যাখ্যা ও রেফারেন্স:</span>
                            </div>
                            <div class="math-tex text-slate-700 leading-relaxed">
                                {!! $q->explanation_bn !!}
                            </div>
                            @if($q->reference_source)
                                <div class="pt-1.5 border-t border-slate-100 text-[11px] text-indigo-700 font-semibold">
                                    📚 সূত্র: {{ $q->reference_source }}
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Community Discussion Threads -->
                    <div class="pt-3 border-t border-slate-100" x-data="{ showDiscussion: false }">
                        <div class="flex items-center justify-between">
                            <button type="button" @click="showDiscussion = !showDiscussion" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1.5 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <span x-text="showDiscussion ? 'আলোচনা লুকান' : '💬 প্রশ্নোত্তর আলোচনা ({{ $q->comments->count() }})'"></span>
                            </button>
                            <span class="text-[10px] text-slate-400 font-medium">+৫ কয়েন প্রতি সমাধানে</span>
                        </div>

                        <div x-show="showDiscussion" x-transition class="mt-3 pt-3 border-t border-slate-100 space-y-3">
                            <!-- Comment form -->
                            @auth
                                <form action="{{ route('questions.comments.store', $q->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="text" name="comment" required placeholder="আপনার মতামত, শর্টকাট টেকনিক বা ব্যাখ্যা লিখুন..." class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:border-indigo-500 outline-none">
                                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shrink-0 shadow-xs transition">
                                        মন্তব্য পোস্ট
                                    </button>
                                </form>
                            @else
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-center text-xs text-slate-500">
                                    আলোচনায় অংশ নিতে <a href="{{ route('login') }}" class="font-bold text-indigo-600 underline">লগইন</a> করুন।
                                </div>
                            @endauth

                            <!-- Existing Comments -->
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @forelse($q->comments as $cm)
                                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs space-y-1">
                                        <div class="flex items-center justify-between text-[10px] text-slate-400">
                                            <strong class="text-slate-800 font-bold">{{ $cm->user->name }}</strong>
                                            <span>{{ $cm->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-slate-700 font-medium">{{ $cm->comment }}</p>
                                    </div>
                                @empty
                                    <p class="text-[11px] text-slate-400 italic py-1">এখনো কোনো আলোচনা যুক্ত হয়নি। প্রথম মতামত দিন!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200">
                    <span class="text-3xl">🔍</span>
                    <h3 class="text-base font-bold text-slate-800 mt-2">কোনো প্রশ্ন পাওয়া যায়নি</h3>
                    <p class="text-xs text-slate-400 mt-1">অন্য কোনো ফিল্টার বা অনুসন্ধান শব্দ দিয়ে চেষ্টা করুন।</p>
                </div>
            @endforelse

            <div>
                {{ $questions->links() }}
            </div>
        </div>
    </div>

    <!-- Error Report Modal -->
    <div x-show="reportModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/40 backdrop-blur-xs" x-transition>
        <div @click.outside="reportModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-bold text-base text-slate-900 flex items-center space-x-2">
                <span>🚩</span>
                <span>প্রশ্ন সম্পর্কিত ভুল রিপোর্ট করুন</span>
            </h3>
            
            <form :action="'/questions/' + activeQuestionId + '/report'" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">সমস্যার ধরন</label>
                    <select name="report_type" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        <option value="wrong_answer">ভুল উত্তর চিহ্নিত করা আছে</option>
                        <option value="typo_error">বানান বা ফরম্যাটিং সমস্যা</option>
                        <option value="confusing_explanation">ব্যাখ্যায় বিভ্রান্তি রয়েছে</option>
                        <option value="duplicate">ডুপ্লিকেট প্রশ্ন</option>
                        <option value="other">অন্যান্য</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">আপনার মন্তব্য বা সঠিক তথ্যের উৎস</label>
                    <textarea name="comment" rows="3" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs outline-none focus:border-indigo-500" placeholder="সঠিক উত্তর বা রেফারেন্স লিখুন..."></textarea>
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="reportModal = false" class="w-1/2 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs">রিপোর্ট জমা দিন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
