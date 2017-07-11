<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Services')); ?>
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
										          Services <span class="caret"></span></a>
										          
										          <ul class="dropdown-menu">
												  <li><a data-toggle="modal" data-target="#modal-popup" href="<?php echo site_url('backend/service/edit?return=' . urlencode($return)); ?>"><i class="fa fa-plus"></i> Add</a></li>
									          	</ul>
									          
									        </li>
									      </ul>
									      
									  		<?php echo form_open('backend/services/' . $this->uri->segment(3), 'method="GET" class="navbar-form navbar-right form-inline filter"'); ?>
											<div class="form-group">
												<input type="text" name="keyword" class="form-control" placeholder="Search"
													   value="<?php echo $this->input->get_post('keyword'); ?>">
											</div>
											<div class="form-group">
												
												<?php echo form_dropdown('category', $categories, $this->input->get_post('category'), 'class="selectpicker show-tick form-control"');?>
												
<!--
												<select id="basic" name="category"
														class="selectpicker show-tick form-control"
														data-live-search="false">
													<option value="">All</option>
													<?php foreach ($categories as $cat_id => $cat_name) : ?>
														<option
															<?php if ($this->input->get_post('category') === $cat_id): ?>selected<?php endif; ?>
															value="<?php echo $cat_id; ?>"><?php echo $cat_name; ?></option>
													<?php endforeach ?>
												</select>
-->
											</div>
											<button class="btn btn-default-dark  pull-right" type="submit">Update
											</button>
											<?php echo form_close(); ?>
			                        </div>
		                        </div>
		                        
	                        </nav>
							
							
							<div class="container-fluid ">
								
								<div id="main">
									<div class="table-responsive">
										<table id="" 
											   class="table table-striped table-hover dataTable dt-responsive dataTable no-footer dtr-inline">
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
														<?php echo anchor('backend/service/edit/' . $row['item_id'] . '?return=' . urlencode($return), $row['abbr'] ? $row['title'] . ' (' . $row['abbr'] . ')' : $row['title'], 'class="text-regular" data-toggle="modal" data-target="#modal-popup"'); ?></td>
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
														<a href="<?php echo site_url('backend/service/edit/' . $row['item_id'] . '?return=' . urlencode($return)); ?>"
														   class="btn btn-xs btn-icon btn-primary" data-toggle="modal"
														   data-target="#modal-popup"><i
																class="fa fa-pencil"></i></a>
														<a href="<?php echo site_url('backend/service/delete/' . $row['item_id']); ?>"
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