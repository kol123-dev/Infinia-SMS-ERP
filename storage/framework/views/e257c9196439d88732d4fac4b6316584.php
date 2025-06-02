    <?php $__env->startSection('title'); ?> 
        <?php echo app('translator')->get('fees::feesModule.fees_invoice_settings'); ?>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
    <?php $__env->startPush('css'); ?>
        <link rel="stylesheet" href="<?php echo e(url('Modules\Fees\Resources\assets\css\feesStyle.css')); ?>"/>
        
    <?php $__env->stopPush(); ?>
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1><?php echo app('translator')->get('fees::feesModule.fees_invoice_settings'); ?></h1>
                <div class="bc-pages">
                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                    <a href="#"><?php echo app('translator')->get('fees.fees'); ?></a>
                    <a href="#"><?php echo app('translator')->get('fees::feesModule.fees_invoice_settings'); ?></a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                                $invoicePostions = json_decode($invoiceSettings->invoice_positions);
                            ?>
                            <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                            <?php if(isset($invoiceSettings)): ?>
                                <input type="hidden" name="id" id="ID" value="<?php echo e($invoiceSettings->id); ?>">
                            <?php endif; ?>
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        <?php echo app('translator')->get('fees::feesModule.invoice_number_generator'); ?>
                                    </h3>
                                </div>
                                <div class="add-visitor pr-30">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col-lg-12">
                                            <label for="checkbox" class="mb-2"><?php echo app('translator')->get('fees::feesModule.invoice_number_position'); ?>*</label>
                                            <select ata-tags="true" name="invoice_positions[]" id="selectSectionss" style="width:300px" class="selectValue" multiple>
                                                <option value="prefix"><?php echo app('translator')->get('fees::feesModule.prefix'); ?> </option>
                                                <option value="admission_no"><?php echo app('translator')->get('student.admission_no'); ?></option>
                                                
                                                <option value="class"><?php echo app('translator')->get('common.class'); ?></option>
                                                <option value="section"><?php echo app('translator')->get('common.section'); ?></option>
                                            </select>
                                            <?php if($errors->has('invoice_positions')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('invoice_positions')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-12 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15"><?php echo app('translator')->get('fees::feesModule.invoice_number_preview'); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="white-box">
                                    <div class="row fees_custom_preview pl-30" id="showValue">
    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box mt-40">
                <div class="row">
                    <div class="col-lg-12 p-0">
                        <div class="main-title px-3">
                            <h3 class="mb-15">
                                <?php echo app('translator')->get('fees::feesModule.invoice_attribute'); ?>
                            </h3>
                        </div>
                        <table class="table school-table-style" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('fees::feesModule.uniq_id_start'); ?><span class="text-danger"> *</span></label>
                                                <input class="primary_input_field form-control<?php echo e($errors->has('uniq_id_start') ? ' is-invalid' : ''); ?>" type="text" name="uniq_id_start" id="uniq_id_start" autocomplete="off" value="<?php echo e(isset($invoiceSettings)? $invoiceSettings->uniq_id_start: old('uniq_id_start')); ?>">
                                                
                                                
                                                    <?php if($errors->has('uniq_id_start')): ?>
                                                    <span class="text-danger" >
                                                        <?php echo e($errors->first('uniq_id_start')); ?>

                                                    </span>
                                                    <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('fees::feesModule.prefix'); ?> (<?php echo app('translator')->get('fees::feesModule.max_10_characters'); ?>)</label>
                                                <input class="primary_input_field form-control<?php echo e($errors->has('prefix') ? ' is-invalid' : ''); ?>" type="text" name="prefix" id="prefix" autocomplete="off" value="<?php echo e(isset($invoiceSettings)? $invoiceSettings->prefix: old('prefix')); ?>" maxlength="10">
                                                
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('fees::feesModule.class_limit'); ?></label>
                                                <input class="primary_input_field form-control<?php echo e($errors->has('class_limit') ? ' is-invalid' : ''); ?>" type="text"  name="class_limit" id="class_limit" autocomplete="off" value="<?php echo e(isset($invoiceSettings)? $invoiceSettings->class_limit: old('class_limit')); ?>">
                                             
                                                
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('fees::feesModule.section_limit'); ?></label>
                                                <input class="primary_input_field form-control<?php echo e($errors->has('section_limit') ? ' is-invalid' : ''); ?>" type="text" name="section_limit" id="section_limit" autocomplete="off" value="<?php echo e(isset($invoiceSettings)? $invoiceSettings->section_limit: old('section_limit')); ?>">
                                               
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('fees::feesModule.admission_no_limit'); ?></label>
                                                <input class="primary_input_field form-control<?php echo e($errors->has('admission_limit') ? ' is-invalid' : ''); ?>" type="text" name="admission_limit" id="admission_limit" autocomplete="off" value="<?php echo e(isset($invoiceSettings)? $invoiceSettings->admission_limit: old('admission_limit')); ?>">
                                            
                                                
                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <?php if(userPermission("fees.fees-invoice-settings-update")): ?>
                                    <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" id="invSetting">
                                        <span class="ti-check"></span>
                                        <?php echo app('translator')->get('common.update'); ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(url('public/backEnd/vendors/js/select2/select2.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(url('Modules\Fees\Resources\assets\js\app.js')); ?>"></script>
        <script>
            $(document).ready(function() {
                $("#selectSectionss").on("select2:opening select2:closing", function(event) {
                    var $searchfield = $(this).parent().find(".select2-search__field");
                    $searchfield.prop("disabled", true);
                });

                $("#selectSectionss").select2();
                $('.selectValue').select2('data',<?php echo $invoiceSettings->invoice_positions; ?>);
                selectPosition(<?php echo feesInvoiceSettings()->invoice_positions; ?>);
            });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Modules/Fees\Resources/views/feesInvoiceSettings.blade.php ENDPATH**/ ?>