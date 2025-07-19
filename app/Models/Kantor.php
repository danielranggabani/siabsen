<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kantor extends Model
{
    protected $fillable = [
        'name',
        'lokasi',
        'qr_code',
    ];
}
