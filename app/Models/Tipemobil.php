<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipemobil extends Model
{
    use Uuids;
    protected $fillable = ['photo', 'name'];
}
