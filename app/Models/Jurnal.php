<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'status_absen',
        'kegiatan',
        'hasil',
    ];

    protected $dates = [
        'tanggal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
