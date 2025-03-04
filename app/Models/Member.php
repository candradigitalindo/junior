<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use Uuids;
    protected $fillable = ['no_plat', 'tipe_mobil', 'name', 'phone'];
}
