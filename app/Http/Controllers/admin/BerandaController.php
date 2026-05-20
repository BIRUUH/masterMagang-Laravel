<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        // Simulasi data agregat/statistik untuk ditampilkan di Dashboard
        $statistik = [
            'total_siswa' => 156,
            'siswa_aktif_magang' => 120,
            'total_guru' => 12,
            'total_dudi' => 45
        ];

        // Simulasi data aktivitas terbaru untuk membuat dashboard lebih "hidup"
        $aktivitasTerbaru = [
            ['waktu' => '10 Menit yang lalu', 'deskripsi' => 'Budi Santoso memulai magang di PT. Teknologi Jaya', 'tipe' => 'success'],
            ['waktu' => '1 Jam yang lalu', 'deskripsi' => 'Guru Ahmad Faisal menambahkan jurnal bimbingan', 'tipe' => 'primary'],
            ['waktu' => '2 Jam yang lalu', 'deskripsi' => 'CV. Kreasi Web memperbarui kuota magang', 'tipe' => 'info'],
        ];

        return view('admin.beranda', compact('statistik', 'aktivitasTerbaru'));
    }
}