		<div class='notifications top-left'></div>
		<div id="unassigned-services">
			<ul class="list-group">
			</ul>
		</div>
		<div id="modal-popup" class="modal fade" role="dialog"></div>
		<!-- Include Date Range Picker -->
		<script type="text/javascript" src="/js/moment.min.js"></script>
		<script type="text/javascript" src="/js/fullcalendar.js"></script>
		<script type="text/javascript" src="/js/scheduler.js"></script>
		<script type="text/javascript" src="/js/bootstrap-notify.js"></script>
		<script type="text/javascript" src="/js/typeahead.js"></script>
		<script type="text/javascript" src="/js/bootstrap-tagsinput.js"></script>
		<script type="text/javascript" src="/js/bootstrap-colorpicker.js"></script>
		<script type="text/javascript" src="/js/summernote/summernote.js"></script>
		<script type="text/javascript" src="/js/bootstrap-filestyle.js"></script>
		<script type="text/javascript" src="/js/bootstrap-select.js"></script>
		<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
		<script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
		<script type="text/javascript" src="/js/jquery.multi-select.js"></script>
		<script type="text/javascript" src="/js/bootstrap-timepicker.js"></script>
		<script type="text/javascript" src="/js/jquery.validate.js"></script>
		<script type="text/javascript" src="/js/bootbox.min.js"></script>
		<script type="text/javascript" src="/js/BootSideMenu.js"></script>
		<script type="text/javascript" src="/js/jquery.playSound.js"></script>
		<script type="text/javascript" src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
		<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="/js/common.js"></script>
		<!-- Inline JS-->
		<script type="text/javascript">
		TF.now = function() {
			return moment.unix(<?php echo now(); ?>);
		};
		TF.baseURL = '<?php echo site_url('backend');?>/';
		TF.dateFormat = 'MM/DD/YYYY';
		<?php if (isset($inline_js) && $inline_js) : ?>
		
		<?php foreach (array_keys($inline_js) as $var): ?>
		<?php echo 'TF.'. $var . ' = ' . json_encode($inline_js[$var]). ';'."\n"?>
		<?php endforeach; ?>
		<?php endif; ?>
		</script>
		<script type="text/javascript">
			
			var get_unassigned_events = function(init){					
				$.getJSON(TF.baseURL + 'calendar/unassigned_events', {}, function(data){
					var ul = $('#unassigned-services').find('.list-group');
					var unassigned_events = new Array();
					
					for(var event in data) {
						
						var assigned_events = new Array();
						
						if (data[event].guest_name !== null) {
							
							unassigned_events.push(parseInt(data[event].event_id));
							
							//check if event already in the lists.
							if (ul.find('li#event-'+data[event].event_id).length === 0) {							
								var start = moment(data[event].start);
								var end = moment(data[event].end);
								var title = '<strong class="list-group-item-heading">'+data[event].guest_name+'</strong><br />';
								title += '<span class="text-muted">'+data[event].item_name + '</span><br /><span class="text-muted">'+start.format('MMMD h:mma')+' - ' + end.format('MMMD h:mma')+'</span>';
								
								var item = $('<li class="list-group-item" id="event-'+data[event].event_id+'"><a href="#">'+title+'</a> <span class="label label-success">'+data[event].status+'</span></li>');
								item.data('event', data[event]);
								item.on('click', function(){
									renderPopup($(this).data('event'));
								});
								
								item.appendTo(ul);
								
								if (init === false) {
									$.playSound('/knock');
									item.hide().fadeIn(2000);
									$.notify({message : data[event].guest_name + ' just made a booking.'}, {type: 'success'});
									
									//update calendar
									if ($('#calendar').length > 0) {
										$('#calendar').fullCalendar('refectchEvents');
									}
								}
							}
						}
					}	
					
					ul.find('li:first').addClass('active');
					
					//loop through the list 
					var lists = ul.find('li');
					for(var i=0; i<lists.length; i++) {
						var event = $(lists[i]).data('event');
						var event_id = event.event_id;
						if ($.inArray(parseInt(event_id), unassigned_events) === -1) {
							ul.find('li#event-'+event_id).fadeOut();
						}
					}
										
				}).always(function(){
					setTimeout('get_unassigned_events(false)', 1000*6);
				});
			}
			
			$(document).ready(function(){
				
				$('.btn-toggle').click(function() {
					
					var btn = $(this).find('.btn');
					
					btn.toggleClass('active');  
				    
				    if ($(this).find('.btn-primary').size()>0) {
				    	btn.toggleClass('btn-primary');
				    }
				    if ($(this).find('.btn-danger').size()>0) {
				    	btn.toggleClass('btn-danger');
				    }
				    if ($(this).find('.btn-success').size()>0) {
				    	btn.toggleClass('btn-success');
				    }
				    if ($(this).find('.btn-info').size()>0) {
				    	btn.toggleClass('btn-info');
				    }
				    btn.toggleClass('btn-default');
				       
				});
				
				$('.multiselect').multiSelect();
				
				$('.btn-active').on('click', function(){
					var val = $(this).attr('data-value');
					var id = $(this).attr('data-id');
					val = val === 'Yes' ? 'y' : 'n';
					$.post(TF.baseURL+'account/activate', {contact_id:id, status: val}, function(data){
						$.notify({
							message: data.message 
						},{
							type: 'success'
						});
					}, 'json');
				});
				
				$('.btn-approve').on('click', function(){
					var val = $(this).attr('data-value');
					var id = $(this).attr('data-id');
					val = val === 'Yes' ? 'y' : 'n';
					$.post(TF.baseURL+'account/approve', {contact_id:id, status: val}, function(data){
						$.notify({
							message: data.message 
						},{
							type: 'success'
						});
					}, 'json');
				});
				
				$('.btn-verify').on('click', function(){
					var val = $(this).attr('data-value');
					var id = $(this).attr('data-id');
					val = val === 'Yes' ? 'y' : 'n';
					$.post(TF.baseURL+'account/verify', {contact_id:id, status: val}, function(data){
						$.notify({
							message: data.message 
						},{
							type: 'success'
						});
					}, 'json');
				});
				
				$('#schedule-providers').on('change', function(){
				    var week = $('input[name="week"]').val();
					window.location = TF.baseURL + 'schedule/view/'+this.value+'/'+week;
			    });
			    
			    $('.table-in-house-guests').DataTable({
				    info: false
			    });
				
				$('.dataTable').DataTable();
				
				
				$('.view-guest').each(function(){
					$(this).on('click', function(evt){
						evt.preventDefault();
						var url = $(this).attr('href');
						$('#guest-modal').load(url, function(){
							
						});
					});
				});
				
				$('#settings').on('click', function(){
					var offset = $(this).offset();
					$('.windowSettings').show();
					$('.windowSettings').css('left', (offset.left-210)+'px');
				});
				
				$('#close-calendar-settings').on('click', function(){
					$('.windowSettings').hide();
				});
				
				$('#update-calendar-settings').on('click', function(){
					$.ajax({
					    url: TF.baseURL + 'calendar/update_views',
			            type: 'post',
			            data: {
			              selected_positions : TF.selected_positions,
			              selected_statuses : TF.selected_statuses,
			              selected_locations : TF.selected_locations,
			              show_no_schedule : TF.show_no_schedule,
			              show_my_appointments : TF.show_my_appointments
			            }
				    });
					$('.windowSettings').hide();
				});
				
								
				$('.btn-save-form-entry').on('click', function(evt){
					evt.preventDefault();
					
					var _form = $(this).parents('form').first();

					$(_form).validate({
					  submitHandler: function(form) {

					  }
					});
				});
				
				$('.typeahead').typeahead({
					minLength: 3,
					highlight: true,
					hint: true
				},
				{                  
					name: 'contacts',
				    source: function(query, syncResults, asyncResults) {
				      	$.get(TF.baseURL+'/contacts/json', 'keyword='+query, function(data) {
					      	asyncResults(data);
					    }, 'json');
				    },
				    templates: {
						suggestion: function(output) {
				            return '<div>' + '<i class="fa fa-user"></i> ' + output.first_name + ' '  + output.last_name + '</div>';
				        },
					}
				});
				
				$('.typeahead').bind('typeahead:select', function(ev, suggestion) {
					window.location = TF.baseURL + '/account/edit/' + suggestion.contact_id;
				});
				
				$('.typeahead').bind('typeahead:cursorchange', function(ev, suggestion) {
					$('.typeahead').typeahead('val', suggestion.first_name + ' '  + suggestion.last_name);
				});
				
				$('.btn-save-form-entry').on('click', function(evt){
					var form = $(this).parents('form');
					
					$.post(form.attr('action'), form.serializeArray(), function(data){
						$.notify({
							message: data.message
						},{
							type: 'success'
						});
					}, 'json');
				});

				
				
				get_unassigned_events(true);
				
				$('#unassigned-services').BootSideMenu({side:"right"});
				
				var get_cart = function() {
					$.ajax({
						url: TF.baseURL + 'frontend/get_cart',
						success: function(data) {
							$('#cart-count').html(data.total_items);
						}
					});
				}
				
				
				$('.btn-add-to-cart').each(function(){
					$(this).on('click', function(){
						
						if ($(this).hasClass('btn-primary')) {	
							$(this).removeClass('btn-primary');
							$(this).addClass('btn-success');
							$(this).html('<i class="fa fa-check"></i> Added');
							
							var data = {
								item_id : $(this).attr('data-item-id'),
								name : $(this).attr('data-name'),
								price : $(this).attr('data-price'),
								booking_id : TF.booking_id
							};
							
							$.ajax({
								url: TF.baseURL + 'frontend/add_to_cart',
								data: data,
								type: 'post',
								success: function(data) {
									get_cart();
								}
							})
						}
						else {
							$(this).removeClass('btn-success');
							$(this).addClass('btn-primary');
							$(this).html('<i class="fa fa-plus"></i>');
						}
					});
				});
				
				<?php if ($message = $this->session->flashdata('message')) : ?>
				$.notify({
					// options
					message: '<?php echo $message;?>' 
				},{
					// settings
					type: 'success'
				});
				<?php endif; ?>
				
			});
		</script>
		<script src="/js/calendar.js" type="text/javascript"></script>
