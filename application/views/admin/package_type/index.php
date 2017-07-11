<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Package Types')); ?>
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
							
							
							<div class="container-fluid ">
								
								<div id="main">
									<div class="page-header">
										<h1 class="serif">Package Types <a
												href="<?php echo site_url('backend/packagetype/edit?return=' . urlencode($return)); ?>"
												class="btn btn-primary" data-toggle="modal" data-target="#modal-popup">Add
												<i class="fa fa-plus"></i></a></h1>
									</div>
									<div class="table-responsive">
										<table id="" data-table
											   class="table table-striped table-hover dt-responsive dataTable no-footer dtr-inline">
											<thead>
											<tr class="text-uppercase">
												<th>Name</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($packagetypes as $row) : ?>
												<tr>
													<td>
														<?php echo anchor('backend/packagetype/edit/' . $row['package_type_id'] . '?return=' . urlencode($return), $row['package_type_name'], 'class="text-regular" data-toggle="modal" data-target="#modal-popup"'); ?></td>
													<td class="text-center">
														<a href="<?php echo site_url('backend/packagetype/edit/' . $row['package_type_id'] . '?return=' . urlencode($return)); ?>"
														   class="btn btn-xs btn-icon btn-primary" data-toggle="modal"
														   data-target="#modal-popup"><i
																class="fa fa-pencil"></i></a>
														<a href="<?php echo site_url('backend/packagetype/delete/' . $row['package_type_id']); ?>"
														   class="btn btn-xs btn-icon btn-default btn-confirm"
														   title="Are you sure you want to delete this item?"><i
																class="fa fa-trash-o"></i></a>
													</td>
												</tr>
											<?php endforeach ?>
											</tbody>
										</table>
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