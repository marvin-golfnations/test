<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
	<nav class="navbar navbar-inverse" style="margin-bottom: 0; border-radius: 0;">
		<div class="navbar-inner">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
						data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo site_url('frontend'); ?>"><img src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/images/logov2.png"
																						class="m-r-sm" alt="scale"></a>
			</div>
			
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav serif">
					<li><a href="<?php echo site_url('backend/dashboard'); ?>">Home</a></li>
					<li><a href="<?php echo site_url('backend/calendar'); ?>"><i class="md md-event-available"></i> Schedules</a></li>
					<?php if (current_user_can('can_admin_reports')) : ?>
						<li><a href="<?php echo site_url('backend/reports/daily'); ?>"><i class="md md-insert-chart"></i>
							Reports</a></li><?php endif; ?>
					
					<?php if (current_user_can('can_admin_guest') || current_user_can('can_admin_providers') || current_user_can('can_admin_services') || current_user_can('can_admin_facilities') || current_user_can('can_admin_packages') || current_user_can('can_admin_activities')) : ?>
						<li class="dropdown submenu">
							
							<a href="#"  aria-haspopup="true" aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown"><i class="md md-apps"></i> Manage</a>
							<ul class="dropdown-menu">
								<?php if (current_user_can('can_admin_guest')) : ?>
									<li><a href="<?php echo site_url('backend/contacts/guest'); ?>"><i class="fa fa-group"></i> Guest</a>
									</li><?php endif; ?>
								<?php if (current_user_can('can_admin_services')) : ?>
									<li><a
										href="<?php echo site_url('backend/services'); ?>"><i class="md md-list"></i> Services</a></li>
									<li><a
										href="<?php echo site_url('backend/category'); ?>"><i class="md md-list"></i> Categories</a></li><?php endif; ?>
								<?php if (current_user_can('can_admin_providers')) : ?>
									<li>
									<a href="<?php echo site_url('backend/contacts/provider'); ?>"><i class="md md-person"></i> Providers</a></li><?php endif; ?>
								<?php if (current_user_can('can_admin_providers')) : ?>
									<li><a
										href="<?php echo site_url('backend/schedule/view'); ?>"><i class="md md-timer"></i> Provider Schedules</a>
									</li><?php endif; ?>
								<?php if (current_user_can('can_admin_packages')) : ?>
									<li><a
										href="<?php echo site_url('backend/packages'); ?>"><i class="md md-list"></i> Packages </a></li>
									<li><a
										href="<?php echo site_url('backend/packagetype'); ?>"><i class="md md-list"></i> Package Types</a></li>
									<?php endif; ?>
								<?php if (current_user_can('can_admin_facilities')) : ?>
									<li>
									<a href="<?php echo site_url('backend/facilities'); ?>"><i class="md md-location-on"></i> Facilities </a></li><?php endif; ?>
								
								<?php if (current_user_can('can_admin_activities')) : ?>
									<li><a href="<?php echo site_url('backend/events/view/'); ?>"><i class="md md-directions-walk"></i> Activities</a>
									</li>
									<li><a href="<?php echo site_url('backend/events/view/kids'); ?>"><i class="md md-directions-walk"></i> Kids
											Activities</a></li>
								<?php endif; ?>
						
							</ul>
						</li>
					<?php endif; ?>
					<?php if (is_admin()): ?>
						<li class="<?php if ($this->uri->segment(1) === 'settings'): ?>active<?php endif; ?>"><a
								href="<?php echo site_url('backend/settings'); ?>"><i class="md md-settings"></i>Settings</a>
						</li>
					<?php endif; ?>
					<li class="hidden-lg hidden-md"><a href="<?php echo site_url('login'); ?>">Logout</a></li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
<!--
					<li class="hidden-xs">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-shopping-cart"></i>
							<span id="cart-count" class="badge badge-sm up bg-danger count">0</span> </a>
					</li>
-->
					<!--
					<li class="hidden-xs">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-flag"></i> <span
								class="badge badge-sm up bg-danger count">2</span> </a>
					</li>
					-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span
								class="thumb-sm avatar pull-left"> 
								<?php echo img(array('src' => get_current_user_photo())); ?> </span> <?php echo $this->session->userdata('screen_name'); ?>
							<b class="caret"></b> </a>
						<ul class="dropdown-menu animated fadeInRight">
							<li><a href="<?php echo site_url('login'); ?>">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
		</div>
	</nav>
</header>