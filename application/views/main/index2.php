<!DOCTYPE html>
<html lang="en" class="app">
	<head>
		<meta charset="utf-8" />
		<title>Scale | Web Application</title>
		<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link href='http://fonts.googleapis.com/css?family=Lora:400italic' rel='stylesheet' type='text/css'>		
		<link rel="stylesheet" href="/css/app.css" type="text/css" />
		<link rel="stylesheet" href="/css/fullcalendar.min.css">
		<!--[if lt IE 9]> <script src="js/ie/html5shiv.js"></script> <script src="js/ie/respond.min.js"></script> <script src="js/ie/excanvas.js"></script> <![endif]-->
	</head>
	<body class="" >
		<section class="vbox">
			<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
				<div class="navbar-header aside-md dk"> <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html"> <i class="fa fa-bars"></i> </a> <a href="index.html" class="navbar-brand"> <img src="/images/logo_main.png" class="m-r-sm" alt="scale"> <span class="hidden-nav-xs"> </span> </a> <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"> <i class="fa fa-cog"></i> </a> </div>
				<ul class="nav navbar-nav hidden-xs">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bars"></i> </a> 
						<section class="dropdown-menu aside-lg bg-white on animated fadeInLeft">
							<div class="row m-l-none m-r-none m-t m-b text-center">
								<div class="col-xs-4">
									<div class="padder-v"> <a href="#"> <span class="m-b-xs block"> <i class="i i-mail i-2x text-primary-lt"></i> </span> <small class="text-muted">Mailbox</small> </a> </div>
								</div>
								<div class="col-xs-4">
									<div class="padder-v"> <a href="#"> <span class="m-b-xs block"> <i class="i i-calendar i-2x text-danger-lt"></i> </span> <small class="text-muted">Calendar</small> </a> </div>
								</div>
								<div class="col-xs-4">
									<div class="padder-v"> <a href="#"> <span class="m-b-xs block"> <i class="i i-map i-2x text-success-lt"></i> </span> <small class="text-muted">Map</small> </a> </div>
								</div>
								<div class="col-xs-4">
									<div class="padder-v"> <a href="#"> <span class="m-b-xs block"> <i class="i i-paperplane i-2x text-info-lt"></i> </span> <small class="text-muted">Trainning</small> </a> </div>
								</div>
								<div class="col-xs-4">
									<div class="padder-v"> <a href="#"> <span class="m-b-xs block"> <i class="i i-images i-2x text-muted"></i> </span> <small class="text-muted">Photos</small> </a> </div>
								</div>
								<div class="col-xs-4">
									<div class="padder-v"> <a href="#"> <span class="m-b-xs block"> <i class="i i-clock i-2x text-warning-lter"></i> </span> <small class="text-muted">Timeline</small> </a> </div>
								</div>
							</div>
						</section>
					</li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
					<li class="hidden-xs">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-shopping-cart"></i> <span id="cart-count" class="badge badge-sm up bg-danger count">0</span> </a> 
						<section class="dropdown-menu aside-xl animated flipInY">
							<section class="panel bg-white">
								<div class="panel-heading b-light bg-light"> <strong>You have <span class="count">2</span> notifications</strong> </div>
								<div class="list-group list-group-alt"> <a href="#" class="media list-group-item"> <span class="pull-left thumb-sm"> 
									<?php echo img(array('src' => get_current_user_photo(), 'class' => 'img-circle')); ?> </span> <span class="media-body block m-b-none"> Use awesome animate.css<br> <small class="text-muted">10 minutes ago</small> </span> </a> <a href="#" class="media list-group-item"> <span class="media-body block m-b-none"> 1.0 initial released<br> <small class="text-muted">1 hour ago</small> </span> </a> </div>
								<div class="panel-footer text-sm"> <a href="#" class="pull-right"><i class="fa fa-cog"></i></a> <a href="#notes" data-toggle="class:show animated fadeInRight">See all the notifications</a> </div>
							</section>
						</section>
					</li>
					<li class="hidden-xs">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-flag"></i> <span class="badge badge-sm up bg-danger count">2</span> </a> 
						<section class="dropdown-menu aside-xl animated flipInY">
							<section class="panel bg-white">
								<div class="panel-heading b-light bg-light"> <strong>You have <span class="count">2</span> notifications</strong> </div>
								<div class="list-group list-group-alt"> <a href="#" class="media list-group-item"> <span class="pull-left thumb-sm"> 
									<?php echo img(array('src' => get_current_user_photo(), 'class' => 'img-circle')); ?> </span> <span class="media-body block m-b-none"> Use awesome animate.css<br> <small class="text-muted">10 minutes ago</small> </span> </a> <a href="#" class="media list-group-item"> <span class="media-body block m-b-none"> 1.0 initial released<br> <small class="text-muted">1 hour ago</small> </span> </a> </div>
								<div class="panel-footer text-sm"> <a href="#" class="pull-right"><i class="fa fa-cog"></i></a> <a href="#notes" data-toggle="class:show animated fadeInRight">See all the notifications</a> </div>
							</section>
						</section>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left"> <?php echo img(array('src' => get_current_user_photo())); ?> </span> <?php echo $this->session->userdata('screen_name');?> <b class="caret"></b> </a> 
						<ul class="dropdown-menu animated fadeInRight">
							<li> <span class="arrow top"></span> <a href="#">Settings</a> </li>
							<li> <a href="profile.html">Profile</a> </li>
							<li> <a href="#"> <span class="badge bg-danger pull-right">3</span> Notifications </a> </li>
							<li> <a href="docs.html">Help</a> </li>
							<li class="divider"></li>
							<li> <a href="modal.lockme.html" data-toggle="ajaxModal" >Logout</a> </li>
						</ul>
					</li>
				</ul>
			</header>
			<section>
				<section class="hbox stretch">
					<section id="content">
						<section class="vbox">
							<section class="scrollable bg-white">
								<div class="wrapper-lg bg-light">
									<div class="hbox">
										<aside class="aside-md">
											<div class="text-center">
												<?php echo img(array('src' => get_current_user_photo(), 'class' => 'img-circle m-b')); ?>
											</div>
										</aside>
										<aside>
											<p class="pull-right m-l inline"> <a href="#" class="btn btn-sm btn-icon btn-info rounded m-b"><i class="fa fa-twitter"></i></a> <a href="#" class="btn btn-sm btn-icon btn-primary rounded m-b"><i class="fa fa-facebook"></i></a> <a href="#" class="btn btn-sm btn-icon btn-danger rounded m-b"><i class="fa fa-google-plus"></i></a> </p>
											<h3 class="font-bold m-b-none m-t-none" style="color:#fff"><?php echo $this->session->userdata('screen_name');?></h3>
											<p style="color:#fff"><?php echo $this->session->userdata('email');?></p>
											<?php if ($this->session->userdata('position')) : ?><p><i class="fa fa-lg fa-circle-o text-primary m-r-sm"></i><strong><?php echo $this->session->userdata('position');?></strong></p><?php endif;?>
										</aside>
									</div>
								</div>
								<ul class="nav nav-tabs m-b-n-xxs bg-light">
									<li class="active"><a href="#dashboard" data-toggle="tab">Home</a></li>
									<li> <a href="#form1" data-toggle="tab"><?php echo $form1['form_name']?></a></li>
									<li> <a href="#appointments" data-toggle="tab">Schedule</a></li>
									<li> <a href="#activities" data-toggle="tab" class="m-l">The Farm Activities<span class="badge bg-primary badge-sm m-l-xs"><?php echo count($activities);?></span></a> </li>
									<li> <a href="#kids-activities" data-toggle="tab" class="m-l">The Kids Farm Activities<span class="badge bg-primary badge-sm m-l-xs"><?php echo count($kids_activities);?></span></a> </li>
									<li> <a href="#form6" data-toggle="tab">Measurements</a></li>
									<li> <a href="#services" data-toggle="tab">Treatments</a></li>
									<li> <a href="#edit" data-toggle="tab">Edit profile</a> </li>
								</ul>
								<div class="tab-content">
									
									<div class="tab-pane wrapper-lg active" id="dashboard">
										
										<div class="row">
											<div class="col-lg-12">
												<div class="jumbotron">
												  <h1>Hello, world!</h1>
												  <p>...</p>
												  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-lg-3">
												Fill out your info/GHQ
											</div>
											<div class="col-lg-6">
												
											</div>
											<div class="col-lg-3">
												
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
											  	<button class="btn btn-xs btn-success">Join Now</button>
											  </span>
										  </li>
										  <?php endforeach ;?>
										</ul>
												
											</div>
										</div>
										
									</div>
									
									<div class="tab-pane wrapper-lg" id="form<?php echo $form1['form_id']?>">									
									
									<?php 
									echo form_open('entry', array('class' => 'form-horizontal padding-15 validate'), array('form_id' => $form1['form_id'], 'booking_id' => 0));
									if ($form1['form_html'] !== '') : 
									echo $form1['form_html'];
									else :
									$this->formbuilder->build($form1['field_ids'], '');
									endif;
									?>
									<div class="line line-dashed b-b line-lg pull-in"></div>
									<div class="form-group">
								        <div class="col-md-offset-3 col-sm-5 ">
								            <button type="submit" class="btn btn-primary">Submit</button>
								        </div>
								    </div>
									<?php
									echo form_close();
									?>
									
									</div>
									<div class="tab-pane wrapper-lg" id="appointments">
										<div class="media">
											<div class="media-body">
												<div id="calendar2"></div>
											</div>
										</div>
									</div>
									
									<div class="panel tab-pane" id="activities">
										<ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border" >
										  <?php foreach ($activities as $activity): ?>
										  <li class="list-group-item"><a  href="#<?php echo $activity['event_id'];?>" class="clear">
											  <small class="pull-right"><?php echo date('g:ia', strtotime($activity['start_dt']));?>-<?php echo date('g:ia', strtotime($activity['end_dt']));?></small>
											  <strong class="block"><?php echo $activity['item_name'];?></strong>
											  <span class="pull-right">
											  	<?php echo $activity['facility_name'];?>
											  </span>
											  <?php echo $activity['description'];?></a>
										  </li>
										  <?php endforeach ;?>
										</ul>
									</div>
									
									<div class="panel tab-pane" id="kids-activities">
										<ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border" >
										  <?php foreach ($kids_activities as $activity): ?>
										  <li class="list-group-item"><a  href="#<?php echo $activity['event_id'];?>" class="clear">
											  <small class="pull-right"><?php echo date('g:ia', strtotime($activity['start_dt']));?>-<?php echo date('g:ia', strtotime($activity['end_dt']));?></small>
											  <strong class="block"><?php echo $activity['item_name'];?></strong>
											  <span class="pull-right">
											  	<?php echo $activity['facility_name'];?>
											  </span>
											  <?php echo $activity['description'];?></a>
										  </li>
										  <?php endforeach ;?>
										</ul>
									</div>
									
									<div class="tab-pane wrapper-lg" id="form<?php echo $form6['form_id']?>">									
									
									<?php 
									echo form_open('entry', array('class' => 'form-horizontal padding-15 validate'), array('form_id' => $form6['form_id'], 'booking_id' => 0));
									if ($form6['form_html'] !== '') : 
									echo $form6['form_html'];
									else :	
									$this->formbuilder->build($form6['field_ids'], '');
									endif;
									?>
									<div class="line line-dashed b-b line-lg pull-in"></div>
									<div class="form-group">
								        <div class="col-md-offset-3 col-sm-5 ">
								            <button type="submit" class="btn btn-primary">Submit</button>
								        </div>
								    </div>
									<?php
									echo form_close();
									?>
									
									</div>
									<div class="tab-pane wrapper-lg" id="services">
										
										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
											<?php foreach ($categories as $category) : ?>
											<div class="panel panel-default">
												<div class="panel-heading" role="tab" id="headingOne">
													<h4 class="panel-title">
														<a role="button" data-toggle="collapse" data-parent="#accordion" href="#cat-<?php echo $category['cat_id'];?>" aria-expanded="true" aria-controls="collapseOne">
														<?php echo $category['cat_name'];?>
														</a>
													</h4>
												</div>
												<div id="cat-<?php echo $category['cat_id'];?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
													<div class="panel-body">
														<div class="media">
															<?php
															$this->db->select('items.*'); 
															$this->db->from('items');
															$this->db->join('item_categories', 'items.item_id = item_categories.item_id');
															$this->db->where('item_categories.category_id', $category['cat_id']);
															$query = $this->db->get();
															if ($query->num_rows() > 0) {
																foreach ($query->result_array() as $row) : 
															?>
<!--
														  	<div class="media-left">
														    <a href="#">
														      <img class="media-object" src="..." alt="...">
														    </a>
														  	</div>
-->
														  	<div class="media-body">
															  	<span class="pull-right">
															  		<button type="button" data-item-id="<?php echo $row['item_id'];?>" data-price="<?php echo $row['amount'];?>" data-name="<?php echo $row['title'];?>" class="btn btn-primary btn-add-to-cart">
															  			<i class="fa fa-plus"></i>
															  		</button>
															  	</span>

														    	<h5 class="media-heading">
															    	<?php echo $row['title'];?> <a href="#"><i class="fa fa-caret-right"></i> </a>
																	&#8369;<?php echo $row['amount'];?>/<?php echo $row['duration']; ?> Minutes
														    	</h5>
														    	<div class="media-content hidden"><?php echo $row['description'];?></div>
														    	<div class="line line-dashed b-b line-lg pull-in"></div>
														  	</div>
														  	<?php
															  	endforeach; 
															}  	
															?>
														</div>
													</div>
												</div>
											</div>
											<?php endforeach ;?>
										</div>										
										
									</div>
									<div class="tab-pane wrapper-lg" id="edit">
										<?php $this->view('frontend/info', array('account' => $account)); ?>
									</div>
								</div>
							</section>
						</section>
						<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a> 
					</section>
				</section>
			</section>
		</section>
		<!-- Inline JS-->
		<script type="application/javascript">
		var TF = {};
		TF.now = function() {
			return moment.unix(<?php echo now(); ?>);
		};
		TF.baseURL = '<?php echo site_url();?>';
		TF.dateFormat = 'MM/DD/YYYY';
		<?php if (isset($inline_js) && $inline_js) : ?>
		
		<?php foreach (array_keys($inline_js) as $var): ?>
		<?php echo 'TF.'. $var . ' = ' . json_encode($inline_js[$var]). ';'."\n"?>
		<?php endforeach; ?>
		<?php endif; ?>
		</script>

		<!-- Bootstrap --> <!-- App --> 
		<script src="/js/app.js"></script> 
		<script src="/js/jquery.floatThead.js"></script>
		<script src="/js/moment.min.js"></script>
		<script src="/js/fullcalendar.js"></script>
		<script src="/js/calendar.js"></script>
		<script src="/js/app.plugin.js"></script>
		<script>
			$(document).ready(function(){
				
				var get_cart = function() {
					$.ajax({
						url: TF.baseURL + 'frontend/get_cart',
						success: function(data) {
							$('#cart-count').html(data.total_items);
						}
					});
				}
				
				get_cart();
				
				$('.btn-add-to-cart').each(function(){
					$(this).on('click', function(){
						
						if ($(this).hasClass('btn-primary')) {	
							$(this).removeClass('btn-primary');
							$(this).addClass('btn-success');
							$(this).html('<i class="fa fa-check"></i> Added');
							
							var data = {
								item_id : $(this).attr('data-item-id'),
								name : $(this).attr('data-name'),
								price : $(this).attr('data-price')
							};
							
							$.ajax({
								url: TF.baseURL + 'frontend/add_to_cart',
								data: data,
								type: 'post',
								success: function(data) {
									get_cart();
								}
							})
						}
						else {
							$(this).removeClass('btn-success');
							$(this).addClass('btn-primary');
							$(this).html('<i class="fa fa-plus"></i>');
						}
					});
				});
			});
		</script>
	</body>
</html>