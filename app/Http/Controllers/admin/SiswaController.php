<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class SiswaController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $response = [];
        $error = null;

        try {
            $httpResponse = Http::timeout(10)->get('https://6a02ab760d92f63dd253e7b4.mockapi.io/siswa');

            if ($httpResponse->successful()) {
                $data = $httpResponse->json();
                if (is_array($data)) {
                    $response = collect($data)->sortBy('id')->values()->all();
                } else {
                    $error = 'Format data dari server tidak valid.';
                }
            } else {
                $error = 'Server mengembalikan status ' . $httpResponse->status() . '. Silakan coba beberapa saat lagi.';
            }
        } catch (ConnectionException $e) {
            $error = 'Gagal terhubung ke server. Periksa koneksi internet Anda.';
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $response,
                'error' => $error,
            ], $error ? 500 : 200);
        }

        return view('admin.siswa', compact('response', 'error'));
    }
    public function store(\Illuminate\Http\Request $request)
    {
        try {
            $payload = $request->only([
                'nama',
                'kelas',
                'tempat_magang',
                'status',
                'avatar'
            ]);

            // Kirim data POST ke endpoint mockAPI
            $response = Http::post('https://6a02ab760d92f63dd253e7b4.mockapi.io/siswa', $payload);

            // Cek apakah respon dari MockAPI berhasil (Status 200/201)
            if ($response->successful()) {
                return response()->json($response->json(), 201);
            }

            // JIKA GAGAL: Kembalikan response detail dari MockAPI ke AJAX untuk proses debugging
            return response()->json([
                'error' => 'MockAPI menolak permintaan.',
                'detail' => $response->json() // Membaca error asli dari server MockAPI
            ], $response->status());
        } catch (\Exception $e) {
            // JIKA GAGAL DI LARAVEL (Misal internet putus atau error sintaks)
            return response()->json([
                'error' => 'Terjadi kesalahan pada server Laravel.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
