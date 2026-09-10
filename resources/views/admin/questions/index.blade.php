@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6" x-data="{ uploadModal: false }">
    
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                    CMS Management
                </div>
                <h1 class="text-2xl font-black text-slate-900">{{ __t('প্রশ্ন ব্যাংক ও কনটেন্ট ম্যানেজমেন্ট', 'Question Bank & Content Management') }}</h1>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
                    ← {{ __t('ড্যাশবোর্ড', 'Dashboard') }}
                </a>
                <a href="{{ route('admin.questions.duplicates') }}" class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-bold text-xs transition flex items-center space-x-1">
                    <span>🔍 {{ __t('ডুপ্লিকেট চেকার', 'Duplicate Checker') }}</span>
                </a>
                <a href="{{ route('admin.questions.template') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition flex items-center space-x-1">
                    <span>📥 {{ __t('CSV টেমপ্লেট', 'CSV Template') }}</span>
                </a>
                <button type="button" @click="uploadModal = true" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition flex items-center space-x-1 shadow-xs">
                    <span>📤 {{ __t('বাল্ক আপলোড', 'Bulk Upload') }}</span>
                </button>
                <a href="{{ route('admin.questions.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition shadow-xs flex items-center space-x-1">
                    <span>+ {{ __t('নতুন প্রশ্ন', 'New Question') }}</span>
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('admin.questions.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="প্রশ্নের বিষয়বস্তু দিয়ে খুঁজুন..." class="px-3 py-2 rounded-xl border border-slate-200 text-xs w-60 bg-white">

                <select name="subject_id" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল বিষয়</option>
                    @foreach($subjects as $sb)
                        <option value="{{ $sb->id }}" {{ request('subject_id') == $sb->id ? 'selected' : '' }}>{{ $sb->name_bn }}</option>
                    @endforeach
                </select>

                <select name="setter_id" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল প্রশ্নকর্তা</option>
                    @foreach($setters as $st)
                        <option value="{{ $st->id }}" {{ request('setter_id') == $st->id ? 'selected' : '' }}>{{ $st->name_bn }} ({{ $st->code }})</option>
                    @endforeach
                </select>

                <select name="difficulty" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল কাঠিন্য</option>
                    <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>সহজ (Easy)</option>
                    <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>মাঝারি (Medium)</option>
                    <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>কঠিন (Hard)</option>
                </select>

                <select name="status" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল স্ট্যাটাস</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="review" {{ request('status') === 'review' ? 'selected' : '' }}>Under Review</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">ফিল্টার</button>
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
                            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($questions as $q)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-400">#{{ $q->id }}</td>
                                <td class="py-3.5 px-4 max-w-sm">
                                    <div class="font-bold text-slate-900 line-clamp-2">{!! strip_tags($q->stem_bn) !!}</div>
                                    @if($q->reference_source)
                                        <div class="text-[10px] text-slate-400 mt-0.5">সূত্র: {{ $q->reference_source }}</div>
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
                                        <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold text-[10px]">
                                            {{ $q->setterOrganization->code }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[10px]">সাধারণ</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-bold text-emerald-700">
                                    {{ $q->options->firstWhere('is_correct', true)?->option_letter ?? 'N/A' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-800">{{ number_format($q->accuracy_rate, 0) }}%</span>
                                    <span class="text-[10px] text-slate-400 block">({{ $q->times_served }} বার)</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $q->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($q->status === 'review' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $q->status }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right space-x-1">
                                    <a href="{{ route('admin.questions.edit', $q->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px]">
                                        এডিট
                                    </a>
                                    <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" class="inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই প্রশ্নটি মুছে ফেলতে চান?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[11px]">
                                            মুছুন
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-400">কোনো প্রশ্ন পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $questions->links() }}
            </div>
        </div>

    <!-- Bulk CSV Upload Modal -->
    <div x-show="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/40 backdrop-blur-xs" x-transition>
        <div @click.outside="uploadModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-black text-base text-slate-900">বাল্ক CSV প্রশ্ন আপলোড</h3>
            <p class="text-xs text-slate-500">প্রথমে স্ট্যান্ডার্ড CSV টেমপ্লেটটি ডাউনলোড করে প্রশ্ন এন্ট্রি করুন এবং এখানে ফাইলটি আপলোড করুন।</p>

            <form action="{{ route('admin.questions.bulk-upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <input type="file" name="csv_file" accept=".csv,.txt" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="uploadModal = false" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs">আপলোড করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
