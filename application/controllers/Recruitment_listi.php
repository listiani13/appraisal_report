 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_listi extends CI_Controller {
	public function __construct()
	{
		# NOTE : DIS IS ONLI TEMPORERI #
		parent::__construct();
		// force sessions
		$this->request_model->force_sessions();
		$this->load->model('Recruitment_model_listi');
		$this->load->model('Recruitment_model');
		$this->load->model('Ess_model');
		$this->load->model('Request_model');
	}

	# START OF HIRING #
	function insertHiring(){
		$request_no = $_POST['request_no'];
		$applicant_no = $_POST['applicant_no'];
		// $action_type_0000 = $_POST['action_type_0000'];
		// $employee_group_0000 = $_POST['employee_group_0000'];
		/* FORM 0000 */
		$valid_from_0000 = strtotime($_POST['valid_from_0000']);
		$valid_from_0000 = date('Y-m-d',$valid_from_0000);
		$valid_to_0000 = strtotime($_POST['valid_to_0000']);
		$valid_to_0000 = date('Y-m-d',$valid_to_0000);
		$position_no_0000 = $_POST['position_no_0000'];
		$personnel_area_0000 = $_POST['personnel_area_0000'];
		$employee_subgroup_0000 = $_POST['employee_subgroup_0000'];

		/* FORM 0001 */
		$valid_from_0001 = strtotime($_POST['valid_from_0001']);
		$valid_from_0001 = date('Y-m-d',$valid_from_0001);
		$valid_to_0001 = strtotime($_POST['valid_to_0001']);
		$valid_to_0001 = date('Y-m-d',$valid_to_0001);
		$personnel_subarea_0001 = $_POST['personnel_area_0001'];
		$payroll_area_0001 = $_POST['payroll_area_0001'];
		$contract_0001 = $_POST['contract_0001'];

		/* FORM 0002 */
		$valid_from_0002 = strtotime($_POST['valid_from_0002']);
		$valid_from_0002 = date('Y-m-d',$valid_from_0002);
		$valid_to_0002 = strtotime($_POST['valid_to_0002']);
		$valid_to_0002 = date('Y-m-d',$valid_to_0002);
		$first_name_0002 = $_POST['first_name_0002'];
		$last_name_0002 = $_POST['last_name_0002'];
		$nick_name_0002 = $_POST['nick_name_0002'];
		$gender_0002 = $_POST['gender_0002'];
		$birth_date_0002 = strtotime($_POST['birthdate_0002']);
		$birth_date_0002 = date('Y-m-d',$birth_date_0002);
		$nationality_0002 = $_POST['nationality_0002'];
		$religion_0002 = $_POST['religion_0002'];
		$marriage_status_0002 = $_POST['marriage_status_0002'];
		$birth_place_0002 = $_POST['birthplace_0002'];

		/* FORM 0007 */
		$valid_from_0007 = strtotime($_POST['valid_from_0007']);
		$valid_from_0007 = date('Y-m-d',$valid_from_0007);
		$valid_to_0007 = strtotime($_POST['valid_to_0007']);
		$valid_to_0007 = date('Y-m-d',$valid_to_0007);
		$ws_rule_0007 =  $_POST['ws_rule_0007'];

		/* FORM 0008 */
		$valid_from_0008 = strtotime($_POST['valid_from_0008']);
		$valid_from_0008 = date('Y-m-d',$valid_from_0008);
		$valid_to_0008 = strtotime($_POST['valid_to_0008']);
		$valid_to_0008 = date('Y-m-d',$valid_to_0008);
		$reason_0008 = $_POST['reason_0008'];
		$personnel_type_0008 = $_POST['personnel_type_0008'];
		$personnel_area_0008 = $_POST['personnel_area_0008'];
		$personnel_group_0008 = $_POST['personnel_group_0008'];
		$personnel_level_0008 = $_POST['personnel_level_0008'];
		$wage_type_0008 = $_POST['wage_type_0008'];
		$wage_amount_0008 = $_POST['wage_amount_0008'];

		/* FORM 0009 */
		$valid_from_0009 = strtotime($_POST['valid_from_0009']);
		$valid_from_0009 = date('Y-m-d',$valid_from_0009);
		$valid_to_0009 = strtotime($_POST['valid_to_0009']);
		$valid_to_0009 = date('Y-m-d',$valid_to_0009);
		$payee_0009 = $_POST['payee_0009'];
		$payee_loc_0009 = $_POST['payee_loc_0009'];
		$bank_country_0009 = $_POST['bank_country_0009'];
		$bank_key_0009 = $_POST['bank_key_0009'];
		$bank_acc_0009 = $_POST['bank_acc_0009'];
		$payment_method_0009 = $_POST['payment_method_0009'];
		$purpose_0009 = $_POST['purpose_0009'];
		$payment_curr_0009 = $_POST['payment_curr_0009'];

		/* FORM 0019 */
		// `0019_task_type`, `0019_date_of_task`, `0019_proc_indicator`, `0019_reminder_date`, 
		$task_type_0019 = $_POST['task_type_0019'];
		$date_of_task_0019 = strtotime($_POST['date_of_task_0019']);
		$date_of_task_0019 = date('Y-m-d',$date_of_task_0019);
		$proc_indicator_0019 = $_POST['proc_indicator_0019'];
		$reminder_date_0019 = strtotime($_POST['reminder_date_0019']);
		$reminder_date_0019 = date('Y-m-d',$reminder_date_0019);

		
		/* FORM 0021 */
		$valid_from_0021 = strtotime($_POST['valid_from_0021']);
		$valid_from_0021 = date('Y-m-d',$valid_from_0021);
		$valid_to_0021 = strtotime($_POST['valid_to_0021']);
		$valid_to_0021 = date('Y-m-d',$valid_to_0021);
		$member_0021 = $_POST['member_0021'];
		$name_0021 = $_POST['name_0021'];
		$gender_0021 = $_POST['gender_0021'];
		$birth_place_0021 = $_POST['birth_place_0021'];
		$date_of_birth_0021 = strtotime($_POST['date_of_birth_0021']);
		$date_of_birth_0021 = date('Y-m-d',$date_of_birth_0021);
		
		/* FORM 0022 */
		$valid_from_0022 = strtotime($_POST['valid_from_0022']);
		$valid_from_0022 = date('Y-m-d',$valid_from_0022);
		$valid_to_0022 = strtotime($_POST['valid_to_0022']);
		$valid_to_0022 = date('Y-m-d',$valid_to_0022);
		$education_est_0022 = $_POST['education_est_0022'];
		$institute_0022 = $_POST['institute_0022'];
		$country_key_0022 = $_POST['country_key_0022'];
		$certificate_0022 = $_POST['certificate_0022'];
		$final_grade_0022 = $_POST['final_grade_0022'];
		$branch_of_study_0022 = $_POST['branch_of_study_0022'];
		
		/* FORM 0028 */
		$subtype_0028 = $_POST['subtype_0028'];
		$examination_date_0028 = strtotime($_POST['examination_date_0028']);
		$examination_date_0028 = date('Y-m-d',$examination_date_0028);
		$result_0028 = $_POST['result_0028'];
		$examination_data_0028 = $_POST['examination_data_0028'];
		$area_0028 = $_POST['area_0028'];
		$specific_0028 = $_POST['specific_0028'];

		/* FORM 0041 */
		$date_type_0041 = $_POST['date_type_0041'];
		$date_0041 = strtotime($_POST['date_0041']);
		$date_0041 = date('Y-m-d',$date_0041);

		/* FORM 0051*/
		$valid_from_0051 = strtotime($_POST['valid_from_0051']);
		$valid_from_0051 = date('Y-m-d',$valid_from_0051);
		$valid_to_0051 = strtotime($_POST['valid_to_0051']);
		$valid_to_0051 = date('Y-m-d',$valid_to_0051);
		$type_rec_id_no_0051 = $_POST['type_rec_id_no_0051'];

		/* FORM 0185 */
		$valid_from_0185 = strtotime($_POST['valid_from_0185']);
		$valid_from_0185 = date('Y-m-d',$valid_from_0185);
		$valid_to_0185 = strtotime($_POST['valid_to_0185']);
		$valid_to_0185 = date('Y-m-d',$valid_to_0185);
		$id_type_0185 = $_POST['id_type_0185'];
		$id_number_0185 = $_POST['id_number_0185'];
		$author_0185 = $_POST['author_0185'];
		$date_of_issue_0185 = strtotime($_POST['date_of_issue_0185']);
		$date_of_issue_0185 = date('Y-m-d',$date_of_issue_0185);
		$valid_to1_0185 = strtotime($_POST['valid_to1_0185']);
		$valid_to1_0185 = date('Y-m-d',$valid_to1_0185);
		$place_issue_0185 = $_POST['place_issue_0185'];
		$country_issue_0185 = $_POST['country_issue_0185'];

		/* FORM 0241 */
		$valid_from_0241 = strtotime($_POST['valid_from_0241']);
		$valid_from_0241 = date('Y-m-d',$valid_from_0241);
		$valid_to_0241 = strtotime($_POST['valid_to_0241']);
		$valid_to_0241 = date('Y-m-d',$valid_to_0241);
		$personal_tax_id_0241 = $_POST['personal_tax_id_0241'];
		$npwp_regis_date_0241 = strtotime($_POST['npwp_regis_date_0241']);
		$npwp_regis_date_0241 = date('Y-m-d',$npwp_regis_date_0241);
		$number_of_dependents_0241 = $_POST['number_of_dependents_0241'];
		$married_for_tax_purpose_0241 = $_POST['married_for_tax_purpose_0241'];
		$spouse_benefit_0241 = $_POST['spouse_benefit_0241'];
		
		/* FORM 0242 */
		$valid_from_0242 = strtotime($_POST['valid_from_0242']);
		$valid_from_0242 = date('Y-m-d',$valid_from_0242);
		$valid_to_0242 = strtotime($_POST['valid_to_0242']);
		$valid_to_0242 = date('Y-m-d',$valid_to_0242);
		$identification_number_0242 = $_POST['identification_number_0242'];
		$married_for_jamsostek_0242 = $_POST['married_for_jamsostek_purpose_0242'];

		/* FORM 9005 */
		$valid_from_9005 = strtotime($_POST['valid_from_9005']);
		$valid_from_9005 = date('Y-m-d',$valid_from_9005);
		$valid_to_9005 = strtotime($_POST['valid_to_9005']);
		$valid_to_9005 = date('Y-m-d',$valid_to_9005);
		$bpjs_id_9005 = $_POST['bpjs_id_9005'];
		$class_code_9005 = $_POST['class_code_9005'];
		$faskes_tingkat_1_9005 = $_POST['faskes_tingkat_1_9005'];
		$number_tax_department_9005 = $_POST['number_tax_department_9005'];

		/* FORM 2006 */
		$category_2006 = $_POST['category_2006'];
		$quota_number_2006 = $_POST['quota_number_2006'];
		$deduct_from_2006 = strtotime($_POST['deduct_from_2006']);
		$deduct_from_2006 = date('Y-m-d',$deduct_from_2006);
		$deduct_to_2006 = strtotime($_POST['deduct_to_2006']);
		$deduct_to_2006 = date('Y-m-d',$deduct_to_2006);
		$start_from_2006 = strtotime($_POST['start_from_2006']);
		$start_from_2006 = date('Y-m-d',$start_from_2006);
		$start_to_2006 = strtotime($_POST['start_to_2006']);
		$start_to_2006 = date('Y-m-d',$start_to_2006);

		/* FORM 0006 */
		$valid_from_0006 = strtotime($_POST['valid_from_0006']);
		$valid_from_0006 = date('Y-m-d',$valid_from_0006);
		$valid_to_0006 = strtotime($_POST['valid_to_0006']);
		$valid_to_0006 = date('Y-m-d',$valid_to_0006);
		$address_type_0006 = $_POST['address_type_0006'];
		$street_number_0006 = $_POST['street_number_0006'];
		$_2nd_address_line_0006 = $_POST['second_address_line_0006'];
		$district_0006 = $_POST['district_0006'];
		$city_0006 = $_POST['city_0006'];
		$postal_code_0006 = $_POST['postal_code_0006'];
		$region_0006 = $_POST['region_0006'];
		$country_0006 = $_POST['country_0006'];
		$phone_number_0006 = $_POST['phone_number_0006'];
		$comm_number_0006 = $_POST['comm_number_0006'];

		/* FORM 0105 */
		$valid_from_0105 = strtotime($_POST['valid_from_0105']);
		$valid_from_0105 = date('Y-m-d',$valid_from_0105);
		$valid_to_0105 = strtotime($_POST['valid_to_0105']);
		$valid_to_0105 = date('Y-m-d',$valid_to_0105);
		$user_type_0105 = $_POST['user_type_0105'];
		$user_id_0105 = $_POST['user_id_0105'];
		$password_0105 = $_POST['password_0105'];

		$statusInsert = $this->Recruitment_model_listi->insertHiring($request_no,$applicant_no,$valid_from_0000,$valid_to_0000,$position_no_0000,$personnel_area_0000,$employee_subgroup_0000
			,$valid_from_0001,$valid_to_0001,$personnel_subarea_0001,$payroll_area_0001,$contract_0001
			,$valid_from_0002,$valid_to_0002,$first_name_0002,$last_name_0002,$nick_name_0002,$gender_0002,$birth_date_0002,$nationality_0002,$religion_0002,$marriage_status_0002,$birth_place_0002
			 ,$valid_from_0007, $valid_to_0007, $ws_rule_0007
			 ,$valid_from_0008, $valid_to_0008, $reason_0008, $personnel_type_0008, $personnel_area_0008, $personnel_group_0008, $personnel_level_0008, $wage_type_0008, $wage_amount_0008
			 ,$valid_from_0009, $valid_to_0009, $payee_0009, $payee_loc_0009, $bank_country_0009, $bank_key_0009, $bank_acc_0009, $payment_method_0009, $purpose_0009, $payment_curr_0009
			 , $task_type_0019,$date_of_task_0019,$proc_indicator_0019,$reminder_date_0019
			 ,$valid_from_0021,$valid_to_0021,$member_0021,$name_0021,$gender_0021,$birth_place_0021,$date_of_birth_0021
			 ,$valid_from_0022,$valid_to_0022,$education_est_0022,$institute_0022,$country_key_0022,$certificate_0022,$final_grade_0022,$branch_of_study_0022,$subtype_0028,$examination_date_0028,$result_0028,$examination_data_0028,$area_0028,$specific_0028,$date_type_0041,$date_0041,$valid_from_0051,$valid_to_0051,$type_rec_id_no_0051,$valid_from_0185,$valid_to_0185,$id_type_0185,$id_number_0185,$author_0185,$date_of_issue_0185,$valid_to1_0185,$place_issue_0185,$country_issue_0185,$valid_from_0241,$valid_to_0241,$personal_tax_id_0241,$npwp_regis_date_0241,$number_of_dependents_0241,$married_for_tax_purpose_0241,$spouse_benefit_0241,$valid_from_0242,$valid_to_0242,$identification_number_0242,$married_for_jamsostek_0242,$valid_from_9005,$valid_to_9005,$bpjs_id_9005,$class_code_9005,$faskes_tingkat_1_9005,$number_tax_department_9005,$category_2006,$quota_number_2006,$deduct_from_2006,$deduct_to_2006,$start_from_2006,$start_to_2006,$valid_from_0105,$valid_to_0105,$user_type_0105,$user_id_0105,$password_0105,$valid_from_0006,$valid_to_0006,$address_type_0006,$street_number_0006,$_2nd_address_line_0006,$district_0006,$city_0006,$postal_code_0006,$region_0006,$country_0006,$phone_number_0006,$comm_number_0006);
		// var_dump($statusInsert);
		// echo $statusInsert['message'];
		if ($statusInsert['message']=='') {
			echo "<div class='alert alert-success alerting'><strong>Success!</strong> The data has been inserted.</div>";
		}
		else{
			echo "<div class='alert alert-danger alerting'>".$statusInsert['message']."</div>";
		}
	}

	# END OF HITING #

	public function selectHiring()
	{
		$applicantNo=$_POST['applicantNo'];
		//$applicantNo=(String)'00000021';

		$data=$this->Recruitment_model->selectHiring($applicantNo);
		if($data!=NULL){
			$data['0000_valid_from']=$this->convertStringToDate($data['0000_valid_from']);
			$data['0001_valid_from'] = $this->convertStringToDate($data['0001_valid_from']);
			$data['0002_valid_from'] = $this->convertStringToDate($data['0002_valid_from']);
			$data['0007_valid_from'] = $this->convertStringToDate($data['0007_valid_from']);
			$data['0008_valid_from'] = $this->convertStringToDate($data['0008_valid_from']);
			$data['0009_valid_from'] = $this->convertStringToDate($data['0009_valid_from']);
			$data['0021_valid_from'] = $this->convertStringToDate($data['0021_valid_from']);
			$data['0022_valid_from'] = $this->convertStringToDate($data['0022_valid_from']);
			$data['0051_valid_from'] = $this->convertStringToDate($data['0051_valid_from']);
			$data['0185_valid_from'] = $this->convertStringToDate($data['0185_valid_from']);
			$data['0241_valid_from'] = $this->convertStringToDate($data['0241_valid_from']);
			$data['0242_valid_from'] = $this->convertStringToDate($data['0242_valid_from']);
			$data['9005_valid_from'] = $this->convertStringToDate($data['9005_valid_from']);
			$data['0006_valid_from'] = $this->convertStringToDate($data['0006_valid_from']);
			$data['0105_valid_from'] = $this->convertStringToDate($data['0105_valid_from']);
			$data['0000_valid_to'] = $this->convertStringToDate($data['0000_valid_to']);
			$data['0001_valid_to'] = $this->convertStringToDate($data['0001_valid_to']);
			$data['0002_valid_to'] = $this->convertStringToDate($data['0002_valid_to']);
			$data['0007_valid_to'] = $this->convertStringToDate($data['0007_valid_to']);
			$data['0008_valid_to'] = $this->convertStringToDate($data['0008_valid_to']);
			$data['0009_valid_to'] = $this->convertStringToDate($data['0009_valid_to']);
			$data['0021_valid_to'] = $this->convertStringToDate($data['0021_valid_to']);
			$data['0022_valid_to'] = $this->convertStringToDate($data['0022_valid_to']);
			$data['0051_valid_to'] = $this->convertStringToDate($data['0051_valid_to']);
			$data['0185_valid_to'] = $this->convertStringToDate($data['0185_valid_to']);
			$data['0241_valid_to'] = $this->convertStringToDate($data['0241_valid_to']);
			$data['0242_valid_to'] = $this->convertStringToDate($data['0242_valid_to']);
			$data['9005_valid_to'] = $this->convertStringToDate($data['9005_valid_to']);
			$data['0006_valid_to'] = $this->convertStringToDate($data['0006_valid_to']);
			$data['0105_valid_to'] = $this->convertStringToDate($data['0105_valid_to']);
			$data['0002_birth_date'] = $this->convertStringToDate($data['0002_birth_date']);
			$data['0019_date_of_task'] = $this->convertStringToDate($data['0019_date_of_task']);
			$data['0019_reminder_date'] = $this->convertStringToDate($data['0019_reminder_date']);
			$data['0021_date_of_birth'] = $this->convertStringToDate($data['0021_date_of_birth']);
			$data['0028_examination_date'] = $this->convertStringToDate($data['0028_examination_date']);
			$data['0041_date_type'] = $this->convertStringToDate($data['0041_date_type']);
			$data['0185_date_of_issue'] =  $this->convertStringToDate($data['0185_date_of_issue']);
			$data['0185_valid_to1'] = $this->convertStringToDate($data['0185_valid_to1']);
			$data['0241_npwp_regis_date'] = $this->convertStringToDate($data['0241_npwp_regis_date']);
			$data['0241_married_for_tax_purpose'] = $this->convertStringToDate($data['0241_married_for_tax_purpose']);
			$data['2006_deduct_from'] = $this->convertStringToDate($data['2006_deduct_from']);
			$data['2006_deduct_to'] = $this->convertStringToDate($data['2006_deduct_to']);
			$data['2006_start_from'] = $this->convertStringToDate($data['2006_start_from']);
			$data['2006_start_to'] = $this->convertStringToDate($data['2006_start_to']);
		} else {
			$data = array();
		}
		$data2=$this->Recruitment_model->selectHiring2($applicantNo);
		if($data==NULL){
		if($data2!=NULL){
			$data['0002_first_name']=$data2['name'];
			$data['0002_birth_date']=$data2['dob'];
			$data['0006_city']=$data2['city'];
			$data['0006_country']='Indonesia';
			$data['0006_phone_number']=$data2['phone'];
		}
		$data3=$this->Recruitment_model->selectHiring3($applicantNo);
		if($data3!=NULL){
			$data['0002_first_name']=$data3['name'];
			$data['0002_nick_name']=$data3['nickname'];
			$data['0002_gender']=strtolower($data3['gender']);
			$data['0002_birthplace']=$data3['place_of_birth'];
			$data['0002_birth_date']=$data3['date_of_birth'];
			$data['0002_religion']=$data3['religion'];
			$data['0002_marriage_status']=$data3['marital_status'];

			$data['0021_name']=$data3['name'];
			$data['0021_gender']=strtolower($data3['gender']);
			$data['0021_birth_place']=$data3['place_of_birth'];
			$data['0021_date_of_birth']=$data3['date_of_birth'];

			$data['0241_personal_tax_id']=$data3['npwp_number'];

			$data['0006_city']=$data3['city'];
			$data['0006_postal_code']=$data3['zip_code'];
			$data['0006_country']='Indonesia';
			$data['0006_phone_number']=$data3['phone_number'];
			$data['0006_comm_number']=$data3['mobile_number'];
		}
	}

		echo json_encode($data) ;
	}

	public function convertStringToDate($var)
	{
		$var = strtotime($var);
		$var = date('D, d.m.Y',$var);
		return $var;
	}
}
