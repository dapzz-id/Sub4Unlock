<?php

namespace App\Http\Controllers;

use App\Models\UnlockLink;
use Illuminate\Http\Request;

class UnlockController extends Controller
{
    public function show($shortCode)
    {
        $link = UnlockLink::where('short_code', $shortCode)
                         ->where('status', 'active')
                         ->firstOrFail();

        $link->incrementViews();

        return view('unlock.show', compact('link'));
    }

    public function complete(Request $request, $shortCode)
    {
        $link = UnlockLink::where('short_code', $shortCode)
                         ->where('status', 'active')
                         ->firstOrFail();

        $request->validate([
            'steps_completed' => 'required|array|min:3',
        ]);

        $link->incrementUnlocks();

        return response()->json([
            'success' => true,
            'redirect_url' => $link->target_url,
        ]);
    }
}