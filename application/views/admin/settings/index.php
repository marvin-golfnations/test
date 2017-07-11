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
									          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										          Settings</a>
									          
									        </li>
									      </ul>
									      
			                        </div>
		                        </div>
		                        
	                        </nav>
							
							
							<div class="container-fluid ">
								
								<div id="notification" data-position="top-right" class="display-none">
								
								</div>
								
								<div id="main">
									<div class="row">
										<div class="col-sm-6 col-md-4">
											<div class="panel panel-default panel-shadow">
												<div class="panel-heading">
													<h4 class="panel-title">General Settings</h4>
												</div>
												<div class="panel-body">
													<ul>
														<li><a href="<?php echo site_url('backend/settings/configuration'); ?>">Configuration</a>
														</li>
														<li><a href="<?php echo site_url('backend/users'); ?>">System Users</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										
										<div class="col-sm-6 col-md-4">
											<div class="panel panel-default panel-shadow">
												<div class="panel-heading">
													<h4 class="panel-title">Members</h4>
												</div>
												<div class="panel-body">
													<ul>
														<li><a href="<?php echo site_url('backend/groups'); ?>">Member
																Groups</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-md-4">
											<div class="panel panel-default panel-shadow">
												<div class="panel-heading">
													<h4 class="panel-title">Forms</h4>
												</div>
												<div class="panel-body">
													<ul>
														<li><a href="<?php echo site_url('backend/forms'); ?>">Forms</a></li>
													
													</ul>
												</div>
											</div>
										</div>
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