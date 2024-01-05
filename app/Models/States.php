<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class States extends Model
{
    use HasFactory;

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
