<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;

class MataKuliahSeeder extends Seeder {
    public function run(): void {
        $data = [
            1 => ['Pengantar Teknologi Informasi', 'Algoritma dan Pemrograman', 'Matematika Dasar', 'Logika Informatika', 'Sistem Digital', 'Bahasa Inggris'],
            2 => ['Struktur Data', 'Pemrograman Lanjut', 'Matematika Diskrit', 'Arsitektur Komputer', 'Basis Data Dasar', 'Sistem Operasi'],
            3 => ['Basis Data Lanjut', 'Pemrograman Berorientasi Objek (OOP)', 'Jaringan Komputer', 'Sistem Operasi Lanjut', 'Statistik', 'Interaksi Manusia dan Komputer'],
            4 => ['Pemrograman Web', 'Rekayasa Perangkat Lunak', 'Analisis & Perancangan Sistem', 'Data Mining (Dasar)', 'Keamanan Informasi', 'Grafika Komputer'],
            5 => ['Kecerdasan Buatan / Machine Learning', 'Pemrograman Mobile', 'Cloud Computing', 'Internet of Things (IoT)', 'Keamanan Jaringan', 'Mata Kuliah Pilihan'],
            6 => ['Teknologi Web', 'Metodologi Penelitian', 'Manajemen Proyek TI', 'Seminar Proposal', 'Mata Kuliah Pilihan Lanjutan'],
            7 => ['PKL / Magang', 'Laporan Harian', 'Penilaian Pembimbing'],
        ];

        foreach ($data as $semester => $matkuls) {
            foreach ($matkuls as $matkul) {
                MataKuliah::create(['semester' => $semester, 'nama_matkul' => $matkul]);
            }
        }
    }
}