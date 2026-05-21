@extends('components.main')

@section('title', 'Manajemen Guru Pembimbing')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <div>
            <h1 class="h2 fw-bold">Manajemen Guru Pembimbing</h1>
            <p class="text-muted small mt-1">Daftar data guru pembimbing yang terdaftar dalam sistem.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
            <i class="bi bi-plus-lg me-2"></i>Tambah Guru
        </button>
    </div>

    <!-- Alert Error Fetch Data -->
    <div id="guruError" class="card border-0 rounded-3 mb-4 bg-danger bg-opacity-10 d-none">
        <div class="card-body p-4 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-2 me-3"></i>
            <div>
                <h5 class="fw-bold text-danger mb-1">Gagal Mengambil Data</h5>
                <p class="text-danger mb-0" id="guruErrorMessage"></p>
            </div>
        </div>
    </div>

    <!-- Tabel Data Guru -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">Id</th>
                            <th>Nama Guru</th>
                            <th>Bidang Keahlian</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="guruTableBody">
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

    <!-- Modal Tambah Guru -->
    <div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-labelledby="modalTambahGuruLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahGuruLabel">Tambah Data Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- novalidate → validasi dikelola JS, bukan browser native -->
                <form id="formTambahGuru" novalidate class="needs-validation">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tambah_nama_guru" class="form-label">Nama Guru <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambah_nama_guru" name="nama_guru"
                                   placeholder="Masukkan nama lengkap guru" required minlength="3">
                            <div class="invalid-feedback">
                                Nama guru wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_bidang_keahlian" class="form-label">Bidang Keahlian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambah_bidang_keahlian" name="bidang_keahlian"
                                   placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                            <div class="invalid-feedback">
                                Bidang keahlian wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="tambah_email" name="email"
                                   placeholder="Contoh: guru@sekolah.sch.id" required>
                            <div class="invalid-feedback">
                                Email wajib diisi dengan format yang valid.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="tambah_status" name="status" required>
                                <option value="aktif">aktif</option>
                                <option value="tidak aktif">tidak aktif</option>
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

    <!-- Modal Edit Guru -->
    <div class="modal fade" id="modalEditGuru" tabindex="-1" aria-labelledby="modalEditGuruLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalEditGuruLabel">Edit Data Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditGuru" novalidate class="needs-validation">
                    <input type="hidden" id="edit_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_guru" class="form-label">Nama Guru <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_guru" name="nama_guru"
                                   placeholder="Masukkan nama lengkap guru" required minlength="3">
                            <div class="invalid-feedback">
                                Nama guru wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_bidang_keahlian" class="form-label">Bidang Keahlian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_bidang_keahlian" name="bidang_keahlian"
                                   placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                            <div class="invalid-feedback">
                                Bidang keahlian wajib diisi.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email"
                                   placeholder="Contoh: guru@sekolah.sch.id" required>
                            <div class="invalid-feedback">
                                Email wajib diisi dengan format yang valid.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="aktif">aktif</option>
                                <option value="tidak aktif">tidak aktif</option>
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
    <div class="modal fade" id="modalHapusGuru" tabindex="-1" aria-labelledby="modalHapusGuruLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger" id="modalHapusGuruLabel">
                        <i class="bi bi-trash me-2"></i>Hapus Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted mb-0">Yakin ingin menghapus data <strong id="hapusNamaGuru"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data guru pembimbing.</td>
                        </tr>
                    `;
                }

                return data.map(function (guru) {
                    let badgeClass = guru.status === 'aktif'
                        ? 'bg-success text-success'
                        : 'bg-danger text-danger';

                    return `
                        <tr>
                            <td class="ps-4">${guru.id}</td>
                            <td class="fw-semibold">${guru.nama_guru}</td>
                            <td>${guru.bidang_keahlian}</td>
                            <td>${guru.email}</td>
                            <td>
                                <span class="badge bg-opacity-10 ${badgeClass} px-3 py-2 rounded-pill">
                                    ${guru.status}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button
                                    class="btn btn-sm btn-light text-primary border btn-edit me-1"
                                    data-id="${guru.id}"
                                    data-nama_guru="${guru.nama_guru}"
                                    data-bidang_keahlian="${guru.bidang_keahlian}"
                                    data-email="${guru.email}"
                                    data-status="${guru.status}"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button
                                    class="btn btn-sm btn-light text-danger border btn-hapus"
                                    data-id="${guru.id}"
                                    data-nama="${guru.nama_guru}"
                                    title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            // endpoint GET /admin/guru/data
            function loadGuru() {
                $('#guruTableBody').html(`
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Memuat data...
                        </td>
                    </tr>
                `);

                $.ajax({
                    url: '{{ route("admin.guru.data") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        $('#guruError').addClass('d-none');
                        $('#guruTableBody').html(renderRows(result.data));
                    },
                    error: function (xhr) {
                        let message = xhr.responseJSON?.error || 'Terjadi kesalahan sistem.';
                        $('#guruErrorMessage').text(message);
                        $('#guruError').removeClass('d-none');
                        $('#guruTableBody').html(renderRows([]));
                    }
                });
            }

            loadGuru();

            // Reset validasi saat modal tambah ditutup
            $('#modalTambahGuru').on('hidden.bs.modal', function () {
                resetValidation($('#formTambahGuru'));
            });

            // POST: Tambah data guru baru
            $('#formTambahGuru').on('submit', function (e) {
                e.preventDefault();

                // Cek validasi — jika gagal, tampilkan invalid-feedback & stop
                if (!validateForm($(this))) return;

                let btn     = $('#btnSimpanTambah');
                let spinner = $('#loadingTambah');

                let formData = {
                    nama_guru:       $('#tambah_nama_guru').val().trim(),
                    bidang_keahlian: $('#tambah_bidang_keahlian').val().trim(),
                    email:           $('#tambah_email').val().trim(),
                    status:          $('#tambah_status').val()
                };

                $.ajax({
                    url:         '{{ route("admin.guru.store") }}',
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
                            $('#modalTambahGuru').modal('hide');
                            loadGuru();
                            showToast('Data guru berhasil ditambahkan!', 'success');
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
                resetValidation($('#formEditGuru'));

                $('#edit_id').val(btn.data('id'));
                $('#edit_nama_guru').val(btn.data('nama_guru'));
                $('#edit_bidang_keahlian').val(btn.data('bidang_keahlian'));
                $('#edit_email').val(btn.data('email'));
                $('#edit_status').val(btn.data('status'));

                $('#modalEditGuru').modal('show');
            });

            // Reset validasi saat modal edit ditutup
            $('#modalEditGuru').on('hidden.bs.modal', function () {
                resetValidation($('#formEditGuru'));
            });

            // PUT: Update data guru
            $('#formEditGuru').on('submit', function (e) {
                e.preventDefault();

                // Cek validasi jika gagal, tampilkan invalid-feedback & stop
                if (!validateForm($(this))) return;

                let id      = $('#edit_id').val();
                let btn     = $('#btnSimpanEdit');
                let spinner = $('#loadingEdit');

                let formData = {
                    nama_guru:       $('#edit_nama_guru').val().trim(),
                    bidang_keahlian: $('#edit_bidang_keahlian').val().trim(),
                    email:           $('#edit_email').val().trim(),
                    status:          $('#edit_status').val()
                };

                $.ajax({
                    url:         `{{ url('admin/guru') }}/${id}`,
                    type:        'PUT',
                    data:        JSON.stringify(formData),
                    contentType: 'application/json',
                    headers:     { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function () {
                        btn.prop('disabled', true);
                        spinner.removeClass('d-none');
                    },
                    success: function () {
                        $('#modalEditGuru').modal('hide');
                        loadGuru();
                        showToast('Data guru berhasil diperbarui!', 'success');
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
                $('#hapusNamaGuru').text(btn.data('nama'));
                $('#modalHapusGuru').modal('show');
            });

            //  DELETE: Hapus data guru
            $('#btnKonfirmasiHapus').on('click', function () {
                let id      = $('#hapus_id').val();
                let btn     = $(this);
                let spinner = $('#loadingHapus');

                $.ajax({
                    url:     `{{ url('admin/guru') }}/${id}`,
                    type:    'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function () {
                        btn.prop('disabled', true);
                        spinner.removeClass('d-none');
                    },
                    success: function () {
                        $('#modalHapusGuru').modal('hide');
                        loadGuru();
                        showToast('Data guru berhasil dihapus.', 'success');
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