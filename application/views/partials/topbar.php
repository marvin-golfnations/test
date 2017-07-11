<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<input type="hidden" name="__current_user__" value="<?php echo get_current_user_id(); ?>" />
			<button type="button" class="navbar-toggle visible-xs visible-sm collapsed pull-left" id="showLeftPush">
				<i class="md md-menu"></i>
			</button>
			<a class="navbar-brand" href="<?php echo site_url();?>">
				<img src="<?php echo '/images/logo_main.png'?>" style="display: inline;" /></a>
			<button type="button" class="navbar-toggle pull-right" id="showRightPush">
				<i class="md md-more-vert"></i>
			</button>
		</div>
		<div class="hidden-xs">

			<ul class="nav navbar-nav navbar-right">
				<li class="active dropdown">
					<button class="btn btn-default navbar-btn btn-rounded"  data-toggle="dropdown">
						<i class="md md-notifications"></i>
					</button>
					
					<div class="dropdown-menu dropdown-caret dropdown-caret-right  width-300">
						<div class="dropdown-padding dropdown-headline">
							<div class="media dropdown-head">
								<div class="media-body media-middle">
									<h4 class="">Notifications <small class="bold text-muted" id="notification_count"></small></h4>
								</div>
								<div class="media-right media-middle">
									<a href="#" class="text-muted"><i class="md md-list"></i></a>
								</div>
							</div>
						</div>
						<div class="dropdown-padding" id="notifications">
							
						</div>
						<div class="dropdown-padding text-center">
							<a href="#">View all</a>
						</div>
					</div>
				</li>
				<?php if (is_admin()) : ?>
				<li class="dropdown">
					<button class="btn btn-default-light navbar-btn btn-rounded"  data-toggle="dropdown">
						<i class="md md-location-searching"></i>
					</button>
					<ul class="dropdown-menu dropdown-caret dropdown-caret-right dropdown-menu-auto">
						<?php
						$locations = get_locations();
						foreach ($locations as $id => $location): ?>
						<li><a href="<?php echo site_url('location/change/'.$id);?>"><?php echo $location;?><?php if ($this->session->userdata('location_id') === $id) : ?> <span class="glyphicon glyphicon-ok check-mark"></span><?php endif; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endif; ?>
				<li>
					<a href="#" class="user" id="showUserPush">
						<?php echo img(array('src' => get_current_user_photo(), 'class' => 'img-circle border-white', 'width' => 40));?>
					</a>
				</li>
				
			</ul>
		</div>
	</div>
</nav>

<?php if (isset($_SESSION['message']) && $_SESSION['message']) : ?>
<div id="notification" data-position="top-right" class="display-none">
	<?php echo $this->session->flashdata('message'); ?>
</div>
<?php endif; ?>