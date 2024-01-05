<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Purchases extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
    'person_id',
    'purchase_desc',
    'purchase_date',
    'purchase_number',
    'purchase_status',
    'purchase_type'
    ];

    public function person()
    {
        return $this->belongsTo(Persons::class);
    }

}
