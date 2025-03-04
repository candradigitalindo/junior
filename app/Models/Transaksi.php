<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use Uuids;
    protected $fillable = ['booking_id', 'invoice', 'discount', 'total', 'metode_pembayaran', 'tgl_bayar', 'keterangan'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
