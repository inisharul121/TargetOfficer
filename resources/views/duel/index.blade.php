@extends('layouts.student-layout')

@section('title', __t('১ বনাম ১ কুইজ ব্যাটেল – TargetOfficer', '1v1 Quiz Duel – TargetOfficer'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-600 via-amber-600 to-rose-700 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-black uppercase tracking-wider">
                    <span>⚔️</span>
                    <span>{{ __t('১ বনাম ১ কুইজ ব্যাটেল', '1v1 Live Quiz Battle') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    {{ __t('বন্ধুকে চ্যালেঞ্জ করো বিসিএস কুইজ ব্যাটেলে!', 'Challenge Your Friends to a BCS 10-Question Duel!') }}
                </h1>
                <p class="text-sm text-orange-100 leading-relaxed">
                    {{ __t('যেকোনো বিষয় বেছে নিয়ে ১০টি প্রশ্নের দ্রুত চ্যালেঞ্জ তৈরি করুন। আপনার বন্ধুকে লিঙ্ক বা কোড পাঠিয়ে দিন। একই প্রশ্নে কে বেশি দ্রুত ও নির্ভুল উত্তর দিতে পারে— বিজয়ী পাবেন ২৫টি রিওয়ার্ড কয়েন 🪙!', 'Create a rapid 10-question duel on any subject. Share the battle code with friends on WhatsApp or Messenger. Highest score & fastest time wins 25 Coins!') }}
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20 text-center min-w-[180px] shrink-0">
                <span class="text-[10px] font-black uppercase tracking-wider text-orange-200 block mb-1">বিজয়ী বোনাস</span>
                <div class="text-3xl font-black text-amber-300">🪙 ২৫ কয়েন</div>
                <span class="text-[11px] text-orange-100 mt-1 block font-semibold">প্রতিটি সফল বিজয়ে</span>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 w-60 h-60 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
    </div>

    {{-- Create or Join Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Card 1: Create a Challenge --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-orange-100 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 flex items-center justify-center font-black text-lg">
                    ⚔️
                </div>
                <div>
                    <h2 class="text-base font-black text-slate-900 dark:text-white">নতুন কুইজ ব্যাটেল তৈরি করুন</h2>
                    <p class="text-xs text-slate-400">১০টি দ্রুত প্রশ্নের ব্যাটেল তৈরি করে বন্ধুদের লিংক শেয়ার করুন</p>
                </div>
            </div>

            <form action="{{ route('battle.store') }}" method="POST" class="space-y-4 pt-2">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-2">বিষয় নির্বাচন করুন</label>
                    <select name="subject_id" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-semibold focus:ring-2 focus:ring-orange-500">
                        <option value="">সকল বিষয় থেকে মিশ্র ১০ প্রশ্ন (সুপার চ্যালেঞ্জ)</option>
                        @foreach($subjects as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name_bn }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-orange-600 hover:bg-orange-700 text-white font-black text-xs shadow-md shadow-orange-600/20 transition flex items-center justify-center space-x-2">
                    <span>🔥</span>
                    <span>কুইজ ব্যাটেল শুরু করুন</span>
                </button>
            </form>
        </div>

        {{-- Card 2: Join by Code --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black text-lg">
                    🎯
                </div>
                <div>
                    <h2 class="text-base font-black text-slate-900 dark:text-white">কোড দিয়ে ব্যাটেলে অংশ নিন</h2>
                    <p class="text-xs text-slate-400">বন্ধুর পাঠানো ৬ ডিজিটের ব্যাটেল কোড লিখে সরাসরি যোগ দিন</p>
                </div>
            </div>

            <form action="{{ route('battle.join') }}" method="POST" class="space-y-4 pt-2">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-2">ব্যাটেল কোড (Duel Code)</label>
                    <input type="text"
                           name="duel_code"
                           required
                           placeholder="e.g. DUEL-9X4B"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 font-mono uppercase text-center tracking-widest text-sm rounded-2xl border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-indigo-500">
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md shadow-indigo-600/20 transition flex items-center justify-center space-x-2">
                    <span>⚡</span>
                    <span>ব্যাটেলটিতে যোগ দিন</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Open Challenges looking for players --}}
    @if($openDuels->isNotEmpty())
        <div class="space-y-3">
            <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>খোলা চ্যালেঞ্জসমূহ (Open Duels)</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($openDuels as $od)
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <span class="text-[10px] font-mono font-bold text-orange-600 dark:text-orange-400">{{ $od->duel_code }}</span>
                            <h3 class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                {{ $od->creator->name }} এর চ্যালেঞ্জ
                            </h3>
                            <span class="text-[11px] text-slate-400">
                                {{ $od->subject ? $od->subject->name_bn : 'মিশ্র ১০ প্রশ্ন' }}
                            </span>
                        </div>
                        <a href="{{ route('battle.arena', $od->duel_code) }}"
                           class="px-3.5 py-2 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs shrink-0 transition">
                            অংশ নিন
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- My Recent Battles --}}
    <div class="space-y-4">
        <h2 class="text-base font-black text-slate-900 dark:text-white">আপনার সাম্প্রতিক ব্যাটেল হিস্ট্রি</h2>

        @if($myDuels->isEmpty())
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 text-center border border-slate-200 dark:border-slate-800 shadow-xs">
                <p class="text-slate-400 text-xs font-semibold">আপনি এখনও কোনো কুইজ ব্যাটেলে অংশগ্রহণ করেননি। এখনই নতুন চ্যালেঞ্জ তৈরি করুন!</p>
            </div>
        @else
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200 dark:border-slate-800">
                            <tr>
                                <th class="py-3.5 px-5">কোড</th>
                                <th class="py-3.5 px-4">বিষয়</th>
                                <th class="py-3.5 px-4">প্রতিদ্বন্দ্বী</th>
                                <th class="py-3.5 px-4 text-center">ফলাফল</th>
                                <th class="py-3.5 px-5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-200 font-semibold">
                            @foreach($myDuels as $duel)
                                @php
                                    $isCreator = $duel->creator_id === auth()->id();
                                    $myScore = $isCreator ? $duel->creator_score : $duel->opponent_score;
                                    $oppScore = $isCreator ? $duel->opponent_score : $duel->creator_score;
                                    $opponentName = $isCreator ? ($duel->opponent->name ?? 'অপেক্ষমাণ...') : $duel->creator->name;
                                    $isWinner = $duel->winner_id === auth()->id();
                                @endphp
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-3.5 px-5 font-mono font-bold text-orange-600 dark:text-orange-400">
                                        {{ $duel->duel_code }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300">
                                        {{ $duel->subject ? $duel->subject->name_bn : 'মিশ্র ১০ প্রশ্ন' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        {{ $opponentName }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($duel->status === 'completed')
                                            @if($isWinner)
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400">
                                                    🏆 জয়ী ({{ $myScore }} vs {{ $oppScore }})
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400">
                                                    পরাজিত ({{ $myScore }} vs {{ $oppScore }})
                                                </span>
                                            @endif
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400">
                                                চলমান
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        <a href="{{ route('battle.result', $duel->duel_code) }}"
                                           class="px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold transition">
                                            বিস্তারিত
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
