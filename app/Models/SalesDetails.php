<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SalesDetails extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'sale_id',
        'product_id',
        'sd_desc',
        'sd_qty',
        'sd_amount'
    ];

}
