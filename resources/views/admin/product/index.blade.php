@extends('layouts.office')

@section('title')
    Manajemen Produk | JUNIOR AUTO CARE
@endsection

@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12">
            <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
                <h2 class="fs-2xl fw-bold truncate me-auto">
                    Katalog Produk & Layanan
                </h2>
                <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
                    <button class="btn btn-primary shadow-md me-2" data-bs-toggle="modal" data-bs-target="#modal-tambah" id="tambah">
                        <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Produk
                    </button>
                </div>
            </div>
        </div>

        <div class="g-col-12 mt-2">
            <div class="intro-y box p-5">
                <div class="overflow-x-auto">
                    <table class="table table-report display w-full" id="tabel-product">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">NO</th>
                                <th class="text-nowrap" style="width: 10%">FOTO</th>
                                <th class="text-nowrap">NAMA LAYANAN / PRODUK</th>
                                <th class="text-nowrap">HARGA JUAL</th>
                                <th class="text-center text-nowrap">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH/EDIT -->
    <div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold fs-xl me-auto" id="modal-title">Registrasi Produk</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-product" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-10">
                        <div class="alert alert-danger print-error-msg mb-5" style="display:none" id="error">
                            <ul class="mb-0"></ul>
                        </div>
                        <div class="grid grid-cols-12 gap-6">
                            <div class="g-col-12 g-col-sm-6">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="name_category" id="name_category" class="form-select border-2"></select>
                            </div>
                            <div class="g-col-12 g-col-sm-6">
                                <label class="form-label fw-semibold">Nama Produk</label>
                                <input type="text" name="name" id="name" class="form-control border-2" placeholder="Contoh: Premium Wash Large">
                            </div>
                            <div class="g-col-12 g-col-sm-6">
                                <label class="form-label fw-semibold">Harga Jual</label>
                                <div class="input-group">
                                    <div class="input-group-text bg-gray-100 border-2">Rp</div>
                                    <input type="text" id="price_display" class="form-control border-2" placeholder="0">
                                </div>
                                <input type="hidden" name="price" id="price">
                            </div>
                            <div class="g-col-12 g-col-sm-6">
                                <label class="form-label fw-semibold">Foto Produk</label>
                                <input type="file" name="foto" id="foto" class="form-control border-2">
                                <div class="text-gray-500 text-xs mt-1 italic">*Foto akan otomatis di-resize ke 450x514</div>
                            </div>
                            <div class="g-col-12">
                                <label class="form-label fw-semibold">Deskripsi Singkat</label>
                                <textarea name="description" id="description" rows="3" class="form-control border-2" placeholder="Jelaskan detail layanan..."></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="id">
                    </div>
                    <div class="modal-footer bg-gray-50">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-2">Batal</button>
                        <button type="submit" class="btn btn-primary w-40" id="simpan">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <style>
        .table-report { border-collapse: separate; border-spacing: 0 10px; margin-top: -10px !important; }
        .table-report tr { border-radius: 10px; transition: all 0.3s; }
        .table-report td { background: #fff; border: none !important; padding: 15px 20px !important; }
        .table-report td:first-child { border-radius: 10px 0 0 10px; }
        .table-report td:last-child { border-radius: 0 10px 10px 0; }
        .dark .table-report td { background: #293145; }
        .ts-control { border-radius: 0.5rem !important; border: 2px solid #e2e8f0 !important; padding: 0.5rem 0.75rem !important; }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
    <script>
        $(document).ready(function() {
            // Nominal Format
            const cleavePrice = new Cleave('#price_display', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                delimiter: '.',
                numeralDecimalMark: ',',
            });

            // Searchable Select
            let categorySelect = new TomSelect("#name_category", {
                create: false,
                sortField: { field: "text", order: "asc" },
                placeholder: "Cari Kategori..."
            });

            const table = $('#tabel-product').DataTable({
                responsive: true, processing: true, serverSide: true,
                ajax: "{{ route('product.index') }}",
                columns: [
                    {
                        "data": null, "sortable": false,
                        render: (data, type, row, meta) => `<div class="fw-bold text-gray-400">${meta.row + meta.settings._iDisplayStart + 1}</div>`
                    },
                    { data: 'foto', name: 'foto', sortable: false },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'aksi', name: 'aksi', sortable: false }
                ],
                dom: '<"d-flex flex-wrap align-items-center justify-content-between mb-4"f>t<"d-flex flex-wrap align-items-center justify-content-between mt-4"ip>'
            });

            function loadCategories(selectedId = null) {
                $.get("{{ route('category.create') }}", function(res) {
                    categorySelect.clearOptions();
                    res.data.forEach(item => {
                        categorySelect.addOption({value: item.id, text: item.name});
                    });
                    if(selectedId) categorySelect.setValue(selectedId);
                });
            }

            $('#tambah').on('click', function() {
                $('#form-product')[0].reset();
                cleavePrice.setRawValue('');
                categorySelect.clear();
                $('#id').val('');
                $('#modal-title').text('Registrasi Produk');
                $("#simpan").text('Simpan Produk');
                $("#error").hide();
                loadCategories();
            });

            $('#form-product').on('submit', function(e) {
                e.preventDefault();
                const id = $('#id').val();
                const isEdit = id !== '';
                const url = isEdit ? "{{ route('product.update', ':id') }}".replace(':id', id) : "{{ route('product.store') }}";
                
                let formData = new FormData(this);
                formData.set('price', cleavePrice.getRawValue());
                
                if (isEdit) {
                    formData.append('name_category_edit', $('#name_category').val());
                    formData.append('name_edit', $('#name').val());
                    formData.append('price_edit', cleavePrice.getRawValue());
                    formData.append('description_edit', $('#description').val());
                    if($('#foto')[0].files[0]) formData.append('foto_edit', $('#foto')[0].files[0]);
                }

                $("#simpan").text('Memproses...').prop('disabled', true);

                $.ajax({
                    url: url, type: 'POST', data: formData,
                    cache: false, contentType: false, processData: false,
                    success: function(res) {
                        if (res.error) {
                            printErrorMsg(res.error);
                        } else {
                            table.ajax.reload();
                            bootstrap.Modal.getInstance(document.getElementById('modal-tambah')).hide();
                            Swal.fire('Berhasil', res.text, 'success');
                        }
                        $("#simpan").text(isEdit ? 'Update Produk' : 'Simpan Produk').prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.edit', function() {
                const id = $(this).attr('id');
                $('#modal-title').text('Ubah Produk');
                $("#simpan").text('Update Produk');
                $("#error").hide();
                
                $.get("{{ route('product.edit', ':id') }}".replace(':id', id), (res) => {
                    $('#name').val(res.data.name);
                    cleavePrice.setRawValue(res.data.price);
                    $('#description').val(res.data.description);
                    $('#id').val(res.data.id);
                    loadCategories(res.data.category_id);
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-tambah')).show();
                });
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Hapus Produk?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('product.destroy', ':id') }}".replace(':id', id),
                            type: 'DELETE',
                            data: { _token: "{{ csrf_token() }}" },
                            success: (res) => {
                                Swal.fire('Terhapus!', res.text, 'success');
                                table.ajax.reload();
                            }
                        });
                    }
                });
            });

            function printErrorMsg(msg) {
                $("#error").find("ul").html('');
                $("#error").show();
                $.each(msg, (key, value) => $("#error").find("ul").append(`<li>${value}</li>`));
            }
        });
    </script>
@endsection
