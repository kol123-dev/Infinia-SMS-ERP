<?php

namespace Modules\Certificate\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\InfixRole;
use Modules\Certificate\Entities\CertificateTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateType extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function getRoleTypeAttribute()
    {
        $type = $this->role_id;
        if ($type == 2) {
            return _trans('certificate.Student');
        } else {
            return _trans('certificate.Employee');
        }
    }

    public function templates(){
        return $this->hasMany(CertificateTemplate::class,'certificate_type_id','id');
    }
}
