<!doctype html>
<html>
<head>
	
	<?php $this->view('admin/_common/head',array('title'=>'Login')); ?>
	<script>
		var TF = {};
	</script>
	<style type="text/css">
		body {
			padding-top: 60px;
			padding-bottom: 40px;
			background-color: #fff;
		}
	</style>
</head>
<body>
  <div class="container-fluid">
      
<div id="main">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login">

				<div class="logo text-center" href="#"><img src="<?php echo '/images/logo_med.png'?>"/></div>

				<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

				<?php if ($message = $this->session->flashdata('message')) : ?>
				<div class="alert alert-info"><?php echo $message;?></div>
				<?php endif; ?>
				
				<div class="panel panel-default panel-shadow">
					<?php $return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''; ?>
						<?php echo form_open('login/submit',array('id'=>'form-validation')); ?>
						<div class="panel-body">
							<div class="form-group">
								<label for="exampleInputEmail1">Username</label>
								<input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter Username">
							</div>
							<div class="form-group margin-none">
								<div class="media">
									<div class="media-body media-middle">
										<label for="exampleInputPassword1">Password</label>
									</div>
									<div class="media-right media-middle">
										<a href="#" class="small pull-right">Forgot?</a>
									</div>
								</div>
								<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
							</div>
						</div>
						<div class="form-group text-center">
							<button type="submit" class="btn btn-success">Login <i class="md md-lock-open"></i></button><br />
							<!--
							Not yet a member ? <a href="<?php echo site_url('register')?>">Register now</a>
							-->
							<!--<a href="<?php echo site_url('register')?>" class="small pull-middle">Sign up</a>-->
						</div>
						<?php echo form_close(); ?>
				</div>
				<!--
				<div class="text-center">
					<p class="text-muted">or login with</p>
					<a href="<?php echo $this->facebook->login_url()?>" class="btn btn-default btn-rounded"><i class="fa fa-facebook fa-fw"></i></a>
				</div>
				-->
			</div>
		</div>
	</div>
</div>
  </div>
		
  <?php $this->view('admin/_common/footer_js'); ?>
	
</body>
</html>