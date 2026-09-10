@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex w-12 h-12 rounded-2xl bg-indigo-600 items-center justify-center text-white font-black text-2xl shadow-xs mb-4">T</div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __t('অ্যাকাউন্টে লগইন করুন', 'Login to Account') }}</h2>
        <p class="mt-2 text-sm text-slate-500">
            {{ __t('নতুন ইউজার?', 'New User?') }} 
            <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-700">{{ __t('ফ্রি রেজিস্ট্রেশন করুন', 'Register for Free') }}</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 sm:px-10 shadow-xs rounded-3xl border border-slate-200">
            <form class="space-y-5" action="{{ route('login.post') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __t('ইমেইল এড্রেস', 'Email Address') }}</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __t('পাসওয়ার্ড', 'Password') }}</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                        <label for="remember" class="ml-2 block text-xs font-medium text-slate-600">{{ __t('আমাকে মনে রাখুন', 'Remember Me') }}</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-xs transition">
                        {{ __t('লগইন করুন', 'Login') }}
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100">
                <p class="text-xs font-bold text-slate-400 text-center uppercase tracking-wider mb-3">{{ __t('দ্রুত ডেমো পরীক্ষা করুন', 'Quick Demo Access') }}</p>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('demo.login', 'student') }}" class="py-2.5 px-3 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs text-center border border-slate-200 transition flex items-center justify-center space-x-1">
                        <span>👨‍🎓 {{ __t('ক্যান্ডিডেট ডেমো', 'Candidate Demo') }}</span>
                    </a>
                    <a href="{{ route('demo.login', 'admin') }}" class="py-2.5 px-3 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-800 font-bold text-xs text-center border border-slate-200 transition flex items-center justify-center space-x-1">
                        <span>🛡️ {{ __t('এডমিন ডেমো', 'Admin Demo') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
