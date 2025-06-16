<?php

namespace Database\Seeders;

use App\Models\UnlockLink;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@sub4unlock.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]
        );

        // Create demo unlock links
        UnlockLink::create([
            'title' => 'Premium Course Access',
            'description' => 'Unlock access to our advanced quantum computing course',
            'target_url' => 'https://example.com/premium-course',
            'short_code' => 'QC2200',
            'user_id' => $user->id,
            'views' => 1250,
            'unlocks' => 890,
            'status' => 'active',
            'social_requirements' => json_encode([
                [
                    'type' => 'youtube_subscribe',
                    'title' => 'Subscribe to YouTube Channel',
                    'description' => 'Subscribe to our quantum tech channel for the latest updates',
                    'url' => 'https://youtube.com/@quantumtech2200',
                    'required' => true
                ],
                [
                    'type' => 'instagram_follow',
                    'title' => 'Follow Instagram Account',
                    'description' => 'Follow us for behind-the-scenes content and updates',
                    'url' => 'https://instagram.com/quantumtech2200',
                    'required' => true
                ]
            ])
        ]);

        UnlockLink::create([
            'title' => 'Exclusive Ebook Download',
            'description' => 'Download our comprehensive guide to future technologies',
            'target_url' => 'https://example.com/ebook-download',
            'short_code' => 'EBOOK22',
            'user_id' => $user->id,
            'views' => 2100,
            'unlocks' => 1650,
            'status' => 'active',
            'social_requirements' => json_encode([
                [
                    'type' => 'youtube_subscribe',
                    'title' => 'Subscribe to Newsletter',
                    'description' => 'Get the latest updates and exclusive content',
                    'url' => 'https://newsletter.example.com',
                    'required' => true
                ]
            ])
        ]);

        UnlockLink::create([
            'title' => 'Demo Content',
            'description' => 'Experience the unlock process with our demo content',
            'target_url' => 'https://example.com/demo',
            'short_code' => 'DEMO',
            'user_id' => $user->id,
            'views' => 500,
            'unlocks' => 350,
            'status' => 'active',
            'social_requirements' => json_encode([])
        ]);
    }
}
