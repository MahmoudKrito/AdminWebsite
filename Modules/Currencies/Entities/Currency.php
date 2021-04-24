<?php

namespace Modules\Currencies\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Countries\Entities\Country;

class Currency extends Model
{
    use SoftDeletes;

    protected $table = 'currencies';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'symbol');

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function setNameAttribute($value)
    {
        $key = getExistAttribute('name');
        $this->attributes[$key] = $value;
    }

    public function getNameAttribute($value)
    {
        return getExistData('name', $value, $this);
    }
}
