

<!DOCTYPE html>

<html dir="ltr" lang="en-US">
<head><?php $this->load->view('common/head', array('title' => 'The Farm at San Benito - '.$package_type['package_type_name']));?>
    
</head>
<body  class="stretched">

<?php $this->load->view('common/login_form'); ?>
<?php $this->load->view('common/select_date'); ?>

   <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
    
    
    
    
    	<?php $this->load->view('common/top'); ?>
		<?php $this->load->view('common/header'); ?>  


        

        

        <!-- Page Title
        ============================================= -->
        <section id="page-title" class="page-title page-title-dark mild-dark-overlay" style="background-image: url('<?php echo get_image_url($package_type['package_image'])?>'); 
        background-size: cover; background-position: center top;">

            <div class="container center clearfix">
                <h1 class="serif normal">The Farm <?php echo $package_type['package_type_name'];?></h1>
            </div>
            
        </section><!-- #page-title end -->


            
        
        <!-- Content
        ============================================= -->
        <section id="content">
            <div class="content-wrap bgcolor-black notoppadding nobottompadding">
                

		<div class="section nobottommargin notopmargin toppadding-sm nobottompadding bgcolor-grey-light">                                                          
        	<div class="container">
          
            	<div class="clearfix postcontent">
                    <div class="entry clearfix"><div class="row" style="color: rgb(51, 51, 51); font-family: Georgia, &quot;Times New Roman&quot;, &quot;Bitstream Charter&quot;, Times, serif; font-size: 16px; line-height: 24px;">
	<div class="col-md-8">
		<?php echo $package_type['description']?>
	</div>
