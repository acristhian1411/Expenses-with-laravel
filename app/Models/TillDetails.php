<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TillDetails extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    protected $fillable = [
        'till_id',
        'person_id',
        'account_p_id',
        'td_desc',
        'td_date',
        'td_type',
        'td_amount'
    ];

    public function till()
    {
        return $this->belongsTo(Tills::class, 'till_id');
    }

    public function person()
    {
        return $this->belongsTo(Persons::class, 'person_id');
    }

    public function account_p()
    {
        return $this->belongsTo(AccountPlan::class, 'account_p_id');
    }
}
