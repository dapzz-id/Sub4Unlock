<?php

namespace App\Http\Controllers;

use App\Models\UnlockLink;
use App\Models\AdNetwork;
use Illuminate\Http\Request;

class UnlockController extends Controller
{
    public function home()
    {
        // Get statistics for homepage
        $stats = [
            'total_views' => UnlockLink::sum('views'),
            'total_unlocks' => UnlockLink::sum('unlocks'),
            'conversion_rate' => $this->calculateConversionRate(),
        ];

        return view('unlock.main', compact('stats'));
    }

    public function enterCode()
    {
        return view('unlock.enter-code');
    }

    public function show($shortCode)
    {
        $unlockLink = UnlockLink::where('short_code', $shortCode)
            ->where('status', 'active')
            ->with('user')
            ->firstOrFail();

        $unlockLink->increment('views');

        $activeAdNetworks = AdNetwork::where('is_active', 1)->get();
        
        $steps = $this->getStepsConfiguration($unlockLink, $activeAdNetworks);
        
        $completedSteps = collect($steps)->where('completed', true)->count();
        $totalSteps = count($steps);

        return view('unlock.show', compact('unlockLink', 'steps', 'completedSteps', 'totalSteps'));
    }

    // public function completeStep(Request $request, $shortCode)
    // {
    //     $unlockLink = UnlockLink::where('short_code', $shortCode)->firstOrFail();
    //     $stepIndex = $request->step_index;

    //     // Store completed step in session
    //     $sessionKey = "completed_steps_{$shortCode}";
    //     $completedSteps = session()->get($sessionKey, []);
        
    //     if (!in_array($stepIndex, $completedSteps)) {
    //         $completedSteps[] = $stepIndex;
    //         session()->put($sessionKey, $completedSteps);
            
    //         // Get total steps
    //         $activeAdNetworks = AdNetwork::where('is_active', 1)->get();
    //         $steps = $this->getStepsConfiguration($unlockLink, $activeAdNetworks);
            
    //         // If all steps completed, increment unlocks
    //         if (count($completedSteps) === count($steps)) {
    //             $unlockLink->increment('unlocks');
    //         }
    //     }

    //     return response()->json(['success' => true]);
    // }

    public function completeStep(Request $request, $shortCode)
    {
        $unlockLink = UnlockLink::where('short_code', $shortCode)->firstOrFail();
        $stepIndex = $request->step_index;

        $sessionKey = "completed_steps_{$shortCode}";
        $expiryKey = "session_expiry_{$shortCode}";
        
        // Reset jika sudah expired
        if (session()->has($expiryKey)) {
            if (now()->gt(session($expiryKey))) {
                session()->forget($sessionKey);
                session()->forget($expiryKey);
            }
        }

        $completedSteps = session()->get($sessionKey, []);
        
        if (!in_array($stepIndex, $completedSteps)) {
            // Set expiry time 30 detik dari sekarang
            if (empty($completedSteps)) {
                session()->put($expiryKey, now()->addSeconds(30));
            }
            
            $completedSteps[] = $stepIndex;
            session()->put($sessionKey, $completedSteps);
            
            $activeAdNetworks = AdNetwork::where('is_active', 1)->get();
            $steps = $this->getStepsConfiguration($unlockLink, $activeAdNetworks);
            
            if (count($completedSteps) === count($steps)) {
                $unlockLink->increment('unlocks');
            }
        }

        return response()->json([
            'success' => true,
            'expires_at' => session($expiryKey),
            'current_time' => now()
        ]);
    }

