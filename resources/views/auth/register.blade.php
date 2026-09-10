@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex w-12 h-12 rounded-2xl bg-indigo-600 items-center justify-center text-white font-black text-2xl shadow-xs mb-4">T</div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __t('নতুন অ্যাকাউন্ট তৈরি করুন', 'Create New Account') }}</h2>
        <p class="mt-2 text-sm text-slate-500">
            {{ __t('পূর্বেই অ্যাকাউন্ট আছে?', 'Already have an account?') }} 
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700">{{ __t('লগইন করুন', 'Login Now') }}</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 sm:px-10 shadow-xs rounded-3xl border border-slate-200">
            <form class="space-y-4" action="{{ route('register.post') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __t('আপনার পুরো নাম', 'Full Name') }}</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" placeholder="{{ __t('যেমন: তানভীর আহমেদ', 'e.g. Tanvir Ahmed') }}" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition text-sm">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __t('ইমেইল এড্রেস', 'Email Address') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="name@example.com" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition text-sm">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __t('মোবাইল নম্বর (ঐচ্ছিক)', 'Mobile Number (Optional)') }}</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="017XXXXXXXX" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition text-sm">
                </div>


                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __t('পাসওয়ার্ড', 'Password') }}</label>
                    <input id="password" name="password" type="password" required placeholder="{{ __t('কমপক্ষে ৬ অক্ষর', 'At least 6 characters') }}" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition text-sm">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __t('পাসওয়ার্ড নিশ্চিত করুন', 'Confirm Password') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="{{ __t('পুনরায় পাসওয়ার্ড লিখুন', 'Re-enter password') }}" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none transition text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-xs transition">
                        {{ __t('রেজিস্ট্রেশন সম্পন্ন করুন', 'Complete Registration') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
