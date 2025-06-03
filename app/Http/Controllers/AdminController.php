<?php

namespace App\Http\Controllers;

use App\Models\UnlockLink;
use App\Models\AdNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $links = UnlockLink::with('adNetwork')
                          ->where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();

        $activeAdNetwork = AdNetwork::where('is_active', true)->first();

        $stats = [
            'total_links' => $links->count(),
            'total_views' => $links->sum('views'),
            'total_unlocks' => $links->sum('unlocks'),
            'active_ad_network' => $activeAdNetwork,
        ];

        $stats['conversion_rate'] = $stats['total_views'] > 0 
            ? round(($stats['total_unlocks'] / $stats['total_views']) * 100, 1) 
            : 0;

        return view('admin.dashboard', compact('links', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_url' => 'required|url',
            'short_code' => 'required|string|unique:unlock_links,short_code|max:50',
            'ad_duration' => 'nullable|integer|min:5|max:60',
        ]);

        $adSettings = [];
        $activeAdNetwork = AdNetwork::where('is_active', true)->first();
        
        if ($activeAdNetwork) {
            $adSettings['duration'] = $request->ad_duration ?? 30;
        }

        UnlockLink::create([
            'title' => $request->title,
            'description' => $request->description,
            'target_url' => $request->target_url,
            'short_code' => $request->short_code,
            'ad_network_id' => $activeAdNetwork ? $activeAdNetwork->id : null,
            'ad_settings' => $adSettings,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Link created successfully!');
    }

    public function update(Request $request, UnlockLink $link)
    {
        $this->authorize('update', $link);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_url' => 'required|url',
            'short_code' => 'required|string|max:50|unique:unlock_links,short_code,' . $link->id,
            'ad_duration' => 'nullable|integer|min:5|max:60',
        ]);

        $adSettings = $link->ad_settings ?? [];
        $activeAdNetwork = AdNetwork::where('is_active', true)->first();
        
        if ($activeAdNetwork) {
            $adSettings['duration'] = $request->ad_duration ?? 30;
        } else {
            $adSettings = [];
        }

        $link->update([
            'title' => $request->title,
            'description' => $request->description,
            'target_url' => $request->target_url,
            'short_code' => $request->short_code,
            'ad_network_id' => $activeAdNetwork ? $activeAdNetwork->id : null,
            'ad_settings' => $adSettings,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Link updated successfully!');
    }

    public function destroy(UnlockLink $link)
    {
        $this->authorize('delete', $link);
        
        $link->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Link deleted successfully!');
    }
}