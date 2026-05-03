<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PklLapora extends Model
{
    protected $table = 'pkl_lapora'; // ← tambahkan ini

    protected $fillable = [
        'mahasiswa_id',
        'tanggal',
        'kegiatan',
        'status_validasi',
        'catatan_pembimbing'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
