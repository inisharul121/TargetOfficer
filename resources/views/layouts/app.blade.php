<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? __t('TargetOfficer - Precision Preparation for Public Service', 'TargetOfficer - Precision Preparation for Public Service') }}</title>
    <meta name="description" content="Bangladesh's premier online preparation platform for BCS, Bank, and Government Job exams with question setter analysis.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="flex flex-col min-h-full font-sans antialiased text-slate-800 bg-slate-50 selection:bg-indigo-600 selection:text-white">
    
    @include('layouts.navigation')

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full" x-data="{ show: true }" x-show="show" x-transition>
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 shadow-xs flex items-center justify-between text-emerald-900">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold text-xs">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full" x-data="{ show: true }" x-show="show" x-transition>
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 shadow-sm flex items-center justify-between text-rose-800">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="text-xs font-bold">
                        {{ session('error') ?? $errors->first() }}
                    </div>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-slate-600 py-12 border-t border-slate-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2">
                        <span class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black text-lg shadow-xs">T</span>
                        <span class="text-xl font-extrabold text-slate-900 tracking-tight">Target<span class="text-indigo-600">Officer</span></span>
                    </div>
                    <p class="mt-3 text-xs text-slate-500 max-w-sm leading-relaxed">
                        <strong class="text-slate-800">Aim High. Aim Officer.</strong> {{ __t('বিসিএস, বাংলাদেশ ব্যাংক ও সরকারি চাকরির নির্ভুল প্রস্তুতি এবং প্রশ্নকর্তা প্যাটার্ন বিশ্লেষণের নির্ভরযোগ্য প্ল্যাটফর্ম।', 'Premier online preparation engine for BCS, Bangladesh Bank & public service candidate exams.') }}
                    </p>
                    <div class="mt-4 flex items-center space-x-3 text-[11px] text-slate-400">
                        <span>© {{ date('Y') }} TargetOfficer Engine. All rights reserved.</span>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">{{ __t('দ্রুত লিংক', 'Quick Links') }}</h3>
                    <ul class="mt-4 space-y-2 text-xs font-medium">
                        <li><a href="{{ route('exams.index') }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('সকল মডেল টেস্ট', 'All Model Tests') }}</a></li>
                        <li><a href="{{ route('practice.index') }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('বিষয়ভিত্তিক অনুশীলন', 'Topic Practice') }}</a></li>
                        <li><a href="{{ route('question-bank.index') }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('প্রশ্ন ব্যাংক ও প্যাটার্ন', 'Question Bank & Patterns') }}</a></li>
                        <li><a href="{{ route('leaderboard.index') }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('লিডারবোর্ড', 'Leaderboard') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">{{ __t('প্রশ্নকর্তা প্যাটার্ন', 'Setter Patterns') }}</h3>
                    <ul class="mt-4 space-y-2 text-xs font-medium">
                        <li><a href="{{ route('question-bank.index', ['setter' => 1]) }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('বিপিএসসি (BPSC)', 'BPSC Pattern') }}</a></li>
                        <li><a href="{{ route('question-bank.index', ['setter' => 2]) }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('বুয়েট প্যাটার্ন (BUET)', 'BUET Pattern') }}</a></li>
                        <li><a href="{{ route('question-bank.index', ['setter' => 3]) }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('আইবিএ প্যাটার্ন (IBA)', 'IBA Pattern') }}</a></li>
                        <li><a href="{{ route('question-bank.index', ['setter' => 5]) }}" class="text-slate-600 hover:text-indigo-600 transition">{{ __t('কলা অনুষদ (Arts Faculty)', 'Arts Faculty Pattern') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
