<?php

namespace Modules\Zones\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Areas\Entities\Area;

class Zone extends Model
{

    use SoftDeletes;
    protected $table = 'zones';
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'name_ar', 'area_id', 'active');
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

}
