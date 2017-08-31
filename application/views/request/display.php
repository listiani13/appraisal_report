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
		<?php require_once __DIR__."/../includes/sidebar.php"; ?>
		<?php require_once __DIR__."/../request/template.php"; ?>
	</div>

	<?php require_once __DIR__."/../includes/footer.php"; ?>

</body>
<?php require_once __DIR__."/../includes/global_js.php"; ?>
<script src="<?php echo base_url(); ?>assets/js/au.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime-moment.js"></script>
<script>
	$('.menu_mpr_req_create').addClass('active');
	$('.menu_mpr_req_create').parents('.menu_mpr_req').addClass('active');
	$('.menu_mpr_req_create').parents('.menu_mpr_req').parents('.menu_mpr').addClass('active');
	$('.menu_mpr_req_create').parents('.menu_mpr').addClass('active');

	$(document).ready(function() {
		$('#all_loading').fadeOut();

		// disabled & readonly
		$('input[type=file]').attr('disabled','disabled');
		$('input[type=radio]').attr('disabled','disabled');
		$('input[type=number]').attr('readonly','readonly');
		$('input[type=text]').attr('readonly','readonly');
		$('select').attr('disabled','disabled');
		$('textarea').attr('readonly','readonly');

		// hide button
		$('.btn-plus').hide();
		$('.btn-plus').closest('td').remove();
		$('.btn-minus').hide();
		$('.btn-minus').closest('td').remove();
	});
</script>
</html>