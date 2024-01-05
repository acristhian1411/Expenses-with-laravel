<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'sale_desc',
        'sale_date',
        'sale_number',
        'sale_status',
        'sale_type'
        ];

    public function person()
    {
        return $this->belongsTo(Persons::class);
    }
}
