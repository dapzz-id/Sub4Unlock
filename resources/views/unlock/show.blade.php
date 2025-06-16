@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <!-- Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-1000"></div>
    </div>

    <div class="relative z-10 container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Content Preview -->
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 mb-8 relative overflow-hidden">
                <!-- Lock Overlay -->
                @if($completedSteps < $totalSteps)
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-10">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Content Locked</h3>
                        <p class="text-gray-300">Complete all steps below to unlock this content</p>
                    </div>
                </div>
                @endif

                <!-- Content Preview -->
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-white mb-4">{{ $unlockLink->title }}</h1>
                    <p class="text-gray-300 mb-6">{{ $unlockLink->description }}</p>
                    
                    <!-- Target URL Preview -->
                    <div class="bg-white/10 rounded-lg p-4 inline-block">
                        <button class="flex items-center space-x-2 text-gray-400" type="button" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <span class="text-sm">Go to the page</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Progress Header -->
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-2xl font-bold text-white">Unlock Progress</h1>
                    <div class="bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $completedSteps }}/{{ $totalSteps }}
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-white/10 rounded-full h-3 mb-4">
                    <div class="bg-gradient-to-r from-cyan-500 to-purple-500 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0 }}%"></div>
                </div>
                
                <p class="text-gray-400">Complete all steps to unlock your premium content</p>
            </div>

            <!-- Steps -->
            <div class="space-y-6">
                @foreach($steps as $step)
                <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 
                           {{ $step['completed'] ? 'border-green-500/30 bg-green-500/5' : '' }}">
                    
                    <div class="flex items-start space-x-4">
                        <!-- Step Icon -->
                        <div class="flex-shrink-0">
                            @if($step['completed'])
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-12 h-12 {{ $step['color'] }} rounded-lg flex items-center justify-center">
                                    @if($step['icon'] === 'youtube')
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                    @elseif($step['icon'] === 'instagram')
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    @elseif($step['icon'] === 'twitter')
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                    @elseif($step['icon'] === 'facebook')
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    @elseif($step['icon'] === 'play')
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Step Content -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-white">{{ $step['title'] }}</h3>
                                @if($step['completed'])
                                    <div class="bg-green-500/20 text-green-300 border border-green-500/30 px-2 py-1 rounded text-xs font-medium">
                                        <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Done
                                    </div>
                                @endif
                            </div>
                            <p class="text-gray-400 mb-4">{{ $step['description'] }}</p>

                            <!-- Action Buttons -->
                            @if(!$step['completed'])
                                <div class="flex space-x-3">
                                    @if($step['is_ad'])
                                        <!-- Advertisement Step -->
                                        <div class="flex-1" id="ad-container-{{ $step['index'] }}">
                                            <button onclick="watchAd({{ $step['index'] }}, {{ $step['duration'] }})" 
                                                    class="w-full {{ $step['color'] }} hover:opacity-90 text-white px-6 py-3 rounded-lg font-medium transition-all"
                                                    id="watch-ad-btn-{{ $step['index'] }}">
                                                <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                                                </svg>
                                                {{ $step['button_text'] }}
                                            </button>
                                            
                                            <!-- Ad Player (Hidden initially) -->
                                            <div id="ad-player-{{ $step['index'] }}" class="hidden">
                                                <div class="bg-black rounded-lg p-4 mb-4">
                                                    <!-- Ad content will be loaded here -->
                                                    <div class="text-center text-white">
                                                        <div class="text-3xl font-bold mb-2" id="countdown-{{ $step['index'] }}">{{ $step['duration'] }}</div>
                                                        <p class="text-gray-400 mb-4">Seconds remaining...</p>
                                                        <div class="w-full bg-white/10 rounded-full h-2">
                                                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-1000" 
                                                                 id="progress-{{ $step['index'] }}" style="width: 0%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Social Media Step - Button Gabungan -->
                                        <a href="{{ $step['url'] }}" target="_blank" 
                                           onclick="event.preventDefault(); markCompleteAndRedirect({{ $step['index'] }}, '{{ $step['url'] }}')"
                                           class="flex-1 cursor-pointer {{ $step['color'] }} hover:opacity-90 text-white px-6 py-3 rounded-lg font-medium transition-all text-center">
                                            @if($step['icon'] === 'youtube')
                                                <svg class="inline w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                                </svg>
                                            @elseif($step['icon'] === 'instagram')
                                                <svg class="inline w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                </svg>
                                            @endif
                                            {{ $step['button_text'] }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Unlock Button -->
            @if($completedSteps === $totalSteps && !session("unlocked_{$unlockLink->short_code}"))
            <div class="bg-gradient-to-r from-green-500/10 to-green-600/10 border border-green-500/30 backdrop-blur-md rounded-lg p-8 mt-8 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">All Steps Completed!</h3>
                <p class="text-gray-300 mb-6">You have successfully completed all requirements. Click below to unlock your content.</p>
                <button onclick="unlockContent()" 
                        class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-lg font-medium transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Unlock Content Now
                </button>
            </div>
            @elseif(session("unlocked_{$unlockLink->short_code}"))
            <!-- Success State -->
            <div class="bg-gradient-to-r from-green-500/10 to-green-600/10 border border-green-500/30 backdrop-blur-md rounded-lg p-8 mt-8 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Content Unlocked!</h3>
                <p class="text-gray-300 mb-6">Congratulations! You have successfully unlocked the content. Click below to access it.</p>
                <a href="{{ $unlockLink->target_url }}" target="_blank"
                   class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-lg font-medium transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7l10 10M17 7v4m0 0h-4"></path>
                    </svg>
                    Access Your Content
                </a>
                <div class="mt-4">
                    <a href="/" class="text-gray-400 hover:text-white transition-colors">
                        ← Return Home
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    async function markCompleteAndRedirect(stepIndex, url) {
        const button = event.target;
        const originalText = button.innerHTML;
        
        // Tampilkan loading
        button.innerHTML = `<svg class="animate-spin inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg> Processing...`;
        button.disabled = true;

        try {
            // Buka URL di tab baru
            const newWindow = window.open(url, '_blank');
            
            // Kirim request ke server
            const response = await fetch(`/unlock/{{ $unlockLink->short_code }}/complete-step`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ step_index: stepIndex })
            });
            
            const data = await response.json();
            
            // Jika semua step selesai, redirect ke target URL
            if (data.completed_all) {
                window.location.href = "{{ $unlockLink->target_url }}";
            } else {
                // Reload halaman untuk reset progress
                setTimeout(() => location.reload(), 1000);
            }
            
        } catch (error) {
            console.error('Error:', error);
            button.innerHTML = originalText;
            button.disabled = false;
            // Tetap reload meski ada error
            setTimeout(() => location.reload(), 1000);
        }
    }

    function watchAd(stepIndex, duration) {
        // Hide the watch button and show ad player
        document.getElementById(`watch-ad-btn-${stepIndex}`).style.display = 'none';
        document.getElementById(`ad-player-${stepIndex}`).classList.remove('hidden');
        
        let countdown = duration;
        const countdownElement = document.getElementById(`countdown-${stepIndex}`);
        const progressElement = document.getElementById(`progress-${stepIndex}`);
        
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            const progress = ((duration - countdown) / duration) * 100;
            progressElement.style.width = progress + '%';
            
            if (countdown <= 0) {
                clearInterval(timer);
                // Langsung kirim request complete dan reload
                fetch(`/unlock/{{ $unlockLink->short_code }}/complete-step`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ step_index: stepIndex })
                }).finally(() => location.reload());
            }
        }, 1000);
    }

    // function checkSessionExpiry() {
    //     const expiryTime = new Date('{{ session()->get("session_expiry_".$unlockLink->short_code) }}');
    //     if (expiryTime && new Date() > expiryTime) {
    //         // Force hard refresh untuk clear cache
    //         window.location.reload(true);
    //     }
    // }

    // Cek setiap 5 detik
    // setInterval(checkSessionExpiry, 5000);

    function markComplete(stepIndex) {
        fetch(`/unlock/{{ $unlockLink->short_code }}/complete-step`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                step_index: stepIndex
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function unlockContent() {
        fetch(`/unlock/{{ $unlockLink->short_code }}/unlock`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
@endsection