<?php 
$subjects = $record->assign_subject;
$all_subject_ids = $subjects->pluck('subject_id')->toArray();
$is_result_available = App\SmResultStore::where([
                    ['class_id', $record->class], 
                    ['section_id', $record->section], 
                    ['student_id', $record->student]])
                    ->where('school_id',Auth::user()->school_id)
                    ->get();
$studentDetails = $record;
$record_id =  $record->id;
?>

<?php if(isset($is_result_available)): ?>
    <?php if(moduleStatusCheck('University')): ?>
        
    <?php else: ?>
        <section class="student-details">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-lg-12 no-gutters">
                        <div class="main-title d-flex ">
                            <h3 class="mb-30 flex-fill">
                              <?php if(moduleStatusCheck('University')): ?>
                                    <?php echo e($record->semesterLabel->name); ?> (<?php echo e($record->unSection->section_name); ?>) - <?php echo e(@$record->unAcademic->name); ?>

                              <?php else: ?> 
                                    <?php echo e($record->class->class_name); ?> (<?php echo e($record->section->section_name); ?>) 
                              <?php endif; ?>
                              <?php echo app('translator')->get('exam.final_mark_sheet'); ?>
                            </h3>

                        </div>
                    </div>

                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="single-report-admit">
                                        <div class="card">
                                            <div class="card-header">
                                                    <div class="d-flex">
                                                            <div class="col-lg-2">
                                                            <img class="logo-img" src="<?php echo e(asset(generalSetting()->logo)); ?>" alt="<?php echo e(generalSetting()->school_name); ?>">
                                                            </div>
                                                            <div class="col-lg-6 ml-30">
                                                                <h3 class="text-white"> 
                                                                    <?php echo e(isset(generalSetting()->school_name)?generalSetting()->school_name:'infix School Management ERP'); ?> 
                                                                </h3> 
                                                                <p class="text-white mb-0">
                                                                    <?php echo e(isset(generalSetting()->address)?generalSetting()->address:'infix School Address'); ?> 
                                                                </p>
                                                                <p class="text-white mb-0">
                                                                    <?php echo app('translator')->get('common.email'); ?>:  <?php echo e(isset(generalSetting()->email)?generalSetting()->email:'hello@aorasoft.com'); ?>,   <?php echo app('translator')->get('common.phone'); ?>:  <?php echo e(isset(generalSetting()->phone)?generalSetting()->phone:'+96897002784'); ?> 
                                                                </p> 
                                                            </div>
                                                            <div class="offset-2">
                                                            </div>
                                                        </div>
                                                <div class="report-admit-img profile_100" style="background-image: url(<?php echo e(file_exists(@$studentDetails->studentDetail->student_photo) ? asset($studentDetails->studentDetail->student_photo) : asset('public/uploads/staff/demo/staff.jpg')); ?>)"></div>

                                            </div>
                                        <div class="card-body">
                                            <div class="student_marks_table">
                                                <div class="row">
                                                    <div class="col-lg-7 text-black"> 
                                                        <h3 style="border-bottm:1px solid #ddd; padding: 15px; text-align:center"> 
                                                            <?php echo app('translator')->get('exam.student_final_mark_sheet'); ?>
                                                        </h3>
                                                        <h3>
                                                            <?php echo e($studentDetails->studentDetail->full_name); ?>

                                                        </h3>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <p class="mb-0">
                                                                    <?php echo app('translator')->get('common.academic_year'); ?> : &nbsp;<span class="primary-color fw-500"><?php echo e(@$studentDetails->academic->year); ?></span>
                                                                </p>
                                                                <p class="mb-0">
                                                                    <?php echo app('translator')->get('common.section'); ?> : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="primary-color fw-500"><?php echo e($studentDetails->section->section_name); ?></span>
                                                                </p>
                                                                <p class="mb-0">
                                                                    <?php echo app('translator')->get('common.class'); ?> : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="primary-color fw-500"><?php echo e($studentDetails->class->class_name); ?></span>
                                                                </p>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p class="mb-0">
                                                                    <?php echo app('translator')->get('student.admission_no'); ?> : <span class="primary-color fw-500"><?php echo e($studentDetails->studentDetail->admission_no); ?></span>
                                                                </p>
                                                                <p class="mb-0">
                                                                    <?php echo app('translator')->get('student.roll'); ?> : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="primary-color fw-500"><?php echo e($studentDetails->roll_no); ?></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 text-black">
                                                        <?php if(@$grades): ?>
                                                            <table class="table" id="grade_table">
                                                                <thead>
                                                                <tr>
                                                                    <th><?php echo app('translator')->get('reports.staring'); ?></th>
                                                                    <th> <?php echo app('translator')->get('reports.ending'); ?></th>
                                                                    <?php if(@generalSetting()->result_type != 'mark'): ?>
                                                                        <th><?php echo app('translator')->get('exam.gpa'); ?></th>
                                                                        <th><?php echo app('translator')->get('exam.grade'); ?></th>
                                                                    <?php endif; ?>
                                                                    <th><?php echo app('translator')->get('homework.evalution'); ?></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade_d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td><?php echo e($grade_d->percent_from); ?></td>
                                                                        <td><?php echo e($grade_d->percent_upto); ?></td>
                                                                        <?php if(@generalSetting()->result_type != 'mark'): ?>
                                                                            <td><?php echo e($grade_d->gpa); ?></td>
                                                                            <td><?php echo e($grade_d->grade_name); ?></td>
                                                                        <?php endif; ?>
                                                                        <td class="text-left"><?php echo e($grade_d->description); ?></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        <?php endif; ?>
                                                    </div>
                                                    <table class="table mb-0">
                                                        <thead>
                                                        <tr class="text-center">
                                                            <th class="text-center"><?php echo app('translator')->get('common.subjects'); ?></th>
                                                            <th class="text-center"><?php echo app('translator')->get('exam.total_mark'); ?></th>
                                                            <th class="text-center"><?php echo app('translator')->get('exam.pass_mark'); ?></th>
                                                            <?php $__currentLoopData = $result_setting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assinged_exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <th class="text-center"><?php echo e(@$assinged_exam->examTypeName->title); ?> (<?php echo e(@$assinged_exam->exam_percentage); ?>%)</th>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <th class="text-center"><?php echo app('translator')->get('exam.average'); ?></th>
                                                            <th class="text-center"><?php echo app('translator')->get('exam.result'); ?></th>
                                                            <th class="text-center"><?php echo app('translator')->get('exam.grade'); ?></th>
                                                        </tr>

                                                        </thead>

                                                        <tbody class="mark_sheet_body">
                                                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignsubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                  <tr>
                                                                        <td class="text-center"><?php echo e(@$assignsubject->subject->subject_name); ?></td>
                                                                        <td class="text-center">100</td>
                                                                        <td class="text-center"><?php echo e(@$assignsubject->subject->pass_mark); ?></td>
                                                                        <?php $__currentLoopData = $result_setting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examRule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <td class="text-center"><?php echo e(singleSubjectMark($record_id,$assignsubject->subject->id,$examRule->exam_type_id)[0]); ?></td>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <td class="text-center"><?php echo e(subjectAverageMark($record_id,$assignsubject->subject->id)[0]); ?></td>
                                                                        <td class="text-center"></td>
                                                                        <td class="text-center"><?php echo e(getGrade(subjectAverageMark($record_id,$assignsubject->subject->id)[0],true)); ?></td>
                                                                  </tr>
                                                      
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                            <tfoot>
                                                                  <tr>
                                                                        <th class="text-center"><?php echo app('translator')->get('exam.total_average'); ?></th>
                                                                        <th class="text-center">100</th>
                                                                        <th class="text-center"><?php echo e(avgSubjectPassMark($all_subject_ids)); ?></th>
                                                                        <?php $__currentLoopData = $result_setting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <th class="text-center"><?php echo e(allExamSubjectMark($record_id,$exam->id)[0]); ?></th>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <th class="text-center"><?php echo e(allExamSubjectMarkAverage($record_id,$all_subject_ids)); ?></th>
                                                                        <th class="text-center">
                                                                              <?php if( allExamSubjectMarkAverage($record_id,$all_subject_ids) >= avgSubjectPassMark($all_subject_ids)): ?>
                                                                              <?php echo app('translator')->get('exam.pass'); ?>
                                                                              <?php else: ?>
                                                                              <?php echo app('translator')->get('exam.fail'); ?>
                                                                              <?php endif; ?>

                                                                        </th>
                                                                        <th class="text-center"><?php echo e(getGrade(allExamSubjectMarkAverage($record_id, $all_subject_ids),true)); ?></th>
                                                                        
                                                                       
                                                                  </tr>
                                                            </tfoot>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                 
            </section>
    <?php endif; ?>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\resources\views/backend/studentInformation/inc/finalMarkSheet.blade.php ENDPATH**/ ?>