<?php

use Illuminate\Support\Facades\Route;
use Modules\Certificate\Http\Controllers\CertificateController;
use Modules\Certificate\Http\Controllers\CertificateTypeController;
use Modules\Certificate\Http\Controllers\CertificateSettingController;
use Modules\Certificate\Http\Controllers\CertificateTemplateController;
use Modules\Certificate\Http\Controllers\GenerateCertificateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('verify-certificate',[CertificateController::class,'index'])->name('certificate.verify-certificate');
Route::any('verify-certificate-get',[CertificateController::class,'verify'])->name('certificate.get-verify-certificate')->middleware('XSS');

Route::group(['middleware' => ['XSS', 'subscriptionAccessUrl', 'CheckDashboardMiddleware']], function () {


    Route::prefix('certificate')->as('certificate.')->group(function () {

        
        //Certificate Type

        Route::controller(CertificateTypeController::class)->group(function () {
            Route::get('types', 'index')->name('types')->middleware('userRolePermission:certificate.types');
            Route::post('types', 'storeOrUpdate')->name('type_store')->middleware('userRolePermission:certificate.type_store');
            Route::get('type/{type_id}', 'edit')->name('type_edit')->middleware('userRolePermission:certificate.type_edit');
            Route::get('type-delete/{type_id}', 'delete')->name('type_delete')->middleware('userRolePermission:certificate.type_delete');
        });

        //Certificate Template
        Route::controller(CertificateTemplateController::class)->group(function () {
            Route::get('templates', 'index')->name('templates')->middleware('userRolePermission:certificate.templates');
            Route::post('templates-store', 'storeOrUpdate')->name('template-store')->middleware('userRolePermission:certificate.template-store');
            Route::get('template', 'create')->name('template-create')->middleware('userRolePermission:certificate.template-create');
            Route::get('template/{template_id}', 'edit')->name('template_edit')->middleware('userRolePermission:certificate.template_edit');
            Route::get('template-design/{template_id}', 'design')->name('template_design')->middleware('userRolePermission:certificate.template_design');
            Route::post('template-design', 'updateDesign')->name('template_design_update')->middleware('userRolePermission:certificate.template_design_update');
            Route::get('template-reset-design/{template_id}', 'designReset')->name('template_design_reset')->middleware('userRolePermission:certificate.template_design_reset');

            Route::get('template-delete/{template_id}', 'delete')->name('template_delete')->middleware('userRolePermission:certificate.template_delete');
            Route::post('template-type', 'templateType')->name('templateType');

            Route::post('template-preview', 'preview')->name('preview');
        });
        //Certificate Setting
        Route::controller(CertificateSettingController::class)->group(function () {
            Route::get('settings', 'index')->name('settings')->middleware('userRolePermission:certificate.settings');
            Route::post('settings', 'storeOrUpdate')->name('settings-store')->middleware('userRolePermission:certificate.settings-store');
        });
        //Generate Certificate
        Route::controller(GenerateCertificateController::class)->group(function () {
            Route::get('generate/staff-certificate', 'staffCertificate')->name('generate-staff-certificate')->middleware('userRolePermission:certificate.generate-staff-certificate');
            Route::post('generate/staff-certificate', 'staffCertificateSearch')->name('generate-staff-certificate-search')->middleware('userRolePermission:certificate.generate-staff-certificate-search');
            Route::get('generate-certificate-staff', 'generateCertificateStaff')->name('generate-certificate-staff')->middleware('userRolePermission:certificate.generate-certificate-staff');
            Route::get('generate', 'index')->name('generate')->middleware('userRolePermission:certificate.generate');
            Route::post('generate', 'getStudentList')->name('generate-get-list');
            Route::get('generate-certificate', 'generateCertificate')->name('generate-certificate');
            Route::post('save-generated-certificate', 'store')->name('certificate-save');
            // Route::get('generate-certificate/{template_id}/{student_id}', 'generateCertificate')->name('generate-certificate')->middleware('userRolePermission:certificate.generate-certificate');
        });

        //Certificate Record
        Route::controller(CertificateController::class)->group(function () {
            Route::get('records', 'certificates')->name('records')->middleware('userRolePermission:certificate.records');
            Route::post('records', 'searchCertificates')->name('searchCertificates')->middleware('userRolePermission:certificate.searchCertificates');
            Route::get('record/{record_id}', 'show')->name('record_show')->middleware('userRolePermission:certificate.record_show');

            Route::get('record-delete/{record_id}', 'delete')->name('record_delete')->middleware('userRolePermission:certificate.record_delete');
            Route::get('record-delete-multiple', 'deleteMultiple')->name('record_delete_multiple')->middleware('userRolePermission:certificate.record_delete_multiple');

            Route::get('record-download', 'download')->name('record_download')->middleware('userRolePermission:certificate.record_download');
            Route::get('record-print/{record_id}', 'print')->name('record_print')->middleware('userRolePermission:certificate.record_print');

        });
    });
});
