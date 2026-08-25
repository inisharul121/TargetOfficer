@extends('layouts.app')

@section('content')
<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black text-slate-900">নতুন প্রশ্ন সংযোজন (Question Builder)</h1>
            <a href="{{ route('admin.questions.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">← তালিকায় ফিরুন</a>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm" 
             x-data="{ 
                stem: '', 
                previewMath() {
                    const p = document.getElementById('stem-preview');
                    if (p && window.renderMathInElement) {
                        p.innerHTML = this.stem;
                        window.renderMathInElement(p);
                    }
                }
             }">
            
            <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Subject & Topic -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">বিষয় (Subject)</label>
                        <select name="subject_id" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            @foreach($subjects as $sb)
                                <option value="{{ $sb->id }}">{{ $sb->name_bn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">প্রশ্নকর্তা সংস্থা</label>
                        <select name="setter_organization_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            <option value="">সাধারণ / বিপিএসসি</option>
                            @foreach($setters as $st)
                                <option value="{{ $st->id }}">{{ $st->name_bn }} ({{ $st->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কাঠিন্য (Difficulty)</label>
                        <select name="difficulty" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs bg-white">
                            <option value="easy">সহজ (Easy)</option>
                            <option value="medium" selected>মাঝারি (Medium)</option>
                            <option value="hard">কঠিন (Hard)</option>
                        </select>
                    </div>
                </div>

                <!-- Stem (Question body) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">প্রশ্নের মূল বক্তব্য (Stem - বাংলায়) <span class="text-indigo-600">(LaTeX $...$ সমর্থিত)</span></label>
                    <textarea name="stem_bn" x-model="stem" @input="previewMath()" rows="3" required placeholder="প্রশ্ন লিখুন, যেমন: যদি $x + \frac{1}{x} = 3$ হয়..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm outline-none focus:border-indigo-500 font-medium"></textarea>
                    
                    <!-- Live KaTeX Preview -->
                    <div class="mt-2 p-3 bg-indigo-50/50 rounded-xl border border-indigo-100 text-xs">
                        <span class="font-bold text-indigo-900 block mb-1">লাইভ ফর্মুলা প্রিভিউ:</span>
                        <div id="stem-preview" class="math-tex text-slate-800 font-semibold min-h-[20px]">
                            [এখানে প্রিভিউ দেখা যাবে]
                        </div>
                    </div>
                </div>

                <!-- Marks config -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সঠিক উত্তরের মার্কস</label>
                        <input type="number" step="0.25" name="default_marks" value="1.00" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">নেগেটিভ মার্কস কর্তন</label>
                        <input type="number" step="0.05" name="negative_marks" value="0.50" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                    </div>
                </div>

                <!-- 4 Options -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase">৪টি অপশন ও সঠিক উত্তর সিলেক্ট করুন</label>
                    
                    @foreach(['A', 'B', 'C', 'D'] as $i => $letter)
                        <div class="flex items-center space-x-3 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <input type="radio" name="correct_option" value="{{ $i }}" {{ $i === 0 ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="font-black text-xs text-slate-700 w-6">{{ $letter }})</span>
                            <input type="text" name="options[{{ $i }}][text_bn]" required placeholder="অপশন {{ $letter }} এর টেক্সট..." class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        </div>
                    @endforeach
                </div>

                <!-- Explanation & Reference -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">বিস্তারিত সমাধান ও ব্যাখ্যা</label>
                        <textarea name="explanation_bn" rows="3" placeholder="সমাধানের ধাপসমূহ ও ব্যাখ্যা..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">রেফারেন্স বই বা সূত্র</label>
                        <input type="text" name="reference_source" placeholder="যেমন: নবম-দশম শ্রেণির গণিত বই" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs mb-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">ট্যাগসমূহ (কমা দিয়ে আলাদা করুন)</label>
                        <input type="text" name="tags" placeholder="46th BCS, BUET Pattern, বীজগণিত" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-sm shadow-md transition">
                        প্রশ্ন সংরক্ষণ ও প্রকাশ করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
