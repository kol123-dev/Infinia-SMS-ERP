<?php

namespace Modules\RolePermission\Entities;

use App\infixModuleManager;
use Illuminate\Database\Eloquent\Model;

class infixModuleInfo extends Model
{
    // protected $fillable = ['*'];
    protected $guarded = ['id'];

    public function subModule(){
        
        return $this->hasMany('Modules\RolePermission\Entities\infixModuleInfo','parent_route','route')
        ->whereNotNull('route')->where('route', '!=', '')
        ->whereNotInDeaActiveModulePermission()
        ->where('active_status', 1);
    }

    public function children(){
        return $this->hasMany('Modules\RolePermission\Entities\infixModuleInfo','parent_id','id');
    }

    public function allGroupModule(){
        return $this->subModule()->where('id','!=',$this->module_id);
    }
    public function scopeWhereNotInDeaActiveModulePermission($query)
    {        
        $activeModuleList = infixModuleManager::where('is_default', 0)
        ->whereNull('purchase_code')->pluck('name')->toArray();
          
        $deActiveModules = [];            
        foreach($activeModuleList as $module) {
            if(moduleStatusCheck($module)==false) {
                $deActiveModules[] = $module;
            }
        }
        return $query->where(function($q) use($deActiveModules) {
          $q->whereNotIn('module_name', $deActiveModules)->orWhereNull('module_name');           
        });
    }
    public function roles()
    {
        return $this->belongsToMany(infixRole::class, 'infix_permission_assigns', 'module_id', 'role_id');
    }
    public function assign()
    {
        return $this->hasMany(infixPermissionAssign::class, 'role_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(infixModuleInfo::class, 'parent_route', 'route')->with('childs');
    }

    public function parent()
    {
        return $this->belongsTo(infixModuleInfo::class, 'parent_route', 'route');
    }
}
