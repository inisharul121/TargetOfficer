@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6" x-data="{
    showNewChapterModal: false,
    editChapterModal: false,
    showNewTopicModal: false,
    activeChapterId: null,
    activeChapterNumber: '',
    activeChapterTitle: '',
    editChapterData: { id: '', chapter_number: '', title_bn: '', title_en: '', summary_bn: '' },
    openNewTopicModal(chId, chTitle) {
        this.activeChapterId = chId;
        this.activeChapterTitle = chTitle;
        this.showNewTopicModal = true;
    },
    openEditChapterModal(id, num, bn, en, sum) {
        this.editChapterData = { id: id, chapter_number: num, title_bn: bn, title_en: en, summary_bn: sum };
        this.editChapterModal = true;
    }
}">

    <!-- Top Breadcrumb & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-500 mb-1">
                <a href="{{ route('admin.books.index') }}" class="hover:text-indigo-600 transition">ডিজিটাল বই সমগ্র</a>
                <span>/</span>
                <span class="text-slate-900 font-black">{{ $book->title_bn }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 flex items-center space-x-2">
                <span>{{ $book->icon ?? '📖' }}</span>
                <span>অধ্যায় ও টপিক পরিচালনা (Book & Topics Builder)</span>
            </h1>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition flex items-center space-x-1.5 shadow-xs">
                <span>👁️</span>
                <span>ছাত্রদের ভিউয়ে দেখুন</span>
            </a>
            <button @click="showNewChapterModal = true" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition flex items-center space-x-1">
                <span>+ নতুন অধ্যায় যোগ করুন</span>
            </button>
        </div>
    </div>

    <!-- Book Summary Card -->
    <div class="p-6 rounded-3xl bg-gradient-to-br {{ $book->cover_theme }} text-white shadow-md relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2 max-w-3xl relative z-10">
            <div class="flex items-center space-x-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-white/20 backdrop-blur-xs text-white border border-white/20">
                    {{ $book->edition }}
                </span>
                <span class="text-xs font-bold text-white/80">বিষয়: {{ $book->subject ? $book->subject->name_bn : 'সাধারণ' }}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight">{{ $book->title_bn }}</h2>
            <p class="text-xs text-white/80 leading-relaxed font-medium line-clamp-2">{{ $book->description_bn }}</p>
        </div>

        <div class="flex items-center gap-3 shrink-0 relative z-10">
            <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-2xl text-center border border-white/20">
                <span class="text-[10px] font-bold text-white/70 uppercase block">মোট অধ্যায়</span>
                <span class="text-lg font-black text-white">{{ $book->chapters->count() }}টি</span>
            </div>
            <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-2xl text-center border border-white/20">
                <span class="text-[10px] font-bold text-white/70 uppercase block">মোট টপিক/পাঠ</span>
                <span class="text-lg font-black text-amber-300">
                    {{ $book->chapters->sum(fn($ch) => $ch->writtenContents->count()) }}টি
                </span>
            </div>
            <a href="{{ route('admin.books.edit', $book->id) }}" class="p-2.5 rounded-xl bg-white text-slate-800 hover:bg-slate-100 transition shadow-xs" title="বইয়ের মেটাডাটা এডিট">
                ✏️
            </a>
        </div>
        <div class="absolute -right-8 -bottom-8 w-44 h-44 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
    </div>

    <!-- Chapters & Topics List -->
    <div class="space-y-6">
        @if($book->chapters->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-xs space-y-3">
                <span class="text-5xl">📑</span>
                <h3 class="text-base font-bold text-slate-700">এই বইতে এখনও কোনো অধ্যায় যোগ করা হয়নি</h3>
                <p class="text-xs text-slate-400 max-w-md mx-auto">প্রথম অধ্যায় যুক্ত করে তাতে বিসিএস থিওরি, পাঠ ও লিখিত মডেল প্রশ্নোত্তরগুলো সাজান।</p>
                <div class="pt-2">
                    <button @click="showNewChapterModal = true" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">
                        + ১ম অধ্যায় তৈরি করুন
                    </button>
                </div>
            </div>
        @else
            @foreach($book->chapters as $ch)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                    
                    {{-- Chapter Header Banner --}}
                    <div class="p-5 bg-slate-50 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start space-x-3">
                            <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-black text-xs flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                {{ $ch->chapter_number }}
                            </span>
                            <div>
                                <h3 class="text-base font-black text-slate-900 leading-snug">
                                    {{ $ch->title_bn }}
                                </h3>
                                @if($ch->summary_bn)
                                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-1 italic">{{ $ch->summary_bn }}</p>
                                @endif
                                <div class="flex items-center space-x-3 text-[11px] text-slate-400 font-bold mt-1">
                                    <span class="text-indigo-600">📚 {{ $ch->writtenContents->count() }}টি পাঠ ও টপিক অন্তর্ভুক্ত</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 shrink-0">
                            {{-- Add Topic Button --}}
                            <button @click="openNewTopicModal({{ $ch->id }}, '{{ addslashes($ch->title_bn) }}')"
                                    class="px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-xs transition flex items-center space-x-1">
                                <span>+ টপিক যোগ করুন</span>
                            </button>

                            {{-- Edit Chapter Button --}}
                            <button @click="openEditChapterModal({{ $ch->id }}, {{ $ch->chapter_number }}, '{{ addslashes($ch->title_bn) }}', '{{ addslashes($ch->title_en ?? '') }}', '{{ addslashes($ch->summary_bn ?? '') }}')"
                                    class="p-1.5 rounded-lg border border-slate-200 hover:bg-white text-slate-600 transition"
                                    title="অধ্যায় সম্পাদনা">
                                ✏️
                            </button>

                            {{-- Delete Chapter --}}
                            <form method="POST" action="{{ route('admin.books.chapters.destroy', $ch->id) }}"
                                  onsubmit="return confirm('আপনি কি নিশ্চিত যে এই অধ্যায় এবং এর সকল টপিক মুছে ফেলতে চান?');"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg border border-slate-200 hover:bg-rose-50 text-rose-600 transition" title="অধ্যায় ডিলিট">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Topics / Written Contents List --}}
                    <div class="p-5 space-y-3">
                        @if($ch->writtenContents->isEmpty())
                            <div class="text-center py-6 border border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                                <p class="text-xs font-semibold text-slate-400">এই অধ্যায়ে এখনও কোনো টপিক বা টেক্সট কন্টেন্ট নেই।</p>
                                <button @click="openNewTopicModal({{ $ch->id }}, '{{ addslashes($ch->title_bn) }}')"
                                        class="mt-2 text-xs font-bold text-indigo-600 hover:underline">
                                    + প্রথম টপিক যুক্ত করুন
                                </button>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-3">
                                @foreach($ch->writtenContents as $tIndex => $topic)
                                    <div class="p-4 rounded-2xl border border-slate-200 hover:border-indigo-200 transition bg-white flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div class="space-y-1.5 min-w-0 flex-1">
                                            <div class="flex items-center space-x-2">
                                                <span class="w-5 h-5 rounded-md bg-slate-100 text-slate-600 font-bold text-[10px] flex items-center justify-center shrink-0">
                                                    {{ $tIndex + 1 }}
                                                </span>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider
                                                    @if($topic->content_type === 'written_question_solution') bg-purple-50 text-purple-700 border border-purple-200
                                                    @elseif($topic->content_type === 'theory_and_rules') bg-emerald-50 text-emerald-700 border border-emerald-200
                                                    @elseif($topic->content_type === 'math_step_solution') bg-cyan-50 text-cyan-700 border border-cyan-200
                                                    @else bg-slate-100 text-slate-700 border border-slate-200 @endif">
                                                    @if($topic->content_type === 'written_question_solution') মডেল সমাধান
                                                    @elseif($topic->content_type === 'theory_and_rules') থিওরি ও সূত্র
                                                    @elseif($topic->content_type === 'math_step_solution') গাণিতিক ধাপ
                                                    @else পাঠ্য বিষয় @endif
                                                </span>
                                                @if($topic->bcs_reference)
                                                    <span class="text-[10px] font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded">
                                                        🏛️ {{ $topic->bcs_reference }}
                                                    </span>
                                                @endif
                                                @if($topic->marks)
                                                    <span class="text-[10px] font-mono text-amber-700 font-bold">
                                                        {{ (int)$topic->marks }} নম্বর
                                                    </span>
                                                @endif
                                            </div>

                                            <h4 class="text-sm font-black text-slate-900 leading-snug">
                                                {{ $topic->title_bn }}
                                            </h4>

                                            @if($topic->question_bn)
                                                <p class="text-xs text-slate-600 line-clamp-1 italic">
                                                    <strong>প্রশ্ন:</strong> {{ $topic->question_bn }}
                                                </p>
                                            @endif
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex items-center space-x-1.5 shrink-0">
                                            <a href="{{ route('admin.books.topics.edit', $topic->id) }}"
                                               class="px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-bold text-indigo-700 transition flex items-center space-x-1">
                                                <span>✏️ এডিট টপিক</span>
                                            </a>

                                            <form method="POST" action="{{ route('admin.books.topics.destroy', $topic->id) }}"
                                                  onsubmit="return confirm('আপনি কি নিশ্চিত যে এই টপিকটি মুছে ফেলতে চান?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-xl border border-slate-200 hover:bg-rose-50 text-rose-600 transition" title="টপিক ডিলিট">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        @endif
    </div>

    {{-- MODAL 1: ADD NEW CHAPTER --}}
    <div x-show="showNewChapterModal"
         class="fixed inset-0 z-50 overflow-y-auto p-4 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center"
         style="display: none;">
        <div @click.away="showNewChapterModal = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-black text-slate-900">নতুন অধ্যায় যোগ করুন</h3>
                <button @click="showNewChapterModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.books.chapters.store', $book->id) }}" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায় নম্বর (Chapter #) <span class="text-rose-500">*</span></label>
                    <input type="number" name="chapter_number" value="{{ ($book->chapters->max('chapter_number') ?? 0) + 1 }}" min="1" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-bold">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায়ের নাম (বাংলায়) <span class="text-rose-500">*</span></label>
                    <input type="text" name="title_bn" required placeholder="e.g. অধ্যায় ৩: বাক্য ও বাক্য রূপান্তর"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-semibold">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায়ের নাম (ইংরেজিতে)</label>
                    <input type="text" name="title_en" placeholder="e.g. Chapter 3: Sentence Transformation"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায় সারসংক্ষেপ / মূল বিষয়</label>
                    <textarea name="summary_bn" rows="2" placeholder="এই অধ্যায়ের মূল আলোচ্য বিষয়..."
                              class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-medium"></textarea>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-2">
                    <button type="button" @click="showNewChapterModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">বাতিল</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-xs">অধ্যায় যোগ করুন</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 2: EDIT CHAPTER --}}
    <div x-show="editChapterModal"
         class="fixed inset-0 z-50 overflow-y-auto p-4 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center"
         style="display: none;">
        <div @click.away="editChapterModal = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-black text-slate-900">অধ্যায় সম্পাদনা করুন</h3>
                <button @click="editChapterModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <form method="POST" :action="`/admin/chapters/${editChapterData.id}`" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায় নম্বর <span class="text-rose-500">*</span></label>
                    <input type="number" name="chapter_number" x-model="editChapterData.chapter_number" min="1" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-bold">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায়ের নাম (বাংলায়) <span class="text-rose-500">*</span></label>
                    <input type="text" name="title_bn" x-model="editChapterData.title_bn" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-semibold">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায়ের নাম (ইংরেজিতে)</label>
                    <input type="text" name="title_en" x-model="editChapterData.title_en"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">অধ্যায় সারসংক্ষেপ</label>
                    <textarea name="summary_bn" x-model="editChapterData.summary_bn" rows="2"
                              class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-medium"></textarea>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-2">
                    <button type="button" @click="editChapterModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">বাতিল</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-xs">পরিবর্তন সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 3: ADD NEW TOPIC / CONTENT --}}
    <div x-show="showNewTopicModal"
         class="fixed inset-0 z-50 overflow-y-auto p-4 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center"
         style="display: none;">
        <div @click.away="showNewTopicModal = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-black text-slate-900">নতুন টপিক / পাঠ্য বিষয় যুক্ত করুন</h3>
                    <p class="text-xs text-slate-500 mt-0.5" x-text="`অধ্যায়: ${activeChapterTitle}`"></p>
                </div>
                <button @click="showNewTopicModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <form method="POST" :action="`/admin/chapters/${activeChapterId}/topics`" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700">টপিক / বিষয়ের শিরোনাম <span class="text-rose-500">*</span></label>
                        <input type="text" name="title_bn" required placeholder="e.g. বাক্য পরিবর্তন: সরল, জটিল ও যৌগিক বাক্য"
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-semibold">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">কন্টেন্টের ধরন (Content Type) <span class="text-rose-500">*</span></label>
                        <select name="content_type" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                            <option value="theory_and_rules">থিওরি ও নিয়মাবলী (Theory & Rules)</option>
                            <option value="written_question_solution">লিখিত মডেল প্রশ্ন ও উত্তর (Model Q&A)</option>
                            <option value="short_note">সংক্ষিপ্ত নোট / টীকা (Short Note)</option>
                            <option value="math_step_solution">ধাপভিত্তিক গাণিতিক সমাধান (Math Steps)</option>
                            <option value="essay_outline">রচনামূলক কাঠামো ও পয়েন্ট (Essay Outline)</option>
                            <option value="translation">অনুবাদ ও পরিভাষা (Translation)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">বিসিএস পরীক্ষার রেফারেন্স</label>
                        <input type="text" name="bcs_reference" placeholder="e.g. ৩৮তম ও ৪০তম বিসিএস লিখিত"
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">পূর্ণমান / নম্বর (Marks)</label>
                        <input type="number" step="0.5" name="marks" value="5.0" min="0" max="100"
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">প্রদর্শনের ক্রম (Order)</label>
                        <input type="number" name="order" value="0" min="0"
                               class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-mono">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">ফোকাস / মডেল প্রশ্ন (ঐচ্ছিক)</label>
                    <input type="text" name="question_bn" placeholder="যদি কোনো সুনির্দিষ্ট লিখিত প্রশ্ন থাকে..."
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">বিশদ পাঠ্য কন্টেন্ট (HTML সমর্থিত) <span class="text-rose-500">*</span></label>
                    <textarea name="content_bn" rows="6" required placeholder="টপিকের মূল আলোচনা, নিয়মাবলী, উদাহরণ ও টেবিল লিখুন..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-medium focus:ring-2 focus:ring-indigo-500"></textarea>
                    <span class="text-[10px] text-slate-400">টিপস: &lt;strong&gt;, &lt;table&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;br&gt; ইত্যাদি HTML ট্যাগ ব্যবহার করা যায়।</span>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-3">
                    <button type="button" @click="showNewTopicModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">বাতিল</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-xs">টপিক সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
