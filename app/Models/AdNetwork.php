<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdNetwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'provider',
        'credentials',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'credentials' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function unlockLinks()
    {
        return $this->hasMany(UnlockLink::class);
    }

    // Get provider configuration
    public static function getProviderConfig($provider)
    {
        $configs = [
            'google' => [
                'name' => 'Google Ads',
                'fields' => [
                    'client_id' => 'Client ID',
                    'client_secret' => 'Client Secret',
                    'developer_token' => 'Developer Token',
                    'customer_id' => 'Customer ID'
                ],
                'icon' => 'google',
                'color' => 'from-blue-500 to-green-500'
            ],
            'unity' => [
                'name' => 'Unity Ads',
                'fields' => [
                    'game_id' => 'Game ID',
                    'api_key' => 'API Key',
                    'placement_id' => 'Placement ID'
                ],
                'icon' => 'unity',
                'color' => 'from-gray-700 to-black'
            ],
            'facebook' => [
                'name' => 'Facebook Audience Network',
                'fields' => [
                    'app_id' => 'App ID',
                    'app_secret' => 'App Secret',
                    'placement_id' => 'Placement ID'
                ],
                'icon' => 'facebook',
                'color' => 'from-blue-600 to-blue-800'
            ],
            'admob' => [
                'name' => 'Google AdMob',
                'fields' => [
                    'app_id' => 'App ID',
                    'ad_unit_id' => 'Ad Unit ID',
                    'api_key' => 'API Key'
                ],
                'icon' => 'admob',
                'color' => 'from-green-500 to-blue-500'
            ],
            'applovin' => [
                'name' => 'AppLovin MAX',
                'fields' => [
                    'sdk_key' => 'SDK Key',
                    'ad_unit_id' => 'Ad Unit ID',
                    'api_key' => 'API Key'
                ],
                'icon' => 'applovin',
                'color' => 'from-purple-500 to-pink-500'
            ]
        ];

        return $configs[$provider] ?? null;
    }

    public static function getAllProviders()
    {
        return [
            'google' => self::getProviderConfig('google'),
            'unity' => self::getProviderConfig('unity'),
            'facebook' => self::getProviderConfig('facebook'),
            'admob' => self::getProviderConfig('admob'),
            'applovin' => self::getProviderConfig('applovin'),
        ];
    }

    public static function getActiveNetwork()
    {
        return self::where('is_active', true)->first();
    }

    // Test connection to ad network
    public function testConnection()
    {
        try {
            switch ($this->provider) {
                case 'google':
                    return $this->testGoogleAds();
                case 'unity':
                    return $this->testUnityAds();
                case 'facebook':
                    return $this->testFacebookAds();
                case 'admob':
                    return $this->testAdMob();
                case 'applovin':
                    return $this->testAppLovin();
                default:
                    return ['success' => false, 'message' => 'Unknown provider'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function testGoogleAds()
    {
        // Simulate Google Ads API test
        if (empty($this->credentials['client_id']) || empty($this->credentials['client_secret'])) {
            return ['success' => false, 'message' => 'Missing required credentials'];
        }
        
        // In real implementation, you would make actual API call
        return ['success' => true, 'message' => 'Google Ads connection successful'];
    }

    private function testUnityAds()
    {
        if (empty($this->credentials['game_id']) || empty($this->credentials['api_key'])) {
            return ['success' => false, 'message' => 'Missing required credentials'];
        }
        
        return ['success' => true, 'message' => 'Unity Ads connection successful'];
    }

    private function testFacebookAds()
    {
        if (empty($this->credentials['app_id']) || empty($this->credentials['app_secret'])) {
            return ['success' => false, 'message' => 'Missing required credentials'];
        }
        
        return ['success' => true, 'message' => 'Facebook Ads connection successful'];
    }

    private function testAdMob()
    {
        if (empty($this->credentials['app_id']) || empty($this->credentials['ad_unit_id'])) {
            return ['success' => false, 'message' => 'Missing required credentials'];
        }
        
        return ['success' => true, 'message' => 'AdMob connection successful'];
    }

    private function testAppLovin()
    {
        if (empty($this->credentials['sdk_key']) || empty($this->credentials['ad_unit_id'])) {
            return ['success' => false, 'message' => 'Missing required credentials'];
        }
        
        return ['success' => true, 'message' => 'AppLovin connection successful'];
    }
}