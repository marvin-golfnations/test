<!DOCTYPE html>
<html lang="en" class="app">
	<head>
		<?php $this->load->view('admin/_common/head', array('title' => 'Home - '.$this->session->userdata('screen_name'))); ?>
	</head>
	<body class="" >
		<section class="vbox">
			<?php $this->load->view('admin/_common/header'); ?>
			
			<section>
				<section class="hbox stretch">
					<section id="content">
						<section class="vbox">
							<section class="scrollable bg-white">
								<?php $this->load->view('frontend/photo');?>
								<div class="content">
									
									<?php if ($this->session->userdata('group_id') === 5):?>
										
									<div class="row">
										<div class="col-lg-12 col-xs-12">
											<div class="jumbotron">
												
												<h1 class="text-center">Your Wellness Journey Starts Here</h1>
												<p class="text-center">Welcome to paradise. The Farm at San Benito is where the journey to your best self begins. The Farm serves as your home in the tropics, where nature, science, and tradition combine to rejuvenate you. Our team will be with you in every step of your journey, giving you guidance and help when you need it. But like all great quests in this life, it all begins with a single step.</h1>
												</p>
											</div>
										</div>
									</div>
									
									<?php endif; ?>
									
									<div class="container-fluid">										
										<?php if ($this->session->userdata('group_id') === 11 || $this->session->userdata('group_id') === 13):?>
										
										<div class="wrapper-lg">

											<div class="row">   
												
												  <!-- Nav tabs -->
												  <ul class="nav nav-tabs" role="tablist" id="packages">
												    <?php foreach ($packages as $package) : ?>
												    <li role="presentation" <?php if ((int)$package['package_id'] === $default_package):?>class="active"<?php endif;?>><a href="#package-<?php echo $package['package_id'];?>" aria-controls="package-<?php echo $package['package_id'];?>" role="tab" data-toggle="tab"><?php echo $package['package_name'];?></a></li>
												    <?php endforeach; ?>
												  </ul>
												  <div class="tab-content">	
												<?php foreach ($guests as $package_id => $guest) : ?>
												   <div role="tabpanel" class="tab-pane <?php if ($package_id === $default_package):?>active<?php endif;?>" id="package-<?php echo $package_id;?>">
													   <div class="row wrapper-lg"> 
													   <?php foreach ($guest as $row) : ?>
												      <div class="col-xs-3 col-sm-4 col-md-2 col-lg-1">
												        <div class="item-image text-center">
													        <a  data-target="#guest-modal" data-toggle="modal" href="<?php echo site_url('frontend/guest/'.$row['booking_id'])?>" class="view-guest">
													        <?php if ($row['avatar']) : ?>
															<img class="img-circle img-responsive" src="<?php echo $row['avatar'];?>" />
															<?php else : ?>
															<img class="img-circle img-responsive" src="/images/pic_<?php echo $row['gender'];?>.png" />
															<?php endif; ?>
													        </a>
												        </div>
												        
												        <div class="item-content text-center">
												          <div class="item-text">
													          <a  data-target="#guest-modal" data-toggle="modal" href="<?php echo site_url('frontend/guest/'.$row['booking_id'])?>" class="view-guest">
															  	<?php echo $row['first_name'];?> <?php echo $row['last_name'];?>
													          </a>
												          </div>
												        </div>
												      </div>
												      	<?php endforeach; ?>
													   </div>
												   </div>
												<?php endforeach; ?>
												  </div>
											</div>
											
											<div class="modal fade" tabindex="-1" role="dialog" id="guest-modal"></div>

										</div>
										
										<?php endif;?>
										
										<?php if ($this->session->userdata('group_id') === 5):?>
									
										<div class="row">
											<div class="col-md-6 col-lg-3">
												
												<div class="jumbotron">
													<p class="text-center">
														<a href="<?php echo site_url('frontend/ghq');?>">Fill out your info/GHQ</a></p>
												</div>
											</div>
											<div class="col-md-6 col-lg-6">
												
												<h5 class="headline">Upcoming Treatments</h5>
												
												<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
													<?php if ($upcoming_treatments) : ?>
													<?php foreach ($upcoming_treatments as $event):?>
													<div class="panel panel-default">
														<div class="panel-heading" role="tab" id="headingOne">
															<h4 class="panel-title">
															<a role="button" data-toggle="collapse" data-parent="#accordion" href="#event_<?php echo $event['event_id'];?>" aria-expanded="true" aria-controls="collapseOne">
																<?php echo $event['event_title'] ? $event['event_title'] : $event['item_name']; ?> <?php if ($event['provider']) : ?>w/ <?php echo $event['provider'];?><?php endif;?>
															</a>
															<span class="text-muted"><?php echo date('m/d/Y g:ia', strtotime($event['start']));?> - <?php echo date('m/d/Y g:ia', strtotime($event['end']));?></span>
															</h4>
														</div>
														<div id="event_<?php echo $event['event_id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
															<div class="panel-body">
																<?php if ($event['facility_name']) : ?> Location : <span class="label" style="background-color:<?php echo $event['bg_color'];?>"><?php echo $event['facility_name'];?></span><br /><?php endif;?>
																<?php echo $event['description'];?>
															</div>
														</div>
													</div>
													<?php endforeach; ?>
													<?php else: ?>											
													<p class="text-danger">You do not have treatments TODAY.</p>
													<?php endif;?>
												</div>
												
												<h5 class="headline">Upcoming Activities</h5>
												
												<?php if ($upcoming_activities):?>
												
												<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
					
													<?php foreach ($upcoming_activities as $event):?>
													<div class="panel panel-default">
														<div class="panel-heading" role="tab" id="headingOne">
															<h4 class="panel-title">
															<a role="button" data-toggle="collapse" data-parent="#accordion" href="#event_<?php echo $event['event_id'];?>" aria-expanded="true" aria-controls="collapseOne">
																<?php echo $event['event_title'] ? $event['event_title'] : $event['item_name']; ?> <?php if ($event['provider']) : ?>w/ <?php echo $event['provider'];?><?php endif;?>
															</a>
															<span class="text-muted"><?php echo date('g:ia', strtotime($event['start']));?> - <?php echo date('g:ia', strtotime($event['end']));?></span>
															</h4>
														</div>
														<div id="event_<?php echo $event['event_id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
															<div class="panel-body">
																<?php if ($event['facility_name']) : ?> Location : <span class="label" style="background-color:<?php echo $event['bg_color'];?>"><?php echo $event['facility_name'];?></span><br /><?php endif;?>
																<?php echo $event['description'];?>
															</div>
														</div>
													</div>
													<?php endforeach; ?>
												</div>
												<?php else: ?>
												
												<p class="text-danger">You do not have activities TODAY.</p>
												
												<?php endif;?>
												
											</div>
											<div class="col-lg-3 hidden-xs hidden-sm hidden-md">
												<h5 class="headline">The Farm Activities</h5>
												<ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border" >
												  <?php foreach ($activities as $activity): ?>
												  <li class="list-group-item clearfix"><a  href="#<?php echo $activity['event_id'];?>" class="clear">
													  <small class="pull-right"><?php echo date('g:ia', strtotime($activity['start_dt']));?>-<?php echo date('g:ia', strtotime($activity['end_dt']));?></small>
													  
													  <strong class="block"><?php echo $activity['item_name'];?></strong>
													  </a>
													  <span class="pull-right">
													  	<?php echo $activity['facility_name'];?>
													  </span>
													  <?php echo $activity['description'];?>
													  <span class="pull-right">
													  	<a href="<?php echo site_url('frontend/join_now');?>" class="btn btn-xs btn-success btn-join-now" 
													  		data-item_id="<?php echo $activity['item_id'];?>"
													  		data-facility_id="<?php echo $activity['facility_id'];?>"
													  		data-start="<?php echo date('Y-m-d H:i:s', strtotime($activity['start_dt']));?>"
														  	data-end="<?php echo date('Y-m-d H:i:s', strtotime($activity['end_dt']));?>">Join Now</a>
													  </span>
												  </li>
												  <?php endforeach ;?>
												</ul>
											</div>
										</div>
										<?php endif;?>
									</div>
								</div>
							</section>
						</section>
						<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a> 
					</section>
				</section>
			</section>
		</section>
		<?php $this->load->view('admin/_common/footer_js', array('inline_js' => $inline_js)); ?>
			
	</body>
</html>