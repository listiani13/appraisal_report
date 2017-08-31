<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<ul class="page-sidebar-menu page-sidebar-menu-closed" data-auto-scroll="true" data-slide-speed="200">
			<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
			<li class="sidebar-toggler-wrapper">
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				<div class="sidebar-toggler" style="margin-bottom:15px">
				</div>
				<!-- END SIDEBAR TOGGLER BUTTON -->
			</li>
			<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
			<li class="menu_rec">
				<a href="javascript: void(0);">
					<i class="fa fa-group"></i>
					<span class="title">Appraisal Report</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="menu_main_report">
						<a href="<?php echo base_url();?>recruitment/main_report">
							<i class="fa fa-check-square"></i>
							<span class="title">Main Report</span>
						</a>
					</li>
					<li class="menu_succession_planning">
						<a href="<?php echo base_url();?>recruitment/succession_planning">
							<i class="fa fa-check-square"></i>
							<span class="title">Succession Planning</span>
						</a>
					</li>
					<li class="menu_development_planning">
						<a href="<?php echo base_url();?>recruitment/next">
							<i class="fa fa-check-square"></i>
							<span class="title">Development Planning</span>
						</a>
					</li>
					<li class="menu_kpi_status">
						<a href="<?php echo base_url();?>recruitment/next">
							<i class="fa fa-check-square"></i>
							<span class="title">KPI Status</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>
<!-- END SIDEBAR -->
