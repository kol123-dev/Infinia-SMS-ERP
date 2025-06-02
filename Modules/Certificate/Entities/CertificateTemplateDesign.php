<?php

namespace Modules\Certificate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateTemplateDesign extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Certificate\Database\factories\CertificateTemplateDesignFactory::new();
    }
}
