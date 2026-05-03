<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = ['user_id', 'nama', 'nim', 'jurusan', 'semester'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function aktivitas()
    {
        return $this->hasMany(Aktivitas::class);
    }

    public function pklLapora()
    {
        return $this->hasMany(PklLapora::class);
    }

    public function persentaseKehadiran(): float
    {
        $total = $this->kehadirans()->count();
        if ($total === 0) return 100;
        $hadir = $this->kehadirans()->where('status', 'hadir')->count();
        return round(($hadir / $total) * 100, 1);
    }

    public function rataRataNilai(): float
    {
        return round($this->nilais()->avg('nilai') ?? 0, 1);
    }

    public function statusMonitoring(): string
    {
        $kehadiran = $this->persentaseKehadiran();
        $nilai = $this->rataRataNilai();

        if ($kehadiran < 75 || $nilai < 60) return 'risiko';
        if ($kehadiran < 85 || $nilai < 70) return 'waspada';
        return 'aman';
    }
}