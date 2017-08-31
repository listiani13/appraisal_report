<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sendmail extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		require FCPATH.'assets/PHPMailer/PHPMailerAutoload.php';
		$this->load->model('sendmail_model');
	}

	function index()
	{
		$request_no = 0;
		$this->sendmail_model->sendmail($request_no);
	}
}?>