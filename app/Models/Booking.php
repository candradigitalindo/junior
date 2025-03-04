<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use Uuids;
    protected $fillable = ['product_id', 'no_pol_kendaraan', 'name', 'tipe_mobil', 'phone', 'tgl_booking', 'waktu_booking', 'description', 'status', 'status_pembayaran', 'tgl_proses', 'tgl_selesai', 'tgl_selesai_booking', 'waktu_selesai_booking', 'photo_tipe_mobil', 'status_kendaraan'];

    public function bookingorder()
    {
        return $this->hasMany(Bookingorder::class);
    }

    public function cekmasuk()
    {
        return $this->hasOne(Cekmasuk::class);
    }

    public function cekkeluar()
    {
        return $this->hasOne(Cekkeluar::class);
    }

    public function histori()
    {
        return $this->hasMany(Histori::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    public function photocek()
    {
        return $this->hasMany(Photocek::class);
    }
}
