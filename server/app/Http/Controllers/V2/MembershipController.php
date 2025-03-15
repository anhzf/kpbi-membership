<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\MembershipController as V1;
use App\Models\Membership;

class MembershipController extends V1
{
    public function show(Membership $membership) {
        return $membership->loadFullProfile();
    }
}
