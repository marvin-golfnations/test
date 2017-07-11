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
										          Member Groups <span class="caret"></span></a>
										          
										          <ul class="dropdown-menu">
												  <li><a href="<?php echo site_url('backend/group/edit'); ?>"><i class="fa fa-plus"></i> Create a New Member Group</a></li>
									          	</ul>
									          
									        </li>
									      </ul>
									      
			                        </div>
		                        </div>
		                        
	                        </nav>
	                        
							<div class="container-fluid ">
								
								<div id="main">
									<div class="table-responsive">
										<table class="table">
											<thead>
											<tr class="text-uppercase">
												<th>Group ID</th>
												<th>Group Title</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>
											
											<tbody>
											<?php foreach ($groups as $row) : ?>
												<tr>
													<td>
														<?php echo $row['group_id']; ?>
													</td>
													<td>
														<?php echo anchor('backend/group/edit/' . $row['group_id'], $row['group_name'], 'class="text-regular"'); ?>
													</td>
													<td class="text-center">
														<a href="<?php echo site_url('backend/group/edit/' . $row['group_id']); ?>"
														   class="btn btn-xs btn-icon btn-primary"><i
																class="fa fa-pencil"></i></a>
														<a href="#" class="btn btn-xs btn-icon btn-default"><i
																class="fa fa-trash-o"></i></a>
													</td>
												</tr>
											<?php endforeach ?>
											</tbody>
										</table>
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