<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Categories extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = ['cat_desc'];

    public function products()
    {
        return $this->hasMany(Products::class);
    }

}
