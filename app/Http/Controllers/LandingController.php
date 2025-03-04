<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bookingorder;
use App\Models\Category;
use App\Models\Galery;
use App\Models\Product;
use App\Models\Tagmeta;
use App\Models\Testimoni;
use App\Models\Tipemobil;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // $category_first = Category::orderBy('created_at', 'ASC')->with(['product' => function ($query) {
        //     $query->orderBy('price', 'ASC');
        // }])->first();
        // $category = Category::orderBy('created_at', 'ASC')->with(['product' => function ($queryy) {
        //     $queryy->orderBy('price', 'ASC');
        // }])->get();
        // $product = Product::orderBy('price', 'ASC')->get();
        // $galery = Galery::orderBy('created_at', 'DESC')->take(6)->get();
        // $testimoni = Testimoni::orderBy('created_at', 'DESC')->get();
        // $tagmeta = Tagmeta::orderBy('created_at', 'ASC')->first();
        // $tipemobil = Tipemobil::orderBy('name', 'ASC')->get();
        // return view('landing.index', compact('category', 'product', 'galery', 'testimoni', 'tagmeta', 'tipemobil'));
        return redirect()->route('login');
    }

    public function about()
    {
        return view('landing.about');
    }

    public function layanan()
    {
        $category = Category::orderBy('created_at', 'ASC')->with(['product' => function ($queryy) {
            $queryy->orderBy('price', 'ASC');
        }])->get();
        $product = Product::orderBy('price', 'ASC')->get();
        $tipemobil = Tipemobil::orderBy('name', 'ASC')->get();
        return view('landing.layanan', compact('category', 'product', 'tipemobil'));
    }

    public function booking()
    {
        $booking = Booking::where('tgl_booking', date('Y-m-d'))->orderBy('created_at', 'DESC')->where('status', '!=', 'Selesai')->get();

        return view('landing.booking', compact('booking'));
    }

    public function galery()
    {
        $galery = Galery::orderBy('created_at', 'DESC')->take(10)->get();
        return view('landing.galery', compact('galery'));
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function cek($kendaraan)
    {
        $booking = Booking::where('no_pol_kendaraan', $this->plat($kendaraan))->orderBy('created_at', 'DESC')->get();

        if (request()->ajax()) {
            return datatables()->of($booking)
                ->addColumn('bookingorder', function ($booking) {
                    $bookingorder = Bookingorder::where('booking_id', $booking->id)->get();
                    foreach ($bookingorder as $order) {
                        $data[]  = $order->product_name;
                    }

                    return implode(", ", $data);
                    // return $bookingorder;
                })
                ->addColumn('tanggal', function ($booking) {

                    return date('d-m-Y H:i', strtotime($booking->created_at));
                })
                ->rawColumns(['bookingorder', 'tanggal'])
                ->make(true);
        }
    }

    private function plat($text)
    {
        $string = strtoupper(trim($text));

        $pattern = '/^([A-Z]{1,3})(\s|-)*([1-9][0-9]{0,3})(\s|-)*([A-Z]{0,3}|[1-9][0-9]{1,2})$/i';
        if (preg_match($pattern, $string)) {
            return trim(strtoupper(preg_replace($pattern, '$1 $3 $5', $string)));
        }
    }

    public function bookingorder(Request $request, $id)
    {
        $this->validate($request, [
            'no_pol_kendaraan'  => 'required|string',
            'tipe_mobil'        => 'required|string',
            'phone'             => 'required|string',
            'tgl_booking'       => 'required|date',
            'waktu_booking'     => 'required|string',
            'layanan'           => 'required|string'
        ]);

        if ($request->tipe_mobil == 'Lainnya') {
            $product = Product::find($id);
            $booking = Booking::create([
                'no_pol_kendaraan' => $this->plat($request->no_pol_kendaraan),
                'tipe_mobil'       => strtoupper($request->tipe_mobil),
                'phone'            => $request->phone,
                'tgl_booking'      => $request->tgl_booking,
                'waktu_booking'    => $request->waktu_booking,
                'description'      => $request->layanan,
                'status'           => 'Booking',
                'product_id'       => $product->id
            ]);

            Bookingorder::create([
                'booking_id'    => $booking->id,
                'product_name'  => $product->name,
                'product_price' => $product->price,
                'total'         => $product->price
            ]);

            return redirect(route('landing.booking'));
        }

        $tipemobil = Tipemobil::find($request->tipe_mobil);
        $product = Product::find($id);
        $booking = Booking::create([
            'no_pol_kendaraan' => $this->plat($request->no_pol_kendaraan),
            'tipe_mobil'       => $tipemobil->name,
            'phone'            => $request->phone,
            'tgl_booking'      => $request->tgl_booking,
            'waktu_booking'    => $request->waktu_booking,
            'description'      => $request->layanan,
            'status'           => 'Booking',
            'photo_tipe_mobil' => $tipemobil->photo,
            'product_id'       => $product->id
        ]);

        Bookingorder::create([
            'booking_id'    => $booking->id,
            'product_name'  => $product->name,
            'product_price' => $product->price,
            'total'         => $product->price
        ]);

        return redirect(route('landing.booking'));
    }
}
