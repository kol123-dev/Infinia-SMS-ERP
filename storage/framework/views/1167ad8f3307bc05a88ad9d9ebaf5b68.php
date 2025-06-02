<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('system_settings.utilities'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>

    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1><?php echo app('translator')->get('system_settings.utilities'); ?> </h1>
                <div class="bc-pages">
                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                    <a href="#"><?php echo app('translator')->get('system_settings.system_settings'); ?></a>
                    <a href="#"><?php echo app('translator')->get('system_settings.utilities'); ?> </a>
                </div>
            </div>
        </div>
    </section>
    


    <section class="admin-visitor-area up_admin_visitor empty_table_tab">
        <div class="container-fluid p-0">
        <div class="white-box">
        <div class="row row-gap-24">
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <a class="white-box single-summery cyan d-block btn-ajax"
                       href="<?php echo e(route('utilities','optimize_clear')); ?>">
                        <div class="d-block mt-10 text-center ">
                            <h3><i class="ti-cloud font_30"></i></h3>
                            <h1 class="gradient-color2 total_purchase"> Clear Cache </h1>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-lg-3 col-sm-6">
                    <a class="white-box single-summery violet d-block btn-ajax"
                       href="<?php echo e(route('utilities','clear_log')); ?>">
                        <div class="d-block mt-10 text-center ">
                            <h3><i class="ti-receipt font_30"></i></h3>
                            <h1 class="gradient-color2 total_purchase">Clear Log</h1>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-lg-3 col-sm-6">
                    <a class="white-box single-summery blue d-block btn-ajax"
                       href="<?php echo e(route('utilities','change_debug')); ?>">
                        <div class="d-block mt-10 text-center ">
                            <h3><i class="ti-blackboard font_30"></i></h3>
                            <h1 class="gradient-color2 total_purchase"> <?php echo e(__((env('APP_DEBUG') ? "Disable" : "Enable" ).' App Debug')); ?></h1>
                        </div>
                    </a>
                </div>


                <div class="col-md-4 col-lg-3 col-sm-6">
                    <a class="white-box single-summery fuchsia d-block btn-ajax"
                       href="<?php echo e(route('utilities', 'force_https')); ?>">
                        <div class="d-block mt-10 text-center ">
                            <h3><i class="ti-lock font_30"></i></h3>
                            <h1 class="gradient-color2 total_purchase"> <?php echo e(__((env('FORCE_HTTPS') ? "Disable" : "Enable" ).' Force HTTPS')); ?></h1>
                        </div>
                    </a>
                </div>


            </div>
        </div>
        </div>


        <div class="row mt-40">
            <div class="col-lg-12">
                <div class="white-box">
                    <form method="post" action="<?php echo e(route('updateMaintenance')); ?>" enctype = 'multipart/form-data'>
                        <?php echo csrf_field(); ?>
                        <div class="row p-0">
                            <div class="col-lg-12">
                                <h3 class="text-center"><?php echo app('translator')->get('system_settings.maintenance_mode_setting'); ?></h3>
                                <hr>
                                <div class="row mb-40 mt-40">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-5 d-flex">
                                                <p class="text-uppercase fw-500 mb-10"><?php echo app('translator')->get('system_settings.maintenance_mode_'); ?></p>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="d-flex radio-btn-flex flex-wrap"> 

                                                <div class="mr-30">
                                                        <input type="radio" name="maintenance_mode" id="via_sms" class="common-radio relationButton copy_per_th" <?php echo e(@$setting->maintenance_mode == 1? 'checked':''); ?>  value="1" >
                                                        <label for="via_sms" id="via_sms"><?php echo app('translator')->get('common.enable'); ?></label>
                                                    </div>

                                                    <div class="mr-30">
                                                        <input type="radio" name="maintenance_mode" id="via_email"  class="common-radio relationButton copy_per_th" <?php echo e(@$setting->maintenance_mode == 0? 'checked':''); ?> value="0" >
                                                        <label for="via_email" id="via_email"><?php echo app('translator')->get('common.disable'); ?></label>
                                                    </div>                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('common.title'); ?> </label>
                                            <input class="primary_input_field form-control" type="text" name="title" autocomplete="off" value="<?php echo e(isset($setting)? $setting->title:''); ?>">
                                        </div> 
                                    </div>
                                </div>                                 

                                <div class="row mb-40 mt-40">
                                    <div class="col-lg-12"> 
                                        <div class="primary_input">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('front_settings.sub_title'); ?> </label>
                                            <input class="primary_input_field form-control" type="text" name="sub_title" autocomplete="off" value="<?php echo e(isset($setting)? $setting->sub_title:''); ?>">
                                        </div> 
                                    </div>
                                </div>

                                <div class="row mb-40 mt-40">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-3 d-flex">
                                                <p class="text-uppercase fw-500 mb-10"><?php echo app('translator')->get('auth.applicable_for'); ?></p>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="d-flex radio-btn-flex gap-10 flex-column flex-sm-row flex-wrap"> 
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="mr-30">
                                                            <input type="checkbox" name="applicable_for[]" id="applicable_for_<?php echo e($role->id); ?>" class="common-radio relationButton copy_per_th" value="<?php echo e($role->id); ?>" <?php if(is_null($setting->applicable_for) ||  in_array($role->id,$setting->applicable_for)): ?> checked <?php endif; ?>>
                                                            <label for="applicable_for_<?php echo e($role->id); ?>" id="applicable_for_<?php echo e($role->id); ?>"><?php echo e($role->name); ?></label>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                                    
                                                    <div class="mr-30">
                                                        <input type="checkbox" name="applicable_for[]" id="applicable_for_front" class="common-radio relationButton copy_per_th" value="front" <?php if(is_null($setting->applicable_for) || in_array('front', $setting->applicable_for)): ?> checked <?php endif; ?>>
                                                        <label for="applicable_for_front" id="applicable_for_front">Frontend/Website</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                
                                </div>

                                <div class="row mt-15">                                                 
                                    <script src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/print/2.1.1_jquery.min.js"></script>
                                     <div class="col-lg-6 mt-40"> 
                                         <img src="<?php echo e(isset($setting) && $setting->image ? $setting->image : asset('/public/backEnd/img/503.png')); ?>" style="width: 100%; height: auto;" alt="<?php echo e(isset($setting)? $setting->title:''); ?>" id="blahImg">
                                   
                                         
                                         <div class="row mt-40">
                                             <div class="col-lg-12 mt-15">
                                                 <div class="primary_input">
                                                     <div class="primary_file_uploader">
                                                         <input class="primary_input_field" type="text" id="placeholderFileFourName" placeholder="<?php echo app('translator')->get('system_settings.upload_image'); ?>"
                                                         readonly="">
                                                         <button class="" type="button">
                                                             <label class="primary-btn small fix-gr-bg" for="imgInpBac"><?php echo e(__('common.browse')); ?></label>
                                                             <input type="file" class="d-none" name="image" id="imgInpBac">
                                                         </button>
                                                     </div>
                                                 </div>
                                             </div>
                                             <?php if($errors->has('image')): ?>
                                                     <strong class="error text-danger"><?php echo e($errors->first('image')); ?>

                                             <?php endif; ?>
                                         </div>
                                     </div> 

                                     

                                 </div>


                                <?php if(userPermission('two_factor_auth_setting')): ?>
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg">
                                                <span class="ti-check"></span>
                                                <?php echo app('translator')->get('common.update'); ?>
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </form>
            </div>
            </div>

        </div>
    </section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script language="JavaScript">

        $('#selectAll').click(function () {
            $('input:checkbox').prop('checked', this.checked);

        });


    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).on('change', '#imgInpBac', function(event){
            getFileName($(this).val(),'#placeholderFileFourName');
            imageChangeWithFile($(this)[0],'#blahImg');
        });
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\resources\views/backEnd/systemSettings/utilityView.blade.php ENDPATH**/ ?>