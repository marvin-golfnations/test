<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<?php $this->load->view('admin/_common/head', array('title' => 'Forms')); ?>
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

							<nav class="navbar navbar-default">
		                        <div class="container-fluid">
			                        
			                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				                        
				                        <ul class="nav navbar-nav">
									        <li class="dropdown">
									          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										          <?php echo $form_name === '' ? 'New' : $form_name;?> Settings</a>
									          
									        </li>
									      </ul>
									      
			                        </div>
		                        </div>
		                        
	                        </nav>


<div class="container-fluid ">

	<div id="main">
		<!-- Nav tabs -->
		<div role="tabpanel">
			<?php echo form_open('backend/form', '', array('id' => $form_id)); ?>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Form Name
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						<div class="form-group">
							<?php echo form_input('form_name', $form_name, 'class="form-control"'); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							Fields
						</a>
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						<div class="form-group form-group-sm">
							<div class="input-group">
								<?php echo form_dropdown('all_fields', $all_fields, '', 'class="form-control"'); ?>
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" id="add-field-to-form"><i class="fa fa-plus"></i> </button>
								</span>
							</div>
						</div>
						<ul class="list-group sortable" id="form-fields">
							<?php if (isset($form_fields)) : ?>
							<?php foreach ($form_fields as $field) : ?>
							<li class="list-group-item" id="field-id-<?php echo $field['field_id'];?>">
								<span class="fa fa-sort"></span> <?php echo $field['field_label'] . form_hidden('form_fields['.$field['field_id'].'][field_id]', $field['field_id']);?>
								<span class="pull-right">
								<a class="delete-field" href="#"><i class="fa fa-trash-o"></i></a>&nbsp;
								</span>
								<span class="pull-right">
								<?php echo form_checkbox('form_fields['.$field['field_id'].'][guest_only]', 'y', $field['guest_only'] === 'y');?>Guest Only&nbsp;
								</span>
							</li>
							<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#headingThree" aria-expanded="true" aria-controls="collapseOne">
							Form HTML
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
						<div class="form-group">
							<?php echo form_textarea('form_html', $form_html, 'class="form-control"'); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo form_submit('', 'Save Changes', 'class="btn btn-primary"'); ?>
				</div>
			</div>


			<?php echo form_close();?>
		</div>

		<div class="sidebar right-side" id="right-sidebar">

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