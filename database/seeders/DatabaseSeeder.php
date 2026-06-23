<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Link;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed the Admin user
        User::updateOrCreate(
            ['email' => 'admin@linktree.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Seed Default Settings
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'profile_name' => 'INXDVI',
                'profile_bio' => 'We build high-performance digital products, immersive web platforms, and premium brand identities. Let\'s create something remarkable.',
                'profile_avatar' => '/images/default-avatar.png',
                'theme' => 'inxdvi-dark',
                'social_links' => [
                    'instagram' => 'inxdvi',
                    'tiktok' => 'inxdvi',
                    'github' => 'inxdvi',
                    'linkedin' => 'company/inxdvi',
                    'twitter' => 'inxdvi',
                    'youtube' => '@inxdvi',
                    'whatsapp' => '6281234567890',
                ]
            ]
        );

        // 3. Seed Starter Links
        Link::truncate();
        
        Link::create([
            'title' => '🌐 Visit Our Official Website',
            'url' => 'https://inxdvi.com',
            'icon' => 'globe',
            'is_active' => true,
            'sort_order' => 1,
            'clicks_count' => 124,
        ]);

        Link::create([
            'title' => '💼 Explore Case Studies & Work',
            'url' => 'https://inxdvi.com/portfolio',
            'icon' => 'briefcase',
            'is_active' => true,
            'sort_order' => 2,
            'clicks_count' => 88,
        ]);

        Link::create([
            'title' => '📬 Hire Us / Get a Quote',
            'url' => 'https://inxdvi.com/contact',
            'icon' => 'mail',
            'is_active' => true,
            'sort_order' => 3,
            'clicks_count' => 45,
        ]);
    }
}
