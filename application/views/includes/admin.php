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
								<i class="fa fa-upload"></i>&nbsp;Upload
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<!--
								!IMPORTANT!
								if you change the ID (dropzone1) below, make sure change the JS on guidance_view
							-->
							<div class="form-body">
								<form action="<?php echo base_url().$controller;?>/guinea_upload" enctype="multipart/form-data" class="dropzone dz-clickable" id="dropzone1" name="userfile">
									<button type="button" class="btn btn-circle green-seagreen" id="upload1" value="Add" style="cursor: pointer; position: absolute; bottom: 0; right: 45.5%;"><i class="fa fa-upload"></i> Upload</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="portlet box green-seagreen">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa icon-trash"></i>&nbsp;Delete Files
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
												<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($array as $e){ ?>
												<tr>
													<td><a href="<?php echo base_url().$controller;?>/guinea_download/<?php echo rawurlencode($e);?>"><?php echo $e; ?></a></td>
													<td><a href="<?php echo base_url().$controller;?>/guinea_delete/<?php echo rawurlencode($e);?>">&nbsp<i class="icon-trash"></i>delete</a></td>
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
	</div>
	<!-- END CONTENT -->