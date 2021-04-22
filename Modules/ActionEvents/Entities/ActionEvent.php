<?php

namespace Modules\ActionEvents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionEvent extends Model
{
    use SoftDeletes;
    protected $table = 'action_events';
    protected $dates = ['deleted_at'];
    protected $fillable = array('userable_id', 'userable_type', 'actionable_id', 'actionable_type', 'action', 'comment');

    public function userable()
    {
        return $this->morphTo();
    }

    public function actionable()
    {
        return $this->morphTo();
    }

}
