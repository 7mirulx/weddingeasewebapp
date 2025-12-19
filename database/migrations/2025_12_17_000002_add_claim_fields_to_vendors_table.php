<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL: Drop old constraint and add new enum type
        Schema::table('vendors', function (Blueprint $table) {
            // Drop the old check constraint on status
            DB::statement('ALTER TABLE vendors DROP CONSTRAINT IF EXISTS vendors_status_check');
            
            // Add new enum values to existing type or recreate
            DB::statement("
                ALTER TABLE vendors 
                ALTER COLUMN status TYPE varchar(255),
                ADD CONSTRAINT vendors_status_check 
                CHECK (status IN ('unclaimed', 'claimed', 'active', 'inactive', 'pending', 'suspended'))
            ");
            
            // Add claim-related fields
            if (!Schema::hasColumn('vendors', 'claimed_at')) {
                $table->timestamp('claimed_at')->nullable()->after('owner_user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            // Revert constraint
            DB::statement('ALTER TABLE vendors DROP CONSTRAINT IF EXISTS vendors_status_check');
            DB::statement("
                ALTER TABLE vendors 
                ADD CONSTRAINT vendors_status_check 
                CHECK (status IN ('active', 'inactive', 'pending'))
            ");
            
            // Drop claim fields
            if (Schema::hasColumn('vendors', 'claimed_at')) {
                $table->dropColumn('claimed_at');
            }
        });
    }
};
