<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role->role;
        switch ($role) {
            case 'Superadmin':
                return redirect(route('admin.index'));
                break;
            case 'loket':
                return redirect(route('loket.home'));
                break;
            case 'pengecekan':
                return redirect(route('pengecekan.index'));
                break;
            case 'pengerjaan':
                return redirect(route('histori.index'));
                break;
            case 'kasir':
                return redirect(route('kasir.dashboard'));
                break;
            case 'gudang':
                return redirect(route('gudang.index'));
                break;
            default:
                # code...
                break;
        }
    }
}
