<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /* Base URL endpoint MockAPI untuk data guru.*/
    private string $apiUrl = 'https://6a02ab760d92f63dd253e7b4.mockapi.io/guru';

    /* Render halaman view guru (tanpa fetch data | data diambil via AJAX).*/
    public function index()
    {
        return view('admin.guru');
    }

    /* AJAX Endpoint: Ambil semua data guru dari MockAPI dan kembalikan sebagai JSON.
     * Dipanggil oleh frontend via $.ajax GET /admin/guru/data*/
    public function getData()
    {
        try {
            $httpResponse = Http::timeout(10)->get($this->apiUrl);

            if ($httpResponse->successful()) {
                $data = $httpResponse->json();

                if (is_array($data)) {
                    $sorted = collect($data)->sortBy('id')->values()->all();
                    return response()->json(['data' => $sorted], 200);
                }

                return response()->json(['error' => 'Format data dari server tidak valid.'], 500);
            }

            return response()->json([
                'error' => 'Server mengembalikan status ' . $httpResponse->status() . '. Silakan coba beberapa saat lagi.'
            ], $httpResponse->status());

        } catch (ConnectionException $e) {
            return response()->json([
                'error' => 'Gagal terhubung ke server. Periksa koneksi internet Anda.'
            ], 503);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan pada server.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* AJAX Endpoint: Tambah data guru baru ke MockAPI.
     * Dipanggil via $.ajax POST /admin/guru*/
    public function store(Request $request)
    {
        try {
            $payload = $request->only(['nama_guru', 'bidang_keahlian', 'email', 'status']);

            $response = Http::post($this->apiUrl, $payload);

            if ($response->successful()) {
                return response()->json($response->json(), 201);
            }

            return response()->json([
                'error' => 'MockAPI menolak permintaan.',
                'detail' => $response->json()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan pada server Laravel.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* AJAX Endpoint: Update data guru berdasarkan ID di MockAPI.
     * Dipanggil via $.ajax PUT /admin/guru/{id}*/
    public function update(Request $request, $id)
    {
        try {
            $payload = $request->only(['nama_guru', 'bidang_keahlian', 'email', 'status']);

            $response = Http::put($this->apiUrl . '/' . $id, $payload);

            if ($response->successful()) {
                return response()->json($response->json(), 200);
            }

            return response()->json([
                'error' => 'MockAPI menolak permintaan update.',
                'detail' => $response->json()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan pada server Laravel.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* AJAX Endpoint: Hapus data guru berdasarkan ID dari MockAPI.
     * Dipanggil via $.ajax DELETE /admin/guru/{id}*/
    public function destroy($id)
    {
        try {
            $response = Http::delete($this->apiUrl . '/' . $id);

            if ($response->successful()) {
                return response()->json(['message' => 'Data guru berhasil dihapus.'], 200);
            }

            return response()->json([
                'error' => 'MockAPI menolak permintaan hapus.',
                'detail' => $response->json()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan pada server Laravel.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}