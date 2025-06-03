@extends('layouts.app')

@section('nav-items')
    <a href="{{ route('unlock.show', 'demo') }}" class="text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-colors">
        Try Demo
    </a>
    @auth
        <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-4 py-2 rounded-lg transition-all">
            Admin Panel
        </a>
    @else
        <a href="{{ route('login') }}" class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-4 py-2 rounded-lg transition-all">
            Admin Login
        </a>
    @endauth
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="py-20">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-6 inline-block bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-300 border border-cyan-500/30 px-4 py-2 rounded-full text-sm">
                🚀 Welcome to the Future of Content Unlocking
            </div>
            <h1 class="text-6xl md:text-8xl font-bold mb-6 bg-gradient-to-r from-white via-cyan-200 to-purple-200 bg-clip-text text-transparent leading-tight">
                Unlock the<br>
                <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                    Digital Frontier
                </span>
            </h1>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                Experience the next evolution of content access. Our quantum-powered platform revolutionizes how you unlock
                premium content in the year 2200.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('unlock.show', 'demo') }}" class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-8 py-4 rounded-lg text-lg font-medium transition-all inline-flex items-center justify-center">
                    Start Unlocking
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <button class="border border-white/20 text-white hover:bg-white/10 px-8 py-4 rounded-lg text-lg font-medium transition-all">
                    Learn More
                </button>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 text-center">
                    <svg class="w-8 h-8 text-cyan-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                    </svg>
                    <div class="text-3xl font-bold text-white mb-2">{{ number_format($stats['total_views']) }}+</div>
                    <div class="text-gray-400">Total Views</div>
                </div>
                <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 text-center">
                    <svg class="w-8 h-8 text-purple-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <div class="text-3xl font-bold text-white mb-2">{{ number_format($stats['total_unlocks']) }}+</div>
                    <div class="text-gray-400">Content Unlocked</div>
                </div>
                <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 text-center">
                    <svg class="w-8 h-8 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <div class="text-3xl font-bold text-white mb-2">{{ $stats['conversion_rate'] }}%</div>
                    <div class="text-gray-400">Success Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                    Powered by Future Tech
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Advanced quantum algorithms and neural networks deliver unmatched performance
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $features = [
                        [
                            'title' => 'Instant Unlock',
                            'description' => 'Unlock premium content in seconds with our advanced quantum processing',
                            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'
                        ],
                        [
                            'title' => 'Secure Access',
                            'description' => 'Military-grade encryption protects your data in the digital frontier',
                            'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'
                        ],
                        [
                            'title' => 'Lightning Fast',
                            'description' => 'Powered by neural networks for unprecedented speed and reliability',
                            'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z'
                        ]
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="bg-white/5 border border-white/10 backdrop-blur-md hover:bg-white/10 transition-all duration-300 group rounded-lg p-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"></path>
                            </svg>
                        </div>
                        <h3 class="text-white text-xl font-semibold mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-400">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="container mx-auto px-4 text-center">
            <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border border-cyan-500/20 backdrop-blur-md max-w-4xl mx-auto rounded-lg p-12">
                <h3 class="text-3xl md:text-4xl font-bold mb-6 text-white">Ready to Enter the Future?</h3>
                <p class="text-xl text-gray-300 mb-8">
                    Join millions of users already unlocking content in the digital frontier
                </p>
                <a href="{{ route('unlock.show', 'demo') }}" class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-12 py-4 rounded-lg text-lg font-medium transition-all inline-flex items-center">
                    Begin Your Journey
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/10 py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400" id="footer-text">© Sub4Unlock Ipung | Developed by <span class="text-gray-400 cursor-pointer font-bold">DitzzTechID</span></p>
        </div>
    </footer>
@endsection