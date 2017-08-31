<!DOCTYPE html>
<html lang="en">
<head>
	<title>Manpower Request</title>
	<link rel="icon" href="<?php echo base_url(); ?>/assets/images/tr.ico">
	<?php require_once __DIR__."/../includes/global_css.php"; ?>
</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-sidebar-closed">

	<?php require_once __DIR__."/../includes/header.php"; ?>
	<div class="clearfix"></div>

	<div class="page-container">
		<?php require_once __DIR__."/../includes/sidebar.php";?>
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 style="margin:0;">Manpower Request</h3>
				<div class="row">&nbsp;</div>
				<div class="row container-fluid">
					<ul class="breadcrumb">
						<li>
							<span>Manpower Request</span>
						</li>
						<li>
							<span>Approval</span>
						</li>
						<li>
							<span>Pending</span>
						</li>
					</ul>
				</div>
				<div class="row milestone">
					<div class="col-md-12">
						<div class="portlet box grey-gallery">
							<div class="portlet-title">
								<div class="caption">Milestones</div>
								<div class="tools">
									<a href="#" class="collapse" data-original-title="" title=""></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="form-wizard">
									<ul class="nav nav-pills nav-justified steps">
										<li<?php if ($status == 'R1') echo ' class="active"'; ?>>
											<a data-toggle="tab" class="step">
												<span class="number">1</span></br>
												<span class="desc"><i class="fa fa-check"></i>Creation</span>
											</a>
										</li>
										<li<?php if ($status == 'A1') echo ' class="active"'; ?>>
											<a data-toggle="tab" class="step">
												<span class="number">2</span></br>
												<span class="desc"><i class="fa fa-check"></i>Approval 1</span>
											</a>
										</li>
										<li<?php if ($status == 'A2') echo ' class="active"'; ?>>
											<a data-toggle="tab" class="step">
												<span class="number">3</span></br>
												<span class="desc"><i class="fa fa-check"></i>Approval 2</span>
											</a>
										</li>
										<li<?php if ($status == 'A3') echo ' class="active"'; ?>>
											<a data-toggle="tab" class="step">
												<span class="number">4</span></br>
												<span class="desc"><i class="fa fa-check"></i>Approval 3</span>
											</a>
										</li>
										<li<?php if ($status == 'A4') echo ' class="active"'; ?>>
											<a data-toggle="tab" class="step">
												<span class="number">5</span></br>
												<span class="desc"><i class="fa fa-check"></i>Approval 4</span>
											</a>
										</li>
										<li<?php if ($status == 'HR') echo ' class="active"'; ?>>
											<a data-toggle="tab" class="step">
												<span class="number">6</span></br>
												<span class="desc"><i class="fa fa-check"></i>Approval HR Group</span>
											</a>
										</li>
										<li <?php if ($status == 'C1') echo ' class="active"'; ?>>
											<a data-toggle="tab" class="step">
												<span class="number">7</span></br>
												<span class="desc"><i class="fa fa-check"></i>Closing</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php //var_dump($genReq);?>
				<div class="row">
					<div class="col-lg-12">
						<div class="portlet box red">
							<div class="portlet-title">
								<div class="caption">
									General Information
								</div>
								<div class="tools">
									<a href="javascript: void(0);" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table id="tbRequest" class="table table-striped" style="text-align: center;">
									<thead>
										<tr>
											<th>Request No.</th>
											<th>Position</th>
											<th>Reason For Request</th>
											<th>Working Status</th>
											<th>Number of Employee</th>
											<th>Created By</th>
											<th>Plant</th>
											<th>Department</th>
											<th>Create On</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if(isset($forTbRequest)){
												for($i = 0; $i < sizeof($forTbRequest); $i++){
													echo "
														<tr class='linkRequest' data-no='".$forTbRequest[$i]['request_no']."'>
															<td>".$forTbRequest[$i]['request_no']."</td>
															<td>".$forTbRequest[$i]['position']."</td>
															<td>".$forTbRequest[$i]['reason']."</td>
															<td>".$forTbRequest[$i]['working_status']."</td>
															<td>".$forTbRequest[$i]['number_of_employee']."</td>
															<td>".$forTbRequest[$i]['created_by']."</td>
															<td>".$forTbRequest[$i]['plant']."</td>
															<td>".$forTbRequest[$i]['department']."</td>
															<td>".$forTbRequest[$i]['created_on']."</td>
														</tr>
													";
												}
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<?php require_once __DIR__."/../includes/footer.php"; ?>
	<input type="hidden" name="" id="pending" value="<?php echo $from;?>">
</body>
<?php require_once __DIR__."/../includes/global_js.php"; ?>
<script src="<?php echo base_url(); ?>assets/js/au.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime-moment.js"></script>
<script type="text/javascript">
	$('#tbRequest').DataTable();
</script>
<script>
	var pending = $("#pending").val();
	if (pending == 'change' ) {
		$('.menu_mpr_req_change').addClass('active');
		$('.menu_mpr_req_change').parents('.menu_mpr_req').addClass('active');
		$('.menu_mpr_req_change').parents('.menu_mpr_req').parents('.menu_mpr').addClass('active');
		$('.menu_mpr_req_change').parents('.menu_mpr').addClass('active');
	}
	// jika page history, nilai pending = 2
	else if(pending == 'history'){
		$('.menu_mpr_req_history').addClass('active');
		$('.menu_mpr_req_history').parents('.menu_mpr_req').addClass('active');
		$('.menu_mpr_req_history').parents('.menu_mpr_req').parents('.menu_mpr').addClass('active');
		$('.menu_mpr_req_history').parents('.menu_mpr').addClass('active');
	}
	else if(pending == 'approvalPending'){
		$('.menu_mpr_app_pending').addClass('active');
		$('.menu_mpr_app_pending').parents('.menu_mpr_app').addClass('active');
		$('.menu_mpr_app_pending').parents('.menu_mpr_app').parents('.menu_mpr').addClass('active');
		$('.menu_mpr_app_pending').parents('.menu_mpr').addClass('active');
	}
	else if(pending == 'approvalHistory'){
		$('.menu_mpr_app_history').addClass('active');
		$('.menu_mpr_app_history').parents('.menu_mpr_app').addClass('active');
		$('.menu_mpr_app_history').parents('.menu_mpr_app').parents('.menu_mpr').addClass('active');
		$('.menu_mpr_app_history').parents('.menu_mpr').addClass('active');
	}
	else{
		$('.menu_mpr_req_pending').addClass('active');
		$('.menu_mpr_req_pending').parents('.menu_mpr_req').addClass('active');
		$('.menu_mpr_req_pending').parents('.menu_mpr_req').parents('.menu_mpr').addClass('active');
		$('.menu_mpr_req_pending').parents('.menu_mpr').addClass('active');
	}

	$(document).ready(function() {
		$('#all_loading').fadeOut();

		// date picker
		$('.date-picker').datepicker({
			rtl: Metronic.isRTL(),
			orientation: 'left',
			autoclose: true,
			format: 'D, dd.mm.yyyy'
		});

		// hide milestone
		$('.milestone').hide();

		if (pending == 'change') {
			$('body').on('click', '.linkRequest', function() {
				window.location.href = "<?php echo base_url().'request/change?no='; ?>" + $(this).data('no');
			});
		} else if (pending == 'approvalPending') {
			$('body').on('click', '.linkRequest', function() {
				window.location.href = "<?php echo base_url().'request/approval_pending?no='; ?>" + $(this).data('no');
			});
		} else {
			$('body').on('click', '.linkRequest', function() {
				window.location.href = "<?php echo base_url().'request/pending?no='; ?>" + $(this).data('no');
			});
		}
		
	});
</script>
</html>