<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cekkeluar extends Model
{
    use Uuids;
    protected $fillable = ['booking_id', 'exterior', 'interior', 'mesin', 'barang_mobil'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
