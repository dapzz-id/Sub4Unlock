<?php

namespace App\Http\Controllers;

use App\Models\AdNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdNetworkController extends Controller
{
    public function index()
    {
        $adNetworks = AdNetwork::where('user_id', auth()->id())->get();
        $providers = AdNetwork::getAllProviders();
        
        return view('admin.ad-networks', compact('adNetworks', 'providers'));
    }

    public function store(Request $request)
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
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.ad-networks')->with('success', 'Ad network added successfully!');
    }

    public function update(Request $request, AdNetwork $adNetwork)
    {
        $this->authorize('update', $adNetwork);

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

        return redirect()->route('admin.ad-networks')->with('success', 'Ad network updated successfully!');
    }

    public function destroy(AdNetwork $adNetwork)
    {
        $this->authorize('delete', $adNetwork);
        
        $adNetwork->delete();

        return redirect()->route('admin.ad-networks')->with('success', 'Ad network deleted successfully!');
    }

    public function testConnection(AdNetwork $adNetwork)
    {
        $this->authorize('update', $adNetwork);

        $result = $adNetwork->testConnection();

        if ($result['success']) {
            $adNetwork->update(['is_active' => true]);
            return response()->json(['success' => true, 'message' => $result['message']]);
        }

        return response()->json(['success' => false, 'message' => $result['message']], 400);
    }

    public function toggleStatus(AdNetwork $adNetwork)
    {
        $this->authorize('update', $adNetwork);

        $adNetwork->update(['is_active' => !$adNetwork->is_active]);

        return redirect()->route('admin.ad-networks')->with('success', 'Ad network status updated!');
    }
}