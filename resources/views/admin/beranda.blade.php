@extends('components.main')

@section('title', 'Dashboard Utama Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 fw-bold mb-0">Dashboard</h1>
        <p class="text-muted small mt-1">Ringkasan aktivitas dan data Sistem Informasi MagangMaster.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Total Siswa -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-muted mb-2">Total Siswa</h6>
                        <h2 class="fw-bold mb-0" id="stat_total_siswa">
                            <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                        </h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Siswa Aktif Magang -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-muted mb-2">Siswa Aktif Magang</h6>
                        <h2 class="fw-bold mb-0" id="stat_siswa_aktif">
                            <span class="spinner-border spinner-border-sm text-success" role="status" aria-hidden="true"></span>
                        </h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                        <i class="bi bi-person-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guru Pembimbing -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-muted mb-2">Guru Pembimbing</h6>
                        <h2 class="fw-bold mb-0" id="stat_total_guru">
                            <span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true"></span>
                        </h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                        <i class="bi bi-person-badge fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mitra Industri (DUDI) -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-muted mb-2">Mitra Industri (DUDI)</h6>
                        <h2 class="fw-bold mb-0" id="stat_total_dudi">
                            <span class="spinner-border spinner-border-sm text-info" role="status" aria-hidden="true"></span>
                        </h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 text-info">
                        <i class="bi bi-buildings fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0">Aktivitas Sistem Terbaru</h6>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush">
                    @foreach($aktivitasTerbaru as $aktivitas)
                    <li class="list-group-item px-0 py-3 border-light">
                        <div class="d-flex align-items-center">
                            <div class="bg-{{ $aktivitas['tipe'] }} rounded-circle me-3" style="width: 10px; height: 10px;"></div>
                            <div class="grow">
                                <p class="mb-0 fw-semibold text-dark">{{ $aktivitas['deskripsi'] }}</p>
                                <small class="text-muted">{{ $aktivitas['waktu'] }}</small>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $.ajax({
            url: '{{ route("admin.siswa.data") }}',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.data) {
                    const totalSiswa = response.data.length;
                    const aktifSiswa = response.data.filter(function (siswa) {
                        return siswa.status === 'aktif';
                    }).length;

                    $('#stat_total_siswa').text(totalSiswa);
                    $('#stat_siswa_aktif').text(aktifSiswa);
                } else {
                    $('#stat_total_siswa').text('Error');
                    $('#stat_siswa_aktif').text('Error');
                }
            },
            error: function () {
                $('#stat_total_siswa').text('Error');
                $('#stat_siswa_aktif').text('Error');
            }
        });

        $.ajax({
            url: '{{ route("admin.guru.data") }}',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.data) {
                    $('#stat_total_guru').text(response.data.length);
                } else {
                    $('#stat_total_guru').text('Error');
                }
            },
            error: function () {
                $('#stat_total_guru').text('Error');
            }
        });

        $.ajax({
            url: '{{ route("admin.dudi.data") }}',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.data) {
                    $('#stat_total_dudi').text(response.data.length);
                } else {
                    $('#stat_total_dudi').text('Error');
                }
            },
            error: function () {
                $('#stat_total_dudi').text('Error');
            }
        });
    });
</script>
@endsection