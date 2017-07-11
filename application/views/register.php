<!doctype html>
<html>
<head>
	<?php $this->view('partials/head',array('title'=>'Register')); ?>
	<link href="/css/jquery.wizard.css" rel="stylesheet" media="all" />
	<style type="text/css">
		body {
			padding-top: 60px;
			padding-bottom: 40px;
			background-color: #fff;
		}
		.sidebar-nav {
			padding: 9px 0;
		}

		[data-wizard-init] {
			margin: auto;
			width: 800px;
		}
	</style>
</head>
<body>
<div class="container-fluid">
	<?php echo form_open('register/submit',array('id'=>'form-validation', 'class' => 'registration-form'));?>

    <div class="logo text-center" href="#"><img src="<?php echo '/images/logo_med.png'?>"/></div>


	<div data-wizard-init>
		<ul class="steps">
			<li data-step="1">Account</li>
			<li data-step="2">Personal Information</li>
			<li data-step="3"><?php echo $form['form_name']?></li>
			<li data-step="4">Confirm and Submit</li>
		</ul>
		<div class="steps-content">
			<div data-step="1">
				<div class="panel-body">

					<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control required" name="username" id="username" placeholder="Username" >
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" class="form-control required" name="email" id="email" placeholder="Email" >
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control required" name="password" id="password" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm Password</label>
						<input type="password" class="form-control required" name="confirm_password" id="confirm_password" placeholder="Confirm password">
					</div>
				</div>
			</div>
			<div data-step="2">
				<div class="panel-body">
					<div class="form-group">
						<label for="">Last Name</label>

							<input type="text" class="form-control" id="last_name" name="last_name" value="">
					</div>
					<div class="form-group">
						<label for="">First Name</label>
							<input type="text" class="form-control" id="first_name" name="first_name" value="">
					</div>
					<div class="form-group">
						<label for="">Title</label>
							<input type="text" class="form-control" name="title" value="">
					</div>
					<div class="form-group">
						<label for="">Civil Status</label>
							<input type="text" class="form-control" name="civil_status" value="">
					</div>
					<div class="form-group">
						<label for="">Gender</label>
							<div class="radio radio-info radio-inline">
								<input type="radio" id="female" value="0" name="gender">
								<label for="female"> Female </label>
							</div>
							<div class="radio radio-info radio-inline">
								<input type="radio" id="male" value="1" name="gender">
								<label for="male"> Male </label>
							</div>
					</div>
					<div class="form-group">
						<label for="">Date of Birth</label>
							<input type="text" class="datepicker form-control" name="dob" value="">
					</div>
					<div class="form-group">
						<label for="">Age</label>
							<input type="text" class="form-control" name="age" value="">
					</div>
					<div class="form-group">
						<label for="">Ethnic Origin</label>
							<input type="text" class="form-control" name="etnic_origin" value="">
					</div>
					<div class="form-group">
						<label for="">Height</label>
							<input type="text" class="form-control" name="height" value="">
					</div>
					<div class="form-group">
						<label for="">Weight</label>
							<input type="text" class="form-control" name="weight" value="">
					</div>
					<div class="form-group">
						<label for="">Telephone Number</label>
							<input type="text" class="form-control" name="phone" value="">
					</div>
					<div class="form-group">
						<label for="">Nationality</label>
							<?php echo form_dropdown('nationality', $nationalities, 'Filipino', array("class"=>"selectpicker show-tick form-control")); ?>
					</div>
					<div class="form-group">
						<label for="">Country of Dominicile</label>
							<?php echo form_dropdown('country_dominicile', $countries, 'PH', array("class"=>"selectpicker show-tick form-control")); ?>
					</div>
				</div>
			</div>
			<div data-step="3">
				<div class="panel-body">
					<?php
					echo '<div class="form-group">';
					$this->formbuilder->build($form['field_ids'], '');
					echo '</div>';
					?>
				</div>
			</div>
			<div data-step="4">
				<div class="form-group">
					<div class="checkbox"><input type="checkbox" class="required" id="confirm-<?php echo $form['form_id'];?>" name="confirm[<?php echo $form['form_id'];?>]">
						<label for="confirm-<?php echo $form['form_id'];?>">I hereby certify that the above information given are true and correct as to the best of my knowledge.</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_hidden('form_id', $form['form_id']);?>
	<?php echo form_close();?>

</div><!--/.fluid-container-->

<!--
  <div class="container-fluid">

	  <div class="text-center">
		  <p class="text-muted">or connect with</p>
		  <a href="#" class="btn btn-default btn-rounded"><i class="fa fa-facebook fa-fw"></i></a>
	  </div>

  </div>
-->
<?php $this->view('admin/_common/footer_js'); ?>
</body>
</html>