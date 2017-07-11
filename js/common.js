(function ($) {
    "use strict";

    /**
     * jQuery plugin wrapper for compatibility with Angular UI.Utils: jQuery Passthrough
     */
    $.fn.tkSummernote = function () {

        if (! this.length) return;

        if (typeof $.fn.summernote != 'undefined') {

            this.summernote({
                height: 100
            });

        }

    };

    $(function () {
        $('.summernote').each(function () {
            $(this).tkSummernote();
        });
    });

})(jQuery);

(function ($){

    $('.filestyle').filestyle({
        input:false,
        icon:false,
        buttonText:'Upload',
        buttonName:'btn btn-sm btn-success'
    });

    $('form.validate').validate({

    });

    var eltPrimary = $('[data-role="tagsinput tag-primary"]');
    eltPrimary.tagsinput({
        tagClass: 'label label-primary'
    });

    var eltDefault = $('[data-role="tagsinput tag-default"]');
    eltDefault.tagsinput({
        tagClass: 'label label-default'
    });

    var eltDanger = $('[data-role="tagsinput tag-danger"]');
    eltDanger.tagsinput({
        tagClass: 'label label-danger'
    });

}(jQuery));

(function ($) {
	"use strict";
	
	/**
	 * jQuery plugin wrapper for compatibility with Angular UI.Utils: jQuery Passthrough
	 */
	$.fn.blueDatePicker = function () {
		
		if (! this.length) return;
		
		if (typeof $.fn.datepicker != 'undefined') {
			
			this.datepicker();
			
		}
		
	};
	
	$('.datepicker').blueDatePicker();
	
	
	$.fn.blueTimePicker = function () {
		
		if (! this.length) return;
		
		if (typeof $.fn.datepicker != 'undefined') {
			
			this.timepicker({
				minuteStep: 5,
				showInputs: false,
				disableFocus: true
			});
			
		}
		
	};
	
	
	
})(jQuery);

function getMessages(recieved, always) {
	var user_id = $('input[name="__current_user__"]').val();
	$.getJSON(TF.baseURL+'messages/json', {current_user: user_id, recieved: recieved}, function(data) {
		var notifications = $('#notifications');
		if (data.length > 0) {
			
			if (recieved == 'n') {
				createSnackbar('You have a new message!', 'Dismiss');
				$('#notification_count').text('('+data.length + ' new)');
			}
			
			for (i = 0; i < data.length; i++) {
				var message = '<div class="notification-block body-bg">' +
					'<span classd="notification-icon orange"><i class="md md-comment"></i></span>' +
					'<span class="notification-content">' + data[i].message + '</span>' +
					'<small>' + data[i].sent + '</small>' +
					'</div>';
				notifications.append(message);
			}
		}
	}).always(function(){
		if (always){
			setTimeout('getMessages("'+recieved+'", '+always+')', 1000*60);
		}
	});
}

