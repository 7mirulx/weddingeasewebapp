<?php

namespace App\Services;

use App\Models\PrerequisiteStep;
use App\Models\WeddingPrerequisite;

class PrerequisiteService
{
    /**
     * Ensure all prerequisite steps exist for a user
     */
    public static function ensureForUser(int $userId): void
    {
        $steps = PrerequisiteStep::orderBy('step_order')->get();

        foreach ($steps as $step) {
            WeddingPrerequisite::firstOrCreate([
                'user_id' => $userId,
                'prerequisite_step_id' => $step->id,
            ]);
        }
    }
}
