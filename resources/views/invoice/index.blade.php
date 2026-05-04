@extends('layouts.invoice')
@section('title')
    INVOICE
@endsection
@section('content')
    <!-- BEGIN: Invoice -->
    <div class="intro-y box overflow-hidden mt-5">
        <div class="d-flex flex-column flex-lg-row pt-10 px-5 px-sm-20 pt-sm-20 pb-lg-20 text-center text-sm-start">
            <div class="fw-bold text-theme-1 dark-text-theme-10 fs-3xl" style="letter-spacing: 2px;">
                JUNIOR <span class="text-warning">PREMIUM</span>
                <div class="fs-sm fw-medium text-secondary" style="letter-spacing: 4px; margin-top: -5px;">AUTO CARE</div>
            </div>
            <div class="mt-20 mt-lg-0 ms-lg-auto text-lg-end">
                <div class="mt-1">WhatsApp 081367717172</div>
                <div class="mt-1">Alamat : Jl. Perjuangan No.23</div>
                <div class="mt-1">Kota Medan, Sumatera Utara.</div>
                <div class="mt-1"></div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-lg-row border-bottom px-5 px-sm-20 pt-10 pb-10 pb-sm-20 text-center text-sm-start">
            <div>
                <div class="fs-base text-gray-600">Client Details</div>
                <div class="fs-lg fw-medium text-theme-1 dark-text-theme-10 mt-2">No Kendaraan
                    {{ $booking->no_pol_kendaraan }}</div>
                <div class="mt-1">Tipe kendaraan {{ $booking->tipe_mobil }}</div>
            </div>
            <div class="mt-10 mt-lg-0 ms-lg-auto text-lg-end">
                <div class="fs-base text-gray-600">Receipt</div>
                <div class="fs-lg text-theme-1 dark-text-theme-10 fw-medium mt-2">#{{ $invoice->invoice }}</div>
                <div class="mt-1">{{ date('d-m-Y H:i', strtotime($invoice->created_at)) }} WIB</div>
            </div>
        </div>
        <div class="px-5 px-sm-16 py-10 py-sm-20">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-nowrap">Jasa Layanan</th>
                            <th class="text-end text-nowrap">Subtotal</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($booking->bookingorder as $item)
                            <tr>
                                <td>
                                    <div class="fw-medium text-nowrap">{{ $item->product_name }}</div>
                                </td>
                                <td class="text-end w-32 fw-medium">Rp.
                                    {{ number_format($item->product_price, 0, ',', '.') }}</td>

                            </tr>
                            <tr>
                                @if ($item->extraservice_price == 0)
                                @else
                                    <td>
                                        <div class="fw-medium text-nowrap">{{ $item->extraservice_name }}
                                        </div>
                                    </td>
                                    <td class="text-end w-32 fw-medium">Rp.
                                        {{ number_format($item->extraservice_price, 0, ',', '.') }}</td>
                                @endif
                            </tr>
                        @endforeach
                        <tr>
                            @if ($invoice->discount == 0)
                            @else
                                <td>
                                    <div class="fw-medium text-nowrap">Diskon</div>
                                </td>
                                <td class="text-end w-32 fw-medium">- Rp.
                                    {{ number_format($invoice->discount, 0, ',', '.') }}</td>
                            @endif
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-5 px-sm-20 pb-10 pb-sm-20 d-flex flex-column-reverse flex-sm-row">
            <div class="text-center text-sm-start mt-10 mt-sm-0">
                <div class="fs-base text-gray-600">Metode Pembayaran : {{ $invoice->metode_pembayaran }}</div>

            </div>
            <div class="text-center text-sm-end ms-sm-auto">
                <div class="fs-base text-gray-600">Total Bayar</div>
                <div class="fs-xl text-theme-1 dark-text-theme-10 fw-medium mt-2">Rp.
                    {{ number_format($invoice->total, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->
@endsection
 }}</div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->
@endsection
