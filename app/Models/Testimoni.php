<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use Uuids;
    protected $fillable = ['photo', 'testimoni', 'name', 'pekerjaan'];
}
