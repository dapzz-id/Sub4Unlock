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
        <a href="{{ route('superadmin.dashboard') }}"
            class="text-gray-400 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-colors">
            Dashboard
        </a>
        <a href="{{ route('superadmin.ad-networks') }}"
            class="text-gray-400 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-colors">
            Ad Networks
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
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">User Management</h1>
                    <p class="text-gray-400">Manage admin users and monitor their activities</p>
                </div>
                <a href="{{ route('superadmin.dashboard') }}"
                    class="text-gray-400 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition-colors">
                    ← Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-4 mb-6 flex items-center space-x-2">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-green-400">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-4 mb-6">
                <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-red-400 font-medium">Please fix the following errors:</span>
                </div>
                <ul class="text-red-400 text-sm space-y-1 ml-7">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Users</p>
                        <p class="text-2xl font-bold text-white">{{ $users->count() }}</p>
                    </div>
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Admin Users</p>
                        <p class="text-2xl font-bold text-white">{{ $users->where('role', 'admin')->count() }}</p>
                    </div>
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Regular Users</p>
                        <p class="text-2xl font-bold text-white">{{ $users->where('role', 'user')->count() }}</p>
                    </div>
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Links</p>
                        <p class="text-2xl font-bold text-white">
                            {{ $users->sum(function ($user) {return $user->unlockLinks->count();}) }}</p>
                    </div>
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-lg overflow-hidden">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-white">Users Management</h2>
                        <p class="text-gray-400 mt-1">Create and manage admin users</p>
                    </div>
                    <button onclick="openCreateModal()"
                        class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-4 py-2 rounded-lg transition-all">
                        <svg class="inline-block w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            @if ($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Links</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Views</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Unlocks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($users as $user)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-gray-500/20 text-gray-300 border border-gray-500/30' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $user->unlockLinks->count() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ number_format($user->unlockLinks->sum('views')) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ number_format($user->unlockLinks->sum('unlocks')) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                        {{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button
                                                onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')"
                                                class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button
                                                onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', {{ $user->unlockLinks->count() }}, {{ $user->unlockLinks->sum('views') }}, {{ $user->unlockLinks->sum('unlocks') }})"
                                                class="text-gray-400 hover:text-red-400 hover:bg-red-500/10 p-2 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <h3 class="text-white text-xl font-medium mb-3">No Users Found</h3>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">Create your first admin user to start managing the
                        platform.</p>
                    <button onclick="openCreateModal()"
                        class="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-6 py-3 rounded-lg font-medium transition-all">
                        Add Your First User
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="createModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-slate-900 border border-white/10 rounded-lg max-w-md w-full">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white">Create New User</h3>
                    <p class="text-gray-400 text-sm mt-1">Add a new admin user to the system</p>
                </div>
                <form method="POST" action="{{ route('superadmin.storeUser') }}">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                placeholder="Enter full name">
                        </div>
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                placeholder="Enter email address">
                        </div>
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                placeholder="Enter password (min. 6 characters)">
                        </div>
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Role</label>
                            <select name="role" required
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none custom-select">
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>SuperAdmin</option>
                            </select>
                        </div>
                    </div>
                    <div class="p-6 border-t border-white/10 flex space-x-4">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-6 py-3 rounded-lg font-medium transition-all">
                            Create User
                        </button>
                        <button type="button" onclick="closeCreateModal()"
                            class="flex-1 border border-white/20 text-white hover:bg-white/10 px-6 py-3 rounded-lg font-medium transition-all">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-slate-900 border border-white/10 rounded-lg max-w-md w-full">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-white">Edit User</h3>
                    <p class="text-gray-400 text-sm mt-1">Update user information and permissions</p>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Full Name</label>
                            <input type="text" id="editName" name="name" required
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Email Address</label>
                            <input type="email" id="editEmail" name="email" required
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Password</label>
                            <input type="password" id="editPassword" name="password"
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none"
                                placeholder="Leave blank to keep current password">
                            <p class="text-gray-500 text-xs mt-1">Leave blank to keep current password</p>
                        </div>
                        <div>
                            <label class="block text-white text-sm font-medium mb-2">Role</label>
                            <select id="editRole" name="role" required
                                class="w-full bg-white/5 border border-white/10 text-white px-4 py-3 rounded-lg focus:border-cyan-500/50 focus:outline-none custom-select">
                                <option value="admin">Admin</option>
                                <option value="superadmin">SuperAdmin</option>
                            </select>
                        </div>
                    </div>
                    <div class="p-6 border-t border-white/10 flex space-x-4">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-600 hover:to-purple-600 text-white px-6 py-3 rounded-lg font-medium transition-all">
                            Update User
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 border border-white/20 text-white hover:bg-white/10 px-6 py-3 rounded-lg font-medium transition-all">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-slate-900 border border-white/10 rounded-lg max-w-md w-full">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold text-red-400">Delete User</h3>
                    <p class="text-gray-400 text-sm mt-1">Are you sure you want to delete this user? This action cannot be
                        undone and will also delete all their unlock links.</p>
                </div>
                <div class="p-6">
                    <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-white mb-2" id="deleteUserName"></h4>
                        <p class="text-gray-300 text-sm mb-2" id="deleteUserEmail"></p>
                        <div class="flex items-center space-x-4 text-sm text-gray-400">
                            <span>Links: <span id="deleteUserLinks"></span></span>
                            <span>Views: <span id="deleteUserViews"></span></span>
                            <span>Unlocks: <span id="deleteUserUnlocks"></span></span>
                        </div>
                    </div>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex space-x-4">
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-lg font-medium transition-all">
                                <svg class="inline-block w-4 h-4 mr-1 -mt-1 max-md:hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Delete
                            </button>
                            <button type="button" onclick="closeDeleteModal()"
                                class="flex-1 border border-white/20 text-white hover:bg-white/10 px-6 py-3 rounded-lg font-medium transition-all">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEditModal(id, name, email, role) {
            document.getElementById('editForm').action = `/superadmin/users/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            document.getElementById('editPassword').value = '';
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openDeleteModal(id, name, email, links, views, unlocks) {
            document.getElementById('deleteForm').action = `/superadmin/users/${id}`;
            document.getElementById('deleteUserName').textContent = name;
            document.getElementById('deleteUserEmail').textContent = email;
            document.getElementById('deleteUserLinks').textContent = links;
            document.getElementById('deleteUserViews').textContent = views.toLocaleString();
            document.getElementById('deleteUserUnlocks').textContent = unlocks.toLocaleString();
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                e.target.classList.add('hidden');
            }
        });

        // Auto-close success message after 5 seconds
        @if (session('success'))
            setTimeout(function() {
                const successAlert = document.querySelector('.bg-green-500\\/10');
                if (successAlert) {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 500);
                }
            }, 5000);
        @endif
    </script>

    <style>
        /* Custom styling untuk select dropdown */
        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            appearance: none;
        }

        /* Styling untuk dropdown options */
        .custom-select option {
            background-color: #0f172a !important; /* slate-900 */
            color: white !important;
            padding: 8px 12px;
        }

        /* Styling untuk option saat di-hover */
        .custom-select option:hover {
            background-color: #1e293b !important; /* slate-800 */
        }

        /* Styling untuk option yang dipilih */
        .custom-select option:checked {
            background-color: #0891b2 !important; /* cyan-600 */
            color: white !important;
        }

        /* Styling untuk select saat focus */
        .custom-select:focus {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
        }

        /* Pastikan dropdown container memiliki background gelap */
        .custom-select:focus option {
            background-color: #0f172a !important;
            color: white !important;
        }

        /* Styling khusus untuk browser webkit (Chrome, Safari) */
        .custom-select option {
            background: #0f172a;
            color: white;
        }

        /* Styling untuk Firefox */
        @-moz-document url-prefix() {
            .custom-select option {
                background-color: #0f172a;
                color: white;
            }
        }
    </style>
@endsection
