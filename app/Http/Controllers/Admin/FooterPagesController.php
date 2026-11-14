<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FooterPagesController extends Controller
{
    /**
     * Show the About Us page content editor.
     */
    public function editAbout()
    {
        $settings = StoreSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.footer-pages.about', compact('settings'));
    }

    /**
     * Update About Us page contents.
     */
    public function updateAbout(Request $request)
    {
        $request->validate([
            'about_heading' => 'required|string|max:255',
            'about_content' => 'required|string',
            'about_story_block_title' => 'nullable|string|max:255',
            'about_story_block_content' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'about_story_block_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'about_meta_title' => 'nullable|string|max:255',
            'about_meta_description' => 'nullable|string',
            'about_meta_keywords' => 'nullable|string',
        ]);

        $settings = [
            'about_heading' => $request->about_heading,
            'about_content' => $request->about_content,
            'about_story_block_title' => $request->about_story_block_title ?? '',
            'about_story_block_content' => $request->about_story_block_content ?? '',
            'about_meta_title' => $request->about_meta_title ?? 'About Our Studio | GURUNANAK',
            'about_meta_description' => $request->about_meta_description ?? '',
            'about_meta_keywords' => $request->about_meta_keywords ?? '',
        ];

        // Handle uploaded image files
        $fileKeys = ['about_image', 'about_story_block_image'];
        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Delete old file if exists
                $oldPath = StoreSetting::where('key', $fileKey)->value('value');
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $path = $request->file($fileKey)->store('branding', 'public');
                $settings[$fileKey] = $path;
            }
        }

        // Save settings
        foreach ($settings as $key => $value) {
            StoreSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear Settings Cache
        Cache::forget('store_settings');
        Cache::rememberForever('store_settings', function () {
            return StoreSetting::all()->pluck('value', 'key')->toArray();
        });

        // Clear cached SEO for '/about' page key
        Cache::forget('seo_about');

        return redirect()->back()->with('success', 'About Us page builder content updated successfully!');
    }

    /**
     * Show the Contact Us page content editor.
     */
    public function editContact()
    {
        $settings = StoreSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.footer-pages.contact', compact('settings'));
    }

    /**
     * Update Contact Us page contents.
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_heading' => 'required|string|max:255',
            'contact_content' => 'required|string',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:100',
            'contact_address' => 'required|string|max:500',
            'contact_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'contact_meta_title' => 'nullable|string|max:255',
            'contact_meta_description' => 'nullable|string',
            'contact_meta_keywords' => 'nullable|string',
        ]);

        $settings = [
            'contact_heading' => $request->contact_heading,
            'contact_content' => $request->contact_content,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_address' => $request->contact_address,
            'contact_meta_title' => $request->contact_meta_title ?? 'Connect With Us | GURUNANAK',
            'contact_meta_description' => $request->contact_meta_description ?? '',
            'contact_meta_keywords' => $request->contact_meta_keywords ?? '',
        ];

        // Handle uploaded image files
        if ($request->hasFile('contact_image')) {
            $oldPath = StoreSetting::where('key', 'contact_image')->value('value');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('contact_image')->store('branding', 'public');
            $settings['contact_image'] = $path;
        }

        // Save settings
        foreach ($settings as $key => $value) {
            StoreSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear Settings Cache
        Cache::forget('store_settings');
        Cache::rememberForever('store_settings', function () {
            return StoreSetting::all()->pluck('value', 'key')->toArray();
        });

        // Clear cached SEO for '/contact' page key
        Cache::forget('seo_contact');

        return redirect()->back()->with('success', 'Contact Us page builder content updated successfully!');
    }
}
