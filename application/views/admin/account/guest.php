<!doctype html>
<html>
<head>
	<?php $this->view('partials/head',array('title'=>'Account')); ?>
	
</head>
<body class="sidebar-push">
  
	<?php $this->view('partials/topbar'); ?>
	
	<?php $this->view('partials/sidebar'); ?>

	

  <div class="container-fluid ">

<div id="main">
	<div class="page-header">
		<h2 class="serif"><?php echo $account['first_name'] . ' ' . $account['last_name']; ?></h2>
	</div>
	<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#account" aria-controls="account" role="tab" data-toggle="tab">
					<i class="fa fa-fw fa-user"></i> Profile</a>
			</li>

			<?php if (isset($forms) && $forms) : ?>
			<?php foreach ($forms as $form) : ?>
			<li role="presentation">
				<a href="#form-<?php echo $form['form_id'];?>" aria-controls="form-<?php echo $form['form_id'];?>" role="tab" data-toggle="tab"><?php echo ($form['required']==='y' ? '* ' : '') . $form['form_name'];?></a>
			</li>
			<?php endforeach ?>
			<?php endif; ?>
			<?php if (($group_id && $group_id === 5) || $group_id === null) : ?>
			<li role="presentation">
				<a href="#bookings" aria-controls="bookings" role="tab" data-toggle="tab">Bookings</a>
			</li>
			<?php endif; ?>
		</ul>
		
		<!-- Tab panes -->
		<div class="tab-content tab-content-default">
			<div role="tabpanel" class="tab-pane active" id="account">

				<?php $this->view('account/info', array('account' => $account)); ?>
				
			</div>
			<?php if (isset($forms) && $forms) : ?>
				<?php foreach ($forms as $form) : ?>
					<div role="tabpanel" class="tab-pane" id="form-<?php echo $form['form_id'];?>">

					<h4><?php echo $form['form_name']; ?></h4>
					<?php echo form_open('entry', array('class' => 'form-horizontal padding-15 validate'), array('form_id' => $form['form_id'], 'booking_id' => $booking_id)); ?>
					<?php

					$value = booking_form_entries($booking_id, $form['form_id']);

					if ($value) {
						echo form_hidden('entry_id', $value['entry_id']);
					}
					echo '<div class="form-group">';
					$this->formbuilder->build($form['field_ids'], $value);
					echo '</div>';
					?>
					<hr />

					<div class="form-group">
						<div class="checkbox"><input type="checkbox" class="required" id="confirm-<?php echo $form['form_id'];?>" name="confirm[<?php echo $form['form_id'];?>]">
						<label for="confirm-<?php echo $form['form_id'];?>">I hereby certify that the above information given are true and correct as to the best of my knowledge.</label>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Continue</button>
					</div>
					<?php echo form_close(); ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>


			<div role="tabpanel" class="tab-pane" id="bookings">
				<h4 class="headline">Recent & Previous Bookings</h4>
				<div class="table-responsive">
					<table class="table table-striped table-condensed">
						<thead>
						<tr class="text-uppercase ">
							<th>Program</th>
							<th>Status</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($bookings as $booking) : ?>
							<tr>
								<td>
									<?php echo $booking['title'];?>
									<div class="text-muted">
										<?php if (isset($booking['start_date']) && isset($booking['end_date'])) : ?>
											<?php echo date('m/d/Y', $booking['start_date']) . ' to ' . date('m/d/Y', $booking['end_date']) ;?>
										<?php endif; ?>
									</div>
								</td>
								<td>
									<?php echo $statuses[$booking['status']]?>
								</td>
							</tr>
						<?php endforeach ;?>
						</tbody>
					</table>
				</div>
			</div>

		</div>

	</div>
</div>

	 <?php $this->view('partials/footer'); ?>
  </div>


  <div class="overlay-disabled"></div>
  
  <?php $this->view('admin/_common/footer_js', array('inline_js' => isset($inline_js) ? $inline_js : false)); ?>
</body>
</html>