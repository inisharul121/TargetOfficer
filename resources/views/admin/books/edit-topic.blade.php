@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    
    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 font-semibold mb-1">
                <a href="{{ route('admin.books.index') }}" class="hover:text-indigo-600">ডিজিটাল বই</a>
                <span>/</span>
                <a href="{{ route('admin.books.builder', $topic->chapter->book_id) }}" class="hover:text-indigo-600">{{ $topic->chapter->book->title_bn }}</a>
                <span>/</span>
                <span class="text-slate-700">অধ্যায় {{ $topic->chapter->chapter_number }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">পাঠ / টপিক সম্পাদনা</h1>
            <p class="text-xs text-slate-500">টপিকের শিরোনাম, ক্যাটাগরি, রেফারেন্স এবং মূল তাত্ত্বিক/লিখিত বিষয়বস্তু আপডেট করুন।</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.books.builder', $topic->chapter->book_id) }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                বিল্ডারে ফিরে যান
            </a>
            <a href="{{ route('books.read', [$topic->chapter->book->slug, $topic->chapter->chapter_number]) }}" target="_blank" class="px-4 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs transition inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                রিডারে দেখুন
            </a>
        </div>
    </div>

    <!-- Chapter Meta Notice -->
    <div class="bg-indigo-50/60 border border-indigo-100 rounded-2xl p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white font-black text-sm flex items-center justify-center">
                {{ $topic->chapter->chapter_number }}
            </div>
            <div>
                <p class="text-xs font-bold text-indigo-900">অধ্যায়: {{ $topic->chapter->title_bn }}</p>
                <p class="text-[11px] text-indigo-700">বই: {{ $topic->chapter->book->title_bn }}</p>
            </div>
        </div>
        <span class="text-xs px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-800 font-bold">
            আইডি #{{ $topic->id }}
        </span>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.books.topics.update', $topic->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Title BN --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        টপিক / পাঠের নাম (বাংলায়) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title_bn" value="{{ old('title_bn', $topic->title_bn) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden"
                           placeholder="যেমন: ধ্বনি ও বর্ণ প্রকরণ, ব্যাকরণিক বিশ্লেষণ">
                    @error('title_bn') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Content Type --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        কন্টেন্টের ধরণ (Content Type) <span class="text-rose-500">*</span>
                    </label>
                    <select name="content_type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                        <option value="theory_and_rules" {{ old('content_type', $topic->content_type) === 'theory_and_rules' ? 'selected' : '' }}>
                            📘 তাত্ত্বিক নিয়ম ও আলোচনা (Theory & Rules)
                        </option>
                        <option value="written_question_solution" {{ old('content_type', $topic->content_type) === 'written_question_solution' ? 'selected' : '' }}>
                            ✍️ লিখিত প্রশ্ন সমাধান (Written Solution)
                        </option>
                        <option value="short_note" {{ old('content_type', $topic->content_type) === 'short_note' ? 'selected' : '' }}>
                            📝 সংক্ষিপ্ত টীকা (Short Note)
                        </option>
                        <option value="math_step_solution" {{ old('content_type', $topic->content_type) === 'math_step_solution' ? 'selected' : '' }}>
                            📐 গাণিতিক সমাধান ধাপ (Math Step Solution)
                        </option>
                        <option value="essay_outline" {{ old('content_type', $topic->content_type) === 'essay_outline' ? 'selected' : '' }}>
                            📑 রচনা বা ভাবার্থ রূপরেখা (Essay Outline)
                        </option>
                        <option value="translation" {{ old('content_type', $topic->content_type) === 'translation' ? 'selected' : '' }}>
                            🌐 বঙ্গানুবাদ ও অনুবাদ রীতি (Translation)
                        </option>
                    </select>
                    @error('content_type') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Marks --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        বরাদ্দকৃত নম্বর (Marks)
                    </label>
                    <input type="number" step="0.5" name="marks" value="{{ old('marks', $topic->marks) }}" min="0" max="100"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden"
                           placeholder="5.0">
                    @error('marks') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- BCS Reference --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        বিসিএস লিখিত রেফারেন্স (BCS Exam Reference)
                    </label>
                    <input type="text" name="bcs_reference" value="{{ old('bcs_reference', $topic->bcs_reference) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden"
                           placeholder="যেমন: ৪০তম ও ৪১তম বিসিএস লিখিত">
                    @error('bcs_reference') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Order --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        অধ্যায়ের মধ্যে ক্রম (Order sequence)
                    </label>
                    <input type="number" name="order" value="{{ old('order', $topic->order) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    @error('order') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Question BN (Optional) --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        প্রশ্ন / মূল জিজ্ঞাসা (যদি থাকে)
                    </label>
                    <input type="text" name="question_bn" value="{{ old('question_bn', $topic->question_bn) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden"
                           placeholder="যেমন: বাংলা ধ্বনিতত্ত্ব কাকে বলে? মৌলিক স্বরধ্বনি কয়টি ও কি কি?">
                    <p class="text-[11px] text-slate-400">লিখিত প্রশ্ন উত্তরের ক্ষেত্রে প্রশ্নের মূল বক্তব্য এখানে দিন।</p>
                    @error('question_bn') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Content BN (Rich / HTML supported) --}}
                <div class="space-y-1.5 md:col-span-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-700">
                            মূল পড়া / বিষয়বস্তু (Text Content & HTML) <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[11px] text-slate-400 font-medium">
                            HTML ট্যাগ যেমন &lt;p&gt;, &lt;h3&gt;, &lt;ul&gt;, &lt;table&gt;, &lt;strong&gt; সমর্থিত
                        </span>
                    </div>

                    {{-- Quick formatting toolbar --}}
                    <div class="flex flex-wrap items-center gap-1.5 p-2 bg-slate-50 border border-slate-200 rounded-t-xl text-xs font-semibold text-slate-600" id="topicToolbar">
                        <button type="button" onclick="insertTag('strong')" class="px-2 py-1 rounded bg-white hover:bg-slate-100 border border-slate-200"><strong>B</strong></button>
                        <button type="button" onclick="insertTag('em')" class="px-2 py-1 rounded bg-white hover:bg-slate-100 border border-slate-200"><em>I</em></button>
                        <button type="button" onclick="insertHeading('h3')" class="px-2 py-1 rounded bg-white hover:bg-slate-100 border border-slate-200">H3 শিরোনাম</button>
                        <button type="button" onclick="insertHeading('h4')" class="px-2 py-1 rounded bg-white hover:bg-slate-100 border border-slate-200">H4 উপশিরোনাম</button>
                        <button type="button" onclick="insertList()" class="px-2 py-1 rounded bg-white hover:bg-slate-100 border border-slate-200">• বুলেট লিস্ট</button>
                        <button type="button" onclick="insertCallout()" class="px-2 py-1 rounded bg-white hover:bg-slate-100 border border-slate-200">💡 টিপস বক্স</button>
                        <button type="button" onclick="insertTable()" class="px-2 py-1 rounded bg-white hover:bg-slate-100 border border-slate-200">📊 ছক (Table)</button>
                    </div>

                    <textarea id="topicContentBn" name="content_bn" rows="18" required
                              class="w-full px-4 py-3 rounded-b-xl border border-t-0 border-slate-200 text-sm font-sans focus:ring-2 focus:ring-indigo-500 focus:outline-hidden leading-relaxed">{{ old('content_bn', $topic->content_bn) }}</textarea>
                    @error('content_bn') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Submit buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.books.builder', $topic->chapter->book_id) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs transition">
                    বাতিল করুন
                </a>
                
                <div class="flex items-center space-x-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm shadow-indigo-200 transition">
                        ✓ পরিবর্তন সংরক্ষণ করুন
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Danger Zone: Delete Topic -->
    <div class="bg-rose-50/60 border border-rose-200 rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-rose-900">টপিক মুছে ফেলুন</h3>
            <p class="text-xs text-rose-600 mt-0.5">এই পাঠ বা টপিকটি মুছে ফেললে তা আর ফেরত আনা যাবে না।</p>
        </div>
        <form method="POST" action="{{ route('admin.books.topics.destroy', $topic->id) }}" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই টপিকটি পুরোপুরি মুছে ফেলতে চান?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition">
                🗑️ টপিকটি ডিলিট করুন
            </button>
        </form>
    </div>

