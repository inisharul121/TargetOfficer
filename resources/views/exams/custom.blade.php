@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-[80vh]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xl space-y-8">
            <div class="text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto text-2xl font-bold">⚡</div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">কাস্টম টেস্ট জেনারেটর</h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto">আপনার পছন্দমতো বিষয়, টপিক, প্রশ্নকর্তা সংস্থা এবং কাঠিন্যের মাত্রা নির্বাচন করে তাৎক্ষণিক পরীক্ষা তৈরি করুন।</p>
            </div>

            <form action="{{ route('exams.custom.store') }}" method="POST" class="space-y-6" x-data="{ selectedSubject: '', topics: [] }">
                @csrf

                <!-- Subject Selection -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">বিষয় নির্বাচন করুন</label>
                    <select name="subject_id" x-model="selectedSubject" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none bg-white">
                        <option value="">সকল বিষয় (All Subjects)</option>
                        @foreach($subjects as $subj)
                            <option value="{{ $subj->id }}">{{ $subj->name_bn }} ({{ $subj->name_en }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Setter Organization Selection -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">প্রশ্নকর্তা সংস্থা / প্যাটার্ন</label>
                    <select name="setter_organization_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none bg-white">
                        <option value="">সকল প্যাটার্ন (BUET, IBA, BPSC ইত্যাদি)</option>
                        @foreach($setters as $setter)
                            <option value="{{ $setter->id }}">{{ $setter->name_bn }} ({{ $setter->code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Difficulty Level -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">কাঠিন্যের মাত্রা (Difficulty)</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="p-3.5 rounded-xl border border-slate-200 hover:border-indigo-400 cursor-pointer flex items-center justify-center space-x-2 text-xs font-bold text-slate-700 bg-slate-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-600 has-[:checked]:text-indigo-700">
                            <input type="radio" name="difficulty" value="easy" class="text-indigo-600 focus:ring-indigo-500">
                            <span>সহজ (Easy)</span>
                        </label>
                        <label class="p-3.5 rounded-xl border border-slate-200 hover:border-indigo-400 cursor-pointer flex items-center justify-center space-x-2 text-xs font-bold text-slate-700 bg-slate-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-600 has-[:checked]:text-indigo-700">
                            <input type="radio" name="difficulty" value="medium" checked class="text-indigo-600 focus:ring-indigo-500">
                            <span>মাঝারি (Medium)</span>
                        </label>
                        <label class="p-3.5 rounded-xl border border-slate-200 hover:border-indigo-400 cursor-pointer flex items-center justify-center space-x-2 text-xs font-bold text-slate-700 bg-slate-50 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-600 has-[:checked]:text-indigo-700">
                            <input type="radio" name="difficulty" value="hard" class="text-indigo-600 focus:ring-indigo-500">
                            <span>কঠিন (Hard)</span>
                        </label>
                    </div>
                </div>

                <!-- Question Count -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">প্রশ্নের সংখ্যা</label>
                    <select name="question_count" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none bg-white font-semibold">
                        <option value="5">৫ টি প্রশ্ন (৫ মিনিট কুইজ)</option>
                        <option value="10" selected>১০ টি প্রশ্ন (১০ মিনিট টেস্ট)</option>
                        <option value="20">২০ টি প্রশ্ন (২০ মিনিট টেস্ট)</option>
                        <option value="30">৩০ টি প্রশ্ন (৩০ মিনিট টেস্ট)</option>
                    </select>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-extrabold text-sm shadow-lg shadow-indigo-200 transition">
                        ⚡ ইনস্ট্যান্ট কাস্টম টেস্ট জেনারেট ও শুরু করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
