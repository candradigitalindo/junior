@extends('layouts.office')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-9">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="g-col-12 mt-8">
                    <div class="intro-y d-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            General Report
                        </h2>
                        <a href="" class="ms-auto d-flex align-items-center text-theme-1 dark-text-theme-10"> <i
                                data-feather="refresh-ccw" class="w-4 h-4 me-3"></i> Reload Data </a>
                    </div>
                    <div class="grid columns-12 gap-6 mt-5">
                        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="d-flex">
                                        <i data-feather="users" class="report-box__icon text-theme-12"></i>

                                    </div>
                                    <div class="report-box__total fs-3xl fw-medium mt-6">
                                        {{ number_format($booking, 0, ',', '.') }}</div>
                                    <div class="fs-base text-gray-600 mt-1">Booking {{ date('M Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="d-flex">
                                        <i data-feather="repeat" class="report-box__icon text-theme-12"></i>

                                    </div>
                                    <div class="report-box__total fs-3xl fw-medium mt-6">
                                        {{ number_format($kunjungan, 0, ',', '.') }}</div>
                                    <div class="fs-base text-gray-600 mt-1">Kunjungan {{ date('M Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="d-flex">
                                        <i data-feather="box" class="report-box__icon text-theme-12"></i>

                                    </div>
                                    <div class="report-box__total fs-3xl fw-medium mt-6">
                                        {{ number_format($product, 0, ',', '.') }}</div>
                                    <div class="fs-base text-gray-600 mt-1">Produk</div>
                                </div>
                            </div>
                        </div>
                        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="d-flex">
                                        <i data-feather="user-check" class="report-box__icon text-theme-12"></i>

                                    </div>
                                    <div class="report-box__total fs-3xl fw-medium mt-6">
                                        {{ number_format($pengguna, 0, ',', '.') }}</div>
                                    <div class="fs-base text-gray-600 mt-1">User Pengguna</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Sales Report -->
                <div class="g-col-12 g-col-lg-8 mt-8">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Sales Report
                        </h2>
                        {{-- <div class="ms-sm-auto mt-3 mt-sm-0 position-relative text-gray-700 dark-text-gray-300">
                        <i data-feather="calendar" class="w-4 h-4 z-10 position-absolute my-auto top-0 bottom-0 ms-3 start-0"></i>
                        <input type="text" class="datepicker form-control w-sm-56 box border-white dark-border-dark-3 ps-10">
                    </div> --}}
                    </div>
                    <div class="intro-y box p-5 mt-12 mt-sm-5">
                        <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                            <div class="d-flex">
                                <div>
                                    <div class="text-theme-12 dark-text-gray-300 fs-lg fs-xl-xl fw-medium">Rp.
                                        {{ number_format($trx_now, 0, ',', '.') }}</div>
                                    <div class="mt-0.5 text-gray-600 dark-text-gray-600">Bulan ini</div>
                                </div>
                                <div
                                    class="w-px h-12 border border-end border-dashed border-gray-300 dark-border-dark-5 mx-4 mx-xl-5">
                                </div>
                                <div>
                                    <div class="text-gray-600 dark-text-gray-600 fs-lg fs-xl-xl fw-medium">Rp.
                                        {{ number_format($tahun, 0, ',', '.') }}</div>
                                    <div class="mt-0.5 text-gray-600 dark-text-gray-600">Tahun ini</div>
                                </div>
                            </div>
                            <div class="dropdown ms-xl-auto mt-5 mt-xl-0">
                                <button class="btn btn-primary w-25 me-8 mb-4" data-bs-toggle="modal"
                                    data-bs-target="#modal-harian" id="harian"> <i data-feather="list"
                                        class="w-4 h-4 me-2"></i> Pendapatan Harian</button>
                                <button class="btn btn-primary w-25 me-8 mb-4" data-bs-toggle="modal"
                                    data-bs-target="#modal-rincian" id="rincian"> <i data-feather="list"
                                        class="w-4 h-4 me-2"></i> Pendapatan Bulanan</button>
                                <button class="btn btn-primary w-25 me-8 mb-4" data-bs-toggle="modal"
                                    data-bs-target="#modal-pemasukan" id="pemasukan"> <i data-feather="list"
                                        class="w-4 h-4 me-2"></i> Pemasukan Lainnya </button>
                                <button class="btn btn-primary w-25 me-8 mb-4" data-bs-toggle="modal"
                                    data-bs-target="#modal-pengeluaran" id="pengeluaran"> <i data-feather="list"
                                        class="w-4 h-4 me-2"></i> Pengeluaran </button>
                            </div>
                        </div>
                        <div class="report-chart">
                            <canvas id="line-sales" height="169" class="mt-7"></canvas>
                        </div>
                    </div>
                </div>
                <!-- END: Sales Report -->
                <!-- BEGIN: Weekly Best Sellers -->
                <div class="g-col-12 g-col-xl-4 mt-6">
                    <div class="intro-y d-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Booking Terbaru
                        </h2>
                    </div>
                    <div class="mt-5">
                        @foreach ($booking_t as $b)
                            <div class="intro-y">
                                <div class="box px-4 py-4 mb-3 d-flex align-items-center zoom-in">
                                    <div class="w-9 h-12 flex-none image-fit rounded-2 overflow-hidden">
                                        <img alt="Pelanggan Mingguan Terbaik"
                                            src="{{ asset('office/dist/images/mendali-mobil.png') }}">
                                    </div>
                                    <div class="ms-4 me-auto">
                                        <div class="fw-medium">{{ $b->no_pol_kendaraan }}</div>
                                        <div class="text-gray-600 fs-xs mt-0.5">
                                            {{ date('d-m-Y H:i', strtotime($b->created_at)) }}</div>
                                    </div>
                                    <div
                                        class="py-1 px-2 rounded-pill fs-xs bg-theme-12 text-black cursor-pointer fw-medium">
                                        {{ $b->description }}</div>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ route('admin.booking') }}"
                            class="intro-y w-full d-block text-center rounded-2 py-4 border border-dotted border-theme-15 dark-border-dark-5 text-theme-16 dark-text-gray-600"
                            id="booking">Lihat lebih banyak</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="g-col-12 g-col-xxl-3">
            <div class="border-start-xxl border-theme-5 dark-border-dark-3 mb-n10 pb-10">
                <div class="ps-xxl-6 grid grid-cols-12 gap-6">
                    <!-- BEGIN: Transactions -->
                    <div class="g-col-12 g-col-md-6 g-col-xl-4 g-col-xxl-12 mt-3 mt-xxl-8">
                        <div class="intro-x d-flex align-items-center h-10">
                            <h2 class="fs-lg fw-medium truncate me-5">
                                Transaksi Terbaru
                            </h2>
                        </div>
                        <div class="mt-5">
                            @foreach ($transaksi as $trx)
                                <div class="intro-x">
                                    <div class="box px-5 py-3 mb-3 d-flex align-items-center zoom-in">
                                        <div class="w-10 h-10 flex-none image-fit rounded-circle overflow-hidden">
                                            <img alt="Rubick Bootstrap HTML Admin Template"
                                                src="{{ asset('office/dist/images/price-rp.png') }}">
                                        </div>
                                        <div class="ms-4 me-auto">
                                            <div class="fw-medium">{{ $trx->no_pol_kendaraan }}</div>
                                            <div class="text-gray-600 fs-xs mt-0.5">
                                                {{ date('d-m-Y H:i', strtotime($trx->created_at)) }}</div>
                                        </div>
                                        <div class="fw-medium">Rp.
                                            {{ number_format($trx->total, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach

                            <a href="{{ route('admin.transaksi') }}"
                                class="intro-x w-full d-block text-center rounded-2 py-3 border border-dotted border-theme-15 dark-border-dark-5 text-theme-16 dark-text-gray-600">Lihat
                                lebih banyak</a>
                        </div>
                    </div>
                    <!-- END: Transactions -->
                    <!-- BEGIN: Recent Activities -->
                    <div class="g-col-12 g-col-md-6 g-col-xl-4 g-col-xxl-12 mt-3">
                        <div class="intro-x d-flex align-items-center h-10">
                            <h2 class="fs-lg fw-medium truncate me-5">
                                Aktivitas Terbaru
                            </h2>
                        </div>
                        <div class="report-timeline mt-5 position-relative">
                            @foreach ($histori as $item)
                                <div class="intro-x position-relative d-flex align-items-center mb-3">
                                    <div class="report-timeline__image">
                                        <div class="w-10 h-10 flex-none image-fit rounded-circle overflow-hidden">
                                            <img alt="Rubick Bootstrap HTML Admin Template"
                                                src="{{ asset('office/dist/images/logo-mobil.png') }}">
                                        </div>
                                    </div>
                                    <div class="box px-5 py-3 ms-4 flex-1 zoom-in">
                                        <div class="d-flex align-items-center">
                                            <div class="fw-medium">{{ $item->booking->no_pol_kendaraan }}</div>
                                            <div class="fs-xs text-gray-500 ms-auto">
                                                {{ date('d-m-Y H:i', strtotime($item->created_at)) }}</div>
                                        </div>
                                        <div class="text-gray-600 mt-1">{{ $item->histori }}</div>
                                    </div>
                                </div>
                            @endforeach

                            <a href="{{ route('admin.histori') }}"
                                class="intro-x w-full d-block text-center rounded-2 py-3 border border-dotted border-theme-15 dark-border-dark-5 text-theme-16 dark-text-gray-600">Lihat
                                lebih banyak</a>
                        </div>
                    </div>
                    <!-- END: Recent Activities -->

                    <!-- END: Important Notes -->

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-harian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="staticBackdropLabel">Rincian Harian Bulan {{ date('M Y') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table-responsive table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Pemasukan</th>
                                <th class="text-nowrap">Pemasukan Lainnya</th>
                                <th class="text-nowrap">Pengeluaran</th>
                                <th class="text-nowrap">Total Bersih</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($date as $val)
                                <tr>
                                    <td>{{ $val['tanggal'] }}</td>
                                    <td><a style="color: rgb(104, 74, 18)"
                                            href="{{ route('trx-tanggal', $val['tanggal']) }}">{{ number_format($val['trx_tanggal'], 0, ',', '.') }}</a>
                                    </td>
                                    <td><a href="">{{ number_format($val['pemasukan'], 0, ',', '.') }}</a></td>
                                    <td><a href="">{{ number_format($val['pengeluaran'], 0, ',', '.') }}</a></td>
                                    <td>{{ number_format($val['trx_tanggal'] + $val['pemasukan'] - $val['pengeluaran'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-rincian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="staticBackdropLabel">Rincian Bulanan Tahun {{ date('Y') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table-responsive table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Bulan</th>
                                <th class="text-nowrap">Pemasukan</th>
                                <th class="text-nowrap">Pemasukan Lainnya</th>
                                <th class="text-nowrap">Pengeluaran</th>
                                <th class="text-nowrap">Total Bersih</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['bulan'] }}</td>
                                    <td>{{ number_format($item['pemasukan'], 0, ',', '.') }}</td>
                                    <td>{{ number_format($item['pemasukan_lainnya'], 0, ',', '.') }}</td>
                                    <td>{{ number_format($item['pengeluaran'], 0, ',', '.') }}</td>
                                    <td>{{ number_format($item['pemasukan'] + $item['pemasukan_lainnya'] - $item['pengeluaran'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-pengeluaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="staticBackdropLabel">Pengeluaran Tahun {{ date('Y') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-pengeluaran">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">No</th>
                                <th class="text-nowrap">Keterangan</th>
                                <th class="text-nowrap">Jumlah</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Foto Bukti</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-pemasukan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="staticBackdropLabel">Pemasukan Lainnya Tahun {{ date('Y') }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-pemasukan">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">No</th>
                                <th class="text-nowrap">Keterangan</th>
                                <th class="text-nowrap">Jumlah</th>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Foto Bukti</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('line-sales').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels :
                @php
                echo json_encode($labels);
                @endphp,
                datasets: [{
                    label: '',
                    data: {{ json_encode($jumlah_trx_bln, JSON_NUMERIC_CHECK) }},
                    backgroundColor: [
                        'rgb(255,215,0)'
                    ],
                    borderColor: [
                        'rgb(255,215,0)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        $('#pengeluaran').on('click', function() {
            $('#tabel-pengeluaran').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('admin.pengeluaran') }}",
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'foto',
                        name: 'foto'
                    }
                ]
            })
        })

        $('#pemasukan').on('click', function() {
            $('#tabel-pemasukan').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('pemasukan.index') }}",
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'foto',
                        name: 'foto'
                    }
                ]
            })
        })
    </script>
@endsection
