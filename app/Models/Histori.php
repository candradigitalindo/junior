<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histori extends Model
{
    use Uuids;
    protected $fillable = ['booking_id', 'histori'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
