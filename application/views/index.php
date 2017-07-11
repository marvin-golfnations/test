<!DOCTYPE html>

<html dir="ltr" lang="en-US">
<head>
	<?php $this->load->view('common/head', array('title' => 'The Farm at San Benito')); ?>
</head>
<body class="stretched">

<?php $this->load->view('common/login_form'); ?>


<!-- Document Wrapper
 ============================================= -->
<div id="wrapper" class="clearfix">
	
	<?php $this->load->view('common/top'); ?>
	<?php $this->load->view('common/header'); ?>
	
	
	
	
	<?php $this->load->view('common/slider'); ?>
	
	
	<!-- Content initial commit
	============================================= -->
	<section id="content">
		<div class="content-wrap bgcolor-black notoppadding nobottompadding">
			
			
			<div class="section nobottommargin notopmargin bottompadding-lg bgcolor-white">
				
				<div class="container toppadding-sm center hidden">
					
					<div>
						<h3 class="serif">Welcome to the Farm at San Benito</h3>
						<p>
							The Farm at San Benito is a health and wellness resort where guests can embark on a holistic
							healing journey<br/>
							to balance mind, body and spirit. It is the sole sanctuary of its kind in the Philippines
							and one of the best in<br/>
							the world. The Farm offer transformative retreats which enables its guests to cope with the
							ever-increasing<br/>
							stress-filled challenges of everyday life through a well-managed and tailored wellness
							programs for<br/>
							restoration of balance and harmony by encouraging a commitment to a proactive healthy
							lifestyle.
						</p>
						<!--<span>Sarah Smith - Trip Advisor</span>//-->
						<?php if (!$this->session->userdata('user_id')) : ?>
						<div style="width:300px;" class="center"><a href="#login" data-toggle="modal" data-target="#login-modal" type="submit" value="Submit"
																	class="button button-small button-full button-reveal button-check tright hvr-bounce-to-top"><span>FIND OUT MORE</span>
								<i class="icon-chevron-right"></i></a>
								
								</div>
								<?php endif; ?>
					</div>
					
				
				</div>
			</div>
			
			<?php if ($this->session->userdata('group_id') === 5): ?>
				
				<div class="section nobottommargin notopmargin toppadding-md bottompadding-md bgcolor dark">
					<div class="container center clearfix">
						<div class="nobottommargin subscribe-center">
							<button
								class="button button-small button-reveal button-gradient button-rounded tright button-subscribe"
								type="button" onclick="window.location = '/ghq';"><span>Fill out your info/GHQ</span> <i
									class="icon-chevron-right"></i></button>
						</div>
					
					</div>
				</div>
				
				<div class="section nobottommargin notopmargin bottompadding-lg bgcolor-white">
					
					<div class="container toppadding-md">
						
						<div class="row">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12">
								
								<div class="tab-section tab-amenities invert" data-sr="over 1s, move 15px">
									
									<ul class="nav nav-tabs nav-tabs-ame nav-tabs-small">
										<li class="active">
											<a data-toggle="tab" href="#upcoming-treatments">
												Upcoming Treatments
											</a>
										</li>
										<li>
											<a data-toggle="tab" href="#upcoming-activities">
												Upcoming Nutritional Activities
											</a>
										</li>
										<li>
											<a data-toggle="tab" href="#activities">
												The FARM Activities
											</a>
										</li>
									
									</ul>
									
									<div class="tab-content">
										<div id="upcoming-treatments" class="tab-pane fade in active">
											
											<?php if ($upcoming_treatments) : ?>
												<ul class="list-unstyled list-items list-amelist">
													<?php foreach ($upcoming_treatments as $event): ?>
														<li>
															<p class="title">
																<i class="icon-plus"></i>
																<i class="icon-minus"></i>
																<?php echo $event['event_title'] ? $event['event_title'] : $event['item_name']; ?> <?php if ($event['provider']) : ?>w/ <?php echo $event['provider']; ?><?php endif; ?>
																<span
																	class="text-muted"><?php echo date('M d g:ia', strtotime($event['start'])); ?>
																	- <?php echo date('g:ia', strtotime($event['end'])); ?></span>
															</p>
															<div class="amenity-desc serif">
																<p>
																	<?php if ($event['facility_name']) : ?> Location :
																		<span
																			class="label"
																			style="background-color:<?php echo $event['bg_color']; ?>"><?php echo $event['facility_name']; ?></span>
																		<br/><?php endif; ?>
																	<?php echo $event['description']; ?>
																</p>
														</li>
													<?php endforeach; ?>
												</ul>
											<?php else: ?>
												<p class="text-danger">You do not have treatments TODAY.</p>
											<?php endif; ?>
										</div>
										
										<div id="upcoming-activities" class="tab-pane fade in">
											<?php if ($upcoming_activities): ?>
												
												<ul class="list-unstyled list-items list-amelist">
													
													<?php foreach ($upcoming_activities as $event): ?>
														<li>
															<p class="title">
																<i class="icon-plus"></i>
																<i class="icon-minus"></i>
																<?php echo $event['event_title'] ? $event['event_title'] : $event['item_name']; ?> <?php if ($event['provider']) : ?>w/ <?php echo $event['provider']; ?><?php endif; ?>
																<span
																	class="text-muted"><?php echo date('M d g:ia', strtotime($event['start'])); ?>
																	- <?php echo date('g:ia', strtotime($event['end'])); ?></span>
															</p>
															<div class="amenity-desc serif">
																<p>
																	<?php if ($event['facility_name']) : ?> Location :
																		<span
																			class="label"
																			style="background-color:<?php echo $event['bg_color']; ?>"><?php echo $event['facility_name']; ?></span>
																		<br/><?php endif; ?>
																	<?php echo $event['description']; ?>
																</p>
															</div>
														</li>
													<?php endforeach; ?>
												</ul>
											<?php else: ?>
												
												<p class="text-danger">You do not have activities TODAY.</p>
											
											<?php endif; ?>
										</div>
										
										<div id="activities" class="tab-pane fade in">
											<ul class="list-unstyled list-items list-amelist">
												<?php foreach ($activities as $activity): ?>
													<li>
														<p class="title">
															<i class="icon-plus"></i>
															<i class="icon-minus"></i>
															
															<?php echo $activity['item_name']; ?>
															
															<small class="text-muted"><?php echo date('M d g:ia', strtotime($activity['start_dt'])); ?>
																- <?php echo date('g:ia', strtotime($activity['end_dt'])); ?></small>
														
														
														</p>
														<div class="amenity-desc serif clearfix">
													  	<?php echo $activity['description']; ?>
															<p>
															<span class="pull-right">
													  		<?php echo $activity['facility_name']; ?>
															</span>
															
															<?php if (isset($booking_id)) : ?>
															
															<a href="<?php echo site_url('frontend/join_now'); ?>"
															   class="hidden btn btn-xs btn-success btn-join-now"
															   data-booking_id="<?php echo $booking_id;?>"	   
															   data-item_id="<?php echo $activity['item_id']; ?>"
															   data-facility_id="<?php echo $activity['facility_id']; ?>"
															   data-start="<?php echo date('Y-m-d H:i:s', strtotime($activity['start_dt'])); ?>"
															   data-end="<?php echo date('Y-m-d H:i:s', strtotime($activity['end_dt'])); ?>">Join Now</a>
															   
															<?php endif; ?>
															</p>
														</div>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			
				
			<?php endif; ?>
					
		
		</div>
	</section>
	<!-- #content end -->
	
	<?php $this->load->view('common/footer'); ?>

</div><!-- #wrapper end -->

<?php $this->load->view('common/footer_js'); ?>


</body>
</html>
