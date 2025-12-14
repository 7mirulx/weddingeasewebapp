<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrerequisiteStepsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prerequisite_steps')->insert([
            [
                'code' => 'kursus',
                'name' => 'Kursus Pra-Perkahwinan',
                'description' => 'Sahkan sijil kursus pra-perkahwinan',
                'requires_document' => true,
                'requires_expiry' => false,
                'step_order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'hiv',
                'name' => 'Ujian Saringan HIV',
                'description' => 'Sahkan keputusan ujian saringan HIV',
                'requires_document' => true,
                'requires_expiry' => true,
                'step_order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'borang',
                'name' => 'Borang Nikah Negeri',
                'description' => 'Isi dan sahkan borang nikah mengikut negeri',
                'requires_document' => true,
                'requires_expiry' => false,
                'step_order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'wali',
                'name' => 'Pengesahan Wali',
                'description' => 'Pengesahan maklumat wali',
                'requires_document' => false,
                'requires_expiry' => false,
                'step_order' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'kelulusan',
                'name' => 'Kelulusan Nikah',
                'description' => 'Kelulusan daripada Pejabat Agama',
                'requires_document' => false,
                'requires_expiry' => false,
                'step_order' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'akad',
                'name' => 'Akad Nikah',
                'description' => 'Akad nikah telah dilaksanakan',
                'requires_document' => false,
                'requires_expiry' => false,
                'step_order' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}