<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = ['slug', 'name', 'barcode', 'stok', 'description', 'barang_masuk', 'barang_keluar'];

    public function historibarang()
    {
        return $this->hasMany(Historibarang::class);
    }
}
