
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $account['title'] . '. ' . $account['first_name'] . ' ' . $account['last_name'];?></h4>
			</div>
			<div class="modal-body">
				<!-- tabs left -->
				<div class="tabbable tabs-left">
					<ul class="nav nav-tabs">
					<li class="active"><a href="#profile" data-toggle="tab">Guest Profile</a></li>
					<li><a href="#restrictions" data-toggle="tab">Restrictions</a></li>
					<li><a href="#program" data-toggle="tab">Program</a></li>
					<li><a href="#nutrionits-notes" data-toggle="tab">Nutritionist Notes</a></li>
					<li><a href="#schedule" data-toggle="tab">Schedule</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane wrapper-lg active" id="profile">
							
							<?php $this->load->view('frontend/profile', array('account' => $account, 'room_name' => $room_name, 'contact_id' => $contact_id, 'return' => 'frontend')); ?>
							
						</div>
						<div class="tab-pane wrapper-lg" id="restrictions">
							<p><?php echo $account['restrictions'];?></p>
						</div>
						<div class="tab-pane wrapper-lg" id="program">
							<p>Program : <b><?php echo $account['program_name'];?></b></p>
							<p>Date : <b><?php echo date('m/d/Y', $account['start_date']);?> - <?php echo date('m/d/Y', $account['end_date']);?></b></p>
						</div>
						<div class="tab-pane wrapper-lg" id="nutrionits-notes">
							<p><?php echo $account['notes'];?></p>
						</div>
						<div class="tab-pane wrapper-lg" id="schedule">
							
							
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
								
								<?php foreach ($events as $date => $event):?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#event_<?php echo $date;?>" aria-expanded="true" aria-controls="collapseOne">
											<?php echo date('M d, Y', strtotime($date));?>
										</a>
										</h4>
									</div>
									<div id="event_<?php echo $date;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<ul class="list-group">
											<?php foreach ($event as $row) : ?>
											<li class="list-group-item">
											<strong><?php echo $row['item_name'];?></strong>
											<span class="span-muted">
												<?php echo date('g:ia', strtotime($row['start']));?> - <?php echo date('g:ia', strtotime($row['end']));?>
											</span>
											<div>Facility : <strong><?php if ($row['facility_name']) : ?><?php echo $row['facility_name'];?><?php else : ?>TBD<?php endif; ?></strong></div>
											<div>Provider : <strong><?php if ($row['provider']) : ?><?php echo $row['provider'];?><?php else : ?>TBD<?php endif; ?></strong></div>
											</li>
											<?php endforeach; ?>
											</ul>
											
										</div>
									</div>
								</div>
								<?php endforeach; ?>
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /tabs -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->