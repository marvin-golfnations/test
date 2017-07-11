<!doctype html>
<html>
<head>
		<?php $this->view('partials/head',array('title'=>'Configuration')); ?>

</head>
<body class="sidebar-push">
  
	<?php $this->view('partials/topbar'); ?>
	
	<?php $this->view('partials/sidebar'); ?>

  <div class="container-fluid ">
  
  		<?php echo form_open('settings/configuration', '', array('site_id' => $site_id)); ?>

		<div id="main">
			<div class="page-header">
				<h1 class="serif">
					Configuration
					
					<button type="submit" id="save-configuration" data-loading-text="Saving..." class="btn btn-primary" autocomplete="off">
					  Save Changes
					</button>
					
				</h1>
				
				
			</div>
			<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Localization</h3>
			  	</div>
			  	<div class="panel-body">
			  		<label class="text-muted">Timezone</label>
			    	<input type="text" class="form-control" name="preferences[localization][timezone]" value="<?php echo $preferences['localization']['timezone'];?>" />
			    	
			    	<label class="text-muted">Date Format</label>
			    	<input type="text" class="form-control" name="preferences[localization][date_format]" value="<?php echo $preferences['localization']['date_format'];?>" />
			    	
			    	<label class="text-muted">Language</label>
			    	<input type="text" class="form-control" name="preferences[localization][language]" value="<?php echo $preferences['localization']['language'];?>" />
			  	</div>
			</div>
			
			<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">User Preferences</h3>
			  	</div>
			  	<div class="panel-body">
			  		<label class="text-muted">Avatar Upload Path</label>
			    	<input type="text" class="form-control" name="preferences[upload_path]" value="<?php echo $preferences['upload_path'];?>" />
			  	</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Company</h3>
				</div>
				<div class="panel-body">
					<label class="text-muted">Start Time</label>
					<input type="text" class="form-control" name="preferences[start_time]" value="<?php echo $preferences['start_time'];?>" />
					<label class="text-muted">End Time</label>
					<input type="text" class="form-control" name="preferences[end_time]" value="<?php echo $preferences['end_time'];?>" />
				</div>
			</div>
			
			

			<div class="sidebar right-side" id="right-sidebar"></div>
		</div>
		
		<?php echo form_close(); ?>


	  <?php $this->view('partials/footer'); ?>
	  
  </div>


	<div class="overlay-disabled"></div>
  
  <?php $this->view('admin/_common/footer_js'); ?>


</body>
</html>