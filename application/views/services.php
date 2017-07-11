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
							$return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/services';
							?>
							
							
							<div class="container-fluid ">
								
								<div id="main">
									<div class="page-header">
										<h1 class="serif">Services <a
												href="<?php echo site_url('service/edit?return=' . urlencode($return)); ?>"
												class="btn btn-primary" data-toggle="modal" data-target="#modal-popup">Add
												<i class="fa fa-plus"></i></a></h1>
									</div>
									<div class="panel panel-shadow">
										<div class="panel-body">
											<?php echo form_open('services/' . $this->uri->segment(2), array('class' => 'form-inline filter', 'method' => 'GET')); ?>
											<span class="bold text-muted">Filter</span>
											<div class="form-group">
												<input type="text" name="keyword" class="form-control"
													   value="<?php echo $this->input->get_post('keyword'); ?>">
											</div>
											<div class="form-group">
												<select id="basic" name="category"
														class="selectpicker show-tick form-control"
														data-live-search="false">
													<option value="">All</option>
													<?php foreach ($categories as $cat) : ?>
														<option
															<?php if ($this->input->get_post('category') === $cat['cat_id']): ?>selected<?php endif; ?>
															value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name']; ?></option>
													<?php endforeach ?>
												</select>
											</div>
											<button type="submit" class="btn btn-default-dark  pull-right">Search
											</button>
											<?php echo form_close(); ?>
										</div>
									</div>
									<div class="table-responsive">
										<table id="" data-table
											   class="table table-striped table-hover dt-responsive dataTable no-footer dtr-inline">
											<thead>
											<tr class="text-uppercase">
												<th>Service</th>
												<th>Duration</th>
												<th>Amount</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>
											
											<tbody>
											<?php foreach ($services as $row) : ?>
												<tr>
													<td>
														<?php echo anchor('service/edit/' . $row['item_id'] . '?return=' . urlencode($return), $row['abbr'] ? $row['title'] . ' (' . $row['abbr'] . ')' : $row['title'], 'class="text-regular" data-toggle="modal" data-target="#modal-popup"'); ?></td>
													<td>
														<?php if (intval($row['duration']) > 0) : ?>
															<i class="fa fa-clock-o"></i>
															<?php
															$duration_hr = floor(intval($row['duration']) / 60);
															$str = array();
															if ($duration_hr > 0) $str[] = $duration_hr . ' hour' . (($duration_hr > 1) ? 's' : '');
															
															$duration_min = intval($row['duration']) % 60;
															
															if ($duration_min > 0) $str[] = $duration_min . ' mins';
															echo implode(' and ', $str);
															?>
														<?php endif; ?>
													</td>
													<td>&#8369; <?php echo $row['amount']; ?></td>
													<td class="text-center">
														<a href="<?php echo site_url('service/edit/' . $row['item_id'] . '?return=' . urlencode($return)); ?>"
														   class="btn btn-xs btn-icon btn-primary" data-toggle="modal"
														   data-target="#modal-popup"><i
																class="fa fa-pencil"></i></a>
														<a href="<?php echo site_url('service/delete/' . $row['item_id']); ?>"
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