<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagmeta extends Model
{
    use Uuids;
    protected $fillable = ['keywords', 'description', 'title'];
}
