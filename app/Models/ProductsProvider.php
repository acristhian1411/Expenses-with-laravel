<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsProvider extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;
    protected $fillable = ['product_id','provider_id'];

    public function product(){
        return $this->belongsTo(Products::class);
    }

    public function provider(){
        return $this->belongsTo(Persons::class);
    }
}
