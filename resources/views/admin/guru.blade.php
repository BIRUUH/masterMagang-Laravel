@extends('components.main')

@section('title', 'Manajemen Guru Pembimbing')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 fw-bold">Manajemen Guru Pembimbing</h1>
        <p class="text-muted small mt-1">Daftar data guru pembimbing yang terdaftar dalam sistem</p>
    </div>
    <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-2"></i>Tambah Guru</button>
</div>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nama Guru</th>
                        <th>Bidang Keahlian</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($response as $guru)
                    <tr>
                        <td class="ps-4">{{ $guru['id'] }}</td>
                        <td class="fw-semibold">{{ $guru['nama_guru'] }}</td>
                        <td>{{ $guru['bidang_keahlian'] }}</td>
                        <td>{{ $guru['no_telepon'] }}</td>
                        <td><span class="badge bg-primary rounded-s-full">{{ $guru['email'] }}</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light text-primary border"><i
                                    class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light text-danger border"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data guru pembimbing.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection