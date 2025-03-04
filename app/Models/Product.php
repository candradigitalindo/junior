<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Uuids;
    protected $fillable = ['category_id', 'name', 'price', 'description', 'foto'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function extraservice()
    {
        return $this->hasMany(Extraservice::class);
    }

    public function stepproduct()
    {
        return $this->hasMany(Stepproduct::class);
    }
}
