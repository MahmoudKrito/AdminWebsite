<?php

namespace Modules\Areas\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AreaPolicy
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
