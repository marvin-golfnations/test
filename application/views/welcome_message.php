<!doctype html>
<html>
<head>
	<?php $this->view('partials/head',array('title'=>'Welcome')); ?>

</head>
<body class="sidebar-push">
  
  <?php $this->view('partials/topbar'); ?>
	
	<?php $this->view('partials/sidebar'); ?>

  <div class="container-fluid ">
      
<div id="notification" data-position="top-right" class="display-none">
	You have a new message!
</div>

<div id="main">
	<div class="page-header">
		<h2 class="serif">Overview</h2>
	</div>
	
	<div class="row">

		<?php foreach ($locations as $location) : ?>
			<?php
			$total = 0;
			$package = 0;
			$foc = 0;
			$upsell = 0;
			
			
			
			$location_id = (int)$location['location_id'];
						
			if (isset($stats['sales_today'][$location_id])) {
// 				$total = $stats['sales'][$location_id]['daily_sales'][$current_date]['total'];
				$package = $stats['sales_today'][$location_id][0];
				$foc = $stats['sales_today'][$location_id][1];
				$upsell = $stats['sales_today'][$location_id][2];
			}
			?>
			<div class="col-md-3">
				<div class="panel panel-default panel-shadow">
					<div class="widget">
						<div class="widget-content bg-white" style="padding: 20px;">
							<div class="row">
								<div class="col-xs-6">
									<h3 style="margin-top: 5px; font-weight: bold">
										&#8369; <?php echo $package;?>
									</h3>
								</div>
								<div class="col-xs-6">
									<p class="font-size-38"><span class="fa <?php echo $icons[$location_id];?> pull-right"></span></p>
								</div>
							</div>
							<div class="pull-right btns">
								<button class="btn btn-success btn-xs btn-package-sales" data-out="package" data-date="<?php echo $current_date;?>" data-location="<?php echo $location_id;?>" data-amount="<?php echo $package;?>">Package</button>
								<button class="btn btn-default btn-xs btn-package-foc" data-out="foc" data-date="<?php echo $current_date;?>" data-location="<?php echo $location_id;?>" data-amount="<?php echo $foc;?>">FOC</button>
								<button class="btn btn-default btn-xs btn-package-upsell" data-out="upsell" data-date="<?php echo $current_date;?>" data-location="<?php echo $location_id;?>" data-amount="<?php echo $upsell;?>">Up Sales</button>
							</div>
							<p>Total Daily Sales <?php echo $location['location'];?></p>
							<a style="width:100%;" class="report-url padding-8 hvr-bounce-to-right bg-<?php echo $colors[$location_id];?>" href="<?php echo site_url('reports/daily/'.$location_id.'/'.$current_date.'/package');?>">Read full report <i class="fa fa-arrow-circle-right"></i></a>
						</div><!--/widget-content-->
					</div>
				
				</div>
			</div>
		<?php endforeach; ?>
		<!--
		<div class="col-md-3">
			<div class="panel panel-default panel-shadow">
				<div class="widget">
					<div class="widget-content bg-white" style="padding: 20px;">
						<div class="row">
							<div class="col-xs-6">
								<h3 style="margin-top: 5px; font-weight: bold">&#8369; <?php echo $daily_sales;?></h3>
							</div>
							<div class="col-xs-6">
								<p class="font-size-38"><span class="fa fa-money pull-right"></span></p>
							</div>
						</div>
						<p>Total Daily Sales</p>
						<a style="width:100%;" class="padding-8 hvr-bounce-to-right bg-alizarin" href="<?php echo site_url('reports/daily/'.$location_id.'/'.$current_date);?>">Read full report <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			
			</div>
		</div> -->
	</div>

	<div class="media">
		<div class="media-body clearfix-xs width-100">
			<div class="panel panel-shadow">
				<div class="panel-heading">
					<div class="pull-right btn-group">
						<?php foreach ($locations as $location) : ?>
						<a data-location="<?php echo $location['location_id'];?>" href="#<?php echo $location['location_id'];?>" class="btn btn-default btn-vertical btn-last-7-days"><?php echo $location['location'];?></a>
						<?php endforeach?>
					</div>
					<h4 class="headline">
						Stats <span class="label" style="background-color:#448aff">Included</span> <span class="label" style="background-color:#f4511e">FOC</span>
					</h4>
				</div>

				<div class="ct-chart ct-chart-daily" style="height: 200px; padding-right:15px; overflow: hidden"></div>

			</div>
		</div>
		<div class="media-right clearfix-xs">
			<div class="panel bg-primary text-center width-300">
				<div class="h3 margin-b-none">
					<?php echo $current_month;?>
				</div>
				<div class="h4 margin-t-none light">Total sales</div>
				<div class="panel-body">
					<i class="fa fa-calendar fa-4x"></i>
					<div class="h1"> &#8369; <?php echo $monthly_sales;?></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="media">
		<div class="media-body clearfix-xs width-100">
			<div class="panel panel-shadow">
				<div class="panel-heading">
					<div class="pull-right btn-group">
						<?php foreach ($locations as $location) : ?>
						<a data-location="<?php echo $location['location_id'];?>" href="#<?php echo $location['location_id'];?>" class="btn btn-default btn-vertical btn-this-year"><?php echo $location['location'];?></a>
						<?php endforeach?>
					</div>
					<h4 class="headline">
						<?php echo date('Y'); ?> Monthly Stats
					</h4>
				</div>

				<div class="ct-chart ct-chart-monthly" style="height: 200px; padding-right:15px; overflow: hidden"></div>
			</div>
		</div>
		<div class="media-right clearfix-xs">
			<div class="panel bg-primary text-center width-300">
				<div class="h3 margin-b-none">
					<?php echo $current_month;?>
				</div>
				<div class="h4 margin-t-none light">Total sales</div>
				<div class="panel-body">
					<i class="fa fa-calendar fa-4x"></i>
					<div class="h1"> &#8369; <?php echo $monthly_sales;?></div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php $this->view('partials/footer'); ?>
	  
  </div>


  <div class="overlay-disabled"></div>


  <?php $this->view('admin/_common/footer_js'); ?>

</body>
</html>