    public function unlock(Request $request, $shortCode)
    {
        $unlockLink = UnlockLink::where('short_code', $shortCode)->firstOrFail();
    
        // Verify all steps are completed
        $activeAdNetworks = AdNetwork::where('status', 'active')->get();
        $steps = $this->getStepsConfiguration($unlockLink, $activeAdNetworks);
        $completedSteps = session()->get("completed_steps_{$shortCode}", []);
    
        if (count($completedSteps) === count($steps)) {
            // Mark as unlocked in session
            session()->put("unlocked_{$shortCode}", true);
        
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Not all steps completed']);
    }

    private function calculateConversionRate()
    {
        $totalViews = UnlockLink::sum('views');
        $totalUnlocks = UnlockLink::sum('unlocks');
        
        if ($totalViews > 0) {
            return round(($totalUnlocks / $totalViews) * 100, 1);
        }
        
        return 0;
    }

    private function getStepsConfiguration($unlockLink, $activeAdNetworks)
    {
        $completedSteps = session()->get("completed_steps_{$unlockLink->short_code}", []);
        $steps = [];
        $stepIndex = 0;

        $socialSteps = json_decode($unlockLink->social_requirements ?? '[]', true);
        
        if (empty($socialSteps)) {
            $socialSteps = [
                [
                    'type' => 'youtube_subscribe',
                    'title' => 'Subscribe to YouTube Channel',
                    'description' => 'Subscribe to our channel for the latest updates',
                    'url' => $unlockLink->youtube_url ?? 'https://youtube.com/@channel',
                    'required' => true
                ],
                [
                    'type' => 'instagram_follow',
                    'title' => 'Follow Instagram Account',
                    'description' => 'Follow us for behind-the-scenes content',
                    'url' => $unlockLink->instagram_url ?? 'https://instagram.com/account',
                    'required' => true
                ]
            ];
        }

        // Add social media steps
        foreach ($socialSteps as $socialStep) {
            if ($socialStep['required'] ?? true) {
                $steps[] = [
                    'index' => $stepIndex,
                    'type' => $socialStep['type'],
                    'title' => $socialStep['title'],
                    'description' => $socialStep['description'],
                    'url' => $socialStep['url'],
                    'color' => $this->getStepColor($socialStep['type']),
                    'icon' => $this->getStepIcon($socialStep['type']),
                    'button_text' => $this->getStepButtonText($socialStep['type']),
                    'completed' => in_array($stepIndex, $completedSteps),
                    'is_ad' => false,
                ];
                $stepIndex++;
            }
        }

        // Add advertisement steps from active ad networks
        foreach ($activeAdNetworks as $adNetwork) {
            $steps[] = [
                'index' => $stepIndex,
                'type' => 'advertisement',
                'title' => 'Watch Advertisement',
                'description' => "Support our platform by watching a {$adNetwork->duration}-second ad",
                'url' => null,
                'color' => 'bg-green-600',
                'icon' => 'play',
                'button_text' => 'Watch Ad',
                'completed' => in_array($stepIndex, $completedSteps),
                'is_ad' => true,
                'ad_network' => $adNetwork,
                'duration' => $adNetwork->duration,
                'ad_code' => $adNetwork->ad_code,
            ];
            $stepIndex++;
        }

        return $steps;
    }

    private function getStepColor($type)
    {
        return match($type) {
            'youtube_subscribe' => 'bg-red-600',
            'youtube_like' => 'bg-red-500',
            'instagram_follow' => 'bg-gradient-to-r from-pink-500 to-purple-600',
            'instagram_like' => 'bg-gradient-to-r from-pink-400 to-purple-500',
            'twitter_follow' => 'bg-blue-500',
            'twitter_retweet' => 'bg-blue-400',
            'facebook_like' => 'bg-blue-600',
            'facebook_share' => 'bg-blue-700',
            'tiktok_follow' => 'bg-black',
            'tiktok_like' => 'bg-gray-800',
            default => 'bg-gray-600'
        };
    }

    private function getStepIcon($type)
    {
        return match($type) {
            'youtube_subscribe', 'youtube_like' => 'youtube',
            'instagram_follow', 'instagram_like' => 'instagram',
            'twitter_follow', 'twitter_retweet' => 'twitter',
            'facebook_like', 'facebook_share' => 'facebook',
            'tiktok_follow', 'tiktok_like' => 'tiktok',
            default => 'link'
        };
    }

    private function getStepButtonText($type)
    {
        return match($type) {
            'youtube_subscribe' => 'Subscribe',
            'youtube_like' => 'Like Video',
            'instagram_follow' => 'Follow',
            'instagram_like' => 'Like Post',
            'twitter_follow' => 'Follow',
            'twitter_retweet' => 'Retweet',
            'facebook_like' => 'Like Page',
            'facebook_share' => 'Share Post',
            'tiktok_follow' => 'Follow',
            'tiktok_like' => 'Like Video',
            default => 'Complete'
        };
    }
}
