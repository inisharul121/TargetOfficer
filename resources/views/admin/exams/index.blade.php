@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6">
    
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                    Exam Management & Scheduler
                </div>
                <h1 class="text-2xl font-black text-slate-900">{{ __t('সকল পরীক্ষা ও মডেল টেস্ট', 'All Exams & Model Tests') }}</h1>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
                    ← {{ __t('ড্যাশবোর্ড', 'Dashboard') }}
                </a>
                <a href="{{ route('admin.exams.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition shadow-xs flex items-center space-x-1">
                    <span>+ {{ __t('নতুন পরীক্ষা তৈরি', 'Create New Exam') }}</span>
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('admin.exams.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="পরীক্ষার নাম দিয়ে খুঁজুন..." class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs w-60 bg-white">

                <select name="mode" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল মোড</option>
                    <option value="timed_mock" {{ request('mode') === 'timed_mock' ? 'selected' : '' }}>টাইমড মডেল টেস্ট (Timed Mock)</option>
                    <option value="live_model_test" {{ request('mode') === 'live_model_test' ? 'selected' : '' }}>লাইভ শিডিউলড টেস্ট (Live Test)</option>
                    <option value="practice" {{ request('mode') === 'practice' ? 'selected' : '' }}>অনুশীলন মোড (Practice)</option>
                    <option value="previous_year" {{ request('mode') === 'previous_year' ? 'selected' : '' }}>বিগত বছরের প্রশ্ন (Archive)</option>
                    <option value="daily_quiz" {{ request('mode') === 'daily_quiz' ? 'selected' : '' }}>ডেইলি স্পিড কুইজ</option>
                </select>

                <select name="org_id" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল সংস্থা</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}" {{ request('org_id') == $org->id ? 'selected' : '' }}>{{ $org->name_bn ?? $org->name_en }} ({{ $org->code }})</option>
                    @endforeach
                </select>

                <select name="is_published" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                    <option value="">সকল পাবলিকেশন অবস্থা</option>
                    <option value="1" {{ request('is_published') === '1' ? 'selected' : '' }}>প্রকাশিত (Published)</option>
                    <option value="0" {{ request('is_published') === '0' ? 'selected' : '' }}>ড্রাফট (Unpublished)</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">ফিল্টার</button>
            </form>
        </div>

        <!-- Exams Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4">পরীক্ষার শিরোনাম</th>
                            <th class="py-3.5 px-4">মোড</th>
                            <th class="py-3.5 px-4">সংস্থা / ধরন</th>
                            <th class="py-3.5 px-4">প্রশ্ন সংখ্যা</th>
                            <th class="py-3.5 px-4">সময় ও মার্কস</th>
                            <th class="py-3.5 px-4">স্ট্যাটাস</th>
                            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($exams as $exam)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 max-w-xs">
                                    <div class="font-bold text-slate-900">{{ $exam->title_bn }}</div>
                                    @if($exam->title_en)
                                        <div class="text-[10px] text-slate-400">{{ $exam->title_en }}</div>
                                    @endif
                                    @if($exam->scheduled_start_at)
                                        <div class="text-[10px] text-indigo-600 font-semibold mt-0.5">
                                            ⏰ শিডিউল: {{ $exam->scheduled_start_at->format('d M, Y h:i A') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $exam->exam_mode === 'live_model_test' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($exam->exam_mode === 'timed_mock' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-slate-100 text-slate-700') }}">
                                        {{ str_replace('_', ' ', $exam->exam_mode) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($exam->organization)
                                        <span class="font-bold text-slate-800">{{ $exam->organization->code }}</span>
                                    @else
                                        <span class="text-slate-400">সাধারণ</span>
                                    @endif
                                    @if($exam->examType)
                                        <div class="text-[10px] text-slate-400">{{ $exam->examType->name_bn }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-black text-slate-900">{{ $exam->questions_count }} টি</span>
                                    <a href="{{ route('admin.exams.builder', $exam->id) }}" class="text-[10px] text-indigo-600 hover:underline block font-bold">+ বিল্ড করুন</a>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-800">{{ $exam->duration_minutes > 0 ? $exam->duration_minutes . ' মিনিট' : 'আনলিমিটেড' }}</div>
                                    <div class="text-[10px] text-slate-400">মোট মার্কস: {{ $exam->total_marks }} | নেগেটিভ: -{{ $exam->negative_mark_per_question }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($exam->is_published)
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">প্রকাশিত</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold">ড্রাফট</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right space-x-1.5">
                                    <a href="{{ route('admin.exams.builder', $exam->id) }}" class="px-2.5 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold text-[11px] inline-flex items-center space-x-1">
                                        <span>প্রশ্ন বিল্ডার</span>
                                    </a>
                                    <a href="{{ route('admin.exams.edit', $exam->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px]">
                                        এডিট
                                    </a>
                                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই পরীক্ষাটি মুছে ফেলতে চান?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[11px]">
                                            মুছুন
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">কোনো পরীক্ষা পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $exams->links() }}
            </div>
        </div>
    </div>
@endsection
