<?php
ob_start ();
?>
<div role="tabpanel">
	<ul class="nav nav-tabs">
		<li class="active" role="presentation"><a data-toggle="tab" role="tab"
			aria-controls="details" href="#details">Details</a></li>
		<li role="presentation"><a data-toggle="tab" role="tab" aria-controls="notes" href="#notes">Notes</a></li>
		<li role="presentation"><a data-toggle="tab" role="tab" aria-controls="restrictions" href="#restrictions">Restrictions</a></li>
		<li role="presentation" id="forms-tab"><a data-toggle="tab" role="tab"
								   aria-controls="forms" href="#forms">Forms</a></li>
		<li role="presentation"><a data-toggle="tab" role="tab"
			aria-controls="attachments" href="#attachments">Attachments</a></li>
	</ul>

	<div class="tab-content">

		<div id="notes" class="tab-pane" role="tabpanel">

			<textarea name="notes" id="notes" cols="30" rows="10"
				class="summernote"><?php echo $notes;?></textarea>

		</div>
		
		<div id="restrictions" class="tab-pane" role="tabpanel">

			<textarea name="restrictions" id="restrictions" cols="30" rows="10"
				class="summernote"><?php echo $restrictions;?></textarea>

		</div>


		<div id="details" class="tab-pane active" role="tabpanel">

			<?php if (!$booking_id) : ?>
			<div class="form-group">
				<label for="skip_confirmation" class="bold text-muted">Skip Verification Email</label>
				<div class="input-group">
					<?php echo form_checkbox('skip_confirmation', 1); ?> Add the booking without sending an email that requires their verification.
				</div>
			</div>
			<?php endif; ?>

			<div class="form-group <?php echo $personalized ? 'hidden' : ''?>" id="personalized-n">
				
				<label class="bold text-muted">Program</label>
				
				<div class="input-group">
					
					<select name="packages" <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> class="form-control required"
						data-live-search="true"
						<?php if (in_array($status, array(BOOKING_STATUS_COMPLETED, BOOKING_STATUS_CONFIRMED))):?>disabled="disabled"<?php endif;?>>

						<option value="">-Select-</option>
						<?php foreach ($packages as $package) : ?>
						<option <?php echo $package_id === $package['package_id'] ? 'selected' : '' ?> data-duration="<?php echo $package['duration']?>" value="<?php echo $package['package_id']; ?>"><?php echo $package['package_name']; ?></option>
						<?php endforeach ?>
					
					</select>
					 
					<span class="input-group-btn">
						<button type="button" <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> class="btn btn-default btn-select-package"
								<?php if (in_array($status, array(BOOKING_STATUS_COMPLETED, BOOKING_STATUS_CONFIRMED))):?>disabled="disabled"<?php endif;?>>
							<i class="fa fa-check"></i> Select
						</button>
					</span>
					
				</div>
			</div>
			
			
			
			<div class="form-group <?php echo $personalized ? '' : 'hidden'?>" id="personalized-y">
				
				<label class="bold text-muted">Program</label>
				
				<input name="title" type="text" <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> value="<?php echo $title; ?>" class="form-control" />
				<input name="package_id" type="hidden" value="<?php echo $package_id; ?>" />
			
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label class="bold text-muted">Personalized?</label>
						<div class="input-group">
							<?php echo form_checkbox('personalized', 1, $personalized === 1); ?> Yes
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				
				<div class="col-md-4">
					
					
					
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="bold text-muted"><i class="fa fa-calendar"></i>
									Start Date</label> <input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> type="text" name="start_date"
									class="form-control required"
									value="<?php echo $start_date ? date('m/d/Y', $start_date) : date('m/d/Y') ?>">
		
							</div>
						</div>
						<div class="col-lg-6">
		
							<div class="form-group">
		
								<label class="bold text-muted"><i class="fa fa-calendar"></i> End
									Date</label> <input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> type="text" name="end_date"
									class="form-control required"
									value="<?php echo $end_date ? date('m/d/Y', $end_date) : date('m/d/Y') ?>">
		
							</div>
						</div>
					</div>
										
				</div>
				
				<div class="col-md-8">
					<div class="col-lg-4">
						<div class="form-group">
							<label class="bold text-muted">Status</label>
							<?php echo form_hidden('original_status', $status); ?>
	                		<?php echo form_dropdown('status', $statuses, $status, array('class' => "form-control required")); ?>
	            		</div>
					</div>
	
					<div class="col-lg-4">
						<div class="form-group">
							<label class="bold text-muted">Pax</label>
							<?php echo form_input('fax', $fax, array('class' => "form-control required")); ?>
						</div>
					</div>
					
					<div class="col-lg-4">
						<div class="form-group">
							<label class="bold text-muted">Room</label>
							<?php echo form_dropdown('room_id', $facilities, $room_id, array('class' => "form-control")); ?>
						</div>
					</div>
				</div>

				

				
			</div>
			
			<div class="row">

				<div class="panel">
	
					<div class="panel-body">
	
						<div class="form-group">
							<div class="input-group">
	                    <?php echo items_dropdown('items', '', 'class="form-control"'); ?>
	                    <span class="input-group-btn">
									<button type="button" <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> class="btn btn-default btn-add-alacarte">
										<i class="fa fa-plus"></i>
									</button>
								</span>
							</div>
						</div>
						<label class="bold text-muted">Services</label>
						
						<table class="table table-bordered table-striped item-packages">
							<thead>
								<tr>
									<th>Service</th>
									<th class="text-center"># or Set/Session</th>
									<th class="text-center">Included?</th>
									<th class="text-center">FOC?</th>
									<th class="text-center">Upsell?</th>
									<th class="text-center">Upgrade?</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($booking_items as $item) : ?>

								<tr>
									<td>
										<?php echo $item['title']; ?>
										<input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?>
											name="package_items[<?php echo $item['booking_item_id']; ?>][item_id]"
											type="hidden" value="<?php echo $item['item_id']; ?>">
									</td>
									<td><input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?>
											name="package_items[<?php echo $item['booking_item_id']; ?>][qty]"
											type="text" class="form-control text-center package-items-qty" 
											data-original_qty="<?php echo $item['quantity']; ?>"
											value="<?php echo $item['quantity']; ?>">
									</td>
									<td class="text-center">
										<div class="checkbox checkbox-success checkbox-inline">
											<input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> id="package_items_included_<?php echo $item['booking_item_id']; ?>" name="package_items[<?php echo $item['booking_item_id']; ?>][included]" type="checkbox" <?php if (isset($item['included']) && $item['included']) : ?>checked="checked"<?php endif;?> value="1">
										</div>
									</td>
									<td class="text-center">
										<div class="checkbox checkbox-success checkbox-inline">
											<input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> id="package_items_foc_<?php echo $item['booking_item_id']; ?>" name="package_items[<?php echo $item['booking_item_id']; ?>][foc]" type="checkbox" <?php if (isset($item['foc']) && $item['foc']) : ?>checked="checked"<?php endif;?> value="1">
										</div>
									</td>
									<td class="text-center">
										<div class="checkbox checkbox-success checkbox-inline">
											<input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> id="package_items_upsell_<?php echo $item['booking_item_id']; ?>" name="package_items[<?php echo $item['booking_item_id']; ?>][upsell]" type="checkbox" <?php if (isset($item['upsell']) && $item['upsell']) : ?>checked="checked"<?php endif;?> value="1">
										</div>
									</td>
									<td class="text-center">
										<div class="checkbox checkbox-success checkbox-inline">
											<input <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> id="package_items_upgrade_<?php echo $item['booking_item_id']; ?>" name="package_items[<?php echo $item['booking_item_id']; ?>][upgrade]" type="checkbox" <?php if (isset($item['upgrade']) && $item['upgrade']) : ?>checked="checked"<?php endif;?> value="1">
										</div>
									</td>

									<td><button <?php echo !current_user_can('can_manage_guest_bookings') ? 'disabled' : '';?> type="button" class="btn btn-xs btn-delete-item">
											<i class="fa fa-trash-o"></i>
										</button></td>
								</tr>
							<?php endforeach; ?>
	                </tbody>
						</table>
					</div>
	
				</div>
			</div>
		</div>

		<div id="forms" class="tab-pane" role="tabpanel">
			<div class="table-responsive">
			<table class="table"
				<thead>
					<tr>
						<th style="width: 15px"></th>
						<th>Name</th>
						<th class="text-center">Required?</th>
						<th class="text-center">Submitted?</th>
						<th class="text-center">Notify User on Submit?</th>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($forms as $form) : ?>
				<?php
				$selected = isset($form['required']) && $form['required'] !== null;
				$notify = array();
				if (isset($form['notify_user_on_submit']) && $form['notify_user_on_submit'] !== null) {
					$notify = unserialize($form['notify_user_on_submit']);
				}
				?>
				<tr>
					<td>
						<?php echo form_checkbox('booking_forms['.$form['form_id'].'][form_id]', $form['form_id'], $selected); ?>
					</td>
					<td><?php echo $form['form_name'];?></td>
					<td class="text-center">
						<?php echo form_checkbox('booking_forms['.$form['form_id'].'][required]', 'y', $form['required'] === 'y'); ?>
					</td>
					<td class="text-center">
						<?php echo form_checkbox('booking_forms['.$form['form_id'].'][submitted]', 'y', $form['submitted'] === 'y'); ?>
					</td>
					<td class="text-center">
						<?php //echo form_multiselect('booking_forms['.$form['form_id'].'][notify_user_on_submit][]', $notify_users, $notify, 'class="multi-select"');?>
					</td>
				</tr>
			<?php endforeach;?>
				</tbody>
			</table>
			</div>

		</div>

		<div id="attachments" class="tab-pane" role="tabpanel">

			<div class="row" id="controls">
				<div class="col-md-12">
					<div class="btn-toolbar" id="toolbar">
						<div class="btn-wrapper" id="toobar-upload">
							<input type="file" name="attachment" class="filestyle">
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th class="text-uppercase">File</th>
							<th class="text-muted text-uppercase text-center">Date</th>
							<th style="width: 130px;"></th>
						</tr>
					</thead>
					<tbody>
            <?php foreach ($attachments as $file) : ?>
            	<tr>
							<td><?php echo $file['file_name']?></td>
							<td class="text-muted text-uppercase text-center"><?php echo unix_to_human($file['upload_date'])?></td>
							<td class="text-center"><a class="btn btn-default btn-rounded"
								href="#"><i class="fa fa-eye"></i></a> <a
								class="btn btn-default btn-rounded btn-delete-file" href="#"><i
									class="fa fa-trash-o"></i></a></td>
						</tr>
            <?php endforeach;?>
            	</tbody>
				</table>
			</div>


		</div>
	</div>



</div>
<?php
$contents = ob_get_clean ();

$this->view ( 'partials/modal', array (
		'action' => 'backend/booking',
		'title' => $booking_id ? 'Edit Booking' : 'Add Booking',
		'form_classes' => array (),
		'hidden_fields' => array (
			'id' => $booking_id,
			'guest_id' => $contact_id
		),
		'contents' => $contents 
) );
