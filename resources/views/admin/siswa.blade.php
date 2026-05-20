@extends('components.main')

@section('title', 'Manajemen Siswa')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <div>
            <h1 class="h2 fw-bold">Manajemen Siswa</h1>
            <p class="text-muted small mt-1">Daftar data siswa yang terdaftar dalam sistem.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
            <i class="bi bi-plus-lg me-2"></i>Tambah Siswa
        </button>
    </div>

    <div id="siswaError" class="card border-0 rounded-3 mb-4 bg-danger bg-opacity-10 d-none">
        <div class="card-body p-4 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-2 me-3"></i>
            <div>
                <h5 class="fw-bold text-danger mb-1">Gagal Mengambil Data</h5>
                <p class="text-danger mb-0" id="siswaErrorMessage"></p>
            </div>
        </div>
    </div>

    {{-- Tabel Data Siswa --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">Id</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Tempat Magang</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="siswaTableBody">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Siswa --}}
    <div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahSiswaLabel">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahSiswa">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Contoh: XI RPL 1"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="tempat_magang" class="form-label">Tempat Magang</label>
                            <input type="text" class="form-control" id="tempat_magang" name="tempat_magang" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Aktif Magang">Aktif Magang</option>
                                <option value="Tidak Aktif Magang">Tidak Aktif Magang</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <span class="spinner-border spinner-border-sm d-none" id="loadingSimpan" role="status"
                                aria-hidden="true"></span>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- Scripts --}}
@section('scripts')
    <script>
        $(document).ready(function () {
            function renderRows(data) {
                if (!data || !data.length) {
                    return `
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data siswa.</td>
                        </tr>
                    `;
                }

                return data.map(function (siswa) {
                    let badgeClass = siswa.status === 'Aktif Magang' ? 'bg-success text-success' : 'bg-warning text-warning';

                    return `
                        <tr>
                            <td class="ps-4">${siswa.id}</td>
                            <td class="fw-semibold">${siswa.nama}</td>
                            <td>${siswa.kelas}</td>
                            <td>${siswa.tempat_magang}</td>
                            <td><span class="badge bg-opacity-10 ${badgeClass} px-3 py-2 rounded-s-full">${siswa.status}</span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light text-primary border"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-light text-danger border"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            function loadSiswa() {
                $.ajax({
                    url: '{{ route("admin.siswa.index") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        $('#siswaError').addClass('d-none');
                        $('#siswaTableBody').html(renderRows(result.data));
                    },
                    error: function (xhr) {
                        let message = xhr.responseJSON?.error || 'Terjadi kesalahan sistem';
                        $('#siswaErrorMessage').text(message);
                        $('#siswaError').removeClass('d-none');
                        $('#siswaTableBody').html(renderRows([]));
                    }
                });
            }

            loadSiswa();

            $('#formTambahSiswa').on('submit', function (e) {
                e.preventDefault(); // Mencegah halaman reload

                // Ambil elemen
                let btnSimpan = $('#btnSimpan');
                let loadingSimpan = $('#loadingSimpan');
                let form = $(this);

                // Siapkan data manual karena kita butuh menambahkan 'avatar'
                let formData = {
                    nama: $('#nama').val(),
                    kelas: $('#kelas').val(),
                    tempat_magang: $('#tempat_magang').val(),
                    status: $('#status').val(),
                    avatar: "https://cdn.jsdelivr.net/gh/faker-js/assets-person-portrait/male/512/10.jpg"
                };

                // Kirim request AJAX dengan jQuery
                $.ajax({
                    url: '{{ route("admin.siswa.store") }}',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Wajib di Laravel
                    },
                    beforeSend: function () {
                        // Tampilkan efek loading sebelum request dikirim
                        btnSimpan.prop('disabled', true);
                        loadingSimpan.removeClass('d-none');
                    },
                    success: function (result) {
                        if (result.id) {
                            // 1. Tutup modal (menggunakan API Bootstrap)
                            $('#modalTambahSiswa').modal('hide');

                            // 2. Reset form
                            form[0].reset();

                            // 3. Refresh data agar urut berdasarkan ID
                            loadSiswa();

                            alert('Data berhasil ditambahkan!');
                        }
                    },
                    error: function (xhr) {
                        // Menampilkan pesan error asli dari Controller ke dalam Console Browser
                        console.error("Error Detail:", xhr.responseJSON);
                        alert('Gagal: ' + (xhr.responseJSON?.error || 'Terjadi kesalahan sistem'));
                    },
                    complete: function () {
                        // Matikan efek loading setelah request selesai (baik berhasil/gagal)
                        btnSimpan.prop('disabled', false);
                        loadingSimpan.addClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection