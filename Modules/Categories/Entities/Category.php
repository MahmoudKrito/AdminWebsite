<?php

namespace Modules\Categories\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Genders\Entities\Gender;
use Modules\Layouts\Entities\Layout;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'image', 'gender_id', 'layout_id', 'parent_id', 'active');

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }

    public function types()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
