<?php

namespace Modules\Genders\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Categories\Entities\Category;

class Gender extends Model
{

    use SoftDeletes;
    protected $table = 'genders';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'active');

    public function categories()
    {
        return $this->hasMany(Category::class);
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
