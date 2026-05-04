<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Device;
use App\Models\Photocek;
use App\Models\Transaksi;
use App\Traits\PlatHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class WAsenderController extends Controller
{
    use PlatHelper;

    public function send($id)
    {
        $booking = Booking::find($id);

        $pesan = 'Halo,
Semoga Anda selalu diberikan kesehatan dan Kebahagiaan.

Kami dari *JUNIOR PREMIUM AUTO CARE* memberitahukan kendaraan :

        *No : ' . $booking->no_pol_kendaraan . '*

PENGERJAAN LAYANAN ANDA SUDAH SELESAI, Silahkan untuk melakukan pengambilan Kendaraan Anda. Terima kasih 🙏🏻

Info lebih lanjut Telp/WhatsApp : *0821 6061 9089*
———————————————————-

www.juniorwash.com
@juniorwash';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $booking->phone,
                'message' => $pesan,
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . env('FONNTE_TOKEN') // Recommendation: use env for token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        return response()->json(['status' => 'sukses', 'text' => 'Pesan terkirim']);
    }

    public function wa_foto($id)
    {
        $booking = Booking::find($id);
        $device = Device::first();
        if ($device) {
            $data = [
                'api_key' => env('API_KEY'),
                'sender'  => $device->device,
                'number'  => $this->hp($booking->phone),
                'message' =>
                'Halo,
Semoga Anda selalu diberikan kesehatan.
Kami dari JUNIOR WASH memberitahukan kendaraan :

        *No : ' . $booking->no_pol_kendaraan . '*

Berikut merupakan hasil foto pengecekan kendaraan Anda sebelum dilakukan Proses Pengerjaan.

Info lebih lanjut Telp/WhatsApp : *0821 6061 9089*

Terima kasih'
            ];

            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => env('WHATSAPP_API'),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => http_build_query($data)
                )
            );

            $response = curl_exec($curl);
            curl_close($curl);

            $json = json_decode($response, true);
            if (isset($json['status']) && $json['status'] == true) {
                return response()->json(['status' => 'sukses', 'text' => 'Pengiriman Pesan Berhasil']);
            }

            return response()->json(['status' => 'gagal', 'text' => 'Pengiriman Pesan Gagal, Silahkan dicoba kembali']);
        }
        return response()->json(['status' => 'gagal', 'text' => 'Gagal Mengirim Pesan, Sebab No WA Sender belum ada.']);
    }

    public function send_pdf($id)
    {
        $transaksi = Transaksi::where('booking_id', $id)->with('booking')->first();
        $booking = Booking::where('id', $transaksi->booking_id)->with('bookingorder')->first();
        $qrcode = QrCode::format('svg')->size(100)->errorCorrection('H')->generate(url(route('invoice.index', $transaksi->invoice)));
        $pdf = PDF::loadView('cetak.invoice', compact('transaksi', 'qrcode', 'booking'));

        $cek = Storage::disk('local')->exists('public/invoice/' . $transaksi->invoice . '.pdf');
        if (!$cek) {
            $content = $pdf->download()->getOriginalContent();
            Storage::put('public/invoice/' . $transaksi->invoice . '.pdf', $content);
        }
        
        $device = Device::first();
        if ($device) {
            $data = [
                'api_key' => env('API_KEY'),
                'sender'  => $device->device,
                'number'  => $this->hp($booking->phone),
                'url'     => url('storage/invoice/' . $transaksi->invoice . '.pdf')
            ];

            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'https://whatsapp.candio.co.id/send-document',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => http_build_query($data)
                )
            );

            $response = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($response, true);
            if (isset($json['status']) && $json['status'] == true) {
                return response()->json(['status' => 'sukses', 'text' => 'Pengiriman Pesan Berhasil']);
            }

            return response()->json(['status' => 'gagal', 'text' => 'Pengiriman Pesan Gagal, Silahkan dicoba kembali']);
        }
        return response()->json(['status' => 'gagal', 'text' => 'Gagal Mengirim Pesan, Sebab No WA Sender belum ada.']);
    }

    public function index()
    {
        $device = Device::first();
        return view('whatsapp.index', compact('device'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device'      => 'required|string',
        ]);

        if ($validator->passes()) {
            $device = Device::create([
                'device' => $this->hp($request->device)
            ]);

            return response()->json(['text' => 'Tambah Device Whatsapp ' . $device->device . ' berhasil.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function edit($id)
    {
        $device = Device::find($id);
        return response()->json(['data' => $device]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'device'      => 'required|string',
        ]);

        if ($validator->passes()) {
            $device = Device::find($id);
            $device->update([
                'device' => $this->hp($request->device)
            ]);

            return response()->json(['text' => 'Update Device Whatsapp ' . $device->device . ' berhasil.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}
