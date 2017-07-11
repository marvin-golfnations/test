<?php
ob_start();
?>
	<div class="row">
		<div class="col-lg-12">
			<small class="bold text-muted">Name</small>
			<p>
				<input type="text" class="form-control" name="facility_name" value="<?php echo $facility_name;?>">
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-3 col-md-6 col-lg-3">
			<small class="bold text-muted">Abbr</small>
			<p>
				<input type="text" class="form-control" name="abbr" value="<?php echo $abbr;?>">
			</p>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-3">
			<small class="bold text-muted">Maximum Accomodation</small>
			<p>
				<input type="text" class="form-control" name="max_accomodation" value="<?php echo $max_accomodation;?>">
			</p>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-3">
			<small class="bold text-muted">Color</small>
			<div class="form-group">
				<div id="facility-bg-colorpicker" class="input-group colorpicker-component">
					<input type="text" name="bg_color" value="<?php echo $bg_color;?>" class="form-control" /> <span class="input-group-addon"><i></i></span>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col-md-6 col-lg-3">
			<small class="bold text-muted">Status</small>
			<p>
				<?php echo form_dropdown('status', $statuses, $status, array('class' => 'form-control'));?>
			</p>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-3">
			<small class="bold text-muted">Assignment</small>
			<p>
				<?php echo form_dropdown('location_id', get_locations(), $location_id, array('class' => 'form-control')); ?>
			</p>
		</div>
	</div>

	<div class="row hidden">
		
		<div class="col-lg-12">
			<div class="input-group">
				<?php echo form_dropdown('services', $services, '', 'class="form-control"'); ?>
				<span class="input-group-btn"><button type="button" name="add-related-service" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button></span>
			</div>
			<table id="related-services" class="table">
				<tbody>
			<?php foreach ($related_services as $service) : ?>
				<tr>
					<td><?php echo form_checkbox('delete[]', $service['item_id']);?></td>
					<td><?php echo $service['title'];?></td>
				</tr>
			<?php endforeach ;?>
				</tbody>
			</table>
		</div>
		
	</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
	'action' => 'backend/facility',
	'title' => $facility_id ? 'Edit Facility' : 'Add Facility',
	'hidden_fields' => array('id' => $facility_id),
	'contents' => $contents
));
?>
