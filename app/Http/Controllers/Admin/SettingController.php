<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Show the form for editing global store settings.
     */
    public function edit()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update global store settings and flush cache.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'announcement_text' => 'nullable|string|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:50',
            'whatsapp_phone' => 'nullable|string|max:50',
            'whatsapp_message' => 'nullable|string|max:500',
            'whatsapp_color' => 'nullable|string|max:20',
            'whatsapp_pulse' => 'nullable|string|max:5',
        ]);

        // Explicitly capture toggle value for active state
        $validated['whatsapp_enabled'] = $request->has('whatsapp_enabled') ? '1' : '0';

        foreach ($validated as $key => $value) {
            StoreSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // Flush and rebuild the cache instantly
        Cache::forget('store_settings');
        Cache::rememberForever('store_settings', function () {
            return StoreSetting::all()->pluck('value', 'key')->toArray();
        });

        return redirect()->back()->with('success', 'Global Store Settings, SMTP, and WhatsApp configurations updated successfully.');
    }

    /**
     * Real-time SMTP Connection Verification Tester.
     */
    public function testSmtp(Request $request)
    {
        $request->validate([
            'mail_from_name' => 'required|string|max:255',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_encryption' => 'required|string|max:50',
            'recipient' => 'required|email|max:255'
        ]);

        try {
            // Temporarily override Laravel Mail config values dynamically for validation
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $request->mail_host,
                'mail.mailers.smtp.port' => $request->mail_port,
                'mail.mailers.smtp.username' => $request->mail_username,
                'mail.mailers.smtp.password' => $request->mail_password,
                'mail.mailers.smtp.encryption' => $request->mail_encryption === 'None' ? null : strtolower($request->mail_encryption),
                'mail.from.address' => $request->mail_username,
                'mail.from.name' => $request->mail_from_name,
            ]);

            // Flush resolved mailer instances to enforce clean instantiation of the transport manager
            app()->forgetInstances();
            app()->make('mail.manager');

            // Send dynamic verification email
            \Illuminate\Support\Facades\Mail::raw('This is an automated verification email confirming that your SMTP server configuration on Gurunanak Panel is 100% correct, validated, and working!', function ($message) use ($request) {
                $message->to($request->recipient)
                    ->subject('SMTP Verification Test Successful! ✅');
            });

            return response()->json([
                'success' => true,
                'message' => 'SMTP settings verified! Test email sent successfully to ' . $request->recipient
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'SMTP Connection failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
