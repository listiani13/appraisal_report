<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	
	}

	public function force_sessions() {
		$email = 'desti.hapsari@dynapackasia.com';
		$pernr = $this->ess_model->get_pernr($email);
		if($pernr) {
			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('pernr', $pernr);
			$this->session->set_userdata('ename', $this->ess_model->get_name($pernr));
		}
	}

	function get_query($query){
		return $this->db->query( $query )->result_array();
	}

	function truncate_approval(){
		$query = "TRUNCATE `m_approval_user`";
		$this->db->query($query);
	}

	function dump_approval($str){
		foreach ($str as $s) {
			$query = "INSERT INTO `m_approval_user`(`code`, `plant`, `user`, `target`) VALUES ('".$s['code']."','".$s['plant']."','".$s['user']."','".$s['target']."')";
			$this->db->query($query);
		}
	}
}