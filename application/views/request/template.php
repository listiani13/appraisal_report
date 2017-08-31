<style>
.table_working_status,
.table_budget,
.table_reason {
	width: 100%;
}
.table_working_status .radio,
.table_budget .radio,
.table_reason .radio {
	padding-top: 2px;
	padding-right: 20px;
}
.gap {
	height: 7px;
}
#educational_background td,
#experience td,
#other_qualification td, 
#foreign_language td {
	padding-left: 10px;
	padding-bottom: 10px;
}
</style>
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 style="margin:0;">Manpower Request</h3>
		<div class="row">&nbsp;</div>
		<div class="row container-fluid">
			<ul class="breadcrumb">
				<li>
					<span>Manpower Request</span>
				</li>
				<?php
				if ($from == 'create') echo '
					<li>
						<span>Request</span>
					</li>
					<li>
						<span>Create</span>
					</li>';
				else if ($from == 'change') echo '
					<li>
						<span>Request</span>
					</li>
					<li>
						<span>Change</span>
					</li>';
				else if ($from == 'pending') echo '
					<li>
						<span>Request</span>
					</li>
					<li>
						<span>Pending</span>
					</li>';
				else if ($from == 'history') echo '
					<li>
						<span>Request</span>
					</li>
					<li>
						<span>History</span>
					</li>';
				else if ($from == 'approvalPending') echo '
					<li>
						<span>Approval</span>
					</li>
					<li>
						<span>Pending</span>
					</li>';
				else if ($from == 'approvalHistory') echo '
					<li>
						<span>Approval</span>
					</li>
					<li>
						<span>History</span>
					</li>';
				else if ($from == 'report') echo '
					<li>
						<span>Report Request</span>
					</li>';
				?>
			</ul>
		</div>
		<div class="row milestone">
			<div class="col-md-12">
				<div class="portlet box grey-gallery">
					<div class="portlet-title">
						<div class="caption">Milestones - <?php echo $genReq['request_no'];?></div>
						<div class="tools">
							<a href="#" class="collapse" data-original-title="" title=""></a>
						</div>
					</div>
					<div class="portlet-body">
						<div class="form-wizard">
							<ul id="navMilestone" class="nav nav-pills nav-justified steps">
								<?php
									if(isset($milestone)){
										for($i = 0; $i < sizeof($milestone); $i++){
								?>
											<li <?php if (isset($approvalReq[$i])&&$milestone[$i]['code'] == $approvalReq[$i]['approval_code']&&$approvalReq[$i]['status']=="0") echo ' class="reject"';
											else if (isset($approvalReq[$i])&&$milestone[$i]['code'] == $approvalReq[$i]['approval_code']&&$approvalReq[$i]['status']!="") echo ' class="active"'; ?>>
												<a class="step tooltips" data-html="true" data-original-title="<?php
													if (isset($approvalReq[$i])&&$milestone[$i]['code'] == $approvalReq[$i]['approval_code']&&$approvalReq[$i]['status']!=""){
														if($approvalReq[$i]['status'] == "1"){
															if($i == 0){
																echo "Created by<br>".$approvalReq[$i]['name'];
															} else {
																echo "Accepted by<br>".$approvalReq[$i]['name'];
															}
														} else if($approvalReq[$i]['status'] == "0"){
															echo "Rejected by<br>".$approvalReq[$i]['name'];
															if(isset($rejectHistory)){
																echo "<br><br>" . $rejectHistory['reason'];
															}
														}
													} else {
														$flag = 1;
														$arrNama = [];
														foreach ($allApprovalUser as $value) {
															if($value['code'] == $milestone[$i]['code']){
																echo $value['name']."<br>";
																array_push($arrNama, $value['name']);
															}
														}
													}
													
												?>" data-placement="bottom">
													<span class="number"><?php echo $i+1;?></span></br>
													<span class="desc"><i class="fa fa-check"></i><?php echo $milestone[$i]['description'];?></span>
												</a>
											</li>
								<?php
										}
									}
									
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form id="main" onsubmit="return <?php 
			if($from == "approvalPending"){
				echo "validationApprove()";
			} else {
				echo "validation()";
			}
		?>" enctype= "multipart/form-data" action="<?php 
			if($from == "create"){
				echo base_url().'request/createRequest';
			} else if($from == "change") {
				echo base_url().'request/changeRequest/'.$genReq['request_no'];
			} else if($from == "approvalPending"){
				echo base_url().'request/makeApproval/'.$genReq['request_no'];
			}
		?>" method="POST" id="form1">
			<div class="row">
				<div class="col-lg-12">
					<div class="portlet box blue-madison">
						<div class="portlet-title">
							<div class="caption">
								General Information
							</div>
							<div class="tools">
								<a href="javascript: void(0);" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-horizontal" id="form-general" >
								<div class="form-body">
									<div class="row zrow">
										<div class="col-lg-6">
											<?php 
												//var_dump($genReq);
												//var_dump($request_no);
											?>
											<label class="control-label col-lg-4">Plant</label>
											<div class="col-lg-8">
												<select id="plant" name="plant" class="form-control">
													<?php
													if(isset($genReq)){
														foreach ($all_plant as $a) {
															if ($genReq['plant'] == $a) echo '<option selected>'.$a.'</option>';
															else echo '<option>'.$a.'</option>';
														}
													} else {
														foreach ($all_plant as $a) {
															if ($plant == $a) echo '<option selected>'.$a.'</option>';
															else echo '<option>'.$a.'</option>';
														}
													}
													?>
												</select>
												
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">BU/Div/Department</label>
											<div class="col-lg-8">
												<select required id="department" name="department" class="form-control">
													<?php
													if(isset($genReq)){
													?>
														<script>
															var department_selected = '<?php echo $genReq['department']; ?>';
														</script>
													<?php
														foreach ($all_department as $a) {
															if ($genReq['department'] == $a->btrtl) echo '<option class="'.$a->werks.'" value="'.$a->btrtl.'" selected>'.$a->btrtl.' - '.$a->btext.'</option>';
														}
													} else {
														foreach ($all_department as $a) {
															if ($department == $a->btrtl) echo '<option class="'.$a->werks.'" value="'.$a->btrtl.'" selected>'.$a->btrtl.' - '.$a->btext.'</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">Position</label>
											<div class="col-lg-8">
												<?php
													if(isset($genReq)){
												?>
														<input required type="text" id="position" name="position" value="<?php echo $genReq['position'] ?>" class="form-control">
												<?php
													} else {
												?>
														<input required type="text" id="position" name="position" value="<?php echo $position ?>" class="form-control">
												<?php
													}
												?>
												
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">Direct Superior</label>
											<div id="divDirectSuperior" class="col-lg-8">
												<select required id="direct_superior" name="direct_superior" class="form-control">
													<?php
													if(isset($genReq)){
														foreach ($all_employee as $a) {
															if ($genReq['direct_superior'] == $a->pernr) echo '<option value="'.$a->pernr.'" selected>'.$a->pernr.' - '.$a->name.'</option>';
															else echo '<option value="'.$a->pernr.'">'.$a->pernr.' - '.$a->name.'</option>';
														}
													} else {
														foreach ($all_employee as $a) {
															if ($direct_superior == $a->pernr) echo '<option value="'.$a->pernr.'" selected>'.$a->pernr.' - '.$a->name.'</option>';
															else echo '<option value="'.$a->pernr.'">'.$a->pernr.' - '.$a->name.'</option>';
														}
													}
													
													?>
												</select>
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">&nbsp;</label>
											<div class="col-lg-8">
												<table class="table_budget">
													<tr>
														<?php
															if(isset($genReq)){
																$in_the_budget = $genReq['in_the_budget'];
															}
														?>
														<td><label><input type="radio" name="budget" value="1" <?php if ($in_the_budget == '1') echo 'checked'; ?>> In The Budget </label></td>
														<td><label><input type="radio" name="budget" value="0" <?php if ($in_the_budget == '0') echo 'checked'; ?>> Not In The Budget </label></td>
													</tr>
												</table>
											</div>
										</div>
										<div class="col-lg-6">
											<label class="control-label col-lg-4">Job Class</label>
											<div class="col-lg-8">
												<select id="job_class" name="job_class" class="form-control">
													<?php
													if(isset($genReq)){
														$job_class = $genReq['job_class'];
													}
													foreach ($all_job_class as $a) {
														if ($job_class == $a->persk) echo '<option value="'.$a->persk.'" selected>'.$a->persk.' - '.$a->ptext.'</option>';
														else echo '<option value="'.$a->persk.'">'.$a->persk.' - '.$a->ptext.'</option>';
													}
													?>
												</select>
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">Number of Employee</label>
											<div class="col-lg-8">
												<?php
													if(isset($genReq)){
														$number_of_employee = $genReq['number_of_employee'];
													}
													
												?>
												<input required pattern="0-9" type="number" id="number_of_employee" name="number_of_employee" min="1" value="<?php echo $number_of_employee; ?>" class="form-control">
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">Working Status</label>
											<div class="col-lg-8">
												<?php
													if(isset($genReq)){
														$working_status = $genReq['working_status'];
													}
												?>
												<table class="table_working_status">
													<tr>
														<td><label><input type="radio" name="working_status" value="1" <?php if ($working_status == '1') echo 'checked'; ?>> Permanent </label></td>
														<td><label><input type="radio" name="working_status" value="3" <?php if ($working_status == '3') echo 'checked'; ?>> Subcontract </label></td>
													</tr>
													<tr>
														<td><label><input type="radio" name="working_status" value="2" <?php if ($working_status == '2') echo 'checked'; ?>> Contract </label></td>
														<td><label><input type="radio" name="working_status" value="4" <?php if ($working_status == '4') echo 'checked'; ?>> Casual Worker </label></td>
													</tr>
												</table>
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">Expected Working Date</label>
											<div class="col-lg-8">
												<?php
													if(isset($genReq)){
														$expected_working_date = date('D, d.m.Y', strtotime($genReq['expected_working_date']));
													}
												?>
												<input required readonly type="text" id="expected_working_date" name="expected_working_date" value="<?php echo $expected_working_date; ?>" class="form-control form-control-inline date-picker">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="portlet box yellow">
						<div class="portlet-title">
							<div class="caption">
								Reason For Request
							</div>
							<div class="tools">
								<a href="javascript: void(0);" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-horizontal" id="form-general" onsubmit="return false">
								<div class="form-body">
									<div class="row zrow">
										<div class="col-lg-6">
											<label class="control-label col-lg-4">Reason</label>
											<div class="col-lg-8">
											<?php
												if(isset($genReq)){
													$reason = $genReq['reason'];
													if(isset($replacementReq)){
														$nik = $replacementReq;
													}
												}
											?>
												<table class="table_reason">
													<tr><td><label><input type="radio" name="reason" value="1" <?php if ($reason == '1') echo 'checked'; ?>> Replacement </label></td></tr>
													<tr><td><label><input type="radio" name="reason" value="2" <?php if ($reason == '2') echo 'checked'; ?>> Additional Employee </label></td></tr>
													<tr><td><label><input type="radio" name="reason" value="3" <?php if ($reason == '3') echo 'checked'; ?>> New Position </label></td></tr>
												</table>
											</div>
											<div class="col-lg-12 gap replacement" <?php if ($reason != '1') echo 'style="display:none;"'; ?>>&nbsp;</div>
											<label class="control-label col-lg-4 replacement" <?php if ($reason != '1') echo 'style="display:none;"'; ?>>Employee to be Replaced</label>
											<div class="col-lg-8 replacement" <?php if ($reason != '1') echo 'style="display:none;"'; ?>>
												<table id="replacement" style="width:100%">
													<tr><td>
														<?php 
														echo '
														<select name="nik[]" class="selectReplacement form-control">';
														foreach ($all_employee as $a) {
															if (isset($nik[0]) && $nik[0]['nik'] == $a->pernr) echo '<option value="'.$a->pernr.'" selected>'.$a->pernr.' - '.$a->name.'</option>';
															else echo '<option value="'.$a->pernr.'">'.$a->pernr.' - '.$a->name.'</option>';
														}
														echo '
														</select>';
														?>
													</td><td style="width:40px">
														<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
													</td></tr>
													<?php
													$i = 1;
													foreach ($nik as $key=>$value) if ($key > 0) {
														echo '
														<tr><td>
														<select name="nik[]" class="form-control">';
														foreach ($all_employee as $a) {
															if ($nik[$i]['nik'] == $a->pernr) {
																echo '<option value="'.$a->pernr.'" selected>'.$a->pernr.' - '.$a->name.'</option>';
															}
															else echo '<option value="'.$a->pernr.'">'.$a->pernr.' - '.$a->name.'</option>';
														}
														echo '
														</select>
														</td><td style="width:40px">
															<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
														</td></tr>';
														$i++;
													}
													?>
													<!-- <tr><td style="width:40px">
														<a class="btn btn-plus green"><i class="fa fa-plus"></i></a>
													</td></tr> -->
												</table>
												<center style="margin-top: 5px;"><a id="btnNik" class="btn btn-plus green"><i class="fa fa-plus"></i>&nbsp; Add Employee to be Replaced</a></center>
												<script>
												var all_employee = '<?php echo '<select name="nik[]" required class="form-control">'; foreach ($all_employee as $a) echo '<option value="'.$a->pernr.'">'.$a->pernr.' - '.$a->name.'</option>'; echo '</select>'; ?>';
												</script>
											</div>
											
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-12">Organizational Structure</label>
											<div id="org0" class="col-lg-12">
												<div id="org1">
													<div id="strukturOrganisasi">
														
													</div>
												</div>
											</div>
											<input type="hidden" name="organisasi1" value="<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col1']; else echo " ";?>">
											<input type="hidden" name="organisasi2" value="<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col2']; else echo " ";?>">
											<input type="hidden" name="organisasi3" value="<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col3']; else echo " ";?>">
											<input type="hidden" name="organisasi4" value="<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col4']; else echo " ";?>">
											<input type="hidden" name="organisasi5" value="<?php if(isset($strukturOrganisasi)) echo $strukturOrganisasi['col5']; else echo " ";?>">
											<style type="text/css">
												#org0, #org1 {margin: 0px; padding: 0px;height: 100%; overflow: hidden; }
												#strukturOrganisasi {width: 100%;height: 100%; } 
											</style>
										</div>
										<div class="col-lg-6">
											<?php
												if(isset($genReq)){
													$request_note = $genReq['note'];
												}
											?>
											<label class="control-label col-lg-12">Request Notes</label>
											<div class="col-lg-12">
												<textarea id="request_note" name="request_note" style="height:250px;"><?php echo $request_note; ?></textarea>
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">Job Description</label>
											<div class="col-lg-8">
												<table id="job_description" style="width:100%">
													<?php
													if($from == "change" || $from == "pending" || $from == "history" || $from == "approvalHistory" || $from == "report" || $from == "approvalPending"){
														foreach ($jobDescReq as $j) {
															echo '
															<tr class="jdShow"><td>
																<a target="blank" href="'.base_url().'assets/uploads/request/job_description/'.$j['file_name'].'"><input type="text" class="form-control" value="'.explode('---', $j['file_name'])[sizeof(explode('---', $j['file_name']))-1].'" ><input hidden type="hidden" name="job_description_show[]" class="form-control" value="'.$j['file_name'].'"></a> <div class="gap"></div>';
															/*echo '
															</td><td style="width:40px">
																<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
															</td></tr>';*/
														}
													}
													if($from == "create" || true){
													?>

													<tr><td>
														<!-- <input accept=".xls, .xlsx" type="file" name="job_description[]" class="form-control"  id="job_description1"> -->
														<form action="" method="POST" id="formJobDesc">
															<input accept=".xls, .xlsx" type="file" name="job_description[]" class="form-control"  id="job_description1">
														</form>
													</td><td id="upJobDesc" style="width:40px">
														<!-- <a class="btn btn-minus red"><i class="fa fa-minus"></i></a> -->
													</td></tr>
													<?php
													}
													?>
												</table>
												<!-- <center><a id="btnJobDesc" class="btn btn-plus green"><i class="fa fa-plus"></i> Add Job Description</a></center> -->
											</div>
											<div class="col-lg-12 gap">&nbsp;</div>
											<label class="control-label col-lg-4">Supporting Document</label>
											<div class="col-lg-8">
												<table id="supporting_document" style="width:100%">
													<?php
													if($from == "change" || $from == "pending" || $from == "history" || $from == "approvalHistory" || $from == "report" || $from == "approvalPending"){
														foreach ($supportDocReq as $j) {
															echo '
															<tr><td>
																<a target="blank" href="'.base_url().'assets/uploads/request/supporting_document/'.$j['file_name'].'"><input type="text" class="form-control" value="'.explode('---', $j['file_name'])[sizeof(explode('---', $j['file_name']))-1].'" ><input hidden type="hidden" name="supporting_document_show[]" class="form-control" value="'.$j['file_name'].'"></a> <div class="gap"></div>
															</td><td style="width:40px">
																<a class="btn btn-plus green"><i class="fa fa-plus"></i></a>
															</td></tr>';
														}
													}
													if($from == "create" || true){
													?>
													<tr><td>
														<input accept=".jpg, .png, .PNG, .gif, .jpeg, .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" type="file" name="supporting_document[]" class="form-control" id="supporting_document1">
													</td><td style="width:40px">
														<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
													</td></tr>
													<?php
													}
													?>
												</table>
												<center><a id="btnSupportDoc" class="btn btn-plus green"><i class="fa fa-plus"></i> Add Supporting Document</a></center>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="requirementRow">
				<div class="col-lg-12">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								Requirement
							</div>
							<div class="tools">
								<a href="javascript: void(0);" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-horizontal" id="form-general">
								<div class="form-body">
									<div class="row zrow">
										<div class="col-lg-12">
											<div class="col-lg-12 gap">&nbsp;</div>
											<div class="col-lg-12">
												<?php
													//var_dump($eduBackReq);
												?>
												<table  style="width:100%">
													<tbody id="educational_background">
													<tr>
														<td class="center">Educational Background</td>
														<td class="center">Level</td>
														<td class="center">Major</td>
														<td class="center" style="width:40px"></td>
													</tr>
													<tr><td>
														<input required name="educational_background[]" type="text" class="form-control" value="<?php if(isset($eduBackReq[0])) echo $eduBackReq[0]['educational_background'];?>">
													</td><td>
														<input required name="level[]" type="text" class="form-control" value="<?php if(isset($eduBackReq[0])) echo $eduBackReq[0]['level'];?>">
													</td><td>
														<input required name="major[]" type="text" class="form-control" value="<?php if(isset($eduBackReq[0])) echo $eduBackReq[0]['major'];?>">
													</td><td>
														<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
													</td></tr>
													<?php
														if(isset($eduBackReq)){
															$i = 1;
															foreach ($eduBackReq as $key=>$value) if ($key > 0) {
													?>
																<tr><td>
																	<input required name="educational_background[]" type="text" class="form-control" value="<?php if(isset($eduBackReq)) echo $eduBackReq[$i]['educational_background'];?>">
																</td><td>
																	<input required name="level[]" type="text" class="form-control" value="<?php if(isset($eduBackReq)) echo $eduBackReq[$i]['level'];?>">
																</td><td>
																	<input required name="major[]" type="text" class="form-control" value="<?php if(isset($eduBackReq)) echo $eduBackReq[$i]['major'];?>">
																</td><td>
																	<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
																</td></tr>
													<?php
																$i++;
															}
														}
													?>
													</tbody>
												</table>
												<center><a id="btnEduBack" class="btn btn-plus green"><i class="fa fa-plus"></i>&nbsp; Add Educational Background</a></center>
												
											</div>
											<h3 class="form-section">&nbsp;</h3>
											<div class="col-lg-12">
												<table  style="width:100%">
													<tbody id="experience">
													<tr class="sub"><td>
													<table style="width:100%"><tr>
													<td class="left" style="width:150px">
														Experiences
													</td><td>
														<input required name="experience[]" type="text" class="form-control" value="<?php if(!empty($experienceReq)) echo $experienceReq[0]['experience'];?>">
													</td><td class="center" style="width:100px">
														Years
													</td><td style="width:100px">
														<input required id="year" name="year[]" type="number" class="form-control" min="0" value="<?php if(!empty($experienceReq)) echo $experienceReq[0]['year'];?>">
													</td><td style="width:40px">
														<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
													</td></tr>
													<tr><td colspan="4">
														<textarea name="expDesc[]" style="width:100%;height:150px;resize:none;border-color:#e5e5e5"><?php if(!empty($experienceReq)) echo $experienceReq[0]['note'];?></textarea>
													</td><td></td>
													</tr></table>
													</td></tr>
													<?php
														if(isset($experienceReq)){
															$i = 1;
															foreach ($experienceReq as $key=>$value) if ($key > 0) {
													?>
																<tr class="sub"><td>
																<table style="width:100%"><tr>
																<td class="left" style="width:150px">
																	Experiences
																</td><td>
																	<input required name="experience[]" type="text" class="form-control" value="<?php if(!empty($experienceReq)) echo $experienceReq[$i]['experience'];?>">
																</td><td class="center" style="width:100px">
																	Years
																</td><td style="width:100px">
																	<input required name="year[]" type="number" class="form-control" min="0" value="<?php if(!empty($experienceReq)) echo $experienceReq[$i]['year'];?>">
																</td><td style="width:40px">
																	<a class="btn btn-minus red"><i class="fa fa-minus"></i></a>
																</td></tr>
																<tr><td colspan="4">
																	<textarea name="expDesc[]" style="width:100%;height:150px;resize:none;border-color:#e5e5e5"><?php if(!empty($experienceReq)) echo $experienceReq[$i]['note'];?></textarea>
																</td><td></td>
																</tr></table>
																</td></tr>
																<script type="text/javascript">document.getElementById('year').addEventListener('keydown', function(e) {var key   = e.keyCode ? e.keyCode : e.which; if (!( [8, 9, 13, 27].indexOf(key) !== -1 || (key >= 48 && key <= 57 ) || (key >= 96 && key <= 105))) e.preventDefault();});</script>
													<?php
																$i++;
															}
														}
													?>
													<script type="text/javascript">document.getElementById('year').addEventListener('keydown', function(e) {var key   = e.keyCode ? e.keyCode : e.which; if (!( [8, 9, 13, 27].indexOf(key) !== -1 || (key >= 48 && key <= 57 ) || (key >= 96 && key <= 105))) e.preventDefault();});</script>
													</tbody>
												</table>
												<center><a id="btnExperience" class="btn btn-plus green"><i class="fa fa-plus"></i>&nbsp; Add Experience</a></center>
											</div>
											<h3 class="form-section">&nbsp;</h3>
											<div class="col-lg-12">
												<label class="control-label col-lg-2 other_qualification">Other Qualification</label>
												<div class="col-lg-10">
													<table  style="width:100%">
													<tbody id="other_qualification">
														<tr>
															<td><input required name="other_qualification[]" type="text" class="form-control" value="<?php if(!empty($otherQualificationReq)) echo $otherQualificationReq[0]['other_qualification'];?>"></td>
															<td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td>
														</tr>
														<?php
															if(isset($otherQualificationReq)){
																$i = 1;
																foreach ($otherQualificationReq as $key=>$value) if ($key > 0) {
														?>
																	<tr><td><input required name="other_qualification[]" type="text" class="form-control" value="<?php if(!empty($otherQualificationReq)) echo $otherQualificationReq[$i]['other_qualification'];?>"></td><td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td></tr>
														<?php
																	$i++;
																}
															}
														?>
														</tbody>
													</table>
												</div>
												
												<center><a id="btnOtherQualification" class="btn btn-plus green"><i class="fa fa-plus"></i>&nbsp; Add Other Qualification</a></center>
											</div>
											<h3 class="form-section">&nbsp;</h3>
											<div class="col-lg-12">
												<label class="control-label col-lg-2 foreign_language">Foreign Language</label>
												<div class="col-lg-10">
													<table  style="width:100%">
														<tbody id="foreign_language">
														<tr>
															<td><input required name="foreign_language[]" type="text" class="form-control" value="<?php if(isset($foreignLangReq)) echo $foreignLangReq[0]['foreign_language'];?>"></td>
															<td style="width:100px"><select name="langQuality[]" class="form-control"><option <?php if(!empty($foreignLangReq) && $foreignLangReq[0]['score']=="GOOD") echo "selected";?>>GOOD</option><option <?php if(!empty($foreignLangReq) && $foreignLangReq[0]['score']=="FAIR") echo "selected";?>>FAIR</option></select></td>
															<td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td>
														</tr>
														<?php
															if(isset($foreignLangReq)){
																$i = 1;
																foreach ($foreignLangReq as $key=>$value) if ($key > 0) {
														?>
																	<tr>
																		<td><input name="foreign_language[]" type="text" class="form-control" value="<?php if(!empty($foreignLangReq)) echo $foreignLangReq[$i]['foreign_language'];?>"></td>
																		<td style="width:100px"><select name="langQuality[]" class="form-control"><option <?php if(isset($foreignLangReq) && $foreignLangReq[0]['score']=="GOOD") echo "selected";?>>GOOD</option><option <?php if(isset($foreignLangReq) && $foreignLangReq[$i]['score']=="FAIR") echo "selected";?>>FAIR</option></select></td>
																		<td style="width:40px"><a class="btn btn-minus red"><i class="fa fa-minus"></i></a></td>
																	</tr>
														<?php
																	$i++;
																}
															}
														?>
														</tbody>
													</table>
												</div>
												<center><a id="btnForLang" class="btn btn-plus green"><i class="fa fa-plus"></i>&nbsp; Add Foreign Language</a></center>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
				if(isset($applicant)){
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">Applicant List - <?php echo $genReq['request_no'];?></div>
							<div class="tools">
								<a href="#" class="collapse" data-original-title="" title=""></a>
							</div>
						</div>
						<div class="portlet-body">
							<table id="tbApplicant" class="table table-striped" style="text-align: center;">
								<thead>
									<tr>
										<th>Applicant No.</th>
										<th>Plant</th>
										<th>Department</th>
										<th>Position</th>
										<th>Name</th>
										<th>Major</th>
										<th>Status</th>
										<th>Create On</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if(isset($applicant)){
											for($i = 0; $i < sizeof($applicant); $i++){
												echo "
													<tr>
														<td>".$applicant[$i]['applicant_no']."</td>
														<td>".$applicant[$i]['plant']."</td>
														<td>".$applicant[$i]['reason']."</td>
														<td>".$applicant[$i]['position']."</td>
														<td>".$applicant[$i]['name']."</td>
														<td>".$applicant[$i]['major']."</td>
														<td>".$applicant[$i]['status']."</td>
														<td>".$applicant[$i]['created_at']."</td>
													</tr>
												";
											}
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php 
				}
			?>
			<div class="row">
				<div class="col-lg-12" style="text-align:center;margin-bottom:25px;">
				<div id="forApproval"></div>
				<div id="forDelete"></div>
					<?php
					if ($from == "pending" || $from == "history" || $from == "approvalHistory" || $from == "report") {
						echo '<button type="button" name="btnBack" class="btn blue" id="btnBack"><i class="fa fa-arrow-left"></i> Back</button> ';
						if(isset($rejectHistory) && isset($olUser) && $olUser == $genReq['created_by']){
							echo '<a href="'.base_url().'request/change?no='.$genReq['request_no'].'" class="btn yellow"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change/edit</a>';
						}
					} else if ($from == "approvalPending") {
						//var_dump($reqStatQuery);
						if($reqStatQuery['approval_code'] == "CL"){
							if($countHired == $genReq['number_of_employee']){
								echo '<button type="submit" name="btnApprove" class="btn green" id="btnApprove"><i class="fa fa-check"></i> Approve</button> ';
							} else {
								echo '<span title="Number of applicants did not match with requirement!"><button disabled name="btnApprove" class="btn green" id="btnApprove" ><i class="fa fa-check"></i> Approve</button></span>';
								/*echo '<a class="step tooltips" data-html="true" data-original-title="hahah wkwkwkwk anjay
								hahah" data-placement="bottom"><button disabled name="btnApprove" class="btn green" id="btnApprove"><i class="fa fa-check"></i> 
													<span class="number"> Approve</span>
												</button></a>';*/
							}
						} else {
							/*echo '<span title="Recruitment has not been finalize yet!"><button disabled type="submit" name="btnApprove" class="btn green" id="btnApprove" ><i class="fa fa-check"></i> Approve</button></span>';*/

							echo '<button type="submit" name="btnApprove" class="btn green" id="btnApprove" ><i class="fa fa-check"></i> Approve</button>';
						}
					?>
						
						<button type="button" data-toggle="modal" data-target="#rejectModal" class="btn red"><i class="fa fa-times"></i> Reject</button> 
						<button type="button" name="btnCancel" class="btn blue" id="btnCancel"><i class="fa fa-arrow-left"></i> Cancel</button> 
						<!-- Modal -->
						<div class="modal fade" id="rejectModal" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Reject Reason</h4>
									</div>
									<div class="modal-body">
										<textarea style="height: 200px;" name="rejectReason" required id="rejectReason" placeholder="Reject Reason"></textarea>
									</div>
									<div class="modal-footer">
										<button type="submit" name="btnReject" class="btnRejectRequest btn red" id="btnReject"><i class="fa fa-times"></i> Reject</button> 
										<button type="button" class="btn blue" data-dismiss="modal">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					<?php
					} else {
						echo '<button type="submit" name="btnCreateSubmit" class="btn blue"><i class="fa fa-send"></i> Submit</button> ';
						$dest = "";
						if($from == "create"){
							$dest = base_url().'request/historyAllList';
						} else if($from == "change") {
							echo '<button id="btnDelete" type="submit" name="btnDelete" class="btn"><i class="fa fa-times"></i> Delete</button> ';
							$dest = base_url().'request/changealllist';
						}
						echo '<a href="'.$dest.'" class="btn red">Cancel</a>';//anchor($dest, '<button class="btn red">Cancel</Button>');
					}
					?>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	<?php
		if($from != "change" && $from != "create"){
			echo "function validation(){return true;}";
		}
	?>	
</script>

<?php 
if($from =='approvalPending'){
?>
<script type="text/javascript">
	function validationApprove(){
		//alert($('input[name="approve"]').value);
		if($('input[name="approve"]').value == "0"){
			alert('Reject Success');
		}
	}
</script>
<?php
}
if($from !='approvalPending'){?>
<script>
	document.getElementById('number_of_employee').addEventListener('keydown', function(e) {
	    var key   = e.keyCode ? e.keyCode : e.which;
	    if (!( [8, 9, 13, 27].indexOf(key) !== -1 ||
	         (key >= 48 && key <= 57 )
	       )) e.preventDefault();
	});
	document.getElementById("year").addEventListener("keydown", function(e) {
	    var key   = e.keyCode ? e.keyCode : e.which;
	    if (!( [8, 9, 13, 27].indexOf(key) !== -1 ||
	         (key >= 48 && key <= 57 )
	       )) e.preventDefault();
	});
	function validation() {
		var flag = true;
		var j = 0;
		var c = $('input[name="job_description_show[]"]').size();
        $('input[name="job_description[]"]').each(function (i, val){
			if (val.value != ''/* && val.value.contains('.')*/) {
				//alert(val.value);
				var ext = val.value.substring(val.value.lastIndexOf('.') + 1);
				var filesize = val.files[0].size; // MB
				if(filesize < 10240000 && (ext =="xls" || ext =="xlsx" <?php if($from == "change" || $from == "approvalPending") echo '|| ext == ""';?>)){
					//benar
				}else{
					if(filesize >= 10240000) {
						alert("File size job description item must smaller than 10MB");
					}
					if(ext =="xls" || ext =="xlsx" <?php if($from == "change" || $from == "approvalPending") echo '|| ext == ""';?>){

					} else {
						alert("Check file type job description item");
					}
					flag = false;
					//break;
				}
			} else if (c == 0) {
				alert("Job description file required");
				flag = false;
			}
		});

		var c = $('input[name="supporting_document_show[]"]').size();
		$('input[name="supporting_document[]"]').each(function(i, val){
			if (val.value != ''/* && val.value.contains('.')*/) {
				var ext = val.value.substring(val.value.lastIndexOf('.') + 1);
				var filesize = val.files[0].size; // MB
				if(filesize < 10240000 && (ext =="png" || ext =="PNG" || ext =="jpg" || ext =="jpeg" || ext =="pdf" || ext =="doc" || ext =="docx" || ext =="xls" || ext =="xlsx" || ext =="ppt" || ext =="pptx" || ext =="gif" || ext == "")){
					//benar
				}else{
					if(filesize >= 10240000) {
						alert("File size supporting document item "+ (i+1) + " must smaller than 10MB");
					}
					if(ext =="png" || ext =="PNG" || ext =="jpg" || ext =="jpeg" || ext =="pdf" || ext =="doc" || ext =="docx" || ext =="xls" || ext =="xlsx" || ext =="ppt" || ext =="pptx" || ext =="gif" || ext == ""){

					} else {
						alert("Check file type supporting document item "+ (i+1));
					}
					flag = false;
					//break;
				}
			}
		});
		
		if (flag) {
			<?php if ($from == 'create') echo "alert('Input New Request Success');"; else if ($from == 'change') echo "alert('Request Changed');" ?>
		}

		return flag;
	}
	/*$("[readonly]").live('focus',function(e) {
	    $("[readonly]").blur();
	    return false;
	});*/
</script>

<?php }?>