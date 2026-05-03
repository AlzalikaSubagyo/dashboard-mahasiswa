<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model {
    protected $fillable = ['mahasiswa_id', 'tanggal', 'status', 'keterangan'];
    protected $casts = ['tanggal' => 'date'];

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }
}