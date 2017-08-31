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
	$('.menu_mpr_app_history').addClass('active');
	$('.menu_mpr_app_history').parents('.menu_mpr_app').addClass('active');
	$('.menu_mpr_app_history').parents('.menu_mpr_app').parents('.menu_mpr').addClass('active');
	$('.menu_mpr_app_history').parents('.menu_mpr').addClass('active');

	$(document).ready(function() {
		//setInterval(function(){ $('.get-org-chart>a').html(""); }, 1);
		$('#all_loading').fadeOut();
		$('.milestone').show();

		var orgchart = new getOrgChart(document.getElementById("strukturOrganisasi"), {			
	        theme: "ula",
	        color: "orange",
	        enableEdit: false,
	        enableZoom: false,
	        //enableMove: false,
	        enableSearch: false,
	        enableDetailsView: false,
	        dataSource: [
	            { id: 1, parentId: null, Name: "<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col1']; else echo " ";?>"},
	            { id: 2, parentId: 1, Name: "<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col2']; else echo " ";?>"},
	            { id: 3, parentId: 2, Name: "<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col3']; else echo " ";?>"},
	            { id: 4, parentId: 2, Name: "<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col4']; else echo " ";?>"},
	            { id: 5, parentId: 2, Name: "<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col5']; else echo " ";?>"}
	        ]
	    });

		// disabled & readonly
		$('input[type=file]').attr('disabled','disabled');
		$('input[type=radio]').attr('disabled','disabled');
		$('input[type=number]').attr('readonly','readonly');
		$('input[type=text]').attr('readonly','readonly');
		$('select').attr('disabled','disabled');
		$('textarea').attr('readonly','readonly');

		// hide button
		$('#job_description1').hide();
		$('#supporting_document1').hide();
		$('.btn-plus').hide();
		$('.btn-plus').closest('td').remove();
		$('.btn-minus').hide();
		$('.btn-minus').closest('td').remove();
		
		// button back
		$('#btnBack').click(function(){
			window.history.go(-1);
		});
	});
	$('#tbApplicant').DataTable();
</script>
</html>