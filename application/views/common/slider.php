<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="false" id="bs-carousel">
  <!-- Overlay -->
  <div class="overlay"></div>

  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#bs-carousel" data-slide-to="1"></li>
    <?php if (!$this->session->userdata('user_id')) : ?>
    <li data-target="#bs-carousel" data-slide-to="2"></li>
    <?php endif; ?>
  </ol>
  
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item slides active row">
      <div class="slide-1"></div>
      <div class="hero col-lg-4 col-md-6 col-xs-10">
        <hgroup>
            <h3 class="serif">Welcome to the Farm at San Benito</h3>      
			<p>
				The Farm at San Benito is a health and wellness resort where guests can embark on a holistic
				healing journey 
				to balance mind, body and spirit. It is the sole sanctuary of its kind in the Philippines
				and one of the best in 
				the world. The Farm offer transformative retreats which enables its guests to cope with the
				ever-increasing 
				stress-filled challenges of everyday life through a well-managed and tailored wellness
				programs for 
				restoration of balance and harmony by encouraging a commitment to a proactive healthy
				lifestyle.
			</p>
        </hgroup>
        <a role="button" class="btn-text" href="http://www.thefarmatsanbenito.com/">Learn more about us <i class="iglyphicon glyphicon-chevron-right"></i></a>
      </div>
    </div>
    
    <div class="item slides row">
      <div class="slide-2"></div>
      <div class="hero col-lg-4 col-md-6 col-xs-10">        
        <hgroup>
            <h3 class="serif">The Farm Health Programmes</h3>        
            <p>We offer the following health programmes that are highly customizable depending on your goals and concerns: <br />
	            <ul class="list-unstyled">
		            <li>The Farm Wellness Experience</li>
		            <li>Eat Clean, Live Well (mindful eating)</li>
		            <li>Detox Cleanse Weight Management</li>
		            <li>Mindy and Body Restoration</li>
		            <li>Beauty and Vitality Rejuvenation</li>
		            <li>Sports Recovery and Regeneration</li>
	            </ul>
			</p>
        </hgroup>       
        <a class="btn-text" role="button" href="http://www.thefarmatsanbenito.com/retreats-2/">Click here to learn more about our Programmes <i class="glyphicon glyphicon-chevron-right"></i></a>
      </div>
    </div>
    <?php if (!$this->session->userdata('user_id')) : ?>
    <div class="item slides row">
      <div class="slide-3"></div>
      <div class="hero col-lg-4 col-md-6 col-xs-10">        
        <hgroup>       
	        <div class="loginmodal-container" style="background-color: #fff;"> 
            <p class="text-center"><img src="/images/logo_med.png" /></p>
			<p class="serif hidden-xs">This digital platform enables you to book or modify your schedule of<br /> treatments while with us at The Farm</p>
		  <?php echo form_open('login/submit', array(), array('return' => $return)); ?>
			<input type="text" name="username" placeholder="Username" class="required col-xs-12 col-lg-12">
			<input type="password" name="password" placeholder="Password" class="required col-xs-12 col-lg-12">
			<input type="submit" name="login" class="login loginmodal-submit" value="Login" style="background-color: #68b044">
		  <?php echo form_close(); ?>
			
		  	<div class="login-help text-center">
			<a href="#" data-toggle="modal" data-target="#register-modal">Register</a>
		  	</div>
	        </div>
        </hgroup>       
      </div>
    </div>
    <?php endif; ?>
  </div> 
</div>