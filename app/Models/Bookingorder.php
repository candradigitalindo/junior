<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookingorder extends Model
{
    use Uuids;
    protected $fillable = ['booking_id', 'product_name', 'product_price', 'extraservice_name', 'extraservice_price'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
