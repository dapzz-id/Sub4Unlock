<?php

namespace App\Http\Controllers;

use App\Models\UnlockLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $links = UnlockLink::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();

        $stats = [
            'total_links' => $links->count(),
            'total_views' => $links->sum('views'),
            'total_unlocks' => $links->sum('unlocks'),
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
        ]);

        UnlockLink::create([
            'title' => $request->title,
            'description' => $request->description,
            'target_url' => $request->target_url,
            'short_code' => $request->short_code,
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
        ]);

        $link->update($request->only(['title', 'description', 'target_url', 'short_code']));

        return redirect()->route('admin.dashboard')->with('success', 'Link updated successfully!');
    }

    public function destroy(UnlockLink $link)
    {
        $this->authorize('delete', $link);
        
        $link->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Link deleted successfully!');
    }
}