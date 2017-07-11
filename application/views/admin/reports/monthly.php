<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Monthly Sales Report')); ?>
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
										          Monthly Sales Report <span class="caret"></span></a>
										          
										          <ul class="dropdown-menu">
												  <li><a href="<?php echo site_url('backend/reports/pdf'); ?>"><i class="fa fa-print"></i> Print</a></li>
												  <li class="separator"></li>
												  <li><a href="<?php echo site_url('backend/reports/daily'); ?>"><i class="fa fa-grid"></i> Daily</a></li>
									          	</ul>
									          
									        </li>
									      </ul>
									      
									  		<?php echo form_open('backend/reports/monthly', 'method="GET" class="navbar-form navbar-right form-inline filter"'); ?>
											<div class="form-group">
												<?echo form_dropdown('year', $years, date('Y'), 'class="form-control"');?>
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
		<table id=""data-table class="table table-striped table-hover dt-responsive dataTable no-footer dtr-inline">
			<thead>
			<tr class="text-uppercase">
				<th>Treatment</th>
				<?php foreach ($months as $m => $mon) : ?>
				<th class="text-center"><?php echo $mon;?></th>
				<?php endforeach; ?>
			</tr>
			</thead>

			<tbody>
			<?php foreach ($data as $row) : ?>
			<?php if ($row['item_id'] !== NULL) : ?>
			<?php 
				$amount = (float)$row['price'];
			?>
			<tr>
				<td><?php echo $row['item_name'] . ' ('.$row['duration'].' mins)'; ?></td>
				<?php foreach ($months as $m => $mon) : ?>
				<td class="text-center">&#8369; 0</td>
				<?php endforeach; ?>
			</tr>
			<?php endif; ?>
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