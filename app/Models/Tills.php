<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tills extends Model
{
    use HasFactory;

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
}
