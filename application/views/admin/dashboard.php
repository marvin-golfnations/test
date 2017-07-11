<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Dashboard')); ?>
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
							<?php $this->load->view('admin/_common/search_bar', array('title' => 'Dashboard', 'qstr' => '')); ?>
							
							<div class="container-fluid ">
								<div id="main">
									
									
									<?php if (isset($dashboard_top)) : ?>
									<div class="row tile_count clearfix">
										<?php foreach ($dashboard_top as $widget) : ?>
												<?php 
												$this->load->view('admin/_dashboard/'.$widget, array('providers' => $providers, 'sales' => $sales, 'bookings' => $bookings, 'today' => $today, 'yesterday' => $yesterday));
												?>
										<?php endforeach ;?>									
									</div>
									<?php endif; ?>
									
									<?php if (isset($dashboard_middle)) : ?>

									<div class="row">
										<?php foreach ($dashboard_middle as $widget) : ?>
											<?php 
											$this->load->view('admin/_dashboard/'.$widget, array('bookings_by_package' => $bookings_by_package, 'providers' => $providers, 'sales' => $sales, 'bookings' => $bookings, 'today' => $today, 'yesterday' => $yesterday));
											?>
										<?php endforeach ;?>	
									</div>

									<?php endif ?>
									<?php if (isset($dashboard_bottom)) : ?>
									<div class="row">
										<?php foreach ($dashboard_bottom as $widget) : ?>
											<?php 
											$this->load->view('admin/_dashboard/'.$widget, array('bookings_by_package' => $bookings_by_package, 'providers' => $providers, 'sales' => $sales, 'bookings' => $bookings, 'today' => $today, 'yesterday' => $yesterday));
											?>
										<?php endforeach ;?>	
									</div>
									<?php endif?>
								</div>
							</div>
						</div>
					</section>
				</section>
			</section>
		</section>
	</section>
</section>
<script>
	TF.calendarOptions = {
		resources: false,
		dayRender: function(date, cell) {
			//do nothing
		}
	};
</script>
<?php $this->view('admin/_common/footer_js'); ?>
<script>
	
	<?php 
		$monthly_data = array();
		echo '/**';
		var_dump($sales['monthly_sales']);
		echo '**/';
		
		foreach ($sales['monthly_sales'] as $month => $sale) : 
			$monthly_data[0][] = $sale['included'];
			$monthly_data[1][] = $sale['upsell'];
			$monthly_data[2][] = $sale['foc'];
		endforeach;	
		
		$daily_labels = array();
		$num = date('Y');
		for($i=1; $i<=(int)date('t');$i++) {
			$daily_labels[] = date('m/'.$i);
		}
		
		$daily_data = array();
		foreach ($sales['daily_sales'] as $month => $sale) : 
			$daily_data[0][] = $sale['included'];
			$daily_data[1][] = $sale['upsell'];
			$daily_data[2][] = $sale['foc'];
		endforeach;	
		
	?>
	
	$(document).ready(function(){
		
		var monthly_labels = <?php echo json_encode(array_keys($sales['monthly_sales']), true);?>;
		var daily_labels = <?php echo json_encode($daily_labels);?>; 
		var monthly_data = <?php echo json_encode($monthly_data);?>;
		var daily_data = <?php echo json_encode($daily_data);?>;
		
		var options = {
	  		fullWidth: true,
	  		chartPadding: { right: 40 },
	  		axisY: {
			    offset: 100,
			    labelInterpolationFnc: function(value) {
			      return '&#x20B1;'+value;
			    },
			    scaleMinSpace: 15
			}
		};
		
		new Chartist.Line('#projected-sales', {labels: monthly_labels, series: monthly_data}, options);
		
		$('.btn-daily').on('click', function(){
			new Chartist.Line('#projected-sales', {labels: daily_labels, series: daily_data}, options);			
		});
		$('.btn-monthly').on('click', function(){
			new Chartist.Line('#projected-sales', {labels: monthly_labels, series: monthly_data}, options);			
		});
	});
</script>
</body>
</html>