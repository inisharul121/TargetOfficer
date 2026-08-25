@extends('layouts.app')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen" x-data="{ uploadModal: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-[10px] font-black uppercase mb-1">
                    CMS Management
                </div>
                <h1 class="text-2xl font-black text-slate-900">প্রশ্ন ব্যাংক ও কনটেন্ট ম্যানেজমেন্ট</h1>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.questions.template') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>📥 CSV টেমপ্লেট ডাউনলোড</span>
                </a>
                <button type="button" @click="uploadModal = true" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition flex items-center space-x-1 shadow-xs">
                    <span>📤 বাল্ক CSV আপলোড</span>
                </button>
                <a href="{{ route('admin.questions.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition shadow-sm">
                    + নতুন প্রশ্ন যোগ করুন
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('admin.questions.index') }}" class="flex flex-wrap items-center gap-3">
                <select name="subject_id" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল বিষয়</option>
                    @foreach($subjects as $sb)
                        <option value="{{ $sb->id }}" {{ request('subject_id') == $sb->id ? 'selected' : '' }}>{{ $sb->name_bn }}</option>
                    @endforeach
                </select>

                <select name="status" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল স্ট্যাটাস</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="review" {{ request('status') === 'review' ? 'selected' : '' }}>Under Review</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white font-bold text-xs">ফিল্টার</button>
            </form>
        </div>

        <!-- Questions Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4">#ID</th>
                            <th class="py-3.5 px-4">প্রশ্ন (Stem)</th>
                            <th class="py-3.5 px-4">বিষয় ও টপিক</th>
                            <th class="py-3.5 px-4">প্যাটার্ন</th>
                            <th class="py-3.5 px-4">সঠিক অপশন</th>
                            <th class="py-3.5 px-4">নির্ভুলতা</th>
                            <th class="py-3.5 px-4">স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @foreach($questions as $q)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-400">#{{ $q->id }}</td>
                                <td class="py-3.5 px-4 max-w-sm">
                                    <div class="font-bold text-slate-900 line-clamp-1">{!! strip_tags($q->stem_bn) !!}</div>
                                    @if($q->reference_source)
                                        <div class="text-[10px] text-slate-400">সূত্র: {{ $q->reference_source }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-slate-800">{{ $q->subject->name_bn }}</span>
                                    @if($q->topic)
                                        <div class="text-[10px] text-slate-400">{{ $q->topic->name_bn }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($q->setterOrganization)
                                        <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 font-bold text-[10px]">
                                            {{ $q->setterOrganization->code }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[10px]">সাধারণ</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-bold text-emerald-600">
                                    {{ $q->options->firstWhere('is_correct', true)?->option_letter ?? 'N/A' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-800">{{ number_format($q->accuracy_rate, 0) }}%</span>
                                    <span class="text-[10px] text-slate-400 block">({{ $q->times_served }} বার)</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase">
                                        {{ $q->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $questions->links() }}
            </div>
        </div>
    </div>

    <!-- Bulk CSV Upload Modal -->
    <div x-show="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" x-transition>
        <div @click.outside="uploadModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-black text-base text-slate-900">বাল্ক CSV প্রশ্ন আপলোড</h3>
            <p class="text-xs text-slate-500">প্রথমে স্ট্যান্ডার্ড CSV টেমপ্লেটটি ডাউনলোড করে প্রশ্ন এন্ট্রি করুন এবং এখানে ফাইলটি আপলোড করুন।</p>

            <form action="{{ route('admin.questions.bulk-upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <input type="file" name="csv_file" accept=".csv" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="uploadModal = false" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs">আপলোড করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
