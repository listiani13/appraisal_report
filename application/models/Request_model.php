<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_model extends CI_Model {
	//public $year; $month;	
	function __construct()
	{
		parent::__construct();
	
	}

	public function force_sessions() {
		$email = 'desti.hapsari@dynapackasia.com';
		//$email = 'TRIMURTI.HANDAYANI@DYNAPACKASIA.COM';
		//$email = 'BUDHI.TJAHYONO@DYNAPACKASIA.COM';
		//$email = 'MERCIA.NATIO@DYNAPACKASIA.COM';
		//$email = 'EVELINE.HARTONO@DYNAPACKASIA.COM';
		//$email = 'EMMELINE.HAMBALI@DYNAPACKASIA.COM';



		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
	}

	public function createNewRequest($genReq, $replacementReq, $jobDescReq, $supportDocReq, $organisasi, $eduBackReq, $experienceReq, $otherQualificationReq, $foreignLangReq){
		var_dump($this->db->insert('t_request_general', $genReq));	
		var_dump($this->db->insert('t_request_diagram_organizational_structure', $organisasi));
		foreach ($replacementReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_replacement', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		foreach ($jobDescReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_job_description', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		foreach ($supportDocReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_supporting_document', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		foreach ($eduBackReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_educational_background', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		foreach ($experienceReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_experience', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		foreach ($otherQualificationReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_other_qualification', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		foreach ($foreignLangReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_foreign_language', $key));
			var_dump($key);	
			echo "<br>";
		}
	}

	public function changeRequest($request_no, $genReq, $replacementReq, $jobDescReq, $supportDocReq, $organisasi, $eduBackReq, $experienceReq, $otherQualificationReq, $foreignLangReq){
		var_dump($this->db->where('request_no', $request_no)
						  ->update('t_request_general', $genReq));	
		echo "<br>";
		var_dump($this->db->where('request_no', $request_no)
						  ->update('t_request_diagram_organizational_structure', $organisasi));	
		echo "<br>";
		var_dump($this->db->where('request_no', $request_no)
					  	  ->delete('t_request_replacement'));
		foreach ($replacementReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_replacement', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		var_dump($this->db->where('request_no', $request_no)
					  	  ->delete('t_request_job_description'));
		foreach ($jobDescReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_job_description', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		var_dump($this->db->where('request_no', $request_no)
					  	  ->delete('t_request_supporting_document'));
		foreach ($supportDocReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_supporting_document', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		var_dump($this->db->where('request_no', $request_no)
					  	  ->delete('t_request_educational_background'));
		foreach ($eduBackReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_educational_background', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		var_dump($this->db->where('request_no', $request_no)
					  	  ->delete('t_request_experience'));
		foreach ($experienceReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_experience', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		var_dump($this->db->where('request_no', $request_no)
					  	  ->delete('t_request_other_qualification'));
		foreach ($otherQualificationReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_other_qualification', $key));
			/*var_dump($key);	
			echo "<br>";*/
		}
		var_dump($this->db->where('request_no', $request_no)
					  	  ->delete('t_request_foreign_language'));
		foreach ($foreignLangReq as $key) {
			echo "<br>";
			var_dump($this->db->insert('t_request_foreign_language', $key));
			var_dump($key);	
			echo "<br>";
		}
	}

	public function upadteApprovalAfterReject($request_no){
		$delete = $this->db->query("
				delete
				from t_request_approval
				where request_no = '".$request_no."'
					and item_no > 2
			");
		$update = [
			"approved_by" => "",
			"approved_at" => "0000-00-00 00:00:00",
			"status" => ""
		];
		$do_update = $this->db->where('item_no', "2")
				 ->where('request_no', $request_no)
				 ->update('t_request_approval', $update);
				 var_dump($do_update);
	}

	public function getLastItemNoRejectHistory($request_no){
		$result = $this->db->query("
				select item_no
				from t_request_reject_history
				where request_no = '".$request_no."' and item_no = (
					select max(item_no)
					from t_request_reject_history
					where request_no = '".$request_no."'
				)
			")->row_array();
		if(sizeof($result)<1){
			return 0;
		} else {
			return $result['item_no'];
		}
	}

	public function getLastRejectHistory($request_no){
		$result = $this->db->query("
				select *
				from t_request_reject_history
				where request_no = '".$request_no."' and item_no = (
					select max(item_no)
					from t_request_reject_history
					where request_no = '".$request_no."'
				)
			")->row_array();
		return $result;
	}

	public function writeRejectHistory($reject){
		$this->db->insert('t_request_reject_history', $reject);
	}

	public function getNewRequestId(){
		$year = date('y');
		$month = date('m');
		$lastOldReqNo = $this->db->select('max(request_no) as request_no')
							     ->from('t_request_general')
							     ->like("request_no", $year.$month)
						         ->get()->row_array()['request_no'];
		$newReqNo = "";
		if(isset($lastOldReqNo)){
			$newReqNo = $lastOldReqNo + 1;
		} else {
			$newReqNo = $year.$month."0001";
		}
		return $newReqNo;
	}

	public function getApprovalRequest($request_no){
		$res = $this->db->select('*')
						->from('t_request_approval')
						->where('request_no', $request_no)
						->get()->result_array();
		for($i = 0; $i<sizeof($res); $i++){
			$res[$i]['name'] = $this->ess_model->get_name($res[$i]['approved_by']);
		}
		return $res;
	}

	public function getGeneralRequest($request_no){
		return $this->db->select('*')
						->from('t_request_general')
						->where('request_no', $request_no)
						->get()->row_array();
	}

	public function getReplacementRequest($request_no){
		return $this->db->select('*')
						->from('t_request_replacement')
						->where('request_no', $request_no)
						->get()->result_array();
	}

	public function getJobDescRequest($request_no){
		return $this->db->select('*')
						->from('t_request_job_description')
						->where('request_no', $request_no)
						->get()->result_array();
	}

	public function getSupportDocRequest($request_no){
		return $this->db->select('*')
						->from('t_request_supporting_document')
						->where('request_no', $request_no)
						->get()->result_array();
	}

	public function getStrukturOrganisasi($request_no){
		return $this->db->select('*')
						->from('t_request_diagram_organizational_structure')
						->where('request_no', $request_no)
						->get()->row_array();
	}

	public function getEducationBackgroundRequest($request_no){
		return $this->db->select('*')
						->from('t_request_educational_background')
						->where('request_no', $request_no)
						->get()->result_array();
	}

	public function getExperienceRequest($request_no){
		return $this->db->select('*')
						->from('t_request_experience')
						->where('request_no', $request_no)
						->get()->result_array();
	}

	public function getOtherQualificationRequest($request_no){
		return $this->db->select('*')
						->from('t_request_other_qualification')
						->where('request_no', $request_no)
						->get()->result_array();
	}

	public function getForeignLangRequest($request_no){
		return $this->db->select('*')
						->from('t_request_foreign_language')
						->where('request_no', $request_no)
						->get()->result_array();
	}

	public function getAllUserGeneralRequest($olUser){
		return $this->db->select('*')
						->from('t_request_general')
						->where('created_by', $olUser)
						->get()->result_array();
	}

	/*public function getUserFromTarget($target){
		$user = $this->db->select('*')
						 ->from('m_approval_user')
						 ->where('target', $target)
						 ->get()->result_array();
	}*/

	public function getTargetFromUserAndCode($user, $plant, $code){
		return $this->db->query('
				select target
				from m_approval_user
				where user = "'.$user.'" and
					  plant = "'.$plant.'" and
					  code = "'.$code.'"
			')->result_array();
	}

	public function getAllLastApprovalRequest($request_no){
		return $this->db->query('select request_no, item_no, approval_code, approved_by, approved_at, status
								from t_request_approval
								where request_no = "'.$request_no.'" and item_no = (
										select max(item_no) 
										from t_request_approval
										where request_no = "'.$request_no.'"
									)
								;')->row_array();
	}

	public function getLastItemId($request_no, $tbName){
		$sql = 'select item_no
				from '.$tbName.'
				where request_no = "'.$request_no.'" and item_no = (
						select max(item_no) 
						from '.$tbName.'
						where request_no = "'.$request_no.'"
					)
				;';
		$query = $this->db->query($sql)->row_array();
		if(isset($query['item_no'])){
			return $query['item_no'] + 1;
		} else {
			return 0;
		}
	}

	public function getReasonName($code){
		return $this->db->select('description')
						->from('m_reason')
						->where('code', $code)
						->get()->row_array();
	}

	public function getWorkingStatusName($code){
		return $this->db->select('description')
						->from('m_working_status')
						->where('code', $code)
						->get()->row_array();
	}

	public function getApprovalName($code){
		$ret = $this->db->select('description')
						->from('m_approval')
						->where('code', $code)
						->get()->row_array();
		if (isset($ret['description'])) $ret['description'] = str_replace("Approval ","",$ret['description']);
		return $ret;
	}

	public function getMApproval(){
		return $this->db->select('*')
						  ->from('m_approval')
						  ->order_by('sequence')
						  ->get()->result_array();	
	}

	public function getPlant($request_no){
		return $this->db->select('plant')
						  ->from('t_request_general')
						  ->where('request_no', $request_no)
						  ->get()->row_array()['plant'];
	}

	public function getApprovalUser($request_no, $user){
		$plant = $this->db->select('plant')
						  ->from('t_request_general')
						  ->where('request_no', $request_no)
						  ->get()->row_array()['plant'];
		return $this->db->select('*')
						->from('m_approval_user')
						->where('user', $user)
						->where('plant', $plant)
						->get()->result_array();
	}

	public function getApprovalUserWithName($request_no, $user){
		$plant = $this->db->select('plant')
						  ->from('t_request_general')
						  ->where('request_no', $request_no)
						  ->get()->row_array()['plant'];
		$res = $this->db->select('*')
						->from('m_approval_user')		
						->where('user', $user)
						->where('plant', $plant)
						->get()->result_array();
		for($i = 0; $i<sizeof($res); $i++){
			$res[$i]['name'] = $this->ess_model->get_name($res[$i]['target']);
		}
		return $res;
	}

	public function getNextApproval($request_no, $user){
		echo $request_no."<br><br>";
		$approvalUser = $this->getApprovalUser($request_no, $user);
		echo "<br>";
		echo "<br>";
		//var_dump($approvalUser);
		$mApproval = $this->getMApproval();	
		echo "<br>";
		echo "<br>";
		//var_dump($mApproval);

		$tbName = 't_request_approval';
		$sql = 'select *
				from '.$tbName.'
				where request_no = "'.$request_no.'" and item_no = (
						select max(item_no) 
						from '.$tbName.'
						where request_no = "'.$request_no.'"
					)
				;';
		$lastApproval = $this->db->query($sql)->row_array();
		echo "<br>";
		echo "<br>";
		//var_dump($lastApproval);

		$flag = 0;
		$nextApproval;
		foreach ($mApproval as $mAppVal) {
			foreach ($approvalUser as $appUserVal) {
				if($mAppVal['code'] != $lastApproval['approval_code'] && $mAppVal['code'] == $appUserVal['code']){
					$flag2 = 0;
					foreach ($mApproval as $key) {
						if($key['code'] == $lastApproval['approval_code']){
							if($mAppVal['sequence'] > $key['sequence']){
								$flag2 = 1;
								break;
							}
						}
					}
					if($flag2 == 1){
						$flag = 1;
						break;
					}
				}
			}
			if($flag == 1){
				$nextApproval = $mAppVal;
				break;
			}
		}
		echo "<br>";
		echo "<br>";
		//var_dump($nextApproval);

		return $nextApproval;		
	}

	public function getLastApprovalTarget($request_no, $created_by, $lastApprovalCode){
		$approvalUser = $this->getApprovalUser($request_no, $created_by);
		//var_dump($approvalUser);
		//echo "<br><br>";
		$approvalTarget = [];
		foreach ($approvalUser as $value) {
			if($value['code'] == $lastApprovalCode){
				array_push($approvalTarget, $value['target']);
			}
		}
		return $approvalTarget;
		//var_dump($approvalTarget);
	}

	public function getTargetGeneralRequestPendingApprove($target){
		$sql = "SELECT `t_request_general`.* 
				FROM `t_request_general`
				JOIN `t_request_approval`
					ON `t_request_general`.`request_no` = `t_request_approval`.`request_no`
				JOIN `m_approval_user`
					ON `t_request_general`.`plant` = `m_approval_user`.`plant`
					AND `t_request_general`.`created_by` = `m_approval_user`.`user`
					AND `t_request_approval`.`approval_code` = `m_approval_user`.`code`
				WHERE `m_approval_user`.`target` = '".$target."'
				AND `t_request_approval`.`status` = ''";
		return $this->db->query($sql)->result_array();
	}

	public function getTargetGeneralRequestHistoryApprove($target){
		$sql = "SELECT `t_request_general`.* , `t_request_approval`.`approval_code` , `t_request_approval`.`approved_at`, `t_request_approval`.`status` 
				FROM `t_request_general`
				JOIN `t_request_approval`
					ON `t_request_general`.`request_no` = `t_request_approval`.`request_no`
				JOIN `m_approval_user`
					ON `t_request_general`.`plant` = `m_approval_user`.`plant`
					AND `t_request_general`.`created_by` = `m_approval_user`.`user`
					AND `t_request_approval`.`approval_code` = `m_approval_user`.`code`
				WHERE `m_approval_user`.`target` = '".$target."' 
					AND `t_request_approval`.`status` != '' AND `t_request_approval`.`approval_code` != 'CR'";
		return $this->db->query($sql)->result_array();
	}

	public function getTargetGeneralRequestReport($target){
		$sql = "SELECT `t_request_general`.* , `m_approval`.`code` as approval_code , `t_request_approval`.`approved_at`, `t_request_approval`.`status` 
				FROM `t_request_general`
				JOIN `m_approval_user`
					ON `t_request_general`.`plant` = `m_approval_user`.`plant`
					AND `t_request_general`.`created_by` = `m_approval_user`.`user`
				JOIN `m_approval`
					ON `m_approval_user`.`code` = `m_approval`.`code`
				LEFT JOIN `t_request_approval`
					ON `t_request_general`.`request_no` = `t_request_approval`.`request_no`
				WHERE `m_approval_user`.`target` = '".$target."'
				GROUP BY `t_request_general`.`request_no`";
		return $this->db->query($sql)->result_array();
	}

	public function getMilestone($user, $plant){
		$resultQMS = $this->db->query('
			select *
			from m_approval as ma
			join m_approval_user as mau
			on ma.code = mau.code
			where mau.user = "'.$user.'" and plant = "'.$plant.'"
			group by 1
			order by ma.sequence;
			')->result_array(); 
		$i = 1;
		for ($i = 0; $i < sizeof($resultQMS); $i++) {
			$resultQMS[$i]['sequence'] = $i+1;
			if($plant == "DN00" || $plant == "DP00"){
				if($resultQMS[$i]['code'] == "HRP"){
					$resultQMS[$i]['description'] = "Approval Recruitment Group";
				} else if($resultQMS[$i]['code'] == "RG"){
					$resultQMS[$i]['description'] = "Approval HRM Division Head";
				} 

			}
			/*var_dump($value);
			echo "<br>";*/
		}
		/*foreach ($resultQMS as $value) {
			$value['sequence'] = $i;
			$i++;
			var_dump($value);
			echo "<br>";
		}*/
		/*var_dump($resultQMS);
		die();*/
		return $resultQMS;
	}

	public function insertApproval($newApproval){
		return $this->db->insert('t_request_approval', $newApproval);
	}

	public function updateApproval($request_no, $item_no, $updateApproval){
		$this->db->where('request_no', $request_no)
				 ->where('item_no',  $item_no)
				 ->update('t_request_approval', $updateApproval);
	}

	public function getUserSameOrBelowThisUser($user){
		$resultHR = $this->db->query('
				SELECT *
				FROM m_approval_user
				WHERE target =  "'.$user.'"
				AND ( code = "HRP" OR code = "RG" )
			')->result_array();

		if (sizeof($resultHR) > 0) {
			$resultPlant = $this->db->query('
					SELECT DISTINCT plant
					FROM m_approval_user
					WHERE target =  "'.$user.'"
					AND ( code = "HRP" OR code = "RG" )
				')->result_array();
			
			for($i = 0; $i < sizeof($resultPlant); $i++){
				$resultPlant[$i]['employee'] = $this->db->query('
					select distinct *
					from m_approval_user
					where target = "'.$user.'"
						and ( code = "HRP" OR code = "RG" )
						and plant = "'.$resultPlant[$i]['plant'].'"
				')->result_array();
			}
			for($i = 0; $i < sizeof($resultPlant); $i++) {
				for($j = 0; $j < sizeof($resultPlant[$i]['employee']); $j++){
					$resultPlant[$i]['employee'][$j]['userName'] = $this->ess_model->get_name($resultPlant[$i]['employee'][$j]['user']);
				}
			}
			return $resultPlant;
		} else {
			$resultPlant = $this->db->query('
					SELECT DISTINCT plant
					FROM m_approval_user
					WHERE target =  "'.$user.'"
					AND code NOT LIKE  "HR%"
				')->result_array();
			
			for($i = 0; $i < sizeof($resultPlant); $i++){
				$resultPlant[$i]['employee'] = $this->db->query('
					select distinct *
					from m_approval_user
					where target = "'.$user.'"
						and code not like "HR%"
						and code != "CL"
						and plant = "'.$resultPlant[$i]['plant'].'"
				')->result_array();
			}
			for($i = 0; $i < sizeof($resultPlant); $i++) {
				for($j = 0; $j < sizeof($resultPlant[$i]['employee']); $j++){
					$resultPlant[$i]['employee'][$j]['userName'] = $this->ess_model->get_name($resultPlant[$i]['employee'][$j]['user']);
				}
			}
			return $resultPlant;
		}
	}

	public function getApplicantFromRequestNo($request_no){
		$applicant = $this->db->query('
				SELECT b. * 
				FROM t_recruitment_basic AS b
				JOIN t_recruitment_basic_assign AS ba 
				ON b.applicant_no = ba.applicant_no
				AND ba.request_no =  "'.$request_no.'"
			')->result_array();
		$genReq = $this->getGeneralRequest($request_no);
		for($i=0; $i<sizeof($applicant); $i++){
			$applicant[$i]['plant'] = $genReq['plant'];
			$applicant[$i]['reason'] = $this->getReasonName($genReq['reason'])['description'];
			$applicant[$i]['position'] = $genReq['position'];
		}
		return $applicant;
	}

	public function getHiringStatus($request_no){
		$applicant = $this->db->query('
				SELECT b. * 
				FROM t_recruitment_basic AS b
				JOIN t_recruitment_basic_assign AS ba 
				ON b.applicant_no = ba.applicant_no
				AND ba.request_no =  "'.$request_no.'"
			')->result_array();
		$genReq = $this->getGeneralRequest($request_no);
		$countHired = 0;
		
		for($i=0; $i<sizeof($applicant); $i++){
			$applicant[$i]['plant'] = $genReq['plant'];
			$applicant[$i]['reason'] = $this->getReasonName($genReq['reason'])['description'];
			$applicant[$i]['position'] = $genReq['position'];
			$applicant[$i]['status'] = $this->Recruitment_model-> get_status_applicant($applicant[$i]['applicant_no'],$request_no);
			if($applicant[$i]['status'] == "Hired"){
				$countHired++;
			}
		}
		$hiringStatus = '';
		$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($genReq['request_no']);
		if($reqStatQuery['approval_code'] == "CL"  && $reqStatQuery['status'] != '0' && $reqStatQuery['status'] != '3'){
			if($reqStatQuery['status'] == ''){
				if($countHired == 0){
					$hiringStatus = 'Recruiting';
				} else {
					$hiringStatus = 'Hiring';
				}
			} else if($reqStatQuery['status'] == '1'){
				$hiringStatus = 'Hired';
			} 
		} else {
			$hiringStatus = '-';
		}
		return $hiringStatus;
	}

	public function getApplicantBasic($applicant_no){
		return $this->db->select('*')
						->from('t_recruitment_basic')
						->where('applicant_no', $applicant_no)
						->get()->row_array();
	}

	public function getApplicantForRequest($request_no){
		$applicant = getApplicantFromRequestNo($request_no);
		$applicantForRequest = [];
		foreach ($applicant as $value) {
			array_push($applicantForRequest, $this->getApplicantBasic($value['applicant_no']));
		}

	}

	public function get_query($query){
		return $this->db->query( $query )->result_array();
	}
}