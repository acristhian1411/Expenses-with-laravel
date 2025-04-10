<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TillDetailProofPayments extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    protected $fillable = [
        'till_detail_id',
        'proof_payment_id',
        'td_pr_desc'
    ];

    public function proofPayments()
    {
        return $this->belongsTo(ProofPayments::class, 'proof_payment_id');
    }

    public function tillDetail()
    {
        return $this->belongsTo(TillDetails::class, 'till_detail_id');
    }
}
