<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use Uuids;
    protected $fillable = ['booking_id', 'invoice', 'no_pol_kendaraan', 'tipe_mobil', 'product_name', 'product_price', 'discount', 'total', 'metode_pembayaran', 'tgl_bayar', 'keterangan'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
