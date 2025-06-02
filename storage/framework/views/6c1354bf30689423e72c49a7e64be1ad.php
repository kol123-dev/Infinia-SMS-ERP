<?php $__env->startSection('title'); ?> 
    <?php echo app('translator')->get('fees.collect_fees'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('fees.collect_fees'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.fees_collection'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.collect_fees'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="white-box">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-15"><?php echo app('translator')->get('common.select_criteria'); ?> </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'collect_fees_search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student'])); ?>

                            <div class="row">
                                <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                <?php if(moduleStatusCheck('University')): ?>
                                <?php if ($__env->exists('university::common.session_faculty_depart_academic_semester_level',  ['hide'=>['USUB'],'required'=> ['US','UF','UD','UA','USN','US','USL']])) echo $__env->make('university::common.session_faculty_depart_academic_semester_level',  ['hide'=>['USUB'],'required'=> ['US','UF','UD','UA','USN','US','USL']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php else: ?>
                                <div class="col-lg-3 mt-30-md infix_up_mt">
                                    <select class="primary_select form-control <?php echo e($errors->has('class') ? ' is-invalid' : ''); ?>" id="select_class" name="class">
                                        <option data-display="<?php echo app('translator')->get('common.select_class'); ?>" value=""><?php echo app('translator')->get('common.select_class'); ?>* </option>
                                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($class->id); ?>"  <?php echo e(( old("class") == $class->id ? "selected":"")); ?>><?php echo e($class->class_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('class')): ?>
                                    <span class="text-danger invalid-select" role="alert">
                                        <?php echo e($errors->first('class')); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 mt-30-md infix_up_mt" id="select_section_div">
                                    <select class="primary_select form-control<?php echo e($errors->has('current_section') ? ' is-invalid' : ''); ?>" id="select_section" name="section">
                                        <option data-display="<?php echo app('translator')->get('common.select_section'); ?>" value=""><?php echo app('translator')->get('common.select_section'); ?></option>
                                    </select>
                                    <?php if($errors->has('section')): ?>
                                    <span class="text-danger invalid-select" role="alert">
                                        <?php echo e($errors->first('section')); ?>

                                    </span>
                                    <?php endif; ?>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="<?php echo e(asset('public/backEnd/img/demo_wait.gif')); ?>" alt="loader">
                                    </div>
                                </div>
    
                                <div class="col-lg-6 mt-30-md infix_up_mt">
                                    <div class="primary_input">
                                
                                        <input class="primary_input_field form-control" type="text" name="keyword" placeholder="<?php echo app('translator')->get('fees.search_by_name'); ?>, <?php echo app('translator')->get('student.admission'); ?>, <?php echo app('translator')->get('student.roll'); ?>, <?php echo app('translator')->get('student.national_id'); ?>, <?php echo app('translator')->get('student.local_id_number'); ?>">
                                    
                                    </div>
                                </div>
                                <?php endif; ?>
    
                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        <?php echo app('translator')->get('common.search'); ?>
                                    </button>
                                </div>
                            </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
            
        <?php if(isset($students)): ?>
            <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-lg-8 no-gutters">
                                    <div class="main-title mb-10">
                                        <h3 class="mb-0"><?php echo app('translator')->get('fees.fees_collection_list'); ?></h3>
                                            
                                             <p class="fs-12">
                                             <?php if(! moduleStatusCheck('University')): ?>
                                             (<?php echo app('translator')->get('common.class'); ?>: <?php echo e($search_info['class_name']); ?>, <?php echo app('translator')->get('common.section'); ?>: <?php echo e(@$search_info['section_name']); ?>, <?php echo app('translator')->get('fees.keyword'); ?>: <?php echo e(@$search_info['keyword']); ?>)
                                             <?php endif; ?>
                                             </p>
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
                                                    <th><?php echo app('translator')->get('student.admission_no'); ?></th>
                                                    <th><?php echo app('translator')->get('common.name'); ?></th>
                                                    <th><?php echo app('translator')->get('common.date_of_birth'); ?></th>
                                                    <th><?php echo app('translator')->get('common.phone'); ?></th>
    
                                                    <?php if(! moduleStatusCheck('University')): ?>
                                                    <th><?php echo app('translator')->get('common.class'); ?></th>
                                                    <th><?php echo app('translator')->get('common.section'); ?></th>
                                                    <th><?php echo app('translator')->get('student.father_name'); ?></th>
                                                    <?php endif; ?>
                                                    <th><?php echo app('translator')->get('common.action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($student->studentDetail->admission_no); ?></td>
                                                        <td><?php echo e($student->studentDetail->first_name.' '.$student->studentDetail->last_name); ?></td>
                                                        <td ><?php echo e($student->studentDetail->date_of_birth != ""? dateConvert($student->studentDetail->date_of_birth):''); ?></td>
                                                        <td><?php echo e($student->studentDetail->mobile); ?></td>
    
                                                        <?php if(! moduleStatusCheck('University')): ?>
                                                        <td><?php echo e($student->class->class_name); ?></td>
                                                        <td><?php echo e($student->section->section_name); ?></td>
                                                        <td><?php echo e($student->studentDetail->parents != ""? $student->studentDetail->parents->fathers_name:""); ?></td>
                                                        <?php endif; ?>
    
                                                        <?php if(userPermission("fees_collect_student_wise")): ?>
                                                            <td>
                                                                <a target="_blank" href="<?php echo e(route('fees_collect_student_wise', [$student->id])); ?>" class="primary-btn small tr-bg text-nowrap">
                                                                    <?php echo app('translator')->get('fees.collect_fees'); ?>
                                                                </a>
                                                            </td>
                                                        <?php endif; ?>
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
            <?php echo e(Form::close()); ?>

        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.partials.data_table_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\resources\views/backEnd/feesCollection/collect_fees.blade.php ENDPATH**/ ?>