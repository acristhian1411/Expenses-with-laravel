<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TillDetailProofPayments extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'till_detail_id',
        'proof_payments_id',
        'td_pr_desc'
    ];

    public function proofPayments()
    {
        return $this->belongsTo(ProofPayments::class);
    }

    public function tillDetail()
    {
        return $this->belongsTo(TillDetails::class);
    }
}
