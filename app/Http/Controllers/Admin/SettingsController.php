<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $vendorCategories = Setting::where('key', 'vendor_categories')->first();
        $emailSender = Setting::where('key', 'email_sender')->first();

        return view('admin.settings.index', compact('vendorCategories', 'emailSender'));
    }

    public function updateCategories(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|string',
        ]);

        // Parse comma-separated categories
        $categories = array_map('trim', explode(',', $validated['categories']));

        Setting::updateOrCreate(
            ['key' => 'vendor_categories'],
            ['value' => json_encode($categories), 'group' => 'vendor']
        );

        return back()->with('success', 'Vendor categories updated');
    }

    public function updateEmailSender(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string',
            'sender_email' => 'required|email',
        ]);

        Setting::updateOrCreate(
            ['key' => 'email_sender'],
            [
                'value' => json_encode($validated),
                'group' => 'email'
            ]
        );

        return back()->with('success', 'Email sender information updated');
    }
}
