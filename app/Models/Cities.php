<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['city_name', 'city_code', 'state_id'];


    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }
}
