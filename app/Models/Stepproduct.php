<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stepproduct extends Model
{
    use Uuids;
    protected $fillable = ['product_id', 'step'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