</div>

<script>
function insertTag(tagName) {
    const textarea = document.getElementById('topicContentBn');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end) || 'এখানে লিখুন';
    const replacement = `<${tagName}>${selectedText}</${tagName}>`;
    textarea.setRangeText(replacement, start, end, 'end');
    textarea.focus();
}

function insertHeading(level) {
    const textarea = document.getElementById('topicContentBn');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end) || 'গুরুত্বপূর্ণ শিরোনাম';
    const replacement = `\n<${level} class="text-lg font-bold text-slate-900 mt-4 mb-2">${selectedText}</${level}>\n`;
    textarea.setRangeText(replacement, start, end, 'end');
    textarea.focus();
}

function insertList() {
    const textarea = document.getElementById('topicContentBn');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const replacement = `\n<ul class="list-disc list-inside space-y-1 my-2">\n  <li>প্রথম পয়েন্ট বা বৈশিষ্ট্য</li>\n  <li>দ্বিতীয় গুরুত্বপূর্ণ তথ্য</li>\n</ul>\n`;
    textarea.setRangeText(replacement, start, end, 'end');
    textarea.focus();
}

function insertCallout() {
    const textarea = document.getElementById('topicContentBn');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const replacement = `\n<div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 my-4">\n  <strong>বিসিএস স্পেশাল টিপস:</strong> বিগত লিখিত পরীক্ষায় এই নিয়ম থেকে প্রায়ই প্রশ্ন এসেছে।\n</div>\n`;
    textarea.setRangeText(replacement, start, end, 'end');
    textarea.focus();
}

function insertTable() {
    const textarea = document.getElementById('topicContentBn');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const replacement = `\n<div class="overflow-x-auto my-4">\n  <table class="w-full text-xs text-left border border-slate-200">\n    <thead class="bg-slate-100 font-bold">\n      <tr>\n        <th class="p-2 border border-slate-200">ক্রম</th>\n        <th class="p-2 border border-slate-200">বিষয় / পরিভাষা</th>\n        <th class="p-2 border border-slate-200">অর্থ বা উদাহরণ</th>\n      </tr>\n    </thead>\n    <tbody>\n      <tr>\n        <td class="p-2 border border-slate-200">১</td>\n        <td class="p-2 border border-slate-200">স্বরধ্বনি</td>\n        <td class="p-2 border border-slate-200">অ, আ, ই ইত্যাদি</td>\n      </tr>\n    </tbody>\n  </table>\n</div>\n`;
    textarea.setRangeText(replacement, start, end, 'end');
    textarea.focus();
}
</script>
@endsection
