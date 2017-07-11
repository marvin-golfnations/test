		<?php
		
		$return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		?>
		
		<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" style="display: none;">
    	  <div class="modal-dialog">
				<div class="loginmodal-container" style="background-color: #fff">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p class="text-center"><img src="/images/logo_med.png" /></p>
					<h1 class="serif hidden-xs">e-program/e-platform enables you to book or modify your schedule of
treatments while with us at The Farm</h1><br>
				  <?php echo form_open('login/submit', array('name' => "login-form", 'ajax' => true, 'class' => "validate"), array('return' => $return)); ?>
					<input type="text" name="username" placeholder="Username" class="required col-xs-12 col-lg-12">
					<input type="password" name="password" placeholder="Password" class="required col-xs-12 col-lg-12">
					<input type="submit" name="login" class="login loginmodal-submit" value="Login" style="background-color: #68b044">
				  <?php echo form_close(); ?>
					
				  <div class="login-help text-center">
					<a href="#" data-toggle="modal" data-target="#register-modal">Register</a>
				  </div>
				</div>
			</div>
		</div>
		
		<?php
		$q = $this->db->get_where('contacts', array('contact_id' => $this->session->userdata('user_id')));
		$result = $q->row_array();
		if ($result['active'] === 'n') : 
		?>
		
		<div class="modal fade" id="activation-modal" tabindex="-1" role="dialog" aria-labelledby="Activation" aria-hidden="true" style="display: none;">
    	  <div class="modal-dialog">
				<div class="loginmodal-container" style="background-color: #fff">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <?php echo form_open('activate', array(), array('return' => $return)); ?>
					<input type="text" name="activation_code" placeholder="Enter Activation Code" tabindex="1" style="letter-spacing: 3px; font-size: 30px; height: 50px">
					<input type="submit" name="login" class="login loginmodal-submit" value="Submit" style="background-color: #68b044">
				  <?php echo form_close(); ?>
					
				</div>
			</div>
		</div>
		
		<?php endif; ?>
		
		<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="Register" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="loginmodal-container" style="background-color: #fff">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p class="text-center"><img src="/images/logo_med.png" /></p>
					<h1 class="serif">Create Your Account</h1><br>
					<?php echo form_open('register/submit',array('id'=>'form-validation'), array('return' => $return)); ?>
					<div class="row" style="margin-left: 0; margin-right: 0;">
					<input type="text" name="first_name" required id="first_name" placeholder="First Name" class="required col-xs-12 col-lg-4">
					<input type="text" name="last_name" required placeholder="Last Name" class="required col-xs-12 col-lg-4">
					<input type="text" name="middle_name" placeholder="Middle Name" class=" col-xs-12 col-lg-4">
					</div>
					<input type="text" name="phone" required placeholder="Mobile Number" class="required col-xs-12 col-lg-12">
					<label>Date of Birth</label><br />
					<select name="dob-month" class="required col-xs-4 col-lg-4">
						<option value="">Month</option>
						<option value="01">Jan</option>
						<option value="02">Feb</option>
						<option value="03">Mar</option>
						<option value="04">Apr</option>
						<option value="05">May</option>
						<option value="06">Jun</option>
						<option value="07">Jul</option>
						<option value="08">Aug</option>
						<option value="09">Sep</option>
						<option value="10">Oct</option>
						<option value="11">Nov</option>
						<option value="12">Dec</option>
					</select>
					<select name="dob-day" class="required col-xs-4 col-lg-4">
						<option value="">Day</option>
						<?php for($i=1; $i<32;$i++) {
						echo '<option value="'.($i<10?'0'.$i:$i).'">'.($i<10?'0'.$i:$i).'</option>';	
						}?>
					</select>
					<select name="dob-year" class="required col-xs-4 col-lg-4">
						<option value="">Year</option>
					<?php for($i=1900;$i<=date('Y');$i++) {
						echo '<option value="'.$i.'">'.$i.'</option>';	
					}
					?>
					</select><br />
					<input type="text" name="place_of_birth" required placeholder="Place of Birth" class="required col-xs-12 col-lg-12">
					<input type="text" name="email" required autocomplete="off" placeholder="Email" class="required email col-xs-12 col-lg-6">
					<input type="password" name="password" required autocomplete="off" placeholder="Password" class="required col-xs-12 col-lg-6">
					
					<div class="clearfix"></div>
					
<!-- 					<input type="radio" required="" name="gender" value="F"> Female <input type="radio" required="" name="gender" value="M"> Male  -->
					<p class="login-help"><input type="checkbox" name="agree" class="required"> I hereby certify that the above information given are true and correct as to the best of my knowledge.</p>
					<hr />

					<div style="text-align: center"><button type="submit" name="signupButton" class="btn btn-primary"> Signup </button> or
					<a href="#<?php //echo $this->facebook->login_url()?>" class="btn btn-default btn-rounded"><i class="fa fa-facebook fa-fw"></i> Signup with Facebook</a>
					<?php echo form_close(); ?>
					</div>
				
				</div>
			</div>
		</div>