<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
// use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $response = [];
        $error = null;

        try {
            $httpResponse = Http::timeout(10)->get('https://6a02ab760d92f63dd253e7b4.mockapi.io/guru');

            if ($httpResponse->successful()) {
                $data = $httpResponse->json();
                if (is_array($data)) {
                    $response = $data;
                } else {
                    $error = 'Format data dari server tidak valid.';
                }
            } else {
                $error = 'Server mengembalikan status ' . $httpResponse->status() . '. Silakan coba beberapa saat lagi.';
            }
        } catch (ConnectionException $e) {
            $error = 'Gagal terhubung ke server. Periksa koneksi internet Anda.';
        }

        return view('admin.guru', compact('response', 'error'));
    }
}