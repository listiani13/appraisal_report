<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ExcelDataInsert extends CI_Controller
{

public function __construct() {
        parent::__construct();
                $this->load->library('excel');//load PHPExcel library 
		            // $this->load->model('upload_model');//To Upload file in a directory
                $this->load->model('excel_data_insert_model');
}	
public function index(){
  $this->load->view('recruitement/coba-excel');
}
public	function ExcelDataAdd()	{  
//Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 
    $config['upload_path']   = './assets/uploads/recruitment'; 
    $config['allowed_types'] = 'xlsx|xls'; 
    $config['max_size']      = 1024*30;
    $file_name = $_FILES['userfile']['name'];
    $file_type =pathinfo($file_name, PATHINFO_EXTENSION);
    $config['file_name']   = $_FILES['userfile']['name'];
    $this->upload->initialize($config);
    if ( ! $this->upload->do_upload('userfile')) {
      $error = array('error' => $this->upload->display_errors()); 
      var_dump($error);
    }
    if ($file_type == 'xls') {
      // For Excel 2003
      $objReader =PHPExcel_IOFactory::createReader('Excel5'); 
    }
    elseif($file_type == 'xlsx'){
      // For Excel 2007
      $objReader= PHPExcel_IOFactory::createReader('Excel2007');
    }
  
    //Set to read only
          $objReader->setReadDataOnly(true); 		  
        //Load excel file
		 $objPHPExcel=$objReader->load(FCPATH.'assets/uploads/recruitment/'.$file_name);		 
         $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel      	 
         $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);                
          //loop from first data untill last data
          for($i=2;$i<=$totalrows;$i++)
          {
              $FirstName= $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();			
              $LastName= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue(); //Excel Column 1
			  $Email= $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); //Excel Column 2
			  $Mobile=$objWorksheet->getCellByColumnAndRow(3,$i)->getValue(); //Excel Column 3
			  $Address=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue(); //Excel Column 4
			  $data_user=array('FirstName'=>$FirstName, 'LastName'=>$LastName ,'Email'=>$Email ,'Mobile'=>$Mobile , 'Address'=>$Address);
			  $this->excel_data_insert_model->Add_User($data_user);
              
						  
          }
             // unlink('./assets/uploads/recruitment/'.$file_name); //File Deleted After uploading in database .			 
             
	       $this->load->view('recruitement/coba-excel');
       
     }
	
}
?>