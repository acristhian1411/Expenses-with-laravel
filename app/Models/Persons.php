<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Persons extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
    'person_fname',
    'person_lastname',
    'person_corpname',
    'person_idnumber',
    'person_ruc',
    'person_birtdate',
    'person_photo',
    'person_address',
    'person_type_id',
    'country_id',
    'city_id'
];


    public function type()
    {
        return $this->belongsTo(PersonTypes::class, 'person_type_id');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
}
