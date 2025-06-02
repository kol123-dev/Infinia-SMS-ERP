<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\infixPermissionAssign;

class Role extends Model
{
    //
    public function permissions()
    {
        return $this->hasMany(infixPermissionAssign::class, 'role_id', 'id');
    }
}
