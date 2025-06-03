<?php

namespace App\Http\Controllers;

use App\Models\AdNetwork;
use App\Models\User;
use App\Models\UnlockLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SuperAdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_links' => UnlockLink::count(),
            'total_views' => UnlockLink::sum('views'),
            'total_unlocks' => UnlockLink::sum('unlocks'),
            'total_ad_networks' => AdNetwork::count(),
            'active_ad_network' => AdNetwork::where('is_active', true)->first(),
        ];

        $stats['conversion_rate'] = $stats['total_views'] > 0 
            ? round(($stats['total_unlocks'] / $stats['total_views']) * 100, 1) 
            : 0;

        return view('superadmin.dashboard', compact('stats'));
    }

    public function adNetworks()
    {
        $adNetworks = AdNetwork::all();
        $providers = AdNetwork::getAllProviders();
        
        return view('superadmin.ad-networks', compact('adNetworks', 'providers'));
    }

    public function storeAdNetwork(Request $request)
    {
        $provider = $request->input('provider');
        $config = AdNetwork::getProviderConfig($provider);
        
        if (!$config) {
            return back()->withErrors(['provider' => 'Invalid provider selected']);
        }

        // Validate required fields for the provider
        $rules = ['name' => 'required|string|max:255'];
        foreach ($config['fields'] as $field => $label) {
            $rules["credentials.{$field}"] = 'required|string';
        }

        $validated = $request->validate($rules);

        AdNetwork::create([
            'name' => $validated['name'],
            'provider' => $provider,
            'credentials' => $validated['credentials'],
            'is_active' => false,
        ]);

        return redirect()->route('superadmin.ad-networks')->with('success', 'Ad network added successfully!');
    }

    public function updateAdNetwork(Request $request, AdNetwork $adNetwork)
    {
        $config = AdNetwork::getProviderConfig($adNetwork->provider);
        
        $rules = ['name' => 'required|string|max:255'];
        foreach ($config['fields'] as $field => $label) {
            $rules["credentials.{$field}"] = 'required|string';
        }

        $validated = $request->validate($rules);

        $adNetwork->update([
            'name' => $validated['name'],
            'credentials' => $validated['credentials'],
        ]);

        return redirect()->route('superadmin.ad-networks')->with('success', 'Ad network updated successfully!');
    }

    public function destroyAdNetwork(AdNetwork $adNetwork)
    {
        $adNetwork->delete();

        return redirect()->route('superadmin.ad-networks')->with('success', 'Ad network deleted successfully!');
    }

    public function testConnection(AdNetwork $adNetwork)
    {
        $result = $adNetwork->testConnection();

        if ($result['success']) {
            return response()->json(['success' => true, 'message' => $result['message']]);
        }

        return response()->json(['success' => false, 'message' => $result['message']], 400);
    }

    public function toggleStatus(AdNetwork $adNetwork)
    {
        $adNetwork->update(['is_active' => !$adNetwork->is_active]);

        return redirect()->route('superadmin.ad-networks')->with('success', 'Ad network status updated!');
    }

    public function users()
    {
        $users = User::where('role', '!=', 'superadmin')->get();
        return view('superadmin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::min(6)],
            'role' => 'required|in:admin,user',
        ],[
            'email.unique' => 'The email has already been taken.',
            'role.in' => 'The selected role is invalid.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'role.required' => 'The role field is required.',
            'role.string' => 'The role must be a string.',
            'role.max' => 'The role may not be greater than 255 characters.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('superadmin.users')->with('success', 'User created successfully!');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
        ],[
            'email.unique' => 'The email has already been taken.',
            'role.in' => 'The selected role is invalid.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'role.required' => 'The role field is required.',
            'role.string' => 'The role must be a string.',
            'role.max' => 'The role may not be greater than 255 characters.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', Password::min(6)],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.users')->with('success', 'User updated successfully!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('superadmin.users')->with('success', 'User deleted successfully!');
    }
}