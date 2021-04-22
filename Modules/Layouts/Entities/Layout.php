<?php

namespace Modules\Layouts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Categories\Entities\Category;

class Layout extends Model
{
    use SoftDeletes;

    protected $table = 'layouts';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'active');

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

}
