<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('style.background_settings'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>

    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1><?php echo app('translator')->get('style.background_settings'); ?></h1>
                <div class="bc-pages">
                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                    <a href="#"><?php echo app('translator')->get('style.style'); ?></a>
                    <a href="#"><?php echo app('translator')->get('style.background_settings'); ?></a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(isset($visitor)): ?>
                                <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'background-settings-update',
                                'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                            <?php else: ?>
                                <?php if(userPermission('background-settings-store')): ?>
                                    <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'background-settings-store',
                                    'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        <?php echo app('translator')->get('style.add_style'); ?>
                                    </h3>
                                </div>
                                <div class="add-visitor">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('style.style'); ?><span class="text-danger"> *</span></label>
                                            <select class="primary_select  form-control<?php echo e($errors->has('style') ? ' is-invalid' : ''); ?>" name="style" id="style">
                                                <option data-display="<?php echo app('translator')->get('style.select_position'); ?> *" value=""><?php echo app('translator')->get('style.select_position'); ?> *</option>
                                                
                                                <option value="2" <?php echo e(old('style') == 2? 'selected': ''); ?>><?php echo app('translator')->get('style.login_page_background'); ?></option>
                                                <?php if(moduleStatusCheck('Lead')==true): ?>
                                                <option value="3" <?php echo e(old('style') == 3? 'selected': ''); ?>><?php echo app('translator')->get('lead::lead.lead_form_background'); ?></option>
                                                <?php endif; ?>
                                            </select>
                                            <?php if($errors->has('style')): ?>
                                            <span class="text-danger invalid-select" role="alert">
                                                <?php echo e($errors->first('style')); ?>

                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <div class="row mt-15">
                                        <div class="col-lg-12"> 
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('style.background_type'); ?><span class="text-danger"> *</span></label>
                                            <select class="primary_select  form-control<?php echo e($errors->has('background_type') ? ' is-invalid' : ''); ?>" name="background_type" id="background-type">
                                                <option data-display="<?php echo app('translator')->get('style.background_type'); ?> *" value=""><?php echo app('translator')->get('style.background_type'); ?> *</option>            
                                                <option value="color" <?php echo e(old('background_type') == 'color'? 'selected': ''); ?>><?php echo app('translator')->get('style.color'); ?></option>
                                                <option value="image" <?php echo e(old('background_type') == 'image'? 'selected': ''); ?>><?php echo app('translator')->get('common.image'); ?> (1920x1400)</option>
                                            </select>
                                            <?php if($errors->has('background_type')): ?>
                                            <span class="text-danger invalid-select" role="alert">
                                                <?php echo e($errors->first('background_type')); ?>

                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>



                                    <div class="row mt-15" id="background-color">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('style.color'); ?><span class="text-danger"> *</span></label>
                                                <input class="primary_input_field form-control<?php echo e($errors->has('color') ? ' is-invalid' : ''); ?>" type="color" name="color" autocomplete="off" value="<?php echo e(isset($visitor)? $visitor->purpose: old('color')); ?>">
                                                <input type="hidden" name="id" value="<?php echo e(isset($visitor)? @$visitor->id: ''); ?>">
                                               
                                                
                                                <?php if($errors->has('color')): ?>
                                                    <span class="text-danger" >
                                                        <?php echo e($errors->first('color')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row  mt-15" id="background-image">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                    for=""><?php echo e(trans('common.file')); ?></label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary_input_field" id="placeholderInput" type="text" placeholder="<?php echo e(isset($visitor)? (@$visitor->file != ""? getFilePath3(@$visitor->file): trans('style.background_image').' *'): trans('style.background_image').' *'); ?>"
                                                    readonly>
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg" for="addBackgroundImage"><span
                                                                class="ripple rippleEffect"
                                                                style="width: 56.8125px; height: 56.8125px; top: -16.4062px; left: 10.4219px;"></span><?php echo app('translator')->get('common.browse'); ?></label>
                                                                <input type="file" class="d-none" id="addBackgroundImage" name="image">
                                                    </button>
                                                </div>
                                            
                                                <?php if($errors->has('image')): ?>
                                                <span class="text-danger d-block">
                                                    <?php echo e($errors->first('image')); ?>

                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row  mt-15">
                                        <div class="col-lg-12">
                                            <img class="d-none previewImageSize" src="" alt="" id="backgroundImageShow" height="100%" width="100%">
                                        </div>
                                    </div>


                                    
                                    <?php 
                                        $tooltip = "";
                                        if(userPermission('background-settings-store')){
                                                $tooltip = "";
                                            }else{
                                                $tooltip = "You have no permission to add";
                                            }
                                    ?>

                                    <div class="row mt-25">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="<?php echo e(@$tooltip); ?>">
                                                <span class="ti-check"></span>
                                                <?php if(isset($visitor)): ?>
                                                    <?php echo app('translator')->get('common.update'); ?>
                                                <?php else: ?>
                                                    <?php echo app('translator')->get('common.save'); ?>
                                                <?php endif; ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15"><?php echo app('translator')->get('common.view'); ?></h3>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
    
                                    <thead>
                                  
                                    <tr>
                                        <th><?php echo app('translator')->get('common.title'); ?></th>
                                        <th><?php echo app('translator')->get('common.type'); ?></th>
                                        <th><?php echo app('translator')->get('common.image'); ?></th> 
                                        <th><?php echo app('translator')->get('common.status'); ?></th>
                                        <th><?php echo app('translator')->get('common.action'); ?></th>
                                    </tr>
                                    </thead>
    
                                    <tbody>
                                        <?php $__currentLoopData = $background_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $background_setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(@$background_setting->title); ?></td>
                                            <td><p class="primary-btn small tr-bg"><?php echo e(@$background_setting->type); ?></p></td>
                                            <td>
                                                <?php if(@$background_setting->type == 'image'): ?>
                                                <img src="<?php echo e(asset($background_setting->image)); ?>" width="200px" height="100px">
                                                <?php else: ?>
                                                 <div style="width: 200px; height: 100px; background-color:<?php echo e(@$background_setting->color); ?> "></div>
                                                <?php endif; ?>
                                            </td> 
                                            <td>
                                                <div class="col-md-12">
                                                
                                                <?php if(@$background_setting->is_default==1): ?> 
                                                    <a  class="primary-btn small fix-gr-bg " href="<?php echo e(route('background_setting-status',@$background_setting->id)); ?>"> <?php echo app('translator')->get('style.activated'); ?> </a> 
                                                <?php else: ?>
                                                <?php if(Illuminate\Support\Facades\Config::get('app.app_sync')): ?>
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> 
                                                    <?php if(userPermission("background_setting-status")): ?>
                                                    <a  class="primary-btn small tr-bg" href="#"> <?php echo app('translator')->get('style.make_default'); ?></a> 
                                                    </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                <?php if(userPermission('background_setting-status')): ?>
                                                <a  class="primary-btn small tr-bg" href="<?php echo e(route('background_setting-status',@$background_setting->id)); ?>"> <?php echo app('translator')->get('style.make_default'); ?></a> 
                                               
                                                <?php endif; ?>
                                                <?php endif; ?>
                                               
    
                                                <?php endif; ?>
                                            </div>
                                            </td>
    
                                            <td>
                                                <?php if(@$background_setting->id==1): ?>
                                                <p class="primary-btn small tr-bg"><?php echo app('translator')->get('common.disable'); ?></p>
                                                <?php else: ?>
    
                                                <?php if (isset($component)) { $__componentOriginalf5ee9bc45d6af00850b10ff7521278be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf5ee9bc45d6af00850b10ff7521278be = $attributes; } ?>
<?php $component = App\View\Components\DropDown::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('drop-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DropDown::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                                        <?php if(userPermission('background-setting-delete')): ?>
                                                        <a class="dropdown-item" data-toggle="modal"
                                                           data-target="#deletebackground_settingModal<?php echo e(@$background_setting->id); ?>"
                                                           href="#"><?php echo app('translator')->get('common.delete'); ?></a>
                                                        <?php endif; ?>
                                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf5ee9bc45d6af00850b10ff7521278be)): ?>
<?php $attributes = $__attributesOriginalf5ee9bc45d6af00850b10ff7521278be; ?>
<?php unset($__attributesOriginalf5ee9bc45d6af00850b10ff7521278be); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf5ee9bc45d6af00850b10ff7521278be)): ?>
<?php $component = $__componentOriginalf5ee9bc45d6af00850b10ff7521278be; ?>
<?php unset($__componentOriginalf5ee9bc45d6af00850b10ff7521278be); ?>
<?php endif; ?>
                                                
                                                <?php endif; ?>
                                            </td>
                                            <div class="modal fade admin-query" id="deletebackground_settingModal<?php echo e(@$background_setting->id); ?>">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo app('translator')->get('common.delete'); ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;
                                                            </button>
                                                        </div>
    
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <h4><?php echo app('translator')->get('common.are_you_sure_to_delete'); ?></h4>
                                                            </div>
    
                                                            <div class="mt-15 d-flex justify-content-between">
                                                                <button type="button" class="primary-btn tr-bg"
                                                                        data-dismiss="modal"><?php echo app('translator')->get('common.cancel'); ?>
                                                                </button>
    
                                                                <a href="<?php echo e(route('background-setting-delete',@$background_setting->id)); ?>"
                                                                   class="primary-btn fix-gr-bg"><?php echo app('translator')->get('common.delete'); ?></a>
    
                                                            </div>
                                                        </div>
    
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    
                                    </tbody>
                                </table>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.partials.data_table_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(document).on('change', '#addBackgroundImage', function(event) {
            $('#backgroundImageShow').removeClass('d-none');
            getFileName($(this).val(), '#placeholderInput');
            imageChangeWithFile($(this)[0], '#backgroundImageShow');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\resources\views/backEnd/style/background_setting.blade.php ENDPATH**/ ?>