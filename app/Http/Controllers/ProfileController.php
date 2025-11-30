<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeddingDetail;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wedding = $user->weddingDetails;

        return view('profile', compact('user', 'wedding'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $user = auth()->user();
        $user->update($request->only('name','phone'));

        return back()->with('success', 'Profile updated!');
    }

    public function updateWedding(Request $request)
    {
        $validated = $request->validate([
            'partner_name' => 'nullable|string|max:255',
            'wedding_date' => 'nullable|date',
            'preference_priority' => 'nullable|string',
            'wedding_theme' => 'nullable|string',
            'wedding_size' => 'nullable|integer',
            'budget' => 'nullable|numeric',
            'venue_state' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        WeddingDetail::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return back()->with('success', 'Wedding details updated!');
    }
}
