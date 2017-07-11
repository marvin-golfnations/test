<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Rooms / Facilities / Amenities')); ?>
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
										<h1 class="serif">Rooms / Facilities / Amenities <a
												href="<?php echo site_url('backend/facility/edit'); ?>" class="btn btn-primary"
												data-toggle="modal" data-target="#modal-popup">Add <i
													class="fa fa-plus"></i></a></h1>
									</div>
									<div class="table-responsive">
										<table class="table">
											<thead>
											<tr class="text-uppercase">
												<th>Facility</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>
											
											<tbody>
											<?php foreach ($facilities as $row) : ?>
												<tr>
													<td>
													<span class="round"
														  style="background-color: <?php echo $row['bg_color']; ?>">
														<?php echo anchor('backend/facility/edit/' . $row['facility_id'], $row['abbr'] ? $row['facility_name'] . ' (' . $row['abbr'] . ')' : $row['facility_name'], 'class="text-regular" data-toggle="modal" data-target="#modal-popup"'); ?>
													</span>
													</td>
													<td class="text-center">
														<a href="<?php echo site_url('backend/facility/edit/' . $row['facility_id']); ?>"
														   class="btn btn-xs btn-icon btn-primary" data-toggle="modal"
														   data-target="#modal-popup"><i class="fa fa-pencil"></i></a>
														<a href="<?php echo site_url('backend/facility/delete/' . $row['facility_id']); ?>"
														   class="btn btn-xs btn-icon btn-default btn-confirm"
														   title="Are you sure you want to delete this facility?"><i
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