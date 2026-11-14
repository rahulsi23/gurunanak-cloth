<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalesChannelController extends Controller
{
    /**
     * Display a listing of the sales channels.
     */
    public function index()
    {
        $channels = SalesChannel::all();
        return view('admin.sales-channels.index', compact('channels'));
    }

    /**
     * Store a newly created sales channel.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2000',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'url' => $request->url,
        ];

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = 'sales-channels/' . time() . '-' . uniqid() . '.webp';

            if (!Storage::disk('public')->exists('sales-channels')) {
                Storage::disk('public')->makeDirectory('sales-channels');
            }

            $destinationPath = storage_path('app/public/' . $filename);

            if ($extension === 'webp') {
                $file->storeAs('sales-channels', basename($filename), 'public');
            } else {
                $imagePath = $file->getRealPath();
                $image = null;

                if ($extension === 'jpg' || $extension === 'jpeg') {
                    $image = @imagecreatefromjpeg($imagePath);
                } elseif ($extension === 'png') {
                    $image = @imagecreatefrompng($imagePath);
                    if ($image) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                    }
                } elseif ($extension === 'gif') {
                    $image = @imagecreatefromgif($imagePath);
                }

                if ($image) {
                    @imagewebp($image, $destinationPath, 90);
                    @imagedestroy($image);
                } else {
                    $filename = $file->store('sales-channels', 'public');
                }
            }

            $data['icon'] = $filename;
        }

        SalesChannel::create($data);

        return redirect()->route('admin.sales-channels.index')->with('success', 'Sales channel created successfully!');
    }

    /**
     * Update the specified sales channel.
     */
    public function update(Request $request, SalesChannel $salesChannel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2000',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'url' => $request->url,
        ];

        if ($request->hasFile('icon')) {
            // Delete old icon file if exists to save storage space
            if ($salesChannel->icon && Storage::disk('public')->exists($salesChannel->icon)) {
                Storage::disk('public')->delete($salesChannel->icon);
            }

            $file = $request->file('icon');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = 'sales-channels/' . time() . '-' . uniqid() . '.webp';

            if (!Storage::disk('public')->exists('sales-channels')) {
                Storage::disk('public')->makeDirectory('sales-channels');
            }

            $destinationPath = storage_path('app/public/' . $filename);

            if ($extension === 'webp') {
                $file->storeAs('sales-channels', basename($filename), 'public');
            } else {
                $imagePath = $file->getRealPath();
                $image = null;

                if ($extension === 'jpg' || $extension === 'jpeg') {
                    $image = @imagecreatefromjpeg($imagePath);
                } elseif ($extension === 'png') {
                    $image = @imagecreatefrompng($imagePath);
                    if ($image) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                    }
                } elseif ($extension === 'gif') {
                    $image = @imagecreatefromgif($imagePath);
                }

                if ($image) {
                    @imagewebp($image, $destinationPath, 90);
                    @imagedestroy($image);
                } else {
                    $filename = $file->store('sales-channels', 'public');
                }
            }

            $data['icon'] = $filename;
        }

        $salesChannel->update($data);

        return redirect()->route('admin.sales-channels.index')->with('success', 'Sales channel updated successfully!');
    }

    /**
     * Remove the specified sales channel.
     */
    public function destroy(SalesChannel $salesChannel)
    {
        // Delete physical icon file from storage disk
        if ($salesChannel->icon && Storage::disk('public')->exists($salesChannel->icon)) {
            Storage::disk('public')->delete($salesChannel->icon);
        }

        $salesChannel->delete();

        return redirect()->route('admin.sales-channels.index')->with('success', 'Sales channel deleted successfully!');
    }
}
