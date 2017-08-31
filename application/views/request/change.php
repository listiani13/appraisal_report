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
	$('.menu_mpr_req_change').addClass('active');
	$('.menu_mpr_req_change').parents('.menu_mpr_req').addClass('active');
	$('.menu_mpr_req_change').parents('.menu_mpr_req').parents('.menu_mpr').addClass('active');
	$('.menu_mpr_req_change').parents('.menu_mpr').addClass('active');

	$(document).ready(function() {
		//setInterval(function(){ $('.get-org-chart>a').html(""); }, 1);

		$('#all_loading').fadeOut();

		$('#plant').on('change', function() {
			$('#direct_superior option').remove();
			$('#job_class option').remove();
			$('select[name="nik[]"] option').remove();
			$('#replacement').empty();
			$('#department option').remove();
			$('#direct_superior').select2({
				placeholder: {
					id: '-1',
					text: 'Select direct superior'
				},
				required: 'true'
			});
			$('#job_class').select2({
				placeholder: {
					id: '-1',
					text: 'Select job class'
				},
				required: 'true'
			});
			$('#department').select2({
				placeholder: {
					id: '-1',
					text: 'Select department'
				},
				required: 'true'
			});
			var plant = $('#plant').val();
			<?php if(isset($genReq)) echo "var request_no = ".$genReq['request_no'].";";?>
			$.ajax({
		        url: "<?php echo base_url();?>request/selectSupperiorPlant",
		        type: "post",
		        data: {plant:plant <?php if(isset($genReq)) echo ", request_no:request_no";?>} ,
		        success: function (response) {
		        	$('#direct_superior').append(response);
		        	$('#direct_superior').val($('#direct_superior').val()).trigger('change.select2');
		        	$('#direct_superior').trigger('change');
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }

		    });
			$.ajax({
		        url: "<?php echo base_url();?>request/selectJobClassPlant",
		        type: "post",
		        data: {plant:plant <?php if(isset($genReq)) echo ", request_no:request_no";?>} ,
		        success: function (response) {
		        	$('#job_class').append(response);
		        	$('#job_class').val($('#job_class').val()).trigger('change.select2');
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
		    });
		    $.ajax({
		        url: "<?php echo base_url();?>request/generateSelectForUpdate",
		        type: "post",
		        data: {plant:plant <?php if(isset($genReq)) echo ", request_no:request_no";?>} ,
		        success: function (response) {
		        	$('#replacement').append(response);
		        	//$('select[name="nik[]"]').val($('select[name="nik[]"]').val()).trigger('change.select2');
		        	$('select[name="nik[]"]').select2({
						placeholder: {
							id: '-1',
							text: 'Select employee to be replaced'
						},
						required: 'true'
					});
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }

		    });	
		    $.ajax({
		        url: "<?php echo base_url();?>request/selectReplacement",
		        type: "post",
		        data: {plant:plant <?php if(isset($genReq)) echo ", request_no:request_no";?>} ,
		        success: function (response) {
		        	all_employee = '<select required name="nik[]" class="form-control">' + response + '</select>';
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }

		    });	
		    $.ajax({
		        url: "<?php echo base_url();?>request/selectDepartment",
		        type: "post",
		        data: {plant:plant <?php if(isset($genReq)) echo ", request_no:request_no";?>} ,
		        success: function (response) {
		        	$('#department').append(response);
		        	$('#department').val($('#department').val()).trigger('change.select2');
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
		    });
		}).trigger('change');

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

		// date picker
		$('.date-picker').datepicker({
			rtl: Metronic.isRTL(),
			orientation: 'left',
			autoclose: true,
			format: 'D, dd.mm.yyyy'
		});

		$('#btnDelete').click(function(){
			var result = confirm("Want to delete?");
			if (result) {
			    $("#forDelete").append('<input type="hidden" name="delete" value="1">');
			} else {
				return false;
			}
		});

		// hide milestone
		$('.milestone').hide();

		// department
		/*
		$('#plant').change(function(){
			$('#department').showHideDropdownOptions('option',false);
			$('#department').showHideDropdownOptions('option.'+$('#plant').val(),true);
			$('#department').val( $("#department option:not([disabled])").first().val() );
		}).trigger('change');
		*/
		$('#department').val( department_selected );

		// reason
		$('input[name=reason]').change(function(){
			if ($('input[name=reason]:checked').val() == '1') {
				$('.replacement').show();
			} else {
				$('.replacement').hide();
			}
		});

		function jobDescValidation(){
			var flag = true;
			var j = 0;
			var c = $('input[name="job_description_show[]"]').size();
	        $('input[name="job_description[]"]').each(function (i, val){
				if (val.value != ''/* && val.value.contains('.')*/) {
					//alert(val.value);
					var ext = val.value.substring(val.value.lastIndexOf('.') + 1);
					var filesize = val.files[0].size; // MB
					if(filesize < 10240000 && (ext =="xls" || ext =="xlsx" <?php if($from == "change" || $from == "approvalPending") echo '|| ext == ""';?>)){
						//benar
					}else{
						if(filesize >= 10240000) {
							alert("File size job description must smaller than 10MB");
						}
						if(ext =="xls" || ext =="xlsx" <?php if($from == "change" || $from == "approvalPending") echo '|| ext == ""';?>){

						} else {
							alert("Check file type job description");
						}
						flag = false;
						//break;
					}
				} else if (c == 0) {
					alert("Job description file required");
					flag = false;
				}
			});
			return flag;
		}

		// job descriptions
		$('input[name="job_description[]"]').on('change', function(){
			if($('input[name="job_description[]"]').val() != '' && jobDescValidation()){
				$('.jdShow').remove();
				$('#upJobDesc a').remove();
				$('#upJobDesc').append('<a id="btnUpJobDesc" class="btn blue" title="Load Requirement from this Excel"><i class="fa fa-upload"></i></a>');
				// form upload
				$('#btnUpJobDesc').on('click', function(){
					$('#educational_background tr').remove();
					$('#educational_background').append('<tr><td class="center">Educational Background</td><td class="center">Level</td><td class="center">Major</td><td class="center" style="width:40px"></td></tr>');
					var formData = new FormData($("#main")[0]);
					$.ajax({
						url: "<?php echo base_url();?>request/getDataFromExcelToEdu",
						type: 'POST',
						data: formData,
						async: false,
						success: function (ret) {
							$('#educational_background').append(ret);

						},
						error: function (ret) {
							alert(ret);
						},
						cache: false,
						contentType: false,
						processData: false
					});

					$('#experience tr').remove();
					var formData = new FormData($("#main")[0]);
					$.ajax({
						url: "<?php echo base_url();?>request/getDataFromExcelToExp",
						type: 'POST',
						data: formData,
						async: false,
						success: function (ret) {
							$('#experience').append(ret);
						},
						error: function (ret) {
							alert(ret);
						},
						cache: false,
						contentType: false,
						processData: false
					});
					$('input[name="year[]"]').on("keydown", function(e) {
					    var key   = e.keyCode ? e.keyCode : e.which;
					    if (!( [8, 9, 13, 27].indexOf(key) !== -1 ||
					         (key >= 48 && key <= 57 ) ||
					         (key >= 96 && key <= 105)
					       )) e.preventDefault();
					});

					$('#other_qualification tr').remove();
					$.ajax({
						url: "<?php echo base_url();?>request/getDataFromExcelToOth",
						type: 'POST',
						data: formData,
						async: false,
						success: function (ret) {
							$('#other_qualification').append(ret);

						},
						error: function (ret) {
							alert(ret);
						},
						cache: false,
						contentType: false,
						processData: false
					});

					$('#foreign_language tr').remove();
					$.ajax({
						url: "<?php echo base_url();?>request/getDataFromExcelToLng",
						type: 'POST',
						data: formData,
						async: false,
						success: function (ret) {
							$('#foreign_language').append(ret);

						},
						error: function (ret) {
							alert(ret);
						},
						cache: false,
						contentType: false,
						processData: false
					});

					$.ajax({
						url: "<?php echo base_url();?>request/generateDiagramStructureTextFromExcel",
						type: 'POST',
						data: formData,
						dataType: 'json',
						async: false,
						success: function (ret) {
							$('[data-node-id="1"] text').text(ret[0]);
							$('[data-node-id="2"] text').text(ret[1]);
							$('[data-node-id="3"] text').text(ret[2]);
							$('[data-node-id="4"] text').text(ret[3]);
							$('[data-node-id="5"] text').text(ret[4]);
							$('[name="organisasi1"').val(ret[0]);
							$('[name="organisasi2"').val(ret[1]);
							$('[name="organisasi3"').val(ret[2]);
							$('[name="organisasi4"').val(ret[3]);
							$('[name="organisasi5"').val(ret[4]);
						},
						error: function (ret) {
							alert(ret);
						},
						cache: false,
						contentType: false,
						processData: false
					});
				});
			} else {
				$('#upJobDesc a').remove();
			}
		});
		$('body').on('click','#btnJobDesc.btn-plus',function(){
			$('#job_description').append('<tr><td><input accept=".jpg, .png, .PNG, .gif, .jpeg, .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" type="file" name="job_description[]" class="form-control"></td><td><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr>');
		});
		$('body').on('click','#job_description .btn-minus',function(){
			if($('#job_description tr').size() == 1){
				
			} else {
				var result = confirm("Want to delete?");
				if (result) {
				    $(this).closest('tr').remove();
				}
			}
		});

		// supporting documents
		$('body').on('click','#btnSupportDoc.btn-plus',function(){
			$('#supporting_document').append('<tr><td><input accept=".jpg, .png, .PNG, .gif, .jpeg, .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" type="file" name="supporting_document[]" class="form-control"></td><td><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr>');
		});
		$('body').on('click','#supporting_document .btn-minus',function(){
			var result = confirm("Want to delete?");
			if (result) {
			    $(this).closest('tr').remove();
			}
		});

		// replacements
		$('body').on('click','#btnNik.btn-plus',function(){
			$('#replacement').append('<tr><td>'+all_employee+'</td><td><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr>');
			$('select').select2();
			$('select[name="nik[]"]').select2({
				placeholder: {
					id: '-1',
					text: 'Select employee to be replaced'
				},
				required: 'true'
			});
		});
		$('body').on('click','#replacement .btn-minus',function(){
			if($('#replacement tr').size() == 1){
				
			} else {
				var result = confirm("Want to delete?");
				if (result) {
				    $(this).closest('tr').remove();
				}
			}
		});

		// educational background
		$('body').on('click','#btnEduBack.btn-plus',function(){
			var flagEdu = 1;
			$('input[name="educational_background[]"]').each(function (i, val){
				if(val.value == ""){
					flagEdu = 0;
				}
			});
			$('input[name="level[]"]').each(function (i, val){
				if(val.value == ""){
					flagEdu = 0;
				}
			});
			$('input[name="major[]"]').each(function (i, val){
				if(val.value == ""){
					flagEdu = 0;
				}
			});
			if(flagEdu == 1){
				$('#educational_background').append('<tr><td><input required type="text" name="educational_background[]" class="form-control"></td><td><input required type="text" name="level[]" class="form-control"></td><td><input required type="text" name="major[]" class="form-control"></td><td><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr>');
			}
		});
		$('body').on('click','#educational_background .btn-minus',function(){
			if($('#educational_background tr').size() == 2){
				
			} else {
				var result = confirm("Want to delete?");
				if (result) {
				    $(this).closest('tr').remove();
				}
			}
		});

		// experience
		$('body').on('click','#btnExperience.btn-plus',function(){
			var flagExp = 1;
			$('input[name="experience[]"]').each(function (i, val){
				if(val.value == ""){
					flagExp = 0;
				}
			});
			$('input[name="year[]"]').each(function (i, val){
				if(val.value == ""){
					flagExp = 0;
				}
			});
			if(flagExp == 1){
				$('#experience').append('<tr class="sub"><td><table style="width:100%"><tr><td class="left" style="width:150px">Experiences</td><td><input  required name="experience[]" type="text" class="form-control"></td><td class="center" style="width:100px">Years</td><td style="width:100px"><input id="year" required name="year[]" type="number" class="form-control" min="1"></td><td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr><tr><td colspan="4"><textarea name="expDesc[]" style="width:100%;height:150px;resize:none;border-color:#e5e5e5"></textarea></td><td></td></tr></table></td></tr>');
				$('input[name="year[]"]').on("keydown", function(e) {
				    var key   = e.keyCode ? e.keyCode : e.which;
				    if (!( [8, 9, 13, 27].indexOf(key) !== -1 ||
				         (key >= 48 && key <= 57 ) ||
				         (key >= 96 && key <= 105)
				       )) e.preventDefault();
				});
			}
			
		});

		$('body').on('click','#experience .btn-minus',function(){
			if($('#experience tr.sub').size() == 1){
				
			} else {
				var result = confirm("Want to delete?");
				if (result) {
				    $(this).closest('tr.sub').remove();
				}
			}
		});

		// other qualification
		$('body').on('click','#btnOtherQualification.btn-plus',function(){
			var flagOther = 1;
			$('input[name="other_qualification[]"]').each(function (i, val){
				if(val.value == ""){
					flagOther = 0;
				}
			});
			if(flagOther == 1){
				$('#other_qualification').append('<tr><td><input required name="other_qualification[]" type="text" class="form-control"></td><td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr>');
			}
		});
		$('body').on('click','#other_qualification .btn-minus',function(){
			if($('#other_qualification tr').size() == 1){
				
			} else {
				var result = confirm("Want to delete?");
				if (result) {
				    $(this).closest('tr').remove();
				}
			}
		});

		// foreign language
		$('body').on('click','#btnForLang.btn-plus',function(){
			var flagLang = 1;
			$('input[name="foreign_language[]"]').each(function (i, val){
				if(val.value == ""){
					flagLang = 0;
				}
			});
			if(flagLang == 1){
				$('#foreign_language').append('<tr><td><input required name="foreign_language[]" type="text" class="form-control"></td><td style="width:100px"><select name="langQuality[]" class="form-control"><option>GOOD</option><option>FAIR</option></select></td><td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr>');
				$('select').select2();
			}
		});
		$('body').on('click','#foreign_language .btn-minus',function(){
			if($('#foreign_language tr').size() == 1){
				
			} else {
				var result = confirm("Want to delete?");
				if (result) {
				    $(this).closest('tr').remove();
				}
			}
		});
	});
</script>
</html>