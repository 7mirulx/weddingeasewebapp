<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeddingDetail;

class WeddingDetailController extends Controller
{
    public function create()
    {
        return view('wedding.setup');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'partner_name'         => 'nullable|string|max:255',
            'wedding_date'         => 'nullable|date',
            'preference_priority'  => 'required|in:budget,quality,balanced,service,popularity',
            'wedding_theme'        => 'nullable|string|max:255',
            'wedding_size'         => 'nullable|integer',
            'budget'               => 'nullable|numeric',
            'venue_state'          => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        WeddingDetail::create($validated);

        return redirect('/dashboard')->with('success', 'Wedding details saved!');
    }
}
