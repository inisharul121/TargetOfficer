@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                Item Calibration & Deep Analytics
            </div>
            <h1 class="text-2xl font-black text-slate-900">{{ __t('প্ল্যাটফর্ম ও প্রশ্ন ক্যালিব্রেশন অ্যানালিটিক্স', 'Platform & Item Calibration Analytics') }}</h1>
            <p class="text-xs text-slate-500">{{ __t('আইটেম ডিফিকাল্টি, ক্যান্ডিডেট দুর্বলতা ও প্রশ্নকর্তা প্যাটার্ন রিপোর্ট', 'Item difficulty index, candidate weakness profiling, and setter pattern metrics.') }}</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
            ← {{ __t('ড্যাশবোর্ড', 'Dashboard') }}
        </a>
    </div>

    <!-- Global Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-1">
            <span class="text-xs text-slate-400 font-bold uppercase">মোট সম্পন্ন পরীক্ষা</span>
            <div class="text-2xl font-black text-slate-900">{{ number_format($totalCompletedAttempts) }}</div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-1">
            <span class="text-xs text-slate-400 font-bold uppercase">গড় প্ল্যাটফর্ম স্কোর</span>
            <div class="text-2xl font-black text-indigo-600">{{ number_format($globalAverageScore, 1) }}</div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-1">
            <span class="text-xs text-slate-400 font-bold uppercase">গড় নির্ভুলতার হার (Accuracy)</span>
            <div class="text-2xl font-black text-emerald-600">{{ number_format($globalAverageAccuracy, 1) }}%</div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-1">
            <span class="text-xs text-slate-400 font-bold uppercase">ট্যাব-সুইচ অ্যালার্ট (Anti-Cheat)</span>
            <div class="text-2xl font-black text-rose-600">{{ number_format($totalTabSwitches) }} বার</div>
        </div>
    </div>

    <!-- 2 Column: Lowest Accuracy Questions (Flawed / Tricky) vs Setter Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Lowest Accuracy Questions (Tricky / Potential Distractors) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-black text-slate-900">কঠিন / ত্রুটিপূর্ণ প্রশ্নাবলি (Item Difficulty)</h2>
                    <p class="text-xs text-slate-400">যেসব প্রশ্নে শিক্ষার্থীদের ভুলের হার সবচেয়ে বেশি</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($lowestAccuracyQuestions as $q)
                    <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 border border-rose-200 font-black text-[10px]">
                                Accuracy: {{ number_format($q->accuracy_rate, 0) }}% ({{ $q->times_served }} বার জিজ্ঞাসিত)
                            </span>
                            <span class="text-[10px] text-slate-500 font-bold">{{ $q->subject->name_bn }}</span>
                        </div>

                        <div class="font-bold text-slate-900 line-clamp-2">
                            {!! strip_tags($q->stem_bn) !!}
                        </div>

                        <div class="flex items-center justify-between pt-1 border-t border-slate-200/60 text-[10px]">
                            <span class="text-slate-500">প্যাটার্ন: <strong class="text-indigo-600">{{ $q->setterOrganization?->code ?? 'সাধারণ' }}</strong></span>
                            <a href="{{ route('admin.questions.edit', $q->id) }}" class="text-indigo-600 font-bold hover:underline">
                                পর্যালোচনা করুন →
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">এখনো পর্যাপ্ত পরীক্ষার ডেটা সংরক্ষিত হয়নি।</p>
                @endforelse
            </div>
        </div>

        <!-- Setter Performance & Accuracy Ranking -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
            <div>
                <h2 class="text-base font-black text-slate-900">প্রশ্নকর্তা সংস্থা পারফরম্যান্স ও কাঠিন্য</h2>
                <p class="text-xs text-slate-400">বিভিন্ন সংস্থার প্রশ্নে শিক্ষার্থীদের গড় নির্ভুলতার তুলনা</p>
            </div>

            <div class="space-y-3">
                @foreach($setterAnalytics as $st)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-900 flex items-center space-x-2">
                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200 font-black text-[10px]">{{ $st->code }}</span>
                                <span>{{ $st->name_bn ?? $st->name_en }}</span>
                            </span>
                            <span class="text-slate-500">{{ $st->questions_count }} টি প্রশ্ন</span>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-slate-500 pt-1">
                            <span>গড় নির্ভুলতা হার:</span>
                            <strong class="text-indigo-600 font-black">{{ number_format($st->avg_accuracy, 1) }}%</strong>
                        </div>
                        <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $st->avg_accuracy }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
