<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_model_listi extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Ess_model');
	
	}
	# Start Hiring Modal #
		function insertHiring($request_no,$applicant_no,$valid_from_0000,$valid_to_0000,$position_no_0000,$personnel_area_0000,$employee_subgroup_0000
			,$valid_from_0001,$valid_to_0001,$personnel_subarea_0001,$payroll_area_0001,$contract_0001
			,$valid_from_0002,$valid_to_0002,$first_name_0002,$last_name_0002,$nick_name_0002,$gender_0002,$birth_date_0002,$nationality_0002,$religion_0002,$marriage_status_0002,$birth_place_0002
			 ,$valid_from_0007, $valid_to_0007, $ws_rule_0007
			 ,$valid_from_0008, $valid_to_0008, $reason_0008, $personnel_type_0008, $personnel_area_0008, $personnel_group_0008, $personnel_level_0008, $wage_type_0008, $wage_ammount_0008
			 ,$valid_from_0009, $valid_to_0009, $payee_0009, $payee_loc_0009, $bank_country_0009, $bank_key_0009, $bank_acc_0009, $payment_method_0009, $purpose_0009, $payment_curr_0009
			 , $task_type_0019,$date_of_task_0019,$proc_indicator_0019,$reminder_date_0019
			 ,$valid_from_0021,$valid_to_0021,$member_0021,$name_0021,$gender_0021,$birth_place_0021,$date_of_birth_0021
			 ,$valid_from_0022,$valid_to_0022,$education_est_0022,$institute_0022,$country_key_0022,$certificate_0022,$final_grade_0022,$branch_of_study_0022
			 ,$subtype_0028,$examination_date_0028,$result_0028,$examination_data_0028,$area_0028,$specific_0028
			 ,$date_type_0041,$date_0041
			 ,$valid_from_0051,$valid_to_0051,$type_rec_id_no_0051
			 ,$valid_from_0185,$valid_to_0185,$id_type_0185,$id_number_0185,$author_0185,$date_of_issue_0185,$valid_to1_0185,$place_issue_0185,$country_issue_0185
			 ,$valid_from_0241,$valid_to_0241,$personal_tax_id_0241,$npwp_regis_date_0241,$number_of_dependents,$married_for_tax_purpose_0241,$spouse_benefit_0241
			 ,$valid_from_0242,$valid_to_0242,$identification_number_0242,$married_for_jamsostek_0242
			 ,$valid_from_9005,$valid_to_9005,$bpjs_id_9005,$class_code_9005,$faskes_tingkat_1_9005,$number_tax_department_9005
			 ,$category_2006,$quota_number_2006,$deduct_from_2006,$deduct_to_2006,$start_from_2006,$start_to_2006
			 ,$valid_from_0105,$valid_to_0105,$user_type_0105,$user_id_0105,$password_0105,$valid_from_0006
			 ,$valid_to_0006,$address_type_0006,$street_number_0006,$_2nd_address_line_0006,$district_0006,$city_0006,$postal_code_0006,$region_0006,$country_0006,$phone_number_0006,$comm_number_0006
			 ){
			$data = array(
					'request_no'=>$request_no,
			        'applicant_no' => $applicant_no,
			        '0000_valid_from' => $valid_from_0000,
			        '0000_valid_to' => $valid_to_0000,
			        '0000_position_no' => $position_no_0000,
			        '0000_personnel_area' => $personnel_area_0000,
			        '0000_employee_subgroup' => $employee_subgroup_0000,
			        '0001_valid_from' => $valid_from_0001,
			        '0001_valid_to' =>$valid_to_0001,
			        '0001_personnel_subarea'=>$personnel_subarea_0001,
			        '0001_payroll_area'=>$payroll_area_0001,
			        '0001_contract'=>$contract_0001,
			        '0002_valid_from'=>$valid_from_0002,
			        '0002_valid_to'=>$valid_to_0002,
			        '0002_first_name'=>$first_name_0002,
			        '0002_last_name'=>$last_name_0002,
			        '0002_nick_name'=>$nick_name_0002,
			        '0002_gender'=>$gender_0002,
			        '0002_birth_date'=>$birth_date_0002,
			        '0002_nationality'=>$nationality_0002,
			        '0002_religion'=>$religion_0002,
			        '0002_marriage_status'=>$marriage_status_0002,
			        '0002_birthplace'=>$birth_place_0002,
			        '0007_valid_from'=>$valid_from_0007,
			        '0007_valid_to'=>$valid_to_0007,
			        '0007_ws_rule'=>$ws_rule_0007,
			        '0008_valid_from'=>$valid_from_0008,
			        '0008_valid_to'=>$valid_to_0008,
			        '0008_reason'=>$reason_0008,
			        '0008_personnel_type'=>$personnel_type_0008,
			        '0008_personnel_area'=>$personnel_area_0008,
			        '0008_personnel_group'=>$personnel_group_0008,
			        '0008_personnel_level'=>$personnel_level_0008,
			        '0008_wage_type'=>$wage_type_0008,
			        '0008_wage_ammount'=>$wage_ammount_0008,
			        '0009_valid_from'=>$valid_from_0009,
			        '0009_valid_to'=>$valid_to_0009,
			        '0009_payee'=>$payee_0009,
			        '0009_payee_loc'=>$payee_loc_0009,
			        '0009_bank_country'=>$bank_country_0009,
			        '0009_bank_key'=>$bank_key_0009,
			        '0009_bank_acc'=>$bank_acc_0009,
			        '0009_payment_method'=>$payment_method_0009,
			        '0009_purpose'=>$purpose_0009,
			        '0009_payment_curr'=>$payment_curr_0009,
			        '0019_task_type'=>$task_type_0019,
			        '0019_date_of_task'=>$date_of_task_0019,
			        '0019_proc_indicator'=>$proc_indicator_0019,
			        '0019_reminder_date'=>$reminder_date_0019,
			        '0021_valid_from'=>$valid_from_0021,
			        '0021_valid_to'=>$valid_to_0021,
			        '0021_member'=>$member_0021,
			        '0021_name'=>$name_0021,
			        '0021_gender'=>$gender_0021,
			        '0021_birth_place'=>$birth_place_0021,
			        '0021_date_of_birth'=>$date_of_birth_0021,
			        '0022_valid_from'=>$valid_from_0022,
			        '0022_valid_to'=>$valid_to_0022,
			        '0022_education_est'=>$education_est_0022,
			        '0022_institute'=>$institute_0022,
			        '0022_country_key'=>$country_key_0022,
			        '0022_certificate'=>$certificate_0022,
			        '0022_final_grade'=>$final_grade_0022,
			        '0022_branch_of_study'=>$branch_of_study_0022,
			        '0028_subtype'=>$subtype_0028,
			        '0028_examination_date'=>$examination_date_0028,
			        '0028_result'=>$result_0028,
			        '0028_examination_data'=>$examination_data_0028,
			        '0028_area'=>$area_0028,
			        '0028_specific'=>$specific_0028,
			        '0041_date_type'=>$date_type_0041,
			        '0041_date'=>$date_0041,
			        '0051_valid_from'=>$valid_from_0051,
			        '0051_valid_to'=>$valid_to_0051,
			        '0051_type_rec_id_number'=>$type_rec_id_no_0051,
			        '0185_valid_from'=>$valid_from_0185,
			        '0185_valid_to'=>$valid_to_0185,
			        '0185_id_type'=>$id_type_0185,
			        '0185_id_number'=>$id_number_0185,
			        '0185_author'=>$author_0185,
			        '0185_date_of_issue'=>$date_of_issue_0185,
			        '0185_valid_to1'=>$valid_to1_0185,
			        '0185_place_issue'=>$place_issue_0185,
			        '0185_country_issue'=>$country_issue_0185,
			        '0241_valid_from'=>$valid_from_0241,
			        '0241_valid_to'=>$valid_to_0241,
			        '0241_personal_tax_id'=>$personal_tax_id_0241,
			        '0241_npwp_regis_date'=>$npwp_regis_date_0241,
			        '0241_number_of_dependents'=>$number_of_dependents,
			        '0241_married_for_tax_purpose'=>$married_for_tax_purpose_0241,
			        '0241_spouse_bennefit'=>$spouse_benefit_0241,
			        '0242_valid_from'=>$valid_from_0242,
			        '0242_valid_to'=>$valid_to_0242,
			        '0242_identification_number'=>$identification_number_0242,
			        '0242_married_for_jamsostek_purpose'=>$married_for_jamsostek_0242,
			        '9005_valid_from'=>$valid_from_9005,
			        '9005_valid_to'=>$valid_to_9005,
			        '9005_bpjs_id'=>$bpjs_id_9005,
			        '9005_class_code'=>$class_code_9005,
			        '9005_faskes_tingkat_1'=>$faskes_tingkat_1_9005,
			        '9005_number_tax_department'=>$number_tax_department_9005,
			        '2006_category'=>$category_2006,
			        '2006_quota_number'=>$quota_number_2006,
			        '2006_deduct_from'=>$deduct_from_2006,
			        '2006_deduct_to'=>$deduct_to_2006,
			        '2006_start_from'=>$start_from_2006,
			        '2006_start_to'=>$start_to_2006,
			        '0105_valid_from'=>$valid_from_0105,
			        '0105_valid_to'=>$valid_to_0105,
			        '0105_user_type'=>$user_type_0105,
			        '0105_user_id'=>$user_id_0105,
			        '0105_password'=>$password_0105,
			        '0006_valid_from'=>$valid_from_0006,
			        '0006_valid_to'=>$valid_to_0006,
			        '0006_address_type'=>$address_type_0006,
			        '0006_street_number'=>$street_number_0006,
			        '0006_2nd_address_line'=>$_2nd_address_line_0006,
			        '0006_district'=>$district_0006,
			        '0006_city'=>$city_0006,
			        '0006_postal_code'=>$postal_code_0006,
			        '0006_region'=>$region_0006,
			        '0006_country'=>$country_0006,
			        '0006_phone_number'=>$phone_number_0006,
			        '0006_comm_number'=>$comm_number_0006
			);

			$status = $this->db->replace('t_recruitment_hiring', $data);
			return $this->db->error();

		}
	# End Hiring Modal #
}