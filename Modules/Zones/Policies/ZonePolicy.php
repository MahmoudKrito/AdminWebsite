<?php

namespace Modules\Zones\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
