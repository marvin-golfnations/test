<!DOCTYPE html>
<html dir="ltr" lang="en-US">
	<head>		
		<?php $this->load->view('common/head', array('title' => 'The Farm at San Benito - Medical'));?>  
	</head>
	<body  class="stretched">
		<?php $this->load->view('common/login_form'); ?>
		<!-- Document Wrapper
			============================================= -->
		<div id="wrapper" class="clearfix">
			<?php $this->load->view('common/top'); ?>
			<?php $this->load->view('common/header'); ?>        
			<!-- Page Title
				============================================= -->
			<section id="page-title" class="page-title page-title-dark mild-dark-overlay" \
					 style="background-image: url('<?php echo get_image_url($category['cat_image'])?>');
						background-size: cover; background-position: center top;">
				<div class="container center clearfix">
					<h1 class="serif normal"><?php echo $category['cat_name'];?></h1>
					<span></span>
				</div>
				<div class="floating-pn dark">Call us +632 884 8074</div>
			</section>
			<!-- #page-title end -->
			<!-- Content
				============================================= -->
			<section id="content">
				<div class="content-wrap bgcolor-black notoppadding nobottompadding">
					<div class="section nobottommargin notopmargin toppadding-md nobottompadding bgcolor-grey-light">
						<div class="container">
							<div class="clearfix postcontent">
								<?php echo $category['cat_body'];?>
							</div>
						</div>
					</div>
					<div class="section nobottommargin notopmargin toppadding-md nobottompadding bgcolor-black dark">
						<div class="container">
							<h3 class="handwriting xlarge-font center heading2">Services</h3>
							<div class="postcontent clearfix">
								<div id="posts" class="post-grid post-masonry grid-3 clearfix">
									
									<?php
									
									var_dump($categories);
									?>
									
									<?php foreach ($items as $item) : ?>
									
									<div class="entry clearfix">
										<div class="entry-image nobottommargin"><img src="<?php echo get_image_url($item['item_image'])?>" alt=""></div>
										<div class="toggle toggle-bg" style="border-right:1px solid black;">
											<div class="togglet" style="border:0px"><i class="toggle-closed fa fa-caret-down"></i><i class="toggle-open fa fa-caret-up"></i>
												<?php echo $item['title'];?>
											</div>
											<div class="togglec">
												<p>
													PHP <?php echo $item['amount'];?>++/<?php echo $item['duration'];?> Minutes
												</p>
												<p>
													<?php echo $item['description'];?>
													<a href="#category/<?php echo $category_id;?>/book/<?php echo $item['item_id'];?>" class="btn btn-success">Book Now</a>
												</p>
											</div>
										</div>
									</div>
									
									<?php endforeach; ?>

								</div>
							</div>
						</div>
					</div>
					<div class="section nobottommargin notopmargin toppadding-md bottompadding-md bgcolor dark">
						<div class="container center clearfix">
							<h2 class="serif">Sign up for our Newsletter</h2>
							<p class="bottommargin-sm">Signup for wellness tips, updates and special offers</p>
							<div class="nobottommargin subscribe-center">
								<div class="input-group divcenter" style="width: 50%;">
									<input type="email" id="txtSubscribeEmail" name="txtSubscribeEmail" class="form-control required email" placeholder="Email Address">
									<span class="input-group-btn">
									<button class="button button-small button-reveal button-gradient button-rounded tright button-subscribe" type="button" onclick="subscribeUser();"><span>Subscribe</span> <i class="icon-chevron-right"></i></button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- #content end -->     
			<?php $this->load->view('common/footer'); ?>         
		</div>
		<!-- #wrapper end -->
		<?php $this->load->view('common/footer_js'); ?> 
	</body>
</html>