<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		
		$this->load->library('excel');
		$this->load->model('Recruitment_model');
		$this->load->model('Ess_model');
		$this->load->model('Request_model');
		// force sessions
		$this->Recruitment_model->force_sessions_recruitment();
		// $this->request_model->force_sessions();
	}

	public function index()
	{
		redirect('');
	}

	public function rencana_sukses(){
		$this->load->view('recruitement/succession_planning');
	}
	public function main_report(){
		$this->load->view('recruitement/main_report');
	}

	public function create($error)
	{
		if($this->session->userdata('pernr') || $this->session->userdata('pernr') != "") {
			$pernr = $this->session->userdata('pernr');
			$hrd_status = $this->Recruitment_model->hrd_status($pernr);
			if (!$hrd_status) {
				redirect('Request/Create');
			}
		}
		else{
			redirect('');
		}
		
		if ($error==0) {
			$data['error']="";
		}
		else{
			$data['error']=$error;
		}
		$data['dataLookup'] = $this->Recruitment_model->select_reqno();
		$this->load->view('recruitement/create', $data);
	}

	public function modal()
	{
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		$this->load->view('recruitement/modal');
	}

	public function update()
	{
		if($this->session->userdata('pernr') || $this->session->userdata('pernr') != "") {
			$pernr = $this->session->userdata('pernr');
			$hrd_status = $this->Recruitment_model->hrd_status($pernr);
			if (!$hrd_status) {
				redirect('Request/Create');
			}
		}
		else{
			redirect('');
		}
		$data['isi']=NULL;
		$data['isi2']=NULL;
		$data['isi3']=NULL;
		$data['isi4']=NULL;
		$data['isi5']=NULL;
		$data['isi6']=NULL;
		$data['isi7']=NULL;
		$data['isi8']=NULL;
		$data['isi9']=NULL;
		$data['isi10']=NULL;
		$data['isi11']=NULL;
		$data['isi12']=NULL;
		$data['isi13']=NULL;
		$data['isi14']=NULL;
		$data['isi15']=NULL;
		$data['basic']=NULL;
		$data['dataLookup'] = $this->Recruitment_model->select_reqno();
		//$data['listreq']=$this->Recruitment_model->select_all();
		$data['listreq2']=$this->Recruitment_model->select_all2();
		$data['appno']=NULL;
		$data['showForm']=Null;
		$this->load->view('recruitement/update', $data);
	}

	public function updateView()
	{
		if($this->session->userdata('pernr') || $this->session->userdata('pernr') != "") {
			$pernr = $this->session->userdata('pernr');
			$hrd_status = $this->Recruitment_model->hrd_status($pernr);
			if (!$hrd_status) {
				redirect('Request/Create');
			}
		}
		else{
			redirect('');
		}
		$data['dataLookup']=NULL;
		$applicantNo= $_GET['id'];
		$data['isi']=$this->Recruitment_model->searchApp1($applicantNo);
		if(isset($data['isi'])){
			$data['isi2']=$this->Recruitment_model->searchApp2($applicantNo);
			$data['isi3']=$this->Recruitment_model->searchApp3($applicantNo);
			$data['isi4']=$this->Recruitment_model->searchApp4($applicantNo);
			$data['isi5']=$this->Recruitment_model->searchApp5($applicantNo);
			$data['isi6']=$this->Recruitment_model->searchApp6($applicantNo);
			$data['isi7']=$this->Recruitment_model->searchApp7($applicantNo);
			$data['isi8']=$this->Recruitment_model->searchApp8($applicantNo);
			$data['isi9']=$this->Recruitment_model->searchApp9($applicantNo);
			$data['isi10']=$this->Recruitment_model->searchApp10($applicantNo);
			$data['isi11']=$this->Recruitment_model->searchApp11($applicantNo);
			$data['isi12']=$this->Recruitment_model->searchApp12($applicantNo);
			$data['isi13']=$this->Recruitment_model->searchApp13($applicantNo);
			$data['isi14']=$this->Recruitment_model->searchApp14($applicantNo);
			$data['isi15']=$this->Recruitment_model->searchApp15($applicantNo);
			$data['dataLookup'] = $this->Recruitment_model->select_reqno();
			$data['appno']=$applicantNo;
			$this->load->view('recruitement/update-view', $data);
		}else{
			$data['isi']=NULL;
			$data['isi2']=NULL;
			$data['isi3']=NULL;
			$data['isi4']=NULL;
			$data['isi5']=NULL;
			$data['isi6']=NULL;
			$data['isi7']=NULL;
			$data['isi8']=NULL;
			$data['isi9']=NULL;
			$data['isi10']=NULL;
			$data['isi11']=NULL;
			$data['isi12']=NULL;
			$data['isi13']=NULL;
			$data['isi14']=NULL;
			$data['isi15']=NULL;
			$data['basic']=NULL;
			$data['appno']=$applicantNo;
			$data['showForm']=1;
			$data['basic']=$this->Recruitment_model->searchBasic($applicantNo);
			$this->load->view('recruitement/update-view', $data);
		}
	}

	public function insertData()
	{
		$applicant_no = $this->Recruitment_model->getNewRequestId();
		if (!empty($_FILES['userfile']['name'])) {
			$this->upload_form($applicant_no);
		}
		else{
			$bday = strtotime($_POST['dob']);
			$dob = date('Y-m-d',$bday);
			$name = $_POST['name'];
			$address = $_POST['address'];
			$city = $_POST['city'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$assignto = $_POST['txtAssign'];
			$request_no = explode(',', $assignto);
			$university = $_POST['university'];
			$major = $_POST['major'];
			$gpa = $_POST['gpa'];
			$createdby = $this->session->userdata['pernr'];
			$count_experience = $_POST['countExperience'];
			for ($i=0; $i < $count_experience; $i++) { 
				$item_no = $i+1;
				$experience = $_POST['experience'.$item_no];
				$year_from = $_POST['expfrom'.$item_no];
				$year_to = $_POST['expto'.$item_no];
				$this->Recruitment_model->insert_experience($applicant_no,$item_no,$experience,$year_from,$year_to);
			}
			$lastchangedby = $this->session->userdata['pernr'];
			$this->Recruitment_model->insert_recruitment($applicant_no,$name,$address,$city,$dob,$phone,$email,$university,$major,$gpa,$createdby,$lastchangedby);
			foreach ($request_no as $line) {
				$this->Recruitment_model->insert_basic_assign($applicant_no,$line);
			}
			// echo "<script>alert('Applicant Data has been succesfully created!')</script>";
			$this->update();
		}
	}

	public function upload_form($applicant_no){
		$config['upload_path']   = './assets/uploads/recruitment'; 
		$config['allowed_types'] = 'xls|xlsx'; 
		$config['max_size']      = 1024*30;
		$config['file_name'] 	 = $applicant_no."-".$_FILES['userfile']['name'];
		$file_name				 = str_replace(' ', '_', $_FILES['userfile']['name']);
		$file_type 				 = pathinfo($config['file_name'], PATHINFO_EXTENSION);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('userfile')) {
			$error = array('error' => $this->upload->display_errors()); 
			$this->load->view('recruitement/create', $error); 
		}
		if ($file_type == 'xls') {
		// For Excel 2003
			$objReader =PHPExcel_IOFactory::createReader('Excel5'); 
		}
		elseif($file_type == 'xlsx'){
		// For Excel 2007
			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		}
		$objReader->setReadDataOnly(true);
		$objPHPExcel=$objReader->load(FCPATH.'assets/uploads/recruitment/'.$applicant_no."-".$file_name);
		$objWorksheet=$objPHPExcel->setActiveSheetIndex(0);
		$form_type= $objWorksheet->getCellByColumnAndRow(0,1)->getValue();
		if ($form_type == 'FORM_A') {
			// Insert Personal Data
				$full_name 	= $objWorksheet->getCellByColumnAndRow(1,6)->getValue(); 
				$nickname 	= $objWorksheet->getCellByColumnAndRow(7,6)->getValue();
				$gender 	= strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('C'),7)->getValue());
				switch ($gender) {
					case 'M':
						$gender = "Male";
						break;
					case 'F':
						$gender = "Female";
						break;
					default:
						break;
				}
				$address1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),8)->getValue();
				$address2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),9)->getValue();
				$city 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),10)->getValue();
				$zip 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),11)->getValue();
				$phone 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('C'),12)->getValue();
				$mobile 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('C'),13)->getValue();
				$office 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('C'),14)->getValue();
				$place 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),15)->getValue();
				$dob 		= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('C'),15)->getValue());
				$dob 		= date('Y-m-d',$dob);
				$email 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),15)->getValue();
				$email2 	= "N/A";
				$religion 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),16)->getValue();
				$marital 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),17)->getValue();
				$ktp 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),18)->getValue();
				$npwp 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),19)->getValue();

				$statusInsertDetail = $this->Recruitment_model->insert_personal_data($applicant_no,$full_name,$nickname,$gender,$address1,$address2,$city,$zip,$phone,$mobile,$office,$place,$dob,$email,$email2,$religion,$marital,$ktp,$npwp);

			// Insert Recruitment Basic
				$university = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),26)->getValue();
				$major 		= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),26)->getValue();
				$gpa 		= $this->getDataFromCell($objWorksheet,'H',23);
				$createdby 	= $this->session->userdata['pernr'];
				$lastchangedby= $this->session->userdata['pernr'];
				$statusInsertBasic = $this->Recruitment_model->insert_recruitment($applicant_no,$full_name,$address1,$city,$dob,$phone,$email,$university,$major,$gpa,$createdby,$lastchangedby);
				// var_dump($statusInsertBasic);

			// Insert Education Background
				$level = ["Elementary School","Junior High School","High School","Academy/Univ","Postgraduate"];
				$cell_awal = 23;
				$i = 0;
				foreach ($level as $line) {
					$i++;
					$level = $line;
					$institution = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),$cell_awal)->getValue();
					$city = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),$cell_awal)->getValue();
					$major = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),$cell_awal)->getValue();
					$gpa = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),$cell_awal)->getValue();
					$date1 = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),$cell_awal)->getValue());
					$date = date('Y-m-d',$date1);
					$cell_awal++;
					if (empty($major)) {
						$major = " ";
					}
					if (empty($city)) {
						$city = " ";
					}
					if (empty($gpa)) {
						$gpa = " ";
					}
					if (!empty($institution)) {
						$statusInsertBackgroundEducation = $this ->Recruitment_model->insert_education_background($applicant_no,$i,$level,$institution,$city,$major,$gpa,$date);
					}					
				}

			// Insert Family Structure
				# Status Ownership
					$private_owned = strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),31)->getValue());
					// $private_owned = strtoupper($this->getDataFromCell('B',31));
					// $parent = 
					$parent = strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),31)->getValue());
					$rent = strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),31)->getValue());
					$rent_room = strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),31)->getValue());
					$others = strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),31)->getValue());
					$others_text = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),31)->getValue();
				    if ($private_owned == 'X') {
				    	$ownership = "Privately Owned";
				    }
				    elseif ($parent == 'X') {
				    	$ownership = "Parent";
				    }
				    elseif ($rent == 'X') {
				    	$ownership = "Rent";
				    }
				    elseif ($rent_room == 'X') {
				    	$ownership = "Rent Room";
				    }
				    elseif ($others == 'X') {
				    	if (strpos($others_text, ".") != FALSE) {
				    		$ownership = substr($others_text, strrpos($others_text, '.') + 1);
				    	}
				    	else{
				    		$ownership = $others_text;
				    	}
				    }
				    else{
				    	$ownership = '';
				    }
				# Fam Struc
				    $childorder = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),32)->getValue();
				    $totalchild = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),32)->getValue();
				    $fname = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),34)->getValue();
				    $fplace = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('g'),34)->getValue();
				    $fdob = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('h'),34)->getValue());
				    $fdob = date('Y-m-d',$fdob);
				    $feducation = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('l'),34)->getValue();
				    $fjob = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('n'),34)->getValue();
				    $mname = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),35)->getValue();
				    $mplace = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('g'),35)->getValue();
				    $mdob = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('h'),35)->getValue());
				    $mdob = date('Y-m-d',$mdob);
				    $meducation = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('l'),35)->getValue();
				    $mjob = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('n'),35)->getValue();
				    $faddress1 = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),36)->getValue();
				    $faddress2 = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),37)->getValue();
				    $fCity = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('h'),38)->getValue();
				    $fZip = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('h'),39)->getValue();
				    $fPhone = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),40)->getValue();
				    $fhome = '0';
				    $fhome2 = '0';
				    $spname = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),47)->getValue();
					$spplace= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('g'),47)->getValue();
					$spdob= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('h'),47)->getValue());
				    $spdob = date('Y-m-d',$spdob);
					$speducation=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('l'),47)->getValue();
					$spjob=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('n'),47)->getValue();
					$flawname=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),52)->getValue();
					$flawplace=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('g'),52)->getValue();
					$flawdob= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('h'),52)->getValue());
				    $flawdob = date('Y-m-d',$flawdob);
					$flaweducation=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('l'),52)->getValue();
					$flawjob=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('n'),52)->getValue();
					$mlawname=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),53)->getValue();
					$mlawplace=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('g'),53)->getValue();
					$mlawdob= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('h'),53)->getValue());
				    $mlawdob = date('Y-m-d',$mlawdob);
					$mlaweducation=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('l'),53)->getValue();
					$mlawjob=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('n'),53)->getValue();
					$flawadd1=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),54)->getValue();
					$flawadd2=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),55)->getValue();
					$flawCity=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('e'),56)->getValue();
					$flawZip=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('n'),56)->getValue();
					$flawPhone=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),57)->getValue();
					$flawhome='0';
					$flawhome2='0';
					$othername=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),59)->getValue();
					$otheradd1=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),60)->getValue();
					$otheradd2=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),61)->getValue();
					$otherCity=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),62)->getValue();
					$otherZip=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),63)->getValue();
					$otherPhone=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('d'),64)->getValue();
					$otherhome= '0';
					$otherhome2= '0';
					$insert_fam_struc = $this->Recruitment_model->insert_family_structure($applicant_no,$ownership,$childorder,$totalchild,$fname,$fplace,$fdob,$feducation,$fjob,$mname,$mplace,$mdob,$meducation,$mjob,$faddress1,$faddress2,$fCity,$fZip,$fPhone,$fhome,$fhome2,$spname,$spplace,$spdob,$speducation,$spjob,$flawname,$flawplace,$flawdob,$flaweducation,$flawjob,$mlawname,$mlawplace,$mlawdob,$mlaweducation,$mlawjob,$flawadd1,$flawadd2,$flawCity,$flawZip,$flawPhone,$flawhome,$flawhome2,$othername,$otheradd1,$otheradd2,$otherCity,$otherZip,$otherPhone,$otherhome,$otherhome2);
					// var_dump($insert_fam_struc);
				# Insert Sibling
					$t_sibling = [];
					$si = 1;
					$barisawal = 42;
					for($i = 0; $i < 5; $i++){
						$sname = $this->getDataFromCell($objWorksheet,'D',$barisawal);
						$splace = $this->getDataFromCell($objWorksheet,'G',$barisawal);
						$sdob   = PHPExcel_Shared_Date::ExcelToPHP($this->getDataFromCell($objWorksheet,'H',$barisawal));
    					$sdob   = date('Y-m-d',$sdob);
						$seducation = $this->getDataFromCell($objWorksheet,'L',$barisawal);
						$sjob = $this->getDataFromCell($objWorksheet,'N',$barisawal);
						if($sname!=" " && $splace!=" "&& $sdob!=" "&& $seducation!=" "&& $sjob!=" "){
							array_push($t_sibling, [
								'applicant_no'=>$applicant_no,
								'item_no'=>$si,
								'sibling_name'=>$sname,
								'sibling_place_of_birth'=>$splace,
								'sibling_date_of_birth'=>$sdob,
								'sibling_education'=>$seducation,
								'sibling_occupation'=>$sjob
							]);
							$si++;
						}
						$barisawal++;
					}			
					$insert_family_sib = $this ->Recruitment_model->insert_family_siblings($t_sibling);
					// var_dump($insert_family_sib);
				# Insert Children	
					$t_child = [];
					$ci = 1;
					$barisawalchild = 49;
					for($i = 0; $i < 3; $i++){
						$cname = $this->getDataFromCell($objWorksheet,'D',$barisawalchild);
						$cplace = $this->getDataFromCell($objWorksheet,'G',$barisawalchild);
						$cdob   = PHPExcel_Shared_Date::ExcelToPHP($this->getDataFromCell($objWorksheet,'H',$barisawalchild));
    					$cdob   = date('Y-m-d',$cdob);
						$ceducation = $this->getDataFromCell($objWorksheet,'L',$barisawalchild);
						$cjob = $this->getDataFromCell($objWorksheet,'N',$barisawalchild);
							array_push($t_child, [
								'applicant_no'=>$applicant_no,
								'item_no'=>$ci,
								'child_name'=>$cname,
								'child_place_of_birth'=>$cplace,
								'child_date_of_birth'=>$cdob,
								'child_education'=>$ceducation,
								'child_occupation'=>$cjob
							]);
							$ci++;
						$barisawalchild++;
					}			
					$insert_family_child = $this ->Recruitment_model->insert_family_child($t_child);
			
			// Insert Work Background
				$namec1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),68)->getValue();
				$addc1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),69)->getValue();
				$phonec1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),71)->getValue();
				$snamec1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),73)->getValue();
				$sposc1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),74)->getValue();
				$posc1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),77)->getValue();
				$typec1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),78)->getValue();
				$startc1= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),79)->getValue());
				$startc1 = date('Y-m-d',$startc1);
				$endc1= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),79)->getValue());
				$endc1 = date('Y-m-d',$endc1);
				$suborc1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),80)->getValue();
				$salc1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),81)->getValue();
				$benc1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),82)->getValue();
				$fac1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),84)->getValue();
				$reason1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),86)->getValue();
				$namec2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),68)->getValue();
				$addc2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),69)->getValue();
				$phonec2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),71)->getValue();
				$snamec2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),73)->getValue();
				$sposc2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),74)->getValue();
				$posc2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),77)->getValue();
				$typec2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),78)->getValue();
				$startc2= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('I'),79)->getValue());
				$startc2 = date('Y-m-d',$startc2);
				$endc2= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('N'),79)->getValue());
				$endc2 = date('Y-m-d',$endc2);
				$suborc2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),80)->getValue();
				$salc2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),81)->getValue();
				$benc2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),82)->getValue();
				$fac2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),84)->getValue();
				$reason2= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),86)->getValue();
				$achievementc1= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),88)->getValue();
				$careerc1=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),89)->getValue();
				$employment_history = $this->Recruitment_model->insert_employement_history($applicant_no,$namec1,$addc1,$phonec1,$snamec1,$sposc1,$posc1,$typec1,$startc1,$endc1,$suborc1,$salc1,$benc1,$fac1,$reason1,$namec2,$addc2,$phonec2,$snamec2,$sposc2,$posc2,$typec2,$startc2,$endc2,$suborc2,$salc2,$benc2,$fac2,$reason2,$achievementc1,$careerc1);
				// var_dump($employment_history);

			// Insert Other Informations Relevant With Job Application
				$yposition = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),94)->getValue();
				if(!empty($yposition)){
					$dyna = 'Yes';
				}
				else{
					$dyna = 'No';
					$yposition = ' ';
				}
				$yreason = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),96)->getValue();
				// $yhow = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),97)->getValue();
				$yhow = $this->getDataFromCell($objWorksheet,'D',97);
				$workplace_choice = [];
				array_push($workplace_choice, strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),99)->getValue()));
				array_push($workplace_choice, strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),99)->getValue()));
				array_push($workplace_choice, strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),99)->getValue()));
				array_push($workplace_choice, strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),99)->getValue()));
				array_push($workplace_choice, strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),99)->getValue()));
				$key = array_search('X', $workplace_choice);
				switch ($key) {
					case '0':
						$workplace = 'Office';
						break;
					case '1':
						$workplace = 'Plant';
						break;
					case '2':
						$workplace = 'Laboratory';
						break;
					case '3':
						$workplace = 'Field';
						break;
					case '4':
						// $others_workplace = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),101)->getValue();
						$others_workplace = $this->getDataFromCell($objWorksheet,'L',101);
						if (strpos($others_workplace, ".") != FALSE) {
							$workplace = substr($others_workplace, strrpos($others_workplace, '.') + 1);
						}
						else{
							$workplace = $others_workplace;
						}
						break;
					default :
						$workplace = 'no';
						break;					
					}
				$workplacereason = $this->getDataFromCell($objWorksheet,'D',100);
				$ysal = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),101)->getValue();
				$yben = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),102)->getValue();
				$yfac = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),103)->getValue();
				$tri_status = [strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),105)->getValue()),strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),105)->getValue())];
				$oneyear_status = [strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),106)->getValue()),strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),106)->getValue())];
				$assigncity_status = [strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),107)->getValue()),strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),107)->getValue())];
				$locatecity_status = [strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),108)->getValue()),strtoupper($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),108)->getValue())];
				$threemonth = $this->CheckYesOrNo($tri_status);
				$oneyear = $this->CheckYesOrNo($oneyear_status);
				$assigncity = $this->CheckYesOrNo($assigncity_status);
				$locatecity = $this->CheckYesOrNo($locatecity_status);
				// echo "aaaaa $workplace<br>";
				// var_dump($workplace);
				// var_dump($workplace_choice);
				$other_information = $this->Recruitment_model->insert_other_information($applicant_no,$dyna,$yposition,$yreason,$yhow,$workplace,$workplacereason,$ysal,$yben,$yfac,$threemonth,$oneyear,$assigncity,$locatecity);
				// var_dump($other_information);
				// unlink('assets/uploads/recruitment/'.$applicant_no."-".$file_name);
			// Insert Others
				$namecust = $this->getDataFromCell($objWorksheet,'D',111);
				if($namecust!=' '){
					$workcust = '1';
				}
				else{
					$workcust = '0';
					$namecust = ' ';
				}
				$namesub = $this->getDataFromCell($objWorksheet,'D',113);
				if($namesub!=' '){
					$worksub = '1';
				}
				else{
					$worksub = '0';
					$namesub = ' ';
				}
				$diseasename = $this->getDataFromCell($objWorksheet,'D',115);
				if($diseasename!=' '){
					$diseasestat = '1';
					$diseaseyear = $this->getDataFromCell($objWorksheet,'G',115);
				}
				else{
					$diseasestat = '0';
					$diseasename = ' ';
					$diseaseyear = ' ';
				}
				$accidentname = $this->getDataFromCell($objWorksheet,'D',117);
				if($accidentname!=' '){
					$accidentstat = '1';
					$accidentyear = $this->getDataFromCell($objWorksheet,'I',117);
					$accidentcause = $this->getDataFromCell($objWorksheet,'G',117);
				}
				else{
					$accidentstat = '0';
					$accidentname = ' ';
					$accidentyear = ' ';
					$accidentcause = ' ';
				}
				$glass_status = [strtoupper($this->getDataFromCell($objWorksheet,'B',119)),strtoupper($this->getDataFromCell($objWorksheet,'D',119))];
				$smoke_status = [strtoupper($this->getDataFromCell($objWorksheet,'B',121)),strtoupper($this->getDataFromCell($objWorksheet,'D',121))];
				$glass = $this->CheckYesOrNoBinary($glass_status);
				$smoke = $this->CheckYesOrNoBinary($smoke_status);
				$bloodtype = $this->getDataFromCell($objWorksheet,'D',122);
				$vehicletype = $this->getDataFromCell($objWorksheet,'D',123);
				$owner = $this->getDataFromCell($objWorksheet,'D',124);
				$license = $this->getDataFromCell($objWorksheet,'D',125);
				$acknowledge1 = $this->getDataFromCell($objWorksheet,'D',126);
				$relation = $this->getDataFromCell($objWorksheet,'D',127);
				$namer1 = $this->getDataFromCell($objWorksheet,'D',130);
				$posr1 = $this->getDataFromCell($objWorksheet,'F',130);
				$comr1 = $this->getDataFromCell($objWorksheet,'D',131);
				$addr1 = $this->getDataFromCell($objWorksheet,'D',132);
				$telr1 = $this->getDataFromCell($objWorksheet,'D',133);
				$relr1 = $this->getDataFromCell($objWorksheet,'D',134);
				$namer2 = $this->getDataFromCell($objWorksheet,'H',130);
				$posr2 = $this->getDataFromCell($objWorksheet,'N',130);
				$comr2 = $this->getDataFromCell($objWorksheet,'H',131);
				$addr2 = $this->getDataFromCell($objWorksheet,'D',132);
				$telr2 = $this->getDataFromCell($objWorksheet,'D',133);
				$relr2 = $this->getDataFromCell($objWorksheet,'D',134);
				$contact_status = [strtoupper($this->getDataFromCell($objWorksheet,'D',135)),strtoupper($this->getDataFromCell($objWorksheet,'H',135))];
				$contact = $this->CheckYesOrNoBinary($contact_status);
				$readywork = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),136)->getValue());
				$readywork = date('Y-m-d',$readywork);
				// echo "applicant_no,workcust,namecust,worksub,namesub,diseasestat,diseasename,diseaseyear,accidentstat,accidentname,accidentyear,accidentcause,glass,smoke,bloodtype,vehicletype,owner,license,acknowledge1,relation,namer1,posr1,comr1,addr1,telr1,relr1,namer2,posr2,comr2,addr2,telr2,relr2,contact,readywork";
				// echo "$applicant_no,$workcust,$namecust,$worksub,$namesub,$diseasestat,$diseasename,$diseaseyear,$accidentstat,$accidentname,$accidentyear,$accidentcause,$glass,$smoke,$bloodtype,$vehicletype,$owner,$license,$acknowledge1,$relation,$namer1,$posr1,$comr1,$addr1,$telr1,$relr1,$namer2,$posr2,$comr2,$addr2,$telr2,$relr2,$contact,$readywork";
				$insert_others = $this->Recruitment_model -> insert_others($applicant_no,$workcust,$namecust,$worksub,$namesub,$diseasestat,$diseasename,$diseaseyear,$accidentstat,$accidentname,$accidentyear,$accidentcause,$glass,$smoke,$bloodtype,$vehicletype,$owner,$license,$acknowledge1,$relation,$namer1,$posr1,$comr1,$addr1,$telr1,$relr1,$namer2,$posr2,$comr2,$addr2,$telr2,$relr2,$contact,$readywork);
				// var_dump($insert_others);
			
			
			// Insert 
			// Check if Insert is SuccessInsert			
				// var_dump($statusInsertBasic);
				// var_dump($statusInsertDetail);
				// var_dump($other_information);
			if (!empty($statusInsertBasic) && !empty($statusInsertDetail)) {
				$applicantNo = $applicant_no;
				$data['dataLookup'] = $this->Recruitment_model->select_reqno();
				$data['listreq']=$this->Recruitment_model->select_all();
				$data['listreq2']=$this->Recruitment_model->select_all2();
				$data['isi']=$this->Recruitment_model->searchApp1($applicantNo);
				$data['isi2']=$this->Recruitment_model->searchApp2($applicantNo);
				$data['isi3']=$this->Recruitment_model->searchApp3($applicantNo);
				$data['isi4']=$this->Recruitment_model->searchApp4($applicantNo);
				$data['isi5']=$this->Recruitment_model->searchApp5($applicantNo);
				$data['isi6']=$this->Recruitment_model->searchApp6($applicantNo);
				$data['isi7']=$this->Recruitment_model->searchApp7($applicantNo);
				$data['isi8']=$this->Recruitment_model->searchApp8($applicantNo);
				$data['isi9']=$this->Recruitment_model->searchApp9($applicantNo);
				$data['isi10']=$this->Recruitment_model->searchApp10($applicantNo);
				$data['isi11']=$this->Recruitment_model->searchApp11($applicantNo);
				$data['isi12']=$this->Recruitment_model->searchApp12($applicantNo);
				$data['isi13']=$this->Recruitment_model->searchApp13($applicantNo);
				$data['isi14']=$this->Recruitment_model->searchApp14($applicantNo);
				$data['isi15']=$this->Recruitment_model->searchApp15($applicantNo);
				$data['appno']=$applicantNo;
				$data['showForm']=1;
				$this->load->view('recruitement/update', $data);
			}
			else{
				if (!empty($statusInsertBasic)) {
					$error = $statusInsertBasic;
				}
				elseif (!empty($statusInsertDetail)) {
					$error = $statusInsertDetail;
				}
				$this->create($error);
			}
		} elseif($form_type == 'FORM_B'){
			//personal data
			$name 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),5)->getValue();

			$nickname 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('U'),5)->getValue();
			$gender 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),6)->getValue();
			$address1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),7)->getValue();
			$address2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),8)->getValue();
			$zip = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('S'),9)->getValue();
			$phone 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),10)->getValue();
			$mobile 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),11)->getValue();
			$office 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),12)->getValue();
			$place 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),13)->getValue();
			$dob 	= PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),13)->getValue());
			$dob 		= date('Y-m-d',$dob);
			$email 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AA'),13)->getValue();
			$religion 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),14)->getValue();
			$marital 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),15)->getValue();
			$ktp 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),16)->getValue();
			$npwp 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),17)->getValue();
			$city="";
			$email2="";
			$address=$address1.$address2;
			if($gender=="M"){
				$gender="Male";
			} elseif ($gender="F") {
				$gender="Female";
			}
			
			$statusinsertbasic = $this->Recruitment_model->insert_personal_data($applicant_no,$name,$nickname,$gender,$address1,$address2,$city,$zip,$phone,$mobile,$office,$place,$dob,$email,$email2,$religion,$marital,$ktp,$npwp);
			//EDUCATIONAL BACKGROUND
			for($i = 1; $i <= 5; $i++){
			 $item_no 	= $i;
			 $level 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('A'),19+$i)->getValue();
			 $institution 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),19+$i)->getValue();
			 $city 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),19+$i)->getValue();
			 $major 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),19+$i)->getValue();
			 $gpa 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('Y'),19+$i)->getValue();
			 $date 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AD'),19+$i)->getValue();
			 if(isset($institution)||isset($city)||isset($major)||isset($gpa)||isset($date)){
			 $statusinsertedu = $this->Recruitment_model->insert_education_background($applicant_no,$item_no,$level,$institution,$city,$major,$gpa,$date);	
			 }
			 }
			//COURSE/TRAINING
			 $countercourse=0;
			 for($i = 1; $i <= 5; $i++){
			 	 $activity 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('A'),26+$i)->getValue();
			 	 $organizer 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),26+$i)->getValue();
			 	 $year 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('O'),26+$i)->getValue();
			 	 $duration 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('V'),26+$i)->getValue();
			 	 $certificate 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AC'),26+$i)->getValue();
			 	 if (isset($activity)||isset($organizer)||isset($year)||isset($duration)||isset($certificate)) {
			 	 	$countercourse=$countercourse+1;
			 	 	 $statusinsertcourse = $this->Recruitment_model->insert_course_training($applicant_no,$countercourse,$activity,$organizer,$year,$duration,$certificate);
			 	 }
			 }
			//EDUCATION INFORMATION
			 for($i = 1; $i <= 3; $i++){
			 	 $achievementdetails 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),33+$i)->getValue();
			 	 $yeara 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AC'),33+$i)->getValue();
			 	 if (isset($achievementdetails)||isset($yeara)) {
			 	 $item_no=$i;
				 $statusinsertcourse = $this->Recruitment_model->insert_education_achievement($applicant_no,$item_no,$achievementdetails,$yeara);		 	 	
			 	 }
			 }
			$funder 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('J'),37)->getValue();
			$sciencePaper 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('J'),38)->getValue();
			$englishstatusy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),47)->getValue();
			$englishstatusn	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AF'),47)->getValue();
			if (isset($englishstatusy)) {
				$englishstatus="Yes";
			}elseif(isset($englishstatusn)){
				$englishstatus="No";
			}
			$yearb 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),47)->getValue();
			$institution 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('N'),47)->getValue();
			$score 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('Z'),47)->getValue();
			$statusinserteduinfo = $this->Recruitment_model->insert_education_information($applicant_no,$funder,$sciencePaper,$englishstatus,$yearb,$institution,$score);
			for($i = 1; $i <= 5; $i++){
				$item_no=$i;
				$language 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),40+$i)->getValue();
				$speakingy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),40+$i)->getValue();
				$speakingn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),40+$i)->getValue();
				$writingy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('T'),40+$i)->getValue();
				$writingn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('X'),40+$i)->getValue();
				$readingy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AB'),40+$i)->getValue();
				$readingn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AF'),40+$i)->getValue();
				if (isset($speakingy)) {
					$speaking="Good";
				}elseif(isset($speakingn)){
					$speaking="Fair";
				}
				if (isset($writingy)) {
					$writing="Good";
				}elseif(isset($writingn)){
					$writing="Fair";
				}
				if (isset($readingy)) {
					$reading="Good";
				}elseif(isset($readingn)){
					$reading="Fair";
				}
				if (isset($language)||isset($speaking)||isset($writing)||isset($reading)) {
					$statusinsertedulanguage = $this->Recruitment_model->insert_education_information_language($applicant_no,$item_no,$language,$speaking,$writing,$reading);
				}
			}
			//SOCIAL ACTIVITY AND OTHER ACTIVITY
			for($i = 1; $i <= 5; $i++){
				$name_organization 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),50+$i)->getValue();
				$place 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),50+$i)->getValue();
				$position 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('T'),50+$i)->getValue();
				$duration 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AB'),50+$i)->getValue();
				$item_no=$i;
				if (isset($name_organization)||isset($place)||isset($position)||isset($duration)) {
					$statusinsertorganization = $this->Recruitment_model->insert_social_organization1($applicant_no,$item_no,$name_organization,$place,$position,$duration);
				}
			}
			$hobby 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),56)->getValue();
			$newspaper 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),57)->getValue();
			$topic 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),58)->getValue();
			$statusinsertsocial = $this->Recruitment_model->insert_social_activity($applicant_no,$hobby,$newspaper,$topic);
			//FAMILY STRUCTURE
			$fam['owner'][0]['check'] = $objWorksheet->getCellByColumnAndRow(1,61)->getValue();
	        $fam['owner'][1]['check'] = $objWorksheet->getCellByColumnAndRow(8,61)->getValue();
	        $fam['owner'][2]['check'] = $objWorksheet->getCellByColumnAndRow(15,61)->getValue();
	        $fam['owner'][3]['check'] = $objWorksheet->getCellByColumnAndRow(22,61)->getValue();
	        $fam['owner'][4]['check'] = $objWorksheet->getCellByColumnAndRow(29,61)->getValue();
	        $fam['owner'][4]['fill'] = $objWorksheet->getCellByColumnAndRow(31,61)->getValue();
	        $flagSelect = 0;
	        for($i = 0; $i < sizeof($fam['owner']); $i++){
	        	if(isset($fam['owner'][$i]['check'])){
	        		if($i == 0){
	        			$fam['ownership'] = "Privately Owned";
	        		} else if($i == 1){
	        			$fam['ownership'] = "Parents";
	        		} else if($i == 2){
	        			$fam['ownership'] = "Rent";
	        		} else if($i == 3){
	        			$fam['ownership'] = "Rent Room";
	        		} else if($i == 4){
	        			if(isset($fam['owner'][4]['fill'])){
	        				$fam['ownership'] = $fam['owner'][4]['fill'];
	        			} else {
	        				$fam['ownership'] = "Uncheck Ownership";
	        			}
	        			
	        		}
	        		$flagSelect++;
	        	}
	        	if($flagSelect == 0){
	        		$fam['ownership'] = "Uncheck Ownership";
	        	} else if($flagSelect > 1){
	        		$fam['ownership'] = "Unvalid Ownership";
	        	}
	        }
	        $fam['numChild'] = $objWorksheet->getCellByColumnAndRow(7,62)->getValue();
		    $fam['childOf'] = $objWorksheet->getCellByColumnAndRow(22,62)->getValue();
	        $fam['parent']['father']['name'] = $objWorksheet->getCellByColumnAndRow(7,64)->getValue();
	        $fam['parent']['father']['pob'] = $objWorksheet->getCellByColumnAndRow(13,64)->getValue();
	        $fam['parent']['father']['dob'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(16,64)->getValue()));
	        $fam['parent']['father']['edu'] = $objWorksheet->getCellByColumnAndRow(22,64)->getValue();
	        $fam['parent']['father']['pos'] = $objWorksheet->getCellByColumnAndRow(28,64)->getValue();
	        $fam['parent']['mother']['name'] = $objWorksheet->getCellByColumnAndRow(7,65)->getValue();
	        $fam['parent']['mother']['pob'] = $objWorksheet->getCellByColumnAndRow(13,65)->getValue();
	        $fam['parent']['mother']['dob'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(16,65)->getValue()));
	        $fam['parent']['mother']['edu'] = $objWorksheet->getCellByColumnAndRow(22,65)->getValue();
	        $fam['parent']['mother']['pos'] = $objWorksheet->getCellByColumnAndRow(28,65)->getValue();
	        $fam['parent']['address1'] = $objWorksheet->getCellByColumnAndRow(7,66)->getValue();
	        $fam['parent']['address2'] = $objWorksheet->getCellByColumnAndRow(7,67)->getValue();
	        $fam['parent']['city'] = " ";
	        $fam['parent']['zipCode'] = $objWorksheet->getCellByColumnAndRow(23,68)->getValue();
	        $fam['parent']['telephone'] = $objWorksheet->getCellByColumnAndRow(7,69)->getValue();
	        for($i=0; $i<8; $i++){
	        	$fam['sibling'][$i]['name'] = $objWorksheet->getCellByColumnAndRow(7,$i+71)->getValue();
	        	$fam['sibling'][$i]['pob'] = $objWorksheet->getCellByColumnAndRow(13,$i+71)->getValue();
	        	$fam['sibling'][$i]['dob'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(16,$i+71)->getValue()));
	        	$fam['sibling'][$i]['edu'] = $objWorksheet->getCellByColumnAndRow(22,$i+71)->getValue();
	        	$fam['sibling'][$i]['pos'] = $objWorksheet->getCellByColumnAndRow(28,$i+71)->getValue();
	        }
	        $fam['spouse']['name'] = $objWorksheet->getCellByColumnAndRow(7,79)->getValue();
	        $fam['spouse']['pob'] = $objWorksheet->getCellByColumnAndRow(13,79)->getValue();
	        $fam['spouse']['dob'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(16,79)->getValue()));
	        $fam['spouse']['edu'] = $objWorksheet->getCellByColumnAndRow(22,79)->getValue();
	        $fam['spouse']['pos'] = $objWorksheet->getCellByColumnAndRow(28,79)->getValue();
	        for($i=0; $i<4; $i++){
	        	$fam['children'][$i]['name'] = $objWorksheet->getCellByColumnAndRow(7,$i+81)->getValue();
	        	$fam['children'][$i]['pob'] = $objWorksheet->getCellByColumnAndRow(13,$i+81)->getValue();
	        	$fam['children'][$i]['dob'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(16,$i+81)->getValue()));
	        	$fam['children'][$i]['edu'] = $objWorksheet->getCellByColumnAndRow(22,$i+81)->getValue();
	        	$fam['children'][$i]['pos'] = $objWorksheet->getCellByColumnAndRow(28,$i+81)->getValue();
	        }
	        $fam['fatherInLaw']['name'] = $objWorksheet->getCellByColumnAndRow(7,85)->getValue();
	        $fam['fatherInLaw']['pob'] = $objWorksheet->getCellByColumnAndRow(13,85)->getValue();
	        $fam['fatherInLaw']['dob'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(16,85)->getValue()));
	        $fam['fatherInLaw']['edu'] = $objWorksheet->getCellByColumnAndRow(22,85)->getValue();
	        $fam['fatherInLaw']['pos'] = $objWorksheet->getCellByColumnAndRow(28,85)->getValue();
	        $fam['motherInLaw']['name'] = $objWorksheet->getCellByColumnAndRow(7,86)->getValue();
	        $fam['motherInLaw']['pob'] = $objWorksheet->getCellByColumnAndRow(13,86)->getValue();
	        $fam['motherInLaw']['dob'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(16,85)->getValue()));
	        $fam['motherInLaw']['edu'] = $objWorksheet->getCellByColumnAndRow(22,86)->getValue();
	        $fam['motherInLaw']['pos'] = $objWorksheet->getCellByColumnAndRow(28,86)->getValue();
	        $fam['inLaw']['address1'] = $objWorksheet->getCellByColumnAndRow(7,87)->getValue();
	        $fam['inLaw']['address2'] = $objWorksheet->getCellByColumnAndRow(7,88)->getValue();
	        $fam['inLaw']['city'] = " ";
	        $fam['inLaw']['zipCode'] = " ";
	        $fam['inLaw']['telephone'] = $objWorksheet->getCellByColumnAndRow(7,90)->getValue();
	        $fam['emergency']['contact'] = $objWorksheet->getCellByColumnAndRow(1,92)->getValue();
	        $fam['emergency']['address1'] = $objWorksheet->getCellByColumnAndRow(3,93)->getValue();
	        $fam['emergency']['address2'] = $objWorksheet->getCellByColumnAndRow(3,94)->getValue();
	        $fam['emergency']['zipCode'] = $objWorksheet->getCellByColumnAndRow(3,95)->getValue();
	        $fam['emergency']['telephone'] = $objWorksheet->getCellByColumnAndRow(3,96)->getValue();
	        $this->Recruitment_model->insert_family_structure($applicant_no,$fam['ownership'],$fam['numChild'],$fam['childOf'],$fam['parent']['father']['name'],$fam['parent']['father']['pob'],$fam['parent']['father']['dob'],$fam['parent']['father']['edu'],$fam['parent']['father']['pos'],$fam['parent']['mother']['name'],$fam['parent']['mother']['pob'],$fam['parent']['mother']['dob'],$fam['parent']['mother']['edu'],$fam['parent']['mother']['pos'],$fam['parent']['address1'],$fam['parent']['address2']," ",$fam['parent']['zipCode'],$fam['parent']['telephone']," "," ",$fam['spouse']['name'],$fam['spouse']['pob'],$fam['spouse']['dob'],$fam['spouse']['edu'],$fam['spouse']['pos'],$fam['fatherInLaw']['name'],$fam['fatherInLaw']['pob'],$fam['fatherInLaw']['dob'],$fam['fatherInLaw']['edu'],$fam['fatherInLaw']['pos'],$fam['motherInLaw']['name'],$fam['motherInLaw']['pob'],$fam['motherInLaw']['dob'],$fam['motherInLaw']['edu'],$fam['motherInLaw']['pos'],$fam['inLaw']['address1'],$fam['inLaw']['address2']," "," ",$fam['inLaw']['telephone']," "," ",$fam['emergency']['contact'],$fam['emergency']['address1'],$fam['emergency']['address2']," ",$fam['emergency']['zipCode'],$fam['emergency']['telephone']," "," ");    	
			$insertSibling = [];
			$insertChildren = [];
	       	for($i=0; $i<8; $i++){
				if(isset($fam['sibling'][$i])){
					array_push($insertSibling, [
						'applicant_no'=>$applicant_no,
						'item_no'=>$i+1,
						'sibling_name'=>$fam['sibling'][$i]['name'],
						'sibling_place_of_birth'=>$fam['sibling'][$i]['pob'],
						'sibling_date_of_birth'=>$fam['sibling'][$i]['dob'],
						'sibling_education'=>$fam['sibling'][$i]['edu'],
						'sibling_occupation'=>$fam['sibling'][$i]['pos']
					]);
				}
				if(isset($fam['children'][$i])){
					array_push($insertChildren, [
						'applicant_no'=>$applicant_no,
						'item_no'=>$i+1,
						'child_name'=>$fam['children'][$i]['name'],
						'child_place_of_birth'=>$fam['children'][$i]['pob'],
						'child_date_of_birth'=>$fam['children'][$i]['dob'],
						'child_education'=>$fam['children'][$i]['edu'],
						'child_occupation'=>$fam['children'][$i]['pos']
					]);
				}
			}
			$this ->Recruitment_model->insert_family_siblings($insertSibling);
			$this ->Recruitment_model->insert_family_child($insertChildren);
			//EMPLOYEMENT HISTORY
			$namec1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),100)->getValue();
			$addc11 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),101)->getValue();
			$addc12 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),102)->getValue();
			
			$addc1 = $addc11." ".$addc12;
			
			$phonec1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),103)->getValue();
			$snamec1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),105)->getValue();
			$sposc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),106)->getValue();
			$posc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),109)->getValue();
			$typec1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),110)->getValue();
			$startc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),111)->getValue();
			$endc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),111)->getValue();
			$suborc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),112)->getValue();
			$salc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),113)->getValue();
			$benc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),114)->getValue();
			$fac1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),116)->getValue();
			$reason1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),118)->getValue();

			$namec2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),100)->getValue();
			$addc21 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),101)->getValue();
			$addc22 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),102)->getValue();
			$addc2 = $addc21." ".$addc22;
			$phonec2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),103)->getValue();
			$snamec2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),105)->getValue();
			$sposc2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),106)->getValue();
			$posc2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),109)->getValue();
			$typec2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),110)->getValue();
			$startc2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('U'),111)->getValue();
			$endc2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('Z'),111)->getValue();
			$suborc2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),112)->getValue();
			$salc2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),113)->getValue();
			$benc2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),114)->getValue();
			$fac2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),116)->getValue();
			$reason2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),118)->getValue();
			$achievementc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),120)->getValue();
			$careerc1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),121)->getValue();

			$statusinsertemployementhistory = $this->Recruitment_model->insert_employement_history($applicant_no,$namec1,$addc1,$phonec1,$snamec1,$sposc1,$posc1,$typec1,$startc1,$endc1,$suborc1,$salc1,$benc1,$fac1,$reason1,$namec2,$addc2,$phonec2,$snamec2,$sposc2,$posc2,$typec2,$startc2,$endc2,$suborc2,$salc2,$benc2,$fac2,$reason2,$achievementc1,$careerc1);

			//OTHER INFORMATION RELEVANT WITH JOB APPLICATION
			$dynay 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),125)->getValue();
			$dynan	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),125)->getValue();
			if($dynan!=NULL){
				$dyna="No";
			} elseif($dynay!=NULL){
				$dyna="Yes";
				$yposition 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),125)->getValue();
			}
			$yhow 	= $objWorksheet->getCellByColumnAndRow(10,128)->getValue(); 
			


			$yreason 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),127)->getValue();
			$workplace1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),130)->getValue();
			$workplace2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('I'),130)->getValue();
			$workplace3 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),130)->getValue();
			$workplace4 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('W'),130)->getValue();
			$workplace5 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AD'),130)->getValue();
			if($workplace1!=NULL){
				$workplace="Office";
			}elseif($workplace2!=NULL){
				$workplace="Plant";
			}elseif($workplace3!=NULL){
				$workplace="Laboratory";
			}elseif($workplace4!=NULL){
				$workplace="Field";
			}elseif($workplace5!=NULL){
				$workplace=$objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AF'),130)->getValue();
			}


			$workplacereason 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('D'),131)->getValue();
			$ysal 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),132)->getValue();
			$yben 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),133)->getValue();
			$yfac 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),134)->getValue();

			$threemonthy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),136)->getValue();
			$threemonthn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),136)->getValue();
			$oneyeary 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),137)->getValue();
			$oneyearn	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),137)->getValue();
			$assigncityy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),138)->getValue();
			$assigncityn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),138)->getValue();
			$locatecityy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),139)->getValue();
			$locatecityn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),139)->getValue();
			if($threemonthy!=NULL){
				$threemonth="Yes";
			} elseif($threemonthn!=NULL){
				$threemonth="No";
			}

			if($oneyeary!=NULL){
				$oneyear="Yes";
			} elseif($oneyearn!=NULL){
				$oneyear="No";
			}

			if($assigncityy!=NULL){
				$assigncity="Yes";
			} elseif($assigncityn!=NULL){
				$assigncity="No";
			}

			if($locatecityy!=NULL){
				$locatecity="Yes";
			} elseif($locatecityn!=NULL){
				$locatecity="No";
			}

			$statusinsertotherinformation = $this->Recruitment_model->insert_other_information($applicant_no,$dyna,$yposition,$yreason,$yhow,$workplace,$workplacereason,$ysal,$yben,$yfac,$threemonth,$oneyear,$assigncity,$locatecity);
		
			//OTHERS
			$workcusty 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),142)->getValue();
			$workcustn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),142)->getValue();
		

			if($workcustn!=NULL){
				$workcust=0;
			} elseif($workcusty!=NULL){
				$workcust=1;
				$namecust 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),142)->getValue();
			}
			
			$worksuby 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),144)->getValue();
			$worksubn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),144)->getValue();			
			if($worksubn!=NULL){
				$worksub=0;
			} elseif($worksuby!=NULL){
				$worksub=1;
				$namesub 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),144)->getValue();
			}

			$diseasestaty 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),146)->getValue();
			$diseasestatn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),146)->getValue();
			
			if($diseasestatn!=NULL){
				$diseasestat=0;
				$diseasename=" ";
				$diseaseyear=" ";
			} elseif($diseasestaty!=NULL){
				$diseasestat =1;
				$diseasename 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('G'),146)->getValue();
				$diseaseyear 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),146)->getValue();
			}
			
			$accidentstaty 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),148)->getValue();
			$accidentstatn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),148)->getValue();
			
			if($accidentstatn!=NULL){
				$accidentstat=0;
				$accidentname 	= " ";
				$accidentyear 	= " ";
				$accidentcause 	= " ";
			} elseif($accidentstaty!=NULL){
				$accidentstat=1;
				
				$accidentname 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('F'),148)->getValue();
				$accidentyear 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('P'),148)->getValue();
				$accidentcause 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('K'),148)->getValue();
			}
			
			
			$glassy 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),150)->getValue();
			$glassn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),150)->getValue();
			
			$smokey 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('B'),152)->getValue();
			$smoken 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),152)->getValue();
			
			$bloodtype 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),153)->getValue();
			$vehicletype 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('H'),154)->getValue();
			$owner 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),155)->getValue();
			$license 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),156)->getValue();
			$acknowledge1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),157)->getValue();
			$relation 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('L'),158)->getValue();

			$namer1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),161)->getValue();
			$posr1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),162)->getValue();
			$comr1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),163)->getValue();
			$addr1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),164)->getValue();
			$telr1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),165)->getValue();
			$relr1 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),166)->getValue();
			$namer2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('X'),161)->getValue();
			$posr2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('X'),162)->getValue();
			$comr2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('X'),163)->getValue();
			$addr2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('X'),164)->getValue();
			$telr2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('X'),165)->getValue();
			$relr2 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('X'),166)->getValue();
			$contacty 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),167)->getValue();
			$contactn 	= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('AD'),167)->getValue();
			$readywork 	=  date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('M'),168)->getValue()));
			
			if($smoken!=NULL){
				$smoke=0;
			} elseif($smokey!=NULL){
				$smoke=1;
			}

			if($contactn!=NULL){
				$contact=0;
			} elseif($contacty!=NULL){
				$contact=1;
			}


			if($glassn!=NULL){
				$glass=0;
			} elseif($glassy!=NULL){
				$glass=1;
			}
			

			$statusinsertother =$this->Recruitment_model->insert_others($applicant_no,$workcust,$namecust,$worksub,$namesub,$diseasestat,$diseasename,$diseaseyear,$accidentstat,$accidentname,$accidentyear,$accidentcause,$glass,$smoke,$bloodtype,$vehicletype,$owner,$license,$acknowledge1,$relation,$namer1,$posr1,$comr1,$addr1,$telr1,$relr1,$namer2,$posr2,$comr2,$addr2,$telr2,$relr2,$contact,$readywork);
			
			$createdby = $this->session->userdata['pernr'];
			$lastchangedby = $this->session->userdata['pernr'];
			$university= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('E'),23)->getValue();
			$major= $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('R'),23)->getValue();
			$gpa = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar('Y'),23)->getValue();
			if($major==NULL){
				$major=" ";
			}
			if($gpa==NULL){
				$gpa="";
			}
			if($university==NULL){
				$university="";
			}
			$this->Recruitment_model->insert_recruitment($applicant_no,$name,$address,$city,$dob,$phone,$email,$university,$major,$gpa,$createdby,$lastchangedby);
			$applicantNo=$applicant_no;

			// unlink('assets/uploads/recruitment/'.$applicant_no."-".$file_name);
				$data['dataLookup'] = $this->Recruitment_model->select_reqno();
				$data['listreq']=$this->Recruitment_model->select_all();
				$data['listreq2']=$this->Recruitment_model->select_all2();
				$data['isi']=$this->Recruitment_model->searchApp1($applicantNo);
				$data['isi2']=$this->Recruitment_model->searchApp2($applicantNo);
				$data['isi3']=$this->Recruitment_model->searchApp3($applicantNo);
				$data['isi4']=$this->Recruitment_model->searchApp4($applicantNo);
				$data['isi5']=$this->Recruitment_model->searchApp5($applicantNo);
				$data['isi6']=$this->Recruitment_model->searchApp6($applicantNo);
				$data['isi7']=$this->Recruitment_model->searchApp7($applicantNo);
				$data['isi8']=$this->Recruitment_model->searchApp8($applicantNo);
				$data['isi9']=$this->Recruitment_model->searchApp9($applicantNo);
				$data['isi10']=$this->Recruitment_model->searchApp10($applicantNo);
				$data['isi11']=$this->Recruitment_model->searchApp11($applicantNo);
				$data['isi12']=$this->Recruitment_model->searchApp12($applicantNo);
				$data['isi13']=$this->Recruitment_model->searchApp13($applicantNo);
				$data['isi14']=$this->Recruitment_model->searchApp14($applicantNo);
				$data['isi15']=$this->Recruitment_model->searchApp15($applicantNo);
				$data['appno']=$applicantNo;
				$data['showForm']=1;
				$this->load->view('recruitement/update', $data);
			}
	}

	public function getDataFromCell($objWorksheet, $col,$row){
		$a = $objWorksheet->getCellByColumnAndRow($this->getIndexFromChar($col),$row)->getValue();
		if (!empty($a)&&$a!='dd/mm/yyyy') {
			return $a;
		}
		else
		{
			return ' ';
		}
	}
	public function getIndexFromChar($var){
		$var = strtoupper($var);
		$index = PHPExcel_Cell::columnIndexFromString($var)-1;
		return $index;
	}
	public function checkEmpty($var){
		if (empty($var)) {
			return "";
		}
	}
	public function CheckYesOrNo($var_array){
		$key = array_search('X', $var_array);
		switch ($key){
		case '0':
			return 'Yes';
			break;
		case '1':
			return 'No';
			break;
		default :
			return 'N/A';
			break;
		}
	}
	public function CheckYesOrNoBinary($var_array){
		$key = array_search('X', $var_array);
		switch ($key){
		case '0':
			// Artinya YES
			return '1';
			break;
		case '1':
			// Artinya NO
			return '0';
			break;
		default :
			return 'N/A';
			break;
		}
	}
	public function insertDataUpdate()
	{
		$checkapp=$_POST['applicantnumber'];
		if (isset($checkapp)) {
			$this ->Recruitment_model->deletedata($checkapp);
		}
		$approval = $_POST['approval'];
		if(isset($approval)){
			if(isset($checkapp)){
				$applicant_no = $checkapp;
			}
			$assignto = $_POST['txtAssign'];
			$request_no = explode(',', $assignto);
			foreach ($request_no as $line) {
				$this->Recruitment_model->insert_basic_assign($applicant_no,$line);
			}
			$name=$_POST['pName'];
			$nickname=$_POST['pNickName'];
			$gender=$_POST['pGender'];
			$address1=$_POST['pAddress1'];
			$address2=$_POST['pAddress2'];
			$city=$_POST['pCity'];
			$zip=$_POST['pZip'];
			$phone=$_POST['pPhone'];
			$mobile=$_POST['pMobile'];
			$office=$_POST['pOffice'];
			$place=$_POST['pPlace'];
			$dob1=strtotime($_POST['pDOB']);
			$dob=date('Y-m-d',$dob1);
			$email=$_POST['pEmail'];
			$email2=$_POST['pEmail2'];
			$religion=$_POST['pReligion'];
			$marital=$_POST['pMarital'];
			$ktp=$_POST['pKTP'];
			$npwp=$_POST['pNPWP'];
			$this ->Recruitment_model->insert_personal_data($applicant_no,$name,$nickname,$gender,$address1,$address2,$city,$zip,$phone,$mobile,$office,$place,$dob,$email,$email2,$religion,$marital,$ktp,$npwp);

			$counter_education=5;
			for ($i=0; $i < $counter_education; $i++) { 
				$item_no = $i+1;
				$level = $_POST['level'.$item_no];
				$institution = $_POST['institution'.$item_no];
				$city = $_POST['city'.$item_no];
				$major = $_POST['major'.$item_no];
				$gpa = $_POST['gpa'.$item_no];
				$date1 = strtotime($_POST['date'.$item_no]);
				$date = date('Y-m-d',$date1);
				$this ->Recruitment_model->insert_education_background($applicant_no,$item_no,$level,$institution,$city,$major,$gpa,$date);
			}

			$counter_course=5;
			for ($i=0; $i < $counter_course; $i++) { 
				$item_no = $i+1;
				$activity = $_POST['activity'.$item_no];
				$organizer = $_POST['organizer'.$item_no];
				$year = $_POST['year'.$item_no];
				$duration = $_POST['duration'.$item_no];
				$certificate = $_POST['certificate'.$item_no];
				$this ->Recruitment_model->insert_course_training($applicant_no,$item_no,$activity,$organizer,$year,$duration,$certificate);
			}
			
			$funder=$_POST['funder'];
			$scientificPaper=$_POST['scientific'];
			$englishstatus=$_POST['englishstatus'];
			$yearb=$_POST['year'];
			$institution=$_POST['institution'];
			$score=$_POST['score'];

			$achievement=$_POST['achievement'];
			$year=$_POST['yeara'];
			$t_achievement = [];
			
			$j = 1;
			for($i = 0; $i < sizeof($achievement); $i++){
				if($achievement[$i]!="" && $year[$i]!=""){
					array_push($t_achievement, [
						'applicant_no' => $applicant_no,
						'item_no' => $j,
						'achievement_details' => $achievement[$i],
						'year' => $year[$i]
					]);
					$j++;
				}
			}			
				$this ->Recruitment_model->insert_education_information_achievement($t_achievement);
			
			$this ->Recruitment_model->insert_education_information($applicant_no,$funder,$scientificPaper,$englishstatus,$yearb,$institution,$score);
			
			$counter_language=$_POST['countLanguage'];
			for ($i=0; $i < $counter_language; $i++) { 
				$item_no = $i+1;
				$language = $_POST['language'.$item_no];
				$speaking = $_POST['speaking'.$item_no];
				$writing = $_POST['writing'.$item_no];
				$reading = $_POST['reading'.$item_no];
				$this ->Recruitment_model->insert_education_information_language($applicant_no,$item_no,$language,$speaking,$writing,$reading);
			}
			

			$hobby=$_POST['hobby'];
			$newspaper=$_POST['newspaper'];
			$topic=$_POST['topic'];
			$counter_organization=$_POST['countOrganization'];
			$this ->Recruitment_model->insert_social_activity($applicant_no,$hobby,$newspaper,$topic);
			
		
			$organization=$_POST['organization'];
			$place=$_POST['place'];
			$position=$_POST['position'];
			$duration=$_POST['duration'];
			$t_organization = [];

			$oi = 1;
			for($i = 0; $i < sizeof($organization); $i++){
				if($organization[$i]!="" && $place[$i]!=""&& $position[$i]!=""&& $duration[$i]!=""){
					array_push($t_organization, [
				'applicant_no'=>$applicant_no,
				'item_no'=>$oi,
				'name_organization'=>$organization[$i],
				'place'=>$place[$i],
				'position'=>$position[$i],
				'duration'=>$duration[$i]
					]);
					$oi++;
				}
			}			
				$this ->Recruitment_model->insert_social_organization($t_organization);	
			
			$ownership=$_POST['ownership'];
			if ($ownership==1) {
				$ownership=$_POST['ownershipother'];
			}
			$childorder=$_POST['childorder'];
			$totalchild=$_POST['totalchild'];
			$fname=$_POST['fname'];
			$mname=$_POST['mname'];
			$fplace=$_POST['fplace'];
			$mplace=$_POST['mplace'];
			$fdobt=strtotime($_POST['fdob']);
			$fdob=date('Y-m-d',$fdobt);
			$mdobt=strtotime($_POST['mdob']);
			$mdob=date('Y-m-d',$mdobt);
			$feducation=$_POST['feducation'];
			$meducation=$_POST['meducation'];
			$fjob=$_POST['fjob'];
			$mjob=$_POST['mjob'];
			$faddress1=$_POST['faddress1'];
			$faddress2=$_POST['faddress2'];
			$fCity=$_POST['fCity'];
			$fZip=$_POST['fZip'];
			$fPhone=$_POST['fPhone'];
			$fhome=$_POST['fhome'];
			$fhome2=$_POST['fhome2'];
			$spname=$_POST['spname'];
			$spplace=$_POST['spplace'];
			$spdobt=strtotime($_POST['spdob']);
			$spdob=date('Y-m-d',$spdobt);
			$speducation=$_POST['speducation'];
			$spjob=$_POST['spjob'];
			$flawname=$_POST['flawname'];
			$mlawname=$_POST['mlawname'];
			$flawplace=$_POST['flawplace'];
			$mlawplace=$_POST['mlawplace'];
			$flawdobt=strtotime($_POST['flawdob']);
			$flawdob=date('Y-m-d',$flawdobt);
			$mlawdobt=strtotime($_POST['mlawdob']);
			$mlawdob=date('Y-m-d',$mlawdobt);
			$flaweducation=$_POST['flaweducation'];
			$mlaweducation=$_POST['mlaweducation'];
			$flawjob=$_POST['flawjob'];
			$mlawjob=$_POST['mlawjob'];
			$flawadd1=$_POST['flawadd1'];
			$flawadd2=$_POST['flawadd2'];
			$flawCity=$_POST['flawCity'];
			$flawZip=$_POST['flawZip'];
			$flawPhone=$_POST['flawPhone'];
			$flawhome=$_POST['flawhome'];
			$flawhome2=$_POST['flawhome2'];
			$othername=$_POST['othername'];
			$otheradd1=$_POST['otheradd1'];
			$otheradd2=$_POST['otheradd2'];
			$otherCity=$_POST['otherCity'];
			$otherZip=$_POST['otherZip'];
			$otherPhone=$_POST['otherPhone'];
			$otherhome=$_POST['otherhome'];
			$otherhome2=$_POST['otherhome2'];

			$this ->Recruitment_model->insert_family_structure($applicant_no,$ownership,$childorder,$totalchild,$fname,$fplace,$fdob,$feducation,$fjob,$mname,$mplace,$mdob,$meducation,$mjob,$faddress1,$faddress2,$fCity,$fZip,$fPhone,$fhome,$fhome2,$spname,$spplace,$spdob,$speducation,$spjob,$flawname,$flawplace,$flawdob,$flaweducation,$flawjob,$mlawname,$mlawplace,$mlawdob,$mlaweducation,$mlawjob,$flawadd1,$flawadd2,$flawCity,$flawZip,$flawPhone,$flawhome,$flawhome2,$othername,$otheradd1,$otheradd2,$otherCity,$otherZip,$otherPhone,$otherhome,$otherhome2);


			$sname=$_POST['sname'];
			$splace=$_POST['splace'];
			$sdob=$_POST['sdob'];
			$seducation=$_POST['seducation'];
			$sjob=$_POST['sjob'];
			$t_sibling = [];

			$si = 1;
			for($i = 0; $i < sizeof($sname); $i++){
				if($sname[$i]!="" && $splace[$i]!=""&& $sdob[$i]!=""&& $seducation[$i]!=""&& $sjob[$i]!=""){
					array_push($t_sibling, [
				'applicant_no'=>$applicant_no,
				'item_no'=>$si,
				'sibling_name'=>$sname[$i],
				'sibling_place_of_birth'=>$splace[$i],
				'sibling_date_of_birth'=>$sdob[$i],
				'sibling_education'=>$seducation[$i],
				'sibling_occupation'=>$sjob[$i]
					]);
					$si++;
				}
			}			
			$this ->Recruitment_model->insert_family_siblings($t_sibling);	

			$cname=$_POST['cname'];
			$cplace=$_POST['cplace'];
			$cdob=$_POST['cdob'];
			$ceducation=$_POST['ceducation'];
			$cjob=$_POST['cjob'];
			$t_child = [];

			$ci = 1;
			for($i = 0; $i < sizeof($cname); $i++){
				if($cname[$i]!="" && $cplace[$i]!=""&& $cdob[$i]!=""&& $ceducation[$i]!=""&& $cjob[$i]!=""){
					array_push($t_child, [
				'applicant_no'=>$applicant_no,
				'item_no'=>$ci,
				'child_name'=>$cname[$i],
				'child_place_of_birth'=>$cplace[$i],
				'child_date_of_birth'=>$cdob[$i],
				'child_education'=>$ceducation[$i],
				'child_occupation'=>$cjob[$i]
					]);
					$ci++;
				}
			}			

			$this ->Recruitment_model->insert_family_child($t_child);	

			$namec1= $_POST['namec1'];
			$addc1= $_POST['addc1'];
			$phonec1= $_POST['phonec1'];
			$snamec1= $_POST['snamec1'];
			$sposc1= $_POST['sposc1'];
			$posc1= $_POST['posc1'];
			$typec1= $_POST['typec1'];
			$startc1= $_POST['startc1'];
			$endc1= $_POST['endc1'];
			$suborc1= $_POST['suborc1'];
			$salc1= $_POST['salc1'];
			$benc1= $_POST['benc1'];
			$fac1= $_POST['fac1'];
			$namec2= $_POST['namec2'];
			$addc2= $_POST['addc2'];
			$phonec2= $_POST['phonec2'];
			$snamec2= $_POST['snamec2'];
			$sposc2= $_POST['sposc2'];
			$posc2= $_POST['posc2'];
			$typec2= $_POST['typec2'];
			$startc2= $_POST['startc2'];
			$endc2= $_POST['endc2'];
			$suborc2= $_POST['suborc2'];
			$salc2= $_POST['salc2'];
			$benc2= $_POST['benc2'];
			$fac2= $_POST['fac2'];
			$achievementc1= $_POST['achievementc1'];
			$careerc1= $_POST['careerc1'];
			$reason1=$_POST['reas1'];
			$reason2=$_POST['reas2'];
			$this->Recruitment_model->insert_employement_history($applicant_no,$namec1,$addc1,$phonec1,$snamec1,$sposc1,$posc1,$typec1,$startc1,$endc1,$suborc1,$salc1,$benc1,$fac1,$reason1,$namec2,$addc2,$phonec2,$snamec2,$sposc2,$posc2,$typec2,$startc2,$endc2,$suborc2,$salc2,$benc2,$fac2,$reason2,$achievementc1,$careerc1);
			$dyna= $_POST['dyna'];
			if ($dyna=="Yes") {
				$yposition= $_POST['yposition'];
			}else{
				$yposition=" ";
			}
			$yreason= $_POST['yreason'];
			$yhow= $_POST['yhow'];
			$workplace= $_POST['workplace'];
			if ($workplace=="Other") {
				$workplace= $_POST['workplaceother'];
			}
			$workplacereason= $_POST['workplacereason'];
			$ysal= $_POST['ysal'];
			$yben= $_POST['yben'];
			$yfac= $_POST['yfac'];
			$threemonth= $_POST['threemonth'];
			$oneyear= $_POST['oneyear'];
			$assigncity= $_POST['assigncity'];
			$locatecity= $_POST['locatecity'];
			$this->Recruitment_model->insert_other_information($applicant_no,$dyna,$yposition,$yreason,$yhow,$workplace,$workplacereason,$ysal,$yben,$yfac,$threemonth,$oneyear,$assigncity,$locatecity);
			$workcust= $_POST['workcust'];
			if ($workcust=="1") {
				$namecust= $_POST['namecust'];
			}else{
				$namecust=" ";
			}
			$worksub= $_POST['worksub'];
			if ($worksub=="1") {
				$namesub= $_POST['namesub'];
			}else{
				$namesub=" ";
			}
			$diseasestat= $_POST['diseasestat'];
			if ($diseasestat=="1") {
				$diseasename= $_POST['diseasename'];
				$diseaseyear= $_POST['diseaseyear'];
			}else{
				$diseasename= ' ';
				$diseaseyear= ' ';
			}
			$accidentstat= $_POST['accidentstat'];
			if ($accidentstat=="1") {
				$accidentname= $_POST['accidentname'];
				$accidentcause= $_POST['accidentcause'];
				$accidentyear1=strtotime($_POST['accidentyear']);
				$accidentyear=date('Y-m-d',$accidentyear1);
			}else{
				$accidentname= ' ';
				$accidentcause= ' ';
				$accidentyear= ' ';
			}
			$glass= $_POST['glass'];
			$smoke= $_POST['smoke'];
			$bloodtype= $_POST['bloodtype'];
			$vehicletype= $_POST['vehicletype'];
			$owner= $_POST['owner'];
			$license= $_POST['license'];
			$acknowledge1= $_POST['acknowledge1'];
			$relation= $_POST['relation'];
			$namer1= $_POST['namer1'];
			$posr1= $_POST['posr1'];
			$comr1= $_POST['comr1'];
			$addr1= $_POST['addr1'];
			$telr1= $_POST['telr1'];
			$relr1= $_POST['relr1'];
			$namer2= $_POST['namer2'];
			$posr2= $_POST['posr2'];
			$comr2= $_POST['comr2'];
			$addr2= $_POST['addr2'];
			$telr2= $_POST['telr2'];
			$relr2= $_POST['relr2'];
			$contact= $_POST['contact'];
			$readywork1=strtotime($_POST['readywork']);
			$readywork=date('Y-m-d',$readywork1);
			$this->Recruitment_model->insert_others($applicant_no,$workcust,$namecust,$worksub,$namesub,$diseasestat,$diseasename,$diseaseyear,$accidentstat,$accidentname,$accidentyear,$accidentcause,$glass,$smoke,$bloodtype,$vehicletype,$owner,$license,$acknowledge1,$relation,$namer1,$posr1,$comr1,$addr1,$telr1,$relr1,$namer2,$posr2,$comr2,$addr2,$telr2,$relr2,$contact,$readywork);
		}
		$applicantNo= $checkapp;
		$data['dataLookup'] = $this->Recruitment_model->select_reqno();
		$data['listreq']=$this->Recruitment_model->select_all();
		$data['listreq2']=$this->Recruitment_model->select_all2();
		$data['isi']=$this->Recruitment_model->searchApp1($applicantNo);
		$data['isi2']=$this->Recruitment_model->searchApp2($applicantNo);
		$data['isi3']=$this->Recruitment_model->searchApp3($applicantNo);
		$data['isi4']=$this->Recruitment_model->searchApp4($applicantNo);
		$data['isi5']=$this->Recruitment_model->searchApp5($applicantNo);
		$data['isi6']=$this->Recruitment_model->searchApp6($applicantNo);
		$data['isi7']=$this->Recruitment_model->searchApp7($applicantNo);
		$data['isi8']=$this->Recruitment_model->searchApp8($applicantNo);
		$data['isi9']=$this->Recruitment_model->searchApp9($applicantNo);
		$data['isi10']=$this->Recruitment_model->searchApp10($applicantNo);
		$data['isi11']=$this->Recruitment_model->searchApp11($applicantNo);
		$data['isi12']=$this->Recruitment_model->searchApp12($applicantNo);
		$data['isi13']=$this->Recruitment_model->searchApp13($applicantNo);
		$data['isi14']=$this->Recruitment_model->searchApp14($applicantNo);
		$data['isi15']=$this->Recruitment_model->searchApp15($applicantNo);
		if (!isset($data['isi'])) {
			$data['isi']=NULL;
		}
		if (!isset($data['isi2'])) {
			$data['isi2']=NULL;
		}
		if (!isset($data['isi3'])) {
			$data['isi3']=NULL;
		}
		if (!isset($data['isi4'])) {
			$data['isi4']=NULL;
		}
		if (!isset($data['isi5'])) {
			$data['isi5']=NULL;
		}
		if (!isset($data['isi6'])) {
			$data['isi6']=NULL;
		}
		if (!isset($data['isi7'])) {
			$data['isi7']=NULL;
		}
		if (!isset($data['isi8'])) {
			$data['isi8']=NULL;
		}
		if (!isset($data['isi9'])) {
			$data['isi9']=NULL;
		}
		if (!isset($data['isi10'])) {
			$data['isi10']=NULL;
		}
		if (!isset($data['isi11'])) {
			$data['isi11']=NULL;
		}
		if (!isset($data['isi12'])) {
			$data['isi12']=NULL;
		}
		if (!isset($data['isi13'])) {
			$data['isi13']=NULL;
		}
		if (!isset($data['isi14'])) {
			$data['isi14']=NULL;
		}
		if (!isset($data['isi15'])) {
			$data['isi15']=NULL;
		}
		$data['appno']=$applicantNo;
		$data['showForm']=1;
		$data['dataLookup'] = $this->Recruitment_model->select_reqno();
		$data['basic']=NULL;
		// $data['showForm']=1;
		// $data['appno']=$applicantNo;
		$data['basic']=$this->Recruitment_model->searchBasic($applicantNo);
		// $this->load->view('recruitement/update', $data);
		$this->load->view('recruitement/update', $data);
	}

	public function searchApplicant()
	{
		if (isset($_POST['applicantNo'])) {
			$applicantNo= $_POST['applicantNo'];
			$data['dataLookup'] = $this->Recruitment_model->select_reqno();
			$data['listreq']=$this->Recruitment_model->select_all();
			$data['listreq2']=$this->Recruitment_model->select_all2();
			$data['isi']=$this->Recruitment_model->searchApp1($applicantNo);
			if(isset($data['isi'])){
				$data['isi2']=$this->Recruitment_model->searchApp2($applicantNo);
				$data['isi3']=$this->Recruitment_model->searchApp3($applicantNo);
				$data['isi4']=$this->Recruitment_model->searchApp4($applicantNo);
				$data['isi5']=$this->Recruitment_model->searchApp5($applicantNo);
				$data['isi6']=$this->Recruitment_model->searchApp6($applicantNo);
				$data['isi7']=$this->Recruitment_model->searchApp7($applicantNo);
				$data['isi8']=$this->Recruitment_model->searchApp8($applicantNo);
				$data['isi9']=$this->Recruitment_model->searchApp9($applicantNo);
				$data['isi10']=$this->Recruitment_model->searchApp10($applicantNo);
				$data['isi11']=$this->Recruitment_model->searchApp11($applicantNo);
				$data['isi12']=$this->Recruitment_model->searchApp12($applicantNo);
				$data['isi13']=$this->Recruitment_model->searchApp13($applicantNo);
				$data['isi14']=$this->Recruitment_model->searchApp14($applicantNo);
				$data['isi15']=$this->Recruitment_model->searchApp15($applicantNo);
				$data['appno']=$applicantNo;
				$data['showForm']=1;
				$this->load->view('recruitement/update', $data);
			}else{
				$data['isi']=NULL;
				$data['isi2']=NULL;
				$data['isi3']=NULL;
				$data['isi4']=NULL;
				$data['isi5']=NULL;
				$data['isi6']=NULL;
				$data['isi7']=NULL;
				$data['isi8']=NULL;
				$data['isi9']=NULL;
				$data['isi10']=NULL;
				$data['isi11']=NULL;
				$data['isi12']=NULL;
				$data['isi13']=NULL;
				$data['isi14']=NULL;
				$data['isi15']=$this->Recruitment_model->searchApp15($applicantNo);
				$data['basic']=NULL;
				$data['showForm']=1;
				$data['appno']=$applicantNo;
				$data['basic']=$this->Recruitment_model->searchBasic($applicantNo);
				$this->load->view('recruitement/update', $data);
			}
		} else {
			$this->update();
		}
	}

	# LIST #
	public function rec_list()
	{
		if($this->session->userdata('pernr') || $this->session->userdata('pernr') != "") {
			$pernr = $this->session->userdata('pernr');
			$hrd_status = $this->Recruitment_model->hrd_status($pernr);
			if (!$hrd_status) {
				redirect('Request/Create');
			}
		}
		else{
			redirect('');
		}
		$data['applicant_list']="";
		$data['request_general'] = $this->Recruitment_model->get_all_request_general();
		$data['position']=$this->Recruitment_model->get_all_position();
		$data['plant'] = $this->Ess_model->get_all_plant();
		$data['department'] = $this->Ess_model->get_all_department();
		$data['name']=$this->Recruitment_model->get_all_name();
		$data['major'] = $this->Recruitment_model->get_all_major();
		$this->load->view('recruitement/list', $data);
	}
	public function getApplicantList()
	{
		$body = "";	
		if (empty($_POST['request_no'])) {
			$request_no = '%%';
		}
		else
		{
			$input_reqno = $_POST['request_no'];
			$request_no = implode("','",$input_reqno);
			$request_no = "'".$request_no."'";
		}
		if (empty($_POST['plant'])) {
			$plant = '%%';
		}
		else
		{
			$input_plant = $_POST['plant'];
			$plant = implode("','", $input_plant);
			$plant = "'".$plant."'";
		}
		if (empty($_POST['department'])) {
			$department = '%%';
		}
		else
		{
			$input_department = $_POST['department'];
			$department = implode("','", $input_department);
			$department = "'".$department."'";
		}
		if (empty($_POST['position'])) {
			$position = '%%';
		}
		else
		{
			$input_position = $_POST['position'];
			$position = implode("','", $input_position);
			$position = "'".$position."'";
		}
		if (empty($_POST['name'])) {
			$name = '%%';
		}
		else
		{
			$input_name = $_POST['name'];
			$name = implode("','", $input_name);
			$name = "'".$name."'";
		}
		if (empty($_POST['major'])) {
			$major = '%%';
		}
		else
		{
			$input_major = $_POST['major'];
			$major = implode("','", $input_major);
			$major = "'".$major."'";
		}

		$create_from1 = strtotime($_POST['create_from']);
		$create_from = date('Y-m-d',$create_from1);

		$create_to1 = strtotime($_POST['create_to']);
		$create_to = date('Y-m-d',$create_to1);
		if ($create_from == "1970-01-01" && $create_to == "1970-01-01") {
			$create_to = NULL;
		}
		// $status= "Processing...";
		$a = $this->Recruitment_model->getApplicantList($request_no, $plant, $department, $position, $name, $major, $create_from,$create_to);
			
		$applicant_list = $this->Recruitment_model->getApplicantList($request_no, $plant, $department, $position, $name, $major, $create_from,$create_to);
		if($applicant_list != FALSE){
			$i=0;
			foreach ($applicant_list as $line)
			{
				$body.="<tr onClick='window.location.href=\"".base_url().'Recruitment/updateView?id='.$line['applicant_no']."\"'>
				<td>".$line['request_no']."</td>
				<td>".$line['applicant_no']."</td>
				<td>".$line['plant']."</td>
				<td>".$this->Ess_model->get_department($line['plant'],$line['department'])."</td>
				<td>".$line['position']."</td>
				<td>".$line['name']."</td>
				<td>".$line['major']."</td>
				<td>".$this->Recruitment_model->get_status_applicant($line['applicant_no'],$line['request_no'])."</td>
				<td>".$line['created_at']."</td>
			</tr>";
			$i++;
		}
		$tabel = "<div class='row'>
		<div class='col-lg-12'>
			<div class='portlet box blue-madison'>
				<div class='portlet-title'>
					<div class='caption'>
						Applicant List
					</div>
					<div class='tools'>
						<a href='javascript: void(0);' class='collapse'></a>
					</div>
				</div>
				<div class='portlet-body form applicant-list'>
					<div class='form-body'>
						<div class='row zrow'>
							<div class='col-lg-12'>
								<table id='applicant-list-table' class='table table-striped table-bordered' cellspacing='0' width='100%'>
									<thead>
										<tr >
											<th>Request Number</th>
											<th>Applicant Numbers</th>
											<th>Plant</th>
											<th>Department</th>
											<th>Position</th>
											<th>Name</th>
											<th>Major</th>
											<th>Status</th>
											<th>Created On</th>
										</tr>
									</thead>
									<tbody>".$body."  
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
	echo $tabel;
}
else
{
	$kosong = "<div class='row'>
	<div class='col-lg-12'>
		<div class='portlet box blue-madison'>
			<div class='portlet-title'>
				<div class='caption'>
					Applicant List
				</div>
				<div class='tools'>
					<a href='javascript: void(0);' class='collapse'></a>
				</div>
			</div>
			<div class='portlet-body form applicant-list'>
				<div class='form-body'>
					<div class='row zrow'>
						<div class='col-lg-12'>
							<table id='applicant-list-table' class='table table-striped table-bordered' cellspacing='0' width='100%'>
								<thead>
									<tr>
										<th>Request Number</th>
										<th>Applicant Numbers</th>
										<th>Plant</th>
										<th>Department</th>
										<th>Position</th>
										<th>Name</th>
										<th>Major</th>
										<th>Status</th>
										<th>Created On</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>";
echo $kosong;
}
}
	public function ambilStatusAplikan(){
		$statusAplikan = $this->Recruitment_model->get_status_applicant('00000035','17070001');
		echo "$statusAplikan";
		// var_dump($statusAplikan);
	}
	# END Controller for List #

	# NEXT #
	function next(){
		if($this->session->userdata('pernr') || $this->session->userdata('pernr') != "") {
			$pernr = $this->session->userdata('pernr');
			$hrd_status = $this->Recruitment_model->hrd_status($pernr);
			if (!$hrd_status) {
				redirect('Request/Create');
			}
		}
		else{
			redirect('');
		}
			$data = array('applicant_list'=>'');
			$pernr = $this->session->userdata('pernr');
			// plant, BU/Div/Apartment, position, direct superior, budget, job class, number of employee, working status, expected working date
			$data['plant'] = $this->Ess_model->get_all_plant();
			$data['department'] = $this->Ess_model->get_all_department();
			$data['position']=$this->Recruitment_model->get_all_position();
			$data['direct_superior'] = $this->Ess_model->get_superior($pernr);
			$data['all_employee'] = $this->ess_model->get_all_employee();
			$data['request_general'] = $this->Recruitment_model->get_all_request_general();
			$data['all_job_class'] = $this->ess_model->get_all_job_class();
			// var_dump($data['all_job_class']);
			// $data['in_the_budget'] = '1';
			$this->load->view('recruitement/next', $data);
		}

		function getRequestList(){
			// echo "aaa";
			$body = "";
			if (empty($_POST['plant'])) {
				$plant = '%%';
			}
			else
			{
				$input_plant = $_POST['plant'];
				$plant = implode("','", $input_plant);
				$plant = "'".$plant."'";
			}

			if (empty($_POST['position'])) {
				$position = '%%';
			}
			else
			{
				$input_position = $_POST['position'];
				$position = implode("','", $input_position);
				$position = "'".$position."'";
			}

			if (empty($_POST['department'])) {
				$department = '%%';
			}
			else
			{
				$input_department = $_POST['department'];
				$department = implode("','", $input_department);
				$department = "'".$department."'";
			}
			
			if (empty($_POST['direct_superior'])) {
				$direct_superior = '%%';
			}
			else
			{
				$input_direct_superior = $_POST['direct_superior'];
				$direct_superior = implode("','", $input_direct_superior);
				$direct_superior = "'".$direct_superior."'";

			}

			if (empty($_POST['budget'])) {
				$budget = '%%';
			}
			else
			{
				$budget = $_POST['budget'];
			}

			if(empty($_POST['job_class'])){
				$job_class = '%%';
			}
			else
			{
				$input_job_class = $_POST['job_class'];
				$job_class = implode("','",$input_job_class);
				$job_class = "'".$job_class."'";
			}

			if (empty($_POST['number_of_employee'])) {
				$number_of_employee = '%%';
			}
			else
			{
				$number_of_employee = $_POST['number_of_employee'];
			}

			// if (empty($_POST['number_of_employee'])) {
			// 	$number_of_employee = '%%';
			// }
			// else
			// {
			// 	$number_of_employee = $_POST['number_of_employee'];
			// }

			if (!isset($_POST['working_status'])) {
				$working_status = '%%';
			}
			else
			{
				$input_working_status = $_POST['working_status'];
				$working_status = implode("','",$input_working_status);
				$working_status = "'".$working_status."'";
			}

			if (empty($_POST['working_date'])){
				$working_date = '%%';
			}
			else
			{
				$working_date2 = strtotime($_POST['working_date']);
				$working_date = date('Y-m-d',$working_date2);
			}
			$budget = $_POST['budget'];
			$request_list = $this->Recruitment_model->getRequestList($plant,$position, $department,$direct_superior,$budget,$job_class,$number_of_employee,$working_status,$working_date,$budget);
			if ($request_list!=FALSE) {
				$body = "<tbody>";
				foreach ($request_list as $line) {
					// reqStatQuery untuk request status
					$reqStatQuery = $this->Request_model->getAllLastApprovalRequest($line['request_no']);
					if($reqStatQuery['status'] == ""){
						$request_status = "Waiting ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
					} else if($reqStatQuery['status'] == "0"){
						$request_status = "Rejected ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
					} else if($reqStatQuery['status'] == "1"){
						if ($reqStatQuery['approval_code'] == 'CL')
						$request_status = $this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
						else
						$request_status = "Accepted ".$this->Request_model->getApprovalName($reqStatQuery['approval_code'])['description'];
					}
					// Recruitment Status masih kosong karena belum ada tabel
					$recruitment_status = $this->request_model->getHiringStatus($line['request_no']);
					$created_at2 = strtotime($line['created_at']);
					$created_at = date('d-m-Y',$created_at2);
					$body.="<tr class='clickable_row' data-no='".$line['request_no']."'>
					<td >".$line['request_no']."</td>
					<td>".$line['position']."</td>
					<td>".$this->Request_model->getReasonName($line['reason'])['description']."</td>
					<td>".$this->Request_model->getWorkingStatusName($line['working_status'])['description']."</td>
					<td>".$line['number_of_employee']."</td>
					<td>".$this->ess_model->get_name($line['created_by'])."</td>
					<td>".$this->ess_model->get_department($line['plant'],$line['department'])."</td>
					<td>".$created_at."</td>
					<td>".$request_status."</td>
					<td>".$recruitment_status."</td>
					</tr>";
				}
				$body .= "</tbody>";
			}
			else
			{
				$body = "";
			}
			$tabel = 
			"<div class='row'>
				<div class='col-lg-12'>
					<div class='portlet box blue-madison'>
						<div class='portlet-title'>
							<div class='caption'>
								Applicant List
							</div>
							<div class='tools'>
								<a href='javascript: void(0);' class='collapse'></a>
							</div>
						</div>
						<div class='portlet-body form applicant-list'>
							<div class='form-body'>
								<div class='row zrow'>
									<div class='col-lg-12'>
										<table id='applicant-list-table' class='table table-striped table-bordered' cellspacing='0' width='100%'>
												<thead>
												    <tr>
												        <th>Request No.</th>
												        <th>Position</th>
												        <th>Reason For Request</th>
												        <th>Working Status</th>
												        <th>No. of Employees</th>
												        <th>Created By</th>
												        <th>Department</th>
														<th>Created On</th>
												        <th>Request Status</th>
												        <th>Recruitment Status</th>
													</tr>
												</thead>".$body."
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>";
			// echo "$request_list";
			echo "$tabel";
		}

		public function nextList($request_no,$from){
			$data['no'] = $request_no;
			$data['from'] = $from;
			$status_pretest = $this->Recruitment_model->getPretestData($data['no']);
			$status_hr_interview = $this->Recruitment_model->getHRInterviewData($data['no']);
			$status_psy_test = $this->Recruitment_model->getPsyTestData($data['no']);
			$status_user_interview = $this->Recruitment_model->getUserInterviewData($data['no']);
			$status_final_interview = $this->Recruitment_model->getFinalInterviewData($data['no']);
			$status_medical_checkup = $this->Recruitment_model->getMedicalCheckupData($data['no']);
			$status_finalize = $this->Recruitment_model->getFinalizeData($data['no']);
			$data['applicant'] = $status_pretest;
			$data['applicant_hr'] = $status_hr_interview;
			$data['applicant_psy'] = $status_psy_test;
			$data['applicant_user'] = $status_user_interview;
			$data['applicant_final'] = $status_final_interview;
			$data['applicant_medical_checkup'] = $status_medical_checkup;
			
			$data['hiring_availability'] = $this->Recruitment_model->getHiringAvailabilityStatus($data['no']);
			$availability = $this->Recruitment_model->getHiringAvailabilityStatus($data['no']);
			$data_finalize = [];
			foreach ($status_finalize as $line) {
				array_push($data_finalize, [
					'applicant_no'=>$line['applicant_no'],
					'request_no'=>$line['request_no'],
					'name'=>$line['name'],
					'position'=>$line['position'],
					'position_no'=>$line['position_no'],
					'sk_number'=>$line['sk_number'],
					'first_working_date'=>$line['first_working_date'],
					'end_of_contract'=>$line['end_of_contract'],
					'personnel'=>$line['personnel'],
					'test_status_pretest'=>$line['test_status_pretest'],
					'test_status_hr_interview'=>$line['test_status_hr_interview'],
					'test_status_psy_test'=>$line['test_status_psy_test'],
					'test_status_user_interview'=>$line['test_status_user_interview'],
					'test_status_final_interview'=>$line['test_status_final_interview'],
					'test_status_medical_checkup'=>$line['test_status_medical_checkup'],
					'status_hiring'=>$line['status_hiring'],
					'status_proses'=>$this->Recruitment_model->get_status_applicant($line['applicant_no'],$line['request_no'])
				]);
			}
			$data['applicant_finalize'] = $data_finalize;
			// $data['applicant_amount']
			// $status_jumlah_aplikan = [];

			// if ($status_pretest != FALSE && $status_hr_interview !=FALSE && $status_psy_test !=FALSE && $status_user_interview != FALSE &&$status_final_interview!=FALSE) {
				
			// }
			$this->load->view('recruitement/nextList',$data);
		}
		public function checkFungsi(){
			$a = $this->Recruitment_model->getHiringAvailabilityStatus(17070001);
			var_dump($a);
		}
		public function insertPretest(){
			$req_no = $_POST['request_no'];
			$applicant_no = $_POST['app_no'];
			$i = 0;
			foreach ($applicant_no as $a) {
				// $i++;
				if (isset($_POST['test_date_'.$a])) {
					$test_date2 = strtotime($_POST['test_date_'.$a]);
					$test_date = date('Y-m-d',$test_date2);
				}
				else{
					$test_date = '-';
				}
				if (isset($_POST['iq_'.$a])) {
					$iq = $_POST['iq_'.$a];
				}
				else{
					$iq = '';
				}
				if (isset($_POST['mec1_'.$a])) {
					$mec_1 = $_POST['mec1_'.$a];
				}
				else{
					$mec_1 = '';
				}
				if (isset($_POST['mec2_'.$a])) {
					$mec_2 = $_POST['mec2_'.$a];
				}
				else{
					$mec_2 = '';
				}
				if (isset($_POST['status_'.$a])) {
					$test_status = $_POST['status_'.$a];
				}
				else
				{
					$test_status = '';
				}
				if (isset($_POST['speed_'.$a])) {
					$speed = $_POST['speed_'.$a];
				}
				else
				{
					$speed = '';
				}
				if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$iq!=0&&$speed!=0&&$mec_1!=0&&$mec_2!=0&&$test_status!='') {
					$test_status = $test_status.'x';
					$status_submit = $_POST['status_submit_'.$a]."";
				}
				else
				{
					$status_submit = '';
				}
				$next_process = "HR Interview";
				$insert = $this->Recruitment_model->insertPretest($a, 
					$test_date, 
					$iq, 
					$mec_1, 
					$mec_2, 
					$speed, 
					$test_status, 
					$next_process, $status_submit);
			}
			// echo "$insert";
			if ($insert != FALSE) {
				$from = 'pretest';
				$this->nextList($req_no,$from);
			}
			else
			{
				echo "<script>alert('belum masuk');</script>";
			}
		}

		public function insertHRInterview(){
			$req_no = $_POST['request_no'];
			$applicant_no = $_POST['app_no'];
			foreach ($applicant_no as $a) {
				if (isset($_POST['test_date_'.$a])) {
					$test_date2 = strtotime($_POST['test_date_'.$a]);
					$test_date = date('Y-m-d',$test_date2);
				}
				else{
					$test_date = '-';
				}
				if (isset($_POST['status_'.$a])) {
					$test_status = $_POST['status_'.$a];
				}
				else
				{
					$test_status = '';
				}
				if (isset($_POST['remarks_'.$a])) {
					$remarks = $_POST['remarks_'.$a];
				}
				else
				{
					$remarks = '';
				}
				$next_process = "PSY Test";
				$name_for_upload= "upload_file_hr_".$a;
				if (!empty($_FILES[$name_for_upload]['name'])) {
					$file_name = $_FILES[$name_for_upload]['name'];
					$config['upload_path']   = './assets/uploads/recruitment/hr_interview'; 
					$config['allowed_types'] = 'pdf|zip|png|jpg|jpeg|gif'; 
					$config['max_size']      = 1024*35;
					$config['file_name']= $a."-".$file_name;
					$nama_file = $config['file_name'];
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload($name_for_upload)) {
						echo "<script>alert('Failed to upload! Please check your extensions or your file size! Maximum file size allowed is 10MB and file type allowed is pdf, png, jpg, jpeg, and gif.');</script>";
						// $error = array('error' => $this->upload->display_errors()); 
						// echo "string";
						// $this->load->view('recruitement/create', $error); 
						// var_dump($error);
					}
				}
				else{
					if (isset($_POST['file_name_db_'.$a])) {
						$nama_file = $_POST['file_name_db_'.$a];
					}
					else{
						$nama_file = "";
					}
				}
				if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$test_status!=''&&$nama_file!='') {
					$status_submit = $_POST['status_submit_'.$a]."";
					$test_status = $test_status.'x';
				}
				else
				{
					$status_submit = '';
				}
				$insert = $this->Recruitment_model->insertHRInterview($a, $test_date, $test_status, $remarks, $next_process, $status_submit,$nama_file);

				// echo "$nama_file<br>";
			}
			if ($insert != FALSE) {
				$from = 'hr_interview';
				$this->nextList($req_no,$from);
			}
			else
			{
				echo "<script>alert('belum masuk');</script>";
			}
		}
		public function insertPsytest(){
			$req_no = $_POST['request_no'];
			$applicant_no = $_POST['app_no'];
			foreach ($applicant_no as $a) {
				if (isset($_POST['test_date_'.$a])) {
					$test_date2 = strtotime($_POST['test_date_'.$a]);
					$test_date = date('Y-m-d',$test_date2);
				}
				else{
					$test_date = '-';
				}
				if (isset($_POST['status_'.$a])) {
					$test_status = $_POST['status_'.$a];
				}
				else
				{
					$test_status = '';
				}
				if (isset($_POST['remarks_'.$a])) {
					$remarks = $_POST['remarks_'.$a];
				}
				else
				{
					$remarks = '';
				}
				$next_process = "User Interview";
				// if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$test_status!='') {
				// 	$status_submit = $_POST['status_submit_'.$a]."";
				// 	$test_status = $test_status.'x';
				// }
				// else
				// {
				// 	$status_submit = '';
				// }
				// For uploading file
				$name_for_upload= "upload_file_psy_".$a;
				if (!empty($_FILES[$name_for_upload]['name'])) {
					$file_name = $_FILES[$name_for_upload]['name'];
					$config['upload_path']   = './assets/uploads/recruitment/psy_test'; 
					$config['allowed_types'] = 'pdf|zip|png|jpg|jpeg|gif'; 
					$config['max_size']      = 1024*35;
					$config['file_name']= $a."-".$file_name;
					$nama_file = $config['file_name'];
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload($name_for_upload)) {
						echo "<script>alert('Failed to upload! Please check your extensions or your file size! Maximum file size allowed is 10MB and file type allowed is pdf, png, jpg, jpeg, and gif.');</script>";
					}
				}
				else{
					if (isset($_POST['file_name_db_'.$a])) {
						$nama_file = $_POST['file_name_db_'.$a];
					}
					else{
						$nama_file = "";
					}

				}

				if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$test_status!=''&&$nama_file!='') {
					$status_submit = $_POST['status_submit_'.$a]."";
					$test_status = $test_status.'x';
				}
				else
				{
					$status_submit = '';
				}
				$insert = $this->Recruitment_model->insertPsytest($a, $test_date, $test_status, $remarks, $next_process, $status_submit,$nama_file);
			}
			if ($insert != FALSE) {
				$from = 'psy_test';
				$this->nextList($req_no,$from);
			}
			else
			{
				echo "<script>alert('belum masuk');</script>";
			}
		}
		public function insertUserInterview(){
			$req_no = $_POST['request_no'];
			$applicant_no = $_POST['app_no'];
			foreach ($applicant_no as $a) {
				if (isset($_POST['test_date_'.$a])) {
					$test_date2 = strtotime($_POST['test_date_'.$a]);
					$test_date = date('Y-m-d',$test_date2);
				}
				else{
					$test_date = '-';
				}
				if (isset($_POST['status_'.$a])) {
					$test_status = $_POST['status_'.$a];
				}
				else
				{
					$test_status = '';
				}
				if (isset($_POST['remarks_'.$a])) {
					$remarks = $_POST['remarks_'.$a];
				}
				else
				{
					$remarks = '';
				}
				$next_process = "Final Interview";
				// For uploading file
				$name_for_upload= "upload_file_user_".$a;
				if (!empty($_FILES[$name_for_upload]['name'])) {
					$file_name = $_FILES[$name_for_upload]['name'];
					$config['upload_path']   = './assets/uploads/recruitment/user_interview'; 
					$config['allowed_types'] = 'pdf|zip|png|jpg|jpeg|gif'; 
					$config['max_size']      = 1024*35;
					$config['file_name']= $a."-".$file_name;
					$nama_file = $config['file_name'];
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload($name_for_upload)) {
						echo "<script>alert('Failed to upload! Please check your extensions or your file size! Maximum file size allowed is 10MB and file type allowed is pdf, png, jpg, jpeg, and gif.');</script>";
					}
				}
				else{
					if (isset($_POST['file_name_db_'.$a])) {
						$nama_file = $_POST['file_name_db_'.$a];
					}
					else{
						$nama_file = "";
					}
				}
				if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$test_status!=''&&$nama_file!='') {
					$status_submit = $_POST['status_submit_'.$a]."";
					$test_status = $test_status.'x';
				}
				else
				{
					$status_submit = '';
				}
				$insert = $this->Recruitment_model->insertUserInterview($a, $test_date, $test_status, $remarks, $next_process, $status_submit, $nama_file);
			}
			if ($insert != FALSE) {
				$from = 'user_interview';
				$this->nextList($req_no,$from);
			}
			else
			{
				echo "<script>alert('belum masuk');</script>";
			}
		}
		public function insertFinalInterview(){
			$req_no = $_POST['request_no'];
			$applicant_no = $_POST['app_no'];
			foreach ($applicant_no as $a) {
				if (isset($_POST['test_date_'.$a])) {
					$test_date2 = strtotime($_POST['test_date_'.$a]);
					$test_date = date('Y-m-d',$test_date2);
				}
				else{
					$test_date = '-';
				}
				if (isset($_POST['status_'.$a])) {
					$test_status = $_POST['status_'.$a];
				}
				else
				{
					$test_status = '';
				}
				if (isset($_POST['remarks_'.$a])) {
					$remarks = $_POST['remarks_'.$a];
				}
				else
				{
					$remarks = '';
				}
				$next_process = "Medical Checkup";
				// For Uploading File
				$name_for_upload= "upload_file_final_interview_".$a;
				if (!empty($_FILES[$name_for_upload]['name'])) {
					$file_name = $_FILES[$name_for_upload]['name'];
					$config['upload_path']   = './assets/uploads/recruitment/final_interview'; 
					$config['allowed_types'] = 'pdf|zip|png|jpg|jpeg|gif'; 
					$config['max_size']      = 1024*35;
					$config['file_name']= $a."-".$file_name;
					$nama_file = $config['file_name'];
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload($name_for_upload)) {
						echo "<script>alert('Failed to upload! Please check your extensions or your file size! Maximum file size allowed is 10MB and file type allowed is pdf, png, jpg, jpeg, and gif.');</script>";
					}
				}
				else{
					if (isset($_POST['file_name_db_'.$a])) {
						$nama_file = $_POST['file_name_db_'.$a];
					}
					else{
						$nama_file = "";
					}

				}
				if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$test_status!=''&&$nama_file!='') {
					$status_submit = $_POST['status_submit_'.$a]."";
					$test_status = $test_status.'x';
				}
				else
				{
					$status_submit = '';
				}
				$insert = $this->Recruitment_model->insertFinalInterview($a, $test_date, $test_status, $remarks, $next_process, $status_submit, $nama_file);
			}
			if ($insert != FALSE) {
				$from = 'final_interview';
				$this->nextList($req_no,$from);
			}
			else
			{
				echo "<script>alert('belum masuk');</script>";
			}
		}
		public function insertMedicalCheckup(){
			$req_no = $_POST['request_no'];
			$applicant_no = $_POST['app_no'];
			foreach ($applicant_no as $a) {
				if (isset($_POST['test_date_'.$a])) {
					$test_date2 = strtotime($_POST['test_date_'.$a]);
					$test_date = date('Y-m-d',$test_date2);
				}
				else{
					$test_date = '-';
				}
				if (isset($_POST['status_'.$a])) {
					$test_status = $_POST['status_'.$a];
				}
				else
				{
					$test_status = '';
				}
				if (isset($_POST['remarks_'.$a])) {
					$remarks = $_POST['remarks_'.$a];
				}
				else
				{
					$remarks = '';
				}
				$next_process = "Finalize";
				// if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$test_status!='') {
				// 	$status_submit = $_POST['status_submit_'.$a]."";
				// 	$test_status = $test_status.'x';
				// }
				// else
				// {
				// 	$status_submit = '';
				// }
				$name_for_upload= "upload_file_mcu_".$a;
				if (!empty($_FILES[$name_for_upload]['name'])) {
					$file_name = $_FILES[$name_for_upload]['name'];
					$config['upload_path']   = './assets/uploads/recruitment/medical_checkup'; 
					$config['allowed_types'] = 'pdf|zip|png|jpg|jpeg|gif'; 
					$config['max_size']      = 1024*35;
					$config['file_name']= $a."-".$file_name;
					$nama_file = $config['file_name'];
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload($name_for_upload)) {
						echo "<script>alert('Failed to upload! Please check your extensions or your file size! Maximum file size allowed is 10MB and file type allowed is pdf, png, jpg, jpeg, and gif.');</script>";
					}
				}
				else{
					if (isset($_POST['file_name_db_'.$a])) {
						$nama_file = $_POST['file_name_db_'.$a];
					}
					else{
						$nama_file = "";
					}

				}
				if (isset($_POST['status_submit_'.$a])&&$test_date!='1970-01-01'&&$test_status!=''&&$nama_file!='') {
					$status_submit = $_POST['status_submit_'.$a]."";
					$test_status = $test_status.'x';
				}
				else
				{
					$status_submit = '';
				}
				$insert = $this->Recruitment_model->insertMedicalCheckup($a, $test_date, $test_status, $remarks, $next_process, $status_submit,$nama_file);
			}
			if ($insert != FALSE) {
				$from = 'medical_checkup';
				$this->nextList($req_no,$from);
			}
			else
			{
				echo "<script>alert('belum masuk');</script>";
			}
		}
		public function insertFinalize(){
			$from = 'finalize';
			$this->nextList($req_no,$from);
		}
	# END OF NEXT #
	
	
	# START OF ACCEPTED #
	function accepted(){
		if(!$this->session->userdata('pernr') || $this->session->userdata('pernr') == "") {
			redirect('');
		}
		$data = array('applicant_list'=>'');
		$pernr = $this->session->userdata('pernr');
		// plant, BU/Div/Apartment, position, direct superior, budget, job class, number of employee, working status, expected working date
		$data['plant'] = $this->Ess_model->get_all_plant();
		$data['department'] = $this->Ess_model->get_all_department();
		$data['position']=$this->Recruitment_model->get_all_position();
		$data['direct_superior'] = $this->ess_model->get_superior($pernr);
		$data['all_employee'] = $this->ess_model->get_all_employee();
		$data['request_general'] = $this->Recruitment_model->get_all_request_general();
		$data['all_job_class'] = $this->ess_model->get_all_job_class();
		// var_dump($data['all_job_class']);
		// $data['in_the_budget'] = '1';
		$this->load->view('recruitement/accepted', $data);
	}
	# END OF ACCEPTED #

	# START OF HIRING #
	function insertHiring(){
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
		$birth_date_0002 = $_POST['birthdate_0002'];
		$nationality_0002 = $_POST['nationality_0002'];
		$religion_0002 = $_POST['religion_0002'];
		$marriage_status_0002 = $_POST['marriage_status_0002'];

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
		$date_of_task_0019 = $_POST['date_of_task_0019'];
		$proc_indicator_0019 = $_POST['proc_indicator_0019'];
		$reminder_date_0019 = $_POST['reminder_date_0019'];
		
		/* FORM 0021 */
		$valid_from_0021 = $_POST['valid_from_0021'];
		$valid_to_0021 = $_POST['valid_to_0021'];
		$member_0021 = $_POST['member_0021'];
		$name_0021 = $_POST['name_0021'];
		$gender_0021 = $_POST['gender_0021'];
		$birth_place_0021 = $_POST['birth_place_0021'];
		$date_of_birth_0021 = $_POST['date_of_birth_0021'];
		
		$statusInsert = $this->Recruitment_model->insertHiring($applicant_no,$valid_from_0000,$valid_to_0000,$position_no_0000,$personnel_area_0000,$employee_subgroup_0000,$valid_from_0001,$valid_to_0001,$personnel_subarea_0001,$payroll_area_0001,$contract_0001,$valid_from_0002,$valid_to_0002,$first_name_0002,$last_name_0002,$nick_name_0002,$gender_0002,$birth_date_0002,$nationality_0002,$religion_0002,$marriage_status_0002,$valid_from_0007, $valid_to_0007, $ws_rule_0007,$valid_from_0008, $valid_to_0008, $reason_0008, $personnel_type_0008, $personnel_area_0008, $personnel_group_0008, $personnel_level_0008, $wage_type_0008, $wage_amount_0008,$valid_from_0009, $valid_to_0009, $payee_0009, $payee_loc_0009, $bank_country_0009, $bank_key_0009, $bank_acc_0009, $payment_method_0009, $purpose_0009, $payment_curr_0009,$task_type_0019,$date_of_task_0019,$proc_indicator_0019,$reminder_date_0019);
		var_dump($statusInsert);
	}
	# END OF HITING #
}
?>