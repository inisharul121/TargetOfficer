@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                Book Creator
            </div>
            <h1 class="text-2xl font-black text-slate-900">{{ __t('নতুন ডিজিটাল বই তৈরি করুন', 'Create New Digital Book') }}</h1>
            <p class="text-xs text-slate-500">নতুন বই তৈরির পর আপনি এতে অধ্যায় ও লিখিত টপিকসমূহ যুক্ত করতে পারবেন।</p>
        </div>

        <a href="{{ route('admin.books.index') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
            ← তালিকায় ফিরে যান
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.books.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Title BN --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের নাম (বাংলায়) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title_bn" value="{{ old('title_bn') }}" required
                           placeholder="e.g. বিসিএস বাংলা ভাষা ও সাহিত্য সমগ্র"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    @error('title_bn') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Title EN --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের নাম (ইংরেজিতে / Title EN)
                    </label>
                    <input type="text" name="title_en" value="{{ old('title_en') }}"
                           placeholder="e.g. BCS Bengali Literature Complete Volume"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    @error('title_en') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Slug --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        ইউআরএল স্লাগ (খালি রাখলে স্বয়ংক্রিয়ভাবে তৈরি হবে)
                    </label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                           placeholder="e.g. book-bcs-bangla"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    @error('slug') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Subject --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        মূল বিষয় (Subject) <span class="text-rose-500">*</span>
                    </label>
                    <select name="subject_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                        <option value="">বিষয় নির্বাচন করুন</option>
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name_bn }} ({{ $s->name_en }})
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Exam Type --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        পরীক্ষার ধরন (Exam Type)
                    </label>
                    <select name="exam_type_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                        <option value="">সকল পরীক্ষা / সাধারণ</option>
                        @foreach($examTypes as $et)
                            <option value="{{ $et->id }}" {{ old('exam_type_id') == $et->id ? 'selected' : '' }}>
                                {{ $et->name_bn }}
                            </option>
                        @endforeach
                    </select>
                    @error('exam_type_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Icon Emoji --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের আইকন / ইমোজি
                    </label>
                    <input type="text" name="icon" value="{{ old('icon', '📖') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    <span class="text-[10px] text-slate-400">উদাহরণ: 📕, 📘, 📗, 📙, 📐, 🔬, 🏛️</span>
                </div>

                {{-- Edition --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        সংস্করণ (Edition)
                    </label>
                    <input type="text" name="edition" value="{{ old('edition', '১ম সংস্করণ ২০২৬') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>

                {{-- Cover Theme Gradient --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        কভার ব্যাকগ্রাউন্ড গ্রেডিয়েন্ট (Tailwind Classes)
                    </label>
                    <select name="cover_theme" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                        <option value="from-rose-600 via-rose-700 to-rose-950">লাল / মেরুন (Rose: বাংলা বা সাহিত্য)</option>
                        <option value="from-indigo-600 via-blue-700 to-slate-950">নীল / নীলকান্তমণি (Indigo: ইংরেজি)</option>
                        <option value="from-emerald-700 via-teal-800 to-slate-950">সবুজ / ফিরোজা (Emerald: বাংলাদেশ বিষয়াবলী)</option>
                        <option value="from-amber-600 via-orange-700 to-slate-950">কমলা / অ্যাম্বার (Amber: আন্তর্জাতিক বিষয়াবলী)</option>
                        <option value="from-cyan-600 via-teal-700 to-slate-950">সায়ান / টিল (Cyan: গণিত ও মানসিক দক্ষতা)</option>
                        <option value="from-purple-700 via-indigo-800 to-slate-950">বেগুনি (Purple: সাধারণ বিজ্ঞান ও তথ্যপ্রযুক্তি)</option>
                        <option value="from-slate-800 via-slate-900 to-black">ডার্ক ক্লাসিক (Classic Slate: বিবিধ ও সংবিধান)</option>
                    </select>
                </div>

                {{-- Description BN --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের সারসংক্ষেপ ও ভূমিকা (বাংলায়)
                    </label>
                    <textarea name="description_bn" rows="4"
                              placeholder="বইটিতে কোন কোন পাঠ্যক্রম ও লিখিত অধ্যায় কভার করা হয়েছে তা সংক্ষেপে লিখুন..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">{{ old('description_bn') }}</textarea>
                </div>

                {{-- Order --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        প্রদর্শনের ক্রম (Sort Order)
                    </label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>

                {{-- Status Switches --}}
                <div class="space-y-3 pt-6">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="text-xs font-bold text-slate-800">প্রকাশিত (Published – শিক্ষার্থীরা দেখতে পাবে)</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="text-xs font-bold text-amber-700">প্রিমিয়াম সাবস্ক্রিপশন সংরক্ষিত (Premium Book)</span>
                    </label>
                </div>

            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.books.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-bold text-slate-600 transition">
                    বাতিল
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md transition">
                    বই সংরক্ষণ ও টপিক সাজানো শুরু করুন →
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
