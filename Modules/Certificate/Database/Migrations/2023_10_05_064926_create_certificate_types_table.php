<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Certificate\Entities\CertificateType;

class CreateCertificateTypesTable extends Migration
{
   /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificate_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('short_code');
            $table->integer('role_id');
            $table->integer('school_id')->nullable()->default(1);
            $table->timestamps();
        });
        $types = [];
        $types[] = [
            0 => [
                'name' => 'Exam Certificate',
                'short_code' => '["name","dob","present_address","guardian","created_at","admission_no","roll_no","gender","admission_date","category","cast","father_name","mother_name","religion","email","phone","average_mark","grade","gpa_with_optional","gpa_without_optional","evaluation","exam_total_mark","std_total_mark","position","class","section","exam"]',
                'role_id' => 2,
            ],
            1 => [
                'name' => 'Transfer Certificate',
                'short_code' => '["name","dob","present_address","guardian","created_at","admission_no","roll_no","gender","admission_date","category","cast","father_name","mother_name","religion","email","phone","average_mark","grade","gpa_with_optional","gpa_without_optional","evaluation","exam_total_mark","std_total_mark","position","class","section","exam"]',
                'role_id' => 2,
            ],
            2=>[
                'name'=>'Student Character Certificate',
                'short_code' => '["name","dob","present_address","guardian","created_at","admission_no","roll_no","gender","admission_date","category","cast","father_name","mother_name","religion","email","phone"]',
                'role_id'=>2,
            ],
            3=>[
                'name'=>'Staff Character Certificate',
                'short_code' => '["name","gender","staff_id","joining_date","designation","department","qualification","total_experience","religion","blood_group","birthday","email","mobileno","present_address","permanent_address"]',
                'role_id'=>3,
            ],
            4=>[
                'name'=>'NOC',
                'short_code' => '["name","gender","staff_id","joining_date","designation","department","qualification","total_experience","religion","blood_group","birthday","email","mobileno","present_address","permanent_address"]',
                'role_id'=>3,
            ],
            5=>[
                'name'=>'Experience Certificate',
                'short_code' => '["name","gender","staff_id","joining_date","designation","department","qualification","total_experience","religion","blood_group","birthday","email","mobileno","present_address","permanent_address"]',
                'role_id'=>3,
            ],
            6=>[
                'name'=>'Extra Curricular Activities Certificate',
                'short_code' => '["name","dob","present_address","guardian","created_at","admission_no","roll_no","gender","admission_date","category","cast","father_name","mother_name","religion","email","phone"]',
                'role_id'=>2,
            ],
        ];
        foreach ($types as $type) {
            foreach ($type as $t) {
                $certificate_type = new CertificateType();
                $certificate_type->name = $t['name'];
                $certificate_type->short_code = $t['short_code'];
                $certificate_type->role_id = $t['role_id'];
                $certificate_type->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificate_types');
    }
}
