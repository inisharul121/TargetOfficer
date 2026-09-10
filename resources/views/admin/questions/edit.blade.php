@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto animate-fade-up">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">{{ __t('প্রশ্ন সম্পাদনা', 'Edit Question') }} #{{ $question->id }}</h1>
            <p class="text-xs text-slate-500">{{ __t('প্রশ্ন, সঠিক উত্তর, ব্যাখ্যা ও LaTeX সমীকরণ আপডেট করুন', 'Update question stem, correct answer, explanation and LaTeX formula.') }}</p>
        </div>
        <a href="{{ route('admin.questions.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
            ← {{ __t('তালিকায় ফিরুন', 'Back to List') }}
        </a>
    </div>

    @php
        $optsArray = array_values($question->options->sortBy('order')->pluck('option_text_bn')->toArray() ?: ['', '', '', '']);
        while(count($optsArray) < 4) { $optsArray[] = ''; }
        $tagsStr = $question->tags->pluck('tag_value')->implode(', ');
    @endphp

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm"
         x-data="questionEditForm(@js($question->topic_id), @js($question->subtopic_id))"
         x-init="renderPreview()">

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- CASCADE: Subject → Topic → Subtopic --}}
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-4 space-y-3">
                <div class="flex items-center space-x-2">
                    <span class="text-[10px] font-black uppercase text-indigo-700 tracking-wider">📚 {{ __t('ক্যাটাগরি হায়ারার্কি', 'Category Hierarchy') }}</span>
                    <span class="text-[10px] text-slate-500">{{ __t('বিষয় → টপিক → সাব-টপিক', 'Subject → Topic → Subtopic') }}</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('বিষয় (Subject)', 'Subject') }} <span class="text-rose-500">*</span></label>
                        <select name="subject_id" x-model="subjectId" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:border-indigo-500 outline-none">
                            <option value="">— {{ __t('বিষয় নির্বাচন করুন', 'Select Subject') }} —</option>
                            @foreach($subjects as $sb)
                                <option value="{{ $sb->id }}" {{ $question->subject_id == $sb->id ? 'selected' : '' }}>{{ $sb->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('টপিক (Topic)', 'Topic') }}</label>
                        <select name="topic_id" x-model="topicId" :disabled="!subjectId" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white disabled:bg-slate-100 disabled:text-slate-400 focus:border-indigo-500 outline-none">
                            <option value="">— {{ __t('টপিক নির্বাচন করুন', 'Select Topic') }} —</option>
                            <template x-for="t in (topicsBySubject[subjectId] || [])" :key="t.id">
                                <option :value="t.id" :selected="t.id == topicId" x-text="t.name_bn"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('সাব-টপিক (Subtopic)', 'Subtopic') }}</label>
                        <select name="subtopic_id" x-model="subtopicId" :disabled="!topicId" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white disabled:bg-slate-100 disabled:text-slate-400 focus:border-indigo-500 outline-none">
                            <option value="">— {{ __t('সাব-টপিক নির্বাচন করুন', 'Select Subtopic') }} —</option>
                            <template x-for="st in (subtopicsByTopic[topicId] || [])" :key="st.id">
                                <option :value="st.id" :selected="st.id == subtopicId" x-text="st.name_bn"></option>
                            </template>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Setter / Difficulty / Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('প্রশ্নকর্তা সংস্থা (Setter Body)', 'Question Setter Body') }}</label>
                    <select name="setter_organization_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:border-indigo-500 outline-none">
                        <option value="">{{ __t('সাধারণ / বিপিএসসি', 'General / BPSC') }}</option>
                        @foreach($setters as $st)
                            <option value="{{ $st->id }}" {{ $question->setter_organization_id == $st->id ? 'selected' : '' }}>{{ $st->name_bn }} ({{ $st->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('কাঠিন্য (Difficulty)', 'Difficulty') }}</label>
                    <select name="difficulty" x-model="difficulty" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white focus:border-indigo-500 outline-none">
                        <option value="easy" {{ $question->difficulty === 'easy' ? 'selected' : '' }}>{{ __t('সহজ (Easy)', 'Easy') }}</option>
                        <option value="medium" {{ $question->difficulty === 'medium' ? 'selected' : '' }}>{{ __t('মাঝারি (Medium)', 'Medium') }}</option>
                        <option value="hard" {{ $question->difficulty === 'hard' ? 'selected' : '' }}>{{ __t('কঠিন (Hard)', 'Hard') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('স্ট্যাটাস (Status)', 'Status') }}</label>
                    <select name="status" x-model="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white font-bold focus:border-indigo-500 outline-none">
                        <option value="draft" {{ $question->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="review" {{ $question->status === 'review' ? 'selected' : '' }}>Under Review</option>
                        <option value="published" {{ $question->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ $question->status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>

            {{-- Stem --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    {{ __t('প্রশ্নের মূল বক্তব্য (Stem - বাংলায়)', 'Question Stem (Bangla)') }} <span class="text-rose-500">*</span>
                    <span class="text-indigo-600 font-semibold lowercase">({{ __t('LaTeX $...$ সমর্থিত', 'LaTeX $...$ supported') }})</span>
                </label>
                <textarea name="stem_bn" x-model="stem" @input="renderPreview()" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm outline-none focus:border-indigo-500 font-medium leading-relaxed"></textarea>
            </div>

            <!-- Marks config -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('সঠিক উত্তরের মার্কস', 'Marks for Correct Answer') }}</label>
                    <input type="number" step="0.25" name="default_marks" value="{{ $question->default_marks }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('নেগেটিভ মার্কস কর্তন', 'Negative Marks Penalty') }}</label>
                    <input type="number" step="0.05" name="negative_marks" value="{{ $question->negative_marks }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">
                </div>
            </div>

            {{-- LIVE PREVIEW CARD --}}
            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">🪞 {{ __t('লাইভ প্রিভিউ', 'Live Preview') }}</h3>
                    <span class="text-[10px] font-bold text-indigo-600 uppercase flex items-center space-x-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                        <span>{{ __t('স্বয়ংক্রিয় আপডেট', 'Auto-updating') }}</span>
                    </span>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs space-y-3">
                    <div class="flex items-center flex-wrap gap-1.5 text-xs">
                        <template x-if="subjectName">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold" x-text="'📚 ' + subjectName"></span>
                        </template>
                        <template x-if="topicName">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold" x-text="'📂 ' + topicName"></span>
                        </template>
                        <template x-if="subtopicName">
                            <span class="px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-bold" x-text="'🏷️ ' + subtopicName"></span>
                        </template>
                    </div>

                    <div id="stem-preview-edit" class="math-tex text-base font-bold text-slate-900 min-h-[28px] leading-relaxed" x-html="renderedStem"></div>
                </div>
            </div>

            <!-- Options -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase">
                    {{ __t('৪টি অপশন ও সঠিক উত্তর নির্বাচন করুন', 'Select 4 Options and Mark the Correct Answer') }} <span class="text-rose-500">*</span>
                </label>
                
                @php
                    $optsList = $question->options->sortBy('order')->values();
                    $correctIndex = $optsList->search(fn($o) => $o->is_correct) !== false ? $optsList->search(fn($o) => $o->is_correct) : 0;
                @endphp

                @foreach(['A', 'B', 'C', 'D'] as $i => $letter)
                    @php
                        $optObj = $optsList[$i] ?? null;
                    @endphp
                    <div class="flex items-center space-x-3 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <input type="radio" name="correct_option" value="{{ $i }}" {{ $correctIndex == $i ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        <span class="font-black text-xs text-slate-700 w-6">{{ $letter }})</span>
                        <input type="text" name="options[{{ $i }}][text_bn]" value="{{ $optObj?->option_text_bn }}" required placeholder="{{ __t('অপশন ' . $letter . ' এর টেক্সট...', 'Option ' . $letter . ' text...') }}" class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white focus:border-indigo-500 outline-none">
                    </div>
                @endforeach
            </div>

            <!-- Explanation & Reference -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('বিস্তারিত সমাধান ও ব্যাখ্যা', 'Detailed Explanation') }}</label>
                    <textarea name="explanation_bn" rows="3" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">{{ $question->explanation_bn }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('রেফারেন্স বই বা সূত্র', 'Reference Book / Source') }}</label>
                    <input type="text" name="reference_source" value="{{ $question->reference_source }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs mb-3 focus:border-indigo-500 outline-none">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">{{ __t('ট্যাগসমূহ (কমা দিয়ে আলাদা করুন)', 'Tags (comma separated)') }}</label>
                    <input type="text" name="tags" value="{{ $tagsStr }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:border-indigo-500 outline-none">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.questions.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    {{ __t('বাতিল', 'Cancel') }}
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md transition">
                    {{ __t('পরিবর্তনসমূহ সংরক্ষণ করুন', 'Save Changes') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function questionEditForm(initialTopicId, initialSubtopicId) {
    return {
        topicsBySubject: {{ Js::from($topicsBySubject ?? []) }},
        subtopicsByTopic: {{ Js::from($subtopicsByTopic ?? []) }},
        subjectId: {{ Js::from($question->subject_id) }},
        topicId: initialTopicId || '',
        subtopicId: initialSubtopicId || '',
        difficulty: {{ Js::from($question->difficulty ?? 'medium') }},
        status: {{ Js::from($question->status ?? 'published') }},
        stem: {{ Js::from($question->stem_bn) }},
        options: {{ Js::from($optsArray) }},
        renderedStem: {{ Js::from($question->stem_bn) }},

        init() {
            this.$watch('subjectId', () => { this.topicId = ''; this.subtopicId = ''; });
            this.$watch('topicId', () => { this.subtopicId = ''; });
        },

        get subjectName() {
            const sel = document.querySelector('select[name=subject_id]');
            const opt = sel ? sel.options[sel.selectedIndex] : null;
            return opt && this.subjectId ? opt.text.trim() : '';
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

        renderPreview() {
            this.renderedStem = this.stem || '<span class="text-slate-400 italic font-normal">[প্রিভিউ এখানে দেখা যাবে]</span>';
            this.$nextTick(() => {
                const el = document.getElementById('stem-preview-edit');
                if (el && window.renderMathInElement) {
                    window.renderMathInElement(el);
                }
            });
        }
    }
}
</script>
@endsection
