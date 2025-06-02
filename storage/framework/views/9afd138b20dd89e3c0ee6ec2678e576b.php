<?php $__env->startSection('title'); ?> 
<?php echo app('translator')->get('fees.search_fees_payment'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
<?php  $setting = generalSetting(); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } ?>

<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('fees.search_fees_payment'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.fees_collection'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.search_fees_payment'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">               
                <div class="white-box">
                    <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'fees_payment_searches', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student'])); ?>

                        <input type="hidden" id="class" name="class" value="<?php echo e(@$class); ?>">
                        <input type="hidden" id="section" name="section" value="<?php echo e(@$section); ?>">
                        <input type="hidden" id="class" name="class" value="<?php echo e(@$section); ?>">
                        <input type="hidden" id="date_from" name="date_from" value="<?php echo e(@$date_from); ?>">
                        <input type="hidden" id="date_to" name="date_to" value="<?php echo e(@$date_to); ?>">
                        <input type="hidden" id="keyword" name="keyword" value="<?php echo e(@$keyword); ?>">
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">

                            <?php if(moduleStatusCheck('University')): ?>
                            <div class="col-lg-3">
                                <div class="primary_input">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('university::un.date_from'); ?> <span></span></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input name="date_from" readonly
                                                    class="primary_input_field  primary_input_field date form-control <?php echo e($errors->has('date_from') ? ' is-invalid' : ''); ?>"
                                                    type="text" autocomplete="off"
                                                    value="<?php echo e(isset($date_from) ? ($date_from != '' ? $date_from : '') : old('date_from')); ?>">
                                                </div>
                                            </div>
                                            <button class="btn-date" data-id="#startDate" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"><?php echo e($errors->first('date_from')); ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="primary_input">
                                    <?php if($errors->has('date_to')): ?>
                                        <span class="text-danger invalid-select" role="alert" style="display:block">
                                            <?php echo e($errors->first('date_to')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="primary_input">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('university::un.date_to'); ?> <span></span> </label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input name="date_to" readonly
                                                    class="primary_input_field  primary_input_field date form-control <?php echo e($errors->has('date_to') ? ' is-invalid' : ''); ?>"
                                                    type="text" autocomplete="off"
                                                    value="<?php echo e(isset($date_to) ? ($date_to != '' ? $date_to : '') : old('date_to')); ?>">
                                                </div>
                                            </div>
                                            <button class="btn-date" data-id="#startDate" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="text-danger"><?php echo e($errors->first('date_from')); ?></span>
                                </div>
                            </div>
                            <?php if ($__env->exists('university::common.session_faculty_depart_academic_semester_level',  ['hide'=>['USUB'],'required'=> ['US','UF','UD','UA','USN','US','USL'], 'dept_mt'=>'mt-15', 'ac_mt'=>'mt-15'])) echo $__env->make('university::common.session_faculty_depart_academic_semester_level',  ['hide'=>['USUB'],'required'=> ['US','UF','UD','UA','USN','US','USL'], 'dept_mt'=>'mt-15', 'ac_mt'=>'mt-15'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php else: ?>
                            <div class="col-lg-2 mt-30-md">
                                <div class="primary_input">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.date_from'); ?> <span></span></label>
                                    <input name="date_from" readonly
                                           class="primary_input_field  primary_input_field date form-control <?php echo e($errors->has('date_from') ? ' is-invalid' : ''); ?>"
                                           type="text" autocomplete="off"
                                           value="<?php echo e(isset($date_from) ? ($date_from != '' ? $date_from : '') : old('date_from')); ?>">
                                   
                                    
                                    <?php if($errors->has('date_from')): ?>
                                        <span class="text-danger"  style="display:block">
                                            <?php echo e($errors->first('date_from')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-2 mt-30-md">
                                <div class="primary_input">
                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.date_to'); ?> <span></span> </label>
                                    <input name="date_to" readonly
                                           class="primary_input_field  primary_input_field date form-control <?php echo e($errors->has('date_to') ? ' is-invalid' : ''); ?>"
                                           type="text" autocomplete="off"
                                           value="<?php echo e(isset($date_to) ? ($date_to != '' ? $date_to : '') : old('date_to')); ?>">
                                   
                                    
                                    <?php if($errors->has('date_to')): ?>
                                        <span class="text-danger invalid-select" role="alert" style="display:block">
                                            <?php echo e($errors->first('date_to')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                           
                            <div class="col-lg-2 mt-30-md">
                                <label class="primary_input_label" for=""><?php echo app('translator')->get('common.class'); ?></label>
                                <select class="primary_select form-control <?php echo e($errors->has('class') ? ' is-invalid' : ''); ?>" id="select_class" name="class">
                                    <option data-display="<?php echo app('translator')->get('common.select_class'); ?>" value=""><?php echo app('translator')->get('common.select_class'); ?> </option>
                                    <?php $__currentLoopData = @$classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($class->id); ?>"  <?php echo e(( old("class") == $class->id ? "selected":"")); ?>><?php echo e($class->class_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($errors->has('class')): ?>
                                <span class="text-danger invalid-select" role="alert">
                                    <?php echo e($errors->first('class')); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-2 mt-30-md" id="select_section_div">
                                <label class="primary_input_label" for=""><?php echo app('translator')->get('common.section'); ?>  </label>
                                <select class="primary_select form-control<?php echo e($errors->has('current_section') ? ' is-invalid' : ''); ?>" id="select_section" name="section">
                                    <option data-display="<?php echo app('translator')->get('common.select_section'); ?>" value=""><?php echo app('translator')->get('common.select_section'); ?></option>
                                </select>
                                <div class="pull-right loader loader_style" id="select_section_loader">
                                    <img class="loader_img_style" src="<?php echo e(asset('public/backEnd/img/demo_wait.gif')); ?>" alt="loader">
                                </div>
                                <?php if($errors->has('section')): ?>
                                <span class="text-danger invalid-select d-block" role="alert">
                                    <?php echo e($errors->first('section')); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <div class="col-lg-4 <?php echo e(moduleStatusCheck('University') ? 'mt-15' : ''); ?> ">
                                <label class="primary_input_label" for=""><?php echo app('translator')->get('common.search_by_name'); ?>, <?php echo app('translator')->get('student.admission_no'); ?>,<?php echo app('translator')->get('student.roll_no'); ?></label>
                                <div class="primary_input">
                                    <input class="primary_input_field form-control" type="text" name="keyword">
                                  
                                </div>
                            </div>
                                                            

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
                                <h3 class="mb-15"> <?php echo app('translator')->get('fees.payment_ID_Details'); ?></h3>
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
                                            <th><?php echo app('translator')->get('fees.payment_id'); ?></th>
                                            <th><?php echo app('translator')->get('common.date'); ?></th>
                                            <th><?php echo app('translator')->get('common.name'); ?></th>
                                            <?php if(moduleStatusCheck('University')): ?>
                                                <th><?php echo app('translator')->get('university::un.semester_label'); ?></th>
                                                <th><?php echo app('translator')->get('university::un.installment'); ?></th>
                                            <?php else: ?>
                                                <th><?php echo app('translator')->get('common.class'); ?></th>
                                            <?php endif; ?>
                                            <?php if(directFees()): ?>
                                                <th><?php echo app('translator')->get('fees.installment'); ?></th>
                                            <?php else: ?>
                                                <th><?php echo app('translator')->get('fees.fees_type'); ?></th>
                                            <?php endif; ?>
                                            <th><?php echo app('translator')->get('fees.mode'); ?></th>
                                            <th><?php echo app('translator')->get('fees.amount'); ?> (<?php echo e(generalSetting()->currency_symbol); ?>) </th>
                                            <th><?php echo app('translator')->get('common.action'); ?></th>
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
<?php echo $__env->make('backEnd.partials.date_picker_css_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('backEnd.partials.data_table_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('backEnd.partials.server_side_datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="modal fade admin-query" id="deleteFeesPayment">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('fees.delete_fees_payment'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4><?php echo app('translator')->get('common.are_you_sure_to_delete'); ?></h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('common.cancel'); ?></button>
                    <?php echo e(Form::open(['route' => array('fees-payment-delete'), 'method' => 'POST'])); ?>

                    <input type="hidden" name="id" value="">
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.delete'); ?></button>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php $__env->startPush('script'); ?>  

<script>
   $(document).ready(function() {
       $('.data-table').DataTable({
                     processing: true,
                     serverSide: true,
                     "ajax": $.fn.dataTable.pipeline( {
                           url: "<?php echo e(route('ajaxFeesPayment')); ?>",
                           data: { 
                                class: $('#class').val(),
                                section: $('#section').val(),
                                date_from: $('#date_from').val(),
                                date_to: $('#date_to').val(),
                                keyword: $('#keyword').val(),
                            },
                           pages: "<?php echo e(generalSetting()->ss_page_load); ?>" // number of pages to cache
                           
                       } ),
                       columns: [
                           {data: 'invoice', name: 'invoice'},
                           {data: 'date', name: 'date'},
                           {data: 'record_detail.student_detail.full_name', name: 'full_name'},
                           <?php if(moduleStatusCheck('University')): ?>
                           {data: 'class_sec', name: 'class_sec'},
                           {data: 'fees_installment.installment.title', name: 'title'},
                           <?php elseif(directFees()): ?>
                           {data: 'class_sec', name: 'class_sec'},
                           {data: 'fees_installment.installment.title', name: 'title'},
                           <?php else: ?>
                           {data: 'class_sec', name: 'class_sec'},
                           {data: 'fees_type.name', name: 'fees_type_name'},
                           <?php endif; ?> 
                           {data: 'payment_mode', name: 'payment_mode'},
                           {data: 'fees_amount', name: 'amount'},
                           {data: 'action', name: 'action', orderable: false, searchable: true},
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

    function deleteFeesPayment(id){
        var modal = $('#deleteFeesPayment');
        modal.find('input[name=id]').val(id)
        modal.modal('show');
    }
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\resources\views/backEnd/feesCollection/search_fees_payment.blade.php ENDPATH**/ ?>