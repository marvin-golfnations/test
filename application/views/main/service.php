<?php
$title = '';	
if ($category['cat_id'] === '1') {
	$title = 'Holistic Sanctuary';
}	
elseif ($category['cat_id'] === '2') {
	$title = 'Aqua Sancruary';
}
elseif ($category['cat_id'] === '11') {
	$title = 'Movement and Fitness';
}

?>	

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php $this->load->view('common/head', array('title' => $title)); ?>
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
	<section id="page-title" class="page-title page-title-dark mild-dark-overlay"
			 style="background-image: url('<?php echo get_image_url($category['cat_image']) ?>');
				 background-size: cover; background-position: center center;">
		<div class="container center clearfix">
			<h1 class="serif normal"><?php echo $title; ?></h1>
			<span></span>
		</div>
	</section>
	<!-- #page-title end -->
	
	<section id="content">
		
		<div class="content-wrap bgcolor-black notoppadding nobottompadding">
			
			<div class="section nobottommargin notopmargin bottompadding-lg bgcolor-white">
				
				<div class="container toppadding-sm">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12">
							<?php $exclude_item = array(); ?>
							<?php if ($this->session->has_userdata('user_id')) : ?>

							<?php if (isset($treatments)) : ?>
							<div class="tab-section tab-amenities invert" data-sr="over 1s, move 15px">
								
								<ul class="nav nav-tabs nav-tabs-ame nav-tabs-small">
									<li class="active">
										<a data-toggle="tab" href="#cat">
											My Treatments
										</a>
									</li>
								</ul>
								
								<div class="tab-content">
									<div id="cat" class="tab-pane fade in active">
										
										<ul class="list-unstyled list-items list-amelist">
											
											
											<?php foreach ($treatments as $event): ?>
												<?php $exclude_item[] = $event['item_id']; ?>
												<li>
													
													<p class="title serif">
														<i class="icon-plus"></i>
														<i class="icon-minus"></i>
														
														<?php echo $event['item_name']; ?>
													</p>
													
													<div class="amenity-desc serif">
														<?php echo $event['description']; ?>
														<p>
															Date :
															<b><?php echo date('d/M h:iA', strtotime($event['start'])); ?>
																- <?php echo date('h:iA', strtotime($event['end'])); ?></b><br/>
															Duration :
															<b><?php echo $event['duration']; ?>
																minutes</b><br/>
															Location :
															<b><?php if ($event['facility_name']) : ?><?php echo $event['facility_name']; ?><?php else : ?>TBD<?php endif; ?></b><br/>
															Provider :
															<b><?php if ($event['provider']) : ?><?php echo $event['provider']; ?><?php else : ?>TBD<?php endif; ?></b>
														</p>
														<?php if (!is_past_date($event['start'])) : ?>
														<p>
															<?php if ($this->session->has_userdata('user_id') && $booking_id) : ?>
																<a data-target="#popup-modal"
																   data-toggle="modal"
																   href="<?php echo site_url('frontend/rebook/'.$event['event_id']);?>"
																   class="btn btn-popup btn-success"> Rebook</a>
															<?php endif; ?>
														</p>
														<?php else : ?>
															<button type="button"
															   href="#"
															   class="btn btn-popup btn-default" disabled>Completed</button>

															<a data-target="#popup-modal"
															   data-toggle="modal"
															   href="<?php echo site_url('frontend/add_service/'.$booking_id.'/'.$event['item_id']);?>"
															   class="btn btn-popup btn-success"> Book Again</a>
														<?php endif; ?>
													</div>
												
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</div>
						
						<?php endif; ?>
						<?php endif; ?>
						
							<div class="tab-section tab-amenities invert" data-sr="over 1s, move 15px">
								<?php
								
								$categories = get_categories($category_id, true);	
									
/*
								$this->db->where_in("cat_id", array($category_id));
								$query = $this->db->get("categories");
								$categories = $query->result_array();
*/
								?>
								<ul class="nav nav-tabs nav-tabs-ame nav-tabs-small">
									<?php foreach ($categories as $cat_id => $cat_name) : ?>
										<li>
											<a data-toggle="tab" href="#cat-<?php echo $cat_id; ?>"><?php echo $cat_name; ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
								
								<div class="tab-content">
									<?php foreach ($categories as $cat_id => $cat_name) : ?>
										
										<div id="cat-<?php echo $cat_id; ?>"
											 class="tab-pane fade in active">
											
											<ul class="list-unstyled list-items list-amelist">
												<?php
												$this->db->select('items.*');
												$this->db->from('items');
												$this->db->join('item_categories', 'items.item_id = item_categories.item_id');
												$this->db->where('item_categories.category_id', $cat_id);
												$this->db->where('items.for_sale', 'y');
												$query = $this->db->get();
												if ($query->num_rows() > 0) {
													foreach ($query->result_array() as $row) :
														
														if ($row['amount'] === '0') continue;
														
														$disable = false;
														
														if (!in_array($row['item_id'], $exclude_item)):
														?>
														
														<li>
															
															
															<p class="title serif">
																<i class="icon-plus"></i>
																<i class="icon-minus"></i>
																<?php echo $row['title']; ?>
																(<?php echo $row['duration']; ?> Minutes)
															</p>
															
															<div class="amenity-desc serif">
																
																<?php echo $row['description']; ?>
																<p class="price">Duration : <b><?php echo $row['duration']; ?>
																		minutes</b></p>
																<p>
																<?php if ($this->session->has_userdata('user_id') && $booking_id) : ?>
																<a data-target="#popup-modal"
																   data-toggle="modal"
																   href="<?php echo site_url('frontend/add_service/' . $booking_id . '/' . $row['item_id'] . '/' . $category_id); ?>"
																   class="btn btn-popup<?php echo $disable ? ' btn-default disabled' : ' btn-success' ?>"> <?php echo $disable ? 'Booked' : '<i class="fa fa-plus"></i> Book Now' ?></a>
																<?php endif; ?>
																</p>
															</div>
														</li>
														<?php
														endif;
													endforeach;
												}
												?>
											</ul>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- #content end -->
	<div class="modal" tabindex="-1" role="dialog" id="popup-modal"></div>
	<?php $this->load->view('common/footer'); ?>
</div>
<!-- #wrapper end -->
<?php $this->load->view('common/footer_js'); ?>
</body>
</html>