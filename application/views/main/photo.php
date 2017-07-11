<div class="wrapper-lg bg-light">
	<div class="hbox">
		<aside class="aside-md">
			<div class="text-center">
				<?php echo img(array('src' => get_current_user_photo(), 'class' => 'img-circle m-b')); ?>
			</div>
		</aside>
		<aside>
			<p class="pull-right m-l inline"> <a href="#" class="btn btn-sm btn-icon btn-info rounded m-b"><i class="fa fa-twitter"></i></a> <a href="#" class="btn btn-sm btn-icon btn-primary rounded m-b"><i class="fa fa-facebook"></i></a> <a href="#" class="btn btn-sm btn-icon btn-danger rounded m-b"><i class="fa fa-google-plus"></i></a> </p>
			<h3 class="font-bold m-b-none m-t-none" style="color:#fff"><?php echo $this->session->userdata('screen_name');?></h3>
			<p style="color:#fff"><?php echo $this->session->userdata('email');?></p>
			<?php if ($this->session->userdata('position')) : ?><p><i class="fa fa-lg fa-circle-o text-primary m-r-sm"></i><strong><?php echo $this->session->userdata('position');?></strong></p><?php endif;?>
		</aside>
	</div>
</div>