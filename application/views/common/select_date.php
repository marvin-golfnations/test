		<?php
		$return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		?>
		
		<div class="modal fade" id="select-date-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	  <div class="modal-dialog">
				<div class="loginmodal-container">
					<h1 class="serif">Select Date</h1><br>
					
				  <?php echo form_open('retreats/book',array('id'=>'form-validation'), array('return' => $return)); ?>
					<input type="text" id="select-date" style="text-align: center"/>
					<input type="hidden" name="start_date" id="start_date" />
					<input type="hidden" name="end_date" id="end_date" />
					<input type="hidden" name="package_id" id="package_id" />
					<input type="submit" name="confirm" class="login loginmodal-submit" value="Confirm">
				  <?php echo form_close(); ?>
					
				</div>
			</div>
		  </div>