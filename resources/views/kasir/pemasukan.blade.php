@extends('layouts.office')
@section('title', 'Pemasukan Lainnya | JUNIOR AUTO CARE')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <style>
        :root {
            --pemasukan-primary: #8b5cf6;
            --pemasukan-success: #10b981;
            --pemasukan-danger: #ef4444;
            --pemasukan-dark: #1e293b;
            --pemasukan-muted: #64748b;
            --pemasukan-line: #e2e8f0;
            --pemasukan-surface: #ffffff;
        }

        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--pemasukan-dark); }

        .table-card {
            background: var(--pemasukan-surface);
            border: 1px solid var(--pemasukan-line);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            overflow: hidden;
            margin-top: 1.5rem;
        }

        .kasir-stat-inline {
            background: rgba(139, 92, 246, 0.1);
            border: 2px solid #8b5cf6 !important;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            height: 42px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .kasir-stat-inline__label { color: #1e293b; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; }
        .kasir-stat-inline__value { color: #8b5cf6; font-size: 1.1rem; font-weight: 900; line-height: 1; }

        #tabel-pemasukan { border-collapse: separate !important; border-spacing: 0 0.5rem !important; }
        #tabel-pemasukan thead th {
            background: #f1f5f9;
            border: none !important;
            color: var(--pemasukan-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 1rem;
        }
        #tabel-pemasukan thead th { background-image: none !important; cursor: default !important; position: relative !important; }
        #tabel-pemasukan thead th:before, #tabel-pemasukan thead th:after { display: none !important; content: "" !important; }

        #tabel-pemasukan tbody td {
            border-bottom: 1px solid var(--pemasukan-line) !important;
            padding: 1rem;
            vertical-align: middle;
            background: #fff;
        }

        .btn-action { border: none !important; border-radius: 0.75rem; padding: 0.5rem; font-weight: 700; transition: all 0.2s; }
        .btn-action:hover { transform: translateY(-2px); filter: brightness(1.1); }

        @media (max-width: 768px) {
            .table-card { padding: 0.75rem; }
            #tabel-pemasukan tbody td { padding: 0.75rem 0.5rem; font-size: 0.8rem; }
        }
    </style>
@endsection

@section('content')
    <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8 mb-5">
        <h2 class="page-title me-auto">Pemasukan Lainnya</h2>
        <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0 gap-2">
            @if(strtolower(auth()->user()->role->role) != 'superadmin')
            <button class="btn btn-primary shadow-md fw-bold px-4" data-bs-toggle="modal" data-bs-target="#modal-tambah" id="tambah">
                <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Pemasukan
            </button>
            @endif
            <button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-edit" id="edit-trigger"></button>
        </div>
    </div>

    <div class="intro-y table-card p-4 mb-5">
        <div class="row align-items-end g-3">
            <div class="col-12 col-md-3 col-lg-2">
                <label class="form-label small fw-bold text-muted">DARI TANGGAL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i data-feather="calendar" class="w-4 h-4"></i></span>
                    <input type="date" class="form-control border-start-0 ps-0" id="start_date" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <label class="form-label small fw-bold text-muted">SAMPAI TANGGAL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i data-feather="calendar" class="w-4 h-4"></i></span>
                    <input type="date" class="form-control border-start-0 ps-0" id="end_date" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="col-12 col-md-auto">
                <button class="btn btn-dark fw-bold" style="height: 38px;" id="btn-filter">
                    <i data-feather="search" class="w-4 h-4 me-2"></i> Filter
                </button>
            </div>
            <div class="col-12 col-md-auto ms-lg-auto">
                <div class="kasir-stat-inline">
                    <div>
                        <div class="kasir-stat-inline__label">Total Pemasukan</div>
                        <div class="kasir-stat-inline__value" id="summary-total">Rp 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-y table-card mt-0">
        <div class="table-responsive">
            <table class="table table-hover display" id="tabel-pemasukan" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">NO</th>
                        <th>KETERANGAN</th>
                        <th>JUMLAH</th>
                        <th>TANGGAL</th>
                        <th>BUKTI</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
                <div class="modal-header border-bottom-0 pt-6 px-8 text-center">
                    <h2 class="fw-bold fs-xl w-full">Tambah Pemasukan</h2>
                </div>
                <form enctype="multipart/form-data" id="form-pemasukan">
                    @csrf
                    <div class="modal-body px-8 pb-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">KETERANGAN</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Penjualan Oli, Parkir, dll">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">JUMLAH (RP)</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="0">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold text-muted small">FOTO BUKTI</label>
                            <input type="file" class="form-control" id="foto_pemasukan" name="foto_pemasukan" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light bg-opacity-50 px-8 py-4">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary px-6">Batal</button>
                        <button type="submit" class="btn btn-primary px-6" id="simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="modal-edit" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem;">
                <div class="modal-header border-bottom-0 pt-6 px-8 text-center">
                    <h2 class="fw-bold fs-xl w-full">Ubah Pemasukan</h2>
                </div>
                <form enctype="multipart/form-data" id="edit-pemasukan-form">
                    @csrf
                    <div class="modal-body px-8 pb-8">
                        <input type="hidden" id="edit-id">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">KETERANGAN</label>
                            <input type="text" class="form-control" id="editname" name="editname">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">JUMLAH (RP)</label>
                            <input type="text" class="form-control" id="editjumlah" name="editjumlah">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold text-muted small">FOTO BUKTI (OPSIONAL)</label>
                            <input type="file" class="form-control" id="editfoto_pemasukan" name="editfoto_pemasukan" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light bg-opacity-50 px-8 py-4">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary px-6">Batal</button>
                        <button type="submit" class="btn btn-primary px-6" id="editsimpan">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            isi_tabel();

            $("#btn-filter").on('click', function() {
                isi_tabel();
            });
        });

        function formatNumber(n) {
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $(document).on('keyup', '#jumlah, #editjumlah', function() {
            $(this).val(formatNumber($(this).val()));
        });

        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount).replace('Rp','Rp ');
        }

        function formatDateTime(dateTimeString) {
            if (!dateTimeString) return '-';
            var date = new Date(dateTimeString);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + 
                   date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        function isi_tabel(start_date, end_date) {
            var start = start_date || $('#start_date').val();
            var end = end_date || $('#end_date').val();
            
            $('#tabel-pemasukan').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('pemasukan.index') }}",
                    data: {
                        start_date: start,
                        end_date: end
                    }
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        render: function(data) { return '<div class="fw-bold text-dark">' + data + '</div>'; }
                    },
                    {
                        data: 'jumlah',
                        render: function(data) { return '<div class="fw-bold text-success" style="font-size: 1rem;">' + formatRupiah(data) + '</div>'; }
                    },
                    {
                        data: 'created_at',
                        render: function(data) { return formatDateTime(data); }
                    },
                    {
                        data: 'foto',
                        render: function(data) {
                            if (!data) return '<span class="text-muted italic">No proof</span>';
                            return '<img src="/storage/bukti-pemasukan/' + data + '" class="rounded shadow-sm" style="width: 50px; cursor: pointer" onclick="window.open(this.src)"/>';
                        }
                    },
                    {
                        data: 'id',
                        className: 'text-center',
                        render: function(data) {
                            if ("{{ strtolower(auth()->user()->role->role) }}" === 'superadmin') {
                                return '<span class="text-muted small italic">Read Only</span>';
                            }
                            return '<div class="d-flex justify-content-center gap-1">' +
                                '<button class="btn-action btn btn-sm btn-warning text-white edit" id="' + data + '" title="Edit">' +
                                    '<i data-feather="edit-2" style="width: 14px; height: 14px;"></i>' +
                                '</button>' +
                                '<button class="btn-action btn btn-sm btn-danger text-white delete" id="' + data + '" title="Hapus">' +
                                    '<i data-feather="trash-2" style="width: 14px; height: 14px;"></i>' +
                                '</button>' +
                            '</div>';
                        }
                    }
                ],
                drawCallback: function(settings) {
                    if (typeof feather !== 'undefined') feather.replace();
                    var json = settings.json;
                    if (json) {
                        $('#summary-total').text(formatRupiah(json.totalSum || 0));
                    }
                }
            });
        }

        $('#form-pemasukan').on('submit', function(e) {
            e.preventDefault();
            var $btn = $('#simpan');
            $btn.prop('disabled', true).text('Loading..');
            var formData = new FormData(this);
            formData.set('jumlah', $('#jumlah').val().replace(/\./g, ''));
            $.ajax({
                type: 'POST',
                url: "{{ route('pemasukan.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.error) {
                        swal('Error', res.error.join('\n'), 'error');
                    } else {
                        $('#modal-tambah').modal('hide');
                        $('#form-pemasukan')[0].reset();
                        $('#tabel-pemasukan').DataTable().ajax.reload();
                        swal('Berhasil', res.text, 'success');
                    }
                },
                complete: function() { $btn.prop('disabled', false).text('Simpan'); }
            });
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.get("{{ url('pemasukan') }}/" + id + "/edit", function(res) {
                $('#edit-id').val(res.data.id);
                $('#editname').val(res.data.name);
                $('#editjumlah').val(formatNumber(res.data.jumlah.toString()));
                $('#editfoto_pemasukan').val('');
                $('#edit-trigger').click();
            });
        });

        $('#edit-pemasukan-form').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit-id').val();
            var $btn = $('#editsimpan');
            $btn.prop('disabled', true).text('Loading..');
            var formData = new FormData(this);
            formData.set('editjumlah', $('#editjumlah').val().replace(/\./g, ''));
            $.ajax({
                type: 'POST',
                url: "{{ url('pemasukan') }}/" + id + "/update",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.error) {
                        swal('Error', res.error.join('\n'), 'error');
                    } else {
                        $('#modal-edit').modal('hide');
                        $('#tabel-pemasukan').DataTable().ajax.reload();
                        swal('Berhasil', res.text, 'success');
                    }
                },
                complete: function() { $btn.prop('disabled', false).text('Simpan Perubahan'); }
            });
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).attr('id');
            swal({
                title: "Hapus Pemasukan?",
                text: "Data ini akan dihapus secara permanen.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "{{ url('pemasukan') }}/" + id,
                        type: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(res) {
                            $('#tabel-pemasukan').DataTable().ajax.reload();
                            swal('Berhasil', res.text, 'success');
                        }
                    });
                }
            });
        });
    </script>
@endsection
