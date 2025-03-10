<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tills extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;
    protected $fillable = [
        'till_name',
        'till_account_number',
        't_type_id',
        'till_status'
    ];

    public function type()
    {
        return $this->belongsTo(TillType::class, 't_type_id');
    }

    public function transfers(){
        return $this->hasMany(TillsTransfer::class);
    }
    public function details(){
        return $this->hasMany(TillDetails::class);
    }

    public function open(){
        $this->till_status = true;
        $this->save();
    }
    public function close(){
        $this->till_status = false;
        $this->save();
    }
}
