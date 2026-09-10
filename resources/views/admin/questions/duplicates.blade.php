@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-black uppercase mb-1 border border-amber-200">
                Unified Repositories & Duplicate Resolver
            </div>
            <h1 class="text-2xl font-black text-slate-900">{{ __t('ডুপ্লিকেট প্রশ্ন শনাক্তকরণ ও সমাধান', 'Duplicate Question Resolver') }}</h1>
            <p class="text-xs text-slate-500">{{ __t('একই বা কাছাকাছি প্রশ্নগুলোর ট্যাগ ও রেফারেন্স একীভূত (Merge) করে অতিরিক্ত রো দূর করুন।', 'Detect duplicate stems and merge references/tags to keep repository clean.') }}</p>
        </div>

        <a href="{{ route('admin.questions.index') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
            ← {{ __t('প্রশ্ন তালিকায় ফিরুন', 'Back to Questions') }}
        </a>
    </div>

    @if(empty($duplicates))
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-xs space-y-3">
            <div class="text-4xl">✨</div>
            <h3 class="text-base font-black text-slate-900">কোনো ডুপ্লিকেট প্রশ্ন পাওয়া যায়নি!</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">আপনার প্রশ্ন ভাণ্ডারের প্রতিটি প্রশ্ন স্বতন্ত্র এবং সঠিকভাবে ট্যাগ করা রয়েছে।</p>
            <a href="{{ route('admin.questions.index') }}" class="inline-block px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs">
                প্রশ্ন ব্যাংক ব্রাউজ করুন
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($duplicates as $stemKey => $group)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 font-black text-[10px] uppercase">
                            {{ count($group) }} টি সদৃশ রেকর্ড পাওয়া গেছে
                        </span>
                        <span class="text-xs text-slate-500 font-medium">বিষয়: {{ $group[0]->subject->name_bn }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($group as $idx => $q)
                            <div class="p-4 rounded-2xl border {{ $idx === 0 ? 'border-indigo-300 bg-indigo-50/20' : 'border-slate-200 bg-slate-50/60' }} space-y-2 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-black {{ $idx === 0 ? 'text-indigo-700' : 'text-slate-600' }}">
                                        Question #{{ $q->id }} {{ $idx === 0 ? '(প্রস্তাবিত মূল কপি)' : '' }}
                                    </span>
                                    @if($q->setterOrganization)
                                        <span class="px-2 py-0.5 rounded-md bg-white text-indigo-700 border border-indigo-200 font-bold text-[10px]">
                                            {{ $q->setterOrganization->code }}
                                        </span>
                                    @endif
                                </div>

                                <div class="font-bold text-slate-900">
                                    {!! strip_tags($q->stem_bn) !!}
                                </div>

                                <div class="flex flex-wrap gap-1 pt-1">
                                    @foreach($q->tags as $t)
                                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] text-slate-600 font-medium">
                                            🏷️ {{ $t->tag_value }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="pt-2 text-[10px] text-slate-400 border-t border-slate-200/60">
                                    তৈরি: {{ $q->created_at->format('d M, Y') }} | সমাধান: {{ $q->reference_source ?? 'N/A' }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(count($group) >= 2)
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                            <div>
                                <h4 class="font-black text-amber-950">ট্যাগ মার্জ ও ডুপ্লিকেট সমাধান</h4>
                                <p class="text-amber-800 text-[11px]">#{{ $group[1]->id }} এর ট্যাগগুলো #{{ $group[0]->id }} তে একীভূত করে অতিরিক্ত কপিটি মুছে ফেলা হবে।</p>
                            </div>

                            <form action="{{ route('admin.questions.resolve-duplicate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="keep_question_id" value="{{ $group[0]->id }}">
                                <input type="hidden" name="delete_question_id" value="{{ $group[1]->id }}">
                                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition shrink-0">
                                    মার্জ ও ডুপ্লিকেট দূর করুন
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
