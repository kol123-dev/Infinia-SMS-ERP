<?php

namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Modules\MenuManage\Entities\Sidebar;
use Modules\MenuManage\Entities\MenuManage;
use Modules\RolePermission\Entities\infixModuleInfo;

class infixPermissionAssign extends Model
{
    protected $casts = [
        'saas_schools' => 'array'
    ];
    protected $fillable = [];  

    public function routeName()
    {
        return $this->belongsTo(infixModuleInfo::class, 'module_id', 'id');
    }

}
