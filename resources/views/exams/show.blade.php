@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-[80vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-xs font-semibold text-slate-400 mb-6 space-x-2">
            <a href="{{ route('exams.index') }}" class="hover:text-indigo-600">সকল পরীক্ষা</a>
            <span>/</span>
            <span class="text-slate-700 truncate">{{ $exam->title_bn }}</span>
        </nav>

        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xl space-y-8">
            <!-- Header -->
            <div class="border-b border-slate-100 pb-6">
                <div class="flex items-center space-x-2 mb-3">
                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $exam->exam_mode === 'timed_mock' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $exam->exam_mode === 'timed_mock' ? '⏱️ Timed Mock Exam' : ($exam->exam_mode === 'practice' ? '💡 Practice Mode' : '⚡ Micro-Quiz') }}
                    </span>
                    @if($exam->organization)
                        <span class="text-xs font-bold bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full">{{ $exam->organization->name_bn }}</span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">{{ $exam->title_bn }}</h1>
                @if($exam->title_en)
                    <p class="text-sm text-slate-400 font-medium mt-1">{{ $exam->title_en }}</p>
                @endif
                <p class="text-sm text-slate-600 mt-4 leading-relaxed">{{ $exam->description_bn }}</p>
            </div>

            <!-- Exam Stats Matrix -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                    <span class="text-xs text-slate-400 font-semibold">মোট প্রশ্ন</span>
                    <div class="text-2xl font-black text-slate-900 mt-1">{{ $exam->total_questions }}</div>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                    <span class="text-xs text-slate-400 font-semibold">নির্ধারিত সময়</span>
                    <div class="text-2xl font-black text-indigo-600 mt-1">{{ $exam->duration_minutes > 0 ? $exam->duration_minutes . ' মি.' : 'আনলিমিটেড' }}</div>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                    <span class="text-xs text-slate-400 font-semibold">প্রতি সঠিক উত্তর</span>
                    <div class="text-2xl font-black text-emerald-600 mt-1">+১.০০</div>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-center">
                    <span class="text-xs text-slate-400 font-semibold">নেগেটিভ মার্কিং</span>
                    <div class="text-2xl font-black text-rose-600 mt-1">-{{ $exam->negative_mark_per_question }}</div>
                </div>
            </div>

            <!-- Official Rules & Anti-Cheat Checklist -->
            <div class="bg-indigo-50/50 rounded-2xl p-5 border border-indigo-100 text-sm space-y-3">
                <h3 class="font-bold text-indigo-950 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>পরীক্ষার গুরুত্বপূর্ণ নিয়মাবলী ও অ্যান্টি-চিট নির্দেশনা</span>
                </h3>
                <ul class="text-xs text-slate-600 space-y-2 list-disc list-inside">
                    <li>পরীক্ষা চলাকালীন যেকোনো সময় প্রশ্নের উত্তর পরিবর্তন বা বাতিল করা যাবে।</li>
                    <li>প্রতিটি ভুল উত্তরের জন্য <strong>{{ $exam->negative_mark_per_question }}</strong> নম্বর কাটা যাবে।</li>
                    <li>পরীক্ষা শুরু করার পর ব্রাউজার ট্যাব পরিবর্তন (Tab Switch) ট্র্যাক করা হবে এবং অ্যান্টি-চিট রিপোর্টে অন্তর্ভুক্ত থাকবে।</li>
                    <li>ইন্টারনেট সংযোগ সাময়িক বিচ্ছিন্ন হলেও আপনার উত্তরগুলো স্বয়ংক্রিয়ভাবে লোকাল মেমোরিতে সংরক্ষিত থাকবে।</li>
                </ul>
            </div>

            <!-- Start Action Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100">
                <a href="{{ route('exams.index') }}" class="w-full sm:w-auto px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 font-bold text-xs text-slate-600 text-center transition">
                    ← পেছনে যান
                </a>

                @auth
                    <a href="{{ route('exams.room', $exam->slug) }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm shadow-md shadow-indigo-200 transition flex items-center justify-center space-x-2">
                        <span>পরীক্ষা শুরু করুন (Start Exam)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm shadow-md shadow-indigo-200 transition text-center">
                        পরীক্ষা দিতে লগইন করুন
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
