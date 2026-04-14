@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-linear-to-br from-gray-50 via-blue-50 to-indigo-50 relative overflow-hidden">
    <div class="container mx-auto px-4 flex items-center justify-between max-w-6xl">
        <!-- Left side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 justify-center items-center">
            <div class="relative">
                <!-- Decorative circle background -->
                <div class="absolute inset-0 bg-linear-to-br from-blue-100 to-blue-200 rounded-full w-96 h-96 -z-10 opacity-50"></div>
                
                <!-- Image placeholder -->
                <div class="relative z-80 flex items-center justify-center w-full">
                    <img 
                        src="/images/logoReg.png"
                        alt="Library Illustration"
                        class="w-48 h-auto sm:w-64 md:w-80 lg:w-105 xl:w-125 object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                </div>
            </div>
        </div>
        
        <!-- Right side - Register Form -->
        <div class="w-full lg:w-5/12 bg-white rounded-3xl shadow-2xl p-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                Create Account
            </h2>
            <p class="text-sm text-gray-500 mb-8">
                Register now to get access to borrow books and learning resources anytime.
            </p>
            
            <form method="POST" action="/register" class="space-y-5">
                @csrf
                
                <div>
                    <input type="text" 
                           name="name" 
                           placeholder="Full Name"
                           required
                           class="w-full px-5 py-3 bg-gray-50 border-0 rounded-lg text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-cyan-400 focus:bg-white transition">
                </div>
                
                <div>
                    <input type="email" 
                           name="email" 
                           placeholder="Email address"
                           required
                           class="w-full px-5 py-3 bg-gray-50 border-0 rounded-lg text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-cyan-400 focus:bg-white transition">
                </div>
                
                <div>
                    <input type="password" 
                           name="password" 
                           placeholder="Password"
                           required
                           class="w-full px-5 py-3 bg-gray-50 border-0 rounded-lg text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-cyan-400 focus:bg-white transition">
                </div>
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <button type="submit"
                        class="w-full bg-linear-to-r from-cyan-400 to-cyan-500 text-white py-3 rounded-full font-semibold hover:from-cyan-500 hover:to-cyan-600 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                    Create Account
                </button>
            </form>
            
            <div class="flex items-center justify-center mt-6 text-sm">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="/login" class="text-cyan-500 font-semibold hover:text-cyan-600 hover:underline">
                        Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection