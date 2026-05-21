@extends('components.main')

@section('title', 'Manajemen DUDI')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <div>
            <h1 class="h2 fw-bold">Manajemen DUDI</h1>
            <p class="text-muted small mt-1">Daftar data DUDI (Dunia Usaha / Dunia Industri) yang terdaftar dalam sistem.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDudi">
            <i class="bi bi-plus-lg me-2"></i>Tambah DUDI
        </button>
    </div>

    <!-- Alert Error Get Data -->
    <div id="dudiError" class="card border-0 rounded-3 mb-4 bg-danger bg-opacity-10 d-none">
        <div class="card-body p-4 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-2 me-3"></i>
            <div>
                <h5 class="fw-bold text-danger mb-1">Gagal Mengambil Data</h5>
                <p class="text-danger mb-0" id="dudiErrorMessage"></p>
            </div>
        </div>
    </div>

    <!-- Tabel Data DUDI -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">Id</th>
                            <th>Nama DUDI</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Penanggung Jawab</th>
                            <th>Status</th>
                            <th>Kuota</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dudiTableBody">
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
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
    <div class="toast-container position-fixed end-0 top-0 p-3" style="z-index: 1100;">
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

    <!-- Modal Tambah DUDI -->
    <div class="modal fade" id="modalTambahDudi" tabindex="-1" aria-labelledby="modalTambahDudiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahDudiLabel">Tambah Data DUDI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- novalidate → validasi dikelola JS, bukan browser native -->
                <form id="formTambahDudi" novalidate class="needs-validation">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tambah_nama_dudi" class="form-label">Nama DUDI <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambah_nama_dudi" name="nama_dudi"
                                   placeholder="Masukkan nama perusahaan/instansi" required minlength="3">
                            <div class="invalid-feedback">
                                Nama DUDI wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="tambah_alamat" name="alamat" rows="2"
                                      placeholder="Masukkan alamat lengkap" required minlength="5"></textarea>
                            <div class="invalid-feedback">
                                Alamat wajib diisi (minimal 5 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="tambah_email" name="email"
                                   placeholder="contoh@perusahaan.com" required>
                            <div class="invalid-feedback">
                                Email wajib diisi dengan format yang valid.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_pj" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambah_pj" name="penanggung_jawab"
                                   placeholder="Masukkan nama penanggung jawab" required minlength="3">
                            <div class="invalid-feedback">
                                Penanggung jawab wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tambah_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="tambah_status" name="status" required>
                                    <option value="aktif">aktif</option>
                                    <option value="tidak aktif">tidak aktif</option>
                                </select>
                                <div class="invalid-feedback">
                                    Status wajib dipilih.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tambah_kuota" class="form-label">Kuota <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="tambah_kuota" name="kuota"
                                       placeholder="0" required min="0">
                                <div class="invalid-feedback">
                                    Kuota wajib diisi (minimal 0).
                                </div>
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

    <!-- Modal Edit DUDI -->
    <div class="modal fade" id="modalEditDudi" tabindex="-1" aria-labelledby="modalEditDudiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalEditDudiLabel">Edit Data DUDI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditDudi" novalidate class="needs-validation">
                    <input type="hidden" id="edit_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_dudi" class="form-label">Nama DUDI <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_dudi" name="nama_dudi"
                                   placeholder="Masukkan nama perusahaan/instansi" required minlength="3">
                            <div class="invalid-feedback">
                                Nama DUDI wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_alamat" name="alamat" rows="2"
                                      placeholder="Masukkan alamat lengkap" required minlength="5"></textarea>
                            <div class="invalid-feedback">
                                Alamat wajib diisi (minimal 5 karakter).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email"
                                   placeholder="contoh@perusahaan.com" required>
                            <div class="invalid-feedback">
                                Email wajib diisi dengan format yang valid.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_pj" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_pj" name="penanggung_jawab"
                                   placeholder="Masukkan nama penanggung jawab" required minlength="3">
                            <div class="invalid-feedback">
                                Penanggung jawab wajib diisi (minimal 3 karakter).
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="aktif">aktif</option>
                                    <option value="tidak aktif">tidak aktif</option>
                                </select>
                                <div class="invalid-feedback">
                                    Status wajib dipilih.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_kuota" class="form-label">Kuota <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_kuota" name="kuota"
                                       placeholder="0" required min="0">
                                <div class="invalid-feedback">
                                    Kuota wajib diisi (minimal 0).
                                </div>
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
    <div class="modal fade" id="modalHapusDudi" tabindex="-1" aria-labelledby="modalHapusDudiLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger" id="modalHapusDudiLabel">
                        <i class="bi bi-trash me-2"></i>Hapus Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted mb-0">Yakin ingin menghapus data <strong id="hapusNamaDudi"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
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
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data DUDI.</td>
                        </tr>
                    `;
                }

                return data.map(function (dudi) {
                    let statusBadge = dudi.status === 'aktif'
                        ? 'bg-success text-success'
                        : 'bg-danger text-danger';

                    return `
                        <tr>
                            <td class="ps-4">${dudi.id}</td>
                            <td class="fw-semibold">${dudi.nama_dudi}</td>
                            <td><small>${dudi.alamat}</small></td>
                            <td><small>${dudi.email}</small></td>
                            <td>${dudi.penanggung_jawab}</td>
                            <td>
                                <span class="badge bg-opacity-10 ${statusBadge} px-3 py-2 rounded-pill">
                                    ${dudi.status}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    <i class="bi bi-people me-1"></i>${dudi.kuota}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button
                                    class="btn btn-sm btn-light text-primary border btn-edit me-1"
                                    data-id="${dudi.id}"
                                    data-nama_dudi="${dudi.nama_dudi}"
                                    data-alamat="${dudi.alamat}"
                                    data-email="${dudi.email}"
                                    data-pj="${dudi.penanggung_jawab}"
                                    data-status="${dudi.status}"
                                    data-kuota="${dudi.kuota}"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button
                                    class="btn btn-sm btn-light text-danger border btn-hapus"
                                    data-id="${dudi.id}"
                                    data-nama="${dudi.nama_dudi}"
                                    title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            // endpoint GET /admin/dudi/data
            function loadDudi() {
                $('#dudiTableBody').html(`
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Memuat data...
                        </td>
                    </tr>
                `);

                $.ajax({
                    url: '{{ route("admin.dudi.data") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        $('#dudiError').addClass('d-none');
                        $('#dudiTableBody').html(renderRows(result.data));
                    },
                    error: function (xhr) {
                        let message = xhr.responseJSON?.error || 'Terjadi kesalahan sistem.';
                        $('#dudiErrorMessage').text(message);
                        $('#dudiError').removeClass('d-none');
                        $('#dudiTableBody').html(renderRows([]));
                    }
                });
            }

            loadDudi();

            // Reset validasi saat modal tambah ditutup
            $('#modalTambahDudi').on('hidden.bs.modal', function () {
                resetValidation($('#formTambahDudi'));
            });

            // POST: Tambah data DUDI baru
            $('#formTambahDudi').on('submit', function (e) {
                e.preventDefault();

                // Cek validasi — jika gagal, tampilkan invalid-feedback & stop
                if (!validateForm($(this))) return;

                let btn     = $('#btnSimpanTambah');
                let spinner = $('#loadingTambah');

                let formData = {
                    nama_dudi:        $('#tambah_nama_dudi').val().trim(),
                    alamat:           $('#tambah_alamat').val().trim(),
                    email:            $('#tambah_email').val().trim(),
                    penanggung_jawab: $('#tambah_pj').val().trim(),
                    status:           $('#tambah_status').val(),
                    kuota:            parseInt($('#tambah_kuota').val()) || 0
                };

                $.ajax({
                    url:         '{{ route("admin.dudi.store") }}',
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
                            $('#modalTambahDudi').modal('hide');
                            loadDudi();
                            showToast('Data DUDI berhasil ditambahkan!', 'success');
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
                resetValidation($('#formEditDudi'));

                $('#edit_id').val(btn.data('id'));
                $('#edit_nama_dudi').val(btn.data('nama_dudi'));
                $('#edit_alamat').val(btn.data('alamat'));
                $('#edit_email').val(btn.data('email'));
                $('#edit_pj').val(btn.data('pj'));
                $('#edit_status').val(btn.data('status'));
                $('#edit_kuota').val(btn.data('kuota'));

                $('#modalEditDudi').modal('show');
            });

            // Reset validasi saat modal edit ditutup
            $('#modalEditDudi').on('hidden.bs.modal', function () {
                resetValidation($('#formEditDudi'));
            });

            // PUT: Update data DUDI
            $('#formEditDudi').on('submit', function (e) {
                e.preventDefault();

                // Cek validasi — jika gagal, tampilkan invalid-feedback & stop
                if (!validateForm($(this))) return;

                let id      = $('#edit_id').val();
                let btn     = $('#btnSimpanEdit');
                let spinner = $('#loadingEdit');

                let formData = {
                    nama_dudi:        $('#edit_nama_dudi').val().trim(),
                    alamat:           $('#edit_alamat').val().trim(),
                    email:            $('#edit_email').val().trim(),
                    penanggung_jawab: $('#edit_pj').val().trim(),
                    status:           $('#edit_status').val(),
                    kuota:            parseInt($('#edit_kuota').val()) || 0
                };

                $.ajax({
                    url:         `{{ url('admin/dudi') }}/${id}`,
                    type:        'PUT',
                    data:        JSON.stringify(formData),
                    contentType: 'application/json',
                    headers:     { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function () {
                        btn.prop('disabled', true);
                        spinner.removeClass('d-none');
                    },
                    success: function () {
                        $('#modalEditDudi').modal('hide');
                        loadDudi();
                        showToast('Data DUDI berhasil diperbarui!', 'success');
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
                $('#hapusNamaDudi').text(btn.data('nama'));
                $('#modalHapusDudi').modal('show');
            });

            // DELETE: Hapus data DUDI
            $('#btnKonfirmasiHapus').on('click', function () {
                let id      = $('#hapus_id').val();
                let btn     = $(this);
                let spinner = $('#loadingHapus');

                $.ajax({
                    url:     `{{ url('admin/dudi') }}/${id}`,
                    type:    'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    beforeSend: function () {
                        btn.prop('disabled', true);
                        spinner.removeClass('d-none');
                    },
                    success: function () {
                        $('#modalHapusDudi').modal('hide');
                        loadDudi();
                        showToast('Data DUDI berhasil dihapus.', 'success');
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