<html>

	<head>
		<title><?php echo app('translator')->get('admin.student_certificate'); ?></title>

		<link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/bootstrap.css" />
		
		<style rel="stylesheet">
			body{
				font-family: 'dejavu sans','Poppins', sans-serif;
				font-size: 14px;
				margin: 0;
				padding: 0;
			}

			.tdWidth{
				width: 33.33%;
			}
			.bgImage{
				height:auto; 
				background-repeat:no-repeat;
				background-image: url(<?php echo e(asset($certificate->file)); ?>);
				  
			}
			table{
				/* margin-top: 160px; */
				text-align: center; 
			}
			 
			td{
				padding: 25px !important;
			}
			.DivBody{    
				height: 100vh;
				border: 1px solid var(--border_color) !important;
				margin-top: 0px;
			}
			.tdBody{
				text-align: justify !important;				
			    height: 140px;
			    padding-top: 0px;
			    padding-bottom: 0px;
			    padding-left: 65px;
			    padding-right: 65px;

			}
			img{
				position: absolute;
			}
			table{
				position: relative;
				/* top:100;			 */
			}
			body{
				/* padding:0px !important; */
				margin:0px !important;
			}
			/* style added  */
			.DivBody{
				position: relative;
			}
			.position_bg{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
			.certificate_body_inner {
				/* display: flex;
				flex-direction: column;
				justify-content: space-between;
				height: 100%;
				padding: 120px 0 120px 0; */
				position: relative;
				height: 100%;
			}
			.tdBody {
				position: relative;
				top: 280px;
			}
			.position_bg {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
			.postion_header_certificate {
				position: absolute;
				top: 18%;
				width: calc(100% - 20%);
				left: 0;
				margin: auto;
				right: 0;
			}
			.postion_footer_certificate {
				position: absolute;
				bottom: 15%;
				width: calc(100% - 20%);
				left: 0;
				margin: auto;
				right: 0;
			}
			@page { 
				margin: 2px; 
				size: 21cm 17cm; 
				}
			
			body { margin: 1px; }

			.bb-15 {
				border-bottom: 1px solid rgba(65, 80, 148, 0.15);
			}
			.signature {
				padding-bottom: 10px;
				text-align: center;
			}
			@media print{.DivBody{page-break-after:always}}
		</style>
	</head>
	
	<body onLoad="loadHandler();">
		<?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="DivBody"  style="margin-bottom: <?php echo e(@$gridGap); ?>px">
				<img class="position_bg" src="<?php echo e(asset($certificate->file)); ?>" style="height: 100vh; width: 100% !important">
				<div class="certificate_body_inner">
					<table width="80%" align="center" class="postion_header_certificate">
						<tr>
							<td style="text-align: left;" class="tdWidth"><?php echo e(@$certificate->header_left_text); ?>:</td>
							<td style="text-align: center;" class="tdWidth"></td>
							<td style="text-align: right;" class="tdWidth"><?php echo app('translator')->get('common.date'); ?>: <?php echo e(@$certificate->date); ?></td>
						</tr>
					</table>
					<table width="80%" align="center" >
						<tr>
							<td colspan="3" class="tdBody"><?php echo e(isset($student->id) ? App\SmStudentCertificate::certificateBody($certificate->body, 2,$student->id) : ''); ?></td>
						</tr>
					</table>
					<table width="80%" align="center" class="postion_footer_certificate">
						<tr>
							<td style="text-align: left;" class="tdWidth">
								<div class="signature bb-15"><?php echo e(@$certificate->footer_left_text); ?></div>
							</td>
							<td style="text-align: center;" class="tdWidth">
								<div class="signature bb-15"><?php echo e(@$certificate->footer_center_text); ?></div>
							</td>
							<td style="text-align: right;" class="tdWidth ">
								<div class="signature bb-15"><?php echo e(@$certificate->footer_right_text); ?></div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	 
	</body>
</html>
<?php /**PATH D:\xampp\htdocs\Modules/BulkPrint\Resources/views/admin/student_certificate_bulk_print.blade.php ENDPATH**/ ?>