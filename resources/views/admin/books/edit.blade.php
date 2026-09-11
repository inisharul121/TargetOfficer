@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                Book Editor
            </div>
            <h1 class="text-2xl font-black text-slate-900">{{ __t('বই সম্পাদনা করুন', 'Edit Digital Book') }}: {{ $book->title_bn }}</h1>
            <p class="text-xs text-slate-500">বইয়ের শিরোনাম, ভূমিকা ও মেটাডাটা আপডেট করুন।</p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.books.builder', $book->id) }}" class="px-3.5 py-2 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-bold text-xs transition">
                📑 টপিক বিল্ডারে যান
            </a>
            <a href="{{ route('admin.books.index') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
                ← তালিকায় ফিরুন
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.books.update', $book->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Title BN --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের নাম (বাংলায়) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title_bn" value="{{ old('title_bn', $book->title_bn) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    @error('title_bn') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Title EN --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের নাম (ইংরেজিতে / Title EN)
                    </label>
                    <input type="text" name="title_en" value="{{ old('title_en', $book->title_en) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    @error('title_en') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Slug --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        ইউআরএল স্লাগ (URL Slug) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="slug" value="{{ old('slug', $book->slug) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    @error('slug') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Subject --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        মূল বিষয় (Subject) <span class="text-rose-500">*</span>
                    </label>
                    <select name="subject_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ old('subject_id', $book->subject_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->name_bn }} ({{ $s->name_en }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Exam Type --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        পরীক্ষার ধরন (Exam Type)
                    </label>
                    <select name="exam_type_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                        <option value="">সকল পরীক্ষা / সাধারণ</option>
                        @foreach($examTypes as $et)
                            <option value="{{ $et->id }}" {{ old('exam_type_id', $book->exam_type_id) == $et->id ? 'selected' : '' }}>
                                {{ $et->name_bn }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Icon Emoji --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের আইকন / ইমোজি
                    </label>
                    <input type="text" name="icon" value="{{ old('icon', $book->icon) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>

                {{-- Edition --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        সংস্করণ (Edition)
                    </label>
                    <input type="text" name="edition" value="{{ old('edition', $book->edition) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>

                {{-- Cover Theme Gradient --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        কভার ব্যাকগ্রাউন্ড গ্রেডিয়েন্ট (Tailwind Classes)
                    </label>
                    <select name="cover_theme" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                        <option value="from-rose-600 via-rose-700 to-rose-950" {{ $book->cover_theme === 'from-rose-600 via-rose-700 to-rose-950' ? 'selected' : '' }}>লাল / মেরুন (Rose: বাংলা বা সাহিত্য)</option>
                        <option value="from-indigo-600 via-blue-700 to-slate-950" {{ $book->cover_theme === 'from-indigo-600 via-blue-700 to-slate-950' ? 'selected' : '' }}>নীল / নীলকান্তমণি (Indigo: ইংরেজি)</option>
                        <option value="from-emerald-700 via-teal-800 to-slate-950" {{ $book->cover_theme === 'from-emerald-700 via-teal-800 to-slate-950' ? 'selected' : '' }}>সবুজ / ফিরোজা (Emerald: বাংলাদেশ বিষয়াবলী)</option>
                        <option value="from-amber-600 via-orange-700 to-slate-950" {{ $book->cover_theme === 'from-amber-600 via-orange-700 to-slate-950' ? 'selected' : '' }}>কমলা / অ্যাম্বার (Amber: আন্তর্জাতিক বিষয়াবলী)</option>
                        <option value="from-cyan-600 via-teal-700 to-slate-950" {{ $book->cover_theme === 'from-cyan-600 via-teal-700 to-slate-950' ? 'selected' : '' }}>সায়ান / টিল (Cyan: গণিত ও মানসিক দক্ষতা)</option>
                        <option value="from-purple-700 via-indigo-800 to-slate-950" {{ $book->cover_theme === 'from-purple-700 via-indigo-800 to-slate-950' ? 'selected' : '' }}>বেগুনি (Purple: সাধারণ বিজ্ঞান ও তথ্যপ্রযুক্তি)</option>
                        <option value="from-slate-800 via-slate-900 to-black" {{ $book->cover_theme === 'from-slate-800 via-slate-900 to-black' ? 'selected' : '' }}>ডার্ক ক্লাসিক (Classic Slate: বিবিধ ও সংবিধান)</option>
                    </select>
                </div>

                {{-- Description BN --}}
                <div class="space-y-1.5 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">
                        বইয়ের সারসংক্ষেপ ও ভূমিকা (বাংলায়)
                    </label>
                    <textarea name="description_bn" rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">{{ old('description_bn', $book->description_bn) }}</textarea>
                </div>

                {{-- Order --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">
                        প্রদর্শনের ক্রম (Sort Order)
                    </label>
                    <input type="number" name="order" value="{{ old('order', $book->order) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>

                {{-- Status Switches --}}
                <div class="space-y-3 pt-6">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $book->is_published) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="text-xs font-bold text-slate-800">প্রকাশিত (Published – শিক্ষার্থীরা দেখতে পাবে)</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_premium" value="1" {{ old('is_premium', $book->is_premium) ? 'checked' : '' }}
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
                    পরিবর্তন সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
