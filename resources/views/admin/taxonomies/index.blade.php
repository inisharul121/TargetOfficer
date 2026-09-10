@extends('layouts.dashboard-layout')

@section('content')
<div class="space-y-6" x-data="{ tab: 'subjects', addSubModal: false, addTopicModal: false, addOrgModal: false, selectedSubjectId: null }">
    
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase mb-1 border border-indigo-200">
                    Taxonomy & Hierarchy
                </div>
                <h1 class="text-2xl font-black text-slate-900">{{ __t('বিষয়, সংস্থা ও ক্যাটাগরি ম্যানেজমেন্ট', 'Subject, Setter Body & Taxonomy Management') }}</h1>
                <p class="text-xs text-slate-500">Organization -> Exam Type -> Year -> Subject -> Topic -> Subtopic</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs transition">
                ← {{ __t('ড্যাশবোর্ড', 'Dashboard') }}
            </a>
        </div>

        <!-- Tab Controls -->
        <div class="flex items-center space-x-2 border-b border-slate-200 pb-3 text-xs font-bold">
            <button type="button" @click="tab = 'subjects'" :class="tab === 'subjects' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-2 rounded-xl transition">
                বিষয় ও টপিক (Subjects & Topics)
            </button>
            <button type="button" @click="tab = 'organizations'" :class="tab === 'organizations' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-2 rounded-xl transition">
                সংস্থা ও প্রশ্নকর্তা (Organizations & Setters)
            </button>
            <button type="button" @click="tab = 'editions'" :class="tab === 'editions' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-2 rounded-xl transition">
                পরীক্ষার ধরন ও সাল (Types & Years)
            </button>
        </div>

        <!-- TAB 1: Subjects & Topics -->
        <div x-show="tab === 'subjects'" class="space-y-6" x-transition>
            <div class="flex items-center justify-between">
                <h2 class="text-base font-black text-slate-900">বিষয় ও অধ্যায়সমূহ</h2>
                <button type="button" @click="addSubModal = true" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">
                    + নতুন বিষয় যোগ করুন
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subjects as $subject)
                    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $subject->color }}"></div>
                                <div>
                                    <h3 class="font-black text-sm text-slate-900">{{ $subject->name_bn }}</h3>
                                    <p class="text-[10px] text-slate-400">{{ $subject->name_en }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold">
                                {{ $subject->questions_count }} টি প্রশ্ন
                            </span>
                        </div>

                        <!-- Topics List -->
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">টপিকসমূহ:</span>
                            @forelse($subject->topics as $topic)
                                <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                    <span class="font-medium text-slate-700">{{ $topic->name_bn }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $topic->name_en }}</span>
                                </div>
                            @empty
                                <p class="text-[11px] text-slate-400 italic">কোনো টপিক যোগ করা হয়নি।</p>
                            @endforelse
                        </div>

                        <div class="pt-2 border-t border-slate-100">
                            <button type="button" @click="selectedSubjectId = {{ $subject->id }}; addTopicModal = true" class="w-full py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold transition text-center">
                                + টপিক যোগ করুন
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TAB 2: Organizations & Question Setters -->
        <div x-show="tab === 'organizations'" class="space-y-6" x-transition>
            <div class="flex items-center justify-between">
                <h2 class="text-base font-black text-slate-900">সংস্থা ও প্রশ্নকর্তা বডি (Setter Bodies)</h2>
                <button type="button" @click="addOrgModal = true" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">
                    + নতুন সংস্থা যোগ করুন
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($organizations as $org)
                    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 font-black text-xs border border-indigo-200">
                                {{ $org->code }}
                            </span>
                            @if($org->is_question_setter)
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold">
                                    ✓ Question Setter
                                </span>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-black text-sm text-slate-900">{{ $org->name_bn ?? $org->name_en }}</h3>
                            <p class="text-xs text-slate-500 font-medium">{{ $org->name_en }}</p>
                        </div>

                        @if($org->description)
                            <p class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100 leading-relaxed">
                                {{ $org->description }}
                            </p>
                        @endif

                        <div class="text-[11px] text-slate-400 pt-2 border-t border-slate-100">
                            মোট পরীক্ষা: <strong>{{ $org->exams_count }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TAB 3: Exam Types & Years -->
        <div x-show="tab === 'editions'" class="space-y-6" x-transition>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Exam Types -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-black text-base text-slate-900">পরীক্ষার ক্যাটাগরি (Exam Types)</h3>
                    
                    <div class="space-y-2">
                        @foreach($examTypes as $et)
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $et->name_bn ?? $et->name_en }}</h4>
                                    <p class="text-[10px] text-slate-400">{{ $et->name_en }}</p>
                                </div>
                                @if($et->organization)
                                    <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-600">{{ $et->organization->code }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('admin.taxonomies.exam-type.store') }}" method="POST" class="pt-4 border-t border-slate-100 space-y-3">
                        @csrf
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="name_bn" placeholder="ক্যাটাগরি নাম (বাংলা)" required class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                            <input type="text" name="name_en" placeholder="Name (English)" required class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        </div>
                        <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition">+ ক্যাটাগরি তৈরি</button>
                    </form>
                </div>

                <!-- Exam Years -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-black text-base text-slate-900">সাল ও সংস্করণ (Exam Years / Editions)</h3>

                    <div class="space-y-2">
                        @foreach($examYears as $ey)
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-800">{{ $ey->name_bn ?? $ey->name_en }}</span>
                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold text-[10px]">{{ $ey->year }}</span>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('admin.taxonomies.exam-year.store') }}" method="POST" class="pt-4 border-t border-slate-100 space-y-3">
                        @csrf
                        <div class="grid grid-cols-3 gap-2">
                            <input type="text" name="year" placeholder="সাল/সংস্করণ (47th)" required class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                            <input type="text" name="name_bn" placeholder="নাম (বাংলা)" required class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                            <input type="text" name="name_en" placeholder="Name (English)" required class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                        </div>
                        <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs">+ সাল/সংস্করণ যোগ</button>
                    </form>
                </div>
            </div>
        </div>

    <!-- Add Subject Modal -->
    <div x-show="addSubModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/60 backdrop-blur-xs" x-transition>
        <div @click.outside="addSubModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-black text-base text-slate-900">নতুন বিষয় তৈরি করুন</h3>
            <form action="{{ route('admin.taxonomies.subject.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">বিষয়ের নাম (বাংলায়) *</label>
                    <input type="text" name="name_bn" required placeholder="যেমন: বাংলাদেশ বিষয়াবলী" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">বিষয়ের নাম (ইংরেজিতে) *</label>
                    <input type="text" name="name_en" required placeholder="e.g. Bangladesh Affairs" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">থিম কালার (Hex Code)</label>
                    <input type="color" name="color" value="#4F46E5" class="w-full h-10 rounded-xl border border-slate-200 cursor-pointer">
                </div>
                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="addSubModal = false" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Topic Modal -->
    <div x-show="addTopicModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/60 backdrop-blur-xs" x-transition>
        <div @click.outside="addTopicModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-black text-base text-slate-900">নতুন টপিক / অধ্যায় যোগ করুন</h3>
            <form action="{{ route('admin.taxonomies.topic.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="subject_id" :value="selectedSubjectId">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">টপিকের নাম (বাংলায়) *</label>
                    <input type="text" name="name_bn" required placeholder="যেমন: প্রাচীন ও মধ্যযুগ" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">টপিকের নাম (ইংরেজিতে) *</label>
                    <input type="text" name="name_en" required placeholder="e.g. Ancient & Medieval Era" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                </div>
                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="addTopicModal = false" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs">টপিক যোগ করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Organization Modal -->
    <div x-show="addOrgModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-700/60 backdrop-blur-xs" x-transition>
        <div @click.outside="addOrgModal = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <h3 class="font-black text-base text-slate-900">নতুন সংস্থা / প্রশ্নকর্তা বডি যোগ করুন</h3>
            <form action="{{ route('admin.taxonomies.organization.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">সংস্থার নাম (বাংলায়)</label>
                    <input type="text" name="name_bn" placeholder="যেমন: মিলিটারি ইনস্টিটিউট অব সায়েন্স অ্যান্ড টেকনোলজি" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">সংস্থার নাম (ইংরেজিতে) *</label>
                    <input type="text" name="name_en" required placeholder="e.g. Military Institute of Science and Technology" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">সংক্ষিপ্ত কোড (Code) *</label>
                        <input type="text" name="code" required placeholder="e.g. MIST" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white font-bold">
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="flex items-center space-x-2 text-xs font-bold text-slate-700">
                            <input type="checkbox" name="is_question_setter" value="1" checked class="rounded text-indigo-600">
                            <span>Question Setter?</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">বিবরণ / প্রশ্ন প্যাটার্ন নোট</label>
                    <textarea name="description" rows="2" placeholder="সংস্থার প্রশ্ন প্রণয়ন ধারা ও বৈশিষ্ট্য..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"></textarea>
                </div>
                <div class="flex items-center space-x-2 pt-2">
                    <button type="button" @click="addOrgModal = false" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600">বাতিল</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
