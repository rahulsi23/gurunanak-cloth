<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BrandingController extends Controller
{
    /**
     * Show the Visual Branding editor.
     */
    public function edit()
    {
        $settings = StoreSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.branding.edit', compact('settings'));
    }

    /**
     * Update Visual Branding assets and text configurations.
     */
    public function update(Request $request)
    {
        $request->validate([
            'logo_type' => 'required|in:text,image',
            'logo_text' => 'nullable|string|max:100',
            'logo_subtitle' => 'nullable|string|max:100',
            
            'footer_logo_type' => 'required|in:text,image',
            'footer_logo_text' => 'nullable|string|max:100',
            
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'footer_logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:1024',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'watermark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'default_shop_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'footer_qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            'facebook_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'pinterest_url' => 'nullable|string|max:255',
            'tiktok_url' => 'nullable|string|max:255',
        ]);

        $settings = [
            'logo_type' => $request->logo_type,
            'logo_text' => $request->logo_text ?? 'GURUNANAK',
            'logo_subtitle' => $request->logo_subtitle ?? 'CLOTH HOUSE',
            'footer_logo_type' => $request->footer_logo_type,
            'footer_logo_text' => $request->footer_logo_text ?? 'GURUNANAK',
            'facebook_url' => $request->facebook_url ?? '#',
            'instagram_url' => $request->instagram_url ?? '#',
            'twitter_url' => $request->twitter_url ?? '#',
            'linkedin_url' => $request->linkedin_url ?? '#',
            'youtube_url' => $request->youtube_url ?? '#',
            'pinterest_url' => $request->pinterest_url ?? '#',
            'tiktok_url' => $request->tiktok_url ?? '#',
        ];

        // Handle uploaded image files
        $fileKeys = ['logo_image', 'footer_logo_image', 'favicon', 'og_image', 'watermark', 'default_shop_banner', 'footer_qr_code'];
        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Delete previous file if exists to save storage space
                $oldPath = StoreSetting::where('key', $fileKey)->value('value');
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                // Store new file in 'branding' directory in the public disk
                $path = $request->file($fileKey)->store('branding', 'public');
                $settings[$fileKey] = $path;
            }
        }

        // Save key-value settings to store_settings table
        foreach ($settings as $key => $value) {
            StoreSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Flush and rebuild the cache globally for maximum PageSpeed
        Cache::forget('store_settings');
        Cache::rememberForever('store_settings', function () {
            return StoreSetting::all()->pluck('value', 'key')->toArray();
        });

        return redirect()->back()->with('success', 'Visual Branding assets and settings updated and cached successfully!');
    }
}
