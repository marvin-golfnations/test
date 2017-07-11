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
			<section id="page-title" class="page-title page-title-dark mild-dark-overlay" style="background-image: url('uploads/724a127a-4412-4367-a26c-583d40c3c5ae_healing.jpg'); 
				background-size: cover; background-position: center top;">
				<div class="container center clearfix">
					<h1 class="serif normal">Healing Santuary SPA Treatments</h1>
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
								<h3 class="handwriting xlarge-font center heading1">Cleansing your body</h3>
								<div class="entry clearfix">
									<p>
	The Farm at San Benito has everything you need in an award-winning retreat destination. Our rich, indulgent treatments will surely soothe you &ndash; its rejuvenating effects reaching your very soul.</p>
<p>
	All therapies directly support the healing of the body by removing toxins from within the tissues and organs by providing nourishment through the skin, restoring energy balance, and decreasing the body&rsquo;s pH levels. The Sanctuary offers an extensive menu of signature Filipino, Asian, and European massages, scrubs and treatments.The products we use are 100% natural and organic, and made fresh for each treatment. We produce our own fresh coconut milk, virgin coconut oil, coconut fiber, coffee, and cocoa. The dominating feature of the Sanctuary is an infinity pool with a majestic view of Mount Malarayat. This grand panorama stands in stark contrast to the womb-like private massage pavilions, each located within their own gardens and water features. The Sanctuary provides a peaceful and private atmosphere designed to enable our guests to relax and heal, and temporarily forget the world around them. Two Thai massage pavilions overlook the swimming pool and a unique Massage Under The Stars is available in the evenings for that perfect romantic nightcap.</p>

								</div>
							</div>
						</div>
					</div>
					<div class="section nobottommargin notopmargin toppadding-md nobottompadding bgcolor-black dark">
						<div class="container">
							<h3 class="handwriting xlarge-font center heading2">Signature Treatments</h3>
							<div class="postcontent clearfix">
								<div id="posts" class="post-grid post-masonry grid-3 clearfix">
									
									<?php foreach ($items as $item) : ?>
									
									<div class="entry clearfix">
										<div class="entry-image nobottommargin"><img src="/images/noimage.jpg" alt=""></div>
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
													<a href="#medical/book/<?php echo $item['item_id'];?>" class="btn btn-success">Book Now</a>
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