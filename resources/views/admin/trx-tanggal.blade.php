@extends('layouts.office')
@section('title')
    Dashboard Kasir
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Transaksi {{ $tanggal . ' ' . date('M Y') }}
                        </h2>

                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <a class="btn btn-warning w-45 me-8 mb-4" href="{{ route('home') }}"> <i data-feather="rewind"
                                    class="w-4 h-4 me-2"></i>Kembali Dashboard </a>
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-booking" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 1%">No</th>
                                    <th class="text-nowrap">Info Pelanggan</th>
                                    <th class="text-nowrap">Tgl Booking</th>
                                    <th class="text-nowrap">Keterangan</th>
                                    <th class="text-nowrap">Transaksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($trx_tanggal as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 20%">No. Pol Kendaraan</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            {{ $item->booking->no_pol_kendaraan }} <br>
                                                            {{ $item->booking->name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 20%">Tipe Mobil</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            {{ $item->booking->tipe_mobil }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 20%">No. HP</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            {{ $item->booking->phone }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 20%">Booking</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            {{ date('d-m-Y', strtotime($item->booking->tgl_booking)) .' ' .date('H:i', strtotime($item->booking->waktu_booking)) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 20%">Diproses</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            @if ($item->booking->tgl_proses == null)
                                                            @else
                                                                {{ date('d-m-Y H:i', strtotime($item->booking->tgl_proses)) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 20%">Selesai</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            @if ($item->booking->tgl_selesai == null)
                                                            @else
                                                                {{ date('d-m-Y H:i', strtotime($item->booking->tgl_selesai)) }}
                                                            @endif
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 20%">Orderan</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            @foreach ($item->booking->bookingorder as $val)
                                                                {{ $val->product_name }} <br>
                                                            @endforeach

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 20%">Total</td>
                                                        <td style="width: 2%">:</td>
                                                        <td>

                                                            {{ number_format($item->total, 0, ',', '.') . ' | Diskon : ' . number_format($item->discount, 0, ',', '.') }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 20%">Status Bayar</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">

                                                            {{ $item->booking->status_pembayaran }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 20%">Invoice</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            {{ $item->invoice }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 20%">Metode Bayar</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            {{ $item->metode_pembayaran }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 20%">Bukti Bayar</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">
                                                            @if ($item->keterangan == null)
                                                                Tidak ada Bukti Foto
                                                            @else
                                                                <img src="{{ asset('storage/bukti-pembayaran/' . $item->keterangan) }}"
                                                                    style="width: 50px" style="height: 50px" />
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="width: 20%">Tgl Bayar</td>
                                                        <td style="width: 2%">:</td>
                                                        <td style="width: 50%">

                                                            {{ date('d-m-Y H:i', strtotime($item->tgl_bayar)) }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->

            </div>
        </div>
    </div>
@endsection
