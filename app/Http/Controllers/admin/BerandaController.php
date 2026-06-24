<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        $aktivitasTerbaru = [
            ['waktu' => '10 Menit yang lalu', 'deskripsi' => 'Budi Santoso memulai magang di PT. Teknologi Jaya', 'tipe' => 'success'],
            ['waktu' => '1 Jam yang lalu', 'deskripsi' => 'Guru Ahmad Faisal menambahkan jurnal bimbingan', 'tipe' => 'primary'],
            ['waktu' => '2 Jam yang lalu', 'deskripsi' => 'CV. Kreasi Web memperbarui kuota magang', 'tipe' => 'info'],
        ];

        return view('admin.beranda', compact('aktivitasTerbaru'));
    }
}
