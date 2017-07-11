<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Contacts')); ?>
</head>
<body class="">
<section class="vbox">
	<?php $this->load->view('admin/_common/header'); ?>
	<section>
		<section class="hbox stretch">
			<section id="content">
				<section class="vbox">
					<section class="scrollable bg-white">
						<div class="content">
							
							<div class="container-fluid ">
								
								<div id="main">
									<div class="page-header">
										<h1></h1>
									</div>
									<div role="tabpanel" class="tabbable tabs-primary">
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active">
												<a href="#week" aria-controls="week" role="tab" data-toggle="tab">
													Weekly Schedule</a>
											</li>
											<!--
											<li>
												<a href="#special" aria-controls="special" role="tab" data-toggle="tab">
												Special days schedule
												</a>
											</li>
											-->
										</ul>
										<!-- Tab panes -->
										<div class="tab-content tab-content-default">
											<!--
                <div class="tab-pane" id="special">

                    <?php echo form_dropdown('providers', $providers, $contact_id, 'id="schedule-providers"'); ?>

                    <hr />

                    <div class="row">

                    <?php
											
											$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
											$current_month = date('n');
											$current_year = date('Y');
											$current_day = date('d');
											$month = 0;
											
											for ($m = 0; $m < count($months); $m++) {
												echo '<div class="col-lg-3">';
												echo '<div class="text-center label-success bold text-uppercase">' . $months[$m] . '</div>';
												echo draw_calendar($m + 1, $current_year);
												echo '</div>';
											}
											
											?>

                    </div>

                </div>
                -->
											<div role="tabpanel" class="tab-pane active" id="week">
												<?php echo form_dropdown('providers', $providers, $contact_id, 'id="schedule-providers"'); ?>
												<?php echo form_open('backend/schedule/update', '', array('contact_id' => $contact_id, 'week' => $week)); ?>
												<?php echo $this->weeklycalendar->showCalendar(); ?>
												<?php echo form_submit('', 'Save Changes', 'class="btn btn-primary"'); ?>
												<?php echo form_close(); ?>
											</div>
										</div>
									</div>
								
								</div>
							</div>
						</div>
					</section>
				</section>
			</section>
		</section>
	</section>
</section>
<?php $this->view('admin/_common/footer_js'); ?>
</body>
</html>