</div>
<div class="row" style="color: rgb(51, 51, 51); font-family: Georgia, &quot;Times New Roman&quot;, &quot;Bitstream Charter&quot;, Times, serif; font-size: 16px; line-height: 24px;">
	<div class="col-md-8 col-md-offset-2">
		<p class="sect sect-inline">
			Package Inclusions</p>
				
		<div class="table-responsive">
			<table class="table table-pricing table-double mce-item-table" style="border: 1px dashed rgb(187, 187, 187);">
				<thead>
					<tr>
						<th style="font-family: inherit; font-size: 18px; border: 1px dashed rgb(187, 187, 187);">
							Inclusion</th>
						<?php foreach ($durations as $package_id => $duration):?>	
						<th style="font-family: inherit; font-size: 18px; border: 1px dashed rgb(187, 187, 187);">
							<?php echo $duration;?> Nights
							<a href="#<?php echo 'retreats/book/'.$package_id;?>" data-package_id="<?php echo $package_id;?>" data-duration="<?php echo $duration-1;?>" data-toggle="modal" data-target="#<?php if (!$this->session->userdata('user_id')) : ?>login-modal<?php else:?>select-date-modal<?php endif;?>">Book Now</a>
						</th>
						<?php endforeach;?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $category_name => $_items) : ?>
					<tr class="shaded">
						<td colspan="3" style="font-family: inherit; font-size: inherit; border: 1px dashed rgb(187, 187, 187);">
							<strong><?php echo $category_name;?></strong></td>
					</tr>
					
					<?php foreach ($_items as $item_id => $item_name) : ?>
					<tr>
						<td style="font-family: inherit; border: 1px dashed rgb(187, 187, 187);">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $item_name;?></td>
						
						<?php foreach ($durations as $package_id => $duration):?>	
						<td style="font-family: inherit; border: 1px dashed rgb(187, 187, 187);">
							<?php if (isset($packages[$package_id][$item_id])) : ?>
								<?php echo $packages[$package_id][$item_id];?> Session 
							<?php else : ?>
								--
							<?php endif; ?>
						</td>
						<?php endforeach;?>	
							
					</tr>
					<?php endforeach;?>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="alt">
			<div class="row">
				<div class="col-md-12">
					<h3>
						Terms and Conditions:</h3>
					<ul class="list-regular">
						<li>
							Rates are subject to 10% Service Charge and 12% Government Tax.</li>
						<li>
							Private car transfers are available to &amp; from Manila International Airport at Php 9,000++ round trip for a maximum of 3 persons. Travel time is only 90-minute drive to or from The Farm.</li>
						<li>
							Additional guests will incur a surcharge of PHP 2,500++ per night which includes a gourmet breakfast at ALIVE! Restaurant &ndash; not applicable in Sulu Terrace and Palmera Suite</li>
						<li>
							Children aged 12 years and under stay at The Farm for free when sharing a room with adults (meals are not included) &ndash; not applicable in Sulu Terrace</li>
						<li>
							Rates &amp; Inclusions are subject to change without prior notice.</li>
						<li>
							Cancellation Policy Applies.</li>
						<li>
							Published Rates valid from January 1, 2016 to December 31, 2016.</li>
						<li>
							Please note that foreign currency values are subject to change, The Farm will use the prevailing &ldquo;Hotel Exchange Rate of the Day&rdquo; on the date of payment.</li>
					</ul>
				</div>
				<div class="col-md-12">
					<h3>
						Important Notes for The Farm Wellness Experience Program:</h3>
					<ul class="list-regular">
						<li>
							Programs may be created for any number of nights requested.</li>
						<li>
							All Programs are supervised by licensed Medical Doctors and Nurses.</li>
						<li>
							All Programs are considered supportive to natural body balancing with final results dependent on a variety of factors which The Farm cannot take full responsibility in managing.</li>
						<li>
							Guests who require special medical support for serious health challenges must advise and communicate openly to The Farm&rsquo;s Medical Staff. The Farm reserves the right to refuse some guests with health conditions that cannot be reasonably managed by The Farm&rsquo;s professional staff.</li>
						<li>
							Guests arriving at The Farm after 5pm will be booked in on a special Room Only arrangement for their first night. The actual Program will begin the following day.</li>
						<li>
							Programs can change in accordance to and consultation with the guest&rsquo;s medical &amp; wellbeing condition. The Guest Health Questionnaire should be filled in and submitted at least one week prior to arrival at The Farm.</li>
						<li>
							A personalized Daily Schedule will be given to each guest after consultation with an assigned Medical Staff. The Schedule may change depending on our Medical Doctor&rsquo;s assessment and recommendation or in accordance with the guest&rsquo;s reactions to the treatments.</li>
						<li>
							All supplements, services and treatments will be scheduled by our doctors on the General Health &amp; Medical consultation has been completed. Any supplements, services or treatments or other such related items outside the above stated Personalized Program will be discussed with the guest in advance and will be considered Incidental Charges. These will be charged to the guest account and must be settled upon checkout.</li>
						<li>
							All programs containing medical, spa and food components cannot be refunded or credited if not utilized.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</div><div class="panel panel-default events-meta"><div class="panel-body"><ul class="iconlist nobottommargin" style="color:black;"><li><i class="icon-file"></i> <a href="uploads/a4972788-9621-43f8-8809-e1180b3488ab_Farm-Wellness-Experience.pdf" target="_blank">Download package and rates</a></li><li><i class="icon-book"></i> <a href="http://phfarmwh.webhotel.microsapdc.com/bp/search_rooms.jsp" target="_blank">Make reservation</a></li><li><i class="icon-line-mail"></i> <a href="contact.aspx">Contact Us</a></li></ul></div></div>
                </div>

            </div>       
        </div> 


       	<div class="section nobottommargin notopmargin notoppadding bottompadding-md bgcolor-black dark">                                                          
            
             <div class="container toppadding-md center">

                    <h3 class="handwriting xlarge-font heading2">Other Retreat Packages</h3>
                    <div class="clearfix bottommargin-sm"></div>
                    <?php $i = 1; ?>
					<?php foreach ($package_types as $row): ?>
					
					<div class="col_half <?php echo $i % 2 === 0 ? 'col_last' : ''?>">
						<div class="feature-box fbox-center fbox-effect clearfix">
							<h3 class="serif">
								The Farm <?php echo $row['package_type_name']; ?>
							</h3>
							<div id="effect-4">
								<figure>
									<a href="<?php echo site_url('retreats/packages/'.$row['package_type_id']);?>">
										<img src="<?php echo get_image_url($row['package_image'])?>">
									</a>
									<figcaption>
										<span class="serif" style="line-height:22px" align="left">  
										<?php echo $row['description'];?>
										</span><br>
										<a href="<?php echo site_url('retreats/packages/'.$row['package_type_id']);?>" class="button button-small button-white button-reveal tright"><span>Read more</span> <i class="icon-chevron-right"></i></a>
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

    </div><!-- #wrapper end -->

    <?php $this->load->view('common/footer_js'); ?> 

</body>
</html>
