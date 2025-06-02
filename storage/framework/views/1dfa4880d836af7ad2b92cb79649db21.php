<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('admin.certificate'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
    <input type="hidden" id="moduleStatus" value="University">

    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1><?php echo app('translator')->get('admin.certificate'); ?></h1>
                <div class="bc-pages">
                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                    <a href="#"><?php echo app('translator')->get('bulkprint::bulk.bulk_print'); ?></a>
                    <a href="#"><?php echo app('translator')->get('admin.certificate'); ?></a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <?php echo e(Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'route' => 'certificate-bulk-print-seacrh'])); ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-8 col-md-6">
                                <div class="main-title">
                                    <h3 class="mb-15"><?php echo app('translator')->get('common.select_criteria'); ?> </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                            <div class="col-lg-4 mt-30-md systemRole d-none">
                                <select class="primary_select" name="certificate_role" id="certificateRole">
                                    <option data-display="<?php echo app('translator')->get('admin.select_role'); ?> *" value=""><?php echo app('translator')->get('admin.select_role'); ?> *</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role->id); ?>" <?php echo e(old('certificate_role') ? 'selected' : ''); ?>>
                                            <?php echo e($role->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has('certificate_role')): ?>
                                    <span class="text-danger invalid-select" role="alert">
                                        <?php echo e(@$errors->first('certificate_role')); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php if(!moduleStatusCheck('University')): ?>
                                <div class="col-lg-4 mt-30-md classSection">
                                    <label for="checkbox" class="primary_input_label"><?php echo app('translator')->get('common.select_class'); ?></label>
                                    <select multiple id="multipleClass"
                                        class="multypol_check_select active position-relative" name="certificateBulkClass[]"
                                        style="width:300px">
                                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(@$class->id); ?>"><?php echo e(@$class->class_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <?php if($errors->has('class')): ?>
                                        <span class="text-danger invalid-select" role="alert">
                                            <?php echo e(@$errors->first('class')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="col-lg-4 mt-30-md" id="certificate-div">
                                <label class="primary_input_label" for=""><?php echo app('translator')->get('admin.certificate'); ?> <span
                                        class="text-danger">*</span></label>
                                <select
                                    class="primary_select  form-control<?php echo e($errors->has('certificate') ? ' is-invalid' : ''); ?>"
                                    id="certificateList" name="certificate">
                                    <option data-display=" <?php echo app('translator')->get('admin.select_certificate'); ?> *" value=""> <?php echo app('translator')->get('admin.select_certificate'); ?> *
                                    </option>
                                    <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"> <?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="pull-right loader loader_style" id="certificateLoader">
                                    <img class="loader_img_style" src="<?php echo e(asset('public/backEnd/img/demo_wait.gif')); ?>"
                                        alt="loader">
                                </div>

                                <?php if($errors->has('certificate')): ?>
                                    <span class="text-danger invalid-select" role="alert">
                                        <?php echo e(@$errors->first('certificate')); ?>

                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-lg-4 mt-30-md gridGap">
                                <div class="primary_input">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('admin.grid_gap'); ?>(px)</label>
                                    <input
                                        class="primary_input_field form-control<?php echo e($errors->has('grid_gap') ? ' is-invalid' : ''); ?>"
                                        type="number" name="grid_gap" autocomplete="off" value="<?php echo e(old('grid_gap')); ?>">

                                    <?php if($errors->has('grid_gap')): ?>
                                        <span class="text-danger">
                                            <?php echo e($errors->first('grid_gap')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if(moduleStatusCheck('University')): ?>
                                <input type="hidden" id="moduleStatus" value="University">
                                <div class="col-lg-12 mt-25 classSection d-none">
                                    <div class="row">
                                        <?php if ($__env->exists(
                                            'university::common.session_faculty_depart_academic_semester_level',
                                            ['hide' => ['USUB'], 'div' => 'col-lg-4', 'ac_mt' => 'col-lg-25']
                                        )) echo $__env->make(
                                            'university::common.session_faculty_depart_academic_semester_level',
                                            ['hide' => ['USUB'], 'div' => 'col-lg-4', 'ac_mt' => 'col-lg-25']
                                        , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-printer pr-2"></span>
                                    <?php echo app('translator')->get('common.search'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </section>

    <?php if(isset($users)): ?>
        <section class="admin-visitor-area up_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-lg-2 no-gutters">
                                    <div class="main-title">
                                        <h3 class="mb-0"><?php echo app('translator')->get('admin.certificate_list'); ?></h3>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <input type="hidden" value="<?php echo e($certificate->id); ?>" id="certificate">
                                    <a href="javascript:;" id="bulk-genearte-certificate-print-button"
                                        class="primary-btn small fix-gr-bg">
                                        <?php echo app('translator')->get('bulkprint::bulk.generate'); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table school-table-style" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10%">
                                                    <input type="checkbox" id="checkAll"
                                                        class="common-checkbox generate-certificate-print-all" name="checkAll"
                                                        value="">
                                                    <label for="checkAll"><?php echo app('translator')->get('common.all'); ?></label>
                                                </th>
                                                <th><?php echo app('translator')->get('common.name'); ?></th>
                                                <th><?php echo app('translator')->get('common.name'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" id="student.<?php echo e(@$user->user_id); ?>"
                                                            class="common-checkbox generate-certificate-print"
                                                            name="student_checked[]" value="<?php echo e(@$user->user_id); ?>">
                                                        <label for="student.<?php echo e(@$user->user_id); ?>"></label>
                                                    </td>
                                                    <td><?php echo e(@$user->full_name); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.partials.multi_select_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startPush('script'); ?>
    <script type="text/javascript" src="<?php echo e(url('Modules\BulkPrint\Resources\assets\js\app.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $("#certificateRole").on("change", function() {
                if ($(this).val() == 2) {
                    $('.classSection').removeClass('d-none');
                    if ($('#moduleStatus').val() == '') {
                        $('.systemRole').removeClass('col-lg-4');
                        $('.systemRole').addClass('col-lg-2');
                        $('.gridGap').removeClass('col-lg-4');
                        $('.gridGap').addClass('col-lg-2');
                    }
                } else {
                    $('.classSection').addClass('d-none');
                    $('#certificateClass').val('');
                    $('.systemRole').removeClass('col-lg-2');
                    $('.systemRole').addClass('col-lg-4');
                    $('.gridGap').removeClass('col-lg-2');
                    $('.gridGap').addClass('col-lg-4');
                }
                var i = 0;
                var formData = {
                    role_id: $(this).val(),
                };

                $.ajax({
                    type: "GET",
                    data: formData,
                    dataType: "json",
                    url: '<?php echo e(route('get-role-wise-certificate')); ?>',
                    beforeSend: function() {
                        $('#certificateLoader').addClass('pre_loader');
                        $('#certificateLoader').removeClass('loader');
                    },
                    success: function(data) {
                        $.each(data, function(i, item) {
                            if (item.length) {
                                $("#certificateList").find("option").not(":first")
                                    .remove();
                                $("#certificate-div ul").find("li").not(":first")
                                    .remove();

                                $.each(item, function(i, certificate) {
                                    $("#certificateList").append(
                                        $("<option>", {
                                            value: certificate.id,
                                            text: certificate.title,
                                        })
                                    );

                                    $("#certificate-div ul").append(
                                        "<li data-value='" +
                                        certificate.id +
                                        "' class='option'>" +
                                        certificate.title +
                                        "</li>"
                                    );
                                });
                            } else {
                                $("#certificate-div .current").html("Certicicate *");
                                $("#certificateList").find("option").not(":first")
                                    .remove();
                                $("#certificate-div ul").find("li").not(":first")
                                    .remove();
                            }
                        });
                    },
                    error: function(data) {
                        console.log("Error:", data);
                    },
                    complete: function() {
                        i--;
                        if (i <= 0) {
                            $('#certificateLoader').removeClass('pre_loader');
                            $('#certificateLoader').addClass('loader');
                        }
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Modules/BulkPrint\Resources/views/admin/generate_certificate_bulk.blade.php ENDPATH**/ ?>