<?php

namespace App\Observers;

use App\Models\AdNetwork;
use App\Models\UnlockLink;

class AdNetworkObserver
{
    /**
     * Handle the AdNetwork "updated" event.
     */
    public function updated(AdNetwork $adNetwork): void
    {
        if ($adNetwork->is_active) {
            AdNetwork::where('id', '!=', $adNetwork->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            
            UnlockLink::query()->update(['ad_network_id' => $adNetwork->id]);
        }
    }

    /**
     * Handle the AdNetwork "deleted" event.
     */
    public function deleted(AdNetwork $adNetwork): void
    {
        if ($adNetwork->is_active) {
            UnlockLink::where('ad_network_id', $adNetwork->id)
                    ->update(['ad_network_id' => null]);
        }
    }
}