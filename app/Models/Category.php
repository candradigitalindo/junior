<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Uuids;
    protected $fillable = ['name'];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
