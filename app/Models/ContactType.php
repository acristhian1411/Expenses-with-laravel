<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactType extends Model implements AuditableContract
{
    use HasFactory, Auditable, SoftDeletes;

    protected $fillable = ['cont_type_desc'];
    
}
