<?php
$return = urlencode($_SERVER["REQUEST_URI"]);
$qstr = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
$qstr = $qstr ? $qstr.'&return='.$return : '?return=' . $return;
?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Contacts')); ?>
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
							
							<?php $this->load->view('admin/_common/search_bar', array('title' => $account['first_name'] . ' ' . $account['last_name'], 'qstr' => $qstr)); ?>
							
							<div class="container-fluid ">
								
								<div id="main">

									<div class="row">
										
										<div class="col-md-12 col-lg-12">
											
											<div role="tabpanel" class="tabbable tabs-primary">
												<!-- Nav tabs -->
												<ul class="nav nav-tabs" role="tablist">
													<?php if (current_user_can('can_view_other_profiles') || $contact_id === 0 || $contact_id === get_current_user_id()) : ?>
														<li role="presentation">
															<a href="#account" aria-controls="account" role="tab" data-toggle="tab"><i class="fa fa-fw fa-user"></i> Profile</a>
														</li>
													<?php endif; ?>
													
													<?php if ($contact_id) : ?>
													
														<?php if ((int)$group_id === 5 || $group_id === NULL) : ?>
															<?php if (current_user_can('can_manage_guest_bookings')) : ?>
															<li role="presentation">
																<a href="#bookings" aria-controls="bookings" role="tab" data-toggle="tab"><i class="fa fa-fw fa-book"></i> Bookings</a>
															</li>
															<?php endif; ?>
															
															<?php if (current_user_can('can_manage_guest_forms')) : ?>
															<li role="presentation">
																<a href="#submissions" aria-controls="submissions" role="tab" data-toggle="tab"><i class="fa fa-fw fa-book"></i> Forms</a>
															</li>
															<?php endif; ?>
															
														<?php endif; ?>
														
														
														
														<?php if (isset($account['recent_booking'])) : ?>
															<li role="presentation">
																<a href="#appointment" aria-controls="appointment" role="tab" data-toggle="tab"><i class="fa fa-fw fa-calendar"></i>Calendar</a>
															</li>
														
														<?php endif; ?>
														
													<?php endif; ?>
													
													<?php if ($account['include_in_provider_list'] === 'y') : ?>
														<li role="presentation">
															<a href="#services" aria-controls="services" role="tab" data-toggle="tab">Related Services</a>
														</li>
													<?php endif; ?>

                                                    <?php if (current_user_can('can_manage_guest_settings')) : ?>
													<li role="presentation">
														<a href="#member" aria-controls="member" role="tab" data-toggle="tab"><i class="fa fa-fw fa-cog"></i> Settings</a>
													</li>
													<?php endif; ?>
												
												</ul>
												
												<!-- Tab panes -->
												<div class="tab-content tab-content-default">
													
													<?php if (current_user_can('can_view_other_profiles') || $contact_id === 0 || $contact_id === get_current_user_id()) : ?>
														<div role="tabpanel" class="tab-pane" id="account">
															<?php $this->view('admin/account/info', array('account' => $account, 'return' => $return)); ?>
														</div>
													<?php endif; ?>
													
													<?php if ($contact_id) : ?>
														<?php if (current_user_can('can_manage_guest_bookings')) : ?>
														<div role="tabpanel" class="tab-pane" id="bookings">
															<h4 class="headline">Recent & Previous Bookings
																<?php if ($account['recent_booking'] === null) : ?>
																<a href="<?php echo site_url('backend/booking/edit/' . $contact_id) ?>"
																   class="btn btn-primary btn-xs" data-toggle="modal"
																   data-target="#modal-popup">Add <i
																		class="fa fa-plus"></i></a>
																<?php endif; ?>
															</h4>
															<div class="table-responsive">
																<table class="table table-striped table-condensed">
																	<thead>
																	<tr class="text-uppercase ">
																		<th>Program</th>
																		<th>Status</th>
																		<th class="text-center"></th>
																	</tr>
																	</thead>
																	<tbody>
																	<?php foreach ($bookings as $booking) : ?>
																		<tr>
																			<td>
																				<a href="<?php echo site_url('backend/booking/edit/' . $contact_id . '/' . $booking['booking_id']) ?>"
																				   class="text-regular"
																				   data-toggle="modal"
																				   data-target="#modal-popup">
																					<?php echo $booking['title']; ?>
																				</a>
																					<div class="text-muted">
																						<?php if (isset($booking['start_date']) && isset($booking['end_date'])) : ?>
																							<?php echo date('m/d/Y', $booking['start_date']) . ' to ' . date('m/d/Y', $booking['end_date']); ?>
																						<?php endif; ?>
																					</div>
																			</td>
																			<td>
																				<?php
																				echo ucfirst($booking['status'])
																				?>
																			</td>
																			<td class="text-right">
																				<a href="<?php echo site_url('backend/booking/edit/' . $contact_id . '/' . $booking['booking_id']) ?>"
																				   class="btn btn-icon btn-primary"
																				   data-toggle="modal"
																				   data-target="#modal-popup"><i
																						class="md md-edit"></i></a>
																				<a href="<?php echo site_url('backend/account/edit/' . $contact_id . '/' . $booking['booking_id']) ?>#appointment"
																				   class="btn btn-icon btn-primary"><i
																						class="md md-event-available"></i></a>
																				<a href="<?php echo site_url('backend/account/print_schedule/' . $booking['booking_id']); ?>"
																				   class="btn btn-icon btn-primary"
																				   target="_blank"><i
																						class="fa fa-print"></i> </a>
																				<a href="<?php echo site_url('backend/booking/delete/' . $booking['booking_id']) ?>"
																				   class="btn btn-icon btn-primary btn-confirm"
																				   title="Are you sure you want to delete this entry?"><i
																						class="fa fa-trash-o"></i></a>
																			</td>
																		</tr>
																	<?php endforeach; ?>
																	</tbody>
																</table>
															</div>
														</div>
														<?php endif; ?>
														
														<?php if (current_user_can('can_manage_guest_forms')) : ?>
														
														<div role="tabpanel" class="tab-pane" id="submissions">

															<div class="row">
																
																<div class="col-lg-12">
																	<div class="tabs-left">
																		<ul class="nav nav-pills nav-stacked col-md-2">
																		<?php foreach ($guest_forms as $form) : ?>
																		<li>
																			<a data-toggle="tab" href="#form-<?php echo $form['form_id'];?>"><?php echo $form['form_name']; ?></a>
																		</li>
																		<?php endforeach; ?>
																		</ul>
																		
																		<div class="tab-content col-md-10">
																			<?php foreach ($guest_forms as $form) : ?>
																			
																			 
																			<div class="tab-pane" id="form-<?php echo $form['form_id'];?>">
																				
																				
																				<!--<h3><?php echo $form['form_name'];?></h3>-->
																				<?php
																					$completed_by = (int)$form['completed_by'];
																					if ($completed_by > 0 && current_user_can('can_edit_completed_forms') && get_current_user_id() !== $completed_by) :
																					    ?>
																					    You are not allowed to edit forms completed by others.
																					    <?php
																					else :
																					
																					
																						echo form_open('backend/entry', array('class' => 'form validate', 'id' => 'form-'.$form['form_id']), array('booking_id' => $booking_id, 'form_id' => $form['form_id'], 'complete' => 'y'));
																						
																					?>
																					<div class="btn-group pull-right">
																					  <button type="button" class="btn btn-primary btn-save-form-entry">Save</button>
																					  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
																					    <span class="caret"></span>
																					  </button>
																					  <ul class="dropdown-menu" role="menu">
																					    <li><a href="#" class="btn-new-form-entry">New</a></li>
																					    <li><a href="#" class="btn-save-form-entry">Save</a></li>
																					    <li><a href="#" class="btn-duplicate-form-entry">Duplicate</a></li>
																					  </ul>
																					</div>
																					<?php																						
																						
																					    $value = booking_form_entries($booking_id, $form['form_id']);
																					
																					    if ($value) {
																					        echo form_hidden('entry_id', $value['entry_id']);
																					    }
																					    echo '<div class="form-group">';
																					    $this->formbuilder->build($form['field_ids'], $value);
																					    echo '</div>';
																					    
																					    echo form_close();
																					    
																					endif;
																				?>
																			</div>
																			<?php endforeach;?>
																		</div>
																			
																	</div>
																	
																</div>
																																
															</div>
														</div>
														
														<?php endif; ?>
														
														<?php if ($booking_id) : ?>
															<div role="tabpanel" class="tab-pane" id="appointment">
																<?php if ($booking_id) : ?>
																	<?php $this->view('admin/account/calendar', array('booking_id' => $booking_id, 'recent_booking' => $account['recent_booking'], 'booking_items' => $booking_items)); ?>
																<?php else : ?>
																	<div class="alert alert-warning">
																		<button type="button" class="close"
																				data-dismiss="alert" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																		You haven't made any bookings.
																	</div>
																<?php endif; ?>
															</div>
														<?php endif; ?>
														
														
														<div role="tabpanel" class="tab-pane" id="messages">
															<?php $this->view('admin/account/messages', array('messages' => $messages, 'return' => $return)); ?>
														</div>
													
													<?php endif; ?>
													
													<?php if (current_user_can('include_in_provider_list', $account['contact_id'])) : ?>
														
														<div role="tabpanel" class="tab-pane" id="services">
															
															<?php echo form_hidden('contact_id', $account['contact_id']); ?>
															
															<div class="input-group">
																<?php echo form_dropdown('add_service', $other_services, '', 'class="selectpicker show-tick form-control"'); ?>
																<span class="input-group-btn">
	                                <button type="button" class="btn btn-primary" id="add_related_service"><i
											class="fa fa-plus"></i> Add Service</button>
	                            </span>
															</div>
															
															<table class="table" id="related_services">
																<thead>
																<tr>
																	<th>Remove</th>
																	<th>Service</th>
																</tr>
																</thead>
																<tbody>
																<?php if ($related_services) : ?>
																	<?php foreach ($related_services as $service) : ?>
																		<tr id="related_services_<?php echo $service['item_id']; ?>">
																			<td style="width:5%;"><?php echo form_checkbox('remove_related_services_' . $service['item_id'], $service['item_id'], $service['contact_id'] !== null); ?></td>
																			<td>
																				<?php
																				$duration = (int)$service['duration'];
																				echo $service['title'] . ($duration > 0 ? ' (' . $duration . ' min)' : '');
																				?>
																			</td>
																		</tr>
																	<?php endforeach; ?>
																<?php endif; ?>
															</table>
														</div>
													
													<?php endif; ?>

                                                    <?php if (current_user_can('can_manage_guest_settings')) : ?>
													<div role="tabpanel" class="tab-pane" id="member">
														<?php $this->view('admin/account/login', array('account' => $account, 'return' => $return)); ?>
													</div>
													<?php endif; ?>
												</div>
											
											</div>
										</div>
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