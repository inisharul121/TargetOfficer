@extends('layouts.dashboard-layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="questionForm()" x-init="renderPreview()">

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black text-slate-900">নতুন প্রশ্ন সংযোজন (Question Builder)</h1>
            <a href="{{ route('admin.questions.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">← তালিকায় ফিরুন</a>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">

            <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- CASCADE: Subject → Topic → Subtopic --}}
                <div class="rounded-2xl border border-slate-100 bg-slate-50/30 p-4 space-y-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-[10px] font-black uppercase text-indigo-700 tracking-wider">📚 ক্যাটাগরি ক্যাসকেড</span>
                        <span class="text-[10px] text-slate-500">ধাপে ধাপে বিষয় → টপিক → সাব-টপিক নির্বাচন করুন</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">বিষয় (Subject) <span class="text-rose-500">*</span></label>
                            <select name="subject_id" x-model="subjectId" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                                <option value="">— বিষয় নির্বাচন করুন —</option>
                                @foreach($subjects as $sb)
                                    <option value="{{ $sb->id }}">{{ $sb->name_bn }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">টপিক (Topic)</label>
                            <select name="topic_id" x-model="topicId" :disabled="!subjectId" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white disabled:bg-slate-100 disabled:text-slate-400">
                                <option value="">— টপিক নির্বাচন করুন —</option>
                                <template x-for="t in (topicsBySubject[subjectId] || [])" :key="t.id">
                                    <option :value="t.id" x-text="t.name_bn"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সাব-টপিক (Subtopic)</label>
                            <select name="subtopic_id" x-model="subtopicId" :disabled="!topicId" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white disabled:bg-slate-100 disabled:text-slate-400">
                                <option value="">— সাব-টপিক নির্বাচন করুন —</option>
                                <template x-for="st in (subtopicsByTopic[topicId] || [])" :key="st.id">
                                    <option :value="st.id" x-text="st.name_bn"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Setter / Difficulty / Status --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">প্রশ্নকর্তা সংস্থা</label>
                        <select name="setter_organization_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            <option value="">সাধারণ / বিপিএসসি</option>
                            @foreach($setters as $st)
                                <option value="{{ $st->id }}">{{ $st->name_bn }} ({{ $st->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কাঠিন্য (Difficulty)</label>
                        <select name="difficulty" x-model="difficulty" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            <option value="easy">সহজ (Easy)</option>
                            <option value="medium" selected>মাঝারি (Medium)</option>
                            <option value="hard">কঠিন (Hard)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">স্ট্যাটাস</label>
                        <select name="status" x-model="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white font-bold">
                            <option value="draft">Draft</option>
                            <option value="review">Under Review</option>
                            <option value="published" selected>Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>

                {{-- Stem --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">প্রশ্নের মূল বক্তব্য (Stem - বাংলায়) <span class="text-indigo-600">(LaTeX $...$ সমর্থিত)</span></label>
                    <textarea name="stem_bn" x-model="stem" @input="renderPreview()" rows="3" required placeholder="প্রশ্ন লিখুন, যেমন: যদি $x + \frac{1}{x} = 3$ হয়..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm outline-none focus:border-indigo-500 font-medium"></textarea>
                </div>

                {{-- Marks config --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সঠিক উত্তরের মার্কস</label>
                        <input type="number" step="0.25" name="default_marks" value="1.00" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">নেগেটিভ মার্কস কর্তন</label>
                        <input type="number" step="0.05" name="negative_marks" value="0.50" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                    </div>
                </div>

                {{-- Options --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-700 uppercase">৪টি অপশন ও সঠিক উত্তর সিলেক্ট করুন</label>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">প্রতিটি অপশনের জন্য ব্যাখ্যা দেওয়া ঐচ্ছিক</span>
                    </div>
                    @foreach(['A', 'B', 'C', 'D'] as $i => $letter)
                        <div class="rounded-2xl bg-slate-50 border border-slate-200" x-data="{ explainOpen: false }">
                            <div class="flex items-center space-x-3 p-3">
                                <input type="radio" name="correct_option" value="{{ $i }}" {{ $i === 0 ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                <span class="font-black text-xs text-slate-700 w-6">{{ $letter }})</span>
                                <input type="text" name="options[{{ $i }}][text_bn]" x-model="options[{{ $i }}]" @input="renderPreview()" required placeholder="অপশন {{ $letter }} এর টেক্সট..." class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                                <button type="button" @click="explainOpen = !explainOpen" class="text-[10px] font-bold px-2.5 py-1 rounded-lg border border-slate-200 bg-white text-slate-600 hover:text-indigo-600 hover:border-slate-300">
                                    <span x-text="explainOpen ? 'ব্যাখ্যা লুকান' : 'কেন এই উত্তর?'"></span>
                                </button>
                            </div>
                            <div x-show="explainOpen" x-transition class="px-3 pb-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">এই অপশন কেন সঠিক/ভুল — ব্যাখ্যা (বাংলায়)</label>
                                <textarea name="options[{{ $i }}][explanation_bn]" x-model="optionExplanations[{{ $i }}]" @input="renderPreview()" rows="2" placeholder="যেমন: ১৯৭১ সালে বাংলাদেশ স্বাধীনতা লাভ করে, তাই অপশন B সঠিক..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white"></textarea>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Explanation / Reference / Tags --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">বিস্তারিত সমাধান ও ব্যাখ্যা</label>
                        <textarea name="explanation_bn" x-model="explanation" @input="renderPreview()" rows="3" placeholder="সমাধানের ধাপসমূহ ও ব্যাখ্যা..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">রেফারেন্স বই বা সূত্র</label>
                        <input type="text" name="reference_source" placeholder="যেমন: নবম-দশম শ্রেণির গণিত বই" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs mb-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">ট্যাগসমূহ (কমা দিয়ে আলাদা করুন)</label>
                        <input type="text" name="tags" x-model="tagsRaw" @input="renderPreview()" placeholder="46th BCS, BUET Pattern, বীজগণিত" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                    </div>
                </div>

                {{-- ===== LIVE PREVIEW CARD ===== --}}
                <div class="pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">🪞 লাইভ প্রিভিউ — ক্যাটাগরি সহ</h3>
                        <span class="text-[10px] font-bold text-indigo-600 uppercase flex items-center space-x-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                            <span>Auto-updating</span>
                        </span>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-4 shadow-xs">

                        {{-- Breadcrumb --}}
                        <div class="flex items-center flex-wrap gap-1.5 text-xs">
                            <template x-if="!subjectId">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-400 font-bold">📚 বিষয় নির্বাচন করুন</span>
                            </template>
                            <template x-if="subjectId">
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-bold" x-text="'📚 ' + subjectName"></span>
                            </template>
                            <template x-if="topicId">
                                <span class="text-slate-400 font-bold">→</span>
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-bold" x-text="'📂 ' + topicName"></span>
                            </template>
                            <template x-if="subtopicId">
                                <span class="text-slate-400 font-bold">→</span>
                                <span class="px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold" x-text="'🏷️ ' + subtopicName"></span>
                            </template>
                            <template x-if="difficulty">
                                <span class="ml-auto px-2 py-1 rounded text-[10px] font-black uppercase"
                                      :class="difficulty === 'easy' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : (difficulty === 'hard' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-amber-50 text-amber-700 border border-amber-200')"
                                      x-text="difficulty === 'easy' ? 'সহজ' : (difficulty === 'hard' ? 'কঠিন' : 'মাঝারি')"></span>
                            </template>
                        </div>

                        {{-- Stem rendered --}}
                        <div>
                            <div class="text-[10px] font-bold text-slate-500 uppercase mb-1">প্রশ্ন</div>
                            <div id="stem-preview" class="math-tex text-base font-bold text-slate-900 min-h-[28px] leading-relaxed" x-html="renderedStem"></div>
                        </div>

                        {{-- Options rendered --}}
                        <div>
                            <div class="text-[10px] font-bold text-slate-500 uppercase mb-2">অপশনসমূহ</div>
                            <div class="space-y-1.5">
                                <template x-for="(opt, idx) in options" :key="idx">
                                    <div>
                                        <div class="flex items-start space-x-2 text-xs">
                                            <span class="font-black w-5 text-slate-500" x-text="String.fromCharCode(65 + idx) + ')'"></span>
                                            <span class="text-slate-700" x-text="opt || '—'"></span>
                                        </div>
                                        <div x-show="optionExplanations[idx]" class="ml-7 mt-1 pl-2 border-l-2 border-slate-200 text-[11px] text-slate-500 italic">
                                            <span class="text-[10px] font-bold text-indigo-700 not-italic">কেন?</span>
                                            <span class="ml-1" x-text="optionExplanations[idx]"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Tags chips --}}
                        <div x-show="tagChips.length">
                            <div class="text-[10px] font-bold text-slate-500 uppercase mb-1">ট্যাগস</div>
                            <div class="flex flex-wrap gap-1">
                                <template x-for="tag in tagChips" :key="tag">
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold" x-text="'#' + tag"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.questions.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-xs transition">
                        প্রশ্ন সংরক্ষণ ও প্রকাশ করুন
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
function questionForm() {
    return {
        subjects: @json($subjects->map(fn($s) => ['id' => $s->id, 'name_bn' => $s->name_bn])->values()),
        topicsBySubject: @json($topicsBySubject ?? []),
        subtopicsByTopic: @json($subtopicsByTopic ?? []),
        subjectId: '',
        topicId: '',
        subtopicId: '',
        difficulty: 'medium',
        status: 'published',
        stem: '',
        options: ['', '', '', ''],
        optionExplanations: ['', '', '', ''],
        explanation: '',
        tagsRaw: '',
        renderedStem: '<span class="text-slate-400 italic font-normal">[প্রিভিউ এখানে দেখা যাবে]</span>',

        init() {
            this.$watch('subjectId', () => { this.topicId = ''; this.subtopicId = ''; });
            this.$watch('topicId', () => { this.subtopicId = ''; });
        },

        get subjectName() {
            const s = this.subjects.find(x => x.id == this.subjectId);
            return s ? s.name_bn : '';
        },
        get topicName() {
            const list = this.topicsBySubject[this.subjectId] || [];
            const t = list.find(x => x.id == this.topicId);
            return t ? t.name_bn : '';
        },
        get subtopicName() {
            const list = this.subtopicsByTopic[this.topicId] || [];
            const st = list.find(x => x.id == this.subtopicId);
            return st ? st.name_bn : '';
        },
        get tagChips() {
            return this.tagsRaw.split(',').map(t => t.trim()).filter(Boolean);
        },

        renderPreview() {
            this.renderedStem = this.stem
                ? this.stem
                : '<span class="text-slate-400 italic font-normal">[প্রিভিউ এখানে দেখা যাবে]</span>';
            this.$nextTick(() => {
                const el = document.getElementById('stem-preview');
                if (el && window.renderMathInElement) {
                    window.renderMathInElement(el);
                }
            });
        }
    }
}
</script>
@endsection
