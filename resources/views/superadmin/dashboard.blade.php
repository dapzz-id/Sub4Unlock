@extends('layouts.app')

@section('nav-items')
    <div class="flex items-center space-x-4">
        <div class="text-right">
            <p class="text-white font-medium">{{ auth()->user()->name }}</p>
            <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
        </div>
        <div
            class="bg-gradient-to-r from-red-500/20 to-purple-500/20 text-red-300 border border-red-500/30 px-3 py-1 rounded-full text-sm">
            Super Admin
        </div>
        <a href="{{ route('superadmin.ad-networks') }}"
            class="text-gray-400 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-colors">
            Ad Networks
        </a>
        <a href="{{ route('superadmin.users') }}"
            class="text-gray-400 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-colors">
            Users
        </a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit"
                class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3">
                    </path>
                </svg>
            </button>
        </form>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Users</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total_users'] }}</p>
                    </div>
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Admins</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total_admins'] }}</p>
                    </div>
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Links</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total_links'] }}</p>
                    </div>
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Views</p>
                        <p class="text-2xl font-bold text-white">{{ number_format($stats['total_views']) }}</p>
                    </div>
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Unlocks</p>
                        <p class="text-2xl font-bold text-white">{{ number_format($stats['total_unlocks']) }}</p>
                    </div>
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Ad Networks</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total_ad_networks'] }}</p>
                    </div>
                    <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Ad Network -->
        <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-white">Active Ad Network</h2>
                    <p class="text-gray-400 mt-1">Currently active ad network for all unlock links</p>
                </div>
                <a href="{{ route('superadmin.ad-networks') }}"
                    class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-4 py-2 rounded-lg transition-all">
                    Manage Ad Networks
                </a>
            </div>

            @if ($stats['active_ad_network'])
                @php
                    $config = App\Models\AdNetwork::getProviderConfig($stats['active_ad_network']->provider);
                @endphp
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r {{ $config['color'] }} rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            @if ($stats['active_ad_network']->provider === 'google')
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            @elseif($stats['active_ad_network']->provider === 'unity')
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            @else
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            @endif
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-medium">{{ $stats['active_ad_network']->name }}</h3>
                        <p class="text-gray-400 text-sm">
                            {{ $config['name'] ?? ucfirst($stats['active_ad_network']->provider) }}</p>
                    </div>
                    <div class="ml-auto flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <span class="text-green-400 text-sm">Active</span>
                    </div>
                </div>
            @else
                <div class="p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <span class="text-yellow-400 font-medium">No active ad network</span>
                    </div>
                    <p class="mt-2 text-gray-400 text-sm">Configure and activate an ad network to enable monetization for
                        all unlock links.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('superadmin.ad-networks') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/5 transition-colors">
                        <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="text-white">Manage Ad Networks</span>
                    </a>
                    <a href="{{ route('superadmin.users') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/5 transition-colors">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="text-white">Manage Users</span>
                    </a>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">System Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Platform Status</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-green-400 text-sm">Online</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Conversion Rate</span>
                        <span class="text-white">{{ $stats['conversion_rate'] }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Active Ad Network</span>
                        @if ($stats['active_ad_network'])
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                <span class="text-green-400 text-sm">Connected</span>
                            </div>
                        @else
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                                <span class="text-red-400 text-sm">Not Set</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
