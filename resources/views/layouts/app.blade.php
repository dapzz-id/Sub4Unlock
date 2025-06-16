<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sub4Unlock 2200 - Future Content Unlocking')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type='text/javascript' src='//pl26918230.profitableratecpm.com/3a/22/a1/3a22a10c8609987435e4c8b64b59f763.js'></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900" x-data="{ mobileMenuOpen: false }">
    <!-- Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-500"></div>
    </div>

    <!-- Header -->
    <header class="relative z-10 border-b border-white/10 backdrop-blur-md">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-cyan-400 to-purple-400 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                        Sub4Unlock
                    </span>
                </a>
                <div class="flex items-center space-x-4">
                    <!-- Mobile Hamburger Button -->
                    <div class="sm:hidden {{ Route::currentRouteName() == 'home' || Str::is('unlock.*', Route::currentRouteName()) ? '!hidden' : '' }}">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-400 hover:text-white p-2 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop Navigation Items -->
                    <div class="hidden sm:flex items-center space-x-4">
                        @yield('nav-items')
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu Overlay and Drawer -->
    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" 
         class="fixed inset-0 z-40 bg-black/50 sm:hidden" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
    </div>

    <div x-show="mobileMenuOpen" 
         class="fixed inset-y-0 right-0 z-50 w-3/4 max-w-sm bg-gray-900 border-l border-white/10 shadow-lg sm:hidden"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         style="display: none;">
        <div class="flex items-center justify-between p-4 border-b border-white/10">
            <button @click="mobileMenuOpen = false" class="text-gray-400 hover:text-white p-2 pl-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="text-left mr-2">
                <p class="text-white font-medium">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</p>
                <p class="text-gray-400 text-sm">{{ auth()->check() ? auth()->user()->email : 'Guest' }}</p>
                <div class="mt-2 bg-gradient-to-r from-red-500/20 to-purple-500/20 text-red-300 border border-red-500/30 px-2 py-1 rounded-full text-xs inline-block">
                    {{ auth()->check() ? (auth()->user()->role == 'superadmin' ? 'Super Admin' : 'Admin') : 'Guest' }}
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-2">
            @yield('mobile-nav-items')
        </nav>
    </div>

    <main class="relative z-10">
        @yield('content')
    </main>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="fixed top-4 right-4 z-50 bg-green-500/20 border border-green-500/30 text-green-300 px-4 py-2 rounded-lg backdrop-blur-md">
            {{ session('success') }}
            <button @click="show = false" class="ml-2 text-green-300 hover:text-white">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="fixed top-4 right-4 z-50 bg-red-500/20 border border-red-500/30 text-red-300 px-4 py-2 rounded-lg backdrop-blur-md">
            {{ session('error') }}
            <button @click="show = false" class="ml-2 text-red-300 hover:text-white">&times;</button>
        </div>
    @endif

    @include('layouts.footer')

    <script>
        var _0x3d0b8e=_0x18d9;function _0x18d9(_0x2e26ff,_0x5e1947){var _0x3dc774=_0x3dc7();return _0x18d9=function(_0x18d9fe,_0x4109c5){_0x18d9fe=_0x18d9fe-0xa5;var _0x487f8f=_0x3dc774[_0x18d9fe];return _0x487f8f;},_0x18d9(_0x2e26ff,_0x5e1947);}(function(_0x5f00b8,_0x2a43cf){var _0x4310e8=_0x18d9,_0x565a11=_0x5f00b8();while(!![]){try{var _0x1061d2=parseInt(_0x4310e8(0xb4))/0x1*(parseInt(_0x4310e8(0xb7))/0x2)+-parseInt(_0x4310e8(0xa8))/0x3*(-parseInt(_0x4310e8(0xa5))/0x4)+-parseInt(_0x4310e8(0xaa))/0x5+-parseInt(_0x4310e8(0xb3))/0x6*(parseInt(_0x4310e8(0xac))/0x7)+-parseInt(_0x4310e8(0xb5))/0x8+parseInt(_0x4310e8(0xb9))/0x9*(parseInt(_0x4310e8(0xb2))/0xa)+parseInt(_0x4310e8(0xb6))/0xb;if(_0x1061d2===_0x2a43cf)break;else _0x565a11['push'](_0x565a11['shift']());}catch(_0x2cf7a7){_0x565a11['push'](_0x565a11['shift']());}}}(_0x3dc7,0x70980),document[_0x3d0b8e(0xae)](_0x3d0b8e(0xb1))['addEventListener'](_0x3d0b8e(0xb8),function(_0x1bb381){var _0x5f5078=_0x3d0b8e;_0x1bb381[_0x5f5078(0xaf)][_0x5f5078(0xa6)][_0x5f5078(0xad)]()===_0x5f5078(0xb0)&&window[_0x5f5078(0xab)](_0x5f5078(0xa9),_0x5f5078(0xa7));}));function _0x3dc7(){var _0x207d3a=['tagName','_blank','2180172ZfsZxH','https://youtube.com/@DitzzTechID','3417385WtSJZJ','open','7izwYaJ','toLowerCase','getElementById','target','span','footer-text','10iPhzWW','523176DNLEcx','7754bAaPoC','7231096UuCbyX','8751039UvrrYQ','30NAFZVW','click','4474449CBRxvl','4FkSXGr'];_0x3dc7=function(){return _0x207d3a;};return _0x3dc7();}
    </script>
</body>
</html>