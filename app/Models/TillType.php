<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TillType extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = ['till_type_desc'];

    public function tills()
    {
        return $this->hasMany(Tills::class);
    }
}
