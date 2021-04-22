<?php

namespace Modules\Layouts\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutPolicy
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
