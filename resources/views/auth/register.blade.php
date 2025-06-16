@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Register Card -->
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="text-center mb-6">
                    <h2 class="text-2xl text-white font-semibold">Create Account</h2>
                    <p class="text-gray-400 mt-2">Enter your details to create a new Sub4Unlock account</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3 mb-4 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-400 text-sm">{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-white text-sm font-medium mb-2">Full Name</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-4 w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full bg-white/5 border border-white/10 text-white pl-10 pr-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                    placeholder="Enter your full name">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-white text-sm font-medium mb-2">Email Address</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-4 w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="w-full bg-white/5 border border-white/10 text-white pl-10 pr-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                    placeholder="Enter your email">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-white text-sm font-medium mb-2">Password</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-4 w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <input type="password" id="password" name="password" required
                                    class="w-full bg-white/5 border border-white/10 text-white pl-10 pr-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                    placeholder="Create a password">
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-white text-sm font-medium mb-2">Confirm
                                Password</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-4 w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full bg-white/5 border border-white/10 text-white pl-10 pr-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                    placeholder="Confirm your password">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white py-3 rounded-lg font-medium transition-all">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-400 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-cyan-400 hover:text-cyan-300 font-medium">Sign in
                            here</a>
                    </p>
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('home') }}"
                    class="text-gray-400 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-colors">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
@endsection
