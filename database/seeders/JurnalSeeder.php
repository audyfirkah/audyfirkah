<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurnal;

class JurnalSeeder extends Seeder
{
    public function run()
    {
        // Generate 50 jurnal entries
        Jurnal::factory()->count(5)->create();
    }
}
