<?php

namespace Modules\RolePermission\Entities;
use Illuminate\Database\Eloquent\Model;

class infixRole extends Model
{
    protected $fillable = [];
    protected $casts = [
        'saas_schools' => 'array',
        'id' => 'integer',
        'name' => 'string',
    ];  
    public function assignedPermission()
    {
        return $this->hasMany(AssignPermission::class, 'role_id', 'id')->where('school_id', auth()->user()->school_id);
    }  
}
