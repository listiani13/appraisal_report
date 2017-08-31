<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Ess_model');
	
	}
	public function force_sessions_recruitment() {
		// $email = 'desti.hapsari@dynapackasia.com';
		// $email = 'TRIMURTI.HANDAYANI@DYNAPACKASIA.COM';
		//$email = 'BUDHI.TJAHYONO@DYNAPACKASIA.COM';
		//$email = 'MERCIA.NATIO@DYNAPACKASIA.COM';
		$email = 'EVELINE.HARTONO@DYNAPACKASIA.COM';
		//$email = 'EMMELINE.HAMBALI@DYNAPACKASIA.COM';
		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
	}

	public function selectHiring($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_hiring');
		$result = $query->row_array();
		return $result;	
	}

	public function selectHiring2($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_basic');
		$result = $query->row_array();
		return $result;	

	}
	
	public function selectHiring3($applicantNo){
		//$query = $this->db->where('applicant_no',$applicantNo)
						   //->get('t_recruitment_detail');
		$query=$this->db->query("SELECT * FROM t_recruitment_detail WHERE applicant_no='$applicantNo'");
		$result = $query->row_array();
		return $result;	
		//return $this->db->error();
	}

	public function hrd_status($pernr){
		$sql = "SELECT * FROM  `m_approval_user` WHERE ( code = 'HRP' OR code = 'RG' ) AND target = '$pernr'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			return true;
		}
	}

	public function select_reqno(){
		$query = $this->db->query("SELECT request_no,plant,department,position FROM t_request_general WHERE request_no IN (SELECT request_no FROM t_request_approval WHERE approval_code = 'CL' AND status = '')");
		$result = $query->result_array();
		foreach ($result as $key=>$value) {
			$result[$key]['department_desc'] = $this->Ess_model->get_department($value['plant'],$value['department']);
		}
		return $result;
	}

	public function select_all(){
		$query =$this->db->distinct('applicant_no,name')
							->get('t_recruitment_detail');
		$result = $query->result_array();
		return $result;
	}



	public function select_all2(){
		$query =$this->db->distinct('applicant_no,name')
							->get('t_recruitment_basic');
		$result = $query->result_array();
		return $result;
	}

	public function searchApp1($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail');
		$result = $query->row();
		return $result;	
	}

	public function searchApp2($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_education_background');
		$result = $query->result_array();
		return $result;	
	}

	public function searchApp3($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_course_training');
		$result = $query->result_array();
		return $result;	
	}

	public function searchApp4($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_education_achievement');
		$result = $query->result_array();
		return $result;	
	}

	public function searchApp5($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_education_information');
		$result = $query->row();
		return $result;	
	}

	public function searchApp6($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_education_language');
		$result = $query->result_array();
		return $result;	
	}

	public function searchApp7($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_social_other_activity');
		$result = $query->row();
		return $result;	
	}

	public function searchApp8($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_social_organization');
		$result = $query->result_array();
		return $result;	
	}

	public function searchApp9($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_family_structure');
		$result = $query->row();
		return $result;	
	}

	public function searchApp10($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_family_structure_siblings');
		$result = $query->result_array();
		return $result;	
	}

	public function searchApp11($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_family_structure_child');
		$result = $query->result_array();
		return $result;	
	}

	public function searchApp12($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_employement_history');
		$result = $query->row();
		return $result;	
	}

	public function searchApp13($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_other_information');
		$result = $query->row();
		return $result;	
	}

	public function searchApp14($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_detail_others');
		$result = $query->row();
		return $result;	
	}
	public function searchApp15($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_basic_assign');
		$result = $query->result_array();
		return $result;	
	}

	public function searchBasic($applicantNo){
		$query = $this->db->where('applicant_no',$applicantNo)
						   ->get('t_recruitment_basic');
		$result = $query->row();
		return $result;	
	}

	public function deletedata($applicantNo){
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_course_training');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_education_achievement');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_education_background');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_education_information');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_education_language');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_employement_history');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_family_structure');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_family_structure_child');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_family_structure_siblings');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_others');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_other_information');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_social_organization');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_detail_social_other_activity');
		$this->db->where('applicant_no',$applicantNo)
				 ->delete('t_recruitment_basic_assign');
	}

	public function getNewRequestId(){
		/*
		$year = date('y');
		$month = date('m');
		$lastOldReqNo = $this->db->select('max(applicant_no) as applicant_no')
							     ->from('t_recruitment_basic')
							     ->like('applicant_no', $year.$month)
						         ->get()->row_array()['applicant_no'];
		$newReqNo = "";
		if(isset($lastOldReqNo)){
			$newReqNo = $lastOldReqNo + 1;
		} else {
			$newReqNo = $year.$month."0001";
		}
		return $newReqNo;
		*/
		$lastOldReqNo = $this->db->select('max(applicant_no) as applicant_no')
							     ->from('t_recruitment_basic')
						         ->get()->row_array()['applicant_no'];
		$newReqNo = "";
		if(isset($lastOldReqNo)){
			$newReqNo = $lastOldReqNo + 1;
		} else {
			$newReqNo = 1;
		}
		return str_pad($newReqNo, 8, '0', STR_PAD_LEFT);
	}

	public function insert_recruitment($applicant_no,$name,$address,$city,$dob,$phone,$email,$university,$major,$gpa,$createdby,$lastchangedby){
		$data = array(
	        'applicant_no' => $applicant_no,
	        'name' => $name,
	        'address'=>$address,
	        'city'=>$city,
	        'dob'=>$dob,
	        'phone'=>$phone,
	        'email'=>$email,
	        'university'=>$university,
	        'major'=>$major,
	        'gpa'=>$gpa,
	        'created_by'=>$createdby,
	        'last_changed_by'=>$lastchangedby
		);
		$this->db->insert('t_recruitment_basic', $data);
		return $this->db->error();
	}

	public function insert_experience ($applicant_no,$item_no,$experience,$year_from,$year_to){
		$data = array(
				'applicant_no' => $applicant_no,
				'item_no' => $item_no,
				'experience' => $experience,
				'year_from' => $year_from,
				'year_to' => $year_to
			);
		$this->db->insert('t_recruitment_basic_experience', $data);
	}
	public function insert_basic_assign($applicant_no,$request_no){
		$data = array(
				'applicant_no' => $applicant_no,
				'request_no' => $request_no
			);
		$this->db->insert('t_recruitment_basic_assign', $data);
	}

	public function getNewRequestIdPersonal(){
		$year = date('y');
		$month = date('m');
		$lastOldReqNo = $this->db->select('max(applicant_no) as applicant_no')
							     ->from('t_recruitment_detail')
							     ->like('applicant_no', $year.$month)
						         ->get()->row_array()['applicant_no'];
		$newReqNo = "";
		if(isset($lastOldReqNo)){
			$newReqNo = $lastOldReqNo + 1;
		} else {
			$newReqNo = $year.$month."0001";
		}
		return $newReqNo;
	}

	public function insert_personal_data($applicant_no,$name,$nickname,$gender,$address1,$address2,$city,$zip,$phone,$mobile,$office,$place,$dob,$email,$email2,$religion,$marital,$ktp,$npwp){
		$data = array(
				'applicant_no'=>$applicant_no,
				'name'=>$name,
				'nickname'=>$nickname,
				'gender'=>$gender,
				'address'=>$address1,
				'address2'=>$address2,
				'city'=>$city,
				'zip_code'=>$zip,
				'phone_number'=>$phone,
				'mobile_number'=>$mobile,
				'office_number'=>$office,
				'place_of_birth'=>$place,
				'date_of_birth'=>$dob,
				'email'=>$email,
				'email_alt'=>$email2,
				'religion'=>$religion,
				'marital_status'=>$marital,
				'ktp_number'=>$ktp,
				'npwp_number'=>$npwp
			);

		$this->db->replace('t_recruitment_detail', $data);
		return $this->db->error();
		$data = array(
				'applicant_no'=>$applicant_no,
				'name'=>$name
			);
		$sql = "SELECT * FROM t_recruitment_basic WHERE `applicant_no` = '".$applicant_no."'";
		$kueri = $this->db->query($sql);
		if ($kueri->num_rows() > 0) {
			$this->db->query("UPDATE t_recruitment_basic SET `name` = '".$name."' WHERE `applicant_no` = '".$applicant_no."'");
		}
		return $this->db->error();
	}

	public function insert_education_background($applicant_no,$item_no,$level,$institution,$city,$major,$gpa,$date){
		$data = array(
				'applicant_no'=>$applicant_no,
				'item_no'=>$item_no,
				'education_level'=>$level,
				'institution'=>$institution,
				'city'=>$city,
				'major'=>$major,
				'gpa'=>$gpa,
				'end_date'=>$date				
			);
		$this->db->insert('t_recruitment_detail_education_background',$data);
	}

	public function insert_education_information_language($applicant_no,$item_no,$language,$speaking,$writing,$reading){
		$data = array(
				'applicant_no'=>$applicant_no,
				'item_no'=>$item_no,
				'language'=>$language,
				'speaking_skill'=>$speaking,
				'writing_skill'=>$writing,
				'reading_skill'=>$reading				
			);
		$this->db->insert('t_recruitment_detail_education_language',$data);
	}

	public function insert_course_training($applicant_no,$item_no,$activity,$organizer,$year,$duration,$certificate){
		$data = array(
				'applicant_no'=>$applicant_no,
				'item_no'=>$item_no,
				'activity'=>$activity,
				'organizer'=>$organizer,
				'year'=>$year,
				'duration'=>$duration,
				'certificate'=>$certificate				
			);
		$this->db->insert('t_recruitment_detail_course_training',$data);
	}

	public function insert_education_information($applicant_no,$funder,$sciencePaper,$englishstatus,$yearb,$institution,$score){
		$data = array(
				'applicant_no'=>$applicant_no,
				'funder'=>$funder,
				'scientific_paper'=>$sciencePaper,
				'english_test_status'=>$englishstatus,
				'year_taken'=>$yearb,
				'institution'=>$institution,
				'score'=>$score	
			);

		$this->db->insert('t_recruitment_detail_education_information',$data);
		return $this->db->error();

	}

	public function insert_education_information_achievement($t_achievement){
			foreach ($t_achievement as $key) {
			$this->db->insert('t_recruitment_detail_education_achievement',$key);
		}
		
	}

	public function insert_education_achievement($applicant_no,$item_no,$achievementdetails,$yeara){
		$data = array(
				'applicant_no'=>$applicant_no,
				'item_no'=>$item_no,
				'achievement_details'=>$achievementdetails,
				'year'=>$yeara,
			);
		$this->db->insert('t_recruitment_detail_education_achievement',$data);
	}

	
	public function insert_social_activity($applicant_no,$hobby,$newspaper,$topic){
		$data = array(
				'applicant_no'=>$applicant_no,
				'hobby'=>$hobby,
				'newspaper_magazine'=>$newspaper,
				'preferred_topic'=>$topic,
			);
		$this->db->insert('t_recruitment_detail_social_other_activity',$data);
	}

	public function insert_social_organization($t_organization){
		foreach ($t_organization as $key) {
		$this->db->insert('t_recruitment_detail_social_organization',$key);
	}
	}

	public function insert_social_organization1($applicant_no,$item_no,$name_organization,$place,$position,$duration){
		$data = array(
				'applicant_no'=>$applicant_no,
				'item_no'=>$item_no,
				'name_organization'=>$name_organization,
				'place'=>$place,
				'position'=>$position,
				'duration'=>$duration
			);
		$this->db->insert('t_recruitment_detail_social_organization',$data);
	}

	public function insert_family_structure($applicant_no,$ownership,$childorder,$totalchild,$fname,$fplace,$fdob,$feducation,$fjob,$mname,$mplace,$mdob,$meducation,$mjob,$faddress1,$faddress2,$fCity,$fZip,$fPhone,$fhome,$fhome2,$spname,$spplace,$spdob,$speducation,$spjob,$flawname,$flawplace,$flawdob,$flaweducation,$flawjob,$mlawname,$mlawplace,$mlawdob,$mlaweducation,$mlawjob,$flawadd1,$flawadd2,$flawCity,$flawZip,$flawPhone,$flawhome,$flawhome2,$othername,$otheradd1,$otheradd2,$otherCity,$otherZip,$otherPhone,$otherhome,$otherhome2){
		
		$data = array(
				'applicant_no'=>$applicant_no,
				'ownership_status'=>$ownership,
				'family_order'=>$childorder,
				'number_of_siblings'=>$totalchild,
				'father_name'=>$fname,
				'father_place_of_birth'=>$fplace,
				'father_date_of_birth'=>$fdob,
				'father_education'=>$feducation,
				'father_occupation'=>$fjob,
				'mother_name'=>$mname,
				'mother_place_of_birth'=>$mplace,
				'mother_date_of_birth'=>$mdob,
				'mother_education'=>$meducation,
				'mother_occupation'=>$mjob,
				'address'=>$faddress1,
				'address2'=>$faddress2,
				'city'=>$fCity,
				'zipcode'=>$fZip,
				'phone_number'=>$fPhone,
				'home_number'=>$fhome,
				'home_number_alt'=>$fhome2,
				'spouse_name'=>$spname,
				'spouse_place_of_birth'=>$spplace,
				'spouse_date_of_birth'=>$spdob,
				'spouse_education'=>$speducation,
				'spuse_ocupation'=>$spjob,
				'father_law_name'=>$flawname,
				'father_law_place_of_birth'=>$flawplace,
				'father_law_date_of_birth'=>$flawdob,
				'father_law_education'=>$flaweducation,
				'father_law_occupation'=>$flawjob,
				'mother_law_name'=>$mlawname,
				'mother_law_place_of_birth'=>$mlawplace,
				'mother_law_date_of_birth'=>$mlawdob,
				'mother_law_education'=>$mlaweducation,
				'mother_law_occupation'=>$mlawjob,
				'law_address'=>$flawadd1,
				'law_address2'=>$flawadd2,
				'law_city'=>$flawCity,
				'law_zipcode'=>$flawZip,
				'law_phone_number'=>$flawPhone,
				'law_home_number'=>$flawhome,
				'law_home_number_alt'=>$flawhome2,
				'other_name'=>$othername,
				'other_address'=>$otheradd1,
				'other_address2'=>$otheradd2,
				'other_city'=>$otherCity,
				'other_zipcode'=>$otherZip,
				'other_phone_number'=>$otherPhone,
				'other_home_number'=>$otherhome,
				'other_home_number_alt'=>$otherhome2
			);
		$this->db->insert('t_recruitment_detail_family_structure',$data);
		return $this->db->error();

	}

	public function insert_family_siblings($t_sibling){
		foreach ($t_sibling as $key) {
					$this->db->insert('t_recruitment_detail_family_structure_siblings',$key);
			}
	}

	public function insert_family_child($t_child){
		foreach ($t_child as $key) {
		$this->db->insert('t_recruitment_detail_family_structure_child',$key);
	}

	}

	public function insert_employement_history($applicant_no,$namec1,$addc1,$phonec1,$snamec1,$sposc1,$posc1,$typec1,$startc1,$endc1,$suborc1,$salc1,$benc1,$fac1,$reason1,$namec2,$addc2,$phonec2,$snamec2,$sposc2,$posc2,$typec2,$startc2,$endc2,$suborc2,$salc2,$benc2,$fac2,$reason2,$achievementc1,$careerc1){
		$data = array(
				'applicant_no'=>$applicant_no,
				'company_name'=>$namec1,
				'company_address'=>$addc1,
				'company_phone_number'=>$phonec1,
				'company_superior_name'=>$snamec1,
				'company_superior_position'=>$sposc1,
				'company_position'=>$posc1,
				'company_type_of_work'=>$typec1,
				'company_date_begin_worked'=>$startc1,
				'company_date_end_worked'=>$endc1,
				'company_number_subordinates'=>$suborc1,
				'company_current_salary'=>$salc1,
				'company_benefit'=>$benc1,
				'company_facilites'=>$fac1,
				'company_reason_resign'=>$reason1,
				'company2_name'=>$namec2,
				'company2_address'=>$addc2,
				'company2_phone_number'=>$phonec2,
				'company2_superior_name'=>$snamec2,
				'company2_superior_position'=>$sposc2,
				'company2_position'=>$posc2,
				'company2_type_of_work'=>$typec2,
				'company2_date_begin_worked'=>$startc2,
				'company2_date_end_worked'=>$endc2,
				'company2_number_subordinates'=>$suborc2,
				'company2_current_salary'=>$salc2,
				'company2_benefit'=>$benc2,
				'company2_facilites'=>$fac2,
				'company2_reason_resign'=>$reason2,
				'achievement_during_work'=>$achievementc1,
				'career_objective'=>$careerc1
			);
	
		$this->db->insert('t_recruitment_detail_employement_history',$data);
	}

	public function insert_other_information($applicant_no,$dyna,$yposition,$yreason,$yhow,$workplace,$workplacereason,$ysal,$yben,$yfac,$threemonth,$oneyear,$assigncity,$locatecity){
		$data = array(
				'applicant_no'=>$applicant_no,
				'worked_at_dynaplast_status'=>$dyna,
				'position_applied'=>$yposition,
				'reason_applying'=>$yreason,
				'where_find_information'=>$yhow,
				'prefered_workplace'=>$workplace,
				'reason_workplace'=>$workplacereason,
				'expected_salary'=>$ysal,
				'expected_benefit'=>$yben,
				'expected_facilities'=>$yfac,
				'willing_probation'=>$threemonth,
				'willing_in_contract'=>$oneyear,
				'willing_move_city'=>$assigncity,
				'willing_locate_city'=>$locatecity
			);
		$this->db->replace('t_recruitment_detail_other_information',$data);
		return $this->db->error();
	}

	public function insert_others($applicant_no,$workcust,$namecust,$worksub,$namesub,$diseasestat,$diseasename,$diseaseyear,$accidentstat,$accidentname,$accidentyear,$accidentcause,$glass,$smoke,$bloodtype,$vehicletype,$owner,$license,$acknowledge1,$relation,$namer1,$posr1,$comr1,$addr1,$telr1,$relr1,$namer2,$posr2,$comr2,$addr2,$telr2,$relr2,$contact,$readywork){
		$data = array(
				'applicant_no'=>$applicant_no,
				'contacted_supplier_customer'=>$workcust,
				'name_customer_supplier'=>$namecust,
				'contacted_subsidiaries_affiliation'=>$worksub,
				'name_subsidiaries_affiliations'=>$namesub,
				'disease_status'=>$diseasestat,
				'disease_name'=>$diseasename,
				'disease_year'=>$diseaseyear,
				'accident_status'=>$accidentstat,
				'accident_name'=>$accidentname,
				'accident_cause'=>$accidentcause,
				'accident_year'=>$accidentyear,
				'glasses_status'=>$glass,
				'smoking_status'=>$smoke,
				'blood_type'=>$bloodtype,
				'type_vehicle'=>$vehicletype,
				'ownership_vehicle'=>$owner,
				'driving_license'=>$license,
				'employee_acknowledge'=>$acknowledge1,
				'relation'=>$relation,
				'reference_name'=>$namer1,
				'reference_position'=>$posr1,
				'reference_company'=>$comr1,
				'reference_address'=>$addr1,
				'reference_telephone'=>$telr1,
				'reference_relation'=>$relr1,
				'reference2_name'=>$namer2,
				'reference2_position'=>$posr2,
				'reference2_company'=>$comr2,
				'reference2_address'=>$addr2,
				'reference2_telephone'=>$telr2,
				'reference2_relation'=>$relr2,
				'reference_contact_status'=>$contact,
				'date_ready_work'=>$readywork
			);
		$this->db->insert('t_recruitment_detail_others',$data);
		return $this->db->error();
	}

	# List #
		public function getApplicantList($request_no, $plant, $department, $position, $name, $major, $create_from,$create_to){
			$sql = "SELECT rba.request_no, rba.applicant_no, plant, department, position, name, major, rg.created_at
					FROM t_recruitment_basic_assign rba
					INNER JOIN t_request_general rg ON rba.request_no = rg.request_no
					INNER JOIN t_recruitment_basic rb ON rba.applicant_no = rb.applicant_no
					";
			if ($request_no!='%%') {
				$sql.=" WHERE rba.request_no IN($request_no)";
			}
			else
			{
				$sql.=" WHERE rba.request_no LIKE ('$request_no')";
			}
			if ($plant!='%%') {
				$sql.=" AND plant IN ($plant)";
			}
			if ($department!='%%') {
				$sql.=" AND department IN ($department)";
			}
			if ($position!='%%') {
				$sql.=" AND position IN ($position)";
			}
			if ($name!='%%') {
				$sql.=" AND name IN ($name)";
			}
			if ($major !='%%') {
				$sql.=" AND major IN ($major)";
			}
			if ($create_to != NULL) {
				$sql.="AND
				 (date(rg.created_at) >= '$create_from' AND date(rg.created_at) <= '$create_to')";
			}
			
			$query = $this->db->query($sql);
			if($query->num_rows() > 0) {
				$row = $query->result_array();
	        	return $row;
			}
			return false;
			// return $sql;
		}
		public function get_all_request_general(){
			$this->db->distinct('*');
			$query = $this->db->get('t_request_general');
			return $query->result_array();
		}
		public function get_all_position(){
			$this->db->distinct('position');
			$query = $this->db->get('t_request_general');
			return $query->result_array();
		}
		public function get_all_name(){
			$query = $this->db->query('SELECT DISTINCT name FROM `t_recruitment_basic`');
			return $query->result_array();
		}
		public function get_all_major(){
			$query = $this->db->query('SELECT DISTINCT major FROM  `t_recruitment_basic`');
			return $query->result_array();
		}
		public function get_status_applicant($applicant_no,$request_no){
			$sql = "SELECT 
				trnp.test_status AS 'test_status_pretest',
				trnhi.test_status AS 'test_status_hr_interview',
				trnpt.test_status AS 'test_status_psy_test',
				trnui.test_status AS 'test_status_user_interview',
				trnfi.test_status AS 'test_status_final_interview',
				trnmc.test_status AS 'test_status_medical_checkup',
				IFNULL(trnp.test_date,'0000-00-00') AS 'test_date_pretest',
				IFNULL(trnhi.test_date,'0000-00-00') AS 'test_date_hr_interview',
				IFNULL(trnpt.test_date,'0000-00-00') AS 'test_date_psy_test',
				IFNULL(trnui.test_date,'0000-00-00') AS 'test_date_user_interview',
				IFNULL(trnfi.test_date,'0000-00-00') AS 'test_date_final_interview',
				IFNULL(trnmc.test_date,'0000-00-00') AS 'test_date_medical_checkup'
				FROM t_recruitment_basic_assign trba
				LEFT JOIN t_recruitment_next_pretest trnp
				ON (trba.applicant_no = trnp.applicant_no) 
				LEFT JOIN t_recruitment_next_hr_interview trnhi
				ON (trba.applicant_no = trnhi.applicant_no)
				LEFT JOIN t_recruitment_next_psy_test trnpt
				ON (trba.applicant_no = trnpt.applicant_no)
				LEFT JOIN t_recruitment_next_user_interview trnui
				ON (trba.applicant_no = trnui.applicant_no)
				LEFT JOIN t_recruitment_next_final_interview trnfi
				ON (trba.applicant_no = trnfi.applicant_no)
				LEFT JOIN t_recruitment_next_medical_checkup trnmc
				ON (trba.applicant_no = trnmc.applicant_no)
				JOIN t_recruitment_basic trb
				ON (trba.applicant_no = trb.applicant_no)
				LEFT JOIN t_recruitment_next_finalize trnf
				ON (trba.applicant_no = trnf.applicant_no)
				WHERE trba.applicant_no = '$applicant_no' AND trba.request_no = '$request_no';";
			$query = $this->db->query($sql);
			if($query->num_rows() > 0) {
				$row = $query->row();
				if ($row->test_status_pretest=='failx'||$row->test_status_hr_interview=='failx'||$row->test_status_psy_test=='failx'||$row->test_status_user_interview=='failx'||$row->test_status_final_interview=='failx'||$row->test_status_medical_checkup=='failx') {
					return "Rejected";
				}
				else
				{
					$sql = "SELECT request_no, applicant_no FROM t_recruitment_hiring WHERE applicant_no = '$applicant_no' AND request_no='$request_no'";
					$query = $this->db->query($sql);
					$sql2 = "SELECT request_no, applicant_no FROM t_recruitment_hiring WHERE applicant_no = '$applicant_no'";
					$query2 = $this->db->query($sql2);
					if ($query->num_rows()>0 && $query2->num_rows()>0) {
						return "Hired";
					}
					elseif($query2->num_rows()>0){
						return "Rejected";
					}
					else{
						$test_date_container = [];
						array_push($test_date_container, $row->test_date_pretest, $row->test_date_hr_interview, $row->test_date_psy_test, $row->test_date_user_interview, $row->test_date_final_interview, $row->test_date_medical_checkup);
						$mostRecent= strtotime('0000-00-00');
						foreach($test_date_container as $date){
						  $curDate = strtotime($date);
						  if ($curDate > $mostRecent) {
						     $mostRecent = $curDate;
						  }
						}
						$index = array_search(date('Y-m-d',$mostRecent), $test_date_container);
						// return $index;
						switch ($index) {
						    case 0:
						        $stat = "Pretest";
						        break;
						    case 1:
						        $stat = "HR Interview";
						        break;
						    case 2:
						        $stat = "PSY Test";
						        break;
						    case 3:
						        $stat = "User Interview";
						        break;
						    case 4:
						        $stat = "Final Interview";
						        break;
						    case 5:
						        $stat = "Medical Checkup";
						        break;
						}
						return $stat;
					}
				}
			}
		}
	# End List #

	# Start Next #
		public function getRequestList($plant,$position, $department,$direct_superior,$in_the_budget,$job_class,$number_of_employee,$working_status,$expected_working_date, $budget){

			$sql = "SELECT DISTINCT request_no,plant,position,reason,working_status,number_of_employee,created_by,department,created_at
			FROM t_request_general
			WHERE request_no IN (SELECT request_no FROM t_request_approval WHERE approval_code = 'CL' AND status = '' )";
			if ($position!='%%') {
				$sql.="  AND position IN ($position)";
			}
			else{
				$sql.=" AND position LIKE '$position'";
			}
			if ($department!='%%') {
				$sql.=" AND department IN ($department)";
			}
			if ($direct_superior!='%%') {
				$sql.=" AND direct_superior IN ($direct_superior)";
			}
			if ($in_the_budget == '%%' ||$in_the_budget != '%%') {
				$sql.= " AND in_the_budget LIKE '$in_the_budget'";
			}
			if ($job_class != '%%') {
				$sql.= " AND job_class IN ($job_class)";
			}
			if ($number_of_employee!= '%%') {
				$sql.= " AND number_of_employee IN ($number_of_employee)";
			}
			if ($working_status!= '%%') {
				$sql.= " AND working_status IN ($working_status)";
			}
			if ($expected_working_date!='%%') {
				$sql.= " AND DATE(expected_working_date) LIKE '$expected_working_date'";
			}
			if ($plant!='%%') {
				$sql.= " AND plant IN ($plant)";
			}
			$sql.= " AND in_the_budget = $budget ";
			$query = $this->db->query($sql);
			if($query->num_rows() > 0) {
				$row = $query->result_array();
	        	return $row;
			}
			return false;
			// return $sql;
		}
		public function getPretestData($request_no){
			$sql = "SELECT t_recruitment_basic_assign.applicant_no, name,
				t_recruitment_next_pretest.test_date AS test_date_pretest,
				t_recruitment_next_hr_interview.test_date AS test_date_hr,
				t_recruitment_next_pretest.test_status AS test_status_pretest,
				t_recruitment_next_hr_interview.test_status AS test_status_hr_interview,
				t_recruitment_next_psy_test.test_status AS test_status_psy_test,
				t_recruitment_next_user_interview.test_status AS test_status_user_interview,
				t_recruitment_next_final_interview.test_status AS test_status_final_interview,
				t_recruitment_next_medical_checkup.test_status AS test_status_medical_checkup,
				iq, mec_1, mec_2, speed, t_recruitment_next_pretest.test_status, t_recruitment_next_pretest.next_process,t_recruitment_next_pretest.status_submit 
				FROM t_recruitment_basic_assign 
				LEFT JOIN t_recruitment_next_pretest 
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_pretest.applicant_no) 
				LEFT JOIN t_recruitment_next_hr_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_hr_interview.applicant_no)
				LEFT JOIN t_recruitment_next_psy_test
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_psy_test.applicant_no)
				LEFT JOIN t_recruitment_next_user_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_user_interview.applicant_no)
				LEFT JOIN t_recruitment_next_final_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_final_interview.applicant_no)
				LEFT JOIN t_recruitment_next_medical_checkup
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_medical_checkup.applicant_no)
				JOIN t_recruitment_basic ON (t_recruitment_basic_assign.applicant_no = t_recruitment_basic.applicant_no) WHERE request_no = '$request_no'";
			$query = $this->db->query($sql);
			$status = $query->result_array();
			return $status;
		}
		public function getHRInterviewData($request_no){
			$sql = "SELECT t_recruitment_basic_assign.applicant_no, name, 
				t_recruitment_next_hr_interview.test_date AS test_date_hr, 
				t_recruitment_next_psy_test.test_date AS test_date_psy,
				`t_recruitment_next_hr_interview`.`remarks`, 
				`t_recruitment_next_hr_interview`.next_process, 
				t_recruitment_next_hr_interview.status_submit,
				t_recruitment_next_pretest.test_status AS test_status_pretest,
				t_recruitment_next_hr_interview.test_status AS test_status_hr_interview,
				t_recruitment_next_psy_test.test_status AS test_status_psy_test,
				t_recruitment_next_user_interview.test_status AS test_status_user_interview,
				t_recruitment_next_final_interview.test_status AS test_status_final_interview,
				t_recruitment_next_medical_checkup.test_status AS test_status_medical_checkup,
				t_recruitment_next_hr_interview.file_name
				FROM t_recruitment_basic_assign 
								LEFT JOIN t_recruitment_next_pretest 
								ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_pretest.applicant_no) 
								LEFT JOIN t_recruitment_next_hr_interview
								ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_hr_interview.applicant_no)
								LEFT JOIN t_recruitment_next_psy_test
								ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_psy_test.applicant_no)
								LEFT JOIN t_recruitment_next_user_interview
								ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_user_interview.applicant_no)
								LEFT JOIN t_recruitment_next_final_interview
								ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_final_interview.applicant_no)
								LEFT JOIN t_recruitment_next_medical_checkup
								ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_medical_checkup.applicant_no)
								JOIN t_recruitment_basic ON (t_recruitment_basic_assign.applicant_no = t_recruitment_basic.applicant_no) WHERE request_no = '$request_no'";
			$query = $this->db->query($sql);
			$status = $query->result_array();
			return $status;
		}
		public function getPsyTestData($request_no){
			$sql = "SELECT t_recruitment_basic_assign.applicant_no, name,
			 t_recruitment_next_psy_test.test_date AS test_date_psy,
			 t_recruitment_next_user_interview.test_date AS test_date_user,
			 `t_recruitment_next_psy_test`.`remarks`,
			 `t_recruitment_next_psy_test`.next_process, 
			 t_recruitment_next_psy_test.status_submit,
			 t_recruitment_next_pretest.test_status AS test_status_pretest,
			t_recruitment_next_hr_interview.test_status AS test_status_hr_interview,
			t_recruitment_next_psy_test.test_status AS test_status_psy_test,
			t_recruitment_next_user_interview.test_status AS test_status_user_interview,
			t_recruitment_next_final_interview.test_status AS test_status_final_interview,
			t_recruitment_next_medical_checkup.test_status AS test_status_medical_checkup,
			t_recruitment_next_psy_test.file_name AS file_name
			FROM t_recruitment_basic_assign 
							LEFT JOIN t_recruitment_next_pretest 
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_pretest.applicant_no) 
							LEFT JOIN t_recruitment_next_hr_interview
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_hr_interview.applicant_no)
							LEFT JOIN t_recruitment_next_psy_test
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_psy_test.applicant_no)
							LEFT JOIN t_recruitment_next_user_interview
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_user_interview.applicant_no)
							LEFT JOIN t_recruitment_next_final_interview
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_final_interview.applicant_no)
							LEFT JOIN t_recruitment_next_medical_checkup
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_medical_checkup.applicant_no)
							JOIN t_recruitment_basic ON (t_recruitment_basic_assign.applicant_no = t_recruitment_basic.applicant_no) WHERE request_no = '$request_no'";
			$query = $this->db->query($sql);
			$status = $query->result_array();
			return $status;
		}
		public function getUserInterviewData($request_no){
			$sql = "SELECT t_recruitment_basic_assign.applicant_no, name,
			 t_recruitment_next_user_interview.test_date AS test_date_user,
			 t_recruitment_next_final_interview.test_date AS test_date_final_int,
			 `t_recruitment_next_user_interview`.`remarks`,
			 `t_recruitment_next_user_interview`.next_process, 
			 t_recruitment_next_user_interview.status_submit,
			 t_recruitment_next_pretest.test_status AS test_status_pretest,
			t_recruitment_next_hr_interview.test_status AS test_status_hr_interview,
			t_recruitment_next_psy_test.test_status AS test_status_psy_test,
			t_recruitment_next_user_interview.test_status AS test_status_user_interview,
			t_recruitment_next_final_interview.test_status AS test_status_final_interview,
			t_recruitment_next_medical_checkup.test_status AS test_status_medical_checkup,
			t_recruitment_next_user_interview.file_name AS file_name
			FROM t_recruitment_basic_assign 
							LEFT JOIN t_recruitment_next_pretest 
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_pretest.applicant_no) 
							LEFT JOIN t_recruitment_next_hr_interview
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_hr_interview.applicant_no)
							LEFT JOIN t_recruitment_next_psy_test
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_psy_test.applicant_no)
							LEFT JOIN t_recruitment_next_user_interview
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_user_interview.applicant_no)
							LEFT JOIN t_recruitment_next_final_interview
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_final_interview.applicant_no)
							LEFT JOIN t_recruitment_next_medical_checkup
							ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_medical_checkup.applicant_no)
							JOIN t_recruitment_basic ON (t_recruitment_basic_assign.applicant_no = t_recruitment_basic.applicant_no) WHERE request_no = '$request_no'";
			$query = $this->db->query($sql);
			$status = $query->result_array();
			return $status;
		}
		public function getFinalInterviewData($request_no){
			$sql = "SELECT t_recruitment_basic_assign.applicant_no, name, 
				t_recruitment_next_final_interview.test_date AS test_date_final_int, 
				t_recruitment_next_medical_checkup.test_date AS test_date_medical_checkup,
				`t_recruitment_next_final_interview`.`remarks`, 
				`t_recruitment_next_final_interview`.next_process, 
				t_recruitment_next_final_interview.status_submit,
				t_recruitment_next_pretest.test_status AS test_status_pretest,
				t_recruitment_next_hr_interview.test_status AS test_status_hr_interview,
				t_recruitment_next_psy_test.test_status AS test_status_psy_test,
				t_recruitment_next_user_interview.test_status AS test_status_user_interview,
				t_recruitment_next_final_interview.test_status AS test_status_final_interview,
				t_recruitment_next_medical_checkup.test_status AS test_status_medical_checkup,
				t_recruitment_next_final_interview.file_name AS file_name
				FROM t_recruitment_basic_assign 
				LEFT JOIN t_recruitment_next_pretest 
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_pretest.applicant_no) 
				LEFT JOIN t_recruitment_next_hr_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_hr_interview.applicant_no)
				LEFT JOIN t_recruitment_next_psy_test
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_psy_test.applicant_no)
				LEFT JOIN t_recruitment_next_user_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_user_interview.applicant_no)
				LEFT JOIN t_recruitment_next_final_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_final_interview.applicant_no)
				LEFT JOIN t_recruitment_next_medical_checkup
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_medical_checkup.applicant_no)
				JOIN t_recruitment_basic ON (t_recruitment_basic_assign.applicant_no = t_recruitment_basic.applicant_no) WHERE request_no = '$request_no'";
			$query = $this->db->query($sql);
			$status = $query->result_array();
			return $status;
		}
		public function getMedicalCheckupData($request_no){
			$sql = "SELECT t_recruitment_basic_assign.applicant_no, name, `t_recruitment_next_medical_checkup`.test_date,
				`t_recruitment_next_medical_checkup`.`remarks`,
				`t_recruitment_next_medical_checkup`.next_process, 
				t_recruitment_next_medical_checkup.status_submit,
				t_recruitment_next_pretest.test_status AS test_status_pretest,
				t_recruitment_next_hr_interview.test_status AS test_status_hr_interview,
				t_recruitment_next_psy_test.test_status AS test_status_psy_test,
				t_recruitment_next_user_interview.test_status AS test_status_user_interview,
				t_recruitment_next_final_interview.test_status AS test_status_final_interview,
				t_recruitment_next_medical_checkup.test_status AS test_status_medical_checkup,
				t_recruitment_next_medical_checkup.file_name
				FROM t_recruitment_basic_assign 
				LEFT JOIN t_recruitment_next_pretest 
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_pretest.applicant_no) 
				LEFT JOIN t_recruitment_next_hr_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_hr_interview.applicant_no)
				LEFT JOIN t_recruitment_next_psy_test
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_psy_test.applicant_no)
				LEFT JOIN t_recruitment_next_user_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_user_interview.applicant_no)
				LEFT JOIN t_recruitment_next_final_interview
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_final_interview.applicant_no)
				LEFT JOIN t_recruitment_next_medical_checkup
				ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_medical_checkup.applicant_no)
				JOIN t_recruitment_basic ON (t_recruitment_basic_assign.applicant_no = t_recruitment_basic.applicant_no) WHERE request_no = '$request_no'";
			$query = $this->db->query($sql);
			$status = $query->result_array();
			return $status;
		}
		public function getFinalizeData($request_no){
			$sql = "SELECT t_recruitment_basic_assign.request_no,t_recruitment_basic_assign.applicant_no, 
					(
					   CASE WHEN EXISTS(SELECT t_recruitment_hiring.applicant_no FROM t_recruitment_hiring WHERE t_recruitment_hiring.applicant_no = t_recruitment_basic_assign.applicant_no AND t_recruitment_hiring.request_no != t_recruitment_basic_assign.request_no)
					      THEN 'already_hired' 
					      ELSE NULL
					   END 
					  )AS status_hiring, 
						number_of_employee,t_recruitment_basic.name,t_request_general.position,sk_number, first_working_date, end_of_contract, personnel, position_no,
									t_recruitment_next_pretest.test_status AS test_status_pretest,
									t_recruitment_next_hr_interview.test_status AS test_status_hr_interview,
									t_recruitment_next_psy_test.test_status AS test_status_psy_test,
									t_recruitment_next_user_interview.test_status AS test_status_user_interview,
									t_recruitment_next_final_interview.test_status AS test_status_final_interview,
									t_recruitment_next_medical_checkup.test_status AS test_status_medical_checkup
									FROM t_recruitment_basic_assign 
									LEFT JOIN t_recruitment_next_pretest 
									ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_pretest.applicant_no) 
									LEFT JOIN t_recruitment_next_hr_interview
									ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_hr_interview.applicant_no)
									LEFT JOIN t_recruitment_next_psy_test
									ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_psy_test.applicant_no)
									LEFT JOIN t_recruitment_next_user_interview
									ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_user_interview.applicant_no)
									LEFT JOIN t_recruitment_next_final_interview
									ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_final_interview.applicant_no)
									LEFT JOIN t_recruitment_next_medical_checkup
									ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_medical_checkup.applicant_no)
									JOIN t_recruitment_basic
									ON (t_recruitment_basic.applicant_no = t_recruitment_basic_assign.applicant_no)
									LEFT JOIN t_recruitment_next_finalize
									ON (t_recruitment_basic_assign.applicant_no = t_recruitment_next_finalize.applicant_no)
									LEFT JOIN t_request_general
									ON(t_recruitment_basic_assign.request_no=t_request_general.request_no) WHERE t_recruitment_basic_assign.request_no = '$request_no'";
			$query = $this->db->query($sql);
			$status = $query->result_array();
			return $status;
		}
		public function getHiringAvailabilityStatus($request_no){
			$number_of_employee_needed = "SELECT number_of_employee FROM t_request_general WHERE request_no='$request_no'";
			$number_of_employee_hired = "SELECT applicant_no FROM t_recruitment_hiring WHERE request_no='$request_no'";
			$result_number_of_employee_needed = $this->db->query($number_of_employee_needed);
					if($result_number_of_employee_needed->num_rows() > 0) {
						$result_number_of_employee_needed_line = $result_number_of_employee_needed->row();
						$num_emp_needed = $result_number_of_employee_needed_line->number_of_employee;
					}
					$num_emp_hired = $this->db->query($number_of_employee_hired)->num_rows();
					if ($num_emp_needed==$num_emp_hired) {
						return "not_available_to_hire";
					}
					elseif($num_emp_needed<$num_emp_hired){
						return "available_to_hire";
					}
		}
		public function insertPretest($applicant_no, $test_date, $iq, $mec_1, $mec_2, $speed, $test_status, $next_process,$status_submit){
			$data = array(
			        'applicant_no' => $applicant_no,
			        'test_date'  => $test_date,
			        'iq'  => $iq,
			        'mec_1' => $mec_1,
			        'mec_2' => $mec_2,
			        'speed' => $speed,
			        'test_status' => $test_status,
			        'next_process' => $next_process,
			        'status_submit' => $status_submit
			);
			$sql = "SELECT applicant_no, status_submit FROM t_recruitment_next_pretest WHERE applicant_no = '$applicant_no'";
			$query = $this->db->query($sql);
			$data2 = $query->result_array();
			if($query->num_rows() > 0) {
				$stat_submit_db = $data2[0]['status_submit'];
				if ($stat_submit_db!='x') {
					$status = $this->db->replace('t_recruitment_next_pretest', $data);
				}
				else
				{
					$status = TRUE;
				}
			}
			else{
				$status = $this->db->insert('t_recruitment_next_pretest', $data);
			}
			return $status;
		}
		public function insertHRInterview($applicant_no, $test_date, $test_status, $remarks, $next_process,$status_submit,$nama_file){
			$data = array(
			        'applicant_no' => $applicant_no,
			        'test_date'  => $test_date,
			        'test_status' => $test_status,
			        'remarks'=>$remarks,
			        'next_process' => $next_process,
			        'status_submit' => $status_submit,
			        'file_name'=>$nama_file
			);
			$sql = "SELECT applicant_no, status_submit FROM t_recruitment_next_hr_interview WHERE applicant_no = '$applicant_no'";
			$query = $this->db->query($sql);
			$data2 = $query->result_array();
			if($query->num_rows() > 0) {
				$stat_submit_db = $data2[0]['status_submit'];
				if ($stat_submit_db!='x') {
					$status = $this->db->replace('t_recruitment_next_hr_interview', $data);
				}
				else
				{
					$status = TRUE;
				}
			}
			else{
				$status = $this->db->insert('t_recruitment_next_hr_interview', $data);
			}
			return $status;
		}
		public function insertPsytest($applicant_no, $test_date, $test_status, $remarks, $next_process,$status_submit,$nama_file){
			$data = array(
			        'applicant_no' => $applicant_no,
			        'test_date'  => $test_date,
			        'test_status' => $test_status,
			        'remarks'=>$remarks,
			        'next_process' => $next_process,
			        'status_submit' => $status_submit,
			        'file_name'=>$nama_file
			);
			$sql = "SELECT applicant_no, status_submit FROM t_recruitment_next_psy_test WHERE applicant_no = '$applicant_no'";
			$query = $this->db->query($sql);
			$data2 = $query->result_array();
			if($query->num_rows() > 0) {
				$stat_submit_db = $data2[0]['status_submit'];
				if ($stat_submit_db!='x') {
					$status = $this->db->replace('t_recruitment_next_psy_test', $data);
				}
				else
				{
					$status = TRUE;
				}
			}
			else{
				$status = $this->db->insert('t_recruitment_next_psy_test', $data);
			}
			return $status;
		}
		public function insertUserInterview($applicant_no, $test_date, $test_status, $remarks, $next_process,$status_submit,$nama_file){
			$data = array(
			        'applicant_no' => $applicant_no,
			        'test_date'  => $test_date,
			        'test_status' => $test_status,
			        'remarks'=>$remarks,
			        'next_process' => $next_process,
			        'status_submit' => $status_submit,
			        'file_name'=>$nama_file
			);
			$sql = "SELECT applicant_no, status_submit FROM t_recruitment_next_user_interview WHERE applicant_no = '$applicant_no'";
			$query = $this->db->query($sql);
			$data2 = $query->result_array();
			if($query->num_rows() > 0) {
				$stat_submit_db = $data2[0]['status_submit'];
				if ($stat_submit_db!='x') {
					$status = $this->db->replace('t_recruitment_next_user_interview', $data);
				}
				else
				{
					$status = TRUE;
				}
			}
			else{
				$status = $this->db->insert('t_recruitment_next_user_interview', $data);
			}
			return $status;
		}
		public function insertFinalInterview($applicant_no, $test_date, $test_status, $remarks, $next_process,$status_submit,$nama_file){
			$data = array(
			        'applicant_no' => $applicant_no,
			        'test_date'  => $test_date,
			        'test_status' => $test_status,
			        'remarks'=>$remarks,
			        'next_process' => $next_process,
			        'status_submit' => $status_submit,
			        'file_name'=>$nama_file
			);
			$sql = "SELECT applicant_no, status_submit FROM t_recruitment_next_final_interview WHERE applicant_no = '$applicant_no'";
			$query = $this->db->query($sql);
			$data2 = $query->result_array();
			if($query->num_rows() > 0) {
				$stat_submit_db = $data2[0]['status_submit'];
				if ($stat_submit_db!='x') {
					$status = $this->db->replace('t_recruitment_next_final_interview', $data);
				}
				else
				{
					$status = TRUE;
				}
			}
			else{
				$status = $this->db->insert('t_recruitment_next_final_interview', $data);
			}
			return $status;
		}
		public function insertMedicalCheckup($applicant_no, $test_date, $test_status, $remarks, $next_process,$status_submit,$nama_file){
			$data = array(
			        'applicant_no' => $applicant_no,
			        'test_date'  => $test_date,
			        'test_status' => $test_status,
			        'remarks'=>$remarks,
			        'next_process' => $next_process,
			        'status_submit' => $status_submit,
			        'file_name'=>$nama_file
			);
			$sql = "SELECT applicant_no, status_submit FROM t_recruitment_next_medical_checkup WHERE applicant_no = '$applicant_no'";
			$query = $this->db->query($sql);
			$data2 = $query->result_array();
			if($query->num_rows() > 0) {
				$stat_submit_db = $data2[0]['status_submit'];
				if ($stat_submit_db!='x') {
					$status = $this->db->replace('t_recruitment_next_medical_checkup', $data);
				}
				else
				{
					$status = TRUE;
				}
			}
			else{
				$status = $this->db->insert('t_recruitment_next_medical_checkup', $data);
			}
			return $status;
		}
	# End Next #

	# Start Hiring Modal #
		function insertHiring($applicant_no,$valid_from_0000,$valid_to_0000,$position_no_0000,$personnel_area_0000,$employee_subgroup_0000
			,$valid_from_0001,$valid_to_0001,$personnel_subarea_0001,$payroll_area_0001,$contract_0001
			,$valid_from_0002,$valid_to_0002,$first_name_0002,$last_name_0002,$nick_name_0002,$gender_0002,$birth_date_0002,$nationality_0002,$religion_0002,$marriage_status_0002
			 ,$valid_from_0007, $valid_to_0007, $ws_rule_0007
			 ,$valid_from_0008, $valid_to_0008, $reason_0008, $personnel_type_0008, $personnel_area_0008, $personnel_group_0008, $personnel_level_0008, $wage_type_0008, $wage_ammount_0008
			 ,$valid_from_0009, $valid_to_0009, $payee_0009, $payee_loc_0009, $bank_country_0009, $bank_key_0009, $bank_acc_0009, $payment_method_0009, $purpose_0009, $payment_curr_0009
			 , $task_type_0019,$date_of_task_0019,$proc_indicator_0019,$reminder_date_0019){
			$data = array(
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
			        '0019_reminder_date'=>$reminder_date_0019
			);
			//  `0019_task_type`, `0019_date_of_task`, `0019_proc_indicator`, `0019_reminder_date`, 
			$status = $this->db->insert('t_recruitment_hiring', $data);
			return $this->db->error();

		}
	# End Hiring Modal #
}