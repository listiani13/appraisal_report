<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// force sessions
		//$this->request_model->force_sessions();
		$this->load->model('Request_model');
		$this->load->model('Recruitment_model');
		$this->load->model('Sendmail_model');
		$this->load->helper("file");
		$this->load->library('excel');//load PHPExcel library 
		require FCPATH.'assets/PHPMailer/PHPMailerAutoload.php';
	}

	public function index()
	{
		redirect('');
	}

	public function desti(){
		$email = 'desti.hapsari@dynapackasia.com';

		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->change();
	}
	public function benar(){
		$email = 'BH.SITOMPUL@DYNAPLAST.CO.ID';
		// $pernr = $this->ess_model->get_pernr($email);
		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->create();
	}
	public function murti(){
		$email = 'TRIMURTI.HANDAYANI@DYNAPACKASIA.COM';

		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->approvalPendingAllList();
	}

	public function heny(){
		$email = 'HN.WIJAYANTI@DYNAPLAST.CO.ID';
		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->approvalPendingAllList();
	}

	

	public function budhi(){
		$email = 'BUDHI.TJAHYONO@DYNAPACKASIA.COM';

		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->approvalPendingAllList();
	}

	public function mercia(){
		$email = 'MERCIA.NATIO@DYNAPACKASIA.COM';

		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->approvalPendingAllList();
	}

	public function eveline(){
		$email = 'EVELINE.HARTONO@DYNAPACKASIA.COM';

		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->approvalPendingAllList();
	}

	public function emmeline(){
		$email = 'EMMELINE.HAMBALI@DYNAPACKASIA.COM';

		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->approvalPendingAllList();
	}

	public function celia(){
		$email = 'CELIA@DYNAPLAST.CO.ID';

		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
		$this->approvalPendingAllList();
	}


	public function get_data($request_no)
	{
		$data = array();
		$pernr = $this->session->userdata('pernr');
		$me = $this->ess_model->get_me($pernr);

		if ($request_no == null) {
			$data['plant'] = $me->werks;
			$data['all_plant'] = $this->ess_model->get_all_plant();
			$data['department'] = $me->btrtl;
			$data['all_department'] = $this->ess_model->get_all_department();
			$data['position'] = '';
			$data['direct_superior'] = $this->ess_model->get_superior($pernr);
			$data['all_employee'] = $this->ess_model->get_all_employee();
			$data['in_the_budget'] = '1';
			$data['job_class'] = $me->persk;
			$data['all_job_class'] = $this->ess_model->get_all_job_class();
			$data['number_of_employee'] = '1';
			$data['working_status'] = '1';
			$data['expected_working_date'] = date('D, d.m.Y');
			$data['reason'] = '1';
			$data['request_note'] = '';
			$data['status'] = 'R1';
			$data['nik'] = array();
		} else {
			// select data with $request_no
			$data['plant'] = $me->werks;
			$data['all_plant'] = $this->ess_model->get_all_plant();
			$data['department'] = $me->btrtl;
			$data['all_department'] = $this->ess_model->get_all_department();
			$data['position'] = '';
			$data['direct_superior'] = $this->ess_model->get_superior($pernr);
			$data['all_employee'] = $this->ess_model->get_all_employee();
			$data['in_the_budget'] = '1';
			$data['job_class'] = $me->persk;
			$data['all_job_class'] = $this->ess_model->get_all_job_class();
			$data['number_of_employee'] = '1';
			$data['working_status'] = '1';
			$data['expected_working_date'] = date('D, d.m.Y');
			$data['reason'] = '1';
			$data['request_note'] = 'This is note';
			$data['status'] = 'R1';
			$data['nik'] = array('6917','9131','8229');
		}

		return $data;
	}

	public function generateDiagramStructureTextFromExcel(){
		$upload = $this->upload_form($_SESSION['pernr'], 'job_description-temp', date('Y-m-d_H:i:s'), 0);
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true); 		  
		$objPHPExcel=$objReader->load(FCPATH.'assets/uploads/request/temp/'.$upload['name']);		 
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();	 
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        $col[0] = $objWorksheet->getCellByColumnAndRow(4,54)->getValue();
        $col[1] = $objWorksheet->getCellByColumnAndRow(4,61)->getValue();
        $col[2] = $objWorksheet->getCellByColumnAndRow(2,68)->getValue();
        $col[3] = $objWorksheet->getCellByColumnAndRow(4,68)->getValue();
        $col[4] = $objWorksheet->getCellByColumnAndRow(6,68)->getValue();
        for($i = 0; $i < 5; $i++){
        	if(!isset($col[$i])){
        		$col[$i] = "";
        	}
        }
        echo json_encode($col);

        unlink('./assets/uploads/request/temp/'.$upload['name']);
	}

	public function getDataFromExcelToEdu(){
		$upload = $this->upload_form($_SESSION['pernr'], 'job_description-temp', date('Y-m-d_H:i:s'), 0);
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true); 		  
		$objPHPExcel=$objReader->load(FCPATH.'assets/uploads/request/temp/'.$upload['name']);		 
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();	 
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        $k=0;
        for($i = 0; $i < 5; $i++){
        	$edu['edu'][$i] = $objWorksheet->getCellByColumnAndRow(2,$i+77)->getValue();
        	$edu['lev'][$i] = $objWorksheet->getCellByColumnAndRow(4,$i+77)->getValue();
        	$edu['maj'][$i] = $objWorksheet->getCellByColumnAndRow(7,$i+77)->getValue();
        	if(isset($edu['edu'][$i]) || isset($edu['lev'][$i]) || isset($edu['maj'][$i])){
        		echo '
					<tr><td>
						<input required name="educational_background[]" type="text" class="form-control" value="'.$edu['edu'][$i].'">
					</td><td>
						<input required name="level[]" type="text" class="form-control" value="'.$edu['lev'][$i].'">
					</td><td>
						<input required name="major[]" type="text" class="form-control" value="'.$edu['maj'][$i].'">
					</td><td>
						<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
					</td></tr>
				';
				$k++;
        	}
        }
        if($k<1){
    		echo '
				<tr><td>
					<input required name="educational_background[]" type="text" class="form-control" value="">
				</td><td>
					<input required name="level[]" type="text" class="form-control" value="">
				</td><td>
					<input required name="major[]" type="text" class="form-control" value="">
				</td><td>
					<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
				</td></tr>
			';
    	}
        unlink('./assets/uploads/request/temp/'.$upload['name']);
	}

	public function getDataFromExcelToExp(){
		$upload = $this->upload_form($_SESSION['pernr'], 'job_description-temp', date('Y-m-d_H:i:s'), 0);
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true); 		  
		$objPHPExcel=$objReader->load(FCPATH.'assets/uploads/request/temp/'.$upload['name']);		 
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();	 
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        $k=0;
        for($i = 0; $i < 5; $i++){
        	$exp['exp'][$i] = $objWorksheet->getCellByColumnAndRow(2,$i+84)->getValue();
        	$exp['year'][$i] = $objWorksheet->getCellByColumnAndRow(4,$i+84)->getValue();
        	$exp['note'][$i] = $objWorksheet->getCellByColumnAndRow(5,$i+84)->getValue();
        	if(isset($exp['exp'][$i]) || isset($exp['year'][$i]) || isset($exp['note'][$i])){
        		echo '
					<tr class="sub"><td>
					<table style="width:100%"><tr>
					<td class="left" style="width:150px">
						Experiences
					</td><td>
						<input required name="experience[]" type="text" class="form-control" value="'.$exp['exp'][$i].'">
					</td><td class="center" style="width:100px">
						Years
					</td><td style="width:100px">
						<input required name="year[]" type="number" class="form-control" min="0" value="'.$exp['year'][$i].'">
					</td><td style="width:40px">
						<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
					</td></tr>
					<tr><td colspan="4">
						<textarea name="expDesc[]" style="width:100%;height:150px;resize:none;border-color:#e5e5e5">'.$exp['note'][$i].'</textarea>
					</td><td></td>
					</tr></table>
					</td></tr>
				';
				$k++;
        	}
        }
        if($k<1){
    		echo '
				<tr class="sub"><td>
				<table style="width:100%"><tr>
				<td class="left" style="width:150px">
					Experiences
				</td><td>
					<input required name="experience[]" type="text" class="form-control" value="">
				</td><td class="center" style="width:100px">
					Years
				</td><td style="width:100px">
					<input required name="year[]" type="number" class="form-control" min="0" value="">
				</td><td style="width:40px">
					<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
				</td></tr>
				<tr><td colspan="4">
					<textarea name="expDesc[]" style="width:100%;height:150px;resize:none;border-color:#e5e5e5"></textarea>
				</td><td></td>
				</tr></table>
				</td></tr>
			';
    	}
        unlink('./assets/uploads/request/temp/'.$upload['name']);
	}

	public function getDataFromExcelToOth(){
		$upload = $this->upload_form($_SESSION['pernr'], 'job_description-temp', date('Y-m-d_H:i:s'), 0);
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true); 		  
		$objPHPExcel=$objReader->load(FCPATH.'assets/uploads/request/temp/'.$upload['name']);		 
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();	 
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        $k=0;
        for($i = 0; $i < 5; $i++){
        	$oth[$i] = $objWorksheet->getCellByColumnAndRow(2,$i+91)->getValue();
        	if(isset($oth[$i])){
        		echo '
					<tr>
						<td><input required name="other_qualification[]" type="text" class="form-control" value="'.$oth[$i].'"></td>
						<td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td>
					</tr>
				';
				$k++;
        	}
        }
        if($k<1){
    		echo '
				<tr>
					<td><input required name="other_qualification[]" type="text" class="form-control" value=""></td>
					<td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td>
				</tr>
			';
    	}
        unlink('./assets/uploads/request/temp/'.$upload['name']);
	}

	public function getDataFromExcelToLng(){
		$upload = $this->upload_form($_SESSION['pernr'], 'job_description-temp', date('Y-m-d_H:i:s'), 0);
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true); 		  
		$objPHPExcel=$objReader->load(FCPATH.'assets/uploads/request/temp/'.$upload['name']);		 
        $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();	 
        $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
        $k=0;
        for($i = 0; $i < 5; $i++){
        	$lang[$i] = $objWorksheet->getCellByColumnAndRow(2,$i+98)->getValue();
        	if(isset($lang[$i])){
        		echo '
					<tr>
						<td><input required name="foreign_language[]" type="text" class="form-control" value="'.$lang[$i].'"></td>
						<td style="width:100px"><select name="langQuality[]" class="form-control"><option selected>GOOD</option><option>FAIR</option></select></td>
						<td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td>
					</tr>
				';
				$k++;
        	}
        }
        if($k<1){
    		echo '
				<tr>
					<td><input required name="foreign_language[]" type="text" class="form-control" value=""></td>
					<td style="width:100px"><select name="langQuality[]" class="form-control"><option selected>GOOD</option><option>FAIR</option></select></td>
					<td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td>
				</tr>
			';
    	}
        unlink('./assets/uploads/request/temp/'.$upload['name']);
	}

	public function upload_form($request_no, $destination, $i, $j){
		//var_dump($_FILES);
		$destination = explode('-', $destination);
		if(sizeof($destination) > 1){
			$config['upload_path']   = './assets/uploads/request/'.$destination[1]; 
		} else {
			$config['upload_path']   = './assets/uploads/request/'.$destination[0]; 
		}
        //$config['allowed_types'] = '*'; 
        $config['allowed_types'] = 'gif|jpg|png|jpeg|docx|doc|xlsx|xls|ppt|pptx|pdf|PNG'; 
        $config['max_size']      = 10240;

        //echo "<br>";
        //var_dump($_FILES[$destination]);
        //echo "<br>";
        
        if(sizeof($destination) > 1){
        	$_FILES['upFile']['name'] = $request_no."---".$i."---temp.xlsx";
        } else {
        	$_FILES['upFile']['name'] = $request_no."---".$i."---".$_FILES[$destination[0]]['name'][$j];
        }
        $_FILES['upFile']['type'] = $_FILES[$destination[0]]['type'][$j];
        $_FILES['upFile']['tmp_name'] = $_FILES[$destination[0]]['tmp_name'][$j];
    	$_FILES['upFile']['error'] = $_FILES[$destination[0]]['error'][$j];
    	$_FILES['upFile']['size'] = $_FILES[$destination[0]]['size'][$j];
    	//echo "<br>";
    	//var_dump($_FILES['upFile']);
        $this->upload->initialize($config);
        
        $forReturn['upload'] = $this->upload->do_upload('upFile');
        if(sizeof($destination) > 1){
        	$forReturn['name'] = $request_no."---".$i."---temp.xlsx";
        	//unlink('./assets/uploads/request/temp/'.$forReturn['name']);
        } else {
        	$forReturn['name'] = $request_no."---".$i."---".$_FILES[$destination[0]]['name'][$j];
        }
        if ( ! $forReturn['upload']) {
        	$forReturn['error'] = array('error' => $this->upload->display_errors()); 
        	//$this->load->view('recruitement/create', $error); 
        }
        return $forReturn;
	}

	function selectSupperiorPlant(){
		$plant = $_POST['plant'];
		$plantAndEmployee = $this->Request_model->getUserSameOrBelowThisUser($_SESSION['pernr']);
		if(isset($_POST['request_no'])){
			$genReq = $this->Request_model->getGeneralRequest($_POST['request_no']);
			//var_dump($genReq);
		}
		for($i = 0; $i < sizeof($plantAndEmployee); $i++){
			if($plantAndEmployee[$i]['plant'] == $plant){
				$j=0;
				if(isset($genReq)){
					foreach ($plantAndEmployee[$i]['employee'] as $a) {
						if ($genReq['direct_superior'] == $a['user']) {
							echo '<option value="'.$a['user'].'" selected>'.$a['user'].' - '.$a['userName'].'</option>';
						}
						else {
							echo '<option value="'.$a['user'].'">'.$a['user'].' - '.$a['userName'].'</option>';
						}
						$j++;
					}
				} else {
					foreach ($plantAndEmployee[$i]['employee'] as $a) {
						if ($direct_superior == $a['user']) {
							echo '<option value="'.$a['user'].'" selected>'.$a['user'].' - '.$a['userName'].'</option>';
						}
						else { 
							if($j == 0){
								echo '<option value="'.$a['user'].'" selected>'.$a['user'].' - '.$a['userName'].'</option>';
							} else {
								echo '<option value="'.$a['user'].'">'.$a['user'].' - '.$a['userName'].'</option>';
							}
						}
						$j++;
					}
				}
				break;
			}
		}
	}

	public function uji($uji){
		//var_dump($this->Request_model->getUserSameOrBelowThisUser($uji));
		//echo "<br><br><br>";
		//var_dump($this->ess_model->get_all_department());
		//var_dump($this->ess_model->get_department_by_pernr($uji));
		//var_dump($this->Request_model->getGeneralRequest($uji));
		// var_dump($this->ess_model->get_all_plant());
		// echo substr('DN00', 0, 2);
		//die();
		$this->load->view('request/test1.html');
	}

	public function selectDepartment(){
		$plant = $_POST['plant'];
		$department = $this->ess_model->get_department_by_pernr($_SESSION['pernr']);
		if(isset($_POST['request_no'])){
			$genReq = $this->Request_model->getGeneralRequest($_POST['request_no']);
			foreach ($department as $value) {
				if ($plant == $value['werks']){
					if($genReq['department'] == $value['werks']){
						echo '<option selected class="'.$value['werks'].'" value="'.$value['btrtl'].'">'.$value['btrtl'].' - '.$this->ess_model->get_department($value['werks'], $value['btrtl']).'</option>';
					}
					echo '<option class="'.$value['werks'].'" value="'.$value['btrtl'].'">'.$value['btrtl'].' - '.$this->ess_model->get_department($value['werks'], $value['btrtl']).'</option>';
				}
			}
		} else {
			foreach ($department as $value) {
				if ($plant == $value['werks']){ 
					echo '<option class="'.$value['werks'].'" value="'.$value['btrtl'].'">'.$value['btrtl'].' - '.$this->ess_model->get_department($value['werks'], $value['btrtl']).'</option>';
				}
			}
		}
	}

	public function selectReplacement(){
		$plant = $_POST['plant'];
		$plantAndEmployee = $this->Request_model->getUserSameOrBelowThisUser($_SESSION['pernr']);
		for($i = 0; $i < sizeof($plantAndEmployee); $i++){
			if($plantAndEmployee[$i]['plant'] == $plant){
				$j=0;
				foreach ($plantAndEmployee[$i]['employee'] as $a) {
					if ($a['user'] != $_SESSION['pernr']) {
						if($j == 0){
							echo '<option value="'.$a['user'].'" selected>'.$a['user'].' - '.$a['userName'].'</option>';
						} else {
							echo '<option value="'.$a['user'].'">'.$a['user'].' - '.$a['userName'].'</option>';
						}
					}
					$j++;
				}
				break;
			}
		}
	}

	public function generateSelectForUpdate(){
		$plant = $_POST['plant'];
		$genReq = $this->Request_model->getGeneralRequest($_POST['request_no']);
		$nik = $this->Request_model->getReplacementRequest($_POST['request_no']);
		$plantAndEmployee = $this->Request_model->getUserSameOrBelowThisUser($_SESSION['pernr']);
		if($plant == $genReq['plant'] && sizeof($nik) > 0){
			$j=0;
			foreach ($nik as $key=>$value) if ($key >= 0) {
				echo '
				<tr><td>
				<select required name="nik[]" class="form-control">';
				for($i = 0; $i < sizeof($plantAndEmployee); $i++){
					if($plantAndEmployee[$i]['plant'] == $plant){						
						foreach ($plantAndEmployee[$i]['employee'] as $a) {
							if ($a['user'] != $_SESSION['pernr']) {
								if($nik[$j]['nik'] == $a['user']){
									echo '<option value="'.$a['user'].'" selected>'.$a['user'].' - '.$a['userName'].'</option>';
								} else {
									echo '<option value="'.$a['user'].'">'.$a['user'].' - '.$a['userName'].'</option>';
								}
							}
						}
						break;
					}
				}
				echo '
				</select>
				</td><td style="width:40px">
					<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
				</td></tr>';
				$j++;
			}
		} else {
			echo '
				<tr><td>
				<select required name="nik[]" class="form-control">';
			for($i = 0; $i < sizeof($plantAndEmployee); $i++){
				if($plantAndEmployee[$i]['plant'] == $plant){
					$j=0;
					foreach ($plantAndEmployee[$i]['employee'] as $a) {
						if ($a['user'] != $_SESSION['pernr']) {
							if($j == 0){
								echo '<option value="'.$a['user'].'" selected>'.$a['user'].' - '.$a['userName'].'</option>';
							} else {
								echo '<option value="'.$a['user'].'">'.$a['user'].' - '.$a['userName'].'</option>';
							}
						}
						$j++;
					}
					break;
				}
			}
			echo '</select>
				</td><td style="width:40px">
					<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
				</td></tr>';
		}
		
	}

	public function selectJobClassPlant(){
		$plant = $_POST['plant'];
		$job_class = $this->ess_model->get_all_job_class();
		if(isset($_POST['request_no'])){
			$genReq = $this->Request_model->getGeneralRequest($_POST['request_no']);
		}
		if(isset($genReq)){
			if (substr($plant, 0, 2)=='DN'||substr($plant, 0, 2)=='DP'||substr($plant, 0, 2)=='RX'||substr($plant, 0, 2)=='VM')
			{
				foreach ($job_class as $line) {
					if (substr($line->persk,0,1)=='Y'||substr($line->persk,0,1)=='Z'){
						if ($genReq['job_class']==$line->persk) {
							echo "<option value='".$line->persk."' selected>".$line->persk." - ".$line->ptext."</option>";
						}
						else{
							echo "<option value='".$line->persk."'>".$line->persk." - ".$line->ptext."</option>";
						}
					}
				}
			}
			elseif(substr($plant, 0, 2)!=''&&substr($plant, 0, 2)!='DN'&&substr($plant, 0, 2)!='DP'&&substr($plant, 0, 2)!='RX'&&substr($plant, 0, 2)!='VM')
			{
				foreach ($job_class as $line) {
					if (substr($line->persk,0,1)!='Y'&&substr($line->persk,0,1)!='Z') {
						echo "<option value='".$line->persk."'>".$line->persk." - ".$line->ptext."</option>";
					}
				}
			}
		}
		elseif(!isset($genReq))
		{
			if (substr($plant, 0, 2)=='DN'||substr($plant, 0, 2)=='DP'||substr($plant, 0, 2)=='RX'||substr($plant, 0, 2)=='VM')
			{
				foreach ($job_class as $line) {
					if (substr($line->persk,0,1)=='Y'||substr($line->persk,0,1)=='Z') {
						echo "<option value='".$line->persk."'>".$line->persk." - ".$line->ptext."</option>";
					}
				}
			}
			elseif(substr($plant, 0, 2)!=''&&substr($plant, 0, 2)!='DN'&&substr($plant, 0, 2)!='DP'&&substr($plant, 0, 2)!='RX'&&substr($plant, 0, 2)!='VM')
			{
				foreach ($job_class as $line) {
					if (substr($line->persk,0,1)!='Y'&&substr($line->persk,0,1)!='Z') {
						echo "<option value='".$line->persk."'>".$line->persk." - ".$line->ptext."</option>";
					}
				}
			}
		}
	}

	public function create()
	{
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}

		$data = $this->get_data(null);
		$data['from'] = "create";
		$this->load->view('request/create', $data);
	}
	
	public function createRequest(){
		if(isset($_POST['btnCreateSubmit'])){
			$plant = $_POST['plant'];
			$department = $_POST['department'];
			$position = $_POST['position'];
			$direct_superior = $_POST['direct_superior'];
			$budget = $_POST['budget'];
			$job_class = $_POST['job_class'];
			$number_of_employee = $_POST['number_of_employee'];
			$working_status = $_POST['working_status'];
			$expected_working_date = date('Y-m-d', strtotime($_POST['expected_working_date']));

			$reason = $_POST['reason'];
			$nik = $_POST['nik'];
			$request_note = $_POST['request_note'];
			$job_description = $_FILES['job_description']['name'];
			$supporting_document = $_FILES['supporting_document']['name'];

			$organisasi1 = $_POST['organisasi1'];
			$organisasi2 = $_POST['organisasi2'];
			$organisasi3 = $_POST['organisasi3'];
			$organisasi4 = $_POST['organisasi4'];
			$organisasi5 = $_POST['organisasi5'];
			
			$educational_background = $_POST['educational_background'];
			$level = $_POST['level'];
			$major = $_POST['major'];
			$experience = $_POST['experience'];
			$year = $_POST['year'];
			$expDesc = $_POST['expDesc'];
			$other_qualification = $_POST['other_qualification'];
			$foreign_language = $_POST['foreign_language'];
			$langQuality = $_POST['langQuality'];

			$newReqNo = $this->Request_model->getNewRequestId().'';
			$olUser = $_SESSION["pernr"];
			$now = date('Y-m-d H:i:s');
			var_dump($newReqNo);
			echo "<br>";
			$total = count($_FILES['job_description']['name']);
			$upload;			
			if($job_description[0] != ""){
				$i = 1;
				$j = 0;
				foreach ($job_description as $key) {
					//var_dump($_FILES['job_description']);
					if ($_FILES['job_description']['name'][$j]!="") {
						echo "<br>".$i."-".$j."<br>";
						var_dump($key);
						echo "<br>";
						$job_description[$j] = $newReqNo."---".$i."---".str_replace(" ", "_", $key);
						var_dump($job_description); 
						$upload = $this->upload_form($newReqNo, 'job_description', $i, $j);
						var_dump($upload);
						$i++;			
					}
					$j++;
				}
			}
			if(isset($upload['error'])){
				$error = $upload['error']['error'];
				echo "<script>alert('".$error."'); window.history.back();</script>";
				//header("location:javascript://history.go(-1)");
			}
			echo "<br>";
			$total = count($_FILES['supporting_document']['name']);
			$upload;			
			if($supporting_document[0] != ""){
				$i = 1;
				$j = 0;
				foreach ($supporting_document as $key) {
					//var_dump($_FILES['supporting_document']);
					if ($_FILES['supporting_document']['name'][$j]!="") {
						echo $i."---".$j."<br>";
						$supporting_document[$j] = $newReqNo."---".$i."---".str_replace(" ", "_", $key);
						$upload = $this->upload_form($newReqNo, 'supporting_document', $i, $j);
						var_dump($upload);
						$i++;			
					}
					$j++;
				}
			}
			if(isset($upload['error'])){
				$error = $upload['error']['error'];
				echo "<script>alert('".$error."'); window.history.back();</script>";
				//header("location:javascript://history.go(-1)");
			}
			$genReq = [
				'request_no' => $newReqNo,
				'plant' => $plant,
				'department' => $department,
				'position' => $position,
				'direct_superior' => $direct_superior,
				'job_class' => $job_class,
				'number_of_employee' => $number_of_employee,
				'working_status' => $working_status,
				'expected_working_date' => $expected_working_date,
				'in_the_budget' => $budget,
				'reason' => $reason,
				'note' => $request_note,
				'created_by' => $olUser,
				'created_at' => $now,
				'last_changed_by' => $olUser,
				'last_changed_at' => $now
			];
			$replacementReq = [];
			if($reason == 1){
				$i = 1;
				foreach ($nik as $key=>$value) {
					array_push($replacementReq, [
						'request_no' => $newReqNo,
						'item_no' => $i,
						'nik' => $value
					]);
					$i++;
				}
			}
			//var_dump($replacementReq);
			$jobDescReq = [];
			$i = 1;
			foreach ($job_description as $key => $value) {
				if($value!=""){
					array_push($jobDescReq, [
						'request_no' => $newReqNo,
						'item_no' => $i,
						'file_name' => $value
					]);
					$i++;
				}			
			}
			//var_dump($jobDescReq);
			$supportDocReq = [];
			$i = 1;
			foreach ($supporting_document as $key => $value) {
				if($value!=""){
					array_push($supportDocReq, [
						'request_no' => $newReqNo,
						'item_no' => $i,
						'file_name' => $value
					]);
					$i++;
				}			
			}
			//var_dump($supportDocReq);
			$organisasi = [];
			$organisasi = [
				'request_no' => $newReqNo,
				'col1' => $organisasi1,
				'col2' => $organisasi2,
				'col3' => $organisasi3,
				'col4' => $organisasi4,
				'col5' => $organisasi5,
			];
			//var_dump($organisasi);
			$eduBackReq = [];
			$j = 1;
			for($i = 0; $i < sizeof($educational_background); $i++){
				if($educational_background[$i]!="" && $level[$i]!="" && $major[$i]!=""){
					array_push($eduBackReq, [
						'request_no' => $newReqNo,
						'item_no' => $j,
						'educational_background' => $educational_background[$i],
						'level' => $level[$i],
						'major' => $major[$i]
					]);
					$j++;
				}
			}
			//var_dump($eduBackReq);
			$experienceReq = [];
			$j = 1;
			for($i = 0; $i < sizeof($experience); $i++){
				if($experience[$i]!="" && $year[$i]!="" && $expDesc[$i]!=""){
					array_push($experienceReq, [
						'request_no' => $newReqNo,
						'item_no' => $j,
						'experience' => $experience[$i],
						'year' => $year[$i],
						'note' => $expDesc[$i]
					]);
					$j++;
				}
			}
			//var_dump($experienceReq);
			$otherQualificationReq = [];
			$i = 1;
			foreach ($other_qualification as $key => $value) {
				if($value!=""){
					array_push($otherQualificationReq, [
						'request_no' => $newReqNo,
						'item_no' => $i,
						'other_qualification' => $value
					]);
					$i++;
				}			
			}
			//var_dump($otherQualificationReq);
			$foreignLangReq = [];
			$j = 1;
			for($i = 0; $i < sizeof($foreign_language); $i++){
				if($foreign_language[$i]!="" && $langQuality[$i]!=""){
					array_push($foreignLangReq, [
						'request_no' => $newReqNo,
						'item_no' => $j,
						'foreign_language' => $foreign_language[$i],
						'score' => $langQuality[$i]
					]);
					$j++;
				}
			}
			$this->Request_model->createNewRequest($genReq, $replacementReq, $jobDescReq, $supportDocReq, $organisasi, $eduBackReq, $experienceReq, $otherQualificationReq, $foreignLangReq);
			//var_dump($foreignLangReq);
			$approvalNewReq = [
					'request_no' => $newReqNo,
					'item_no' => 1,
					'approval_code' => "CR",
					'approved_by' => $olUser,
					'approved_at' => $now,
					'status' => '1'
				];
			$this->Request_model->insertApproval($approvalNewReq);
			$nextApproval = $this->Request_model->getNextApproval($newReqNo, $olUser);
			$approvalNewReq = [
					'request_no' => $newReqNo,
					'item_no' => 2,
					'approval_code' => $nextApproval['code'],
					'approved_by' => '',
					'approved_at' => "0000-00-00 00:00:00",
					'status' => ''
				];
			$this->Request_model->insertApproval($approvalNewReq);
			//var_dump($nextApproval);
			//header('localtion:'.base_url().'request/create00');
			//header_remove();
			$this->Sendmail_model->sendmail($newReqNo);
			
			redirect(base_url().'request/History');
		} else {
			redirect(base_url().'request/create');
		}
	}

	public function changeAllList(){
		$data = $this->get_data(null);
		$olUser['pernr'] = $_SESSION["pernr"];
		$olUser['email'] = $_SESSION['email'];
		$olUser['ename'] = $_SESSION['ename'];
		//var_dump($olUser);
		$genReq = $this->Request_model->getAllUserGeneralRequest($olUser['pernr']);
		$data['olUser'] = $olUser;
		$data['from'] = 'change';
		$forTbRequest = [];
		foreach ($genReq as $value) {
			$request_status = "";
			$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($value['request_no']);
			/*var_dump($value['request_no'], $reqStatQuery['status']);
			echo "<br>";*/
			if($reqStatQuery['status'] == ""){
				$request_status = "Waiting Approval ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			} else if($reqStatQuery['status'] == "0"){
				$request_status = "Rejected at ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			} else if($reqStatQuery['status'] == "1"){
				if ($reqStatQuery['approval_code'] == 'CL')
				$request_status = $this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
				else
				$request_status = "Accepted ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
			if(($reqStatQuery['item_no'] == "2" && $reqStatQuery['status'] == "") || ($reqStatQuery['item_no'] > 1 && $reqStatQuery['status'] == "0")){
				array_push($forTbRequest, [
					'request_no' => $value['request_no'],
					'position' => $value['position'],
					'reason' => $this->Request_model->getReasonName($value['reason'])['description'],
					'working_status' => $this->Request_model->getWorkingStatusName($value['reason'])['description'],
					'number_of_employee' => $value['number_of_employee'],
					'created_by' => $this->ess_model->get_name($value['created_by']),
					'department' => $this->ess_model->get_department($value['plant'], $value['department']),
					'created_on' => date('d.m.Y', strtotime($value['created_at'])),
					'request_status' => $request_status,
					'recruitment_status' => $this->Request_model->getHiringStatus($value['request_no'])
				]);
			}
		}
		//var_dump($forTbRequest);
		//die();
		$data['forTbRequest'] = $forTbRequest;
		//var_dump($forTbRequest);
		$this->load->view('request/changeAllList', $data);
	}

	public function change()
	{
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		if(isset($_GET['no'])){
			$request_no = $_GET['no'];
		} else {
			redirect(base_url().'request/changeAllList');
		}
		$data = $this->get_data('1');
		$data['genReq'] = $this->Request_model->getGeneralRequest($request_no);
		$data['replacementReq'] = $this->Request_model->getReplacementRequest($request_no);
		$data['jobDescReq'] = $this->Request_model->getJobDescRequest($request_no);
		$data['supportDocReq'] = $this->Request_model->getSupportDocRequest($request_no);
		$strukturOrganisasi = $this->Request_model->getStrukturOrganisasi($request_no);
		if(isset($strukturOrganisasi)){
			$data['strukturOrganisasi'] = $strukturOrganisasi;
		}
		$data['eduBackReq'] = $this->Request_model->getEducationBackgroundRequest($request_no);
		$data['experienceReq'] = $this->Request_model->getExperienceRequest($request_no);
		$data['otherQualificationReq'] = $this->Request_model->getOtherQualificationRequest($request_no);
		$data['foreignLangReq'] = $this->Request_model->getForeignLangRequest($request_no);
		$strukturOrganisasi = $this->Request_model->getStrukturOrganisasi($request_no);
		if(isset($strukturOrganisasi)){
			$data['strukturOrganisasi'] = $strukturOrganisasi;
		}
		$data['request_no'] = $request_no;
		$data['from'] = "change";
		//var_dump($data['foreignLangReq']);
		$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($data['genReq']['request_no']);
		if($_SESSION['pernr'] != $data['genReq']['created_by'] || ($reqStatQuery['item_no'] != "2") && $reqStatQuery['status'] != '0') {
			redirect(base_url()."request/changeAllList");
		}
		/*var_dump($_SESSION['pernr']);
		var_dump($data['genReq']['created_by']);*/

		$this->load->view('request/change', $data);
	}

	public function changeRequest($request_no){
		//var_dump($this->Request_model->getLastItemId($request_no, 't_request_supporting_document'));
		
		
		if(isset($_POST['btnCreateSubmit'])){
			$plant = $_POST['plant'];
			$department = $_POST['department'];
			$position = $_POST['position'];
			$direct_superior = $_POST['direct_superior'];
			$budget = $_POST['budget'];
			$job_class = $_POST['job_class'];
			$number_of_employee = $_POST['number_of_employee'];
			$working_status = $_POST['working_status'];
			$expected_working_date = date('Y-m-d', strtotime($_POST['expected_working_date']));

			$reason = $_POST['reason'];
			$nik = $_POST['nik'];
			$request_note = $_POST['request_note'];
			$job_description = $_FILES['job_description']['name'];
			if(isset($_POST['job_description_show'])){
				$job_description_show = $_POST['job_description_show'];
			}
			$supporting_document = $_FILES['supporting_document']['name'];
			if(isset($_POST['supporting_document_show'])){
				$supporting_document_show = $_POST['supporting_document_show'];
			}
			//var_dump($job_description_show);

			$organisasi1 = $_POST['organisasi1'];
			$organisasi2 = $_POST['organisasi2'];
			$organisasi3 = $_POST['organisasi3'];
			$organisasi4 = $_POST['organisasi4'];
			$organisasi5 = $_POST['organisasi5'];
		
			$educational_background = $_POST['educational_background'];
			$level = $_POST['level'];
			$major = $_POST['major'];
			$experience = $_POST['experience'];
			$year = $_POST['year'];
			$expDesc = $_POST['expDesc'];
			$other_qualification = $_POST['other_qualification'];
			$foreign_language = $_POST['foreign_language'];
			$langQuality = $_POST['langQuality'];

			$olUser = $_SESSION["pernr"];
			$now = date('Y-m-d H:i:s');
			$newReqNo = $request_no;
			var_dump($request_no);
			echo "<br>";
			$total = count($_FILES['job_description']['name']);
			$upload;			
			if($job_description[0] != ""){
				$i = $i = $this->Request_model->getLastItemId($request_no, 't_request_job_description');
				$j = 0;
				foreach ($job_description as $key) {
					//var_dump($_FILES['job_description']);
					if ($_FILES['job_description']['name'][$j]!="") {
						echo "<br>".$i."---".$j."<br>";
						var_dump($key);
						echo "<br>";
						$job_description[$j] = $newReqNo."---".$i."---".str_replace(" ", "_", $key);
						var_dump($job_description); 
						$upload = $this->upload_form($newReqNo, 'job_description', $i, $j);
						//var_dump($upload);
						$i++;			
					}
					$j++;
				}
			}
			if(isset($upload['error'])){
				$error = $upload['error']['error'];
				echo "<script>alert('".$error."'); window.history.back();</script>";
				//header("location:javascript://history.go(-1)");
			}
			echo "<br>";
			$total = count($_FILES['supporting_document']['name']);
			$upload;			
			if($supporting_document[0] != ""){
				$i = $i = $this->Request_model->getLastItemId($request_no, 't_request_supporting_document');
				$j = 0;
				foreach ($supporting_document as $key) {
					//var_dump($_FILES['supporting_document']);
					if ($_FILES['supporting_document']['name'][$j]!="") {
						echo $i."-".$j."<br>";
						$supporting_document[$j] = $newReqNo."---".$i."---".str_replace(" ", "_", $key);
						$upload = $this->upload_form($newReqNo, 'supporting_document', $i, $j);
						//var_dump($upload);
						$i++;			
					}
					$j++;
				}
			}
			if(isset($upload['error'])){
				$error = $upload['error']['error'];
				echo "<script>alert('".$error."'); window.history.back();</script>";
				//header("location:javascript://history.go(-1)");
			}
			//var_dump($upload);
		
			$genReq = [
				'plant' => $plant,
				'department' => $department,
				'position' => $position,
				'direct_superior' => $direct_superior,
				'job_class' => $job_class,
				'number_of_employee' => $number_of_employee,
				'working_status' => $working_status,
				'expected_working_date' => $expected_working_date,
				'in_the_budget' => $budget,
				'reason' => $reason,
				'note' => $request_note,
				'last_changed_by' => $olUser,
				'last_changed_at' => $now
			];
			//var_dump($genReq);
			$replacementReq = [];
			if($reason == 1){
				$i = 1;
				foreach ($nik as $key=>$value) {
					array_push($replacementReq, [
						'request_no' => $request_no,
						'item_no' => $i,
						'nik' => $value
					]);
					$i++;
				}
			}
			//var_dump($replacementReq);
			$jobDescReq = [];
			if(isset($job_description_show)){
				foreach ($job_description_show as $key => $value) {
					if($value!=""){
						array_push($jobDescReq, [
							'request_no' => $request_no,
							'item_no' => explode("---", $value)[1],
							'file_name' => $value
						]);
					}			
				}
			}		
			$i = $this->Request_model->getLastItemId($request_no, 't_request_job_description');
			foreach ($job_description as $key => $value) {
				if($value!=""){
					array_push($jobDescReq, [
						'request_no' => $request_no,
						'item_no' => $i,
						'file_name' => $value
					]);
					$i++;
				}			
			}

			$supportDocReq = [];
			if(isset($supporting_document_show)){
				foreach ($supporting_document_show as $key => $value) {
					if($value!=""){
						array_push($supportDocReq, [
							'request_no' => $request_no,
							'item_no' => explode("---", $value)[1],
							'file_name' => $value
						]);
					}			
				}
			}
			//var_dump($supportDocReq);
			$organisasi = [];
			$organisasi = [
				'request_no' => $newReqNo,
				'col1' => $organisasi1,
				'col2' => $organisasi2,
				'col3' => $organisasi3,
				'col4' => $organisasi4,
				'col5' => $organisasi5,
			];
			//var_dump($organisasi);
			$i = $this->Request_model->getLastItemId($request_no, 't_request_supporting_document');
			foreach ($supporting_document as $key => $value) {
				if($value!=""){
					array_push($supportDocReq, [
						'request_no' => $request_no,
						'item_no' => $i,
						'file_name' => $value
					]);
					$i++;
				}			
			}
			//var_dump($supportDocReq);
			$eduBackReq = [];
			$j = 1;
			for($i = 0; $i < sizeof($educational_background); $i++){
				if($educational_background[$i]!="" && $level[$i]!="" && $major[$i]!=""){
					array_push($eduBackReq, [
						'request_no' => $request_no,
						'item_no' => $j,
						'educational_background' => $educational_background[$i],
						'level' => $level[$i],
						'major' => $major[$i]
					]);
					$j++;
				}
			}
			//var_dump($eduBackReq);
			$experienceReq = [];
			$j = 1;
			for($i = 0; $i < sizeof($experience); $i++){
				if($experience[$i]!="" && $year[$i]!="" && $expDesc[$i]!=""){
					array_push($experienceReq, [
						'request_no' => $request_no,
						'item_no' => $j,
						'experience' => $experience[$i],
						'year' => $year[$i],
						'note' => $expDesc[$i]
					]);
					$j++;
				}
			}
			//var_dump($experienceReq);
			$otherQualificationReq = [];
			$i = 1;
			foreach ($other_qualification as $key => $value) {
				if($value!=""){
					array_push($otherQualificationReq, [
						'request_no' => $request_no,
						'item_no' => $i,
						'other_qualification' => $value
					]);
					$i++;
				}			
			}
			//var_dump($otherQualificationReq);
			$foreignLangReq = [];
			$j = 1;
			for($i = 0; $i < sizeof($foreign_language); $i++){
				if($foreign_language[$i]!="" && $langQuality[$i]!=""){
					array_push($foreignLangReq, [
						'request_no' => $request_no,
						'item_no' => $j,
						'foreign_language' => $foreign_language[$i],
						'score' => $langQuality[$i]
					]);
					$j++;
				}
			}
			//var_dump($foreignLangReq);
			$lastApprovalRequest = $this->Request_model->getAllLastApprovalRequest($request_no);
			if($lastApprovalRequest['status'] == "0"){
				$this->Request_model->upadteApprovalAfterReject($request_no);
				$this->Sendmail_model->sendmail($request_no);
			}
			$this->Request_model->changeRequest($request_no, $genReq, $replacementReq, $jobDescReq, $supportDocReq, $organisasi, $eduBackReq, $experienceReq, $otherQualificationReq, $foreignLangReq);
			redirect('request/history');
		} else if(isset($_POST['btnDelete'])){
			$genReq = $data['genReq'] = $this->Request_model->getGeneralRequest($request_no);
			$olUser = $_SESSION['pernr'];
			$lastApprovalRequest = $this->Request_model->getAllLastApprovalRequest($request_no);
			$approve = "3";
			$now = date('Y-m-d H:i:s');
			$updateApproval = [
				'approved_by' => $olUser,
				'approved_at' => $now,
				'status' => $approve
			];
			$this->Request_model->updateApproval($request_no, $lastApprovalRequest['item_no'] + 0, $updateApproval);
			redirect('request/changeAllList');
		} else {
			$this->change();
		}
	}


	# START OF Pending #
	public function pending()
	{
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		if(isset($_GET['no'])){
			$request_no = $_GET['no'];
		} else {
			redirect(base_url().'request/pendingAllList');
		}
		$data = $this->get_data('1');
		$data['genReq'] = $this->Request_model->getGeneralRequest($request_no);
		$data['replacementReq'] = $this->Request_model->getReplacementRequest($request_no);
		$data['jobDescReq'] = $this->Request_model->getJobDescRequest($request_no);
		$data['supportDocReq'] = $this->Request_model->getSupportDocRequest($request_no);
		$strukturOrganisasi = $this->Request_model->getStrukturOrganisasi($request_no);
		if(isset($strukturOrganisasi)){
			$data['strukturOrganisasi'] = $strukturOrganisasi;
		}
		$data['eduBackReq'] = $this->Request_model->getEducationBackgroundRequest($request_no);
		$data['experienceReq'] = $this->Request_model->getExperienceRequest($request_no);
		$data['otherQualificationReq'] = $this->Request_model->getOtherQualificationRequest($request_no);
		$data['foreignLangReq'] = $this->Request_model->getForeignLangRequest($request_no);
		$data['request_no'] = $request_no;
		$data['from'] = "pending";
		$data['approvalReq'] = $this->Request_model->getApprovalRequest($request_no);
		$data['milestone'] = $this->request_model->getMilestone($data['genReq']['created_by'], $data['genReq']['plant']);
		$data['allApprovalUser'] = $this->Request_model->getApprovalUserWithName($request_no, $data['genReq']['created_by']);
		//var_dump($data['foreignLangReq']);
		if($_SESSION['pernr'] != $data['genReq']['created_by']) redirect(base_url()."request/pendingAllList");
		/*var_dump($_SESSION['pernr']);
		var_dump($data['genReq']['created_by']);*/
		$this->load->view('request/pending', $data);
	}
	public function pendingAllList(){
		$data = $this->get_data(null);
		$olUser['pernr'] = $_SESSION["pernr"];
		$olUser['email'] = $_SESSION['email'];
		$olUser['ename'] = $_SESSION['ename'];
		//var_dump($olUser);
		$genReq = $this->Request_model->getAllUserGeneralRequest($olUser['pernr']);
		$data['olUser'] = $olUser;
		$data['from'] = "pending";
		$forTbRequest = [];
		foreach ($genReq as $value) {
			$request_status = "";
			//echo "<br><br><br><br><br><br><br>";
			$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($value['request_no']);
			if($reqStatQuery['status'] == ""){
				$request_status = "Waiting Approval ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
					array_push($forTbRequest, [
						'request_no' => $value['request_no'],
						'position' => $value['position'],
						'reason' => $this->Request_model->getReasonName($value['reason'])['description'],
						'working_status' => $this->Request_model->getWorkingStatusName($value['reason'])['description'],
						'number_of_employee' => $value['number_of_employee'],
						'created_by' => $this->ess_model->get_name($value['created_by']),
						'department' => $this->ess_model->get_department($value['plant'], $value['department']),
						'created_on' => date('d.m.Y', strtotime($value['created_at'])),
						'request_status' => $request_status,
						'recruitment_status' => $this->Request_model->getHiringStatus($value['request_no']),
					]);
			}
			else if($reqStatQuery['status'] == "0"){
				$request_status = "Rejected by ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			} else if($reqStatQuery['status'] == "1"){
				if ($reqStatQuery['approval_code'] == 'CL')
				$request_status = $this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
				else
				$request_status = "Accepted ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
		}
		$data['forTbRequest'] = $forTbRequest;
		//var_dump($forTbRequest);
		$this->load->view('request/changeAllList', $data);
	}
	# END OF Pending #

	# START OF History #
	function history(){
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		if(isset($_GET['no'])){
			$request_no = $_GET['no'];
		} else {
			redirect(base_url().'request/historyAllList');
		}
		$data = $this->get_data('1');
		$data['genReq'] = $this->Request_model->getGeneralRequest($request_no);
		$data['replacementReq'] = $this->Request_model->getReplacementRequest($request_no);
		$data['jobDescReq'] = $this->Request_model->getJobDescRequest($request_no);
		$data['supportDocReq'] = $this->Request_model->getSupportDocRequest($request_no);
		$strukturOrganisasi = $this->Request_model->getStrukturOrganisasi($request_no);
		if(isset($strukturOrganisasi)){
			$data['strukturOrganisasi'] = $strukturOrganisasi;
		}
		$data['eduBackReq'] = $this->Request_model->getEducationBackgroundRequest($request_no);
		$data['experienceReq'] = $this->Request_model->getExperienceRequest($request_no);
		$data['otherQualificationReq'] = $this->Request_model->getOtherQualificationRequest($request_no);
		$data['foreignLangReq'] = $this->Request_model->getForeignLangRequest($request_no);
		$data['request_no'] = $request_no;
		$data['from'] = "history";
		$data['approvalReq'] = $this->Request_model->getApprovalRequest($request_no);
		$data['milestone'] = $this->request_model->getMilestone($data['genReq']['created_by'], $data['genReq']['plant']);
		$data['allApprovalUser'] = $this->Request_model->getApprovalUserWithName($request_no, $data['genReq']['created_by']);
		$data['olUser'] = $_SESSION['pernr'];
		$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($request_no);
		$applicant = $this->Request_model->getApplicantFromRequestNo($request_no);
		for($i = 0; $i < sizeof($applicant); $i++){
			$applicant[$i]['status'] = $this->Recruitment_model-> get_status_applicant($applicant[$i]['applicant_no'],$request_no);
		}
		if(sizeof($applicant) > 0){
			$data['applicant'] = $applicant;
		}
		if($reqStatQuery['status'] == 0){
			$data['rejectHistory'] = $this->Request_model->getLastRejectHistory($request_no);
			/*var_dump($data['rejectHistory']);
			die();*/
		}
		//var_dump($data['foreignLangReq']);
		if($_SESSION['pernr'] != $data['genReq']['created_by']) redirect(base_url()."request/changeAllList");
		/*var_dump($_SESSION['pernr']);
		var_dump($data['genReq']['created_by']);*/
		$this->load->view('request/history', $data);
	}
	public function historyAllList(){
		$data = $this->get_data(null);
		$olUser['pernr'] = $_SESSION["pernr"];
		$olUser['email'] = $_SESSION['email'];
		$olUser['ename'] = $_SESSION['ename'];
		//var_dump($olUser);
		$genReq = $this->Request_model->getAllUserGeneralRequest($olUser['pernr']);
		$data['olUser'] = $olUser;
		$data['from'] = 'history';
		$forTbRequest = [];
		foreach ($genReq as $value) {
			$request_status = "";
			//echo "<br><br><br><br><br><br><br>";
			$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($value['request_no']);
			if($reqStatQuery['status'] == ""){
				$request_status = "Waiting Approval ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
			else if($reqStatQuery['status'] == "0"){
				$request_status = "Rejected by ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
			else if($reqStatQuery['status'] == "3"){
				$request_status = "Deleted";
			} 
			else if($reqStatQuery['status'] == "1"){
				if ($reqStatQuery['approval_code'] == 'CL')
				$request_status = $this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
				else
				$request_status = "Accepted ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
			array_push($forTbRequest, [
						'request_no' => $value['request_no'],
						'position' => $value['position'],
						'reason' => $this->Request_model->getReasonName($value['reason'])['description'],
						'working_status' => $this->Request_model->getWorkingStatusName($value['reason'])['description'],
						'number_of_employee' => $value['number_of_employee'],
						'created_by' => $this->ess_model->get_name($value['created_by']),
						'department' => $this->ess_model->get_department($value['plant'], $value['department']),
						'created_on' => date('d.m.Y', strtotime($value['created_at'])),
						'request_status' => $request_status,
						'recruitment_status' => $this->Request_model->getHiringStatus($value['request_no']),
					]);
		}
		$data['forTbRequest'] = $forTbRequest;
		//var_dump($forTbRequest);
		$this->load->view('request/changeAllList', $data);
	}
	# END OF History #

	# START OF Report #
	function report(){
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		if(isset($_GET['no'])){
			$request_no = $_GET['no'];
		} else {
			redirect(base_url().'request/reportAllList');
		}
		$data = $this->get_data('1');
		$data['genReq'] = $this->Request_model->getGeneralRequest($request_no);
		$data['replacementReq'] = $this->Request_model->getReplacementRequest($request_no);
		$data['jobDescReq'] = $this->Request_model->getJobDescRequest($request_no);
		$data['supportDocReq'] = $this->Request_model->getSupportDocRequest($request_no);
		$strukturOrganisasi = $this->Request_model->getStrukturOrganisasi($request_no);
		if(isset($strukturOrganisasi)){
			$data['strukturOrganisasi'] = $strukturOrganisasi;
		}
		$data['eduBackReq'] = $this->Request_model->getEducationBackgroundRequest($request_no);
		$data['experienceReq'] = $this->Request_model->getExperienceRequest($request_no);
		$data['otherQualificationReq'] = $this->Request_model->getOtherQualificationRequest($request_no);
		$data['foreignLangReq'] = $this->Request_model->getForeignLangRequest($request_no);
		$data['request_no'] = $request_no;
		$data['from'] = "report";
		$data['approvalReq'] = $this->Request_model->getApprovalRequest($request_no);
		$data['milestone'] = $this->request_model->getMilestone($data['genReq']['created_by'], $data['genReq']['plant']);
		$data['allApprovalUser'] = $this->Request_model->getApprovalUserWithName($request_no, $data['genReq']['created_by']);
		$data['from'] = "report";
		$data['olUser'] = $_SESSION['pernr'];
		$applicant = $this->Request_model->getApplicantFromRequestNo($request_no);
		for($i = 0; $i < sizeof($applicant); $i++){
			$applicant[$i]['status'] = $this->Recruitment_model-> get_status_applicant($applicant[$i]['applicant_no'],$request_no);
		}
		if(sizeof($applicant) > 0){
			$data['applicant'] = $applicant;
		}
		$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($request_no);
		if($reqStatQuery['status'] == 0){
			$data['rejectHistory'] = $this->Request_model->getLastRejectHistory($request_no);
			/*var_dump($data['rejectHistory']);
			die();*/
		}
		//if($_SESSION['pernr'] != $data['genReq']['created_by']) redirect(base_url()."request/reportAllList");
		$this->load->view('request/report', $data);
	}
	public function reportAllList(){
		$data = $this->get_data(null);
		$olUser['pernr'] = $_SESSION["pernr"];
		$olUser['email'] = $_SESSION['email'];
		$olUser['ename'] = $_SESSION['ename'];
		$genReq = $this->Request_model->getTargetGeneralRequestReport($olUser['pernr']);
		$data['olUser'] = $olUser;
		$data['from'] = 'report';
		$forTbRequest = [];
		foreach ($genReq as $value) {
			$request_status = "";
			$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($value['request_no']);
			if($reqStatQuery['status'] == ""){
				$request_status = "Waiting Approval ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
			else if($reqStatQuery['status'] == "3"){
				$request_status = "Deleted";
			} 
			else if($reqStatQuery['status'] == "0"){
				$request_status = "Rejected by ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			} else if($reqStatQuery['status'] == "1"){
				if ($reqStatQuery['approval_code'] == 'CL')
				$request_status = $this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
				else
				$request_status = "Accepted ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
			array_push($forTbRequest, [
						'request_no' => $value['request_no'],
						'position' => $value['position'],
						'reason' => $this->Request_model->getReasonName($value['reason'])['description'],
						'working_status' => $this->Request_model->getWorkingStatusName($value['reason'])['description'],
						'number_of_employee' => $value['number_of_employee'],
						'created_by' => $this->ess_model->get_name($value['created_by']),
						'department' => $this->ess_model->get_department($value['plant'], $value['department']),
						'created_on' => date('d.m.Y', strtotime($value['created_at'])),
						'request_status' => $request_status,
						'recruitment_status' => $this->Request_model->getHiringStatus($value['request_no'])
					]);
		}
		/*var_dump($forTbRequest);
		die();*/
		$data['forTbRequest'] = $forTbRequest;
		$this->load->view('request/reportAllList', $data);
	}
	# END OF Report #

	public function approvalPendingAllList(){
		$data = $this->get_data(null);
		$olUser['pernr'] = $_SESSION["pernr"];
		$olUser['email'] = $_SESSION['email'];
		$olUser['ename'] = $_SESSION['ename'];
		//var_dump($olUser);
		/*$userFromTarget = $this->Request_model->getUserFromTarget($olUser['pernr']);
		$genReq = [];
		foreach ($userFromTarget as $value) {
			if(isset())
		}*/
		$genReq = $this->Request_model->getTargetGeneralRequestPendingApprove($olUser['pernr']);
		$data['olUser'] = $olUser;
		$data['from'] = 'approvalPending';
		/*var_dump($genReq);
		die();*/
		$forTbRequest = [];
		foreach ($genReq as $value) {
			$request_status = "";
			//echo "<br><br><br><br><br><br><br>";
			$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($value['request_no']);
			if($reqStatQuery['status'] == ""){
				$request_status = "Waiting Approval ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			} else if($reqStatQuery['status'] == "0"){
				$request_status = "Rejected by ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			} else if($reqStatQuery['status'] == "1"){
				if ($reqStatQuery['approval_code'] == 'CL')
				$request_status = $this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
				else
				$request_status = "Accepted ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
			}
			if($reqStatQuery['status'] == ""/* && $flagUser == 1*/){
				array_push($forTbRequest, [
					'request_no' => $value['request_no'],
					'position' => $value['position'],
					'reason' => $this->Request_model->getReasonName($value['reason'])['description'],
					'working_status' => $this->Request_model->getWorkingStatusName($value['reason'])['description'],
					'number_of_employee' => $value['number_of_employee'],
					'created_by' => $this->ess_model->get_name($value['created_by']),
					'plant' => $value['plant'],
					'department' => $this->ess_model->get_department($value['plant'], $value['department']),
					'created_on' => date('d.m.Y', strtotime($value['created_at']))
				]);
			}
		}
		$data['forTbRequest'] = $forTbRequest;
		//var_dump($forTbRequest);
		$this->load->view('request/approvalPendingAllList', $data);
	}

	public function approval_pending(){
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		if(isset($_GET['no'])){
			$request_no = $_GET['no'];
		} else {
			redirect(base_url().'request/approvalPendingAllList');
		}
		$olUser = $_SESSION["pernr"];
		$data = $this->get_data('1');
		$data['genReq'] = $this->Request_model->getGeneralRequest($request_no);
		$data['replacementReq'] = $this->Request_model->getReplacementRequest($request_no);
		$data['jobDescReq'] = $this->Request_model->getJobDescRequest($request_no);
		$data['supportDocReq'] = $this->Request_model->getSupportDocRequest($request_no);
		$strukturOrganisasi = $this->Request_model->getStrukturOrganisasi($request_no);
		if(isset($strukturOrganisasi)){
			$data['strukturOrganisasi'] = $strukturOrganisasi;
		}
		$data['eduBackReq'] = $this->Request_model->getEducationBackgroundRequest($request_no);
		$data['experienceReq'] = $this->Request_model->getExperienceRequest($request_no);
		$data['otherQualificationReq'] = $this->Request_model->getOtherQualificationRequest($request_no);
		$data['foreignLangReq'] = $this->Request_model->getForeignLangRequest($request_no);
		$data['approvalReq'] = $this->Request_model->getApprovalRequest($request_no);
		$data['milestone'] = $this->request_model->getMilestone($data['genReq']['created_by'], $data['genReq']['plant']);
		$data['allApprovalUser'] = $this->Request_model->getApprovalUserWithName($request_no, $data['genReq']['created_by']);
		$data['request_no'] = $request_no;
		$data['from'] = "approvalPending";
		$data['countHired'] = 0;
		$applicant = $this->Request_model->getApplicantFromRequestNo($request_no);
		for($i = 0; $i < sizeof($applicant); $i++){
			$applicant[$i]['status'] = $this->Recruitment_model-> get_status_applicant($applicant[$i]['applicant_no'],$request_no);
			if($applicant[$i]['status'] == "Hired"){
				$data['countHired']++;
			}
		}
		if(sizeof($applicant) > 0){
			$data['applicant'] = $applicant;
		}
		$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($request_no);
		$data['reqStatQuery'] = $reqStatQuery;
		$approvalTarget = $this->Request_model->getLastApprovalTarget($request_no, $data['genReq']['created_by'], $reqStatQuery['approval_code']);
		$flag = 0;
		foreach ($approvalTarget as $value) {
			if($value == $olUser){
				$flag = 1;
				break;
			}
		}
		if($flag == 1){
			$this->load->view('request/approvalPending', $data);
		} else {
			redirect(base_url().'request/approvalPendingAllList');
		}
	}

	public function makeApproval($request_no){
		$approve = $_POST['approve'];
		$olUser = $_SESSION["pernr"];
		$now = date('Y-m-d H:i:s');
		$genReq = $this->Request_model->getGeneralRequest($request_no);
		$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($request_no);
		$updateApproval = [
			'approved_by' => $olUser,
			'approved_at' => $now,
			'status' => $approve
		];
		$this->Request_model->updateApproval($request_no, $reqStatQuery['item_no'] + 0, $updateApproval);
		/*var_dump($reqStatQuery);
		die();*/
		if($approve == 1 && $reqStatQuery['approval_code'] != 'CL'){
			//die();
			$nextApproval = $this->Request_model->getNextApproval($request_no, $genReq['created_by']);
			$approvalNewReq = [
					'request_no' => $request_no,
					'item_no' => $reqStatQuery['item_no'] + 1,
					'approval_code' => $nextApproval['code'],
					'approved_by' => '',
					'approved_at' => "0000-00-00 00:00:00",
					'status' => ''
				];
			$this->Request_model->insertApproval($approvalNewReq);
			while (true) {
				$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($request_no);
				$approvalTarget = $this->Request_model->getLastApprovalTarget($request_no, $genReq['created_by'], $reqStatQuery['approval_code']);
				if((sizeof($approvalTarget) > 1 || $approvalTarget[0] != $olUser) || $reqStatQuery['approval_code'] == "CL"){
					break;
				}
				$updateApproval = [
					'approved_by' => $olUser,
					'approved_at' => $now,
					'status' => $approve
				];
				$this->Request_model->updateApproval($request_no, $reqStatQuery['item_no'] + 0, $updateApproval);
				if($approve == 1 && $reqStatQuery['approval_code'] != 'CL'){
					$nextApproval = $this->Request_model->getNextApproval($request_no, $genReq['created_by']);
					$approvalNewReq = [
							'request_no' => $request_no,
							'item_no' => $reqStatQuery['item_no'] + 1,
							'approval_code' => $nextApproval['code'],
							'approved_by' => '',
							'approved_at' => "0000-00-00 00:00:00",
							'status' => ''
						];
					$this->Request_model->insertApproval($approvalNewReq);
				}
			}
		}
		if(isset($_POST['rejectReason']) && $_POST['rejectReason'] != ""){
			$reject = [
				'request_no' => $request_no,
				'item_no' => $this->Request_model->getLastItemNoRejectHistory($request_no) + 1,
				'rejected_approval' => $reqStatQuery['approval_code'],
				'reason' => $_POST['rejectReason'],
				'rejected_by' => $olUser,
				'rejected_at' => $now
			];
			$this->Request_model->writeRejectHistory($reject);
		}
		$this->Sendmail_model->sendmail($request_no);
		redirect(base_url().'request/approvalPendingAllList');
	}

	public function aprrovalHistoryAllList(){
		$data = $this->get_data(null);
		$olUser['pernr'] = $_SESSION["pernr"];
		$olUser['email'] = $_SESSION['email'];
		$olUser['ename'] = $_SESSION['ename'];
		$genReq = $this->Request_model->getTargetGeneralRequestHistoryApprove($olUser['pernr']);
		$data['olUser'] = $olUser;
		$data['from'] = 'approvalHistory';
		$forTbRequest = [];
		foreach ($genReq as $value) {	
			if($value['status'] == ""){
				$request_status = "Waiting Approval ".$this->Request_model->getApprovalName($value['approval_code'])['description'];
			} else if($value['status'] == "0"){
				$request_status = "Rejected by ".$this->Request_model->getApprovalName($value['approval_code'])['description'];
			}
			else if($value['status'] == "3"){
				$request_status = "Deleted";
			} 
			else if($value['status'] == "1"){
				if ($value['approval_code'] == 'CL')
				$request_status = $this->Request_model->getApprovalName($value['approval_code'])['description'];
				else
				$request_status = "Accepted ".$this->Request_model->getApprovalName($value['approval_code'])['description'];
			}
			array_push($forTbRequest, [
				'request_no' => $value['request_no'],
				'position' => $value['position'],
				'reason' => $this->Request_model->getReasonName($value['reason'])['description'],
				'working_status' => $this->Request_model->getWorkingStatusName($value['reason'])['description'],
				'number_of_employee' => $value['number_of_employee'],
				'created_by' => $this->ess_model->get_name($value['created_by']),
				'plant' => $value['plant'],
				'department' => $this->ess_model->get_department($value['plant'], $value['department']),
				'state' => $request_status,
				'on' => date('d.m.Y', strtotime($value['approved_at'])),
				'code' => $value['approval_code']
			]);
		}
		$data['forTbRequest'] = $forTbRequest;
		$this->load->view('request/approvalHistoryAllList', $data);
	}

	public function approval_history(){
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		if(isset($_GET['no']) && isset($_GET['code'])){
			$request_no = $_GET['no'];
			$code = $_GET['code'];
		} else {
			redirect(base_url().'request/aprrovalHistoryAllList');
		}
		$olUser = $_SESSION["pernr"];
		$data = $this->get_data('1');
		$data['genReq'] = $this->Request_model->getGeneralRequest($request_no);
		$data['replacementReq'] = $this->Request_model->getReplacementRequest($request_no);
		$data['jobDescReq'] = $this->Request_model->getJobDescRequest($request_no);
		$data['supportDocReq'] = $this->Request_model->getSupportDocRequest($request_no);
		$strukturOrganisasi = $this->Request_model->getStrukturOrganisasi($request_no);
		if(isset($strukturOrganisasi)){
			$data['strukturOrganisasi'] = $strukturOrganisasi;
		}
		$data['eduBackReq'] = $this->Request_model->getEducationBackgroundRequest($request_no);
		$data['experienceReq'] = $this->Request_model->getExperienceRequest($request_no);
		$data['otherQualificationReq'] = $this->Request_model->getOtherQualificationRequest($request_no);
		$data['foreignLangReq'] = $this->Request_model->getForeignLangRequest($request_no);
		$data['approvalReq'] = $this->Request_model->getApprovalRequest($request_no);
		$data['milestone'] = $this->request_model->getMilestone($data['genReq']['created_by'], $data['genReq']['plant']);
		$data['allApprovalUser'] = $this->Request_model->getApprovalUserWithName($request_no, $data['genReq']['created_by']);
		$data['request_no'] = $request_no;
		$data['from'] = "approvalHistory";
		$applicant = $this->Request_model->getApplicantFromRequestNo($request_no);
		for($i = 0; $i < sizeof($applicant); $i++){
			$applicant[$i]['status'] = $this->Recruitment_model-> get_status_applicant($applicant[$i]['applicant_no'],$request_no);
		}
		if(sizeof($applicant) > 0){
			$data['applicant'] = $applicant;
		}
		$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($request_no);
		if($reqStatQuery['status'] == 0){
			$data['rejectHistory'] = $this->Request_model->getLastRejectHistory($request_no);
			/*var_dump($data['rejectHistory']);
			die();*/
		}
		$approvalTarget = $this->Request_model->getTargetFromUserAndCode($data['genReq']['created_by'], $data['genReq']['plant'], $code);
		$flag = 0;
		foreach ($approvalTarget as $value) {
			if($value['target'] == $olUser){
				$flag = 1;
				break;
			}
		}
		/*var_dump($approvalTarget, $data['genReq'], $olUser);
		die();*/
		if($flag == 1){
			$this->load->view('request/approvalHistory', $data);
		} else {
			//die();
			redirect(base_url().'request/aprrovalHistoryAllList');
		}
	}
}
?>