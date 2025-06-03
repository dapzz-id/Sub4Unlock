<?php

namespace App\Http\Controllers;

use App\Models\UnlockLink;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_links' => UnlockLink::count(),
            'total_views' => UnlockLink::sum('views'),
            'total_unlocks' => UnlockLink::sum('unlocks'),
        ];

        $stats['conversion_rate'] = $stats['total_views'] > 0 
            ? round(($stats['total_unlocks'] / $stats['total_views']) * 100, 1) 
            : 0;

        return view('home', compact('stats'));
    }
}