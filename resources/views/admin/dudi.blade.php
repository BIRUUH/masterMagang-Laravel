@extends('components.main')

@section('title', 'Manajemen DUDI')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 fw-bold">Manajemen DUDI</h1>
        <p class="text-muted small mt-1">Daftar data DUDI yang terdaftar dalam sistem</p>
    </div>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-2"></i>Tambah DUDI</button>
</div>

@if($error)
<div class="card border-0 rounded-3 mb-4 bg-danger bg-opacity-10">
    <div class="card-body p-4 d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-2 me-3"></i>
        <div>
            <h5 class="fw-bold text-danger mb-1">Gagal Mengambil Data</h5>
            <p class="text-danger mb-0">{{ $error }}</p>
        </div>
    </div>
</div>
@else
<div class="row g-4">
    @forelse ($response as $dudi)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3 text-primary">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ $dudi['nama_dudi'] }}</h5>
                        <small class="{{ $dudi['status'] === 'Aktif' ? 'text-success' : 'text-danger' }}">{{ $dudi['status'] }}</small>
                    </div>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-geo-alt me-2"></i>{{ $dudi['alamat'] }}</p>
                <p class="text-muted small mb-3"><i class="bi bi-envelope me-2"></i>{{ $dudi['email_perusahaan'] }}</p>
                <p class="text-muted small mb-3"><i class="bi bi-telephone me-2"></i>{{ $dudi['no_telepon'] }}</p>
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-people me-1"></i> Kuota: {{ $dudi['kuota'] }}</span>
                    <div>
                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5 text-muted">Belum ada data DUDI.</div>
    </div>
    @endforelse
</div>
@endif
@endsection