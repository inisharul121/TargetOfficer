@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6" x-data="{ autoAssignModal: false }">
        
        <!-- Header & Exam Details Banner -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-black uppercase">
                        Interactive Exam Builder
                    </span>
                    <span class="text-xs text-slate-400">ID: #{{ $exam->id }}</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900">{{ $exam->title_bn }}</h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 font-medium pt-1">
                    <span class="font-bold text-indigo-700">মোট প্রশ্ন: {{ $exam->questions->count() }} টি</span>
                    <span>•</span>
                    <span>মোট পূর্ণমান: {{ $exam->total_marks }}</span>
                    <span>•</span>
                    <span>সময়: {{ $exam->duration_minutes > 0 ? $exam->duration_minutes . ' মিনিট' : 'আনলিমিটেড' }}</span>
                    <span>•</span>
                    <span>ভুল উত্তরে কর্তন: -{{ $exam->negative_mark_per_question }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-2 shrink-0">
                <button type="button" @click="autoAssignModal = true" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>⚡ অটো-অ্যাসাইন প্রশ্ন</span>
                </button>
                <a href="{{ route('admin.exams.edit', $exam->id) }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    সেটিংস
                </a>
                <a href="{{ route('admin.exams.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs transition">
                    ← শেষ করুন
                </a>
            </div>
        </div>

        <!-- 2 Column Layout: Attached Questions vs Question Bank Browser -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column: Attached Questions (5 cols) -->
            <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 shadow-xs p-5 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-sm font-black text-slate-900">সংযুক্ত প্রশ্নাবলী ({{ $exam->questions->count() }})</h2>
                        <p class="text-[11px] text-slate-400">এই পরীক্ষায় অন্তর্ভুক্ত প্রশ্নসমূহ</p>
                    </div>
                </div>

                <div class="space-y-3 max-h-[700px] overflow-y-auto pr-1">
                    @forelse($exam->questions as $index => $q)
                        <div class="p-3.5 rounded-2xl border border-slate-100 bg-slate-50/70 hover:bg-slate-50 transition space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-black text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100 text-[10px]">
                                    প্রশ্ন #{{ $index + 1 }}
                                </span>
                                <div class="flex items-center space-x-1.5">
                                    <span class="text-[10px] text-slate-400">{{ $q->subject->name_bn }}</span>
                                    <form action="{{ route('admin.exams.detach-question', [$exam->id, $q->id]) }}" method="POST" onsubmit="return confirm('প্রশ্নটি এই পরীক্ষা থেকে বাদ দিতে চান?')">
                                        @csrf
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 p-1 rounded-md hover:bg-rose-50 font-bold" title="বাদ দিন">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="font-bold text-slate-800 line-clamp-2">
                                {!! strip_tags($q->stem_bn) !!}
                            </div>

                            <div class="flex items-center justify-between pt-1 border-t border-slate-200/60 text-[10px] text-slate-500">
                                <span>সঠিক: <strong class="text-emerald-700 font-bold">{{ $q->options->firstWhere('is_correct', true)?->option_letter }}</strong></span>
                                @if($q->setterOrganization)
                                    <span class="font-bold text-indigo-700">{{ $q->setterOrganization->code }}</span>
                                @endif
                                <span>মার্কস: 1.00</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400 space-y-2">
                            <div class="text-3xl">📝</div>
                            <p class="text-xs font-bold text-slate-600">এখনো কোনো প্রশ্ন সংযুক্ত করা হয়নি!</p>
                            <p class="text-[11px] text-slate-400">ডানপাশের প্রশ্ন ব্যাংক থেকে প্রশ্ন সিলেক্ট করুন বা অটো-অ্যাসাইন ব্যবহার করুন।</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column: Question Bank Browser (7 cols) -->
            <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-xs p-5 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-sm font-black text-slate-900">প্রশ্ন ব্যাংক থেকে নির্বাচন করুন</h2>
                        <p class="text-[11px] text-slate-400">ফিল্টার করে সরাসরি পরীক্ষায় প্রশ্ন যোগ করুন</p>
                    </div>
                </div>

                <!-- Search & Filters -->
                <form method="GET" action="{{ route('admin.exams.builder', $exam->id) }}" class="grid grid-cols-1 sm:grid-cols-4 gap-2 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="প্রশ্ন খুঁজুন..." class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs bg-white">

                    <select name="subject_id" class="px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs bg-white">
                        <option value="">সকল বিষয়</option>
                        @foreach($subjects as $sb)
                            <option value="{{ $sb->id }}" {{ request('subject_id') == $sb->id ? 'selected' : '' }}>{{ $sb->name_bn }}</option>
                        @endforeach
                    </select>

                    <select name="setter_id" class="px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs bg-white">
                        <option value="">সকল প্রশ্নকর্তা</option>
                        @foreach($setters as $st)
                            <option value="{{ $st->id }}" {{ request('setter_id') == $st->id ? 'selected' : '' }}>{{ $st->code }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white font-bold text-xs">খুঁজুন</button>
                </form>

                <!-- Available Questions List -->
                <div class="space-y-3 max-h-[620px] overflow-y-auto pr-1">
                    @forelse($availableQuestions as $availQ)
                        <div class="p-3.5 rounded-2xl border border-slate-200 hover:border-indigo-300 transition space-y-2 text-xs bg-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold text-[10px]">#{{ $availQ->id }}</span>
                                    <span class="font-bold text-indigo-700">{{ $availQ->subject->name_bn }}</span>
                                    @if($availQ->setterOrganization)
                                        <span class="px-1.5 py-0.2 rounded bg-indigo-50 text-indigo-700 font-bold text-[9px]">{{ $availQ->setterOrganization->code }}</span>
                                    @endif
                                </div>

                                <form action="{{ route('admin.exams.attach-question', $exam->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="question_id" value="{{ $availQ->id }}">
                                    <button type="submit" class="px-3 py-1 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-2xs transition flex items-center space-x-1">
                                        <span>+ যোগ করুন</span>
                                    </button>
                                </form>
                            </div>

                            <div class="font-bold text-slate-900">
                                {!! strip_tags($availQ->stem_bn) !!}
                            </div>

                            <div class="grid grid-cols-2 gap-1 text-[11px] text-slate-600 bg-slate-50 p-2 rounded-xl">
                                @foreach($availQ->options as $opt)
                                    <div class="truncate {{ $opt->is_correct ? 'text-emerald-700 font-bold' : '' }}">
                                        {{ $opt->option_letter }}. {{ strip_tags($opt->option_text_bn) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate-400 text-xs">
                            কোনো অবশিষ্ট প্রশ্ন পাওয়া যায়নি।
                        </div>
                    @endforelse
                </div>

                <div class="pt-3">
                    {{ $availableQuestions->links() }}
                </div>
            </div>

        </div>

    <!-- Auto-Assign Modal -->
    <div x-show="autoAssignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/40 backdrop-blur-xs" x-transition>
        <div @click.outside="autoAssignModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-black text-base text-slate-900 flex items-center space-x-2">
                <span>⚡</span>
                <span>স্বয়ংক্রিয় প্রশ্ন সংযোজন (Auto-Assign)</span>
            </h3>

            <form action="{{ route('admin.exams.auto-assign', $exam->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কোন বিষয়ের প্রশ্ন চান? *</label>
                    <select name="subject_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white font-bold">
                        <option value="">সকল বিষয় থেকে মিশ্রিত</option>
                        @foreach($subjects as $sb)
                            <option value="{{ $sb->id }}">{{ $sb->name_bn }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">প্রশ্নকর্তা সংস্থা</label>
                    <select name="setter_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        <option value="">সকল প্রশ্নকর্তা</option>
                        @foreach($setters as $st)
                            <option value="{{ $st->id }}">{{ $st->name_bn }} ({{ $st->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কাঠিন্য (Difficulty)</label>
                    <select name="difficulty" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        <option value="">যেকোনো কাঠিন্য</option>
                        <option value="easy">সহজ (Easy)</option>
                        <option value="medium">মাঝারি (Medium)</option>
                        <option value="hard">কঠিন (Hard)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কতটি প্রশ্ন যোগ করতে চান? *</label>
                    <input type="number" name="count" value="10" min="1" max="50" required class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="autoAssignModal = false" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs">প্রশ্ন যুক্ত করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
