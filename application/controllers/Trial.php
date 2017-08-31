<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trial extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// force sessions
		$this->load->model('approval_model');
		$this->load->model('ess_model');
		$this->approval_model->force_sessions();
	}

	public function get_plans($pernr)
	{
		$result = array();
		$plans = $this->ess_model->get_query("SELECT plans_pernr FROM mysql_dump_structure_new WHERE kd_form = '99' AND pernr = '".$pernr."'");
		foreach($plans as $p) {
			array_push($result,$p['plans_pernr']);
		}
		return $result;
	}

	public function get_plants($plans)
	{
		$result = array();
		$sub = $this->ess_model->get_query("SELECT pernr FROM mysql_dump_structure_new WHERE kd_form = '99' AND ( plans_sup1 = '".$plans."' OR plans_sup2 = '".$plans."' OR plans_sup3 = '".$plans."' )");
		foreach($sub as $s) {
			$plant = $this->ess_model->get_query("SELECT werks FROM mysql_pa0001 WHERE pernr = '".$s['pernr']."' AND endda = '9999-12-31'");
			foreach ($plant as $p) {
				if (!in_array($p['werks'],$result))
				array_push($result,$p['werks']);
			}
		}
		if (count($result) == 0) {
			$plant = $this->ess_model->get_query("SELECT werks FROM mysql_pa0001 WHERE plans = '".$plans."' AND endda = '9999-12-31'");
			foreach ($plant as $p) {
				if (!in_array($p['werks'],$result))
				array_push($result,$p['werks']);
			}
		}
		return $result;
	}

	public function index()
	{
	}

	public function dump()
	{
		ini_set('memory_limit', '-1');

		$idx = 1;
		$str = array();
		$structure = $this->approval_model->get_query("SELECT * FROM m_approval ORDER BY sequence");
		$pernrs = $this->ess_model->get_query("SELECT DISTINCT pernr FROM mysql_pa0001 WHERE endda = '9999-12-31' ORDER BY pernr");

		$this->approval_model->truncate_approval();
		foreach ($pernrs as $pernr) {
			$pernr = $pernr['pernr'];
			$planss = $this->get_plans($pernr);
			foreach ($planss as $plans) {
				$plants = $this->get_plants($plans);
				foreach ($plants as $plant) {
					$valid = false;
					foreach ($structure as $s) {
						if ($s['self'] == 'X') {
							$str[$idx] = array();
							$str[$idx]['code']   = $s['code'];
							$str[$idx]['plant']  = $plant;
							$str[$idx]['user']   = $pernr;
							$str[$idx]['target'] = $pernr;
							$idx++;
						} elseif ($s['fixed'] != '') {
							if ($s['code'] == 'RG' && ($plant == 'DN00' || $plant == 'DP00')) {
								$str[$idx] = array();
								$str[$idx]['code']   = $s['code'];
								$str[$idx]['plant']  = $plant;
								$str[$idx]['user']   = $pernr;
								$str[$idx]['target'] = '9276';
								$idx++;
							} else {
								$str[$idx] = array();
								$str[$idx]['code']   = $s['code'];
								$str[$idx]['plant']  = $plant;
								$str[$idx]['user']   = $pernr;
								$str[$idx]['target'] = $s['fixed'];
								$idx++;
							}
						} elseif ($s['source'] == 'm_hrd') {
							if ($plant == 'DN00' || $plant == 'DP00') {
								$str[$idx] = array();
								$str[$idx]['code']   = $s['code'];
								$str[$idx]['plant']  = $plant;
								$str[$idx]['user']   = $pernr;
								$str[$idx]['target'] = '9276'; // Eveline Hartono
								$idx++;
							} else {
								$hrd = $this->ess_model->get_query("SELECT * FROM m_hrd WHERE persarea = '".$plant."'");
								foreach ($hrd as $h) {
									$str[$idx] = array();
									$str[$idx]['code']   = $s['code'];
									$str[$idx]['plant']  = $plant;
									$str[$idx]['user']   = $pernr;
									$str[$idx]['target'] = $h['nik'];
									$idx++;
								}
							}
						} elseif ($s['code'] == 'DS') {
							$except = array('DPH','DVH','AD','MD','GMD','PD');
							$sups = $this->ess_model->get_query("SELECT pernr_sup1,plans_sup1 FROM mysql_dump_structure_new WHERE kd_form = '99' AND plans_pernr = '".$plans."'");
							if (count($sups) > 0) {
								foreach ($sups as $sup) {
									$curr_pernr = $sup['pernr_sup1'];
									$curr_plans = $sup['plans_sup1'];
									$job = $this->ess_model->get_job_by_plans($curr_plans);
									if (!in_array($job,$except)) {
										$str[$idx] = array();
										$str[$idx]['code']   = $s['code'];
										$str[$idx]['plant']  = $plant;
										$str[$idx]['user']   = $pernr;
										$str[$idx]['target'] = $curr_pernr;
										$valid = true;
										$idx++;
										break;
									}
								}
							} else {
								break;
							}
						} elseif ($s['source'] == 'mysql_dump_structure_new') {
							$curr_pernr = $pernr;
							$curr_plans = $plans;
							while (true) {
								$sups = $this->ess_model->get_query("SELECT pernr_sup1,plans_sup1 FROM mysql_dump_structure_new WHERE kd_form = '99' AND plans_pernr = '".$curr_plans."'");
								if (count($sups) > 0) {
									foreach ($sups as $sup) {
										$curr_pernr = $sup['pernr_sup1'];
										$curr_plans = $sup['plans_sup1'];
										$job = $this->ess_model->get_job_by_plans($curr_plans);
										if ($job == $s['code']) {
											$str[$idx] = array();
											$str[$idx]['code']   = $s['code'];
											$str[$idx]['plant']  = $plant;
											$str[$idx]['user']   = $pernr;
											$str[$idx]['target'] = $curr_pernr;
											$valid = true;
											$idx++;
										}
									}
								} else {
									break;
								}
							}
						}
					}
					// validation
					if ($valid) $this->approval_model->dump_approval( $str );
					$str = array();
					$idx = 1;
				}
			}
		}
	}
	/*
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
	*/
	
}
?>