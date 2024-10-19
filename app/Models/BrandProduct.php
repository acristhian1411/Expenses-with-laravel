<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;


class BrandProduct extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;
    protected $fillable = ['brand_id','product_id'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function product(){
        return $this->belongsTo(Products::class);
    }
}
