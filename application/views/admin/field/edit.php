<?php
ob_start();
?>
<!--
	<small class="bold text-muted">Field Name</small>
	<p>
		<input type="text" class="form-control" name="field_name" value="<?php echo $field_name;?>">
	</p>
-->
	<small class="bold text-muted">Field Label</small>
	<p>
		<input type="text" class="form-control" name="field_label" value="<?php echo $field_label;?>">
	</p>
	<div class="checkbox checkbox-primary">
		<?php echo form_checkbox('required', 'y', $required === 'y' ? true : false, 'id="required"'); ?>
		<label for="required"> Required? </label>
	</div>
	<small class="bold text-muted">Field Type</small>
	<div class="row">
		<div class="col-md-6">
			<?php echo form_dropdown('field_type', $field_types, $field_type, 'class="form-control"'); ?>
		</div>
		<div class="col-md-6">
			
			<div id="field_type_text" class="field_type_settings" style="<?php if ($field_type !== 'text') echo 'display:none'; ?> ">
				
				<?php 
					
					$_settings = unserialize($settings);
					$has_settings = false;
					if ($_settings && isset($_settings['text'])) {
						$_settings = $_settings['text'];
					}
					
					echo form_checkbox('settings[text][multiline]', 'y', isset($_settings['multiline'])); 
					
				?> Multi-line?
				
			</div>
			
			<div id="field_type_dropdown" class="field_type_settings" style="<?php if ($field_type !== 'dropdown') echo 'display:none'; ?> ">
				
				<?php
					$value = '';
					$_settings = unserialize($settings);
					if ($_settings && isset($_settings['dropdown'])) {
						$value = $_settings['dropdown'];
					}
					echo form_textarea('settings[dropdown]', $value, 'class="form-control"', 5); 
				?>

				<small class="text-muted">Put each item per line</small>
			</div>
			
			<div id="field_type_checkboxes" class="field_type_settings" style="<?php if ($field_type !== 'checkboxes') echo 'display:none'; ?> ">
				<?php
					$value = '';
					$_settings = unserialize($settings);
					if ($_settings && isset($_settings['checkboxes'])) {
						$value = $_settings['checkboxes'];
					}
					echo form_textarea('settings[checkboxes]', $value, 'class="form-control" rows="5"'); 
				?>
				
				<small class="text-muted">Put each item per line</small>
			</div>

			<div id="field_type_radiobuttons" class="field_type_settings" style="<?php if ($field_type !== 'radiobuttons') echo 'display:none'; ?> ">
				<?php
				$value = '';
				$_settings = unserialize($settings);
				if ($_settings && isset($_settings['radiobuttons'])) {
					$value = $_settings['radiobuttons'];
				}
				echo form_textarea('settings[radiobuttons]', $value, 'class="form-control" rows="5"');
				?>

				<small class="text-muted">Put each item per line</small>
			</div>
			
			<div id="field_type_datatable" class="field_type_settings" style="<?php if ($field_type !== 'datatable') echo 'display:none'; ?> ">
				
				<?php
					$value = '';
					$_settings = unserialize($settings);
					if ($_settings && isset($_settings['datatable'])) {
						$value = $_settings['datatable'];
					}
					echo form_textarea('settings[datatable]', $value, 'class="form-control"', 5); 
				?>

				<small class="text-muted">Put each header per line.</small>
			</div>
			
		</div>
	</div>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
	'action' => 'backend/field',
	'title' => $field_id ? 'Edit Field' : 'Add Field',
	'hidden_fields' => array('id' => $field_id),
	'contents' => $contents
));
?>
