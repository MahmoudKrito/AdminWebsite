<?php

namespace Modules\Countries\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cities\Entities\City;
use Modules\Currencies\Entities\Currency;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'countries';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'image', 'code', 'currency_id', 'active');

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

//    protected static function newFactory()
//    {
//        return \Modules\Countries\Database\factories\CountryFactory::new();
//    }
}
