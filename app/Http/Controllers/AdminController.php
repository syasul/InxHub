<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $settings = Setting::first();
        $links = Link::orderBy('sort_order', 'asc')->get();
        
        // Basic analytics
        $totalClicks = Link::sum('clicks_count');
        
        return view('admin.dashboard', compact('settings', 'links', 'totalClicks'));
    }

    /**
     * Update profile and social media settings.
     */
    public function updateSettings(Request $request)
    {
        $settings = Setting::first() ?? new Setting();
        
        $request->validate([
            'profile_name' => 'required|string|max:255',
            'profile_bio' => 'nullable|string|max:1000',
            'theme' => 'required|string',
            'profile_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'social_links' => 'nullable|array',
        ]);

        $settings->profile_name = $request->profile_name;
        $settings->profile_bio = $request->profile_bio;
        $settings->theme = $request->theme;

        // Handle avatar upload
        if ($request->hasFile('profile_avatar')) {
            // Delete old avatar if it exists and is not the default one
            if ($settings->profile_avatar && $settings->profile_avatar !== '/images/default-avatar.png') {
                $oldPath = public_path($settings->profile_avatar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('profile_avatar');
            $filename = 'avatar_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Ensure uploads directory exists
            $uploadPath = public_path('uploads');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $filename);
            $settings->profile_avatar = '/uploads/' . $filename;
        }

        // Handle social links
        $settings->social_links = $request->social_links ?? [];
        
        $settings->save();

        return back()->with('success', 'Profile and theme settings updated successfully!');
    }

    /**
     * Store a new custom link.
     */
    public function storeLink(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|string|max:255',
        ]);

        // Get highest sort order to put it at the bottom
        $maxOrder = Link::max('sort_order') ?? 0;

        Link::create([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon ?? 'link',
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Link added successfully!');
    }

    /**
     * Update the specified custom link.
     */
    public function updateLink(Request $request, Link $link)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $link->update([
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon ?? 'link',
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Link updated successfully!');
    }

    /**
     * Remove the specified custom link.
     */
    public function destroyLink(Link $link)
    {
        $link->delete();
        return back()->with('success', 'Link deleted successfully!');
    }

    /**
     * Reorder custom links.
     */
    public function reorderLinks(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:links,id',
        ]);

        foreach ($request->ids as $index => $id) {
            Link::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
