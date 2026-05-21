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

    <!-- Alert Error Fetch Data -->
    <div id="siswaError" class="card border-0 rounded-3 mb-4 bg-danger bg-opacity-10 d-none">
        <div class="card-body p-4 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-2 me-3"></i>
            <div>
                <h5 class="fw-bold text-danger mb-1">Gagal Mengambil Data</h5>
                <p class="text-danger mb-0" id="siswaErrorMessage"></p>
            </div>
        </div>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">Id</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="siswaTableBody">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Toast Container (pojok kanan atas) -->
    <div class="toast-container position-fixed top-0 end p-3" style="z-index: 1100;">
        <div id="toastNotif" class="toast align-items-center border-0 text-white" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i id="toastIcon" class="bi fs-5"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahSiswaLabel">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- novalidate → validasi dikelola JS, bukan browser native -->
                <form id="formTambahSiswa" novalidate class="needs-validation">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tambah_nama_siswa" class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambah_nama_siswa" name="nama_siswa"
                                   placeholder="Masukkan nama lengkap" required minlength="3">
                            <div class="invalid-feedback">
                                Nama siswa wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambah_kelas" name="kelas"
                                   placeholder="Contoh: XI RPL 1" required>
                            <div class="invalid-feedback">
                                Kelas wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="tambah_email" name="email"
                                   placeholder="siswa@email.com" required>
                            <div class="invalid-feedback">
                                Email wajib diisi dengan format yang valid.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="tambah_status" name="status" required>
                                <option value="Aktif Magang">Aktif Magang</option>
                                <option value="Tidak Aktif Magang">Tidak Aktif Magang</option>
                            </select>
                            <div class="invalid-feedback">
                                Status wajib dipilih.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpanTambah">
                            <span class="spinner-border spinner-border-sm d-none me-1" id="loadingTambah" role="status" aria-hidden="true"></span>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div class="modal fade" id="modalEditSiswa" tabindex="-1" aria-labelledby="modalEditSiswaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalEditSiswaLabel">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditSiswa" novalidate class="needs-validation">
                    <input type="hidden" id="edit_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_siswa" class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_siswa" name="nama_siswa"
                                   placeholder="Masukkan nama lengkap" required minlength="3">
                            <div class="invalid-feedback">
                                Nama siswa wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_kelas" name="kelas"
                                   placeholder="Contoh: XI RPL 1" required>
                            <div class="invalid-feedback">
                                Kelas wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email"
                                   placeholder="siswa@email.com" required>
                            <div class="invalid-feedback">
                                Email wajib diisi dengan format yang valid.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="Aktif Magang">Aktif Magang</option>
                                <option value="Tidak Aktif Magang">Tidak Aktif Magang</option>
                            </select>
                            <div class="invalid-feedback">
                                Status wajib dipilih.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning" id="btnSimpanEdit">
                            <span class="spinner-border spinner-border-sm d-none me-1" id="loadingEdit" role="status" aria-hidden="true"></span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapusSiswa" tabindex="-1" aria-labelledby="modalHapusSiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger" id="modalHapusSiswaLabel">
                        <i class="bi bi-trash me-2"></i>Hapus Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted mb-0">Yakin ingin menghapus data <strong id="hapusNamaSiswa"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
                    <input type="hidden" id="hapus_id">
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btnKonfirmasiHapus">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="loadingHapus" role="status" aria-hidden="true"></span>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- AJAX Scripts -->
@section('scripts')
    <script>
        $(document).ready(function () {

            // Helper: Tampilkan Toast Notifikasi
            // type: 'success' | 'error'
            function showToast(message, type = 'success') {
                const toastEl  = $('#toastNotif');
                const icon     = $('#toastIcon');
                const msgEl    = $('#toastMessage');

                // Reset class warna
                toastEl.removeClass('bg-success bg-danger');

                if (type === 'success') {
                    toastEl.addClass('bg-success');
                    icon.attr('class', 'bi bi-check-circle-fill fs-5');
                } else {
                    toastEl.addClass('bg-danger');
                    icon.attr('class', 'bi bi-x-circle-fill fs-5');
                }

                msgEl.text(message);

                // Tampilkan toast (auto-hide 4 detik)
                const toast = new bootstrap.Toast(toastEl[0], { delay: 4000 });
                toast.show();
            }

            // Helper: Validasi form Bootstrap (needs-validation)
            // Menambah class 'was-validated' agar invalid-feedback muncul.
            // Return true jika form valid, false jika tidak.
            function validateForm(formEl) {
                formEl.addClass('was-validated');
                return formEl[0].checkValidity();
            }

            // Helper: Reset state validasi saat modal ditutup
            function resetValidation(formEl) {
                formEl.removeClass('was-validated');
                formEl[0].reset();
            }

            // Helper: Render baris tabel dari array data
            function renderRows(data) {
                if (!data || !data.length) {
                    return `
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data siswa.</td>
                        </tr>
                    `;
                }

                return data.map(function (siswa) {
                    let badgeClass = siswa.status === 'aktif'
                        ? 'bg-success text-success'
                        : 'bg-warning text-warning';

                    return `
                        <tr>
                            <td class="ps-4">${siswa.id}</td>
                            <td class="fw-semibold">${siswa.nama_siswa}</td>
                            <td>${siswa.kelas}</td>
                            <td>${siswa.email}</td>
                            <td>
                                <span class="badge bg-opacity-10 ${badgeClass} px-3 py-2 rounded-pill">
                                    ${siswa.status}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button
                                    class="btn btn-sm btn-light text-primary border btn-edit me-1"
                                    data-id="${siswa.id}"
                                    data-nama_siswa="${siswa.nama_siswa}"
                                    data-kelas="${siswa.kelas}"
                                    data-email="${siswa.email}"
                                    data-status="${siswa.status}"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button
                                    class="btn btn-sm btn-light text-danger border btn-hapus"
                                    data-id="${siswa.id}"
                                    data-nama="${siswa.nama_siswa}"
                                    title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            // endpoint GET /admin/siswa/data
            function loadSiswa() {
                $('#siswaTableBody').html(`
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Memuat data...
                        </td>
                    </tr>
                `);

                $.ajax({
                    url: '{{ route("admin.siswa.data") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        $('#siswaError').addClass('d-none');
                        $('#siswaTableBody').html(renderRows(result.data));
                    },
                    error: function (xhr) {
                        let message = xhr.responseJSON?.error || 'Terjadi kesalahan sistem.';
                        $('#siswaErrorMessage').text(message);
                        $('#siswaError').removeClass('d-none');
                        $('#siswaTableBody').html(renderRows([]));
                    }
                });
            }

            loadSiswa();

            // Reset validasi saat modal tambah ditutup
            $('#modalTambahSiswa').on('hidden.bs.modal', function () {
                resetValidation($('#formTambahSiswa'));
            });

            // POST: Tambah data siswa baru
            $('#formTambahSiswa').on('submit', function (e) {
                e.preventDefault();

                // Cek validasi — jika gagal, tampilkan invalid-feedback & stop
                if (!validateForm($(this))) return;

                let btn     = $('#btnSimpanTambah');
                let spinner = $('#loadingTambah');

                let formData = {
                    nama_siswa: $('#tambah_nama_siswa').val().trim(),
                    kelas:      $('#tambah_kelas').val().trim(),
                    email:      $('#tambah_email').val().trim(),
                    status:     $('#tambah_status').val()
                };

                $.ajax({
                    url:         '{{ route("admin.siswa.store") }}',
                    type:        'POST',
                    data:        JSON.stringify(formData),
                    contentType: 'application/json',
                    headers:     { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function () {
                        btn.prop('disabled', true);
                        spinner.removeClass('d-none');
                    },
                    success: function (result) {
                        if (result.id) {
                            $('#modalTambahSiswa').modal('hide');
                            loadSiswa();
                            showToast('Data siswa berhasil ditambahkan!', 'success');
                        }
                    },
                    error: function (xhr) {
                        console.error('Error Tambah:', xhr.responseJSON);
                        let msg = xhr.responseJSON?.error || 'Terjadi kesalahan sistem.';
                        showToast('Gagal menambah: ' + msg, 'error');
                    },
                    complete: function () {
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });

            // Klik tombol Edit → isi modal & tampilkan
            $(document).on('click', '.btn-edit', function () {
                let btn = $(this);

                // Reset validasi sebelum isi ulang data
                resetValidation($('#formEditSiswa'));

                $('#edit_id').val(btn.data('id'));
                $('#edit_nama_siswa').val(btn.data('nama_siswa'));
                $('#edit_kelas').val(btn.data('kelas'));
                $('#edit_email').val(btn.data('email'));
                $('#edit_status').val(btn.data('status'));

                $('#modalEditSiswa').modal('show');
            });

            // Reset validasi saat modal edit ditutup
            $('#modalEditSiswa').on('hidden.bs.modal', function () {
                resetValidation($('#formEditSiswa'));
            });

            // PUT: Update data siswa
            $('#formEditSiswa').on('submit', function (e) {
                e.preventDefault();

                // Cek validasi jika gagal, tampilkan invalid-feedback & stop
                if (!validateForm($(this))) return;

                let id      = $('#edit_id').val();
                let btn     = $('#btnSimpanEdit');
                let spinner = $('#loadingEdit');

                let formData = {
                    nama_siswa: $('#edit_nama_siswa').val().trim(),
                    kelas:      $('#edit_kelas').val().trim(),
                    email:      $('#edit_email').val().trim(),
                    status:     $('#edit_status').val()
                };

                $.ajax({
                    url:         `{{ url('admin/siswa') }}/${id}`,
                    type:        'PUT',
                    data:        JSON.stringify(formData),
                    contentType: 'application/json',
                    headers:     { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function () {
                        btn.prop('disabled', true);
                        spinner.removeClass('d-none');
                    },
                    success: function () {
                        $('#modalEditSiswa').modal('hide');
                        loadSiswa();
                        showToast('Data siswa berhasil diperbarui!', 'success');
                    },
                    error: function (xhr) {
                        console.error('Error Edit:', xhr.responseJSON);
                        let msg = xhr.responseJSON?.error || 'Terjadi kesalahan sistem.';
                        showToast('Gagal memperbarui: ' + msg, 'error');
                    },
                    complete: function () {
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });

            // Klik tombol Hapus → tampilkan modal konfirmasi
            $(document).on('click', '.btn-hapus', function () {
                let btn = $(this);
                $('#hapus_id').val(btn.data('id'));
                $('#hapusNamaSiswa').text(btn.data('nama'));
                $('#modalHapusSiswa').modal('show');
            });

            //  DELETE: Hapus data siswa
            $('#btnKonfirmasiHapus').on('click', function () {
                let id      = $('#hapus_id').val();
                let btn     = $(this);
                let spinner = $('#loadingHapus');

                $.ajax({
                    url:     `{{ url('admin/siswa') }}/${id}`,
                    type:    'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function () {
                        btn.prop('disabled', true);
                        spinner.removeClass('d-none');
                    },
                    success: function () {
                        $('#modalHapusSiswa').modal('hide');
                        loadSiswa();
                        showToast('Data siswa berhasil dihapus.', 'success');
                    },
                    error: function (xhr) {
                        console.error('Error Hapus:', xhr.responseJSON);
                        let msg = xhr.responseJSON?.error || 'Terjadi kesalahan sistem.';
                        showToast('Gagal menghapus: ' + msg, 'error');
                    },
                    complete: function () {
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });

        });
    </script>
@endsection