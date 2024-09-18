<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonTypes extends Model implements AuditableContract
{
    use HasFactory;

    use Auditable;
    use SoftDeletes;
    
    protected $fillable = ['p_type_desc'];

    public function persons()
    {
        return $this->hasMany(Persons::class);
    }

}
