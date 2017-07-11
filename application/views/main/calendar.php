<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php $this->load->view('common/head', array('title' => 'Calendar')); ?>
</head>
<body class="stretched">
<?php $this->load->view('common/login_form'); ?>
<!-- Document Wrapper
	============================================= -->
<div id="wrapper" class="clearfix">
	<?php $this->load->view('common/top'); ?>
	<?php $this->load->view('common/header'); ?>
	<!-- Page Title
		============================================= -->
	<section id="page-title" class="page-title page-title-dark mild-dark-overlay" style="background-image: url('/images/calendar.jpg');
				 background-size: cover; background-position: center top;">
		<div class="container center clearfix">
			<h1 class="serif normal">Calendar</h1>
			<span></span>
		</div>
	</section>
	<!-- #page-title end -->

								<section class="content">
										
									<div class="content-wrap bgcolor-black notoppadding nobottompadding">
			
									<div class="section nobottommargin notopmargin bottompadding-lg bgcolor-white">

									<div class="container">
									
										<div class="row">
											
											<div class="col-lg-12 pull-right" style="padding-bottom: 15px; padding-top: 30px;">
												
												<div class="btn-group" data-toggle="buttons">
												  <label class="btn btn-default active">
												    <input value="1,2" type="radio" name="calendar-cat-id" id="option1" autocomplete="off" checked> Treatments
												  </label>
												  <label class="btn btn-default">
												    <input value="3,12" type="radio" name="calendar-cat-id" id="option2" autocomplete="off"> Nutrional Activities
												  </label>
												</div>
									
											</div>
											
											
											<div class="col-lg-12 col-xs-12 col-sm-12" style="padding:0;">
																								
												<div id="calendar"></div>
												
											</div>
										</div>
									</div>
									
									</div>
									
									</div>
								</section>
	<div id="popup-modal" class="modal"></div>
							<!-- #content end -->
	<?php $this->load->view('common/footer'); ?>
</div>
<!-- #wrapper end -->
<?php $this->load->view('common/footer_js'); ?>
</body>
</html>