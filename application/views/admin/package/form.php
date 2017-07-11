<?php
ob_start();
?>
	<small class="bold text-muted">Name</small>
	<div class="form-group">
		<input type="text" class="form-control" name="package_name" value="<?php echo $package_name;?>">
	</div>
	
	<small class="bold text-muted">Number of Nights</small>
	<div class="form-group">
		<input type="text" class="form-control" name="duration" value="<?php echo $duration;?>">
	</div>
	
	<small class="bold text-muted">Package Type</small>
	<div class="form-group">
		<?php echo form_dropdown('package_type_id', $package_types, $package_type_id, 'class="form-control"'); ?>
	</div>

	<small class="bold text-muted"><i class="fa fa-clock"></i>Included Services</small>

	<div class="panel panel-default panel-shadow">
		<table class="table table-bordered item-packages">
			<thead>
				<tr>
					<th colspan="3">
						<div class="input-group">
							<?php echo items_dropdown('items', '', 'class="form-control"'); ?>
							<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-add-item"><i class="fa fa-plus"></i> </button>
						</span>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($package_items as $item) : ?>
				<tr>
					<td><?php echo $item['title'];?> </td>
					<td><input placeholder="Session or Set" name="package_items[<?php echo $item['item_id'];?>]" type="text" class="form-control" value="<?php echo $item['quantity'];?>"></td>
					<td><button type="button" class="btn btn-xs btn-delete-item"><i class="fa fa-trash-o"></i></button></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
	'action' => 'backend/package',
	'title' => $package_id ? 'Edit Package' : 'Add Package',
	'hidden_fields' => array('id' => $package_id),
	'contents' => $contents
));
?>