<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php $this->load->view('common/head', array('title' => 'The Farm at San Benito - Medical')); ?>
	
	<style>
		.formGhq label {
			font-size: 14px;
		}
		
		.formGhq input[type="text"], .formGhq select {
			border: 1px solid #c0c0c0;
		}
		
		.form-horizontal .control-label {
			padding-top: 0;
		}
		
		.form-horizontal .checkbox {
			padding: 0;
		}
		
		.control-label {
			font-weight: bold;
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
	<section id="page-title" class="page-title page-title-dark mild-dark-overlay"
			 style="background-size: cover; background-position: center top; background-image: url(/images/Medical-Questionnaires.jpg)">
		<div class="container center clearfix">
			<h1 class="serif normal"><?php echo $form1['form_name']; ?></h1>
			<span></span>
		</div>
	</section>
	<!-- #page-title end -->
	
	<section id="content">
		
		<div class="content-wrap bgcolor-black notoppadding nobottompadding">
			
			<div class="section nobottommargin notopmargin bottompadding-lg bgcolor-white">
				
				<div class="container-fluid toppadding-sm">
					
					<div class="row">
						
						<div class="col-md-8 col-md-offset-2">							

								<?php

								if (is_logged_in()) :

								echo form_open('backend/entry', array('class' => 'formGhq form-horizontal padding-15 validate'), array('form_id' => $form1['form_id'], 'booking_id' => $booking_id, 'return' => '/ghq', 'entry_id' => $entry_id)); ?>

								<div class="row">
									
									<div class="col-md-6">
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Please chose the statement that BEST
												describes the intentions of your stay:</label>
											<div class="col-sm-7">
												<?php echo form_radio_buttons('field_id_29', array('0' => 'I just want to relax, be cared for and left alone. I want my peace and quiet.', '1' => 'I am interested in taking the necessary steps to achieve a healthier life.', '2' => 'I have issues that are having a negative impact on my health and quality of life. I am seeking help to correct the issues and reverse them.', '3' => 'I want to experience everything that the FARM has to offer.'), (int)$data['field_id_29']); ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Please, indicate your main health
												concern, if any.</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_30']; ?>"
																		 name="field_id_30"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">What are your goals for your stay at
												the Farm?</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_31']; ?>"
																		 name="field_id_31"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Please state the diseases, symptoms,
												or disorders that you are experiencing for the last 6 months:</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_32']; ?>"
																		 name="field_id_32"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Please list medications utilized
												during the course of the past six (6) months. Please, include vitamins
												and dietary supplements.</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_33']; ?>"
																		 name="field_id_33"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Have you undergone surgery in the last
												2 years?</label>
											<div class="col-sm-7">
												<select class="form-control" name="34">
													<option value="0">Yes</option>
													<option value="1">No</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">If yes, please indicate the reason for
												the surgery and the date the surgery was performed.</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_35']; ?>"
																		 name="field_id_35"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Have you had colon hydrotherapy or
												other colon cleansing treatment before?</label>
											<div class="col-sm-7">
												<select class="form-control" name="36">
													<option value="0">Yes</option>
													<option value="1">No</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">If yes, please indicate the date, the
												name of the institution and the country</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control col-xs-12"
																		 value="<?php echo $data['field_id_37']; ?>"
																		 name="field_id_37"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Please, indicate the MAXIMUM duration
												you are able to stay:</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_40']; ?>"
																		 name="field_id_40"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">The Medical Doctors will prescribe the
												duration of the program on the basis of your state of health and the
												health goals you have defined, as well as allowable time away from work
												and family.</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_41']; ?>"
																		 name="field_id_41"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Please, provide information regarding
												any known allergies you may have:</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_42']; ?>"
																		 name="field_id_42"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Do you smoke cigarettes, cigars? How
												often?</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_43']; ?>"
																		 name="field_id_43"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Do you drink alcoholic beverages? How
												often?</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_44']; ?>"
																		 name="field_id_44"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">How many meals do you eat per day?
												What kind of food do you usually eat?</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_45']; ?>"
																		 name="field_id_45"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">What causes your stress?</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_46']; ?>"
																		 name="field_id_46"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">Are there any other concerns or
												information that you wish to add that may assist us in maximizing your
												stay at the Farm?</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_47']; ?>"
																		 name="field_id_47"></div>
										</div>
										
										<div class="form-group">
											<label class="col-xs-12 col-sm-5 control-label">The Farm at San Benito offers a wide
												variety of services and private sessions. Please choose any areas that
												are of interest to you during your stay.</label>
											<div class="col-sm-7 col-xs-12"><input type="text" class="form-control"
																		 value="<?php echo $data['field_id_48']; ?>"
																		 name="field_id_48"></div>
										</div>
									
									</div>
									
									<div class="col-md-6">
										

										<label class="col-xs-12 col-sm-5 control-label">Integrative Medicine</label>
										<div class="col-sm-7">
											
											<?php form_checkboxes('field_id_49', array('Consultation', 'Brain biofeedback Nutritional Microscopy', 'Capillary Scan'), $data['field_id_49']); ?>
											
										</div>

									

										<label class="col-xs-12 col-sm-5 control-label">Body Treatments</label>
										<div class="col-sm-7">
											
											<?php form_checkboxes('field_id_50', array('Massages', 'Aromatherapy', 'Body Scrubs', 'Herbal Wraps', 'Dry Brushing', 'Tibetan Steam Therapy'), $data['field_id_50']); ?>
											
										</div>

									

										<label class="col-xs-12 col-sm-5 control-label">Detoxification</label>
										<div class="col-sm-7">
											
											<?php form_checkboxes('field_id_51', array('Colon Hydrotherapies', 'Wheatgrass Infusion', 'Liver Cleanse', 'Internal Organ Compress', 'Magnetic Clay Foot Bath', 'Body Salt Batch'), $data['field_id_51']); ?>
											
										</div>
										
										<label class="col-xs-12 col-sm-5 control-label">Beauty Treatments</label>
										<div class="col-sm-7">
											
											<?php form_checkboxes('field_id_52', array('Facials', 'Hair Spa', 'Manicure', 'Pedicure'), $data['field_id_52']); ?>
											
										</div>
									
										<label class="col-xs-12 col-sm-5 control-label">Exercise / Movement</label>
										<div class="col-sm-7">
											
											<?php form_checkboxes('field_id_53', array('Yoga', 'Personal Training', 'Power Walk', 'Horticulture Walk', 'Oil of Life Tour'), $data['field_id_53']); ?>
										</div>
									
										<label class="col-xs-12 col-sm-5 control-label">Acupuncture</label>
										<div class="col-sm-7">
											
											<?php form_checkboxes('field_id_54', array('Body Acupuncture', 'Aesthetic Acupuncture', 'Ear Acudetox', 'Ear Acupuncture for Smoking Cessation', 'Weight Loss Acupuncture'), $data['field_id_54']); ?>
											
										</div>
									
										<label class="col-xs-12 col-sm-5 control-label">Healing Energy</label>
										<div class="col-sm-7">
											
											<?php form_checkboxes('field_id_55', array('Acupuncture', 'Reiki', 'Craniosacral Therapy', 'Cranioemotional Release', 'Jin Shin Jyutsu', 'JSJ Harmonizing Flows', 'Psychoemotional Clearing', 'Art Therapy'), $data['field_id_55']); ?>
											
										</div>
									
										<label class="col-xs-12 col-sm-5 control-label">Food</label>
										<div class="col-sm-7">
											<?php form_checkboxes('field_id_56', array('Consultations with a Nutritionist', 'Menu Design', 'Healthy Weight'), $data['field_id_56']); ?>
											
										</div>
									
										<label class="col-xs-12 col-sm-5 control-label">Outdoor activities</label>
										<div class="col-sm-7">
											<?php form_checkboxes('field_id_57', array('Golf', 'Fishing'), $data['field_id_57']); ?>
										</div>
									
										<label class="col-xs-12 col-sm-5 control-label">Kids &amp; Teen Services</label>
										<div class="col-xs-12 col-sm-7">
											<?php form_checkboxes('field_id_58', array('for guests ages less than 17'), $data['field_id_58']); ?>
										</div>
										
									
									</div>
								</div>
								
								<div class="clearfix"></div>
								
								<hr />
								
								<div class="row">
									<div class="col-xs-12 col-sm-7">
										<div class="checkbox">
											<label for="terms_of_services">
											<input type="checkbox" name="terms" id="terms_of_services">
											I have read, understood and agree with the Program Terms and Conditions <a href="http://www.thefarm.com.ph/wp-content/uploads/2012/10/The%20Farm%20-%20Program%20Terms%20and%20Conditions.pdf" target="blank">Read Here</a><br />
											</label>
										</div>
									</div>
									<div class="col-lg-12 col-xs-12">
										<div class="form-group">
											<div class="text-center">
												<button type="submit" class="button button-small button-reveal">Submit <i class="icon-chevron-right"></i></button>
											</div>
										</div>
									</div>
								</div>
								
								
								<?php
								echo form_close();
								else :
									echo 'You need to logged in to access this page.';
								endif;
								?>
							
						
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