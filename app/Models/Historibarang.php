<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historibarang extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = ['barang_id', 'status'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
