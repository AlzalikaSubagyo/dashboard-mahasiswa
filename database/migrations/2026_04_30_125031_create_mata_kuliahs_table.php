<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->integer('semester');
            $table->string('nama_matkul');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mata_kuliahs');
    }
};