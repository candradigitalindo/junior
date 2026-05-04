@extends('layouts.office')

@section('title')
    Dashboard | JUNIOR AUTO CARE
@endsection

@section('content')
    <div class="grid columns-12 gap-6 mb-20">
        <div class="g-col-12">
            <div class="intro-y d-flex align-items-center mt-8">
                <h2 class="fs-2xl fw-bold truncate me-5">
                    Ringkasan Bisnis
                </h2>
                <button onclick="window.location.reload()" class="ms-auto btn btn-primary shadow-md d-flex align-items-center">
                    <i data-feather="refresh-ccw" class="w-4 h-4 me-2"></i> Segarkan Data
                </button>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
            <div class="report-box">
                <div class="box p-5 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="report-box__icon text-theme-10 bg-theme-1/10 p-3 rounded-2">
                            <i data-feather="shopping-cart" class="w-8 h-8"></i>
                        </div>
                        <div class="ms-auto text-end">
                            <div class="report-box__total fs-3xl fw-bold text-dark">
                                {{ number_format($stats['booking_month'], 0, ',', '.') }}
                            </div>
                            <div class="fs-sm text-gray-500 mt-1">Pesanan Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
            <div class="report-box">
                <div class="box p-5 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="report-box__icon text-warning bg-warning/10 p-3 rounded-2">
                            <i data-feather="user-check" class="w-8 h-8"></i>
                        </div>
                        <div class="ms-auto text-end">
                            <div class="report-box__total fs-3xl fw-bold text-dark">
                                {{ number_format($stats['visits_month'], 0, ',', '.') }}
                            </div>
                            <div class="fs-sm text-gray-500 mt-1">Selesai Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
            <div class="report-box">
                <div class="box p-5 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="report-box__icon text-success bg-success/10 p-3 rounded-2">
                            <i data-feather="credit-card" class="w-8 h-8"></i>
                        </div>
                        <div class="ms-auto text-end">
                            <div class="report-box__total fs-xl fw-bold text-dark">
                                Rp {{ number_format($stats['revenue_month'], 0, ',', '.') }}
                            </div>
                            <div class="fs-sm text-gray-500 mt-1">Omzet Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
            <div class="report-box">
                <div class="box p-5 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="report-box__icon text-primary bg-theme-1/10 p-3 rounded-2">
                            <i data-feather="trending-up" class="w-8 h-8"></i>
                        </div>
                        <div class="ms-auto text-end">
                            <div class="report-box__total fs-xl fw-bold text-dark">
                                Rp {{ number_format($stats['revenue_year'], 0, ',', '.') }}
                            </div>
                            <div class="fs-sm text-gray-500 mt-1">Omzet Tahun Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="g-col-12 g-col-lg-8 mt-6 intro-y">
            <div class="box p-5 h-full shadow-sm">
                <div class="d-flex align-items-center mb-5">
                    <h2 class="fw-bold fs-lg me-auto">Analisis Keuangan & Penjualan</h2>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm d-none d-md-inline-block" data-bs-toggle="modal" data-bs-target="#modal-harian">Detail Harian</button>
                        <button class="btn btn-outline-secondary btn-sm d-none d-md-inline-block" data-bs-toggle="modal" data-bs-target="#modal-rincian">Detail Bulanan</button>
                        
                        <!-- Mobile Icons -->
                        <button class="btn btn-success btn-sm d-md-none text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-harian" title="Detail Harian">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                        </button>
                        <button class="btn btn-primary btn-sm d-md-none text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-rincian" title="Detail Bulanan">
                            <i data-feather="bar-chart-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                <div class="report-chart">
                    <div id="main-sales-chart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Feed -->
        <div class="g-col-12 g-col-lg-4 mt-6 intro-y">
            <div class="box p-5 h-full d-flex flex-column">
                <h2 class="fw-bold fs-lg mb-5">Pesanan Terbaru</h2>
                <div class="report-timeline position-relative flex-1">
                    @foreach ($recent['bookings'] as $b)
                        <div class="intro-x d-flex align-items-center mb-4">
                            <div class="w-10 h-10 flex-none image-fit rounded-circle overflow-hidden bg-gray-100 p-2">
                                <i data-feather="calendar" class="w-full h-full text-warning"></i>
                            </div>
                            <div class="ms-4 me-auto">
                                <div class="fw-bold">{{ $b->no_pol_kendaraan }}</div>
                                <div class="text-gray-500 fs-xs mt-0.5">{{ $b->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="badge bg-warning/20 text-warning rounded-pill px-3">{{ $b->status }}</span>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.booking') }}" class="btn btn-outline-secondary w-full border-dotted mt-4">Lihat Semua Pesanan</a>
            </div>
        </div>

        <!-- Secondary Feed -->
        <div class="g-col-12 g-col-lg-6 mt-6 intro-y">
            <div class="box p-5 h-full d-flex flex-column">
                <div class="d-flex align-items-center mb-4">
                    <h2 class="fw-bold fs-lg me-auto mb-0">Transaksi Terakhir</h2>
                    <span class="badge bg-success/15 text-success rounded-pill px-3 fs-xs">{{ count($recent['transactions']) }} transaksi</span>
                </div>
                <div class="d-flex flex-column gap-2 flex-1">
                    @forelse ($recent['transactions'] as $trx)
                        <div class="d-flex align-items-center gap-3 px-3 py-2 rounded-2 trx-row">
                            <div class="flex-none">
                                @php
                                    $mp = strtolower($trx->metode_pembayaran ?? '');
                                    $mpColor = str_contains($mp, 'cash') ? 'success' : (str_contains($mp, 'qris') ? 'warning' : 'primary');
                                    $mpIcon  = str_contains($mp, 'cash') ? 'dollar-sign' : (str_contains($mp, 'qris') ? 'grid' : 'credit-card');
                                @endphp
                                <div class="w-9 h-9 rounded-circle bg-{{ $mpColor }}/10 d-flex align-items-center justify-content-center">
                                    <i data-feather="{{ $mpIcon }}" class="text-{{ $mpColor }}" style="width:15px;height:15px;"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-dark fs-sm text-truncate">{{ $trx->no_pol_kendaraan }}</span>
                                    <span class="badge bg-{{ $mpColor }}/15 text-{{ $mpColor }} rounded-pill px-2" style="font-size:10px;">{{ strtoupper($trx->metode_pembayaran) }}</span>
                                </div>
                                <div class="text-gray-400 fs-xs text-truncate mt-0.5">{{ $trx->product_name }}</div>
                            </div>
                            <div class="text-end flex-none">
                                <div class="fw-bold text-dark fs-sm">Rp {{ number_format($trx->total, 0, ',', '.') }}</div>
                                <div class="text-gray-400 fs-xs">{{ $trx->tgl_bayar ? \Carbon\Carbon::parse($trx->tgl_bayar)->format('d/m H:i') : $trx->created_at->format('d/m H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-5">
                            <i data-feather="inbox" class="mb-2" style="width:28px;height:28px;opacity:.4;"></i>
                            <div class="fs-sm">Belum ada transaksi</div>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('admin.transaksi') }}" class="btn btn-outline-secondary w-full border-dotted mt-4">Riwayat Transaksi</a>
            </div>
        </div>

        <div class="g-col-12 g-col-lg-6 mt-6 intro-y">
            <div class="box p-5 h-full d-flex flex-column">
                <div class="d-flex align-items-center mb-4">
                    <h2 class="fw-bold fs-lg me-auto mb-0">Aktivitas Terkini</h2>
                    <span class="badge bg-primary/10 text-primary rounded-pill px-3 fs-xs">Log</span>
                </div>
                <div class="d-flex flex-column gap-0 flex-1">
                    @forelse ($recent['activities'] as $i => $item)
                        <div class="d-flex gap-3 pb-3 {{ !$loop->last ? 'border-bottom border-gray-100 mb-3' : '' }}">
                            <div class="flex-none d-flex flex-column align-items-center">
                                <div class="w-8 h-8 rounded-circle bg-primary/10 d-flex align-items-center justify-content-center">
                                    <i data-feather="clock" class="text-primary" style="width:13px;height:13px;"></i>
                                </div>
                                @if (!$loop->last)
                                    <div style="width:1px;flex:1;background:rgba(0,0,0,0.06);margin-top:4px;"></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 pb-1">
                                <div class="d-flex align-items-center gap-2 mb-0.5">
                                    <span class="fw-semibold text-dark fs-sm">
                                        {{ $item->booking?->no_pol_kendaraan ?? '—' }}
                                    </span>
                                    <span class="text-gray-400 fs-xs ms-auto">{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-gray-500 fs-xs">{{ $item->histori }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 py-5">
                            <i data-feather="activity" class="mb-2" style="width:28px;height:28px;opacity:.4;"></i>
                            <div class="fs-sm">Belum ada aktivitas</div>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('admin.histori') }}" class="btn btn-outline-secondary w-full border-dotted mt-3">Log Seluruh Aktivitas</a>
            </div>
        </div>
    </div>

    <!-- Modals (Simplified versions of existing ones) -->
    @include('admin.partials.dashboard_modals')

@endsection

@section('css')
    <style>
        .report-box:before {
            content: "";
            width: 90%;
            background: rgba(var(--color-theme-1), .05);
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            margin-top: .75rem;
            border-radius: .75rem;
        }
        .hover-bg-gray-100:hover {
            background-color: rgba(0,0,0,0.02);
        }
        .trx-row {
            transition: background .15s;
        }
        .trx-row:hover {
            background-color: rgba(0,0,0,0.025);
        }

        /* Force remove all header borders */
        .box h2, .box .d-flex.border-bottom {
            border-bottom: none !important;
        }

        /* Remove vertical timeline line */
        .report-timeline:before {
            display: none !important;
        }

        /* Fix for footer line and bottom spacing */
        .content {
            border: none !important;
            box-shadow: none !important;
            padding-bottom: 50px !important;
        }

        /* FIX: Prevent chart clipping/blur at edges */
        #main-sales-chart, #main-sales-chart svg {
            overflow: visible !important;
        }
        .apexcharts-canvas {
            margin: 0 auto;
        }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            const chartData = @json($chartData);
            
            if (chartData && chartData.length > 0) {
                const options = {
                    series: [{
                        name: 'Omzet',
                        data: chartData.map(d => d.revenue)
                    }, {
                        name: 'Pemasukan Lain',
                        data: chartData.map(d => d.other_income)
                    }, {
                        name: 'Pengeluaran',
                        data: chartData.map(d => d.expense)
                    }, {
                        name: 'Belum Dibayar',
                        data: chartData.map(d => d.unpaid)
                    }, {
                        name: 'Laba Bersih',
                        data: chartData.map(d => d.net)
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        toolbar: { show: false },
                        fontFamily: 'Poppins, sans-serif',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4,
                        padding: {
                            left: 15,
                            right: 25,
                            top: 0,
                            bottom: 0
                        }
                    },
                    colors: ['#f59e0b', '#8b5cf6', '#ef4444', '#3b82f6', '#10b981'],
                    fill: {
                        type: 'solid',
                        opacity: 0.1
                    },
                    dataLabels: { enabled: false },
                    stroke: { 
                        curve: 'smooth', 
                        width: 3,
                        lineCap: 'round'
                    },
                    markers: {
                        size: 5,
                        colors: ['#f59e0b', '#ef4444', '#3b82f6', '#10b981'],
                        strokeColors: '#fff',
                        strokeWidth: 2,
                        hover: { size: 7 }
                    },
                    xaxis: {
                        categories: chartData.map(d => d.month),
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        crosshairs: { show: true },
                        labels: {
                            trim: false, // Prevent cutting off month names
                            style: {
                                colors: '#64748b',
                                fontSize: '11px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function (val) {
                                return val >= 1000000 ? (val / 1000000).toFixed(1) + ' jt' : val.toLocaleString('id-ID');
                            }
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function (val) {
                                return "Rp " + val.toLocaleString('id-ID');
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'center', // Centered to prevent edge clipping
                        offsetY: -10,
                        itemMargin: {
                            horizontal: 15,
                            vertical: 5
                        },
                        labels: {
                            colors: '#64748b'
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#main-sales-chart"), options);
                chart.render();
            }

            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection
