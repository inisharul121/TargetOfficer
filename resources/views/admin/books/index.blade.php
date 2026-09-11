@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                Digital Books & Topics CMS
            </div>
            <h1 class="text-2xl font-black text-slate-900">{{ __t('বিষয়ভিত্তিক ডিজিটাল ই-বুক ও পাঠ্যবই সমগ্র', 'Digital Books & Textbooks Management') }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">বিসিএস ও অন্যান্য সরকারি চাকরির জন্য বিষয়ভিত্তিক টেক্সটবুক, অধ্যায় ও লিখিত টপিকসমূহ পরিচালনা করুন।</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
                ← {{ __t('ড্যাশবোর্ড', 'Dashboard') }}
            </a>
            <a href="{{ route('admin.books.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition shadow-xs flex items-center space-x-1">
                <span>+ {{ __t('নতুন বই যুক্ত করুন', 'Add New Book') }}</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.books.index') }}" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="বইয়ের নাম বা স্লাগ খুঁজুন..." class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs w-60 bg-white">

            <select name="subject_id" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                <option value="">সকল বিষয় (All Subjects)</option>
                @foreach($subjects as $subj)
                    <option value="{{ $subj->id }}" {{ request('subject_id') == $subj->id ? 'selected' : '' }}>{{ $subj->name_bn ?? $subj->name_en }}</option>
                @endforeach
            </select>

            <select name="is_published" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                <option value="">সকল স্ট্যাটাস</option>
                <option value="1" {{ request('is_published') === '1' ? 'selected' : '' }}>প্রকাশিত (Published)</option>
                <option value="0" {{ request('is_published') === '0' ? 'selected' : '' }}>খসড়া (Unpublished)</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">ফিল্টার</button>
            @if(request()->hasAny(['search', 'subject_id', 'is_published']))
                <a href="{{ route('admin.books.index') }}" class="px-3 py-2 text-xs font-bold text-slate-500 hover:text-slate-800">রিসেট</a>
            @endif
        </form>
    </div>

    <!-- Books Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        @if($books->isEmpty())
            <div class="text-center py-16 space-y-3">
                <span class="text-5xl">📚</span>
                <h3 class="text-base font-bold text-slate-700">কোনো বই পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-400">নতুন বই তৈরি করতে উপরের '+ নতুন বই যুক্ত করুন' বাটনে ক্লিক করুন।</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4">বইয়ের বিবরণ ও কভার</th>
                            <th class="py-3.5 px-4">বিষয় ও পাঠ্যক্রম</th>
                            <th class="py-3.5 px-4">অধ্যায় সংখ্যা</th>
                            <th class="py-3.5 px-4">টপিক / পাঠ সংখ্যা</th>
                            <th class="py-3.5 px-4">ক্রম</th>
                            <th class="py-3.5 px-4">অবস্থা</th>
                            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @foreach($books as $book)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br {{ $book->cover_theme }} text-white flex items-center justify-center text-lg shrink-0 shadow-xs">
                                            {{ $book->icon ?? '📖' }}
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.books.builder', $book->id) }}" class="font-black text-slate-900 hover:text-indigo-600 transition truncate block text-sm">
                                                {{ $book->title_bn }}
                                            </a>
                                            <span class="text-[10px] text-slate-400 font-mono block">slug: {{ $book->slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-800">{{ $book->subject ? $book->subject->name_bn : 'সাধারণ' }}</span>
                                    <span class="text-[10px] text-slate-400 block">{{ $book->edition }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-slate-100 text-slate-800 font-black">
                                        {{ $book->chapters_count }}টি অধ্যায়
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-indigo-50 text-indigo-700 font-black">
                                        {{ $book->written_contents_count }}টি টপিক
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-slate-500">
                                    #{{ $book->order }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($book->is_published)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            ✓ প্রকাশিত
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 border border-amber-200">
                                            খসড়া (Draft)
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end space-x-1.5">
                                        <a href="{{ route('admin.books.builder', $book->id) }}" 
                                           class="px-2.5 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition flex items-center space-x-1"
                                           title="অধ্যায় ও টপিক পরিচালনা করুন">
                                            <span>📑</span>
                                            <span>টপিক বিল্ডার</span>
                                        </a>

                                        <a href="{{ route('admin.books.edit', $book->id) }}" 
                                           class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-600 transition"
                                           title="বই এডিট">
                                            ✏️
                                        </a>

                                        <a href="{{ route('books.show', $book->slug) }}" 
                                           target="_blank"
                                           class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-600 transition"
                                           title="রিডারে লাইভ দেখুন">
                                            👁️
                                        </a>

                                        <form method="POST" action="{{ route('admin.books.destroy', $book->id) }}" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই বইটি এবং এর সকল অধ্যায় ও টপিক মুছে ফেলতে চান?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg hover:bg-rose-50 text-rose-600 transition" title="মুছে ফেলুন">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $books->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
