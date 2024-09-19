<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

use Illuminate\Database\Eloquent\SoftDeletes;


class Categories extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;
    protected $fillable = ['cat_desc'];

    public function products()
    {
        return $this->hasMany(Products::class);
    }

}
