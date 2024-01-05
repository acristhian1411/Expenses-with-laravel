<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PersonTypes extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = ['p_type_desc'];

    public function persons()
    {
        return $this->hasMany(Persons::class);
    }

}
