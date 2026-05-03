<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('jurusan');
            $table->integer('semester')->between(1, 7);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mahasiswas');
    }
};