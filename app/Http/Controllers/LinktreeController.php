<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Setting;
use Illuminate\Http\Request;

class LinktreeController extends Controller
{
    /**
     * Show the public profile page.
     */
    public function show()
    {
        $settings = Setting::first();
        
        // If settings don't exist yet, we can create empty defaults
        if (!$settings) {
            $settings = Setting::create([
                'profile_name' => 'My Linktree',
                'profile_bio' => 'Welcome to my links page.',
                'theme' => 'glass-3d-dark',
                'social_links' => [],
            ]);
        }

        $links = Link::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('welcome', compact('settings', 'links'));
    }

    /**
     * Track click on a link and redirect.
     */
    public function redirect(Link $link)
    {
        // Increment clicks
        $link->increment('clicks_count');
        
        // Redirect to target URL
        return redirect()->away($link->url);
    }
}
