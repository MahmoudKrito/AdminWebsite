<?php

namespace Modules\Cities\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Areas\Entities\Area;
use Modules\Countries\Entities\Country;

class City extends Model
{

    use SoftDeletes;
    protected $table = 'cities';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'active', 'country_id');
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function areas()
    {
        return $this->hasMany(Area::class);
    }

}
