@extends('components.main')

@section('title', 'Manajemen Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 fw-bold mb-0">Manajemen Penempatan Magang</h1>
        <p class="text-muted small mt-1">Atur penempatan siswa ke industri beserta guru pembimbingnya.</p>
    </div>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-link-45deg me-2"></i>Buat Penempatan</button>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3">Nama Siswa</th>
                        <th>Industri (DUDI)</th>
                        <th>Guru Pembimbing</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-semibold">Budi Santoso</td>
                        <td><i class="bi bi-building text-primary me-2"></i>PT. Teknologi Jaya</td>
                        <td>Ahmad Faisal, S.Kom.</td>
                        <td><small class="text-muted">1 Jul - 30 Des 2026</small></td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Berjalan</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-dark">Log Jurnal <i class="bi bi-arrow-right ms-1"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection