<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends  Model
{
    protected $table = 'permissions';

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany('Group', 'group_permissions');
    }
}