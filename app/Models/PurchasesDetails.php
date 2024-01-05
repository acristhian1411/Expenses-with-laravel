<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasesDetails extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'pd_desc',
        'pd_qty',
        'pd_amount'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchases::class, 'purchase_id', 'id');
    }
}
