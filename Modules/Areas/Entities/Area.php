<?php

namespace Modules\Areas\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cities\Entities\City;
use Modules\Zones\Entities\Zone;

class Area extends Model
{
    use SoftDeletes;
    protected $table = 'areas';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'active', 'city_id');
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
