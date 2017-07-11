<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Settings')); ?>
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
			                        
			                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				                        
				                        <ul class="nav navbar-nav">
									        <li class="dropdown">
										          <a href="#">
										          <?php if ($group['group_name'] !== '') : ?>
										          Edit <b><?php echo $group['group_name']; ?></b>
										          <?php else : ?>
										          New Member Group
										          <?php endif; ?>
										          </a>
									          
									        </li>
									      </ul>
									      
			                        </div>
		                        </div>
		                        
	                        </nav>
							
							<div class="container-fluid ">
								
								<div id="main">
									
									<?php echo form_open('backend/group', '', array('group_id' => $group['group_id'])); ?>
									
									<div class="panel-group" role="tablist">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingOne">
												<h4 class="panel-title">
													<a role="button" data-toggle="collapse" data-parent="#accordion"
													   href="#collapseOne" aria-expanded="true"
													   aria-controls="collapseOne">
														Member Group Name
													</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
												 aria-labelledby="headingOne">
												<div class="panel-body">
													<div class="form-group">
														<?php echo form_input('group_name', $group['group_name'], 'class="form-control"'); ?>
													</div>
												</div>
											</div>
										</div>
										
										<?php $this->load->view('admin/group/privileges/locations', array('group', $group)); ?>
										<?php $this->load->view('admin/group/privileges/member', array('group', $group)); ?>
										<?php $this->load->view('admin/group/privileges/manage', array('group', $group)); ?>
										<?php $this->load->view('admin/group/privileges/dashboard', array('group', $group)); ?>										
										<?php $this->load->view('admin/group/privileges/services', array('group', $group)); ?>
										<?php $this->load->view('admin/group/privileges/location', array('group', $group)); ?>
										<?php $this->load->view('admin/group/privileges/forms', array('group', $group)); ?>
										<div class="panel panel-default">
											<div class="panel-body">
												<button type="submit" class="btn btn-primary">Save Changes</button>
											</div>
										</div>
										
										<?php echo form_close(); ?>
									
									</div>
								
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