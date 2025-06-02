<?php

namespace Modules\Certificate\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Certificate\Entities\CertificateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Certificate\Entities\CertificateTemplateDesign;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $casts = ['qr_code' => 'array'];
    
    public function type(){
        return $this->belongsTo(CertificateType::class,'certificate_type_id','id');
    }

    public function design(){
        return $this->hasOne(CertificateTemplateDesign::class,'certificate_template_id','id');
    }

    public function generatedCertificates(){
        return $this->hasMany(CertificateRecord::class,'template_id','id');
    }

    public function getLayoutStringAttribute(){
        $layout = $this->layout;
        switch ($layout) {
            case 1:
                $layout = _trans('certificate.A4 (Portrait)');
                break;
            case 2:
                $layout = _trans('certificate.A4 (Landscape)');
                break;
            default:
                $layout = _trans('certificate.Custom');
                break;
        }
        return $layout;
    }
    
}
