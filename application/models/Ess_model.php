<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ess_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$CI = &get_instance();
		$this->ess2 = $CI->load->database('ess2',TRUE);
	}

	function get_query($sql)
	{
		$result = $this->ess2->query($sql);
		if($result->num_rows() > 0) {
			return $result->result_array();
		}
		return array();
	}

	function get_pernr($email)
	{
		$sql = "SELECT pernr FROM mysql_pa0105 WHERE usrid_long = UPPER('$email') AND (CURDATE() BETWEEN begda AND endda) AND subty IN (0010) LIMIT 1";
		$query = $this->ess2->query($sql);
		if($query->num_rows() > 0) {
			$row = $query->row();
			return $row->pernr;
		}
		return false;
	}

	function get_name($pernr)
	{
		$sql = "SELECT ename FROM mysql_pa0002 WHERE pernr = '$pernr' AND (CURDATE() BETWEEN begda AND endda) LIMIT 1";
		$query = $this->ess2->query($sql);
		if($query->num_rows() > 0) {
			$row = $query->row();
			return $row->ename;
		}
		return false;
	}

	function get_plant($pernr)
	{
		$sql="SELECT werks FROM mysql_pa0001 WHERE pernr = '$pernr' AND (CURDATE() BETWEEN begda AND endda) LIMIT 1";
		$query = $this->ess2->query($sql);
		if($query->num_rows() > 0) {
			$row = $query->row();
			return $row->werks;
		}
	}

	function get_department($werks,$btrtl)
	{
		$result = $this->ess2->query("SELECT btext
									FROM mysql_t001p
									WHERE werks = '".$werks."' AND
										  btrtl = '".$btrtl."'");
		$btext = "";
		foreach($result->result_array() as $res)
		{
			$btext = $res['btext'];
		}
        return $btext;					  
	}

	function get_job_class($persk)
	{
		$result = $this->ess2->query("SELECT ptext
									FROM mysql_t503t
									WHERE persk = '".$persk."' AND sprsl = 'E'");
		$ptext = "";
		foreach($result->result_array() as $res)
		{
			$ptext = $res['ptext'];
		}
        return $ptext;					  
	}

	function get_me($pernr)
    {
    	$sql = "SELECT satu.orgeh,
    				   satu.persg,
    				   satu.abkrs,
    				   satu.ansvh,
    				   satu.plans,
    				   satu.pernr,
    				   satu.btrtl,
    				   satu.persk,
    				   satu.bukrs,
    				   satu.persk,
    				   dua.gesch,
    				   kostl,
    				   (SELECT ktext 
    				   		FROM mysql_cskt AS cs 
    				   		JOIN mysql_tka02 AS tk ON cs.kokrs = tk.kokrs 
    				   		WHERE tk.bukrs = satu.bukrs AND 
    				   			  cs.kostl = satu.kostl AND 
    				   			  CURDATE() < datbi LIMIT 1) AS ktext, 
    				   (SELECT cs.kokrs 
    				   		FROM mysql_cskt AS cs 
    				   		JOIN mysql_tka02 AS tk ON cs.kokrs = tk.kokrs 
    				   		WHERE tk.bukrs = satu.bukrs AND 
    				   			  cs.kostl = satu.kostl AND 
    				   			  CURDATE() < datbi LIMIT 1) AS kokrs, 
    				   (SELECT LOWER(usrid_long) 
    				   		FROM mysql_pa0105 AS snl 
    				   		WHERE snl.pernr = dua.pernr AND 
    				   			  (CURDATE() BETWEEN snl.begda AND snl.endda) AND 
    				   			  usrty IN (0010, 0030) 
    				   		LIMIT 1) AS email,
    				   	ename,
    				   	vorna,
    				   	btext,
    				   	satu.werks
    			FROM mysql_pa0002 AS dua 
    			JOIN mysql_pa0001 AS satu ON dua.pernr = satu.pernr 
    			JOIN mysql_t001p AS t ON satu.btrtl = t.btrtl  AND satu.werks = t.werks 
    			WHERE dua.pernr = ? AND 
    				 (CURDATE() BETWEEN satu.begda AND satu.endda) AND
    				 (CURDATE() BETWEEN dua.begda AND dua.endda)
    			LIMIT 1";
    	$query = $this->ess2->query($sql, array($pernr));
    	return $query->row();
    }

    function get_superior_detail($pernr,$eligible_job)
	{
		$sql = "SELECT pernr_sup1,pernr_sup2,pernr_sup3 
				FROM mysql_dump_structure_new
				WHERE kd_form = '99' AND pernr = ?";
        $result = $this->ess2->query($sql, array($pernr));

		$sups = "0";
		foreach($result->result_array() as $res)
		{
			$sups = $res['pernr_sup1'];
			
			$job = $this->get_job_by_pernr($sups);
			
			if(!in_array($job,$eligible_job))
			{
				$sups = $res['pernr_sup2'];
			
				$job = $this->get_job_by_pernr($sups);
				
				if(!in_array($job,$eligible_job))
				{
					$sups = $res['pernr_sup3'];
			
					$job = $this->get_job_by_pernr($sups);
					
					if(!in_array($job,$eligible_job))
					{
						$sups = "0";
					}
				}
			}
		}
		
		return $sups;
	}

    function get_superior($pernr)
	{
		$sql = "SELECT pernr_sup1,pernr_sup2,pernr_sup3 
				FROM mysql_dump_structure_new
				WHERE kd_form = '31' AND pernr = ?";
        $result = $this->ess2->query($sql, array($pernr));

		$eligible_job = array('DPH','DVH','AD','MD','GMD','PD');

		$sups = "0";
		foreach($result->result_array() as $res)
		{
			$sups = $res['pernr_sup1'];
			
			$job = $this->get_job_by_pernr($sups);
			
			if(!in_array($job,$eligible_job))
			{
				$sups = $res['pernr_sup2'];
			
				$job = $this->get_job_by_pernr($sups);
				
				if(!in_array($job,$eligible_job))
				{
					$sups = $res['pernr_sup3'];
			
					$job = $this->get_job_by_pernr($sups);
					
					if(!in_array($job,$eligible_job))
					{
						$sups = "0";
					}
				}
			}
		}
		
		return $sups;
	}

	function get_department_by_pernr($pernr){
		$resultHR = $this->db->query('
				SELECT *
				FROM m_approval_user
				WHERE target = "'.$pernr.'"
				AND ( code = "HRP" OR code = "RG" )
			')->result_array();

		if (sizeof($resultHR) > 0) {
			return $this->ess2->query("
					SELECT a.btrtl, a.werks, a.endda
					FROM  `mysql_pa0001` AS a
					GROUP BY a.btrtl, a.werks
					ORDER BY werks
				")->result_array();
		} else {
			return $this->ess2->query("
					SELECT a.btrtl, a.werks, a.endda
					FROM  `mysql_pa0001` AS a
					WHERE  `pernr` LIKE  '".$pernr."'
					AND endda = ( 
						SELECT MAX( b.endda ) 
						FROM mysql_pa0001 AS b
						WHERE a.btrtl = b.btrtl
						AND  `pernr` LIKE  '".$pernr."' 
					)
					GROUP BY a.btrtl, a.werks
					ORDER BY werks
				")->result_array();
		}
	}

	function get_job_by_plans($plans)
	{
		$sql = "SELECT a.short as ashort
			    FROM mysql_hrp1000 a, mysql_hrp1001 b
			    WHERE a.otype = b.otype AND
					a.objid = b.objid AND
					a.plvar = '01' AND 
					a.langu = 'E' AND
					curdate() BETWEEN a.begda AND a.endda AND
					curdate() BETWEEN b.begda AND b.endda AND
					b.otype = 'C' AND
					b.sclas = 'S' AND 
					b.sobid = '".$plans."'
			    LIMIT 0,1";
		$result = $this->ess2->query($sql);

		$ashort = "";
		foreach($result->result_array() as $res)
		{
			$ashort = $res['ashort'];
		}
		return $ashort;  
	}

	function get_job_by_pernr($pernr)
	{
		$result = $this->ess2->query("SELECT a.short as ashort
									FROM mysql_pa0001 p1, mysql_hrp1000 a
									WHERE p1.pernr = '".$pernr."' AND
										  curdate() BETWEEN p1.begda AND p1.endda AND
										  p1.stell = a.objid AND
										  a.plvar = '01' AND
										  a.langu = 'E' AND
										  a.otype = 'C' AND
										  curdate() BETWEEN a.begda AND a.endda");
		
		$ashort = "";
		foreach($result->result_array() as $res)
		{
			$ashort = $res['ashort'];
		}
        return $ashort;					  
	}

    function get_all_employee()
	{
        $query = "
			SELECT DISTINCT mysql_pa0002.pernr, mysql_pa0002.ename as name, mysql_pa0001.persk, mysql_pa0001.werks, LOWER( mysql_pa0105.usrid_long ) as email
				FROM mysql_pa0002
				INNER JOIN mysql_pa0001
					ON mysql_pa0001.pernr = mysql_pa0002.pernr
					AND mysql_pa0001.endda = '9999-12-31'
					AND mysql_pa0001.plans != '99999999'
				LEFT OUTER JOIN mysql_pa0105
					ON mysql_pa0105.pernr = mysql_pa0002.pernr
					AND mysql_pa0105.endda = '9999-12-31'
					AND mysql_pa0105.seqnr = '000'
					AND mysql_pa0105.usrty = '0010'
				WHERE mysql_pa0002.endda = '9999-12-31'
				ORDER BY ABS(mysql_pa0002.pernr)
		";
        $sql = $this->ess2->query($query);
		return $sql->result();
	}

    function get_all_employee_complete()
	{
        $query = "
			SELECT DISTINCT mysql_pa0002.pernr, mysql_pa0002.ename as name, mysql_pa0001.persk, mysql_pa0001.werks, LOWER( mysql_pa0105.usrid_long ) as email
				FROM mysql_pa0002
				INNER JOIN mysql_pa0001
					ON mysql_pa0001.pernr = mysql_pa0002.pernr
					AND mysql_pa0001.endda = '9999-12-31'
					AND mysql_pa0001.plans != '99999999'
				LEFT OUTER JOIN mysql_pa0105
					ON mysql_pa0105.pernr = mysql_pa0002.pernr
				ORDER BY ABS(mysql_pa0002.pernr)
		";
        $sql = $this->ess2->query($query);
		return $sql->result();
	}

	function get_all_plant()
	{
		$result = $this->db->query("SELECT DISTINCT plant
										FROM m_approval_user
										WHERE user = '".$_SESSION["pernr"]."'
										ORDER BY plant");
		$plant = array();
		foreach($result->result_array() as $res)
		{
			array_push($plant,$res['plant']);
		}
		return $plant;
	}

	function get_all_department()
	{
		$this->ess2->distinct();
		$this->ess2->select('*');
		$query = $this->ess2->get('mysql_t001p');
		return $query->result();
	}

	function get_all_job_class()
	{
		$this->ess2->distinct();
		$this->ess2->select('*');
		$query = $this->ess2->get('mysql_t503t');
		return $query->result();
	}

	// function get_btrtl($pernr)
	// {
	// 	$sql="SELECT btrtl FROM mysql_pa0001 WHERE pernr = '$pernr' AND (CURDATE() BETWEEN begda AND endda) LIMIT 1";
	// 	$query = $this->ess2->query($sql);
	// 	if($query->num_rows() > 0) {
	// 		$row = $query->row();
	// 		return $row->werks;
	// 	}
	// }

}