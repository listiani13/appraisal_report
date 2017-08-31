// $(document).ready(function() {
		$('#all_loading').fadeOut();
		var modals = ["0000","0001","0002","0007","0008","0009","0019","0021","0022","0028","0041","0051","0185","0241","0242","9005","2006","0006","0105"];
		$('#modal0001').hide();
		$('#modal0002').hide();
		$('#modal0007').hide();
		$('#modal0008').hide();
		$('#modal0009').hide();
		$('#modal0019').hide();
		$('#modal0021').hide();
		$('#modal0022').hide();
		$('#modal0028').hide();
		$('#modal0041').hide();
		$('#modal0051').hide();
		$('#modal0185').hide();
		$('#modal0241').hide();
		$('#modal0242').hide();
		$('#modal9005').hide();
		$('#modal2006').hide();
		$('#modal0006').hide();
		$('#modal0105').hide();
		$('#finishModal').hide();
		var index=-1;
		$('#nextModal').click(function() {
		index= index+1;
		if(index>modals.length){
			index=0;
		}
		for (var i = modals.length - 1; i >= 0; i--) {
				$('#modal'+modals[i]).hide();
				}
		$('#modal'+modals[index]).show();
		$("#infoType").val(modals[index]);
		if (index==modals.length-1) {
			$('#finishModal').show();
			$('#nextModal').hide();
		}
		});
		$('#prevModal').click(function() {
			index= index-1;
			if(index<0){
				index=modals.length;
			}
			for (var i = modals.length - 1; i >= 0; i--) {
					$('#modal'+modals[i]).hide();
			}
			$('#modal'+modals[index]).show();
			$('#finishModal').hide();
			$('#nextModal').show();
			$("#infoType").val(modals[index]);
		});
		var table = $('#dataTable').DataTable({
		      'order': [1, 'asc']
		});
		$('#psy-test').DataTable({
		      'order': [1, 'asc']
		});
		$('#final-interview').DataTable({
		      'order': [1, 'asc']
		});
		$('#user-interview').DataTable({
		      'order': [1, 'asc']
		});
		$('#medical-checkup').DataTable({
		      'order': [1, 'asc']
		});
		$('#finalize').DataTable({});
		var table = $('#pretest-table').DataTable({
		      'order': [1, 'asc']
		});

		$('#example-select-all').on('click', function(){
	      // Check/uncheck all checkboxes in the table
	      var rows = table.rows({ 'search': 'applied' }).nodes();
	      $('input[type="checkbox"]', rows).prop('checked', this.checked);
	   });
		$('#example tbody').on('change', 'input[type="checkbox"]', function(){
		      // If checkbox is not checked
		      if(!this.checked){
		         var el = $('#example-select-all').get(0);
		         // If "Select all" control is checked and has 'indeterminate' property
		         if(el && el.checked && ('indeterminate' in el)){
		            // Set visual state of "Select all" control 
		            // as 'indeterminate'
		            el.indeterminate = true;
		         }
		      }
		   });
		// date picker
		$('.date-picker').datepicker({
			rtl: Metronic.isRTL(),
			orientation: 'left',
			autoclose: true,
			format: 'D, dd.mm.yyyy',
			endDate : new Date()
		});	
		$('#btnSubmitPretest').click(function(){
			var app_no = $("input[name='app_no[]']")
              .map(function(){return $(this).val();}).get();
		});
		$('.btn-hire').click(function(){
			$('#myModal').modal('show');
			$("#applicant_no_modal").val($(this).data('id'));
		});
		$('.btn-submit-modal').click(function(){
			// Form 0000 //
			var applicant_no = $('#applicant_no_modal').val();
			var valid_from_0000 = $('#valid_from_0000').val();
			var valid_to_0000 = $('#valid_to_0000').val();
			var position_no_0000 = $('#position_no_0000').val();
			var personnel_area_0000 = $('#personnel_area_0000').val();
			var employee_subgroup_0000 = $('#employee_subgroup_0000').val();
			// Form 0001 //
			var valid_from_0001 = $('#valid_from_0001').val();
			var valid_to_0001 = $('#valid_to_0001').val();
			var personnel_subarea_0001 = $('#personnel_area_0001').val();
			var payroll_area_0001 =  $('#payroll_area_0001').val();
			var contract_0001 = $('#contract_0001').val();
			// Form 0002 //
			var valid_from_0002 = $('#valid_from_0002').val();
			var valid_to_0002 = $('#valid_to_0002').val();
			var first_name_0002 = $('#first_name_0002').val();
			var last_name_0002 = $('#last_name_0002').val();
			var nick_name_0002 = $('#nick_name_0002').val();
			var gender_0002 = $("input[name='gender']:checked"). val();
			var birthdate_0002 = $('#birthdate_0002').val();
			var nationality_0002 = $('#nationality_0002').val();
			var religion_0002 = $('#religion_0002').val();
			var marriage_status_0002 = $('#marriage_status_0002').val();
			// Form 0007 //
			var valid_from_0007 = $('#valid_from_0007').val();
			var valid_to_0007 = $('#valid_to_0007').val();
			var ws_rule_0007 = $('#ws_rule_0007').val();
			// Form 0008 //
			var valid_from_0008 = $('#valid_from_0008').val();
			var valid_to_0008 = $('#valid_to_0008').val();
			var reason_0008 = $('#reason_0008').val();
			var personnel_type_0008 = $('#personnel_type_0008').val();
			var personnel_area_0008 = $('#personnel_area_0008').val();
			var personnel_level_0008 = $('#personnel_level_0008').val();
			var personnel_group_0008 = $('#personnel_group_0008').val();
			var wage_type_0008 = $('#wage_type_0008').val();
			var wage_amount_0008 = $('#wage_amount_0008').val();
			// Form 0009 //
			var valid_from_0009 = $('#valid_from_0009').val();
			var valid_to_0009 = $('#valid_to_0009').val();
			var payee_0009 = $('#payee_0009').val();
			var payee_loc_0009 = $('#payee_loc_0009').val();
			var bank_country_0009 = $('#bank_country_0009').val();
			var bank_key_0009 = $('#bank_key_0009').val();
			var bank_acc_0009 = $('#bank_acc_0009').val();
			var payment_method_0009 = $('#payment_method_0009').val();
			var purpose_0009 = $('#purpose_0009').val();
			var payment_curr_0009 = $('#payment_curr_0009').val();
			// Form 0019 //
			var task_type_0019 = $('#task_type_0019').val();
			var date_of_task_0019 = $('#date_of_task_0019').val();
			var proc_indicator_0019 = $('#proc_indicator_0019').val();
			var reminder_date_0019 = $('#reminder_date_0019').val();
			// Form 0021 //
			var valid_from_0021 = $('#valid_from_0021').val();
			var valid_to_0021 = $('#valid_to_0021').val();
			var member_0021 = $('#member_0021').val();
			var name_0021 = $('#name_0021').val();
			var gender_0021 = $('.gender_0021').val();
			var birth_place_0021 = $('#birthplace_0021').val();
			var date_of_birth_0021 = $('#dob_0021').val();
			// Form 0022 //
			var valid_from_0022 = $('#valid_from_0022').val();
			var valid_to_0022 = $('#valid_to_0022').val();
			var education_est_0022 = $('#education_0022').val();
			var institute_0022 = $('#institute_0022').val();
			var country_key_0022 = $('#country_key_0022').val();
			var certificate_0022 = $('#certificate_0022').val();
			var final_grade_0022 = $('#final_grade_0022').val();
			var branch_of_study_0022 = $('#branch_of_study_0022').val();
			// Form 0028 //
			var subtype_0028 = $('#subtype_0028').val();
			var examination_date_0028 = $('#examination_date_0028').val();
			var result_0028 = $('#result_0028').val();
			var examination_data_0028 = $('#examination_data_0028').val();
			var area_0028 = $('#area_0028').val();
			var specific_0028 = $('#specific_0028').val();
			// Form 0041 //
			var date_type_0041 = $('#date_type_0041').val();
			var date_0041 = $('#date_0041').val();
			// Form 0051 //
			var valid_from_0051 = $('#valid_from_0051').val();
			var valid_to_0051 = $('#valid_to_0051').val();
			var type_rec_id_no_0051 = $('#time_rec_id_no_0051').val();
			// Form 0185 //
			var valid_from_0185 = $('#valid_from_0185').val();
			var valid_to_0185 = $('#valid_to_0185').val();
			var id_type_0185 = $('#id_type_0185').val();
			var id_number_0185 = $('#id_number_0185').val();
			var author_0185 = $('#author_0185').val();
			var date_of_issue_0185 = $('#date_of_issue_0185').val();
			var valid_to1_0185 = $('#valid_to1_0185').val();
			var place_issue_0185 = $('#place_issue_0185').val();
			var country_issue_0185 = $('#country_issue_0185').val();
			// Form 0241 //
			var valid_from_0241 = $('#valid_from_0241').val();
			var valid_to_0241 = $('#valid_to_0241').val();
			var personal_tax_id_0241 = $('#personal_tax_id_0241').val();
			var npwp_regis_date_0241 = $('#npwp_regis_date_0241').val();
			var number_of_dependents_0241 = $('#number_of_dependents_0241').val();
			var married_for_tax_purpose_0241 = $('#married_for_tax_purpose_0241').val();
			var spouse_benefit_0241 = $('#spouse_benefit_0241').val();
			// Form 0242 // 
			var valid_from_0242 = $('#valid_from_0242').val();
			var valid_to_0242 = $('#valid_to_0242').val();
			var identification_number_0242 = $('#identification_number_0242').val();
			var married_for_jamsostek_purpose_0242 = $('#married_for_jamsostek_purpose_0242').val();
			
			// Form 9005 //
			var valid_from_9005 = $('#valid_from_9005').val();
			var valid_to_9005 = $('#valid_to_9005').val();
			var bpjs_id_9005 = $('#bpjs_id_9005').val();
			var class_code_9005 = $('#class_code_9005').val();
			var faskes_tingkat_1_9005 = $('#faskes_tingkat_1_9005').val();
			var number_tax_department_9005 = $('#number_tax_department_9005').val();
			// Form 2006 //
			var category_2006 = $('#category_2006').val();
			var quota_number_2006 = $('#quota_number_2006').val();
			var deduct_from_2006 = $('#deduct_from_2006').val();
			var deduct_to_2006 = $('#deduct_to_2006').val();
			var start_from_2006 = $('#start_from_2006').val();
			var start_to_2006 = $('#start_to_2006').val();
			// `0006_valid_from`, `0006_valid_to`, `0006_address_type`, `0006_street_number`, `0006_2nd_address_line`, `0006_district`, `0006_city`, `0006_postal_code`, `0006_region`, `0006_country`, `0006_phone_number`, `0006_comm_type`, `0006_comm_number`,

			// Form 0006 //
			var valid_from_0006 = $('#valid_from_0006').val();
			var valid_to_0006 = $('#valid_to_0006').val();
			var address_type_0006 = $('#address_type_0006').val();
			var street_number_0006 = $('#street_number_0006').val();
			var second_address_line_0006 = $('#2nd_address_line_0006').val();
			var district_0006 = $('#district_0006').val();
			var city_0006 = $('#city_0006').val();
			var postal_code_0006 = $('#postal_code_0006').val();
			var region_0006 = $('#region_0006').val();
			var country_0006 = $('#country_0006').val();
			var phone_number_0006 = $('#phone_number_0006').val();
			var comm_number_0006 = $('#comm_number_0006').val();

			// Form 0105 //
			var valid_from_0105 = $('#valid_from_0105').val();
			var valid_to_0105 = $('#valid_to_0105').val();
			var user_type_0105 = $('#user_type_0105').val();
			var user_id_0105 = $('#user_id_0105').val();
			var password_0105 = $('#password_0105').val();
			$.ajax({
	            type  : 'POST',
	            data: {
	            	applicant_no:applicant_no,
	            	valid_from_0000:valid_from_0000, 
	            	valid_to_0000:valid_to_0000, 
	            	position_no_0000:position_no_0000, 
	            	personnel_area_0000:personnel_area_0000, 
	            	employee_subgroup_0000:employee_subgroup_0000,
	            	valid_from_0001:valid_from_0001,
	            	valid_to_0001:valid_to_0001,
	            	personnel_area_0001:personnel_subarea_0001,
	            	payroll_area_0001:payroll_area_0001,
	            	contract_0001:contract_0001,
	            	valid_from_0002:valid_from_0002,
	            	valid_to_0002:valid_to_0002,
	            	first_name_0002:first_name_0002,
	            	last_name_0002:last_name_0002,
	            	nick_name_0002:nick_name_0002,
	            	gender_0002:gender_0002,
	            	birthdate_0002:birthdate_0002,
	            	nationality_0002:nationality_0002,
	            	religion_0002:religion_0002,
	            	marriage_status_0002:marriage_status_0002,
	            	valid_from_0007:valid_from_0007,
	            	valid_to_0007:valid_to_0007,
	            	ws_rule_0007:ws_rule_0007,
	            	valid_from_0008:valid_from_0008,
	            	valid_to_0008:valid_to_0008,
	            	reason_0008:reason_0008,
	            	personnel_type_0008:personnel_type_0008,
	            	personnel_area_0008:personnel_area_0008,
	            	personnel_level_0008:personnel_level_0008,
	            	personnel_group_0008:personnel_group_0008,
	            	wage_type_0008:wage_type_0008,
	            	wage_amount_0008:wage_amount_0008,
	            	valid_from_0009:valid_from_0009,
	            	valid_to_0009:valid_to_0009,
	            	payee_0009:payee_0009,
	            	payee_loc_0009:payee_loc_0009,
	            	bank_country_0009:bank_country_0009,
	            	bank_key_0009:bank_key_0009,
	            	bank_acc_0009:bank_acc_0009,
	            	payment_method_0009:payment_method_0009,
	            	purpose_0009:purpose_0009,
	            	payment_curr_0009:payment_curr_0009,
	            	task_type_0019:task_type_0019,
	            	date_of_task_0019:date_of_task_0019,
	            	proc_indicator_0019:proc_indicator_0019,
	            	reminder_date_0019:reminder_date_0019,
	            	valid_from_0021:valid_from_0021,
	            	valid_to_0021:valid_to_0021,
	            	member_0021:member_0021,
	            	name_0021:name_0021,
	            	gender_0021:gender_0021,
	            	birth_place_0021:birth_place_0021,
	            	date_of_birth_0021:date_of_birth_0021,
	            	valid_from_0022:valid_from_0022,
	            	valid_to_0022:valid_to_0022,
	            	education_est_0022:education_est_0022,
	            	institute_0022:institute_0022,
	            	country_key_0022:country_key_0022,
	            	certificate_0022:certificate_0022,
	            	final_grade_0022:final_grade_0022,
	            	branch_of_study_0022:branch_of_study_0022,
	            	subtype_0028:subtype_0028,
					examination_date_0028:examination_date_0028,
					result_0028:result_0028,
					examination_data_0028:examination_data_0028,
					area_0028:area_0028,
					specific_0028:specific_0028,
					date_type_0041:date_type_0041,
					date_0041:date_0041,
					valid_from_0051:valid_from_0051,
					valid_to_0051:valid_to_0051,
					type_rec_id_no_0051:type_rec_id_no_0051,
					valid_from_0185:valid_from_0185,
					valid_to_0185:valid_to_0185,
					id_type_0185:id_type_0185,
					id_number_0185:id_number_0185,
					author_0185:author_0185,
					date_of_issue_0185:valid_to_0185,
					valid_to1_0185:valid_to1_0185,
					place_issue_0185:place_issue_0185,
					country_issue_0185:country_issue_0185,
					valid_from_0241:valid_from_0241,
					valid_to_0241:valid_to_0241,
					personal_tax_id_0241:personal_tax_id_0241,
					npwp_regis_date_0241:npwp_regis_date_0241,
					number_of_dependents_0241:number_of_dependents_0241,
					married_for_tax_purpose_0241:married_for_tax_purpose_0241,
					spouse_benefit_0241:spouse_benefit_0241,
					valid_from_0242:valid_from_0242,
					valid_to_0242:valid_to_0242,
					identification_number_0242:identification_number_0242,
					married_for_jamsostek_purpose_0242:married_for_jamsostek_purpose_0242,
					valid_from_9005:valid_from_9005,
					valid_to_9005:valid_to_9005,
					bpjs_id_9005:bpjs_id_9005,
					class_code_9005:class_code_9005,
					faskes_tingkat_1_9005:faskes_tingkat_1_9005,
					number_tax_department_9005:number_tax_department_9005,
					category_2006:category_2006,
					quota_number_2006:quota_number_2006,
					deduct_from_2006:deduct_from_2006,
					deduct_to_2006:deduct_to_2006,
					start_from_2006:start_from_2006,
					start_to_2006:start_to_2006,
					valid_from_0105:valid_from_0105,
					valid_to_0105:valid_to_0105,
					user_type_0105:user_type_0105,
					user_id_0105:user_id_0105,
					password_0105:password_0105,
					valid_from_0006:valid_from_0006,
					valid_to_0006:valid_to_0006,
					address_type_0006:address_type_0006,
					street_number_0006:street_number_0006,
					second_address_line_0006:second_address_line_0006,
					district_0006:district_0006,
					city_0006:city_0006,
					postal_code_0006:postal_code_0006,
					region_0006:region_0006,
					country_0006:country_0006,
					phone_number_0006:phone_number_0006,
					comm_number_0006:comm_number_0006
	            }
	            ,
	            url      : "<?php echo base_url()?>Recruitment_listi/insertHiring",
	            success  : function(response){
	               		$('.isi').html(response)
	               }
	            });
		});
	// });