$(document).ready(function(){
	
	var checkbox = function(id, name, checked) {
        return '<div class="checkbox checkbox-success checkbox-inline">'+
            '<input id="'+id+'" name="'+name+'" type="checkbox"'+(checked ? ' checked="checked"' : '') + ' value="1">'+
            '<label for="'+id+'">Yes</label>'+
            '</div>';
    }
	
	$('[data-toggle="modal"]').on('click', function(evt){
		evt.preventDefault();
		var target = $(this).attr('data-target');
		var url = $(this).attr('href');
		$(target).load(url, function(){
			
			var modalform = $(target);

			modalform.find('input[name="personalized"]').on('click', function(){
				if (!this.checked) {
					modalform.find('input[id*="package_items_"]').attr('readonly', 'readonly');
				}
				else {
					modalform.find('input[id*="package_items_"]').removeAttr('readonly');
				}
			});
			
			modalform.find('.summernote').each(function () {
				$(this).tkSummernote();
			});
			
			modalform.find('form[ajax="true"]').each(function(){
				$(this).submit(function(evt){
					evt.preventDefault();
				});
			});

			modalform.find('#facility-bg-colorpicker').colorpicker();
			
			modalform.find('.datepicker').blueDatePicker();
			modalform.find('.timepicker').blueTimePicker();
			modalform.find('[data-toggle="tree"]').each(function () {
				$(this).tkFancyTree();
			});
			
			modalform.find('a.btn-confirm').each(function(){
				$(this).on('click', function(evt){
					evt.preventDefault();
					var title = $(this).attr('title');
					var url = $(this).attr('href');
					var current_url = window.location;
					
					title = (typeof title === 'undefined' ? 'Confirm?' : title);
					
					bootbox.confirm(title, function(result) {
						if (result) {
							window.location = url+'?confirm=y&return='+encodeURIComponent(current_url);
						}
					});
				})
			});
			
			modalform.find('button.btn-add-alacarte').each(function(){
				$(this).on('click', function(){
					var item_id = modalform.find('select[name="items"] option:selected').val();
					var text = modalform.find('select[name="items"] option:selected').text();
					
					if (item_id > 0) {
						
						var newTr = modalform.find('table.item-packages').find('tbody tr');
						var newId = 'new-'+(newTr.length+1);
						
						modalform.find('table.item-packages').find('tbody').append(
							'<tr class="new">' +
							'<td><input name="package_items['+newId+'][item_id]" type="hidden" value="'+item_id+'">' + text + '</td>' +
							'<td><input value="1" placeholder="Session or Set" name="package_items['+newId+'][qty]" type="text" class="form-control"></td>' +
							'<td>'+checkbox('package_items_'+newId+'_included', 'package_items['+newId+'][included]', false)+'</td>' +
							'<td>'+checkbox('package_items_'+newId+'_foc', 'package_items['+newId+'][foc]', false)+'</td>' +
							'<td>'+checkbox('package_items_'+newId+'_upsell', 'package_items['+newId+'][upsell]', false)+'</td>' +
							'<td>'+checkbox('package_items_'+newId+'_upgrade', 'package_items['+newId+'][upgrade]', false)+'</td>' +
							'<td><button type="button" class="btn btn-xs btn-delete-item"><i class="fa fa-trash"></i></button></td>' +
							'</tr>'
						);
						
						modalform.find('button.btn-delete-item').on('click', function () {
							$(this).parents('tr').first().remove();
						})
					}
				})
			});
			
			modalform.find('button.btn-add-item').each(function(){
				$(this).on('click', function(){
					var id = modalform.find('select[name="items"] option:selected').val();
					var text = modalform.find('select[name="items"] option:selected').text();
					modalform.find('table.item-packages').find('tbody').append(
						'<tr>' +
						'<td>'+text+'</td>' +
						'<td><input placeholder="Session or Set" value="1" name="package_items['+id+']" type="text" class="form-control"></td>' +
						'<td><button type="button" class="btn btn-xs btn-delete-item"><i class="fa fa-trash"></i></button></td>' +
						'</tr>'
					);
					
					modalform.find('button.btn-delete-item').on('click', function(){
						$(this).parents('tr').first().remove();
					})
					
				})
			});

			modalform.find('input[name="start_date"]').datepicker({
				onSelect: function(dateText) {
					var package = $('select[name="packages"] option:selected');
					var duration = package.attr('data-duration');

					if (duration === undefined) {
						duration = 0;
					}
					var end_date = moment(dateText).add(duration, 'days');
					$('input[name="end_date"]').val(end_date.format(TF.dateFormat));
				}}
			);

			modalform.find('input[name="end_date"]').datepicker();

			modalform.find('select[name="packages"]').on('change', function(){
				var duration = parseInt(modalform.find('select[name="packages"] option:selected').attr('data-duration'));
				if (duration === undefined) {
					duration = 0;
				}
				var start_date = moment(modalform.find('input[name="start_date"]').val());
				modalform.find('input[name="end_date"]').val(start_date.add(duration, 'day').format(TF.dateFormat));
			});
			
			modalform.find('.package-items-qty').on('blur', function(){
				var qty = parseInt($(this).val());
				var originalQty = parseInt($(this).attr('data-original_qty'));
				
				if (qty > originalQty) {					
					$(this).next().removeAttr('disabled');
					var i = parseInt($(this).next().val());
					$(this).attr('data-original_qty', qty);
					$(this).next().val(i+(qty - originalQty));
				}
				
			});
			
			modalform.find('button.btn-select-package').each(function(){
				$(this).on('click', function(){
					
					var package_id = modalform.find('select[name="packages"] option:selected').val();
					var package_name = modalform.find('select[name="packages"] option:selected').text();
					var duration = parseInt(modalform.find('select[name="packages"] option:selected').attr('data-duration'));
					
					if (package_id.length === 0) {
						alert('Please select program.');
						return;
					}

					var start_date = moment(modalform.find('input[name="start_date"]').val());

					modalform.find('div.booking-details').removeClass('hidden');
					modalform.find('input[name="package_id"]').val(package_id);
					modalform.find('input[name="title"]').val(package_name);
					modalform.find('input[name="start_date"]').val(start_date.format(TF.dateFormat));
					modalform.find('input[name="end_date"]').val(start_date.add(duration, 'day').format(TF.dateFormat));
					
					$.getJSON(TF.baseURL+'/package/json/'+package_id, function(output){
						
						var ids = new Array();
						modalform.find('table.item-packages').find('tbody').empty();
						for(var i=0; i<output.length;i++) {
							var item_id = output[i].item_id;
							var text = output[i].title;
							var qty = output[i].quantity;
							
							var id = 'new-'+(i+1);
							
							ids.push(item_id);
							modalform.find('table.item-packages').find('tbody').append(
								'<tr>' +
								'<td><input name="package_items['+id+'][item_id]" type="hidden" value="'+item_id+'">'+text+'</td>' +
								'<td><input name="package_items['+id+'][qty]" type="text" class="form-control" value="'+qty+'"></td>' +
								'<td>'+checkbox('package_items_'+id+'_included', 'package_items['+id+'][included]', true)+'</td>' +
								'<td>'+checkbox('package_items_'+id+'_foc', 'package_items['+id+'][foc]', false)+'</td>' +
								'<td>'+checkbox('package_items_'+id+'_upsell', 'package_items['+id+'][upsell]', false)+'</td>' +
								'<td>'+checkbox('package_items_'+id+'_upgrade', 'package_items['+id+'][upgrade]', false)+'</td>' +
								'<td><button type="button" class="btn btn-xs btn-delete-item"><i class="fa fa-close"></i></button></td>' +
								'</tr>'
							);
							
							modalform.find('button.btn-delete-item').on('click', function(){
								$(this).parents('tr').first().remove();
							});
						}
						
						$.getJSON(TF.baseURL+'/service/related_forms/', {'ids' : ids.join('|')}, function(output){
							$('#forms-tab').removeClass('disabled');
							for(var i=0; i<output.length;i++) {
								// $('#related_forms').append(
								//     '<input name="booking_forms[]" type="checkbox" checked="checked" value="'+output[i].form_id+'"> ' + output[i].form_name + '<br />'
								// );
							}
						});
						
						
					});
					
				})
			});

			modalform.find('button[name="save-booking"]').on('click', function(evt){
				var form = $(this).parents('form')[0];
				$(form).validate({
					rules: {
						start_date: {required: true},
						end_date: {required: true},
                        packages: {required:true}
					},
					messages: {
						start_date: {
							required: "Start date is required."
						},
						end_date: {
							required: "End date is required."
						},
                        packages: {
						    required: "Please select program."
                        }
					},
					submitHandler: function(form) {


						// btn-select-package

						form.submit();
					}
				});
			});
			
			modalform.find('button.btn-delete-item').on('click', function(){
				console.log($(this).parents('tr'));
				$(this).parents('tr').first().remove();
			});
			
			modalform.find('select#colorselector').each(function(){
				$(this).colorselector({
					callback: function(value, color, title) {
						$('input[name="bg_color"]').val(value);
					}
				});
			});
			
			modalform.find('input[name="personalized"]').on('click', function(evt){
				if (this.checked) {
					$('div#personalized-n').addClass('hidden');
					$('div#personalized-y').removeClass('hidden');

                    var package_name = $('select[name="packages"]').find('option:selected').text();
                    if (package_name === '-Select-') {
                        package_name = '';
                    }
					
					$('input[name="title"]').val(TF.guest_name + ' ' + package_name);
					
				}
				else {
					
					$('input[name="title"]').val($('select[name="packages"]').find('option:selected').text());
					$('div#personalized-y').addClass('hidden');
					$('div#personalized-n').removeClass('hidden');
				}
			});


			
			/*
			 var c = $(this);
			 console.log(c);
			 c.colorpickerplus();
			 c.on('changeColor', function(e){
			 console.log(e.color);
			 if(e.color==null)
			 $(this).val('transparent').css('background-color', '#fff');
			 else
			 $(this).val(e.color).css('background-color', e.color);
			 });*/
			//});
			
			
			var tagInput = modalform.find('[data-role="tagsinput tag-primary"]').tagsinput({
				tagClass: 'label label-primary',
				allowDuplicates: false,
				itemValue: 'id',  // this will be used to set id of tag
				itemText: 'text' // this will be used to set text of tag
			});
			
			modalform.find('.selectpicker').on('change', function(){
				modalform.find('[data-role="tagsinput tag-primary"]').tagsinput('add', { id: this.value, text: $(this).text() });
			});
			
			modalform.find('.filestyle').filestyle({
				input:false,
				icon:false,
				buttonText:'<span class="glyphicon glyphicon-plus"></span> <span class="hidden-xs">Upload</span>',
				buttonName:'btn btn-sm btn-success'
			});
			
			modalform.find('.btn-delete-file').each(function(){
				$(this).on('click', function(evt){
					evt.preventDefault();
					bootbox.confirm("Are you sure?", function(result) {
						console.log(true);
					});
				})
			});
			
			modalform.find('form.validate').validate();
			
			modalform.find('select[name="field_type"]').each(function(){
				
				$(this).on('change', function(){
					$('.field_type_settings').hide();
					$('.field_type_settings').find(':input').attr('disabled');
					$('#field_type_'+this.value).show();
					$('#field_type_'+this.value).find(':input').removeAttr('disabled');
					
				});
				
			});
			
			modalform.find('input[name*="field_ids"]').each(function(){
				$(this).on('click', function(){
					
					var checked = $(this).is(':checked');
					var parent = $(this).parents('ul#all_fields');
					
					if (checked) {
						var selected = $(this).parents('li');
						var id = selected.find('input[name*="field_ids"]').attr('value');
						
						$('ul#field_ids').append('<li id="field_id-'+id+'"><i class="fa fa-sort" style="cursor: pointer"></i> '+selected.html()+'</li>');
						$('ul#field_ids').find(':input').on('click', function(){
							if (!checked) {
								var selected1 = $(this).parents('li');
								$('ul#all_fields').append('<li>'+selected1.html()+'</li>');
								selected1.remove();
							}
						});
						$('ul#field_ids').find(':input').attr('checked', 'checked');
						selected.remove();
					}
					else {
						var selected = $(this).parents('li');
						selected.find('i.fa').remove();
						$('ul#all_fields').append('<li>'+selected.html()+'</li>').find(':input').removeAttr('checked');
						selected.remove();
					}
				});
			});
			
			//http://stackoverflow.com/questions/26525739/boostrap-multiselect-select-all-checked-by-default
			modalform.find('select.multi-select').each(function(){
				$(this).selectpicker({container: 'body'});
			});
			
			modalform.find("ul.sortable").each(function(){
				$(this).sortable();
			});
			
		});
	});
	
	$('.datepicker').blueDatePicker();
	
	$("ul.sortable").each(function(){
		$(this).sortable();
	});
	
	$('select.multi-select').each(function(){
		$(this).selectpicker({container: 'body'});
	});
	
	$('a.btn-sort-up').on('click', function(evt){
		evt.preventDefault();
		var parent = $(this).parents('tr');
	});
	
	var substringMatcher = function(strs) {
		return function findMatches(q, cb) {
			var matches, substringRegex;
			
			// an array that will be populated with substring matches
			matches = [];
			
			// regex used to determine if a string contains the substring `q`
			substrRegex = new RegExp(q, 'i');
			
			// iterate through the pool of strings and for any string that
			// contains the substring `q`, add it to the `matches` array
			$.each(strs, function(i, str) {
				if (substrRegex.test(str)) {
					matches.push(str);
				}
			});
			
			cb(matches);
		};
	};
	
	$('#add-field-to-form').on('click', function(){
		var selectedField = $('select[name="all_fields"]').find('option:selected');
		
		if ($('#form-fields').find('#field-id-'+selectedField.val()).length > 0)
		{
			alert('The field selected is already in the list');
			return;
		}
		
		var html = '<li class="list-group-item" id="field-id-'+selectedField.val()+'">'+
			'<span class="fa fa-sort"></span> '+
			selectedField.text() + '<input type="hidden" name="form_fields['+selectedField.val()+'][field_id]" value="'+selectedField.val()+'">'+
			'<span class="pull-right">'+
			'<a class="delete-field" href="#"><i class="fa fa-trash"></i></a>&nbsp;'+
			'</span>'+
			'<span class="pull-right">'+
			'<input type="checkbox" name="form_fields['+selectedField.val()+'][guest_only]" value="y">Guest Only&nbsp;'+
			'</span>'+
			'</li>';
		
		$('#form-fields').append(html);
		$('#form-fields').sortable();
		
		
		$('.delete-field').on('click', function(){
			var parent = $(this).parents('li');
			parent.remove();
		});
	});
	
	$('.delete-field').on('click', function(){
		var parent = $(this).parents('li');
		parent.remove();
	});
	
	$('input[name="position"]').typeahead({
			hint: true,
			highlight: true,
			minLength: 1,
			classNames: { input: 'form-control' }
		},
		{
			name: 'position',
			source: substringMatcher(TF.position)
		}
	);
	
	$('#modal-popup').on('hidden.bs.modal', function () {
		$('#calendar').fullCalendar('removeEvents', 0);
	});
	
	var deleteRelatedItem = function(obj) {
		var item_id = obj.value;
		bootbox.confirm('Are you sure you want to remove this service from this provider?', function (result) {
			// var current_url = window.location;
			var contact_id = $('input[name="contact_id"]').val();
			if (result) {
				$.ajax({
					url: TF.baseURL + 'service/delete_user/'+contact_id+'/'+item_id+'/',
					data: {confirm: 'y'},
					success: function(data) {
						if (data) $('tr#related_services_'+data).fadeOut();
					}
				})
			}
			else {
				obj.checked = true;
			}
		});
	};
	
	
	getMessages(1, false);
	getMessages(0, true);
	
	$('a.make-day-off').each(function(){
		$(this).on('click', function(evt) {
			evt.preventDefault();
			var url = $(this).attr('href');
			var self = $(this);
			
			$.get(url, function(data){
				if (data.dayoff) {
					
					self.text('Make working day');
					$('a.t_'+data.dayoff).removeClass('label-success');
					$('a.t_'+data.dayoff).addClass('label-default');
					$('a.h_'+data.dayoff).parents('th').addClass('label-warning');
				}
				else {
					self.text('Make day-off');
					$('a.h_'+data.working).parents('th').removeClass('label-warning');
				}
			}, 'json');
		});
	});
	
	$('a.work-plan').each(function(){
		$(this).on('click', function(evt) {
			evt.preventDefault();
			var url = $(this).attr('href');
			var self = $(this);
			self.css('opacity', 0.1);
			$.get(url, function(data){
				
				if (data.add) {
					$('a#t_'+data.add).css('opacity', 1);
					$('a#t_'+data.add).removeClass('label-default');
					$('a#t_'+data.add).addClass('label-success');
				}
				else {
					$('a#t_'+data.remove).css('opacity', 1);
					$('a#t_'+data.remove).addClass('label-default');
					$('a#t_'+data.remove).removeClass('label-success');
				}
			}, 'json');
		}) ;
	});
	
	$('#add_related_service').on('click', function(){
		
		var selected = $('select[name="add_service"] option:selected');
		var id = selected.val();
		var text = selected.text();
		var contact_id = $('input[name="contact_id"]').val();
		$.ajax({
			url: TF.baseURL+'service/add_user/'+contact_id+'/'+id+'/',
			data: {confirm: 'y'},
			success: function(data) {
				if (data) {
					
					$('#related_services tbody').append('<tr id="related_services_' + data + '">' +
						'<td><input checked="checked" type="checkbox" value="' + data + '" name="remove_related_services_' + data + '"></td>' +
						'<td>' + text + '</td>' +
						'</tr>');
					
					$('#related_services tbody').find('input[name*="remove_related_services"]').on('click', function(evt){
						if (!this.checked) {
							deleteRelatedItem(this);
						}
					});
					
					selected.remove();
				}
			}
		})
		
		
	});
	
	$('input[name*="remove_related_services"]').on('click', function(evt){
		if (!this.checked) {
			deleteRelatedItem(this);
		}
	});
	
	$('a.btn-confirm').each(function(){
		$(this).on('click', function(evt){
			evt.preventDefault();
			var title = $(this).attr('title');
			var url = $(this).attr('href');
			var current_url = window.location;
			
			title = (typeof title === 'undefined' ? 'Confirm?' : title);
			
			bootbox.confirm(title, function(result) {
				if (result) {
					window.location = url+'?confirm=y&return='+encodeURIComponent(current_url);
				}
			});
		})
	});
	
	var selectedTab = window.location.hash;
	if (selectedTab) {
		$('.nav-tabs a[href="'+selectedTab+'"]').tab('show');
	}
	else {
		$('.nav-tabs a:first').tab('show');
	}
	
	$('select[name*="schedule_day"]').on('change', function(){
		var date = $(this).attr('id').replace('date-', '');
		
		$.ajax({
			url: TF.baseURL + 'schedule/check',
			data: {
				date: date,
				contact_id: $('input[name="contact_id"]').val(),
				code: $(this).val()
			},
			dataType: 'json',
			type: 'post',
			success: function(data) {

				if (data.length === 0) return;
				
				for(var dt in data) {
					$('td.date-' + dt).find(':input').removeAttr('checked');
					for(var i=0; i<data[dt].length;i++) {
						var input = $('td.date-' + dt).find('input[value="'+data[dt][i]+'"]');
						$(input).prop('checked', 'checked');
						$(input).attr('checked', 'checked');
					}
				}
			}
		});
	});
	
	$('button[name="add-related-service"]').on('click', function(){
		
		var id = $('select[name="services"]').find('option:selected').val();
		var text = $('select[name="services"]').find('option:selected').text();
		
		$('table#related-services tbody').append('<tr><td>'+id+'</td><td>'+text+'</td></tr>');
	});
	
	if ($('#dailySales1').length > 0 && TF.dailySales1) {
		Morris.Donut({
			element: 'dailySales1',
			data: TF.dailySales1,
			formatter: function (y, data) { return '$' + y }
		});
	}
	
	if ($('#dailySales2').length > 0 && TF.dailySales2) {
		Morris.Donut({
			element: 'dailySales2',
			data: TF.dailySales2,
			formatter: function (y, data) { return '$' + y }
		});
	}
	
	if ($('#dailySales3').length > 0 && TF.dailySales3) {
		Morris.Donut({
			element: 'dailySales3',
			data: TF.dailySales3,
			formatter: function (y, data) { return '$' + y }
		});
	}
	
	$('div.btns').find('button').each(function(){
		$(this).on('click', function(){
			var self = $(this);
			var amount = self.attr('data-amount');
			var date = self.attr('data-date');
			var out = self.attr('data-out');
			var location = self.attr('data-location');
			var parent = self.parents('.widget');
			parent.find('h3').html('&#8369; '+amount);
			parent.find('button.btn-success').removeClass('btn-success').addClass('btn-default');
			parent.find('a.report-url').attr('href', TF.baseURL + 'reports/daily/'+location+'/'+date+'/'+out);
			self.removeClass('btn-default').addClass('btn-success');
			
		});
	});
	
	if ($('.ct-chart-daily').length > 0) {
		var chart = new Chartist.Line('.ct-chart-daily', {
			labels: TF.days_label[1],
			series: [{
				data: TF.days_value[1][0],
				className : "brand-primary-stroke",
			},
				{
					data: TF.days_value[1][1],
					className : "brand-orange-stroke",
				}
			]
		}, {
			low: 0
		});
	}
	
	if ($('.ct-chart-monthly').length > 0 && TF.months_value.length > 0) {
		var monthlyChart = new Chartist.Line('.ct-chart-monthly', {
			labels: TF.months_label,
			series: [{
				data: TF.months_value[1][0],
				className : "brand-primary-stroke",
			},
				{
					data: TF.months_value[1][1],
					className : "brand-orange-stroke",
				}
			]
		}, {
			low: 0
		});
	}
	
	$('.btn-last-7-days').on('click', function(){
		
		var location_id = $(this).attr('data-location');
		var data = {
			labels : TF.days_label[location_id],
			series : [
				{data:TF.days_value[location_id][0], className: "brand-primary-stroke"},
				{data:TF.days_value[location_id][1], className: "brand-orange-stroke"}
			]
		};
		
		chart.update(data);
	});
	
	$('.btn-this-year').on('click', function(){
		var location_id = $(this).attr('data-location');
		
		if (!TF.months_value[location_id]) return;
		
		var data = {
			labels : TF.months_label,
			series : [
				{data:TF.months_value[location_id][0], className: "brand-primary-stroke"},
				{data:TF.months_value[location_id][1], className: "brand-orange-stroke"}
			]
		};
		
		monthlyChart.update(data);
	});
	
	if ($('.daterange').length > 0) {
		$('.daterange').daterangepicker({
			utoUpdateInput: false,
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, function(start, end, label) {
			$('input[name="booking_start"]').val(start.format('YYYY-MM-DD'));
			$('input[name="booking_end"]').val(end.format('YYYY-MM-DD'));
		});
	}
	
	if ($('.date-range').length > 0) {
		
		var start = moment(TF.start_date);
		var end = moment(TF.end_date);
		
		$('.date-range').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, function(start, end, label) {
			$('input[name="start"]').val(start.format('YYYY-MM-DD'));
			$('input[name="end"]').val(end.format('YYYY-MM-DD'));
		});
	}
	
	if ($('#ct-monthly').length > 0) {
		Morris.Donut({
			element: 'ct-monthly',
			data: [
				{label: "Jan 2016", value: 12},
				{label: "Feb 2016", value: 30},
				{label: "Mar 2016", value: 20}
			]
		});
	}
});