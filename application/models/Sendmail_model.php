<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Request_model');
	}

	public function sendmail($request_no)
	{
		$to = 'ramli.ivan@gmail.com'; // nnt diganti ama email tujuan
		$title = 'Manpower Approval Request';
		

		$last2Approval = $this->db->query("
				select *
				from t_request_approval
				where request_no = '".$request_no."'
				order by 2 desc
				limit 2
			")->result_array();
		$genReq = $this->Request_model->getGeneralRequest($request_no);
		$approvalTarget = $this->Request_model->getLastApprovalTarget($request_no, $genReq['created_by'], $last2Approval[0]['approval_code']);

		$approver_prev = $this->ess_model->get_name($last2Approval[1]['approved_by']);
		$requestor = $this->ess_model->get_name($genReq['created_by']);
		/*
		$ccEmail = "ramli.ivan@gmail.com";
		$ccName = $requestor;
		*/
		$ccEmail = "michael.djojo@dynapackasia.com"; // nnt ganti ama email si pembuatnya
		$ccName = "Michael";
		//var_dump($last2Approval[0], $approvalTarget);
		if($last2Approval[0]['status'] == ""){

			//var_dump($this->ess_model->get_job_class($genReq['job_class']));
			//die();
			// select

			foreach ($approvalTarget as $value) {
				
				$approver_now = $this->ess_model->get_name($value);
				$body = '
				<table>
				<tr><td style="font-size:10.0pt;font-family:&quot;Helv$etica&quot;,&quot;sans-serif&quot;;color:#222222">
					Dear <b>'.$approver_now.'</b>,
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">';
				if($last2Approval[1]['approval_code'] == "CR"){
					$body = $body.'This email is sent to inform you, that <b>'.$requestor.'</b> has created request below';
				} else {
					$body = $body.'This email is sent to inform you, that <b>'.$requestor.'</b>\'s request below already approved by <b>'.$approver_prev.'</b>.';
				}
				$body = $body.'</td></tr>
				<tr><td>&nbsp;</td></tr>
				</table>

				<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;border-collapse:collapse;border-spacing: 0">
				<tbody>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Request No.
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['request_no'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						BU/Div/Department
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['department'].' - '.$this->ess_model->get_department($genReq['plant'], $genReq['department']).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Position
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['position'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Direct Superior
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['direct_superior'].' - '.$this->ess_model->get_name($genReq['direct_superior']).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Job Class
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['job_class'].' - '.$this->ess_model->get_job_class($genReq['job_class']).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Number of Employee
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['number_of_employee'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Working Status
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$this->Request_model->getWorkingStatusName($genReq['working_status'])['description'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Expected Working Date
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.date('D, d.m.Y', strtotime($genReq['expected_working_date'])).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Reason
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$this->Request_model->getReasonName($genReq['reason'])['description'].'
					<o:p></o:p></span></p></td>
				</tr>';
				if($genReq['reason'] == "1"){
					$replacement = $this->Request_model->getReplacementRequest($request_no);
					$body = $body.'
					<tr>
						<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
							NIK
						<o:p></o:p></span></b></p></td>
						<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto">';
					foreach ($replacement as $rVal) {
						$body = $body.'<p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
								'.$rVal['nik'].' - '.$this->ess_model->get_name($rVal['nik']).'
							<o:p></o:p></span></p>';
					}
					$body = $body.'</td>
					</tr>';
				}
				if($genReq['reason'] == "1"){
					$body = $body.'
					<tr>
						<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
							Reason Notes
						<o:p></o:p></span></b></p></td>
						<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
							'.$genReq['note'].'
						<o:p></o:p></span></p></td>
					</tr>
					</tbody>
					</table>
					';
				} else {
					$body = $body.'
					<tr>
						<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
							Reason Notes
						<o:p></o:p></span></b></p></td>
						<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;border-top:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
							'.$genReq['note'].'
						<o:p></o:p></span></p></td>
					</tr>
					</tbody>
					</table>
					';
				}
				//echo $body."<br>"."<br>"."<br>";
				//nnt bkin $to di sini sesuai email targetnya
				$this->send($to,$approver_now,$title,$body, $ccEmail, $ccName);
			}
		} else if($last2Approval[0]['status'] == "0"){
			/*var_dump($last2Approval);
			die();*/
			$approver_now = $requestor;
			$body = '
			<table>
			<tr><td style="font-size:10.0pt;font-family:&quot;Helv$etica&quot;,&quot;sans-serif&quot;;color:#222222">
				Dear <b>'.$approver_now.'</b>,
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
				This email is sent to inform you, that <b>'.$requestor.'</b>\'s request below already rejected by <b>'.$this->ess_model->get_name($last2Approval[0]['approved_by']).'</b>.
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			</table>

			<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;border-collapse:collapse;border-spacing: 0">
			<tbody>
			<tr>
				<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Request No.
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$genReq['request_no'].'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					BU/Div/Department
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$genReq['department'].' - '.$this->ess_model->get_department($genReq['plant'], $genReq['department']).'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Position
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$genReq['position'].'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Direct Superior
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$genReq['direct_superior'].' - '.$this->ess_model->get_name($genReq['direct_superior']).'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Job Class
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$genReq['job_class'].' - '.$this->ess_model->get_job_class($genReq['job_class']).'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Number of Employee
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$genReq['number_of_employee'].'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Working Status
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$this->Request_model->getWorkingStatusName($genReq['working_status'])['description'].'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Expected Working Date
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.date('D, d.m.Y', strtotime($genReq['expected_working_date'])).'
				<o:p></o:p></span></p></td>
			</tr>
			<tr>
				<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
					Reason
				<o:p></o:p></span></b></p></td>
				<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					'.$this->Request_model->getReasonName($genReq['reason'])['description'].'
				<o:p></o:p></span></p></td>
			</tr>';
			if($genReq['reason'] == "1"){
				$replacement = $this->Request_model->getReplacementRequest($request_no);
				$body = $body.'
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						NIK
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto">';
				foreach ($replacement as $rVal) {
					$body = $body.'<p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
							'.$rVal['nik'].' - '.$this->ess_model->get_name($rVal['nik']).'
						<o:p></o:p></span></p>';
				}
				$body = $body.'</td>
				</tr>';
			}
			$rejectReason = $this->Request_model->getLastRejectHistory($request_no);
			if($genReq['reason'] == "1"){
				$body = $body.'
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Reason Notes
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['note'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Reject Reason
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;border-top:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$rejectReason['reason'].'
					<o:p></o:p></span></p></td>
				</tr>
				</tbody>
				</table>
				';
			} else {
				$body = $body.'
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Reason Notes
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;border-top:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['note'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Reject Reason
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$rejectReason['reason'].'
					<o:p></o:p></span></p></td>
				</tr>
				</tbody>
				</table>
				';
			}
			//echo $body."<br>"."<br>"."<br>";
			//nnt bkin $to di sini sesuai email targetnya
			$this->send($to,$approver_now,$title,$body, $ccEmail, $ccName);
		} else if($last2Approval[0]['status'] == "1"){
			foreach ($approvalTarget as $value) {			
				$approver_now = $this->ess_model->get_name($value);
				$body = '
				<table>
				<tr><td style="font-size:10.0pt;font-family:&quot;Helv$etica&quot;,&quot;sans-serif&quot;;color:#222222">
					Dear <b>'.$approver_now.'</b>,
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
					This email is sent to inform you, that <b>'.$requestor.'</b>\'s request below already closed.
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				</table>

				<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;border-collapse:collapse;border-spacing: 0">
				<tbody>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Request No.
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['request_no'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						BU/Div/Department
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['department'].' - '.$this->ess_model->get_department($genReq['plant'], $genReq['department']).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Position
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['position'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Direct Superior
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['direct_superior'].' - '.$this->ess_model->get_name($genReq['direct_superior']).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Job Class
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['job_class'].' - '.$this->ess_model->get_job_class($genReq['job_class']).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Number of Employee
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$genReq['number_of_employee'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Working Status
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$this->Request_model->getWorkingStatusName($genReq['working_status'])['description'].'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Expected Working Date
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.date('D, d.m.Y', strtotime($genReq['expected_working_date'])).'
					<o:p></o:p></span></p></td>
				</tr>
				<tr>
					<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
						Reason
					<o:p></o:p></span></b></p></td>
					<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
						'.$this->Request_model->getReasonName($genReq['reason'])['description'].'
					<o:p></o:p></span></p></td>
				</tr>';
				if($genReq['reason'] == "1"){
					$replacement = $this->Request_model->getReplacementRequest($request_no);
					$body = $body.'
					<tr>
						<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:none;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
							NIK
						<o:p></o:p></span></b></p></td>
						<td valign="top" style="border-top:solid #EEEEEE 1.0pt;border-left:none;border-bottom:none;border-right:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto">';
					foreach ($replacement as $rVal) {
						$body = $body.'<p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
								'.$rVal['nik'].' - '.$this->ess_model->get_name($rVal['nik']).'
							<o:p></o:p></span></p>';
					}
					$body = $body.'</td>
					</tr>';
				}
				if($genReq['reason'] == "1"){
					$body = $body.'
					<tr>
						<td valign="top" style="border:none;border-left:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
							Reason Notes
						<o:p></o:p></span></b></p></td>
						<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;background:#EEEEEE;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
							'.$genReq['note'].'
						<o:p></o:p></span></p></td>
					</tr>
					</tbody>
					</table>
					';
				} else {
					$body = $body.'
					<tr>
						<td width="40%" valign="top" style="width:40.0%;border-top:solid #EEEEEE 1.0pt;border-left:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;border-right:none;padding:6.0pt 6.0pt 6.0pt 6.0pt"><p class="MsoNormal"><b><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">
							Reason Notes
						<o:p></o:p></span></b></p></td>
						<td valign="top" style="border:none;border-right:solid #EEEEEE 1.0pt;border-top:solid #EEEEEE 1.0pt;border-bottom:solid #EEEEEE 1.0pt;padding:6.0pt 6.0pt 6.0pt 6.0pt;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
							'.$genReq['note'].'
						<o:p></o:p></span></p></td>
					</tr>
					</tbody>
					</table>
					';
				}
				//echo $body."<br>"."<br>"."<br>";
				//nnt bkin $to di sini sesuai email targetnya
				$this->send($to,$approver_now,$title,$body, $ccEmail, $ccName);
			}
			//die();
		} 

		
	}

	public function send($to,$name,$title,$body, $ccEmail, $ccName)
	{
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'mail.dynapackasia.com';
		$mail->setFrom("noreply@dynapackasia.com", "Notification System");
		$mail->addAddress($to,$name);
		$mail->AddCC($ccEmail, $ccName);
		$mail->isHTML(true);
		$mail->Subject = $title;
		$mail->Body    = '
		<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40"><head><meta name="Generator" content="Microsoft Word 14 (filtered medium)"><!--[if !mso]><style>v\:* {behavior:url(#default#VML);}
		o\:* {behavior:url(#default#VML);}
		w\:* {behavior:url(#default#VML);}
		.shape {behavior:url(#default#VML);}
		</style><![endif]--><style><!--
		/* Font Definitions */
		@font-face
			{font-family:Helvetica;
			panose-1:2 11 6 4 2 2 2 2 2 4;}
		@font-face
			{font-family:Helvetica;
			panose-1:2 11 6 4 2 2 2 2 2 4;}
		@font-face
			{font-family:Cambria;
			panose-1:2 4 5 3 5 4 6 3 2 4;}
		@font-face
			{font-family:Calibri;
			panose-1:2 15 5 2 2 2 4 3 2 4;}
		@font-face
			{font-family:Tahoma;
			panose-1:2 11 6 4 3 5 4 4 2 4;}
		/* Style Definitions */
		p.MsoNormal, li.MsoNormal, div.MsoNormal
			{margin:0in;
			margin-bottom:.0001pt;
			font-size:12.0pt;
			font-family:"Times New Roman","serif";}
		h3
			{mso-style-priority:9;
			mso-style-link:"Heading 3 Char";
			mso-margin-top-alt:auto;
			margin-right:0in;
			mso-margin-bottom-alt:auto;
			margin-left:0in;
			font-size:13.5pt;
			font-family:"Times New Roman","serif";
			font-weight:bold;}
		h4
			{mso-style-priority:9;
			mso-style-link:"Heading 4 Char";
			mso-margin-top-alt:auto;
			margin-right:0in;
			mso-margin-bottom-alt:auto;
			margin-left:0in;
			font-size:12.0pt;
			font-family:"Times New Roman","serif";
			font-weight:bold;}
		td.content
			{font-size:10.0pt !important;
			font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot; !important;
			color:#222222 !important;}
		a:link, span.MsoHyperlink
			{mso-style-priority:99;
			color:blue;
			text-decoration:underline;}
		a:visited, span.MsoHyperlinkFollowed
			{mso-style-priority:99;
			color:#2BA6CB;
			text-decoration:underline;}
		p
			{mso-style-priority:99;
			mso-margin-top-alt:auto;
			margin-right:0in;
			mso-margin-bottom-alt:auto;
			margin-left:0in;
			font-size:12.0pt;
			font-family:"Times New Roman","serif";}
		p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
			{mso-style-priority:99;
			mso-style-link:"Balloon Text Char";
			margin:0in;
			margin-bottom:.0001pt;
			font-size:8.0pt;
			font-family:"Tahoma","sans-serif";}
		span.Heading3Char
			{mso-style-name:"Heading 3 Char";
			mso-style-priority:9;
			mso-style-link:"Heading 3";
			font-family:"Cambria","serif";
			color:#4F81BD;
			font-weight:bold;}
		span.Heading4Char
			{mso-style-name:"Heading 4 Char";
			mso-style-priority:9;
			mso-style-link:"Heading 4";
			font-family:"Cambria","serif";
			color:#4F81BD;
			font-weight:bold;
			font-style:italic;}
		span.BalloonTextChar
			{mso-style-name:"Balloon Text Char";
			mso-style-priority:99;
			mso-style-link:"Balloon Text";
			font-family:"Tahoma","sans-serif";}
		span.EmailStyle22
			{mso-style-type:personal;
			font-family:"Calibri","sans-serif";
			color:windowtext;}
		span.EmailStyle24
			{mso-style-type:personal-reply;
			font-family:"Calibri","sans-serif";
			color:windowtext;}
		.MsoChpDefault
			{mso-style-type:export-only;
			font-size:10.0pt;}
		@page WordSection1
			{size:8.5in 11.0in;
			margin:1.0in 1.0in 1.0in 1.0in;}
		div.WordSection1
			{page:WordSection1;}
		--></style><!--[if gte mso 9]><xml>
		<o:shapedefaults v:ext="edit" spidmax="1027" />
		</xml><![endif]--><!--[if gte mso 9]><xml>
		<o:shapelayout v:ext="edit">
		<o:idmap v:ext="edit" data="1" />
		</o:shapelayout></xml><![endif]--></head><body lang="EN-US" link="blue" vlink="#2BA6CB"><div class="WordSection1"><table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="105%" style="width:105.34%;border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0in 0in 0in 0in"><div align="center"><table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;background:#1F1F1F;border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0in 0in 0in 0in"><div align="center"><table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="580" style="width:435.0pt;border-collapse:collapse"><tbody><tr><td valign="top" style="padding:7.5pt 0in 0in 0in"><table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="580" style="width:435.0pt;border-collapse:collapse"><tbody><tr><td width="50%" valign="top" style="width:50.0%;padding:0in 7.5pt 7.5pt 0in"><p class="MsoNormal" style="mso-line-height-alt:11.25pt"><!--[if gte vml 1]><v:shapetype id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
		<v:stroke joinstyle="miter" />
		<v:formulas>
		<v:f eqn="if lineDrawn pixelLineWidth 0" />
		<v:f eqn="sum @0 1 0" />
		<v:f eqn="sum 0 0 @1" />
		<v:f eqn="prod @2 1 2" />
		<v:f eqn="prod @3 21600 pixelWidth" />
		<v:f eqn="prod @3 21600 pixelHeight" />
		<v:f eqn="sum @0 0 1" />
		<v:f eqn="prod @6 1 2" />
		<v:f eqn="prod @7 21600 pixelWidth" />
		<v:f eqn="sum @8 21600 0" />
		<v:f eqn="prod @7 21600 pixelHeight" />
		<v:f eqn="sum @10 21600 0" />
		</v:formulas>
		<v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect" />
		<o:lock v:ext="edit" aspectratio="t" />
		</v:shapetype><v:shape id="_x0000_s1026" type="#_x0000_t75" alt="" style=\'position:absolute;margin-left:0;margin-top:0;width:86.25pt;height:37.5pt;z-index:251658240;mso-wrap-distance-left:0;mso-wrap-distance-top:0;mso-wrap-distance-right:0;mso-wrap-distance-bottom:0;mso-position-horizontal:left;mso-position-horizontal-relative:text;mso-position-vertical-relative:line\' o:allowoverlap="f">
		<v:imagedata src="http://intranet.dynapackasia.com/imghost/logo-mail.png" />
		<w:wrap type="square"/>
		</v:shape><![endif]--><!--[if !vml]--><img width="115" height="50" src="http://intranet.dynapackasia.com/imghost/logo-mail.png" align="left" v:shapes="_x0000_s1026"><!--[endif]--><span style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222"><o:p></o:p></span></p></td><td width="50%" style="width:50.0%;padding:0in 0in 7.5pt 0in;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;min-width: 0px"><h4 align="right" style="margin:0in;margin-bottom:.0001pt;text-align:right"><span style="font-size:8.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:white">MANPOWER REQUEST<o:p></o:p></span></h4></td><td width="0" valign="top" style="width:.3pt;padding:0in 0in 0in 0in;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;visibility:hidden"></td></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table></div><p class="MsoNormal" align="center" style="text-align:center;line-height:11.25pt"><span style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222"><o:p>&nbsp;</o:p></span></p><div align="center"><table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="580" style="width:435.0pt;border-collapse:collapse;border-spacing: 0;text-align:inherit"><tbody><tr><td valign="top" style="padding:0in 0in 0in 0in;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto">
		<p class="MsoNormal" style="line-height:11.25pt">
			<span style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">
				<o:p>'.$body.'</o:p>
			</span>
		</p>
		<p class="MsoNormal" style="line-height:11.25pt"><span style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222"><o:p>&nbsp;</o:p></span></p>
		<div class="MsoNormal" align="center" style="text-align:center;line-height:11.25pt"><span style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222"><hr size="1" width="100%" noshade="" style="color:#D9D9D9" align="center"></span></div><table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;border-collapse:collapse;border-spacing: 0"><tbody><tr><td valign="top" style="padding:7.5pt 0in 0in 0in;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="580" style="width:435.0pt;border-collapse:collapse;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><tbody><tr><td valign="top" style="padding:0in 0in 7.5pt 0in;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto"><p align="center" style="mso-margin-top-alt:0in;margin-right:0in;margin-bottom:7.5pt;margin-left:0in;text-align:center;line-height:11.25pt"><span style="font-size:10.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#222222">&copy; Dynapack Asia, 2017 <o:p></o:p></span></p></td><td width="0" valign="top" style="width:.3pt;padding:0in 0in 0in 0in;word-break:break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;visibility:hidden"></td></tr></tbody></table></td></tr></tbody></table><p class="MsoNormal"><o:p></o:p></p></td></tr></tbody></table></div><p class="MsoNormal" align="center" style="text-align:center"><o:p></o:p></p></td></tr></tbody></table><p class="MsoNormal"><o:p>&nbsp;</o:p></p></div></body></html>';
		$mail->AltBody = $mail->Subject;

		if(!$mail->send()) {
			return 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			return 200;
		}
	}
}