<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
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
