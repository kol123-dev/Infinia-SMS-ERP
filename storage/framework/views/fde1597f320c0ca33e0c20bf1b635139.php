<?php $__env->startSection('title'); ?> 
<?php echo app('translator')->get('fees.bank_payment'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
<section class="sms-breadcrumb mb-20 up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('fees.bank_payment'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.fees_collection'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.bank_payment'); ?></a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="main-title mt_0_sm mt_0_md">
                                    <h3 class="mb-15"><?php echo app('translator')->get('common.select_criteria'); ?> </h3>
                                </div>
                            </div>
                        </div>
                        <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'bank-payment-slips', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_studentA'])); ?>

                            <input type="hidden" id="class" name="class_id" value="<?php echo e(@$class_id); ?>">
                            <input type="hidden" id="section" name="section_id" value="<?php echo e(@$section_id); ?>">
                            <input type="hidden" id="p_date" name="p_date" value="<?php echo e(@$date); ?>">
                            <input type="hidden" id="status" name="status" value="<?php echo e(@$approve_status); ?>">
                            <input type="hidden" id="un_semester_label_id" name="un_semester_label_id" value="<?php echo e(@$un_semester_label_id); ?>">
                        <?php if(moduleStatusCheck('University')): ?>
                        <div class="row">
                            <?php if ($__env->exists('university::common.session_faculty_depart_academic_semester_level',['required' => ['USN','UF', 'UD', 'UA', 'US', 'USL'], 'hide' => ['USUB']])) echo $__env->make('university::common.session_faculty_depart_academic_semester_level',['required' => ['USN','UF', 'UD', 'UA', 'US', 'USL'], 'hide' => ['USUB']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="col-lg-3 col-md-3 mt-15">
                                <label for=""><?php echo app('translator')->get('common.status'); ?></label>
                                <select class="primary_select  form-control<?php echo e($errors->has('approve_status') ? ' is-invalid' : ''); ?>" name="approve_status">
                                    <option data-display="<?php echo app('translator')->get('common.status'); ?>" value=""><?php echo app('translator')->get('common.status'); ?></option>
                                    <option value="0" <?php echo e(isset($approve_status)? ($approve_status == 0? 'selected': ''):''); ?>><?php echo app('translator')->get('common.pending'); ?></option>
                                    <option value="1" <?php echo e(isset($approve_status)? ($approve_status == 1? 'selected': ''):''); ?>><?php echo app('translator')->get('common.approved'); ?></option>
                                </select>
                                 <?php if($errors->has('approve_status')): ?>
                                <span class="text-danger invalid-select" role="alert">
                                    <?php echo e($errors->first('approve_status')); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                <div class="col-lg-3 col-md-3 ">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('common.class'); ?> </label>
                                    <select class="primary_select  form-control<?php echo e($errors->has('class') ? ' is-invalid' : ''); ?>" id="select_class" name="class">
                                        <option data-display="<?php echo app('translator')->get('common.select_class'); ?>" value=""><?php echo app('translator')->get('common.select_class'); ?></option>
                                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($class->id); ?>" <?php echo e(isset($class_id)? ($class_id == $class->id? 'selected': ''):''); ?>><?php echo e($class->class_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                     <?php if($errors->has('class')): ?>
                                    <span class="text-danger invalid-select" role="alert">
                                        <?php echo e($errors->first('class')); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 col-md-3" id="select_section_div">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('common.section'); ?> </label>
                                    <select class="primary_select  form-control<?php echo e($errors->has('section') ? ' is-invalid' : ''); ?>" id="select_section" name="section">
                                        <option data-display="<?php echo app('translator')->get('common.select_section'); ?>" value=""><?php echo app('translator')->get('common.select_section'); ?></option>
                                        <?php if(isset($section_id)): ?>
                                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($section->id); ?>" <?php echo e(isset($section_id)? ($section_id == $section->id? 'selected': ''):''); ?>><?php echo e($section->section_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="<?php echo e(asset('public/backEnd/img/demo_wait.gif')); ?>" alt="loader">
                                    </div>
                                    <?php if($errors->has('section')): ?>
                                    <span class="text-danger invalid-select" role="alert">
                                        <?php echo e($errors->first('section')); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 col-md-3 mt-30-md">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="primary_input">
                                                <label for="startDate"><?php echo app('translator')->get('fees.payment_date'); ?></label>
                                                <input class="primary_input_field  primary_input_field date form-control form-control<?php echo e($errors->has('payment_date') ? ' is-invalid' : ''); ?> <?php echo e(isset($date)? 'read-only-input': ''); ?>" id="startDate" type="text"
                                                    name="payment_date" autocomplete="off" value="<?php echo e(isset($date)? $date: ''); ?>">
                                                
                                                
                                                <?php if($errors->has('payment_date')): ?>
                                                <span class="text-danger" >
                                                    <?php echo e($errors->first('payment_date')); ?>

                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <label class="m-0 p-0" for="startDate">
                                                <i style="position: relative; top: 15px;" class="ti-calendar" id="admission-date-icon"></i>
                                            </label>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 ">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('common.status'); ?> </label>
                                    <select class="primary_select  form-control<?php echo e($errors->has('approve_status') ? ' is-invalid' : ''); ?>" name="approve_status">
                                        <option data-display="<?php echo app('translator')->get('common.status'); ?>" value=""><?php echo app('translator')->get('common.status'); ?></option>
                                        <option value="0" <?php echo e(isset($approve_status)? ($approve_status == 0? 'selected': ''):''); ?>><?php echo app('translator')->get('common.pending'); ?></option>
                                        <option value="1" <?php echo e(isset($approve_status)? ($approve_status == 1? 'selected': ''):''); ?>><?php echo app('translator')->get('common.approved'); ?></option>
                                    </select>
                                     <?php if($errors->has('approve_status')): ?>
                                    <span class="text-danger invalid-select" role="alert">
                                        <?php echo e($errors->first('approve_status')); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                        <?php endif; ?> 
                        <div class="row">
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
            
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">  <?php echo app('translator')->get('fees.bank_payment_list'); ?></h3>
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
                                    <table id="table_id" class="table data-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th><?php echo app('translator')->get('student.admission_no'); ?></th>
                                                <th><?php echo app('translator')->get('student.student_name'); ?></th>
                                                <?php if(moduleStatusCheck('University')): ?>
                                                <th><?php echo app('translator')->get('university::un.installment'); ?></th>
                                                <?php elseif(directFees()): ?>
                                                <th><?php echo app('translator')->get('fees.installment'); ?></th>
                                                <?php else: ?>
                                                <th><?php echo app('translator')->get('fees.fees_type'); ?></th>
                                                <?php endif; ?> 
                                                <th><?php echo app('translator')->get('common.date'); ?></th>
                                                <th><?php echo app('translator')->get('accounts.amount'); ?></th>
                                                <th><?php echo app('translator')->get('accounts.bank'); ?></th>
                                                <th><?php echo app('translator')->get('common.note'); ?></th>
                                                <th><?php echo app('translator')->get('accounts.slip'); ?></th>
                                                <th><?php echo app('translator')->get('common.status'); ?></th>
                                                <th><?php echo app('translator')->get('common.actions'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
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

<div class="modal fade admin-query" id="enableStudentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('fees.approve_payment'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4><?php echo app('translator')->get('fees.are_you_sure_to_approve'); ?></h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('common.cancel'); ?></button>
                     <?php echo e(Form::open(['route' => 'approve-fees-payment', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                  
                     <input type="hidden" name="class" value="<?php echo e(@$class_id); ?>">
                     <input type="hidden" name="section" value="<?php echo e(@$section_id); ?>">
                     <input type="hidden" name="payment_date" value="<?php echo e(@$date); ?>">
                     <input type="hidden" name="id" value="" id="student_enable_i">
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('fees.approve'); ?></button>
                     <?php echo e(Form::close()); ?>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- modal start here  -->

<div class="modal fade admin-query" id="rejectPaymentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('fees.bank_payment_reject'); ?> </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                        <h4><?php echo app('translator')->get('fees.are_you_sure_to_reject'); ?></h4>
                    </div>
              <?php echo e(Form::open(['route' => 'reject-fees-payment', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                <div class="form-group">
                    <input type="hidden" name="id" id="showId">
                    <label><strong><?php echo app('translator')->get('fees.reject_note'); ?></strong></label>
                    <textarea name="payment_reject_reason" class="form-control" rows="6"></textarea>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('common.close'); ?></button>
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.submit'); ?></button>
                </div>
                <?php echo e(Form::close()); ?>


            </div>

        </div>
    </div>
</div>
<div class="modal fade admin-query" id="showReasonModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('fees.reject_note'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong><?php echo app('translator')->get('fees.reject_note'); ?></strong></label>
                    <textarea readonly class="form-control" rows="4"></textarea>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn fix-gr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php if(! isset($all_bank_slips)): ?>
<?php $__env->startPush('script'); ?>  
<?php echo $__env->make('backEnd.partials.data_table_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('backEnd.partials.server_side_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('backEnd.partials.date_picker_css_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
//
// DataTables initialisation
//
$(document).ready(function() {
   $('.data-table').DataTable({
                 processing: true,
                 serverSide: true,
                 "ajax": $.fn.dataTable.pipeline( {
                       url: "<?php echo e(url('bank-payment-slip-ajax')); ?>",
                       data: { 
                            un_semester_label_id: $('#un_semester_label_id').val(), 
                            class: $('#class').val(), 
                            section: $('#section').val(), 
                            payment_date: $('#p_date').val(), 
                            approve_status: $('#status').val()
                        },
                       pages: "<?php echo e(generalSetting()->ss_page_load); ?>" // number of pages to cache
                       
                   } ),
                   columns: [
                       {data: 'student_info.admission_no', name: 'amount'},
                       {data: 'student_info.full_name', name: 'amount'},
                       <?php if(moduleStatusCheck('University')): ?>
                       {data: 'installment_assign.installment.title', name: 'title'},
                       <?php elseif(directFees()): ?>
                       {data: 'installment_assign.installment.title', name: 'title'},
                       <?php else: ?> 
                       {data: 'fees_type.name', name: 'fees_type'},
                       <?php endif; ?> 
                       {data: 'date', name: 'date'},
                       {data: 'p_amount', name: 'amount'},
                       {data: 'payment_mode', name: 'payment_mode'},
                       {data: 'note', name: 'note'},
                       {data: 'slip', name: 'slip'},
                       {data: 'status', name: 'status'},
                       {data: 'action', name: 'action',orderable: false, searchable: true},
                       
                    ],
                    bLengthChange: false,
                bDestroy: true,
                language: {
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: window.jsLang('quick_search'),
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>",
                    },
                },
                dom: "Bfrtip",
                buttons: [{
                    extend: "copyHtml5",
                    text: '<i class="fa fa-files-o"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: window.jsLang('copy_table'),
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    },
                },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: window.jsLang('export_to_excel'),
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "csvHtml5",
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: window.jsLang('export_to_csv'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('export_to_pdf'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                        orientation: "landscape",
                        pageSize: "A4",
                        margin: [0, 0, 0, 12],
                        alignment: "center",
                        header: true,
                        customize: function(doc) {
                            doc.content[1].margin = [100, 0, 100, 0]; //left, top, right, bottom
                            doc.content.splice(1, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: "center",
                                image: "data:image/png;base64," + $("#logo_img").val(),
                            });
                            doc.defaultStyle = {
                                font: 'DejaVuSans'
                            }
                        },
                    },
                    {
                        extend: "print",
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: window.jsLang('print'),
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "colvis",
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ["colvisRestore"],
                    },
                ],
                columnDefs: [{
                    visible: false,
                }, ],
                responsive: true,
            });
        } );
        </script>
<?php $__env->stopPush(); ?> 
<?php endif; ?>
<?php $__env->startPush('script'); ?>
    <script>
        function rejectPayment(id){
            var modal = $('#rejectPaymentModal');
            modal.find('#showId').val(id)
            modal.modal('show');

        }
        function viewReason(id){
            var reason = $('.reason'+ id).data('reason');
            var modal = $('#showReasonModal');
            modal.find('textarea').val(reason)
            modal.modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\resources\views/backEnd/feesCollection/bank_payment_slip.blade.php ENDPATH**/ ?>