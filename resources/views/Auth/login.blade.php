@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 relative overflow-hidden py-10 px-6">
    <div class="w-full max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-10">

        {{-- Logo/Illustration - atas di mobile, kiri di desktop --}}
        <div class="flex justify-center items-center w-full lg:w-1/2 order-1 lg:order-1">
            <div class="relative flex items-center justify-center">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full w-64 h-64 sm:w-80 sm:h-80 lg:w-[28rem] lg:h-[28rem] -z-10 opacity-50 mx-auto my-auto"></div>
                <img
                    src="/images/logoLog.png"
                    alt="Library Illustration"
                    class="relative z-10 w-48 h-auto sm:w-64 md:w-80 lg:w-[26rem] xl:w-[30rem] object-contain"
                    onerror="this.style.display='none';"
                >
            </div>
        </div>

        {{-- Form Login --}}
        <div class="w-full sm:w-[480px] lg:w-5/12 bg-white rounded-3xl shadow-2xl p-10 sm:p-12 order-2 lg:order-2">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">
                Sign in
            </h2>
            <p class="text-base text-gray-500 mb-10">
                Login now to unlock access to borrow books and learning resources anytime.
            </p>

            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <div>
                    <input type="email"
                           name="email"
                           placeholder="Email address"
                           required
                           class="w-full px-6 py-4 bg-gray-50 border-0 rounded-xl text-gray-700 text-base placeholder-gray-400 focus:ring-2 focus:ring-cyan-400 focus:bg-white transition">
                </div>

                <div>
                    <input type="password"
                           name="password"
                           placeholder="Password"
                           required
                           class="w-full px-6 py-4 bg-gray-50 border-0 rounded-xl text-gray-700 text-base placeholder-gray-400 focus:ring-2 focus:ring-cyan-400 focus:bg-white transition">
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit"
                        class="w-full bg-gradient-to-r from-cyan-400 to-cyan-500 text-white py-4 rounded-full text-base font-semibold hover:from-cyan-500 hover:to-cyan-600 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 mt-2">
                    Sign in
                </button>
            </form>

            <div class="mt-8 text-base text-center">
                <p class="text-gray-600">
                    Not Registered yet?
                    <a href="/register" class="text-cyan-500 font-semibold hover:text-cyan-600 hover:underline">
                        Register
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection