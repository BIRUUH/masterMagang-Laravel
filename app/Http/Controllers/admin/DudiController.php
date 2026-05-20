<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
// use Illuminate\Http\Request;

class DudiController extends Controller
{
    public function index()
    {
        $response = [];
        $error = null;

        try {
            $httpResponse = Http::timeout(10)->get('https://6a0a873221e445625696102c.mockapi.io/DUDI');

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

        return view('admin.dudi', compact('response', 'error'));
    }
}