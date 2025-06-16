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
            'propellerads' => [
                'name' => 'PropellerAds',
                'fields' => [
                    'public_key' => 'Public Key'
                ],
                'icon' => 'bolt',
                'color' => 'from-yellow-400 to-orange-500'
            ],
            'adsterra' => [
                'name' => 'Adsterra',
                'fields' => [
                    'public_key' => 'Public Key'
                ],
                'icon' => 'star',
                'color' => 'from-pink-500 to-red-500'
            ],
            'medianet' => [
                'name' => 'Media.net',
                'fields' => [
                    'site_id' => 'Site ID',
                    'api_key' => 'API Key'
                ],
                'icon' => 'globe',
                'color' => 'from-indigo-500 to-purple-500'
            ]
        ];

        return $configs[$provider] ?? null;
    }

    public static function getAllProviders()
    {
        return [
            'google' => self::getProviderConfig('google'),
            'propellerads' => self::getProviderConfig('propellerads'),
            'adsterra' => self::getProviderConfig('adsterra'),
            'medianet' => self::getProviderConfig('medianet'),
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
                case 'propellerads':
                    return $this->testPropellerAds();
                case 'adsterra':
                    return $this->testAdsterra();
                case 'medianet':
                    return $this->testMediaNet();
                default:
                    return ['success' => false, 'message' => 'Unknown or unsupported provider'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function testGoogleAds()
    {
        if (empty($this->credentials['client_id']) || empty($this->credentials['client_secret'])) {
            return ['success' => false, 'message' => 'Missing required credentials'];
        }

        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'client_id'     => $this->credentials['client_id'],
                    'client_secret' => $this->credentials['client_secret'],
                    'grant_type'    => 'client_credentials',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['access_token'])) {
                return ['success' => true, 'message' => 'Google Ads connection successful'];
            }

            return ['success' => false, 'message' => 'Failed to get access token'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'API Error: ' . $e->getMessage()];
        }
    }

    private function testPropellerAds()
    {
        if (empty($this->credentials['public_key'])) {
            return ['success' => false, 'message' => 'Missing Public Key'];
        }

        // Simulasi: misal harus diawali "pub-"
        if (strpos($this->credentials['public_key'], 'pub-') !== 0) {
            return ['success' => false, 'message' => 'Invalid Public Key format'];
        }

        // Kalau lolos, anggap valid
        return ['success' => true, 'message' => 'PropellerAds config valid (simulated)'];
    }

    private function testAdsterra()
    {
        if (empty($this->credentials['public_key'])) {
            return ['success' => false, 'message' => 'Missing Public Key'];
        }

        return ['success' => true, 'message' => 'Adsterra config valid (simulated)'];
    }

    private function testMediaNet()
    {
        if (empty($this->credentials['site_id']) || empty($this->credentials['api_key'])) {
            return ['success' => false, 'message' => 'Missing Site ID or API Key'];
        }

        // Simulasi: API Key minimal 20 karakter
        if (strlen($this->credentials['api_key']) < 20) {
            return ['success' => false, 'message' => 'API Key too short'];
        }

        return ['success' => true, 'message' => 'Media.net config valid (simulated)'];
    }
}