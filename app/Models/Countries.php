<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Countries extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['country_name', 'country_code'];

    public function states()
    {
        return $this->hasMany(States::class);
    }

}
