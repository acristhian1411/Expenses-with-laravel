<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTypes extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = ['payment_type_desc'];

    

}
