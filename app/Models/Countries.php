<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use OwenIt\Auditing\Auditable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Countries extends Model implements AuditableContract
{
    use HasFactory;

    use SoftDeletes;

    use Auditable;

    protected $guarded = ['id'];
    protected $fillable = ['country_name', 'country_code'];

    public function states()
    {
        return $this->hasMany(States::class);
    }

}
