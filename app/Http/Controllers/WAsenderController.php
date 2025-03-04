<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Device;
use App\Models\Photocek;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class WAsenderController extends Controller
{
    public function send($id)
    {
        $booking = Booking::find($id);


        $api_key   = env('API_KEY'); // API KEY Anda
        $id_device = env('ID_DEVICE_WATSAP'); // ID DEVICE yang di SCAN (Sebagai pengirim)
        $url   = env('WHATSAPP_API'); // URL API
        $no_hp = $booking->phone; // No.HP yang dikirim (No.HP Penerima)
        $pesan = 'Halo,
Semoga Anda selalu diberikan kesehatan dan Kebahagiaan.

Kami dari *KILAT PREMIUM WASH* memberitahukan kendaraan :

        *No : ' . $booking->no_pol_kendaraan . '*

PENGERJAAN LAYANAN ANDA SUDAH SELESAI, Silahkan untuk melakukan pengambilan Kendaraan Anda. Terima kasih 🙏🏻

Info lebih lanjut Telp/WhatsApp : *0821 6061 9089*
———————————————————-

www.kilatpremiumwash.com
@kilatpremiumwash';

        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_HEADER, 0);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        // curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($curl, CURLOPT_POST, 1);

        // $data_post = [
        //     'id_device' => $id_device,
        //     'api-key' => $api_key,
        //     'no_hp'   => $no_hp,
        //     'pesan'   => $pesan
        // ];
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
        // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        // $response = curl_exec($curl);
        // curl_close($curl);

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://wa-kilatwash.candio.co.id/send-message',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array('message' => $pesan,'number' => $booking->phone)
        // ));

        //   $response = curl_exec($curl);

        //   curl_close($curl);
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
                'Authorization: ' //change TOKEN to your actual token
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
        if ($device == true) {
            $data = [
                'api_key' => env('API_KEY'),
                'sender'  => $device->device,
                'number'  => $this->hp($booking->phone),
                'message' =>
                'Halo,
Semoga Anda selalu diberikan kesehatan.
Kami dari KILAT PREMIUM WASH memberitahukan kendaraan :

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

            // $photocek = Photocek::where('booking_id', $booking->id)->get();
            // foreach ($photocek as $photo) {
            //     $data_photo = [
            //         'api_key' => env('API_KEY'),
            //         'sender'  => $device->device,
            //         'number'  => $this->hp($booking->phone),
            //         'message' => $photo->name,
            //         'url'     => 'https://kilatpremiumwash.com/storage/product/3KvLvKfGuRc3c0fIE3fMoX7E6wAD2WWHCpjVqwTc.png'
            //     ];

            //     $curl_photo = curl_init();
            //     curl_setopt_array(
            //         $curl_photo,
            //         array(
            //             CURLOPT_URL => 'https://whatsapp.candio.co.id/send-image',
            //             CURLOPT_RETURNTRANSFER => true,
            //             CURLOPT_ENCODING => "",
            //             CURLOPT_MAXREDIRS => 10,
            //             CURLOPT_TIMEOUT => 0,
            //             CURLOPT_FOLLOWLOCATION => true,
            //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //             CURLOPT_CUSTOMREQUEST => "POST",
            //             CURLOPT_POSTFIELDS => http_build_query($data_photo)
            //         )
            //     );

            //     $response_photo = curl_exec($curl_photo);
            //     curl_close($curl_photo);
            // }
            $json = json_decode($response, true);
            if ($json['status'] == true) {
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
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate(url(route('invoice.index', $transaksi->invoice))));
        $pdf = PDF::loadView('cetak.invoice', compact('transaksi', 'qrcode', 'booking'));

        $cek = Storage::disk('local')->exists('public/invoice/' . $transaksi->invoice . '.pdf');
        if (!$cek) {
            $content = $pdf->download()->getOriginalContent();
            Storage::put('public/invoice/' . $transaksi->invoice . '.pdf', $content);
        }
        $device = Device::first();
        if ($device == true) {
            $data = [
                'api_key' => env('API_KEY'),
                'sender'  => $device->device,
                'number'  => $this->hp($booking->phone),
                'url' => Storage::get(asset('storage/invoice/' . $transaksi->invoice . '.pdf'))
            ];
            dd($data);

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
            if ($json['status'] == true) {
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

    private function hp($nohp)
    {
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);

        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nohp), 0, 3) == '+62') {
                $hp = '62' . substr(trim($nohp), 3);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '62' . substr(trim($nohp), 1);
            }
        }
        return $hp;
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
                'device' => $request->device
            ]);

            return response()->json(['text' => 'Update Device Whatsapp ' . $device->device . ' berhasil.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}
