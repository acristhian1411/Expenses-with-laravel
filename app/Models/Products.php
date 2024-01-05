<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        'product_name',
        'product_desc',
        'product_cost_price',
        'product_quantity',
        'product_selling_price',
        'category_id',
        'iva_type_id'
    ];


    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function ivaType()
    {
        return $this->belongsTo(IvaType::class);
    }

}
