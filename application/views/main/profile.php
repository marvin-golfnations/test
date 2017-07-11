<!DOCTYPE html>
<html dir="ltr" lang="en-US">
	<head>
		<?php $this->load->view('common/head', array('title' => 'Calendar')); ?>
		<!-- some CSS styling changes and overrides -->
		<style>
			.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
				margin: 0;
				padding: 0;
				border: none;
				box-shadow: none;
				text-align: center;
			}
			.kv-avatar .file-input {
				display: table-cell;
				max-width: 220px;
			}
		</style>
	</head>
	<body class="stretched">
		<?php $this->load->view('common/login_form'); ?>
		<!-- Document Wrapper
			============================================= -->
		<div id="wrapper" class="clearfix">
			<?php $this->load->view('common/top'); ?>
			<?php $this->load->view('common/header'); ?>
			<!-- Page Title
				============================================= -->
			<section id="page-title" class="page-title page-title-dark mild-dark-overlay" style="background-image: url('/images/calendar.jpg');
				background-size: cover; background-position: center top;">
				<div class="container center clearfix">
					<h1 class="serif normal">My Profile</h1>
					<span></span>
				</div>
			</section>
			<!-- #page-title end -->
			<section class="content">
				<div class="content-wrap bgcolor-black notoppadding nobottompadding">
					<div class="section nobottommargin bottompadding-lg bgcolor-white">
						<div class="container">
							<?php if ($this->session->flashdata('success_message')) : ?>
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								<?php echo $this->session->flashdata('success_message') ?>
							</div>
							<?php endif ?>
							<?php if ($this->session->flashdata('error_message')) : ?>
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								<?php echo $this->session->flashdata('error_message') ?>
							</div>
							<?php endif ?>
							<?php echo form_open_multipart('profile', array('class'=>'form-horizontal padding-15 validate', 'name' => 'profileForm'), array('contact_id' => $account['contact_id']));?>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-xs-12 text-center">
									<div class="container-fluid text-center">
										<div class="kv-avatar center-block" style="width:200px">
											<input id="avatar" name="avatar" type="file" class="file-loading">
										</div>
										<!--
										<br />
										<button class="btn btn-success"><i class="fa fa-pencil"></i> Update Profile</button>
										-->
									</div>
								</div>
								<div class="col-lg-9 col-md-9 col-xs-12">
									<h3 class="serif"><?php echo $account['first_name'] . ' ' . $account['last_name'];?></h3>
											
									<div class="panel panel-default">
										<div class="panel-heading serif" style="background-color: #68b044; font-weight: bolder">
											Personal Information
										</div>
										<div class="panel-body">
											<div class="form-group">
												<label for="" class="col-sm-3 control-label">Email Address</label>
												<div class="col-sm-9 col-xs-12">
													<input type="text" disabled class="form-control" id="email" name="email" value="<?php echo $account['email'];?>">
												</div>
											</div>
											<div class="form-group">
												<label for="" class="col-sm-3 control-label">Name</label>
												<div class="col-sm-9 col-xs-12">
													<input type="text" disabled class="form-control" id="last_name" name="last_name" value="<?php echo $account['first_name'] . ' ' . $account['last_name'];?>">
												</div>
											</div>
											<div class="form-group">
												<label for="" class="col-sm-3 control-label">Phone</label>
												<div class="col-sm-9 col-xs-12">
													<input type="text" disabled class="form-control" id="phone" name="phone" value="<?php echo $account['phone'];?>">
												</div>
											</div>
											<div class="form-group">
												<label for="" class="col-sm-3 control-label">Civil Status</label>
												<div class="col-sm-9 col-xs-12">
													<input type="text" disabled class="form-control" name="civil_status" value="<?php echo $account['civil_status'];?>">
												</div>
											</div>
											<div class="form-group">
												<label for="" class="col-sm-3 control-label">Gender</label>
												<div class="col-sm-9 col-xs-12">
													<div class="radio radio-info radio-inline">
														<input type="radio" disabled id="female" value="0" name="gender" <?php  echo ($account['gender']==0) ? "checked":""; ?>>
														<label for="female"> Female </label>
													</div>
													<div class="radio radio-info radio-inline">
														<input type="radio" disabled id="male" value="1" name="gender" <?php  echo ($account['gender']==1) ? "checked":""; ?>>
														<label for="male"> Male </label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="" class="col-sm-3 control-label">Date of Birth</label>
												<div class="col-sm-9 col-xs-12">
													<input type="text" disabled class="datepicker form-control" name="dob" value="<?php echo ($account['dob'] === '' || $account['dob'] === '0000-00-00') ? '':date('m/d/Y', strtotime($account['dob']));?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php echo form_close() ?>
						</div>
					</div>
				</div>
			</section>
			<!-- #content end -->
			<!-- #content end -->
			<?php $this->load->view('common/footer'); ?>
		</div>
		<!-- #wrapper end -->
		<?php $this->load->view('common/footer_js'); ?>
	</body>
</html>