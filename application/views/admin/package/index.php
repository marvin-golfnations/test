<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Packages')); ?>
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
							
							
							<div class="container-fluid ">
								
									
								
								<div id="main">
									<div class="page-header">
										<h1 class="serif">Packages <a href="<?php echo site_url('backend/package/edit'); ?>"
														class="btn btn-primary" data-toggle="modal"
														data-target="#modal-popup">Add <i class="fa fa-plus"></i></a>
										</h1>
									</div>
									<div class="panel panel-shadow">
										<div class="panel-body">
											<form class="form-inline filter">
												<span class="bold text-muted">Filter</span>
												<div class="form-group">
													<input type="text" class="form-control" id="" placeholder="Service">
												</div>
												<button type="submit" class="btn btn-default-dark  pull-right">Search
												</button>
											</form>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table">
											<thead>
											<tr class="text-uppercase">
												<th>Package</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>
											
											<tbody>
											<?php foreach ($packages as $row) : ?>
												<tr>
													<td>
														<?php echo anchor('backend/package/edit/' . $row['package_id'], $row['package_name'], 'class="text-regular" data-toggle="modal" data-target="#modal-popup"'); ?></td>
													<td class="text-center">
														<a href="<?php echo site_url('backend/package/edit/' . $row['package_id']); ?>"
														   class="btn btn-xs btn-icon btn-primary" data-toggle="modal"
														   data-target="#modal-popup"><i
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