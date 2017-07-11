<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Categories')); ?>
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
							
							<?php
							$return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/services';
							?>
							
							<nav class="navbar navbar-default">
		                        <div class="container-fluid">
			                        
			                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				                        
				                        <ul class="nav navbar-nav">
									        <li class="dropdown">
									          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										          Categories <span class="caret"></span></a>
										          
										          <ul class="dropdown-menu">
												  <li><a data-toggle="modal" data-target="#modal-popup" href="<?php echo site_url('backend/category/edit?return=' . urlencode($return)); ?>"><i class="fa fa-plus"></i> Add</a></li>
									          	</ul>
									          
									        </li>
									      </ul>
			                        </div>
		                        </div>
		                        
	                        </nav>
							
							<div class="container-fluid ">
								
								<div id="main">
									<div class="table-responsive">
										<table class="table table-striped table-hover dt-responsive no-footer dtr-inline">
											<thead>
											<tr class="text-uppercase">
												<th>Name</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>
											<tbody>
											
											<?php
											
											$indent = false;
											$parent = 0;
											
											foreach ($categories as $row) :
												
												if ($row['parent_id'] === '0' || $row['cat_id'] === $row['parent_id']) {
													$parent = $row['cat_id'];
													$indent = 0;
												}
												elseif ($row['parent_id'] === $parent) {
													$indent++;
												}
												
												
											?>
												<tr>
													<td>
														<?php if ($indent) : ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/cat_marker.gif"><?php endif;?>
														<?php echo anchor('backend/category/edit/' . $row['cat_id'] . '?return=' . urlencode($return), $row['cat_name'], 'class="text-regular" data-toggle="modal" data-target="#modal-popup"'); ?></td>
													<td class="text-center">
														<a href="<?php echo site_url('backend/category/edit/' . $row['cat_id'] . '?return=' . urlencode($return)); ?>"
														   class="btn btn-xs btn-icon btn-primary" data-toggle="modal"
														   data-target="#modal-popup"><i
																class="fa fa-pencil"></i></a>
														<a href="<?php echo site_url('backend/category/delete/' . $row['cat_id']); ?>"
														   class="btn btn-xs btn-icon btn-default btn-confirm"
														   title="Are you sure you want to delete this category?"><i
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