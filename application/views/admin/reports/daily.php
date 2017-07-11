<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Daily Sales Report')); ?>
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
										          Daily Sales Report <span class="caret"></span></a>
										          
										          <ul class="dropdown-menu">
												  <li><a href="<?php echo site_url('backend/reports/pdf'); ?>"><i class="fa fa-print"></i> Print</a></li>
												  <li class="separator"></li>
												  <li><a href="<?php echo site_url('backend/reports/monthly'); ?>"><i class="fa fa-grid"></i> Monthly</a></li>
									          	</ul>
									          
									        </li>
									      </ul>
									      
									  		<?php echo form_open('backend/reports/daily', 'method="GET" class="navbar-form navbar-right form-inline filter"'); ?>
											<div class="form-group">
												<input type="text" placeholder="Date" id=""
													   class="date-range form-control">
											</div>
											<div class="form-group">
												<?php echo form_multiselect('locations[]', $locations, $selected_locations, 'class="multi-select form-control"'); ?>
											</div>
											<input type="hidden" name="start" id="start"
												   value="<?php echo $start; ?>"/>
											<input type="hidden" name="end" id="end" value="<?php echo $end; ?>"/>
											<button class="btn btn-default-dark  pull-right" type="submit">Update
											</button>
											<?php echo form_close(); ?>
			                        </div>
		                        </div>
		                        
	                        </nav>
							
							
							<div class="container-fluid ">
								
								<div id="main">
									<div class="table-responsive">
										<table id="" data-table
											   class="table table-striped table-hover dt-responsive dataTable no-footer dtr-inline">
											<thead>
											<tr class="text-uppercase">
												<th>Guest</th>
												<th>Treatment</th>
												<th class="text-center">Date</th>
												<th>Included</th>
												<th>FOC</th>
												<th>Upsell</th>
											</tr>
											</thead>
											
											<tbody>
											<?php foreach ($data as $row) : ?>
												<?php if ($row['item_id'] !== NULL) : ?>
													<?php
													$amount = (float)$row['price'];
													?>
													<tr>
														<td><?php echo $row['guest_name']; ?></td>
														<td><?php echo $row['item_name'] . ' (' . $row['duration'] . ' mins)'; ?></td>
														<td class="text-center"><?php echo date('d-M', strtotime($row['start'])); ?></td>
														<td><?php if ($row['included'] === '1' && $amount > 0) : ?>&#8369; <?php echo $amount; ?><?php endif; ?></td>
														<td><?php if ($row['foc'] === '1' && $amount > 0) : ?>&#8369; <?php echo $amount; ?><?php endif; ?></td>
														<td><?php if ($row['upsell'] === '1' && $amount > 0) : ?>&#8369; <?php echo $amount; ?><?php endif; ?></td>
													</tr>
												<?php endif; ?>
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