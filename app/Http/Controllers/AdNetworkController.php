<?php

namespace App\Http\Controllers;

use App\Models\AdNetwork;
use Illuminate\Http\Request;

class AdNetworkController extends Controller
{
    public function index()
    {
        $adNetworks = AdNetwork::all();
        $providers = AdNetwork::getAllProviders();
        
        return view('superadmin.ad-networks', compact('adNetworks', 'providers'));
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
        ]);

        return redirect()->route('superadmin.ad-networks')->with('success', 'Ad network added successfully!');
    }

    public function update(Request $request, AdNetwork $adNetwork)
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

    public function destroy(AdNetwork $adNetwork)
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
}