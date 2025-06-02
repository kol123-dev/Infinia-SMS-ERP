<?php $__env->startSection('title'); ?> 
<?php echo app('translator')->get('fees.fees_master'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
<?php $__env->startPush('css'); ?>
<style>
    .custom_fees_master{
        border-bottom: 1px solid #d9dce7; 
        padding-top: 5px;
    }

   
    .dloader_img_style{
        width: 40px;
        height: 40px;
    }

    .dloader {
        display: none;
    }

    .pre_dloader {
        display: block;
    }

    .up_st_admin_visitor .input-right-icon button i.ti-calendar {
        top: 10px;
    }

    .up_st_admin_visitor .input-right-icon button i.ti-calendar.upper-icon {
        top: 15px;
    }

    .up_st_admin_visitor .input-right-icon button i.ti-calendar.lower-icon {
        top: 10px;
    }

    .primary-btn.icon-only.delete-row {
        top: 7px;
    }
</style>
<?php $__env->stopPush(); ?>
<?php  
    $setting = app('school_info'); 
    if(!empty($setting->currency_symbol)) {
        $currency = $setting->currency_symbol;
    } else { 
        $currency = '$'; 
    } 
?>
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('fees.fees_master'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.fees_collection'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.fees_master'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <?php if(isset($fees_master)): ?>
         <?php if(userPermission('fees-master-store')): ?>
                       
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="<?php echo e(route('fees-master')); ?>" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    <?php echo app('translator')->get('common.add'); ?>
                </a>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-4">
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                <?php if(isset($fees_master)): ?>
                                    <?php echo app('translator')->get('fees.edit_fees_master'); ?>
                                <?php else: ?>
                                    <?php echo app('translator')->get('fees.add_fees_master'); ?>
                                <?php endif; ?>
                                  
                            </h3>

                            
                        </div>
                        
                        <?php if(isset($fees_master)): ?>
                        <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true,  'route' => array('fees-master-update',$fees_master->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'fees_master_form'])); ?>

                        <?php else: ?>
                         <?php if(userPermission("fees-master-store")): ?>
                        <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'fees-master-store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'fees_master_form'])); ?>

                        <?php endif; ?>
                        <?php endif; ?>
                        <div class="white-box">
                            <div class="add-visitor">                               
                                <?php if($errors->any()): ?>
                                    <div class="error text-danger "><?php echo e('Something went wrong, please try again'); ?></div>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('common.name'); ?> <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>"
                                                type="text" name="name" autocomplete="off" value="<?php echo e(isset($fees_master)? @$fees_master->feesTypes->name: ''); ?>">
                                            
                                            <?php if($errors->has('name')): ?>
                                            <span class="text-danger" >
                                                <?php echo e($errors->first('name')); ?>

                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo e(isset($fees_master)? $fees_master->id: ''); ?>">
                                <input type="hidden" name="fees_group_id" value="<?php echo e(isset($fees_master)? $fees_master->fees_group_id: ''); ?>">
                                <input type="hidden" name="fees_type" value="<?php echo e(isset($fees_master)? $fees_master->fees_type_id: ''); ?>">
                                <?php if(! directFees()): ?>
                                    <div class="primary_datepicker_input">
                                        <div class="row no-gutters input-right-icon mt-25">
                                            <div class="col">
                                                <div class="primary_input">
                                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.due_date'); ?> <span></span></label>
                                                    <input class="primary_input_field  primary_input_field date form-control form-control<?php echo e($errors->has('date') ? ' is-invalid' : ''); ?>" id="startDate" type="text" name="date" value="<?php echo e(isset($fees_master)? date('m/d/Y', strtotime($fees_master->date)) : date('m/d/Y')); ?>">
                                                        
                                                    <button class="btn-date" style="top: 70% !important;" data-id="#date_of_birth" type="button">
                                                        <label class="m-0 p-0" for="date_of_birth">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </label>
                                                    </button>
                                                    <?php if($errors->has('date')): ?>
                                                    <span class="text-danger" >
                                                        <?php echo e($errors->first('date')); ?>

                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        
                                        

                                        </div>
                                    </div>
                                <?php endif; ?> 

                                    <?php if(isset($fees_master)): ?>
                                        <div class="row  mt-25" id="fees_master_amount">
                                            <div class="col-lg-12">
                                                <div class="primary_input">
                                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.amount'); ?> <span class="text-danger"> *</span></label>
                                                    <input oninput="numberCheckWithDot(this)" class="primary_input_field form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>" type="text" name="amount" autocomplete="off" value="<?php echo e(isset($fees_master)? $fees_master->amount:''); ?>">
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger">
                                                            <?php echo e($message); ?>

                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="row  mt-25" id="fees_master_amount">
                                            <div class="col-lg-12">
                                                <div class="primary_input">
                                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.amount'); ?> <span class="text-danger"> *</span></label>
                                                    <input oninput="numberCheckWithDot(this)" class="primary_input_field form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>"
                                                        type="text" name="amount" autocomplete="off" value="<?php echo e(isset($fees_master)? $fees_master->amount:''); ?>" id="fees_amount">
                                                    
                                                    
                                                    <?php if($errors->has('amount')): ?>
                                                    <span class="text-danger" >
                                                        <?php echo e($errors->first('amount')); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                   
                                    <div class="row mt-25">
                                        <div class="col-lg-12 mb-30">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('common.select_class'); ?><span class="text-danger"> *</span></label>
                                            <select class="primary_select form-control <?php echo e($errors->has('class') ? ' is-invalid' : ''); ?>" id="select_class" name="class">
                                                <option data-display="<?php echo app('translator')->get('common.select_class'); ?>" value=""><?php echo app('translator')->get('common.select_class'); ?></option>
                                                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(isset($fees_master)): ?>
                                                            <option value="<?php echo e($class->id); ?>"  <?php echo e(( $fees_master->class_id == $class->id ? "selected":"")); ?>><?php echo e($class->class_name); ?></option> 
                                                        <?php else: ?> 
                                                            <option value="<?php echo e($class->id); ?>"  <?php echo e(( old("class") == $class->id ? "selected":"")); ?>><?php echo e($class->class_name); ?></option> 
                                                        <?php endif; ?>    
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php if($errors->has('class')): ?>
                                                <span class="text-danger" >
                                                    <?php echo e($errors->first('class')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-lg-12 mb-30" id="select_section__member_div">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('common.select_section'); ?></label>
                                            <select class="primary_select form-control<?php echo e($errors->has('section') ? ' is-invalid' : ''); ?>" id="select_section_member" name="section_id">
                                                <option data-display="<?php echo app('translator')->get('fees.all_section'); ?>" value="all_section"><?php echo app('translator')->get('fees.all_section'); ?></option>
                                                <?php if(isset($fees_master)): ?>
                                                
                                                    <?php if(is_null($fees_master->section_id)): ?>
                                                        <option selected value="all_section"><?php echo app('translator')->get('fees.all_section'); ?></option>
                                                    <?php else: ?> 
                                                        <option value="<?php echo e(@$fees_master->section_id); ?>"  selected ><?php echo e(@$fees_master->section->section_name); ?></option>
                                                    <?php endif; ?> 
                                                <?php endif; ?>
                                            </select>
                                                <?php if($errors->has('section')): ?>
                                                <span class="text-danger" >
                                                    <?php echo e($errors->first('section')); ?>

                                                </span>
                                                <?php endif; ?>
                                            <div class="pull-right loader loader_style" id="select_section_loader">
                                                <img class="loader_img_style" src="<?php echo e(asset('public/backEnd/img/demo_wait.gif')); ?>" alt="loader">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mt-25">
                                        <div class="col-lg-12">        
                                            <div class="row">
                                                    <div class="col-lg-10">
                                                    <div class="main-title">
                                                        <h4><?php echo e(__('fees.instalment')); ?></h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <?php if(isset($fees_master)): ?>
                                                        <?php if($fees_master->installments): ?>
                                                            <button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addRowMark();" id="addRowUn">
                                                            <span class="ti-plus pr-2"></span></button>
                                                        <?php endif; ?>
                                                    <?php else: ?>  
                                                        <button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addRowMark();" id="addRowUn">
                                                        <span class="ti-plus pr-2"></span></button>   
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <table class="table" id="productTable">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('fees.title'); ?></th>
                                                        <th><?php echo app('translator')->get('fees.due_date'); ?></th>
                                                        <th><?php echo app('translator')->get('fees.amount'); ?></th>
                                                      
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if(isset($fees_master)): ?> 
                                                    <?php $i = 0; $totalPercentage = 0; ?>
                                                        <?php $__currentLoopData = $fees_master->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $installment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $i++; $totalPercentage += $installment->percentange; ?>
                                                        <tr id="row1" class="mt-40">
                                                            <td class="border-top-0">
                                                                <input type="hidden" value="<?php echo e($installment->id); ?>" id="installment_id" name="installment_id[]">
                                                                <div class="primary_input">
                                                                  
                                                                    <input type="hidden" value="<?php echo app('translator')->get('common.title'); ?>" id="lang">
                                                                    <input class="primary_input_field "
                                                                        type="text" id="title" name="title[]" autocomplete="off" value="<?php echo e(@$installment->title); ?>">
                                                                       
                                                                </div>
                                                            </td>
                                                            <td class="border-top-0" style="width:40%">
                                                                <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                                                <div class="row no-gutters input-right-icon">
                                                                    <div class="col">
                                                                        <div class="primary_input">
                                                                            <input class="primary_input_field  primary_input_field date form-control <?php echo e($errors->has('due_date') ? ' is-invalid' : ''); ?>" id="startDate" type="text"
                                                                                   name="due_date[]"
                                                                                   value="<?php echo e(isset($installment)? date('m/d/Y', strtotime($installment->due_date)): date('m/d/Y')); ?>">
                                                                           
                                                                            
                                                                            <?php if($errors->has('due_date')): ?>
                                                                                <span class="text-danger" >
                                                                                    <?php echo e($errors->first('due_date')); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <button class="" type="button">
                                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border-top-0" style="width:25%">
                                                                <div class="primary_input">
                                                                    <input oninput="numberCheck(this)" class="primary_input_field form-control<?php echo e($errors->has('unPercentage') ? ' is-invalid' : ''); ?> unPercentage"
                                                                            type="text" id="unPercentage" name="unPercentage[]" autocomplete="off"  onkeypress="return isNumberKey(event)" <?php echo e($fees_master->installmentAssign ? 'readonly' :''); ?> value="<?php echo e(isset($installment) ? $installment->percentange : 0); ?>">
                                                                            <?php if($errors->has('unPercentage')): ?>
                                                                            <span class="text-danger" >
                                                                                <?php echo e($errors->first('unPercentage')); ?>

                                                                            </span>
                                                                            <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            <?php if(!$fees_master->installments): ?>
                                                             <td class="border-0" style="width:10%">                               
                                                                <button class="primary-btn icon-only fix-gr-bg delete-row" type="button" id="<?php echo e($i != 1? 'removeInPercentage':''); ?>">
                                                                        <span class="ti-trash"></span>
                                                                </button>
                                                                
                                                            </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                    <tr id="row1" class="mt-40">
                                                        <td class="border-top-0">
                                                              
                                                            <div class="primary_input">
                                                                <input type="hidden" value="<?php echo app('translator')->get('common.title'); ?>" id="lang">
                                                                <input type="hidden" name="installment_id[]" value="0">
                                                               
                                                                <input class="primary_input_field form-control"
                                                                    type="text" id="title" name="title[]" autocomplete="off" value="<?php echo e(@$installment->title); ?>">
                                                                    
                                                            </div>
                                                        </td>
                                                        <td class="border-top-0" style="width:40%">
                                                            <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                                            <div class="row no-gutters input-right-icon">
                                                                <div class="col">
                                                                    <div class="primary_input">
                                                                        <input class="primary_input_field  primary_input_field date form-control <?php echo e($errors->has('date') ? ' is-invalid' : ''); ?>" id="startDate" type="text"
                                                                               name="due_date[]"
                                                                               value="<?php echo e(date('m/d/Y')); ?>">
                                                                       
                                                                        
                                                                        <?php if($errors->has('date')): ?>
                                                                            <span class="text-danger" >
                                                                                <?php echo e($errors->first('date')); ?>

                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button class="btn-date" data-id="#startDate" type="button">
                                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-top-0" style="width: 25%">
                                                            <div class="primary_input">
                                                               
                                                                <input oninput="numberCheck(this)" class="primary_input_field form-control<?php echo e($errors->has('unPercentage') ? ' is-invalid' : ''); ?> unPercentage"
                                                                        type="text" id="unPercentage" name="unPercentage[]" autocomplete="off"  onkeypress="return isNumberKey(event)"  value="0">
                                                            </div>
                                                        </td>
                                                        <td class="border-0" style="width: 10%">
                                                            
                                                            <button class="primary-btn icon-only fix-gr-bg delete-row" type="button">
                                                                <span class="ti-trash"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                        
                                                    <?php endif; ?>
                                        
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td class="border-top-0"></td>
                                                        <td class="border-top-0"><?php echo app('translator')->get('exam.total'); ?></td>
                                                        <td class="border-top-0" id="totalPercentage">
                                                            <input type="text" class="primary_input_field form-control<?php echo e($errors->has('totalPercentage') ? ' is-invalid' : ''); ?>" name="totalInstallmentAmount" value="<?php echo e(isset($fees_master) ? $totalPercentage :''); ?>" readonly="true">
                                                            <?php if($errors->has('totalInstallmentAmount')): ?>
                                                                <span class="text-danger" >
                                                                    <?php echo e($errors->first('totalInstallmentAmount')); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="border-top-0"></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>       
                                        </div>
                                    </div>
                    

	                            <?php 
                                  $tooltip = "";
                                  if(userPermission("fees-master-store")){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                ?>

                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="<?php echo e($tooltip); ?>">
                                            <span class="ti-check"></span>
                                            <?php if(isset($fees_master)): ?>
                                                <?php echo app('translator')->get('fees.update_fees_master'); ?>
                                            <?php else: ?>
                                                <?php echo app('translator')->get('fees.save_fees_master'); ?>
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
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0"><?php echo app('translator')->get('fees.fees_master_list'); ?></h3>
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
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                <thead>
                                 
                                    <tr>
                                        <th><?php echo app('translator')->get('common.name'); ?></th>
                                        <th><?php echo app('translator')->get('fees.amount'); ?></th>
                                        <th><?php echo app('translator')->get('fees.installment'); ?></th>
                                        <th><?php echo app('translator')->get('common.action'); ?></th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    <?php $__currentLoopData = $fees_masters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       
                                    <tr>
                                        <td valign="top">
                                            <?php $i = 0; ?>
                                            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $i++; ?>
                                            <?php if($i == 1): ?>
                                                <?php echo e(@$fees_master->feesGroups->name); ?>  
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     
                                            <div class="row">
                                                  
                                                    <div class="col-sm-2  nowrap">
                                                         <?php echo e(currency_format((float)$fees_master->amount)); ?>

                                                    </div>
                                               
                                            </div>
    
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $fees_master->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instalment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($instalment->title .'['. $instalment->due_date .']'. '['. (( $instalment->percentange)) .']'); ?> <br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td valign="top">
                                            <?php $i = 0; ?>
                                            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $i++; ?>
                                            <?php if($i == 1): ?>
                                            <div class="dropdown CRM_dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    <?php echo app('translator')->get('common.select'); ?>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <?php if(userPermission(120)): ?>
                                                        <a class="dropdown-item" href="<?php echo e(route('fees-master-edit', [$fees_master->id])); ?>"><?php echo app('translator')->get('common.edit'); ?></a>
                                                    <?php endif; ?>
                                                    <a class="dropdown-item deleteFeesMasterGroup" data-toggle="modal" href="#" data-id="<?php echo e($fees_master->id); ?>" data-target="#deleteFeesMasterGroup<?php echo e($fees_master->
                                                    id); ?>"><?php echo app('translator')->get('common.delete'); ?></a>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="modal fade admin-query" id="deleteFeesMasterGroup<?php echo e($fees_master->id); ?>" >
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo app('translator')->get('fees.delete_fees_master'); ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
    
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <h4><?php echo app('translator')->get('common.are_you_sure_to_delete'); ?></h4>
                                                            </div>
    
                                                            <div class="mt-40 d-flex justify-content-between">
                                                                <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('common.cancel'); ?></button>
                                                                <?php echo e(Form::open(['url' => 'fees-master-group-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                                                                <input type="hidden" name="id" value="<?php echo e($fees_master->id); ?>">
                                                                <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.delete'); ?></button>
                                                                <?php echo e(Form::close()); ?>

                                                            </div>
                                                        </div>
    
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                                        </td>
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
</section>


        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.partials.data_table_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('backEnd.partials.date_picker_css_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('Modules/University/Resources/assets/js/app.js')); ?>"></script>
<script>
        // add new row for marks distribution
        addRowMark = () => {
        $("#addRowUn").button("loading");
        var tableLength = $("#productTable tbody tr").length;
        var url = $("#url").val();
        var lang = $("#lang").val();
        var tableRow;
        var arrayNumber;
        var count;
        if (tableLength > 0) {
            tableRow = $("#productTable tbody tr:last").attr("id");
            arrayNumber = $("#productTable tbody tr:last").attr("class");
            count = tableRow.substring(3);
            count = Number(count) + 1;
            arrayNumber = Number(arrayNumber) + 1;
        } else {
            // no table row
            count = 1;
            arrayNumber = 0;
        }
        let row_count = parseInt($('#row_count').val());

        $("#addRowUn").button("reset");
        var newRow = `<tr id="row1" class="mt-40">
                            <td class="border-top-0">
                              
                              <div class="primary_input">
                                    <input type="hidden" name="installment_id[]" value="0">
                                  <input type="hidden" value="<?php echo app('translator')->get('common.title'); ?>" id="lang">
                                  <input class="primary_input_field "
                                      type="text" id="title" name="title[]" autocomplete="off" >
                              </div>
                          </td>
                        <td class="border-top-0">
                            <div class="row no-gutters input-right-icon">
                                <div class="col">
                                    <div class="primary_input">
                                        <input class="primary_input_field  primary_input_field date form-control has-content" id="startDate${tableLength}" type="text"
                                               name="due_date[]"
                                               value="<?php echo e(isset($visitor)? date('m/d/Y', strtotime($visitor->date)): date('m/d/Y')); ?>">
                                        
                                        <?php if($errors->has('date')): ?>
                                            <span class="text-danger" >
                                                <?php echo e($errors->first('date')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="" type="button">
                                        <label class="m-0 p-0" for="startDate${tableLength}">
                                            <i class="ti-calendar lower-icon" id="start-date-icon"></i>
                                        </label>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="border-top-0">
                            <div class="primary_input">
                                <input oninput="numberCheck(this)" class="primary_input_field form-control<?php echo e($errors->has('unPercentage') ? ' is-invalid' : ''); ?> unPercentage"
                                        type="text" id="unPercentage" name="unPercentage[]" autocomplete="off"  onkeypress="return isNumberKey(event)"  value="<?php echo e(isset($editData)? $editData->unPercentage : 0); ?>">
                            </div>
                        </td>
                        <td class="border-0">
                            <button class="primary-btn icon-only fix-gr-bg delete-row" type="button">
                                <span class="ti-trash" id='removeInPercentage'></span>
                            </button>
                        </td>
                    </tr>`;

     
        $('#row_count').val(row_count + 1);
        if (tableLength > 0) {
            $("#productTable tbody tr:last").after(newRow);
        } else {
            $("#productTable tbody").append(newRow);
        }

        $(".primary_input_field.date").datepicker({
            autoclose: true,
            setDate: new Date(),
        });
        
        $(".common-select").addClass("new_select_css");
    };
    // Assign class routine get subject
    $(document).on("click", "#removeInPercentage", function(event) {
        $(this).closest("tr").remove();
        var totalPercentage = 0;
        $('tr#row1 input[name^="unPercentage"]').each(function() {
            if ($(this).val() != "") {
                totalPercentage += parseInt($(this).val());
            }
        });

        $("th#totalPercentage input").val(totalPercentage);
    });

    $(document).on("keyup", ".unPercentage", function(event) {
        var totalPercentage = 0;
        var fees_amount = $('#fees_amount').val();
        $('tr#row1 input[name^="unPercentage"]').each(function() {
            if ($(this).val() != "") {
                totalPercentage += parseInt($(this).val());
                if(fees_amount < totalPercentage){
                    alert("you have distributed instalment more than fees master amount");
                    //  $('#fees_amount').val(totalPercentage);
                     $(":submit").attr("disabled", true);
                }else{
                    $(":submit").attr("disabled", false);
                }
                
            }
        });

        if (totalPercentage > parseInt($("#unPercentage_main").val())) {
            alert("you have distributed instalment more than 100");
            $(this).val(0);
            var totalPercentage = 0;
            var fees_master_amount = $("#fees_master_amount").val();
            $('tr#row1 input[name^="unPercentage"]').each(function() {
                if ($(this).val() != "") {
                    totalPercentage += parseInt($(this).val());
                }
            });
            $("th#totalPercentage input").val(totalPercentage);
            return false;
        }

        $("td#totalPercentage input").val(totalPercentage);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\resources\views/backEnd/feesCollection/directFees/fees_master.blade.php ENDPATH**/ ?>