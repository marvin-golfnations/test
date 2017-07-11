
										<div class="col-lg-3">
											<div class="panel panel-default">
												<div class="panel-heading bold">In-house Guests <span class="badge"><?php echo count($bookings);?></span></div>
												<table class="table table-striped table-in-house-guests" data-page-length='10'>
													<thead>
														<tr>
															<th>Name</th>
															<th>Room</th>
															<th>&nbsp;</th>
														</tr>
													</thead>
													<!--http://schedule.thefarmatsanbenito.com/backend/account/edit/327?return=%2Fbackend%2Fcontacts%2Fguest-->
													<tbody>
													<?php foreach ($bookings as $row) :?>
													<tr>
													<td><a class="guest-calendar" data-booking_id="<?php echo $row['booking_id'];?>" href="#"><?php echo $row['first_name'] . ' ' . $row['last_name'];?></a></td>
													<td><?php echo $row['room_name']; ?></td>
													<td><a class="guest-calendar" data-booking_id="<?php echo $row['booking_id'];?>" href="#">View</a></td>
													</tr>
													<?php endforeach; ?>
													</tbody>
												</table>
											</div>
											
											<div class="panel-group" id="package-types" role="tablist" aria-multiselectable="true">
												
												<?php foreach ($bookings_by_package as $name => $_bookings) : ?>
											  <div class="panel panel-default">
											    <div class="panel-heading bold" role="tab" id="headingOne">
											      <h3 class="panel-title">
											        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo url_title($name);?>" aria-expanded="true" aria-controls="collapseOne">
											          <?php echo $name; ?> Program <span class="badge"><?php echo count($_bookings);?></span>
											        </a>
											      </h3>
											    </div>
											    <div id="<?php echo url_title($name);?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
											      <div class="panel-body">
												      <table class="table">
													      <thead>
														<tr>
															<th>Name</th>
															<th>Room</th>
															<th>&nbsp;</th>															
														</tr>
													</thead>
													      <?php foreach ($_bookings as $row) : ?>
													    <tr>
															<td><a href="<?php echo site_url('backend/booking/edit/'.$row['contact_id'].'/'.$row['booking_id']);?>" data-toggle="modal" data-target="#modal-popup"><?php echo $row['first_name'] . ' ' . $row['last_name'];?></a></td>
															<td><?php echo $row['room_name']; ?></td>
															<td><a href="<?php echo site_url('backend/account/edit/'.$row['contact_id'].'?return=/backend/dashboard');?>">View</a></td>

														</tr>
													      <?php endforeach;?>
												      </table>
											      </div>
											    </div>
											  </div>
											  <?php endforeach; ?>
											</div>
										</div>
