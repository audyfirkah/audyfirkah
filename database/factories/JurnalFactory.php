<?php

namespace Database\Factories;

use App\Models\Jurnal;
use Illuminate\Database\Eloquent\Factories\Factory;

class JurnalFactory extends Factory
{
    protected $model = Jurnal::class;

    public function definition()
    {
        return [
            'tanggal' => $this->faker->date(),
            'status_absen' => $this->faker->randomElement(['Hadir', 'Tidak Hadir']),
            'kegiatan' => $this->faker->paragraph,
            'hasil' => $this->faker->optional()->imageUrl(640, 480, 'business'), // Optional hasil gambar
        ];
    }
}
