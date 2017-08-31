<!DOCTYPE html>
<html lang="en">
<head>
	<title>Manpower Request</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo base_url(); ?>/assets/images/tr.ico">
	<?php require_once __DIR__."/../includes/global_css.php"; ?>
	<!-- <style type="text/css">
		.date-picker[readonly]{
			cursor: default !important;
		}
	</style> -->
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-sidebar-closed">

	<?php require_once __DIR__."/../includes/header.php"; ?>
	<div class="clearfix"></div>

	<div class="page-container">
		<?php require_once __DIR__."/../includes/sidebar.php"; ?>
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 style="margin:0;">Appraisal Report</h3>
				<div class="row">&nbsp;</div>
				<div class="row container-fluid">
					<ul class="breadcrumb">
						<li>
							<span>Appraisal Report</span>
						</li>
						<li>
							<span>Succession Planning</span>
						</li>
					</ul>
				</div>
				<!-- START Search Options -->
				<div class="row">
					<div class="col-lg-12">
						<div class="portlet box grey-cascade">
							<div class="portlet-title">
								<div class="caption">
									Search Options
								</div>
								<div class="tools">
									<a href="javascript: void(0);" class="collapse"></a>
								</div>
							</div>
							
							<div class="portlet-body form">
								<div class="form-body">
									<div class="row zrow">
										
										<div class="col-lg-12">
											<!-- Bagian Kiri -->
											<div class="col-lg-6">
												<label class="control-label col-lg-4">NIK</label>
												<div class="col-lg-8">
													<select class="form-control" id="nik" name="nik[]" multiple="multiple">
														
													</select>
												</div>

												<div class="col-lg-12 gap">&nbsp;</div>
												<label class="control-label col-lg-4">Name</label>
												<div class="col-lg-8">
													<select class="form-control" id="name" name="name[]" multiple="multiple">
													</select>
												</div>
												<div class="col-lg-12 gap">&nbsp;</div>
												<label class="control-label col-lg-4">Appraisal Period</label>
												<div class="col-md-8">
													<div class="input-group date-picker input-daterange" data-date-format="dd.mm.yyyy">
														<input type="" class="form-control date-picker start-date readonly" name="create_from" id="create_from" placeholder="Start Date" required="">
														<span class="input-group-addon"> to </span>
														<input type="" class="form-control date-picker end-date readonly" name="create_to" id="create_to" placeholder="End Date" required=""> 
													</div>
												</div>
												<div class="col-lg-12 gap">&nbsp;</div>
											</div>

											<!-- Bagian Kanan -->
											<div class="col-lg-6">
												<div class="col-lg-12">
													<label class="control-label col-lg-4">Personnel Area</label>
													<div class="col-lg-8">
														<select class="form-control" id="personnel_area" name="personnel_area[]" multiple="multiple">
															
														</select>
													</div>
												</div>
												<div class="col-lg-12 gap">&nbsp;</div>
												<div class="col-lg-12">
													<label class="control-label col-lg-4">Personnel Subarea</label>
													<div class="col-lg-8">
														<select class="form-control" id="personnel_subarea" name="personnel_subarea[]" multiple="multiple">
															
														</select>
													</div>
												</div>
												<div class="col-lg-12 gap">&nbsp;</div>
												<div class="col-lg-12">
													<label class="control-label col-lg-4">Employee Subgroup</label>
													<div class="col-lg-8">
														<select class="form-control" id="employee_subgroup" name="employee_subgroup[]" multiple="multiple">
															
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12" style="text-align:center;margin-bottom:25px;">
										<button type="submit" name="btnSearch" class="btn blue" id="btnSearch"><i class="fa fa-search"></i> Display</button>
									</div>
								</div>
								<input type="hidden" id="i" name="">
							</div>
							
						</div>
					</div>
				</div>
				<!-- END Search Options -->
				<!-- Datatable (Success) -->
				<div class="isi"></div>
				<?php

				?>
			</div>
		</div>
	</div>

	<?php require_once __DIR__."/../includes/footer.php"; ?>

</body>
<?php require_once __DIR__."/../includes/global_js.php"; ?>
<script src="<?php echo base_url(); ?>assets/js/au.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime-moment.js"></script>
<script>
	$('.menu_rec_app_list').addClass('active');
	$('.menu_rec_app_list').parents('.menu_rec_app').addClass('active');
	$('.menu_rec_app_list').parents('.menu_rec_app').parents('.menu_rec').addClass('active');

	$(document).ready(function() {
		$('#all_loading').fadeOut();
		$('#request_no').select2({
				placeholder: {
			    id: '-1', // the value of the option
			    text: '(Any)'
			}
		});
		// readonly validator
       	$(".readonly").keydown(function(e){
	        e.preventDefault();
	    });
		$('#tes').click(function(){
			var a = $("#sel1").val();
			alert(a); 
		});
		$("select").select2({
			placeholder: {
				text: '(Any)'
			}
		});
		
		// date picker
		$('.start-date').datepicker(
		{
			orientation: 'bottom',
			autoclose: true,
			format: 'D, dd.mm.yyyy'
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('.end-date').datepicker('setStartDate', minDate);
		});		

		$('.end-date').datepicker(
		{
			orientation: 'bottom',
			autoclose: true,
			format: 'D, dd.mm.yyyy'
		}).on('changeDate', function (selected) {
			var maxDate = new Date(selected.date.valueOf());
			$('.start-date').datepicker('setEndDate', maxDate);
		});

		$('#btnSearch').click(function(){
			var request_no = $('#request_no').val();
			var plant = $('#plant').val();
			var department = $('#department').val();
			var position = $('#position').val();
			var name = $("#name").val();
			var major = $('#major').val();
			var create_from = $('#create_from').val();
			var create_to = $('#create_to').val();
			$.ajax({
				type  : 'POST',
				data: {request_no: request_no, plant: plant, department: department, position: position, name: name, major:major, create_from: create_from, create_to: create_to},
				url      : "<?php echo base_url()?>Recruitment/getApplicantList",
				success  : function(response){
					$('.isi').html(response);
					$('#applicant-list-table').DataTable({
						"language": {
							"emptyTable":"Data is not available."
						}
					});
				}
			});
		});

	});
</script>
</html>