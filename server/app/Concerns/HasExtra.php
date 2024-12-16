<?php

namespace App\Concerns;

use App\Models\Extra;

/**
 * @property Extra $extra
 * @method \Illuminate\Database\Eloquent\Relations\MorphOne extra
 */
trait HasExtra
{
    public function extra()
    {
        return $this->morphOne(Extra::class, 'model');
    }
}
