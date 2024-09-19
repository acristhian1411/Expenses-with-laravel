<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
class Cities extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['city_name', 'city_code', 'state_id'];


    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }
}
