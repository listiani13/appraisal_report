<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content" id="zdiv_pagecontent">
			<!-- title diganti buat dinamis -->
			<h3 style="margin:0;"><?php echo $title;?></h3>
			<div class="row">&nbsp;</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="portlet box green-seagreen">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-file"></i>&nbsp;Guidance
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-lg-10 col-lg-offset-1">
										<table class="table table-bordered table-striped" id="guinea-table">
										<thead>
											<tr>
												<th>Filename</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($array as $e){ ?>
											<tr>
												<td><a href="<?php echo base_url().$controller;?>/guinea_download/<?php echo rawurlencode($e);?>"><?php echo $e; ?></a></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- END CONTENT -->

									