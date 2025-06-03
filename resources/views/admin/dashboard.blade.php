@extends('layouts.app')

@section('nav-items')
    <div class="flex items-center space-x-4">
        <div class="text-right">
            <p class="text-white font-medium">{{ auth()->user()->name }}</p>
            <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
        </div>
        <div
            class="bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-300 border border-cyan-500/30 px-3 py-1 rounded-full text-sm">
            Admin Panel
        </div>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Conversion Rate</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['conversion_rate'] }}%</p>
                    </div>
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Ad Network Info -->
        <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-white">Ad Network Status</h2>
                    <p class="text-gray-400 mt-1">Current active ad network for all your links</p>
                </div>
            </div>

            @if ($stats['active_ad_network'])
                @php
                    $config = App\Models\AdNetwork::getProviderConfig($stats['active_ad_network']->provider);
                @endphp
                <div class="mt-4 flex items-center space-x-4">
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
                <p class="mt-4 text-gray-400 text-sm">All your links will use this ad network for monetization. Ad network
                    settings are managed by the Super Admin.</p>
            @else
                <div class="mt-4 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <span class="text-yellow-400 font-medium">No active ad network</span>
                    </div>
                    <p class="mt-2 text-gray-400 text-sm">There is currently no active ad network. Your links will not show
                        ads until a Super Admin activates an ad network.</p>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg">
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-white">Unlock Links Management</h2>
                    <p class="text-gray-400 mt-1">Create and manage your Sub4Unlock links</p>
                </div>
                <button x-data="" x-on:click="$dispatch('open-modal', 'create-link')"
                    class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-4 py-2 rounded-lg transition-all">
                    <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Link
                </button>
            </div>

            @if ($links->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left p-4 text-gray-300">Title</th>
                                <th class="text-left p-4 text-gray-300">Short Code</th>
                                <th class="text-left p-4 text-gray-300">Views</th>
                                <th class="text-left p-4 text-gray-300">Unlocks</th>
                                <th class="text-left p-4 text-gray-300">Status</th>
                                <th class="text-left p-4 text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($links as $link)
                                <tr class="border-b border-white/10">
                                    <td class="p-4">
                                        <div class="font-medium text-white">{{ $link->title }}</div>
                                        <div class="text-sm text-gray-400">{{ $link->description }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div
                                            class="bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 px-2 py-1 rounded-full text-sm inline-block">
                                            {{ $link->short_code }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-white">{{ number_format($link->views) }}</td>
                                    <td class="p-4 text-white">{{ number_format($link->unlocks) }}</td>
                                    <td class="p-4">
                                        <div
                                            class="bg-green-500/20 text-green-300 border border-green-500/30 px-2 py-1 rounded-full text-sm inline-block">
                                            {{ $link->status }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center space-x-2">
                                            <button
                                                onclick="copyToClipboard('{{ route('unlock.show', $link->short_code) }}')"
                                                class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <a href="{{ route('unlock.show', $link->short_code) }}" target="_blank"
                                                class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-link-{{ $link->id }}')"
                                                class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <form method="POST" action="{{ route('admin.links.destroy', $link) }}"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this link?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-red-400 hover:bg-red-500/10 p-2 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                    <h3 class="text-white text-lg font-medium mb-2">No Links Created Yet</h3>
                    <p class="text-gray-400 mb-6">Create your first unlock link to start monetizing your content</p>
                    <button x-data="" x-on:click="$dispatch('open-modal', 'create-link')"
                        class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-6 py-3 rounded-lg transition-all">
                        Create Your First Link
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Link Modal -->
    <x-modal name="create-link" :show="$errors->any()">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Create New Unlock Link</h2>
            <form method="POST" action="{{ route('admin.links.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-white text-sm font-medium mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                        placeholder="Enter link title">
                </div>
                <div>
                    <label for="description" class="block text-white text-sm font-medium mb-2">Description</label>
                    <textarea id="description" name="description" required
                        class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                        placeholder="Enter link description">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label for="target_url" class="block text-white text-sm font-medium mb-2">Target URL</label>
                    <input type="url" id="target_url" name="target_url" value="{{ old('target_url') }}" required
                        class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                        placeholder="https://example.com/content">
                </div>
                <div>
                    <label for="short_code" class="block text-white text-sm font-medium mb-2">Short Code</label>
                    <input type="text" id="short_code" name="short_code" value="{{ old('short_code') }}" required
                        class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                        placeholder="UNIQUE123">
                </div>

                @if ($stats['active_ad_network'])
                    <div>
                        <label for="ad_duration" class="block text-white text-sm font-medium mb-2">Ad Duration
                            (seconds)</label>
                        <input type="number" id="ad_duration" name="ad_duration" value="{{ old('ad_duration', 30) }}"
                            min="5" max="60"
                            class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">
                        <p class="text-gray-400 text-xs mt-1">How long the user must watch the ad (5-60 seconds)</p>
                    </div>
                @endif

                <div class="flex space-x-4 pt-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white py-3 rounded-lg font-medium transition-all">
                        Create Link
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="flex-1 border border-white/20 text-white hover:bg-white/10 py-3 rounded-lg font-medium transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Edit Link Modals -->
    @foreach ($links as $link)
        <x-modal name="edit-link-{{ $link->id }}">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Edit Unlock Link</h2>
                <form method="POST" action="{{ route('admin.links.update', $link) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="title-{{ $link->id }}"
                            class="block text-white text-sm font-medium mb-2">Title</label>
                        <input type="text" id="title-{{ $link->id }}" name="title"
                            value="{{ $link->title }}" required
                            class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">
                    </div>
                    <div>
                        <label for="description-{{ $link->id }}"
                            class="block text-white text-sm font-medium mb-2">Description</label>
                        <textarea id="description-{{ $link->id }}" name="description" required
                            class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">{{ $link->description }}</textarea>
                    </div>
                    <div>
                        <label for="target_url-{{ $link->id }}"
                            class="block text-white text-sm font-medium mb-2">Target URL</label>
                        <input type="url" id="target_url-{{ $link->id }}" name="target_url"
                            value="{{ $link->target_url }}" required
                            class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">
                    </div>
                    <div>
                        <label for="short_code-{{ $link->id }}"
                            class="block text-white text-sm font-medium mb-2">Short Code</label>
                        <input type="text" id="short_code-{{ $link->id }}" name="short_code"
                            value="{{ $link->short_code }}" required
                            class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">
                    </div>

                    @if ($stats['active_ad_network'])
                        <div>
                            <label for="ad_duration-{{ $link->id }}"
                                class="block text-white text-sm font-medium mb-2">Ad Duration (seconds)</label>
                            <input type="number" id="ad_duration-{{ $link->id }}" name="ad_duration"
                                value="{{ $link->ad_settings['duration'] ?? 30 }}" min="5" max="60"
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">
                            <p class="text-gray-400 text-xs mt-1">How long the user must watch the ad (5-60 seconds)</p>
                        </div>
                    @endif

                    <div class="flex space-x-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white py-3 rounded-lg font-medium transition-all">
                            Update Link
                        </button>
                        <button type="button" x-on:click="$dispatch('close')"
                            class="flex-1 border border-white/20 text-white hover:bg-white/10 py-3 rounded-lg font-medium transition-all">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    </script>
@endsection
