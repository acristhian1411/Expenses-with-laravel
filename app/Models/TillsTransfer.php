<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
class TillsTransfer extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'origin_id',
        'destiny_id',
        't_transfer_amount',
        't_transfer_date',
        't_transfer_obs', 
    ];

    public function till()
    {
        return $this->belongsTo(Tills::class, 'till_id');
    }
}
