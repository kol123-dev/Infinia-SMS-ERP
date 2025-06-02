<?php
    $total_fees = 0;
    $total_due = 0;
    $total_paid = 0;
    $total_disc = 0;
    $balance_fees = 0;
?>
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

            <?php $__currentLoopData = $record->directFeesInstallments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feesInstallment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $total_fees += discount_fees($feesInstallment->amount, $feesInstallment->discount_amount);
                    $total_paid += $feesInstallment->paid_amount;
                    $total_disc += $feesInstallment->discount_amount;
                    $balance_fees += discount_fees($feesInstallment->amount, $feesInstallment->discount_amount) - $feesInstallment->paid_amount;
                ?>
                <tr>

                    <td><?php echo e(@$feesInstallment->installment->title); ?></td>
                    <td>
                        <?php if($feesInstallment->discount_amount > 0): ?>
                            <del> <?php echo e($feesInstallment->amount); ?> </del>
                            <?php echo e($feesInstallment->amount - $feesInstallment->discount_amount); ?>

                        <?php else: ?>
                            <?php echo e($feesInstallment->amount); ?>

                        <?php endif; ?>
                    </td>
                    <td>

                        <button
                            class="primary-btn small <?php echo e(fees_payment_status($feesInstallment->amount, $feesInstallment->discount_amount, $feesInstallment->paid_amount, $feesInstallment->active_status)[1]); ?> text-white border-0"><?php echo e(fees_payment_status($feesInstallment->amount, $feesInstallment->discount_amount, $feesInstallment->paid_amount, $feesInstallment->active_status)[0]); ?></button>

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
                        <?php echo e(discount_fees($feesInstallment->amount, $feesInstallment->discount_amount) - $feesInstallment->paid_amount); ?>

                    </td>

                    <td>
                        <div class="dropdown CRM_dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                <?php echo app('translator')->get('common.select'); ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if($feesInstallment->active_status != 1): ?>
                                    <a data-toggle="modal"
                                        data-target="#editInstallment_<?php echo e($feesInstallment->id); ?>"
                                        class="dropdown-item"><?php echo app('translator')->get('common.edit'); ?></a>
                                <?php endif; ?>

                                <?php if(discount_fees($feesInstallment->amount, $feesInstallment->discount_amount) - $feesInstallment->paid_amount != 0): ?>
                                    <a class="dropdown-item modalLink" data-modal-size="modal-lg"
                                        title="<?php echo e(@$feesInstallment->installment->title); ?>"
                                        href="<?php echo e(route('direct-fees-generate-modal', [$feesInstallment->amount, $feesInstallment->id, $feesInstallment->record_id])); ?>">
                                        <?php echo app('translator')->get('fees.add_fees'); ?>
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </td>

                </tr>


                <?php $this_installment = discount_fees($feesInstallment->amount, $feesInstallment->discount_amount); ?>
                <?php $__currentLoopData = $feesInstallment->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $this_installment = $this_installment - $payment->paid_amount; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><img src="<?php echo e(asset('public/backEnd/img/table-arrow.png')); ?>"></td>
                        <td>
                            <?php if($payment->active_status == 1): ?>
                                <a href="#" data-toggle="tooltip" data-placement="right"
                                    title="<?php echo e('Collected By: ' . @$payment->user->full_name); ?>">
                                    <?php echo e(@smFeesInvoice($payment->invoice_no)); ?>

                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($payment->payment_mode); ?></td>
                        <td><?php echo e(@dateConvert($payment->payment_date)); ?></td>
                        <td><?php echo e($payment->discount_amount); ?></td>
                        <td><?php echo e($payment->paid_amount); ?></td>
                        <td><?php echo e($this_installment); ?> </td>
                        <td>
                            <div class="dropdown CRM_dropdown">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                    <?php echo app('translator')->get('common.select'); ?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item modalLink" data-modal-size="modal-md"
                                        title="<?php echo e(@$feesInstallment->installment->title); ?> / <?php echo e(@$payment->fees_type_id . '/' . @$payment->id); ?>"
                                        href="<?php echo e(route('directFees.editSubPaymentModal', [$payment->id, $payment->paid_amount])); ?>"><?php echo app('translator')->get('common.edit'); ?>
                                    </a>
                                    <a onclick="deletePayment(<?php echo e($payment->id); ?>);" class="dropdown-item"
                                        href="#" data-toggle="modal"><?php echo app('translator')->get('common.delete'); ?></a>

                                    <a class="dropdown-item" target="_blank"
                                        href="<?php echo e(route('directFees.viewPaymentReceipt', [$payment->id])); ?>">
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
                                <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'feesInstallmentUpdate', 'method' => 'POST'])); ?>

                                <div class="row">
                                    <input type="hidden" name="installment_id" value="<?php echo e($feesInstallment->id); ?>">
                                    <div class="col-lg-6">
                                        <div class="primary_input ">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.amount'); ?> <span
                                                    class="text-danger"> *</span> </label>
                                            <input
                                                class="primary_input_field form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>"
                                                type="text" name="amount" id="amount"
                                                value="<?php echo e($feesInstallment->amount); ?>" readonly>
                                            <?php if($errors->has('amount')): ?>
                                                <span class="text-danger">
                                                    <strong><?php echo e(@$errors->first('amount')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="primary_input ">
                                                    <input
                                                        class="primary_input_field  primary_input_field date form-control form-control<?php echo e($errors->has('due_date') ? ' is-invalid' : ''); ?>"
                                                        id="startDate" type="text"
                                                        name="due_date"
                                                        value="<?php echo e(date('m/d/Y', strtotime($feesInstallment->installment->due_date))); ?>"
                                                        autocomplete="off">
                                                    <label class="primary_input_label" for=""><?php echo app('translator')->get('fees.due_date'); ?>
                                                        <span class="text-danger"> *</span></label>
                                                    <input
                                                        class="primary_input_field  primary-input date form-control form-control<?php echo e($errors->has('due_date') ? ' is-invalid' : ''); ?>"
                                                        id="startDate" type="text"
                                                        name="due_date"
                                                        value="<?php echo e(date('m/d/Y', strtotime($feesInstallment->installment->due_date))); ?>"
                                                        autocomplete="off">

                                                    <?php if($errors->has('due_date')): ?>
                                                        <span class="text-danger">
                                                            <?php echo e($errors->first('due_date')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <button class="btn-date" data-id="#startDate" type="button">
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <th><?php echo e($total_fees - $total_paid); ?></th>
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

<div class="modal fade admin-query" id="deletePaymentModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo app('translator')->get('fees.delete_fees_payment'); ?> </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <?php echo e(Form::open([
                    'class' => 'form-horizontal',
                    'files' => true,
                    'route' => 'directFees.deleteSubPayment',
                    'method' => 'POST',
                ])); ?>


                <input type="hidden" name="sub_payment_id">
                <div class="text-center">
                    <h4><?php echo app('translator')->get('common.are_you_sure_to_delete'); ?></h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn fix-gr-bg"
                        data-dismiss="modal"><?php echo e(__('common.cancel')); ?></button>
                    <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.delete'); ?> </button>

                </div>
                <?php echo e(Form::close()); ?>

            </div>

        </div>
    </div>
</div>
<?php echo $__env->make('backEnd.partials.date_picker_css_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    function deletePayment(id) {
        var modal = $('#deletePaymentModal');
        modal.find('input[name=sub_payment_id]').val(id)
        modal.modal('show');
    }
</script>
<?php /**PATH D:\xampp\htdocs\resources\views/backEnd/feesCollection/directFees/studentDirectFeesTableView.blade.php ENDPATH**/ ?>