<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProofPayments extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['proof_payment_desc','payment_type_id'];

    public function paymentType()
    {
        return $this->belongsTo(PaymentTypes::class);
    }
}