<div class="sidebar left-side" id="sidebar-left">
    <div class="sidebar-user">
        <div class="media sidebar-padding">
            <div class="media-left media-middle">
                <?php echo img(array('src' => get_current_user_photo(), 'class' => 'img-circle', 'width' => 60, 'height' => 60)); ?>
            </div>
            <div class="media-body media-middle">
                <?php echo anchor('account/edit/' . $this->session->userdata('user_id'), $this->session->userdata('screen_name'), 'class="h4 margin-none"'); ?>
                <ul class="list-unstyled list-inline margin-none">
                    <li>
                        <?php echo anchor('account/edit/' . $this->session->userdata('user_id'), '<i class="md-person-outline"></i>'); ?>
                    </li>
                    <li><?php echo anchor('login', '<i class="md-exit-to-app"></i>'); ?></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="nicescroll">
        <div class="wrapper" style="margin-bottom:90px">
            <ul class="nav nav-sidebar" id="sidebar-menu">
				<?php if (current_user_can('can_view_dashboard')) : ?><li><a href="<?php echo site_url('/');?>"><i class="md md-desktop-mac"></i>Dashboard</a></li><?php endif;?>
                <li><?php echo anchor('account/edit/' . $this->session->userdata('user_id'), '<i class="md md-person-outline"></i> My Account'); ?></li>
                <?php if (current_user_can('can_admin_calendar')) : ?><li><a href="<?php echo site_url('calendar');?>"><i class="md md-event-available"></i>Calendar</a></li><?php endif;?>
                <?php if (current_user_can('can_admin_guest')) : ?><li><a href="<?php echo site_url('contacts');?>"><i class="md md-group"></i> Guest</a></li><?php endif;?>

				<?php if (current_user_can('can_admin_activities')) : ?>
					<li><a href="<?php echo site_url('events/view/');?>"><i class="md md-list"></i> Activities</a></li>
					<li><a href="<?php echo site_url('events/view/kids');?>"><i class="md md-list"></i> Kids Activities</a></li>
				<?php endif;?>
				
				<?php if (current_user_can('can_admin_reports')) : ?><li><a href="<?php echo site_url('reports/daily');?>"><i class="md md-insert-chart"></i> Reports</a></li><?php endif;?>

                <?php if (current_user_can('can_admin_providers') || current_user_can('can_admin_services') || current_user_can('can_admin_facilities') || current_user_can('can_admin_packages')) : ?>
                <li class="submenu<?php if (in_array($this->uri->segment(1), array('services', 'providers', 'packages', 'facilities'))):?> active<?php endif;?>">

					<a href="#"><i class="md md-apps"></i>Manage</a>
					<ul<?php if (in_array($this->uri->segment(1), array('events', 'services', 'providers', 'packages', 'facilities', 'schedule'))):?> class="collapse in" style="display:block" <?php endif;?>>
                        <?php if (current_user_can('can_admin_services')) : ?><li class="<?php if ($this->uri->segment(1) === 'services'): ?>active<?php endif;?>"><a href="<?php echo site_url('services');?>">Services</a></li><?php endif;?>
                        <?php if (current_user_can('can_admin_providers')) : ?><li class="<?php if ($this->uri->segment(1) === 'providers'): ?>active<?php endif;?>"><a href="<?php echo site_url('providers');?>">Providers</a></li><?php endif;?>
                        <?php if (current_user_can('can_admin_providers')) : ?><li class="<?php if ($this->uri->segment(1) === 'schedule'): ?>active<?php endif;?>"><a href="<?php echo site_url('schedule/view');?>">Provider Schedules</a></li><?php endif;?>
                        <?php if (current_user_can('can_admin_packages')) : ?><li class="<?php if ($this->uri->segment(1) === 'packages'): ?>active<?php endif;?>"><a href="<?php echo site_url('packages');?>">Packages </a></li><?php endif;?>
                        <?php if (current_user_can('can_admin_facilities')) : ?><li class="<?php if ($this->uri->segment(1) === 'facilities'): ?>active<?php endif;?>"><a href="<?php echo site_url('facilities');?>">Facilities </a></li><?php endif;?>
					</ul>
				</li>
                <?php endif;?>
                <?php if(is_admin()):?>
				<li class="<?php if ($this->uri->segment(1) === 'settings'):?>active<?php endif;?>"><a href="<?php echo site_url('settings');?>"><i class="md md-settings"></i>Settings</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<div class="sidebar right-side" id="sidebar-right">
    <!-- Wrapper Reqired by Nicescroll -->
    <div class="nicescroll">
        <div class="wrapper">
            <div class="block-primary">
                <div class="media">
                    <div class="media-left media-middle">
                        <?php echo img(array('src' => get_current_user_photo(), 'class' => 'img-circle border-white', 'width' => 60)); ?>
                    </div>
                    <div class="media-body media-middle">
                        <?php echo anchor('account/edit/' . $this->session->userdata('user_id'), $this->session->userdata('screen_name')); ?>
                        <a href="<?php echo site_url('login')?>" class="logout pull-right"><i class="md md-exit-to-app"></i></a>
                    </div>
                </div>
            </div>
            <ul class="nav nav-sidebar" id="sidebar-menu">
                <li>
                    <?php echo anchor('account/edit/' . $this->session->userdata('user_id'), '<i class="md md-person-outline"></i> Account'); ?>
                </li>
                <li>
                    <?php echo anchor('login', '<i class="md md-exit-to-app"></i> Logout'); ?>
                </li>
            </ul>
        </div>
    </div>
</div>