<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            // Tidak bisa absen 2x dalam 1 hari
            $table->unique(['mahasiswa_id', 'tanggal']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('kehadirans');
    }
};