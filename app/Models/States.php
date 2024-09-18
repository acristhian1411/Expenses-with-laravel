<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class States extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['state_name', 'country_id'];

    public function cities()
    {
        return $this->hasMany(States::class);
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
}
