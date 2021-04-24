<?php

namespace Modules\Types\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'image', 'gender_id', 'layout_id', 'parent_id', 'active');

    public function category()
    {
        return $this->belongsTo(Type::class, 'parent_id', 'id');
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

//    protected static function newFactory()
//    {
//        return \Modules\Types\Database\factories\TypeFactory::new();
//    }
}
