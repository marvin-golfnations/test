<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Contacts')); ?>
</head>
<body class="">
<section class="vbox">
	<?php $this->load->view('admin/_common/header'); ?>
	<section>
		<section class="hbox stretch">
			<section id="content">
				<section class="vbox">
					<section class="scrollable bg-white">
						<div class="content">
							
							<nav class="navbar navbar-default">
		                        <div class="container-fluid">
									<!-- Collect the nav links, forms, and other content for toggling -->
									<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
										<ul class="nav navbar-nav navbar-right">
											<li class="dropdown">
												<a href="#" id="settings" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> </a>
											
											
											</li>
										</ul>
										
										<?php echo form_open('backend/contacts/'.$this->uri->segment(3), array('class' => 'navbar-form navbar-left form-inline filter', 'method' => 'GET')); ?>    
									        <div class="form-group">
									          <?php //echo form_multiselect('statuses', $statuses, '', 'class="selectpicker"');?>
									        </div>
									    <?php echo form_close(); ?>
										
									</div><!-- /.navbar-collapse -->
		                        </div>
							</nav>
							
							<div class="windowSettings js opened" style="display: none; position: absolute">
								
								<h3>Status</h3>
								<div class="selectCont">
									<?php echo form_multiselect('statuses[]', $statuses, $this->session->userdata('calendar_view_status'), 'id="calendar-status" class="selectpicker show-tick form-control"');?>
								</div>
								
								<h3>Position</h3>
								<div class="selectCont">
									<?php echo form_multiselect('positions', $positions, $this->session->userdata('calendar_view_positions'), 'id="calendar-position" class="selectpicker show-tick form-control"');?>
								</div>
								
								<h3>Department</h3>
								<div class="selectCont">
									<?php echo form_multiselect('locations[]', $locations, $this->session->userdata('calendar_view_locations'), 'id="calendar-location" class="selectpicker show-tick form-control"');?>
								</div>
								
								<hr class="divider">
								
								<ul class="list-unstyled">
									<li><input type="checkbox" '+(TF.show_no_schedule ? 'checked' : '')+' name="show_no_schedule" value="y"/><span> Show OFF</span></li>
									<li><input type="checkbox" '+(TF.show_my_appointments ? 'checked' : '')+' name="show_my_appointments" value="y"/><span> Show My Schedule Only</span></li>
								</ul>
								
								<hr class="divider">
								
								<div class="text-center">
								<button type="button" id="update-calendar-settings" class="btn btn-success">Save Changes</button>
								<button type="button" id="close-calendar-settings" class="btn btn-default">Close</button>
								</div>
							
							
							</div>


<div class="container-fluid ">

    <div id="main" class="page-content">


                <div class="media">
                    <div class="media-body">
                        <!-- Calendar -->
                        <div id='calendar'></div>
                    </div>
                </div>


        </div>
					</section>
				</section>
			</section>
		</section>
	</section>
</section>
<?php $this->view('admin/_common/footer_js'); ?>
</body>
</html>