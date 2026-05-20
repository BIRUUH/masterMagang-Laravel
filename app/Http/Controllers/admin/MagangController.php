<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MagangController extends Controller
{
    public function index()
    {
        // Simulasi data penempatan magang (Relasi antara Siswa, Guru, dan DUDI)
        $dataMagang = [
            [
                'nama_siswa' => 'Budi Santoso', 
                'industri' => 'PT. Teknologi Jaya', 
                'guru' => 'Ahmad Faisal, S.Kom.', 
                'periode' => '1 Jul - 30 Des 2026', 
                'status' => 'Berjalan'
            ],
            [
                'nama_siswa' => 'Siti Aminah', 
                'industri' => 'CV. Kreasi Web', 
                'guru' => 'Rina Melati, M.T.', 
                'periode' => '1 Jul - 30 Des 2026', 
                'status' => 'Persiapan'
            ]
        ];

        return view('admin.magang', compact('dataMagang'));
    }
}