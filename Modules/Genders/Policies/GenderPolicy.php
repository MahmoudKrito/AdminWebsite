<?php

namespace Modules\Genders\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class GenderPolicy
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
