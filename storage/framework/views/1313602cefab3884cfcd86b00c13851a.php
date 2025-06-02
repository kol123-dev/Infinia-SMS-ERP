<?php $__env->startSection('title'); ?> 
<?php echo app('translator')->get('fees.collect_fees'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
<?php 
$setting = generalSetting(); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } 
$total_fees = 0;
$total_due = 0;
$total_paid = 0;
$total_disc = 0;
$total_balance = 0;
$record = $student;
?>
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('fees.fees_collection'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('fees.fees_collection'); ?></a>
                <a href="<?php echo e(route('collect_fees')); ?>"><?php echo app('translator')->get('fees.collect_fees'); ?></a>
                <a href="<?php echo e(route('fees_collect_student_wise', [$student->id])); ?>"><?php echo app('translator')->get('fees.student_wise'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="student-details mb-40">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="student-meta-box">
                    <div class="white-box">
                        <div class="row">

                            <div class="col-lg-12 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15"><?php echo app('translator')->get('fees.student_fees'); ?></h3>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <div class="single-meta mt-20">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="value text-left">
                                                <?php echo app('translator')->get('common.name'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="name">
                                                <?php echo e(@$student->studentDetail->full_name); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="value text-left">
                                                <?php if(moduleStatusCheck('University')): ?>
                                                <?php echo app('translator')->get('university::un.semester_label'); ?>
                                                <?php else: ?> 
                                                <?php echo app('translator')->get('student.father_name'); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="name">
                                                <?php if(moduleStatusCheck('University')): ?>
                                                <?php echo e(@$student->unSemesterLabel->name); ?> 
                                                <?php else: ?> 
                                                <?php echo e(@$student->studentDetail->parents != ""? @$student->studentDetail->parents->fathers_name:""); ?>

                                                <?php endif; ?>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="value text-left">
                                                <?php echo app('translator')->get('fees.mobile'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="name">
                                                <?php echo e(@$student->studentDetail->mobile); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="value text-left">
                                                <?php echo app('translator')->get('student.category'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="name">
                                                <?php echo e(@$student->studentDetail->category !=""?@$student->studentDetail->category->category_name:""); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="offset-lg-2 col-lg-5 col-md-6">
                                <div class="single-meta mt-20">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="value text-left">
                                                <?php if(moduleStatusCheck('University')): ?>
                                                <?php echo app('translator')->get('university::un.department'); ?>
                                                <?php else: ?>
                                               <?php echo app('translator')->get('common.class_sec'); ?>
                                               <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="name"> 
                                                <?php if(moduleStatusCheck('University')): ?>
                                                    <?php echo e(@$student->unDepartment->name); ?>

                                                <?php else: ?> 
                                                    <?php echo e(@$student->class->class_name .'('.@$student->section->section_name.')'); ?>

                                                <?php endif; ?> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="value text-left">
                                                <?php echo app('translator')->get('student.admission_no'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="name">
                                                <?php echo e(@$student->studentDetail->admission_no); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="value text-left">
                                               <?php echo app('translator')->get('student.roll_no'); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="name">
                                                <?php echo e(@$student->roll_no); ?>

                                  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="url" value="<?php echo e(URL::to('/')); ?>">
<input type="hidden" id="student_id" value="<?php echo e(@$student->id); ?>">
<section class="">
    <div class="container-fluid p-0">
        <div class="white-box">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="d-flex justify-content-between">
                    <div class="main-title">
                        <h3 class="mb-30"><?php echo app('translator')->get('fees.add_fees'); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                
                <div class="table-responsive">
                <?php if(moduleStatusCheck('University')): ?>

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
                    <table id="" class="table school-table-style-parent-fees" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <td class="text-right" colspan="14">
                                    <a class="primary-btn small fix-gr-bg modalLink" data-modal-size="modal-lg" title="<?php echo app('translator')->get('fees.add_fees'); ?>" href="<?php echo e(route('university.un-total-fees-modal', [$student->id])); ?>"0>
                                        <i class="ti-plus pr-2"></i> <?php echo app('translator')->get('fees.add_fees'); ?> 
                                </a>
                                
                                    <a href="" id="fees_groups_invoice_print_button" class="primary-btn small fix-gr-bg" target="">
                                        <i class="ti-printer pr-2"></i>
                                        <?php echo app('translator')->get('fees.invoice_print'); ?>
                                    </a>
                                </td>
                            </tr>
    
                            <tr>
                                
                                <th class="nowrap"># <?php echo app('translator')->get('university::un.installment'); ?> </th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.amount'); ?> (<?php echo e(@generalSetting()->currency_symbol); ?>)</th>
                                <th class="nowrap"><?php echo app('translator')->get('common.status'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.due_date'); ?> </th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.payment_ID'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.mode'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('university::un.payment_date'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.discount'); ?> (<?php echo e(@generalSetting()->currency_symbol); ?>)</th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.paid'); ?> (<?php echo e(@generalSetting()->currency_symbol); ?>)</th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.balance'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('common.action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
    
                           
                              <?php $__currentLoopData = $feesInstallments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $feesInstallment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
                                <?php 
                                $total_fees += discountFeesAmount($feesInstallment->id); 
                                $total_paid += $feesInstallment->paid_amount;
                                $total_disc += $feesInstallment->discount_amount;
                                $total_balance += discountFeesAmount($feesInstallment->id) - ( $feesInstallment->paid_amount );
                                ?> 
    
                              <tr>
                                    <td>
                                        <input type="checkbox" id="fees_group.<?php echo e($feesInstallment->id); ?>" class="common-checkbox fees-groups-print" name="fees_group[]" value="<?php echo e($feesInstallment->id); ?>">
                                        <label for="fees_group.<?php echo e($feesInstallment->id); ?>"></label>
                                        <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                        <?php echo e(@$feesInstallment->installment->title); ?>

                                    </td>
                                    
                                    <td> 
                                        <?php if($feesInstallment->discount_amount > 0): ?>
                                        <del>  <?php echo e($feesInstallment->amount); ?>  </del>
                                          <?php echo e($feesInstallment->amount - $feesInstallment->discount_amount); ?>

                                          <?php else: ?> 
                                           <?php echo e($feesInstallment->amount); ?>

                                        <?php endif; ?> 
                                      </td>
                                      <td>
                                          <?php if($feesInstallment->active_status == 1): ?>
                                          <button class="primary-btn small bg-success text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.paid'); ?></button>
                                          <?php elseif( $feesInstallment->active_status == 2): ?> 
                                          <button class="primary-btn small bg-warning text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.partial'); ?></button>
                                          <?php else: ?> 
                                          <button class="primary-btn small bg-danger text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.unpaid'); ?></button>
                                          <?php endif; ?> 
                                      </td>
                                    <td><?php echo e(@dateConvert($feesInstallment->due_date)); ?></td>
                                    <td>
                                      <?php if($feesInstallment->active_status == 1): ?>
                                        <?php if(moduleStatusCheck('University')): ?>
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.@$feesInstallment->user->full_name); ?>">
                                                <?php echo e(@universityFeesInvoice($feesInstallment->invoice_no)); ?>

                                            </a>
                                        <?php else: ?>
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.@$feesInstallment->user->full_name); ?>">
                                                <?php echo e(@$feesInstallment->fees_type_id.'/'.@$feesInstallment->id); ?>

                                            </a>
                                        <?php endif; ?>
                                      <?php endif; ?> 
                                    </td>
                  
                                    <td>
                                        <?php if(is_null($feesInstallment->payment_mode)): ?>
                                          -- 
                                        <?php else: ?>
                                        <?php echo e($feesInstallment->payment_mode); ?>

                                        <?php endif; ?> 
                                    </td>
                                    <td><?php echo e(@dateConvert($feesInstallment->payment_date)); ?></td>
                  
                                    
                                    <td> <?php echo e($feesInstallment->discount_amount); ?></td>
                                    <td>
                                        <?php echo e($feesInstallment->paid_amount); ?>

                  
                                      </td>
                                    <td><?php echo e(discountFeesAmount($feesInstallment->id) - ($feesInstallment->paid_amount)); ?> </td>
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                              <?php echo app('translator')->get('common.select'); ?>
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-right">
                                              <?php if($feesInstallment->active_status !=1): ?>
                                                  <?php if(userPermission('university.editSubPaymentModal')): ?>
                                                      <a data-toggle="modal" data-target="#editInstallment_<?php echo e($feesInstallment->id); ?>" class="dropdown-item">
                                                          <?php echo app('translator')->get('common.edit'); ?>
                                                      </a>
                                                  <?php endif; ?>
                                              <?php endif; ?> 
                                              
                                          </div>
                                        </div>
                                    </td>
                              </tr>
                              <?php $__currentLoopData = $feesInstallment->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                  
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td class="text-right"><img src="<?php echo e(asset('public/backEnd/img/table-arrow.png')); ?>"></td>
                                  <td>
                                      <?php if($payment->active_status == 1): ?>
                                       <?php if(moduleStatusCheck('University')): ?>
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.@$payment->user->full_name); ?>">
                                                <?php echo e(@universityFeesInvoice($feesInstallment->invoice_no)); ?>

                                            </a>
                                       <?php else: ?>
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.@$payment->user->full_name); ?>">
                                                <?php echo e(@$payment->fees_type_id.'/'.@$payment->id); ?>

                                            </a>
                                       <?php endif; ?>
                                      <?php endif; ?>
                                  </td>
                                  <td><?php echo e($payment->payment_mode); ?></td>
                                  <td><?php echo e(@dateConvert($payment->payment_date)); ?></td>
                                  <td><?php echo e($payment->discount_amount); ?></td>
                                  <td><?php echo e($payment->paid_amount); ?></td>
                                  <td><?php echo e($payment->balance_amount); ?> </td>
                                  <td>
                                      <div class="dropdown CRM_dropdown">
                                          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                              <?php echo app('translator')->get('common.select'); ?>
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-right">
                                              <?php if(userPermission('university.editSubPaymentModal')): ?>
                                                  <a class="dropdown-item modalLink" data-modal-size="modal-md" title="<?php echo e(@$feesInstallment->installment->title); ?> / <?php echo e(@$payment->fees_type_id.'/'.@$payment->id); ?>" href="<?php echo e(route('university.editSubPaymentModal',[$payment->id,$payment->paid_amount])); ?>">
                                                      <?php echo app('translator')->get('common.edit'); ?>
                                                  </a>
                                              <?php endif; ?>
                                              <?php if(userPermission('directFees.deleteSubPayment')): ?>
                                                  <a onclick="deletePayment(<?php echo e($payment->id); ?>);"  class="dropdown-item" href="#" data-toggle="modal">
                                                      <?php echo app('translator')->get('common.delete'); ?>
                                                  </a>
                                              <?php endif; ?>
    
                                              <a class="dropdown-item" target="_blank"  href="<?php echo e(route('university.viewPaymentReceipt',[$payment->id])); ?>"> 
                                                <?php echo app('translator')->get('fees.receipt'); ?>                                      
                                            </a>
    
                                          </div>
                                        </div>
                                       </td>
                               </tr>  
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                            
                            <?php if(moduleStatusCheck('University')): ?>
                              <div class="modal fade admin-query" id="editInstallment_<?php echo e($feesInstallment->id); ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">
                                                <?php echo app('translator')->get('university::un.fees_installment'); ?>
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                    
                                        <div class="modal-body"> 
                                            <?php echo e(Form::open(['class' => 'form-horizontal','files' => true,'route' => 'university.feesInstallmentUpdate','method' => 'POST'])); ?>

                                            <div class="row">
                                                <input type="hidden" name="installment_id" value="<?php echo e($feesInstallment->id); ?>">
                                                <div class="col-lg-6">
                                                    <div class="primary_input ">
                                                        <input class="primary_input_field form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>" type="text" name="amount" id="amount" value="<?php echo e($feesInstallment->amount); ?>" readonly>
                                                        <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.amount'); ?> <span class="text-danger"> *</span> </label>
                                                        
                                                        <?php if($errors->has('amount')): ?>
                                                        <span class="text-danger" ><?php echo e(@$errors->first('amount')); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="primary_input ">
                                                                <input class="primary_input_field  primary_input_field date form-control form-control<?php echo e($errors->has('due_date') ? ' is-invalid' : ''); ?>" id="startDate" type="text"
                                                                     name="due_date" value="<?php echo e(date('m/d/Y', strtotime($feesInstallment->due_date))); ?>" autocomplete="off">
                                                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.due_date'); ?> <span class="text-danger"> *</span></label>
                                                                    
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
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-5 text-center">
                                                <button type="submit" class="primary-btn fix-gr-bg">
                                                    <span class="ti-check"></span>
                                                    <?php echo app('translator')->get('common.update'); ?>
                                                </button>
                                            </div>
                    
                                            <?php echo e(Form::close()); ?>

                                           
                                        </div>
                    
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?> 
    
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                            <?php if($record->credit &&  $record->credit->amount > 0): ?>
                            <?php echo $__env->make('university::include.fees_credit_view', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?> 
                  
                        </tbody>
                  
                        <tfoot>
                          <tr>
                              
                              <th><?php echo app('translator')->get('fees.grand_total'); ?> (<?php echo e(@$currency); ?>)</th>
                              <th><?php echo e(currency_format($total_fees)); ?></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th><?php echo e(currency_format($total_disc)); ?></th>
                              <th><?php echo e(currency_format($total_paid)); ?> </th>
                              <th>
                                <?php if(@$record->credit->amount): ?>
                                <?php echo e(currency_format($total_balance + @$record->credit->amount )); ?>

                                <?php else: ?>
                                <?php echo e(currency_format($total_balance)); ?>

                                <?php endif; ?> 
                            </th>
                              <th></th>
                          </tr>
                      </tfoot>
                  
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

                <?php elseif(directFees()): ?>
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
                    <table id="" class="table school-table-style-parent-fees" cellspacing="0" width="100%">
                                           
                        <thead>
                            <tr>
                                <td class="text-right" colspan="14">
                                    <style>
                                        a.modalLink {
                                            font-size: 12px !important;
                                        }
                                    </style>
                                    <a class="primary-btn small fix-gr-bg modalLink" data-modal-size="modal-lg" title="<?php echo app('translator')->get('fees.add_fees'); ?>" href="<?php echo e(route('direct-fees-total-payment', [$student->id])); ?>"0>
                                            <i class="ti-plus pr-2"></i> <?php echo app('translator')->get('fees.add_fees'); ?> 
                                    </a>
    
                                    <a href="" id="fees_groups_invoice_print_button" class="primary-btn small fix-gr-bg" target="">
                                        <i class="ti-printer pr-2"></i>
                                        <?php echo app('translator')->get('fees.invoice_print'); ?>
                                    </a>
                                   
                                </td>
                            </tr>
                            <tr>
                                <th class="nowrap">#</th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.installment'); ?> </th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.amount'); ?> (<?php echo e(@generalSetting()->currency_symbol); ?>)</th>
                                <th class="nowrap"><?php echo app('translator')->get('common.status'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.due_date'); ?> </th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.payment_ID'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.mode'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.payment_date'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.discount'); ?> (<?php echo e(@generalSetting()->currency_symbol); ?>)</th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.paid'); ?> (<?php echo e(@generalSetting()->currency_symbol); ?>)</th>
                                <th class="nowrap"><?php echo app('translator')->get('fees.balance'); ?></th>
                                <th class="nowrap"><?php echo app('translator')->get('common.action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                              <?php $__currentLoopData = $feesInstallments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $feesInstallment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php 
                              $total_fees += discount_fees($feesInstallment->amount, $feesInstallment->discount_amount); 
                              $total_paid += $feesInstallment->paid_amount;
                              $total_disc += $feesInstallment->discount_amount;
                              ?> 
                              <tr>
                                <td>
                                    <input type="checkbox" id="fees_group.<?php echo e($feesInstallment->id); ?>" class="common-checkbox fees-groups-print" name="fees_group[]" value="<?php echo e($feesInstallment->id); ?>">
                                    <label for="fees_group.<?php echo e($feesInstallment->id); ?>"></label>
                                    <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                </td>
                                    <td><?php echo e(@$feesInstallment->installment->title); ?></td>
                                    <td> 
                                        <?php if($feesInstallment->discount_amount > 0): ?>
                                          <del>  <?php echo e($feesInstallment->amount); ?>  </del>
                                          <?php echo e($feesInstallment->amount - $feesInstallment->discount_amount); ?>

                                        <?php else: ?> 
                                         <?php echo e($feesInstallment->amount); ?>

                                        <?php endif; ?> 
                                      </td>
                                      <td>
                                          <?php if($feesInstallment->active_status == 1): ?>
                                          <button class="primary-btn small bg-success text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.paid'); ?></button>
                                          <?php elseif( $feesInstallment->active_status == 2): ?> 
                                          <button class="primary-btn small bg-warning text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.partial'); ?></button>
                                          <?php else: ?> 
                                          <button class="primary-btn small bg-danger text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.unpaid'); ?></button>
                                          <?php endif; ?> 
                                      </td>
                                    <td><?php echo e(@dateConvert($feesInstallment->due_date)); ?></td>
                                    <td>
                                      
                                    </td>
                                    
                                    <td>
                                        
                                    </td>
                                   
                                  <td>
                                      
                                  </td>
                                  <td> <?php echo e($feesInstallment->discount_amount); ?></td>
                                  <td>
                                      <?php echo e($feesInstallment->paid_amount); ?>

                                  </td>
                                     
                                  <td>
                                      <?php echo e(discount_fees($feesInstallment->amount, $feesInstallment->discount_amount) - ($feesInstallment->payments->sum('total_paid') + $feesInstallment->paid_amount)); ?> </td>
                                     
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                              <?php echo app('translator')->get('common.select'); ?>
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-right">
                                              <?php if($feesInstallment->active_status !=1): ?>
                                              <a data-toggle="modal"
                                              data-target="#editInstallment_<?php echo e($feesInstallment->id); ?>" class="dropdown-item"><?php echo app('translator')->get('common.edit'); ?></a>
                                              <?php endif; ?> 
                  
                                              <?php if( $feesInstallment->active_status != 1): ?>
                                              <a class="dropdown-item modalLink" data-modal-size="modal-lg" title="<?php echo e(@$feesInstallment->installment->title); ?>"
                                                  href="<?php echo e(route('direct-fees-generate-modal',[$feesInstallment->amount,$feesInstallment->id,$feesInstallment->record_id])); ?>"> 
                                                  <?php echo app('translator')->get('fees.add_fees'); ?>                                      
                                              </a>
                                              <?php endif; ?>               
                                          </div>
                                      </div>
                                  </td>
                                   
                              </tr>
                  
                  
                  
                              <?php $__currentLoopData = $feesInstallment->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td class="text-right"><img src="<?php echo e(asset('public/backEnd/img/table-arrow.png')); ?>"></td>
                                  <td>
                                    <?php if($payment->active_status == 1): ?>
                                        <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.@$payment->user->full_name); ?>">
                                            <?php echo e(@sm_fees_invoice($payment->invoice_no, $invoice_settings)); ?>

                                        </a>
                                    <?php endif; ?> 
                                  </td>
                                  <td><?php echo e($payment->payment_mode); ?></td>
                                  <td><?php echo e(@dateConvert($payment->payment_date)); ?></td>
                                  <td><?php echo e($payment->discount_amount); ?></td>
                                  <td><?php echo e($payment->paid_amount); ?></td>
                                  <td><?php echo e($payment->balance_amount); ?> </td>
                                  <td>
                                      <div class="dropdown CRM_dropdown">
                                          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                              <?php echo app('translator')->get('common.select'); ?>
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-right">
    
                                              <a class="dropdown-item modalLink" data-modal-size="modal-md" 
                                              title="<?php echo app('translator')->get('fees.installment'); ?>: <?php echo e(@$feesInstallment->installment->title); ?>, <?php echo app('translator')->get('fees.payment_ID'); ?>: <?php echo e(@$payment->fees_type_id.'/'.@$payment->id); ?>"
                                              href="<?php echo e(route('directFees.editSubPaymentModal',[$payment->id,$payment->paid_amount])); ?>" ><?php echo app('translator')->get('common.edit'); ?> </a>
    
                                              <a onclick="deletePayment(<?php echo e($payment->id); ?>);"  class="dropdown-item" href="#" data-toggle="modal"><?php echo app('translator')->get('common.delete'); ?></a>
    
                                              <a class="dropdown-item" target="_blank"  href="<?php echo e(route('directFees.viewPaymentReceipt',[$payment->id])); ?>"> 
                                                <?php echo app('translator')->get('fees.receipt'); ?>                                      
                                            </a>
                                          </div>
                                        </div>
                                       </td>
                               </tr>  
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                  
                  
                              <div class="modal fade admin-query" id="editInstallment_<?php echo e($feesInstallment->id); ?>">
                                  <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h4 class="modal-title">
                                                  <?php echo app('translator')->get('fees.fees_installment'); ?>
                                              </h4>
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                  
                                          <div class="modal-body"> 
                                              <?php echo e(Form::open(['class' => 'form-horizontal','files' => true,'route' => 'feesInstallmentUpdate','method' => 'POST'])); ?>

                                              <div class="row">
                                                  <input type="hidden" name="installment_id" value="<?php echo e($feesInstallment->id); ?>">
                                                  <div class="col-lg-6">
                                                      <div class="primary_input ">
                                                        <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.amount'); ?> <span class="text-danger"> *</span> </label>
                                                          <input class="primary_input_field form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>" type="text" name="amount" id="amount" value="<?php echo e($feesInstallment->amount); ?>" readonly>
                                                          
                                                          
                                                          <?php if($errors->has('amount')): ?>
                                                          <span class="text-danger" >
                                                              <strong><?php echo e(@$errors->first('amount')); ?>

                                                          </span>
                                                          <?php endif; ?>
                                                      </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                    <div class="primary_datepicker_input">
                                                      <div class="no-gutters input-right-icon">
                                                          <div class="col">
                                                              <div class="primary_input ">
                                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.due_date'); ?> <span class="text-danger"> *</span></label>
                                                                  <input class="primary_input_field  primary_input_field date form-control form-control<?php echo e($errors->has('due_date') ? ' is-invalid' : ''); ?>" id="startDate" type="text"
                                                                       name="due_date" value="<?php echo e(date('m/d/Y', strtotime(@$feesInstallment->due_date))); ?>" autocomplete="off">
                                                                       <button class="btn-date" style="top: 70% !important;" data-id="#date_of_birth" type="button">
                                                                        <label class="m-0 p-0" for="date_of_birth">
                                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                                        </label>
                                                                    </button>
                                                                      
                                                                      
                                                                  <?php if($errors->has('due_date')): ?>
                                                                  <span class="text-danger" >
                                                                      <?php echo e($errors->first('due_date')); ?>

                                                                  </span>
                                                                  <?php endif; ?>
                                                              </div>
                                                          </div>
                                                          
                                                      </div>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="col-lg-12 mt-5 text-center">
                                                  <button type="submit" class="primary-btn fix-gr-bg">
                                                      <span class="ti-check"></span>
                                                      <?php echo app('translator')->get('common.update'); ?>
                                                  </button>
                                              </div>
                      
                                              <?php echo e(Form::close()); ?>

                                             
                                          </div>
                      
                                      </div>
                                  </div>
                              </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <tfoot>
                                  <tr>
                                      <th></th>
                                      <th><?php echo app('translator')->get('fees.grand_total'); ?> (<?php echo e(@$currency); ?>)</th>
                                      <th><?php echo e(currency_format($total_fees)); ?></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th><?php echo e(currency_format($total_disc)); ?></th>
                                      <th><?php echo e(currency_format($total_paid)); ?> </th>
                                      <th><?php echo e(currency_format($total_fees -  ($total_paid))); ?></th>
                                      <th></th>
                                  </tr>
                              </tfoot>
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
                <?php if(moduleStatusCheck('University')): ?>
                <div class="modal fade admin-query" id="deletePaymentModal" >
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?php echo app('translator')->get('fees.delete_fees_payment'); ?>  </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                
                                    <div class="modal-body"> 
                                        <?php echo e(Form::open(['class' => 'form-horizontal','files' => true,'route' => 'university.feesInstallmentUpdate','method' => 'POST'])); ?>

                                        <div class="row">
                                            <input type="hidden" name="installment_id" value="<?php echo e($feesInstallment->id); ?>">
                                            <div class="col-lg-6">
                                                <div class="primary_input ">
                                                    <input class="primary_input_field form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>" type="text" name="amount" id="amount" value="<?php echo e($feesInstallment->amount); ?>" readonly>
                                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.amount'); ?> <span class="text-danger"> *</span> </label>
                                                    
                                                    <?php if($errors->has('amount')): ?>
                                                    <span class="text-danger" ><?php echo e(@$errors->first('amount')); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="primary_input ">
                                                            <input class="primary_input_field  primary_input_field date form-control form-control<?php echo e($errors->has('due_date') ? ' is-invalid' : ''); ?>" id="startDate" type="text"
                                                                 name="due_date" value="<?php echo e(date('m/d/Y', strtotime($feesInstallment->due_date))); ?>" autocomplete="off">
                                                                <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.due_date'); ?> <span class="text-danger"> *</span></label>
                                                                
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
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-5 text-center">
                                            <button type="submit" class="primary-btn fix-gr-bg">
                                                <span class="ti-check"></span>
                                                <?php echo app('translator')->get('common.update'); ?>
                                            </button>
                                        </div>
                
                                        <?php echo e(Form::close()); ?>

                                       
                            <div class="modal-body">
                                    <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'directFees.deleteSubPayment',
                                        'method' => 'POST'])); ?>

                               
                                    <input type="hidden" name="sub_payment_id">   
                                    <div class="text-center">
                                        <h4><?php echo app('translator')->get('common.are_you_sure_to_delete'); ?></h4>
                                    </div>
                                                   
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo e(__('common.cancel')); ?></button>
                                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.delete'); ?> </button>
                                    
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                
                        </div>
                    </div>
                </div>
                <?php endif; ?> 
                
                
                  <script>
                    function deletePayment(id) {
                        var modal = $('#deletePaymentModal');
                        modal.find('input[name=sub_payment_id]').val(id)
                        modal.modal('show');
                    }
                </script>

                <?php else: ?> 
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
                        <table class="table school-table-style" cellspacing="0" width="100%">
                            <thead>
                               
                                <tr>
                                    <td class="text-right" colspan="14">
                                        <a href="" id="fees_groups_invoice_print_button" class="primary-btn small fix-gr-bg" target="">
                                            <i class="ti-printer pr-2"></i>
                                            <?php echo app('translator')->get('fees.invoice_print'); ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo app('translator')->get('fees.fees'); ?></th>
                                    <th><?php echo app('translator')->get('fees.due_date'); ?></th>
                                    <th><?php echo app('translator')->get('common.status'); ?></th>
                                    <th><?php echo app('translator')->get('fees.amount'); ?> (<?php echo e(generalSetting()->currency_symbol); ?>)</th>
                                    <th><?php echo app('translator')->get('fees.payment_id'); ?></th>
                                    <th><?php echo app('translator')->get('fees.mode'); ?></th>
                                    <th><?php echo app('translator')->get('common.date'); ?></th>
                                    <th><?php echo app('translator')->get('fees.discount'); ?> (<?php echo e(generalSetting()->currency_symbol); ?>)</th>
                                    <th><?php echo app('translator')->get('fees.fine'); ?> (<?php echo e(generalSetting()->currency_symbol); ?>)</th>
                                    <th><?php echo app('translator')->get('fees.paid'); ?> (<?php echo e(generalSetting()->currency_symbol); ?>)</th>
                                    <th><?php echo app('translator')->get('fees.balance'); ?></th>
                                    <th><?php echo app('translator')->get('common.action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $grand_total = 0;
                                    $total_fine = 0;
                                    $total_discount = 0;
                                    $total_paid = 0;
                                    $total_grand_paid = 0;
                                    $total_balance = 0;
                                ?>
                                <?php $__currentLoopData = $fees_assigneds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_assigned): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $grand_total += $fees_assigned->feesGroupMaster->amount;
                                    $discount_amount = $fees_assigned->applied_discount;
                                    $total_discount += $discount_amount;
                                    $student_id = $fees_assigned->student_id;
                                    $paid = App\SmFeesAssign::discountSum($fees_assigned->student_id, $fees_assigned->feesGroupMaster->feesTypes->id, 'amount' ,$fees_assigned->record_id);
                                    $total_grand_paid += $paid;
                                    $fine = App\SmFeesAssign::discountSum($fees_assigned->student_id, $fees_assigned->feesGroupMaster->feesTypes->id, 'fine', $fees_assigned->record_id);
                                    $total_fine += $fine;
                                    $total_paid = $discount_amount + $paid;
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="fees_group.<?php echo e($fees_assigned->id); ?>" class="common-checkbox fees-groups-print" name="fees_group[]" value="<?php echo e($fees_assigned->id); ?>">
                                        <label for="fees_group.<?php echo e($fees_assigned->id); ?>"></label>
                                        <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                    </td>
                                    <td>
                                        <?php echo e(@$fees_assigned->feesGroupMaster->feesGroups->name); ?> / <?php echo e(@$fees_assigned->feesGroupMaster->feesTypes->name); ?>

                                    </td>
                                    <td>
                                        <?php if($fees_assigned->feesGroupMaster !=""): ?>
                                            <?php echo e($fees_assigned->feesGroupMaster->date != ""? dateConvert($fees_assigned->feesGroupMaster->date):''); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $rest_amount = $fees_assigned->feesGroupMaster->amount - $total_paid;
                                            $total_balance +=  $rest_amount;
                                            $balance_amount = number_format($rest_amount+$fine, 2, '.', '');
                                        ?>
                                        <?php if($balance_amount == 0): ?>
                                            <button class="primary-btn small bg-success text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.paid'); ?></button>
                                        <?php elseif($paid != 0): ?>
                                            <button class="primary-btn small bg-warning text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.partial'); ?></button>
                                        <?php elseif($paid == 0): ?>
                                            <button class="primary-btn small bg-danger text-white border-0 text-nowrap"><?php echo app('translator')->get('fees.unpaid'); ?></button>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($fees_assigned->feesGroupMaster->amount); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo e($discount_amount); ?></td>
                                    <td><?php echo e($fine); ?></td>
                                    <td><?php echo e($paid); ?></td>
                                    <td> 
                                        <?php
                                            $rest_amount = $fees_assigned->fees_amount;
                                            $total_balance +=  $rest_amount;
                                            echo $balance_amount;
                                        ?>
                                    </td>
                                    <td>
                                        <div class="dropdown CRM_dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                <?php echo app('translator')->get('common.select'); ?>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <?php if(userPermission('fees-generate-modal')): ?>
                                                    <?php if($balance_amount != 0): ?> 
                                                        <?php $balance_amount = $balance_amount*100;?>
                                                        <a class="dropdown-item modalLink" data-modal-size="modal-lg" 
                                                        title="<?php echo e(@$fees_assigned->feesGroupMaster->feesGroups->name.': '. $fees_assigned->feesGroupMaster->feesTypes->name); ?>"  
                                                        href="<?php echo e(route('fees-generate-modal', [$balance_amount, $fees_assigned->student_id, $fees_assigned->feesGroupMaster->fees_type_id,$fees_assigned->fees_master_id,$fees_assigned->id,$fees_assigned->record_id])); ?>" ><?php echo app('translator')->get('fees.add_fees'); ?> </a>
                                                    <?php else: ?>
                                                        <a class="dropdown-item"  target="_blank">Payment Done</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                    <?php
                                        $payments = App\SmFeesAssign::feesPayment($fees_assigned->feesGroupMaster->feesTypes->id, $fees_assigned->student_id, $fees_assigned->record_id);
                                        $i = 0;
                                    ?>
                                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <img src="<?php echo e(asset('public/backEnd/img/table-arrow.png')); ?>">
                                        </td>
                                        <td>
                                            <?php
                                                $created_by = App\User::find($payment->created_by);
                                            ?>
                                            <?php if($created_by != ""): ?>
                                                <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e('Collected By: '.$created_by->full_name); ?>"><?php echo e($payment->fees_type_id.'/'.$payment->id); ?></a>
                                        </td>
                                            <?php endif; ?>
                                        <td><?php echo e($payment->payment_mode); ?></td>
                                        <td class="nowrap"><?php echo e($payment->payment_date != ""? dateConvert($payment->payment_date):''); ?></td>
                                        <td class="text-center"><?php echo e($payment->discount_amount); ?></td>
                                        <td>
                                            <?php echo e($payment->fine); ?>

                                            <?php if($payment->fine!=0): ?>
                                                <?php if(strlen($payment->fine_title) > 14): ?>
                                                    <spna class="text-danger nowrap" title="<?php echo e($payment->fine_title); ?>">
                                                        (<?php echo e(substr($payment->fine_title, 0, 15) . '...'); ?>)
                                                    </spna>
                                                <?php else: ?>
                                                    <?php if($payment->fine_title==''): ?>
                                                        <?php echo e($payment->fine_title); ?>

                                                    <?php else: ?>
                                                        <spna class="text-danger nowrap">
                                                            (<?php echo e($payment->fine_title); ?>)
                                                        </spna>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($payment->amount); ?>

                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo app('translator')->get('fees.grand_total'); ?> (<?php echo e(generalSetting()->currency_symbol); ?>)</th>
                                    <th></th>
                                    <th><?php echo e(currency_format($grand_total)); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo e(currency_format($total_discount)); ?></th>
                                    <th><?php echo e(currency_format($total_fine)); ?></th>
                                    <th><?php echo e(currency_format($total_grand_paid)); ?></th>
                                        <?php
                                            $show_balance=$grand_total+$total_fine-$total_discount;
                                        ?>
                                    <th><?php echo e(currency_format($show_balance - $total_grand_paid)); ?></th>
                                    <th></th>
                                </tr>
                            </tfoot>
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
                <?php endif; ?> 
            </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</section>

<?php if(moduleStatusCheck('University')): ?>
<div class="modal fade admin-query" id="deletePaymentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('fees.delete_fees_payment'); ?>  </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                    <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'university.deleteSubPayment',
                        'method' => 'POST'])); ?>

               
                    <input type="hidden" name="sub_payment_id">   
                    <div class="text-center">
                        <h4><?php echo app('translator')->get('common.are_you_sure_to_delete'); ?></h4>
                    </div>
                                   
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo e(__('common.cancel')); ?></button>
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.delete'); ?> </button>
                    
                </div>
                <?php echo e(Form::close()); ?>

            </div>

        </div>
    </div>
</div>
<?php endif; ?> 

<?php if(directFees()): ?>
<div class="modal fade admin-query" id="deletePaymentModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('fees.delete_fees_payment'); ?>  </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                    <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'directFees.deleteSubPayment',
                        'method' => 'POST'])); ?>

               
                    <input type="hidden" name="sub_payment_id">   
                    <div class="text-center">
                        <h4><?php echo app('translator')->get('common.are_you_sure_to_delete'); ?></h4>
                    </div>
                                   
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo e(__('common.cancel')); ?></button>
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.delete'); ?> </button>
                    
                </div>
                <?php echo e(Form::close()); ?>

            </div>

        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backEnd.partials.date_picker_css_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startPush('script'); ?>
<script>
    function deletePayment(id) {
        var modal = $('#deletePaymentModal');
        modal.find('input[name=sub_payment_id]').val(id)
        modal.modal('show');
    }
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\resources\views/backEnd/feesCollection/collect_fees_student_wise.blade.php ENDPATH**/ ?>