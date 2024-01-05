<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// add softdeletes
use Illuminate\Database\Eloquent\SoftDeletes;

class IvaType extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['iva_type_desc','iva_type_percent'];


    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
