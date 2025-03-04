<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photocek extends Model
{
    use Uuids;
    protected $fillable = ['booking_id', 'photo', 'name'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
