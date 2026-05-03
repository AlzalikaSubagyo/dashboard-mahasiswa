<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model {
    protected $fillable = ['mahasiswa_id', 'aktivitas', 'waktu'];
    protected $casts = ['waktu' => 'datetime'];

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }
}