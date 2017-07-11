<?php
ob_start();
?>
	<small class="bold text-muted">Name</small>
	<p>
		<input type="text" class="form-control" name="name" value="<?php echo $package_type_name;?>">
	</p>
	<small class="bold text-muted">Image</small>
	<p>
		<img src="<?php echo get_image_url($package_image);?>" width="100" style="padding-bottom:10px">
		<span><input type="file" name="package_image" class="filestyle"></span>
	</p>
	<div class="row">
		<div class="col-lg-12">
			<small class="bold text-muted">Description</small>
			<textarea name="description" class="summernote"><?php echo $description;?></textarea>
		</div>
	</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
	'action' => 'backend/packagetype/submit',
	'title' => $package_type_id ? 'Edit Package Type' : 'Add Package Type',
	'hidden_fields' => array('id' => $package_type_id, 'return' => $_REQUEST['return']),
	'contents' => $contents
));
?>
