<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\WeddingPrerequisite;
use App\Models\WeddingPrerequisiteDocument;
use App\Services\PrerequisiteService;

class WeddingPrerequisiteController extends Controller
{
    /**
     * Display the pre-wedding checklist page (DB-driven).
     */
    public function index()
    {
        $user = auth()->user();

        // Ensure all prerequisite steps exist for this user
        PrerequisiteService::ensureForUser($user->id);

        // Fetch all prerequisites with step info
        $prerequisites = WeddingPrerequisite::with(['step', 'documents'])
            ->where('user_id', $user->id)
            ->orderBy('prerequisite_step_id')
            ->get();

        // Determine active step (first not completed)
        $activeId = optional(
            $prerequisites->first(fn ($p) => !$p->isCompleted())
        )->id;

        // Attach UI helper flags
        $prerequisites->each(function ($item) use ($activeId) {
            $item->is_active = $item->id === $activeId;
            $item->is_locked = !$item->is_active && !$item->isCompleted();
        });

        // Progress calculation
        $completed = $prerequisites->filter(fn ($p) => $p->isCompleted())->count();
        $progress = $prerequisites->count() > 0
            ? round(($completed / $prerequisites->count()) * 100)
            : 0;

        return view('preweddingpreparation', compact(
            'prerequisites',
            'progress'
        ));
    }

    /**
     * Update a prerequisite step status (AJAX).
     */
    public function update(Request $request, WeddingPrerequisite $prerequisite)
    {
        // Security: ensure ownership
        if ($prerequisite->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $request->validate([
            'status' => 'required|string',
        ]);

        $prerequisite->update([
            'status' => $request->input('status'),
            'completed_at' => in_array($request->status, ['completed', 'approved'])
                ? now()
                : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Step updated successfully.',
        ]);
    }

    /**
     * Upload document for a prerequisite step (AJAX).
     */
    public function uploadDocument(Request $request, WeddingPrerequisite $prerequisite)
    {
        // Security check
        if ($prerequisite->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $request->validate([
            'document' => 'required|file|max:5120', // 5MB
        ]);

        $file = $request->file('document');

        // Store file
        $path = $file->store(
            'wedding_prerequisites/' . auth()->id(),
            'public'
        );

        // Save document record
        WeddingPrerequisiteDocument::create([
            'wedding_prerequisite_id' => $prerequisite->id,
            'type' => $prerequisite->step->code,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'uploaded_at' => now(),
            'expires_at' => $prerequisite->step->requires_expiry
                ? now()->addMonths(6) // example for HIV expiry
                : null,
        ]);

        // Update step status
        $prerequisite->update([
            'status' => 'submitted',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully.',
        ]);
    }

    /**
     * Delete an uploaded document (AJAX).
     */
    public function deleteDocument(WeddingPrerequisiteDocument $document)
    {
        // Ensure ownership
        if ($document->prerequisite->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        // Delete file from storage
        Storage::disk('public')->delete($document->file_path);

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully.',
        ]);
    }
}
