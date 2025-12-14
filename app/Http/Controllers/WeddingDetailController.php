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

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:4096',
            'type' => 'required'
        ]);

        $prereq = auth()->user()->weddingPrerequisite;
        $user = auth()->user();

        // Rename file
        $extension = $request->file('file')->getClientOriginalExtension();
        $timestamp = now()->timestamp;
        $filename = "{$user->id}_{$request->type}_{$timestamp}.{$extension}";

        // Store file
        $path = $request->file('file')->storeAs(
            'prerequisite_docs',
            $filename,
            'public'
        );

        // Determine expiry (only HIV)
        $expiresAt = null;
        if ($request->type === 'hiv') {
            $expiresAt = now()->addMonths(6); // standard validity
        }

        // Save in database
        $prereq->documents()->create([
            'type' => $request->type,
            'file_path' => $path,
            'original_name' => $filename,
            'uploaded_at' => now(),
            'expires_at' => $expiresAt,
        ]);

        return back()->with('success', 'Dokumen berjaya dimuat naik!');
    }

}
