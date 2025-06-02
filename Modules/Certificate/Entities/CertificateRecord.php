<?php

namespace Modules\Certificate\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Certificate\Entities\CertificateTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateRecord extends Model
{
    use HasFactory;

    protected $fillable = [];
    
   public function user(){
         return $this->belongsTo(User::class,'user_id','id');
   }
   public function template(){
         return $this->belongsTo(CertificateTemplate::class,'template_id','id');
   }
}
