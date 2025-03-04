<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extraservice extends Model
{
    use Uuids;
    protected $fillable = ['product_id', 'name', 'price', 'description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
