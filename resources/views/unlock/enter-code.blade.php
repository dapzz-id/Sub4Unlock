@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <!-- Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-500"></div>
    </div>

    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md">
            <!-- Main Form -->
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6 mb-6">
                <h2 class="text-2xl text-white text-center mb-2">Unlock Content</h2>
                <p class="text-gray-400 text-center mb-6">Enter the code you received to access your content</p>

                <div class="space-y-4">
                    <!-- Error Message -->
                    <div id="errorMessage" class="bg-red-500/10 border border-red-500/20 rounded-lg p-3 hidden">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-400 text-sm" id="errorText"></span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="code" class="block text-white text-sm font-medium">Unlock Code</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-4.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input
                                id="code"
                                type="text"
                                minlength="6"
                                placeholder="Enter your unlock code"
                                class="w-full bg-white/5 border border-white/10 text-white pl-10 pr-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none text-center text-lg font-mono tracking-wider uppercase"
                                maxlength="20"
                                required
                            />
                        </div>
                    </div>

                    <button
                        id="submitBtn"
                        class="w-full bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white py-3 rounded-lg font-medium transition-all"
                    >
                        <span id="submitText">Unlock Content</span>
                    </button>
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-colors">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.getElementById('code');
        const submitBtn = document.getElementById('submitBtn');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');

        submitBtn.addEventListener('click', function() {
            const code = codeInput.value.trim();

            if (!code) {
                showError('Please enter an unlock code');
                return;
            }
            
            if (code.length < 6) {
                showError('Code must be at least 6 characters long');
                return;
            }
            window.location.href = `/unlock/${code}`;
        });

        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
        }
    });

    // Optional: fungsi kalau mau pakai klik kode preset
    function useCode(code) {
        document.getElementById('code').value = code;
        document.getElementById('code').focus();
    }
</script>
@endsection