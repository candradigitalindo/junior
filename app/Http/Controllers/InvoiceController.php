<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class InvoiceController extends Controller
{
    public function index($invoice)
    {
        $invoice = Transaksi::where('invoice', $invoice)->with('booking')->first();
        if ($invoice) {
            $booking = Booking::where('id', $invoice->booking_id)->with('bookingorder')->first();
            $qrcode = QrCode::size(100)->generate(url(route('invoice.index', $invoice->invoice)));
            return view('invoice.index', compact('invoice', 'qrcode', 'booking'));
        }

        return back();
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::where('booking_id', $id)->with('booking')->first();
        $booking = Booking::where('id', $transaksi->booking_id)->with('bookingorder')->first();
        $qrcode = QrCode::format('svg')->size(100)->errorCorrection('H')->generate($booking->id);
        $pdf = PDF::loadView('cetak.invoice', compact('transaksi', 'qrcode', 'booking'));
        return $pdf->stream();
    }
}
