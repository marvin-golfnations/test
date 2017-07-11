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
							
							<?php
							$return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/events';
							?>
							
							
							<div class="container-fluid ">
								
								<div id="main">
									<div class="page-header">
										<h1 class="serif"><?php echo $is_kids === 'y' ? 'Kids' : ''; ?> Activities <a
												href="<?php echo site_url('backend/events/edit/' . ($is_kids === 'y' ? 'kids' : 'adult') . '?return=' . urlencode($return)); ?>"
												class="btn btn-primary" data-toggle="modal" data-target="#modal-popup">Add
												<i class="fa fa-plus"></i></a></h1>
									</div>
									<div class="table-responsive">
										<table id="" data-table
											   class="table table-striped table-hover dt-responsive dataTable no-footer dtr-inline">
											<thead>
											<tr class="text-uppercase">
												<th>Name</th>
												<th>Duration</th>
												<th>Start</th>
												<th>End</th>
												<th>Location</th>
												<th>Provider</th>
											</tr>
											</thead>
											
											<tbody>
											<?php foreach ($activities as $activity) : ?>
												<tr>
													<td>
														<a href="<?php echo site_url('backend/events/edit/' . ($is_kids ? 'kids' : 'adult') . '/' . $activity['event_id'] . '?return=' . urlencode($return)); ?>"
														   data-toggle="modal"
														   data-target="#modal-popup"><?php echo $activity['item_name']; ?></a>
													</td>
													<td><?php echo $activity['duration']; ?> min(s)</td>
													<td><?php echo date('m/d/Y g:iA', strtotime($activity['start_dt'])); ?></td>
													<td><?php echo date('m/d/Y g:iA', strtotime($activity['end_dt'])); ?></td>
													<td><?php echo $activity['facility_name']; ?></td>
													<td><?php echo $activity['first_name']; ?></td>
												</tr>
											<?php endforeach; ?>
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