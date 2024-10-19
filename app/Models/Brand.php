<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;
    protected $fillable = ['brand_name','brand_desc'];

    public function brandProducts(){
        return $this->hasMany(BrandProduct::class);
    }
}
