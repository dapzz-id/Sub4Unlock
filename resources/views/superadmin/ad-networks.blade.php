@extends('layouts.app')

@section('nav-items')
    <!-- Desktop Navigation Items -->
    <div class="text-right">
        <p class="text-white font-medium">{{ auth()->user()->name }}</p>
        <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
    </div>
    <div class="bg-gradient-to-r from-red-500/20 to-purple-500/20 text-red-300 border border-red-500/30 px-3 py-1 rounded-full text-sm">
        Super Admin
    </div>
    <a href="{{ route('superadmin.dashboard') }}" class="text-gray-400 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-colors">
        Dashboard
    </a>
    <a href="{{ route('superadmin.users') }}" class="text-gray-400 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-colors">
        Users
    </a>
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"></path>
            </svg>
        </button>
    </form>
@endsection

@section('mobile-nav-items')
    <!-- Mobile Navigation Items -->
    <a href="{{ route('superadmin.dashboard') }}" class="block text-gray-400 hover:text-white hover:bg-white/10 px-4 py-3 rounded-lg transition-colors">
        Dashboard
    </a>
    <a href="{{ route('superadmin.users') }}" class="block text-gray-400 hover:text-white hover:bg-white/10 px-4 py-3 rounded-lg transition-colors">
        Users
    </a>
    <form method="POST" action="{{ route('logout') }}" class="block">
        @csrf
        <button type="submit" class="w-full text-left text-gray-400 hover:text-white hover:bg-white/10 px-4 py-3 rounded-lg transition-colors">
            Logout
        </button>
    </form>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 sm:py-8">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Ad Network Management</h1>
                <p class="text-gray-400 text-sm sm:text-base">Configure and manage advertising networks for the entire platform</p>
            </div>
            <a href="{{ route('superadmin.dashboard') }}" class="text-gray-400 hover:text-white hover:bg-white/10 px-3 py-2 sm:px-4 sm:py-2 rounded-lg transition-colors text-sm sm:text-base">
                ← Back to Dashboard
            </a>
        </div>

        <!-- Warning Notice -->
        <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-3 sm:p-4 mb-6">
            <div class="flex items-start space-x-2 sm:space-x-3">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h4 class="text-yellow-400 font-medium text-sm sm:text-base">Important Notice</h4>
                    <p class="text-gray-300 text-xs sm:text-sm mt-1">Only one ad network can be active at a time. When you activate a network, all existing unlock links will automatically use this network. Deactivating will remove ads from all links.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Ad Network -->
    <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-4 sm:p-6 mb-6 sm:mb-8" x-data="{ showForm: false, selectedProvider: '', providerConfig: {} }">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3 sm:mb-4 gap-3">
            <h2 class="text-lg sm:text-xl font-semibold text-white">Add New Ad Network</h2>
            <button @click="showForm = !showForm; selectedProvider = ''; providerConfig = {}; document.getElementById('txtName').value = ''" class="max-md:w-full bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg transition-all text-sm sm:text-base">
                <svg x-show="!showForm" class="inline-block w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span x-show="!showForm">Add Network</span>
                <span x-show="showForm">Cancel</span>
            </button>
        </div>

        <div x-show="showForm" x-transition class="space-y-4 sm:space-y-6">
            <!-- Provider Selection -->
            <div>
                <h3 class="text-white font-medium mb-3 sm:mb-4 text-sm sm:text-base">Select Ad Network Provider</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    @foreach($providers as $key => $provider)
                        <div @click="selectedProvider = '{{ $key }}'; providerConfig = {{ json_encode($provider) }}" 
                             :class="selectedProvider === '{{ $key }}' ? 'border-cyan-500/50 bg-cyan-500/10' : 'border-white/10 hover:border-white/20'"
                             class="border backdrop-blur-md rounded-lg p-3 sm:p-4 cursor-pointer transition-all group">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r {{ $provider['color'] }} rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                                    @if($key === 'google')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-white" viewBox="0 0 16 16">
                                            <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                                        </svg>
                                    @elseif($key === 'propellerads')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-white" viewBox="0 0 16 16">
                                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                        </svg>
                                    @elseif($key === 'adsterra')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-white" viewBox="0 0 16 16">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @elseif($key === 'admob')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-white" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                    @elseif($key === 'media.net')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-white" viewBox="0 0 24 24">
                                            <path d="M3 4h3.5l2.7 8.1L11.9 4h3.6v16h-3.3v-8.5l-3 8.5H9.1l-3-8.5V20H3V4zM20.2 9.2c-.9 0-1.6.3-2.2.9-.6.6-.9 1.4-.9 2.2 0 .9.3 1.6.9 2.2.6.6 1.4.9 2.2.9s1.6-.3 2.2-.9c.6-.6.9-1.4.9-2.2 0-.9-.3-1.6-.9-2.2-.6-.6-1.3-.9-2.2-.9zm0 7c-1.5 0-2.8-.5-3.8-1.5C15.5 13.8 15 12.5 15 11c0-1.5.5-2.8 1.5-3.8 1-1 2.3-1.5 3.8-1.5s2.8.5 3.8 1.5c1 1 1.5 2.3 1.5 3.8 0 1.5-.5 2.8-1.5 3.8-1 1-2.3 1.5-3.8 1.5z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-white" viewBox="0 0 16 16">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-white font-medium text-sm sm:text-base">{{ $provider['name'] }}</h4>
                                    <p class="text-gray-400 text-xs sm:text-sm">{{ ucfirst($key) }} integration</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Configuration Form -->
            <div x-show="selectedProvider" x-transition>
                <form method="POST" action="{{ route('superadmin.ad-networks.store') }}" class="space-y-3 sm:space-y-4">
                    @csrf
                    <input type="hidden" name="provider" x-model="selectedProvider">
                    
                    <div class="bg-white/5 border border-white/10 rounded-lg p-3 sm:p-4">
                        <h4 class="text-white font-medium mb-3 sm:mb-4 text-sm sm:text-base">Network Configuration</h4>
                        
                        <div class="grid grid-cols-1 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-white text-xs sm:text-sm font-medium mb-1 sm:mb-2">Network Name</label>
                                <input type="text" id="txtName" name="name" required
                                       class="w-full bg-white/5 border border-white/10 text-white px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none text-sm sm:text-base"
                                       :placeholder="'My ' + (providerConfig.name || 'Ad Network')">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <template x-for="(label, field) in providerConfig.fields" :key="field">
                                    <div>
                                        <label class="block text-white text-xs sm:text-sm font-medium mb-1 sm:mb-2" x-text="label"></label>
                                        <input type="text" :name="'credentials[' + field + ']'" required
                                               class="w-full bg-white/5 border border-white/10 text-white px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none text-sm sm:text-base"
                                               :placeholder="'Enter ' + label.toLowerCase()">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        <button type="submit" class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-medium transition-all text-sm sm:text-base">
                            Add Ad Network
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Existing Ad Networks -->
    <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-white/10">
            <h2 class="text-lg sm:text-xl font-semibold text-white">Configured Ad Networks</h2>
            <p class="text-gray-400 mt-1 text-xs sm:text-sm">Manage your existing ad network integrations</p>
        </div>

        @if($adNetworks->count() > 0)
            <div class="divide-y divide-white/10">
                @foreach($adNetworks as $network)
                    @php
                        $config = App\Models\AdNetwork::getProviderConfig($network->provider);
                    @endphp
                    <div class="p-4 sm:p-6" x-data="{ editing: false, testing: false }">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-center space-x-3 sm:space-x-4">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-r {{ $config['color'] }} rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        @if($network->provider === 'google')
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        @elseif($network->provider === 'unity')
                                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                        @elseif($network->provider === 'facebook')
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        @else
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-medium text-base sm:text-lg">{{ $network->name }}</h3>
                                    <p class="text-gray-200 text-xs sm:text-sm">{{ $config['name'] ?? ucfirst($network->provider) }}</p>
                                    <p class="text-gray-300 text-xs mt-1">Created {{ $network->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                <!-- Status Badge -->
                                <div class="flex items-center space-x-2">
                                    @if($network->is_active)
                                        <div class="w-2 h-2 sm:w-3 sm:h-3 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="text-green-400 font-medium text-xs sm:text-sm">Active</span>
                                    @else
                                        <div class="w-2 h-2 sm:w-3 sm:h-3 bg-gray-400 rounded-full"></div>
                                        <span class="text-gray-400 text-xs sm:text-sm">Inactive</span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2 ml-auto sm:ml-0">
                                    <!-- Test Connection -->
                                    <button @click="testing = true; fetch('{{ route('superadmin.ad-networks.test', $network) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            }
                                        })
                                        .then(r => r.json())
                                        .then(data => {
                                            testing = false;
                                            Swal.fire({
                                                title: data.success ? 'Success' : 'Failed',
                                                html: `<div style='max-height: 300px; overflow-y: auto;'>${data.message}</div>`,
                                                icon: data.success ? 'success' : 'error',
                                                confirmButtonText: 'OK'
                                            });
                                        })
                                        .catch((error) => {
                                            testing = false;
                                            Swal.fire({
                                                title: 'Test Failed',
                                                html: `<div style='max-height: 300px; overflow-y: auto;'>${error.message || 'Something went wrong'}</div>`,
                                                icon: 'error',
                                                confirmButtonText: 'OK'
                                            });
                                        })"
                                            :disabled="testing"
                                            class="text-gray-400 hover:text-white hover:bg-white/10 p-1 sm:p-2 rounded-lg transition-colors">
                                        <svg x-show="!testing" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <svg x-show="testing" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>

                                    <!-- Toggle Status -->
                                    <form method="POST" action="{{ route('superadmin.ad-networks.toggle', $network) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-white hover:bg-white/10 p-1 sm:p-2 rounded-lg transition-colors" 
                                                onclick="return confirm('{{ $network->is_active ? 'This will deactivate the current ad network and remove ads from all links.' : 'This will activate this ad network and apply it to all existing links.' }} Continue?')">
                                            @if($network->is_active)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    <!-- Edit -->
                                    <button @click="editing = !editing" class="text-gray-400 hover:text-white hover:bg-white/10 p-1 sm:p-2 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('superadmin.ad-networks.destroy', $network) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this ad network? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-400 hover:bg-red-500/10 p-1 sm:p-2 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div x-show="editing" x-transition class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-white/10">
                            <form method="POST" action="{{ route('superadmin.ad-networks.update', $network) }}" class="space-y-3 sm:space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div class="bg-white/5 border border-white/10 rounded-lg p-3 sm:p-4">
                                    <h4 class="text-white font-medium mb-3 sm:mb-4 text-sm sm:text-base">Edit Network Configuration</h4>
                                    
                                    <div class="grid grid-cols-1 gap-3 sm:gap-4">
                                        <div>
                                            <label class="block text-white text-xs sm:text-sm font-medium mb-1 sm:mb-2">Network Name</label>
                                            <input type="text" name="name" value="{{ $network->name }}" required
                                                   class="w-full bg-white/5 border border-white/10 text-white px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none text-sm sm:text-base">
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                            @foreach($config['fields'] as $field => $label)
                                                <div>
                                                    <label class="block text-white text-xs sm:text-sm font-medium mb-1 sm:mb-2">{{ $label }}</label>
                                                    <input type="text" name="credentials[{{ $field }}]" value="{{ $network->credentials[$field] ?? '' }}" required
                                                           class="w-full bg-white/5 border border-white/10 text-white px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none text-sm sm:text-base">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                                    <button type="submit" class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-medium transition-all text-sm sm:text-base">
                                        Update Network
                                    </button>
                                    <button type="button" @click="editing = false" class="border border-white/20 text-white hover:bg-white/10 px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-medium transition-all text-sm sm:text-base">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 sm:p-12 text-center">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-400 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-white text-lg sm:text-xl font-medium mb-2 sm:mb-3">No Ad Networks Configured</h3>
            </div>
        @endif
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mt-6 sm:mt-8">
        <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 sm:p-6">
            <div class="flex items-start space-x-2 sm:space-x-3">
                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-blue-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-blue-400 font-medium mb-1 sm:mb-2 text-sm sm:text-base">How It Works</h4>
                    <p class="text-gray-300 text-xs sm:text-sm">When you activate an ad network, all existing unlock links automatically use this network. Users will see ads from the active network when unlocking content.</p>
                </div>
            </div>
        </div>

        <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-4 sm:p-6">
            <div class="flex items-start space-x-2 sm:space-x-3">
                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-green-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-green-400 font-medium mb-1 sm:mb-2 text-sm sm:text-base">Best Practices</h4>
                    <p class="text-gray-300 text-xs sm:text-sm">Test your ad network connection before activating. Keep your API credentials secure and update them regularly. Monitor performance through your ad network dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection