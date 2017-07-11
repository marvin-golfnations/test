<?php
ob_start();
?>

	<div class="row">

		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="form-group">
				<label class="bold text-muted"><i class="fa fa-tasks"></i> Service</label>
				<div class="form-group">
					<div class="input-group" style="width:100%">
						<?php echo form_dropdown('item_id', available_booking_items(0, $categories), $item_id,
							'class="show-tick form-control" '.($item_id ? 'readonly' : '')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<div class="form-group">
				<label class="bold text-muted"><i class="fa fa-calendar"></i> Date & Time Settings</label>
				<div class="input-group">
					<div class="start-dt" style="display: inline-block;">
						<input style="width: 100px" type="text" name="start_date" class="form-control datepicker" value="<?php echo $start_date;?>" />
						<?php echo form_dropdown('start_time', $times, $start_time, 'class="form-control required" style="width:50%"'); ?>
					</div>
					<div class="end-dt" style="display: inline-block;">
						<input style="width: 100px" type="text" name="end_date" class="form-control datepicker" value="<?php echo $end_date;?>" />
						<?php echo form_dropdown('end_time', $times, $end_time, 'class="form-control required" style="width:50%"'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    <div class="row">
	    
	    <div class="col-xs-12 col-md-6 col-lg-6">
	
		    <div class="form-group">
				<div class="input-group" style="width:100%">
					<label class="bold text-muted"><i class="fa fa-home"></i> Facility</label>
					<?php echo form_dropdown('facility_id', $facilities, $facility_id, 'class="show-tick form-control"'); ?>
				</div>
		    </div>
	    
	    </div>
		<div class="col-xs-12 col-md-6 col-lg-6">
		    <div class="form-group">
				<div class="input-group" style="width:100%">
					<label class="bold text-muted"><i class="fa fa-user"></i> Service provider (s)</label>
					<?php echo form_multiselect('assigned_to[]', $providers, $assigned_to, 'class="multi-select show-tick form-control"', TRUE); ?>
				</div>
		    </div>
		</div>
    
    </div>

	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-3">
		    <div class="form-group">
				<div class="input-group" style="width:100%">
					<label class="bold text-muted"><i class="fa fa-flag"></i> Status</label>
					<?php echo form_dropdown('status', $statuses, $status, 'class="show-tick form-control"'); ?>
				</div>
		    </div>
		    
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<label class="bold text-muted"><i class="fa fa-file-text"></i> Additional Info </label>
				<?php echo form_input('notes', $notes, 'class="form-control"'); ?>
			</div>
		</div>
		
	</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
    'action' => 'backend/events',
    'ajax' => false,
    'custom_buttons' => $event_id ? '<a class="btn btn-orange btn-confirm pull-left" title="Are you sure you want to delete this event" href="'.site_url('backend/events/delete/'.$event_id).'?return='.$return.'">Delete</a>' : '',
    'title' => 'Activities',
    'hidden_fields' => array('event_id' => $event_id, 'item_id' => $item_id, 'is_kids' => $is_kids),
    'contents' => $contents
));
?>