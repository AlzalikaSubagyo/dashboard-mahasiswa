<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliahs';

    protected $fillable = ['semester', 'nama_matkul'];

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}