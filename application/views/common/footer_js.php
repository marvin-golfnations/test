	<!-- Footer Scripts -->
    <script type="text/javascript" src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/themes/encore/js/functions.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/themes/encore/js/modernizr.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.validation/1.15.1/additional-methods.js"></script>
	
	<script src="/js/fullcalendar-3.0.1/fullcalendar.js"></script>
	<script src="/js/bootstrap-notify.js"></script>
	<script src="/js/bootbox.min.js"></script>
    <script src="/js/sweetalert.js"></script>
    <script src="/js/jquery.form.js"></script>
	<script src="/js/fileinput/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
	<script src="/js/fileinput/fileinput.min.js"></script>

	<!-- Inline JS-->
	<script type="application/javascript">
	var TF = {};
	TF.now = function() {
		return moment.unix(<?php echo now(); ?>);
	};
	TF.is_logged = '<?php echo $this->session->userdata('group_id') ?>';
	TF.baseURL = '<?php echo site_url();?>';
	TF.dateFormat = 'MM/DD/YYYY';
	<?php if (isset($inline_js) && $inline_js) : ?>
	
	<?php foreach (array_keys($inline_js) as $var): ?>
	<?php echo 'TF.'. $var . ' = ' . json_encode($inline_js[$var]). ';'."\n"?>
	<?php endforeach; ?>
	<?php endif; ?>
	</script>
	
	<!-- Random Backgrounds -->
	<script src="http://thefarmatsanbenito.com.iis3002.shared-servers.com/themes/encore/js/rand.bg.js"></script> 
	<script>
	    $(".randbg").RandBG();
	</script>
    

    <script type="text/javascript">

		var getMessages = function (recieved, always) {
			var user_id = $('input[name="__current_user__"]').val();
			$.getJSON(TF.baseURL+'messages/json', {current_user: user_id, recieved: recieved}, function(data) {
				var notifications = $('#notifications');
				if (data.length > 0) {

					if (recieved == 'n') {
//						createSnackbar('You have a new message!', 'Dismiss');
//						$('#notification_count').text('('+data.length + ' new)');
//						$.notify(data[i].message);
					}

					for (i = 0; i < data.length; i++) {
						$.notify(data[i].message);
//						var message = '<div class="notification-block body-bg">' +
//							'<span classd="notification-icon orange"><i class="md md-comment"></i></span>' +
//							'<span class="notification-content">' + data[i].message + '</span>' +
//							'<small>' + data[i].sent + '</small>' +
//							'</div>';
//						notifications.append(message);
					}
				}
			}).always(function(){
				if (always){
					setTimeout('getMessages("'+recieved+'", '+always+')', 1000*10);
				}
			});
		}

        $(document).ready(function () {

            if ($('form[name="login-form"]').length > 0) {
                $('form[name="login-form"]').validate({
                    submitHandler: function (form) {
                        $(form).ajaxSubmit({
                            dataType: 'json',
                            success: function (data) {
                                if (data.Error) alert(data.Message);
                                else window.location = data.Redirect;
                            }
                        });
                    }
                });
            }

            var avatar = TF.avatar ? TF.avatar : '/images/avatars/default_avatar_male.jpg';

			$("#avatar").fileinput({
				overwriteInitial: true,
				maxFileSize: 0,
				showClose: false,
				showCaption: false,
				browseLabel: '',
				showUpload: false,
				removeLabel: '',
				browseIcon: '<i class="fa fa-folder-open"></i>',
				removeIcon: '<i class="fa fa-trash-o"></i>',
				removeTitle: 'Cancel or reset changes',
				elErrorContainer: '#kv-avatar-errors-1',
				msgErrorClass: 'alert alert-block alert-danger',
				defaultPreviewContent: '<img src="'+avatar+'" alt="Your Avatar" style="width:160px">',
				layoutTemplates: {
				    main2: '{preview} {remove} {browse}',
                    actions: '{upload}',
                    actionUpload: '<button type="button" class="kv-file-upload btn btn-default" title="{uploadTitle}"><i class="fa fa-upload"></i> Upload</button>\n'
				},
				allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
                uploadUrl: '/frontend/upload_photo/<?php echo $this->session->userdata('user_id');?>',
				uploadAsync: false
			});

			getMessages(0, true);
	        
	        $('.formGhq').validate({
			  	submitHandler: function(form) {
				  	
				  	if ($('input[name="terms"]:checked').length === 0) {
					  	$.notify('You must agree to the terms of services to continue.', 'warning');
					  	return false;
				  	}
				  	
				  	bootbox.confirm({ 
					  	size: "small",
					  	message: "Are you sure you want to proceed?", 
					  	callback: function(result){
						  	if (result) {
							  	form.submit();
						  	}
					  	}
				})
			  }
			});
	        	        
	        $('input[name="calendar-cat-id"]').on('change', function(e){
		       TF.categories = this.value.split(',');
		        $('#calendar').fullCalendar('refetchEvents');
	        });
	        
	        $('.btn-join-now').each(function(){
				$(this).on('click', function(evt){
					evt.preventDefault();
					
					var url = $(this).attr('href');
					var data = {
						start : $(this).attr('data-start'),
						end : $(this).attr('data-end'),
						item_id : $(this).attr('data-item_id'),
						facility_id : $(this).attr('data-facility_id'),
						booking_id : TF.booking_id
					}
					$.ajax({
						url : url,
						data : data,
						type : 'post',
						dataType: 'json',
						success: function(output){
							if (typeof output.errors !== 'undefined') {
								$.notify({
									message: output.errors
								},{
									type: 'warning'
								});
							}
							else {
								$.notify({
									message: output.message
								},{
									type: 'success'
								});
							}
						}
					});
				});
			});
	        
	        $('#calendar').fullCalendar({
		        defaultView : TF.defaultView,
		        header :TF.header,
		        eventLimit: false,
		        height: 'auto',
		        navLinks: true,
		        minTime: TF.minTime,
				maxTime: TF.maxTime,
		        eventSources: [
	                {
	                    url : TF.baseURL+'backend/calendar/json/'+TF.booking_id,
	                    type: 'post',
	                    cache: true,
	                    data: function(){
	                        var params = new Object();
	                        params.show_my_appointments = TF.show_my_appointments;
	                        params.show_guest_name = TF.showGuestName;
	                        params.resource_field_id = TF.resource_field_id;
	                        params.show_facility = TF.showFacility;
	                        params.abbreviate = TF.abbreviate;
	                        params.categories = TF.categories;
	                        if (TF.guest_id) params.guest_id = TF.guest_id;
	                        return params;
	                    }
	                }
	            ],
				eventClick: function(event, jsEvent, view) {

					jQuery('#popup-modal').modal('show');
					jQuery('#popup-modal').load('/frontend/rebook/'+event.event_id);

				},
	            dayClick: function (date, jsEvent, view) {
				    $(".fc-highlight").popover({
				        title: 'haha',
				        placement: 'right',
				        content: 'haha',
				        html: true,
				        container: 'body'
				    });
				    $(".fc-highlight").popover('show');
				}
	        });
	        
			var get_available_time = function(form){
		
				var data = {
					booking_id : form.find('input[name="booking_id"]').val(),
					item_id : form.find('input[name="item_id"]').val(),
					date : form.find('select[name="date"]').val(),
					duration : form.find('input[name="duration"]').val()
				}
		
				form.find('select[name="time"]').attr('disabled', 'disabled');
		
				$.ajax({
					url: '/frontend/get_available_time',
					data : data,
					dataType: 'json',
					success : function (time_array) {
						form.find('select[name="time"]').empty();

						var originalTime = form.find('input[name="original_time"]').val();

						console.log(originalTime);
				
						for(time in time_array) {

							var selected = '';
							if (time === originalTime) {
								selected = ' selected="selected"';
							}

							form.find('select[name="time"]').append('<option value="'+time+'"'+selected+'>'+time_array[time]+'</option>');
						}
				
						form.find('select[name="time"]').removeAttr('disabled');
					}
				});
			};
	
	
			$("#owl-awards").owlCarousel({
                //Autoplay
                items: 5,
                autoPlay: true,
                stopOnHover: false
            });
	
			$('.btn-popup').each(function(){
				$(this).on('click', function(evt){
					evt.preventDefault();
					var url = $(this).attr('href');
			
					var modal = $('#popup-modal');
					modal.load(url, {},  function(){
						get_available_time(modal.find('form'));
				
						modal.find('select[name="date"]').on('change', function(){
							get_available_time(modal.find('form'));
						});

						modal.find('button[name="add-service-confirm"]').on('click', function(){
							modal.find('form#add-service-form').validate({
								rules: {
									time: {required: true},
									date: {required: true}
								},
								messages: {
									time: {
										required: "Please select time"
									},
									date: {
										required: "Please select date"
									}
								},
								submitHandler: function(form) {

									var start = jQuery(':input[name="date"] option:selected').val() + ' ' + jQuery(':input[name="time"] option:selected').val();
									var endTime = moment(start, 'YYYY-MM-DD HH:mm:ss');
									var startTime = moment();
									var hoursDiff = endTime.diff(startTime, 'hours');

									if (hoursDiff <= 0) {
										swal('Invalid time.');
										return;
									}

									if (hoursDiff > 0 && hoursDiff < 5) {
										swal({
												title: "Are you sure?",
												text: "Additional charges will apply!",
												type: "warning",
												showCancelButton: true,
												confirmButtonClass: "btn-danger",
												confirmButtonText: "Yes, Continue!",
												closeOnConfirm: false
											},
											function(){
												$.post( $(form).attr('action'), $(form).serialize(), function( output ) {
													if (output.errors) {
														swal('Opps', output.errors[0], 'error');
													}
													else {
														location.reload();
													}
												}, 'json');
											});
										return;
									}
									$.post( $(form).attr('action'), $(form).serialize(), function( output ) {
										if (output.errors) {
											swal('Opps', output.errors[0], 'error');
										}
										else {
											location.reload();
										}
									}, 'json');
							  }
							});
						});
				
					});
				});
			});
	
			$('p.title').on('click', function(e){
				e.preventDefault();
				var parent = $(this).parents('li');
				parent.toggleClass('open');
				var desc = parent.find('.amenity-desc');
				desc.slideToggle(400);
			});

			$('form#form-validation').validate();
	
			$('#select-date-modal').on('shown.bs.modal', function (e) {
				
				var target = $(e.relatedTarget);
				var duration = target.attr('data-duration');
				var package_id = target.attr('data-package_id');
				var url = target.attr('href');
				var start_date = moment();
				var end_date = moment().add(parseInt(duration), 'day');
				window.location.hash = url.substring(1);
				
				$('#package_id').val(package_id);
				$('#select-date').daterangepicker({
					"showDropdowns": true,
					"autoApply": false,
					"dateLimit": {
						"days": duration
					},
					"minDate":moment(),
					"parentEl":"#select-date-modal",
					"alwaysShowCalendars": true,
					"startDate":start_date,
					"endDate":end_date
				}, function(start, end, label) {
					$('#start_date').val(start.format('YYYY-MM-DD'));
					$('#end_date').val(end.format('YYYY-MM-DD'));
				});
			});
			
			<?php if ($message = $this->session->flashdata('message')) : ?>
			$.notify('<?php echo $message;?>', 'success');
			<?php endif; ?>

        });

    </script>   