<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Histori;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        
        // Key Metrics based on tgl_booking
        $stats = [
            'booking_month' => Booking::whereMonth('tgl_booking', $month)->whereYear('tgl_booking', $year)->count(),
            'visits_month'  => Booking::where('status', 'Selesai')->whereMonth('tgl_booking', $month)->whereYear('tgl_booking', $year)->count(),
            'total_products' => Product::count(),
            'total_users'    => User::count(),
            'revenue_month'  => Transaksi::join('bookings', 'transaksis.booking_id', '=', 'bookings.id')
                ->whereNotNull('transaksis.tgl_bayar')
                ->whereMonth('bookings.tgl_booking', $month)
                ->whereYear('bookings.tgl_booking', $year)
                ->sum('transaksis.total'),
            'revenue_year'   => Transaksi::join('bookings', 'transaksis.booking_id', '=', 'bookings.id')
                ->whereNotNull('transaksis.tgl_bayar')
                ->whereYear('bookings.tgl_booking', $year)
                ->sum('transaksis.total'),
        ];

        // Recent Data
        $recent = [
            'transactions' => Transaksi::with('booking')->whereNotNull('tgl_bayar')->orderBy('tgl_bayar', 'DESC')->limit(6)->get(),
            'activities'   => Histori::with('booking')->orderBy('created_at', 'DESC')->limit(6)->get(),
            'bookings'     => Booking::orderBy('tgl_booking', 'DESC')->orderBy('waktu_booking', 'DESC')->limit(7)->get(),
        ];

        // Optimized Chart Data Collection using tgl_booking
        $driver = DB::connection()->getDriverName();
        if ($driver == 'sqlite') {
            $monthFunc = "strftime('%m', bookings.tgl_booking)";
            $dayFunc = "strftime('%d', bookings.tgl_booking)";
            $dayFuncCreated = "strftime('%d', created_at)";
        } elseif ($driver == 'pgsql') {
            $monthFunc = "EXTRACT(MONTH FROM bookings.tgl_booking)";
            $dayFunc = "EXTRACT(DAY FROM bookings.tgl_booking)";
            $dayFuncCreated = "EXTRACT(DAY FROM created_at)";
        } else {
            $monthFunc = "MONTH(bookings.tgl_booking)";
            $dayFunc = "DAY(bookings.tgl_booking)";
            $dayFuncCreated = "DAY(created_at)";
        }

        $monthlyRevenue = Transaksi::join('bookings', 'transaksis.booking_id', '=', 'bookings.id')
            ->selectRaw("$monthFunc as month, SUM(transaksis.total) as total")
            ->whereYear('bookings.tgl_booking', $year)
            ->whereNotNull('transaksis.tgl_bayar')
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month');

        $monthlyExpense = Pengeluaran::selectRaw($driver == 'sqlite' ? "strftime('%m', created_at) as month, SUM(jumlah) as total" : ($driver == 'pgsql' ? "EXTRACT(MONTH FROM created_at) as month, SUM(jumlah) as total" : "MONTH(created_at) as month, SUM(jumlah) as total"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month');

        $monthlyOtherIncome = Pemasukan::selectRaw($driver == 'sqlite' ? "strftime('%m', created_at) as month, SUM(jumlah) as total" : ($driver == 'pgsql' ? "EXTRACT(MONTH FROM created_at) as month, SUM(jumlah) as total" : "MONTH(created_at) as month, SUM(jumlah) as total"))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month');

        $monthlyUnpaid = Transaksi::join('bookings', 'transaksis.booking_id', '=', 'bookings.id')
            ->selectRaw("$monthFunc as month, SUM(transaksis.total) as total")
            ->whereYear('bookings.tgl_booking', $year)
            ->whereNull('transaksis.tgl_bayar')
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month');

        $chartData = [];
        foreach (range(1, 12) as $m) {
            $mKey = $driver == 'sqlite' ? str_pad($m, 2, '0', STR_PAD_LEFT) : $m;
            $revenue = $monthlyRevenue->get($mKey, 0);
            $expense = $monthlyExpense->get($mKey, 0);
            $otherIncome = $monthlyOtherIncome->get($mKey, 0);
            $unpaid = $monthlyUnpaid->get($mKey, 0);
            
            $chartData[] = [
                'month' => Carbon::create($year, $m, 1)->translatedFormat('F'),
                'revenue' => (int)$revenue,
                'other_income' => (int)$otherIncome,
                'expense' => (int)$expense,
                'unpaid' => (int)$unpaid,
                'net' => (int)($revenue + $otherIncome - $expense)
            ];
        }

        // Daily Chart Data (Current Month)
        $daysInMonth = $now->daysInMonth;
        
        $dailyRevenue = Transaksi::join('bookings', 'transaksis.booking_id', '=', 'bookings.id')
            ->selectRaw("$dayFunc as day, SUM(transaksis.total) as total")
            ->whereMonth('bookings.tgl_booking', $month)
            ->whereYear('bookings.tgl_booking', $year)
            ->whereNotNull('transaksis.tgl_bayar')
            ->groupBy('day')
            ->get()
            ->pluck('total', 'day');

        $dailyExpense = Pengeluaran::selectRaw($driver == 'sqlite' ? "strftime('%d', created_at) as day, SUM(jumlah) as total" : ($driver == 'pgsql' ? "EXTRACT(DAY FROM created_at) as day, SUM(jumlah) as total" : "DAY(created_at) as day, SUM(jumlah) as total"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('day')
            ->get()
            ->pluck('total', 'day');

        $dailyOtherIncome = Pemasukan::selectRaw($driver == 'sqlite' ? "strftime('%d', created_at) as day, SUM(jumlah) as total" : ($driver == 'pgsql' ? "EXTRACT(DAY FROM created_at) as day, SUM(jumlah) as total" : "DAY(created_at) as day, SUM(jumlah) as total"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('day')
            ->get()
            ->pluck('total', 'day');

        $dailyUnpaid = Transaksi::join('bookings', 'transaksis.booking_id', '=', 'bookings.id')
            ->selectRaw("$dayFunc as day, SUM(transaksis.total) as total")
            ->whereMonth('bookings.tgl_booking', $month)
            ->whereYear('bookings.tgl_booking', $year)
            ->whereNull('transaksis.tgl_bayar')
            ->groupBy('day')
            ->get()
            ->pluck('total', 'day');

        $dailyData = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dKey = $driver == 'sqlite' ? str_pad($d, 2, '0', STR_PAD_LEFT) : $d;
            $revenue = $dailyRevenue->get($dKey, 0);
            $expense = $dailyExpense->get($dKey, 0);
            $otherIncome = $dailyOtherIncome->get($dKey, 0);
            $unpaid = $dailyUnpaid->get($dKey, 0);

            $dailyData[] = [
                'day' => $d,
                'revenue' => (int)$revenue,
                'expense' => (int)$expense,
                'other_income' => (int)$otherIncome,
                'unpaid' => (int)$unpaid,
                'net' => (int)($revenue + $otherIncome - $expense)
            ];
        }

        return view('dashboard', compact('stats', 'recent', 'chartData', 'dailyData'));
    }
}
