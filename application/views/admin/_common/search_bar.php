							<nav class="navbar navbar-default">
		                        <div class="container-fluid">
			                        
			                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				                        
				                        <ul class="nav navbar-nav">
									        <li class="dropdown">
									          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										          <?php echo $title?> <span class="caret"></span></a>
										          
										          <?php if (current_user_can('can_admin_providers')) : ?>
										          <ul class="dropdown-menu">
										            <li><a href="<?php echo site_url('backend/account/edit').$qstr; ?>"><i class="fa fa-plus"></i> Add Guest</a></li>
										          </ul>
										          <?php endif;?>
									        </li>
									      </ul>
									      
					                    <?php echo form_open('backend/contacts/'.strtolower($title), array('class' => 'navbar-form navbar-right form-inline filter', 'method' => 'GET')); ?>    
					                    	
					                    	
					                    	<?php if ($title === 'Guest') : ?>
					                    	
					                    	<div class="form-group">
						                    	<label>Day of Stay</label>
						                    	<?php echo form_input('', '', array('class' => 'form-control daterange', 'style' => 'width:200px')); ?>
						                    	
						                    	<?php echo form_hidden('booking_start'); ?>
						                    	<?php echo form_hidden('booking_end'); ?>
					                    	</div>
					                    	
					                    	<?php endif; ?>
					                    
									        <div class="form-group">
									          <?php echo form_input('keyword', $this->input->get_post('keyword'), array('class' => 'form-control typeahead', 'placeholder' => 'Search by Name or Email')); ?>
									        </div>
									        <button type="submit" class="btn btn-default">Search</button>
									    <?php echo form_close(); ?>
			                        </div>
		                        </div>
		                        
	                        </nav>