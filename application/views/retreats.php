<!DOCTYPE html>
<html dir="ltr" lang="en-US">
	<head>
		<?php $this->load->view('common/head', array('title' => 'The Farm at San Benito - Retreats'));?>
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
			<section id="page-title" class="page-title page-title-dark mild-dark-overlay" style="background-image: url('http://thefarmatsanbenito.com.iis3002.shared-servers.com/uploads/8e7ce287-a453-4935-9703-b1e9b48e1bba_spa.jpg'); 
				background-size: cover; background-position: center top;">
				<div class="container center clearfix">
					<h1 class="serif normal">Retreats</h1>
					<span>The Farm at San Benito, a unique Wellness Center, has the perfect retreat that your body seeks.</span>
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
								<h3 class="handwriting xlarge-font center heading1">Experience Wellness</h3>
								<div class="entry clearfix">
									<p>
										The Farm&rsquo;s signature programs provide certified professional guidance to achieve and sustain optimal physical health, emotional well-being, along with spiritual growth. Our natural body detoxification techniques reduce toxins, boost overall immunity, encourage mental clarity leading to improved lifestyle habits, and can have a profound impact on better understanding interpersonal relationships.
									</p>
									<p>
										1. reduce toxins, boost overall immunity
									</p>
									<p>
										2. encourage mental clarity leading to improved lifestyle habits
									</p>
									<p>
										3. can have a profound impact on better understanding interpersonal relationships.
									</p>
									<p>
										Our Wellness program is intended to offer a full immersion into The Farm&rsquo;s philosophy and practice of optimal health. This multi-faceted program includes professional guidance, signature Massage &amp; Spa Therapy, three full meals of quality &ldquo;live&rdquo; cuisine per day, along with a range of optional Fitness &amp; Spiritual Development sessions.
									</p>
									<p>
										All programs are highly personalized, and individually formulated for each guest. All guests complete a Guest Health Questionnaire which allows us to personally customize your program based on your specific needs, goals, and state of health. Based on your Medical Intake profile, our medical doctors will suggest a treatment plan with a proposed number of days to address your health-related goals, with consideration of your current state of health.
									</p>
									<p>
										Should you have a limited period for completing your program, kindly indicate this in the Guest Health Questionnaire to ensure achievable goals. Your Personalized Daily Schedule will be completed after your personal consultation with our medical staff after arrival.
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="section nobottommargin notopmargin notoppadding bottompadding-md bgcolor-black dark">
						<div class="container toppadding-md center">
							<h3 class="handwriting xlarge-font heading2">Retreat Packages</h3>
							<div class="clearfix bottommargin-sm"></div>
							<?php $i = 1; ?>
							<?php foreach ($package_types as $package_type): ?>
							
							<div class="col_half <?php echo $i % 2 === 0 ? 'col_last' : ''?>">
								<div class="feature-box fbox-center fbox-effect clearfix">
									<h3 class="serif">
										The Farm <?php echo $package_type['package_type_name']; ?>
									</h3>
									<div id="effect-4">
										<figure>
											<a href="<?php echo site_url('retreats/packages/'.$package_type['package_type_id']);?>">												
												<img src="<?php echo get_image_url($package_type['package_image'])?>" />
											</a>
											<figcaption>
												<span class="serif" style="line-height:22px" align="left">  
												<?php echo substr(strip_tags($package_type['description']), 0, 300);?>...
												</span><br>
												<a href="<?php echo site_url('retreats/packages/'.$package_type['package_type_id']);?>" class="button button-small button-white button-reveal tright"><span>Read more</span> <i class="icon-chevron-right"></i></a>
											</figcaption>
										</figure>
									</div>
								</div>
							</div>
							<?php $i++;?>
							<?php endforeach; ?>
							
						</div>
					</div>
					<div class="section nobottommargin notopmargin toppadding-md bottompadding-md bgcolor dark">
						<div class="container center clearfix">
							<h2 class="serif">Sign up for our Newsletter</h2>
							<p class="bottommargin-sm">Signup for wellness tips, updates and special offers</p>
							<div class="nobottommargin subscribe-center">
								<div class="input-group divcenter" style="width:50%;">                                            
									<input type="email" id="txtSubscribeEmail" name="txtSubscribeEmail" class="form-control required email" placeholder="Email Address">
									<span class="input-group-btn"><button class="button button-small button-reveal button-gradient button-rounded tright button-subscribe" type="button" onclick="subscribeUser();"><span>Subscribe</span> <i class="icon-chevron-right"></i></button></span>
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