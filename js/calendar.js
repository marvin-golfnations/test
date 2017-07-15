(function ($) {

    /* initialize the external events
     -----------------------------------------------------------------*/
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    var populateDropdown = function (name, data, selected) {
        var items = $('select[name="' + name + '"]');
        items.empty();
        for (key in data) {
            var s = '';
            if (selected === key) s = "selected";
            items.append('<option ' + s + ' value="' + key + '">' + data[key] + '</option>');
        }
    }

    var isValidEvent = function (selected_start) {

        if (typeof booking === 'undefined' || booking == null)
            return true;

        var start = moment(booking.start_date);
        var end = moment(booking.end_date);

        return selected_start.isSameOrAfter(start) && selected_start.isSameOrBefore(end);
    };

    var updateInventory = function (booking_item_id, qty) {
        $.ajax({
            dataType: "json",
            url: TF.baseURL + '/calendar/update_inventory',
            data: {
                booking_item_id: booking_item_id,
                qty: qty
            },
            success: function (data) {
                console.log('Success');
            },
            type: "POST"
        });
    }

    var getBookingDates = function (booking_id, arrival_date, departure_date) {
        $.ajax({
            dataType: 'json',
            url: TF.baseURL + 'calendar/get_booking_dates',
            data: {
                booking_id: booking_id,
                start_date: arrival_date,
                end_date: departure_date
            },
            success: function (data) {
                populateDropdown('start_date', data, $('input[name="_start_date"]').val());
                populateDropdown('end_date', data, $('input[name="_end_date"]').val());
            }
        });

    }

    var getAvailableServices = function (booking_id) {
        $.ajax({
            dataType: "json",
            url: TF.baseURL + 'calendar/get_available_services',
            data: {
                booking_id: booking_id
            },
            success: function (data) {

                var items = $('select[name="item_id"]');
                items.empty();
                for (program_name in data) {
                    items.append('<optgroup label="' + program_name + '"></optgroup>');
                    if (Object.prototype.toString.call(data[program_name]) === '[object Object]') {
                        for (item_id in data[program_name]) {
                            items.find('optgroup[label="' + program_name + '"]').append('<option value="' + item_id + '">' + data[program_name][item_id] + '</option>');
                        }
                    }
                    else {
                        items.append('<option value="' + program_name + '">' + data[program_name] + '</option>');
                    }
                }
                items.trigger('change');
            },
            type: "POST"
        });
    }

    var checkGuestName = function(){
        var firstName = $('input[name="first_name"]').val().trim();
        var lastName = $('input[name="last_name"]').val().trim();
        if (firstName.length === 0 || lastName.length === 0) return;
        $.ajax({
            dataType: 'json',
            url: TF.baseURL + 'account/check_name',
            data: {
                first_name : firstName,
                last_name : lastName
            },
            success: function(data) {
                if (data.result !== null) {
                    if ( confirm("Existing guest first and last name exists. Do you want to use it?") ) {
                        $('input[name="first_name"]').val(data.result.first_name);
                        $('input[name="last_name"]').val(data.result.last_name);
                        $('input[name="guest_id"]').val(data.result.contact_id);
                    }
                }
            }
        })
    };

    var getAvailableRoomsAndPeople = function () {

        $('select[name="facility_id"]').attr('disabled', 'disabled');
        $.ajax({
            dataType: "json",
            url: TF.baseURL + 'calendar/get_available_facilities',
            data: {
                item_id: $('select[name="item_id"]').val(),
                event_id: $('input[name="event_id"]').val(),
                start_time: $('select[name="start_date"]').val() + ' ' + $('select[name="start_time"]').val(),
                status: $('select[name="status"]').val(),
                end_time: $('select[name="end_date"]').val() + ' ' + $('select[name="end_time"]').val()
            },
            success: function (data) {
                var selected = $('select[name="assigned_to"] option:selected').val();
                $('select[name="facility_id"]').removeAttr('disabled');
                $('select[name="facility_id"]').empty();
                $('select[name="facility_id"]').append('<option value="">-Select-</option>');

                for (facility in data) {
                    var s = '';

                    if (data[facility].facility_id === selected) {
                        s = ' selected="selected"';
                    }
                    $('select[name="facility_id"]').append(
                        '<option value="' + data[facility].facility_id + '"' + s + '>' + data[facility].facility_name + '</option>'
                    );
                }
            },
            type: "POST"
        });

        var item_id = $('select[name="item_id"]').val();

        if (item_id !== '0') {
            $('select[name="assigned_to"]').attr('disabled', 'disabled');
            $.ajax({
                dataType: "json",
                url: TF.baseURL + 'calendar/get_available_peoples',
                data: {
                    item_id: item_id,
                    event_id: $('input[name="event_id"]').val(),
                    start_time: $('select[name="start_date"] option:selected').val() + ' ' + $('select[name="start_time"] option:selected').val(),
                    status: $('select[name="status"]').val(),
                    end_time: $('select[name="end_date"] option:selected').val() + ' ' + $('select[name="end_time"] option:selected').val()
                },
                success: function (data) {

                    var selected = $('select[name="assigned_to"] option:selected').val();
                    $('select[name="assigned_to[]"]').removeAttr('disabled');
                    $('select[name="assigned_to[]"]').empty();
                    $('select[name="assigned_to[]"]').append('<option value="">-Select-</option>');

                    for (var contact in data) {

                        var s = '';

                        if (data[contact].contact_id === selected) {
                            s = ' selected="selected"';
                        }

                        $('select[name="assigned_to[]"]').append(
                            '<option value="' + data[contact].contact_id + '"' + s + '>' + data[contact].first_name + ' ' + data[contact].last_name + '</option>'
                        );
                    }
                },
                type: "POST"
            });
        }
    };

    var calculateEndTime = function (duration) {
        var start_date = $('select[name="start_date"]').val();
        var start_time = $('select[name="start_time"]').val();
        var duration = parseInt(duration);
        var start_dt = moment(start_date + ' ' + start_time, 'YYYY-MM-DD hh:mm');
        start_dt.add(duration, 'minutes');
        $('select[name="end_date"] option').removeAttr('selected').filter('[value="' + start_dt.format('YYYY-MM-DD') + '"]').prop('selected', true);
        $('select[name="end_time"] option').removeAttr('selected').filter('[value="' + start_dt.format('HH:mm') + '"]').prop('selected', true);

        getAvailableRoomsAndPeople();
    };

    $('.scrollable').scroll(function() {
        if ($(this).scrollTop() > 1){
            $('.fc-byProviders-view thead').addClass("sticky");
        }
        else{
            $('.fc-byProviders-view thead').removeClass("sticky");
        }
    });

    var pageTop = function () {
        return $(".navbar").height();
    }

    var start_date = moment(TF.start_date);

    var loadResources = function (callback) {

        if (!TF.show_providers) {
            callback(new Array());
            return;
        }
        if (TF.resource_field_id.length === 0) {
            callback(new Array());
            return;
        }

        var url = TF.baseURL + 'calendar/get_resources_' + TF.resource_field_id;

        $.ajax({
            url: url,
            type: 'post',
            data: {
                date: start_date.format('YYYY-MM-DD'),
                positions: TF.selected_positions,
                statuses: TF.selected_statuses,
                locations: TF.selected_locations,
                show_my_appointments: TF.show_my_appointments,
                show_no_schedule: TF.show_no_schedule
            },
            success: function (data) {
                $('.popover').find(':input').removeAttr('disabled');
                callback(data);
            }
        });
    }

    $('select#calendar-status').on('change', function () {
        var selected = $(this).find('option:selected');

        TF.selected_statuses = new Array();
        for (var i = 0; i < selected.length; i++) {
            TF.selected_statuses.push($(selected[i]).val());
        }

        $('#calendar').fullCalendar('refetchEvents');

    });

    $('select#calendar-position').on('change', function () {
        var selected = $(this).find('option:selected');

        TF.selected_positions = new Array();
        for (var i = 0; i < selected.length; i++) {
            TF.selected_positions.push($(selected[i]).val());
        }

        $('#calendar').fullCalendar('refetchResources');

    });

    $('select#calendar-location').on('change', function () {
        var selected = $(this).find('option:selected');

        TF.selected_locations = new Array();
        for (var i = 0; i < selected.length; i++) {
            TF.selected_locations.push($(selected[i]).val());
        }

        $('#calendar').fullCalendar('refetchEvents');

    });

    $('input[name="calendar-categories"]').on('change', function () {
        TF.categories = this.value.split(',');
        $('#calendar').fullCalendar('refetchEvents');

    });


    var update_calendar_views = false;

    if ($('#calendar2').length > 0) {
        $('#calendar2').fullCalendar({
            header: TF.header,
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultView: TF.defaultView,
            eventSources: [
                {
                    url: TF.baseURL + 'calendar/json/0',
                    type: 'post',
                    cache: true,
                    data: function () {
                        var params = new Object();
                        params.status = TF.selected_statuses;
                        params.position = TF.selected_positions;
                        params.location = TF.selected_locations;
                        params.show_my_appointments = TF.show_my_appointments;
                        params.show_no_schedule = TF.show_no_schedule;
                        params.show_guest_name = TF.showGuestName;
                        params.resource_field_id = TF.resource_field_id;
                        params.update_calendar_views = update_calendar_views;
                        params.show_facility = TF.showFacility;
                        params.abbreviate = TF.abbreviate;
                        if (TF.guest_id)
                            params.guest_id = TF.guest_id;
                        return params;
                    }
                }
            ]
        });
    }

    if ($('#calendar').length > 0) {

        var bookingId = 0;

        if (typeof TF.booking_id != 'undefined' && TF.booking_id != null) bookingId = TF.booking_id;

        /* initialize the calendar
         -----------------------------------------------------------------*/
        var defaultCalendarOptions = {
            header: TF.header,
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultDate: start_date,
            firstDay: start_date.weekday(),
            defaultView: TF.defaultView,
            editable: TF.editable,
            droppable: TF.droppable,
            eventLimit: false,
            height: 'auto',
            resourceLabelText: TF.resource_name,
            resources: function (callback) {
                loadResources(callback);
            },
            resourceRender: function (resource, labelTds, bodyTds) {
                var date = $('#calendar').fullCalendar('getDate');
                if (resource.work_plan) {
                    date = date.format('YYYY-MM-DD');
                    if (typeof resource.work_plan[date] !== 'undefined') {
                        labelTds.removeClass();
                        labelTds.addClass('schedule');
                        labelTds.addClass('schedule-' + resource.work_plan[date]);

                        resource.title = resource.title + resource.work_plan[date];
                    }
                }
            },
            eventSources: [
                {
                    url: TF.baseURL + 'calendar/json/' + bookingId,
                    type: 'post',
                    cache: true,
                    data: function () {
                        var params = new Object();
                        params.status = TF.selected_statuses;
                        params.position = TF.selected_positions;
                        params.location = TF.selected_locations;
                        params.show_my_appointments = TF.show_my_appointments;
                        params.show_no_schedule = TF.show_no_schedule;
                        params.show_guest_name = TF.showGuestName;
                        params.resource_field_id = TF.resource_field_id;
                        params.update_calendar_views = update_calendar_views;
                        params.show_facility = TF.showFacility;
                        params.abbreviate = TF.abbreviate;
                        params.categories = TF.categories;
                        if (TF.guest_id)
                            params.guest_id = TF.guest_id;
                        return params;
                    }
                }
            ],
            selectable: true,
            businessHours: TF.businessHours,
            maxTime: TF.maxTime,
            minTime: TF.minTime,
            views: TF.views,
            slotMinutes: 15,
            slotEventOverlap: false,
            eventDurationEditable: false,
            customButtons: {
                print: {
                    text: 'print',
                    click: function () {
                        var date = $('#calendar').fullCalendar('getDate');
                        window.open(TF.print_url + '/' + TF.booking_id + '/' + date.format('YYYY-MM-DD'));
                    }
                },
                facilities: {
                    text: 'facilities',
                    click: function () {
                        window.location = TF.baseURL + 'calendar/by_facilities';
                    }
                },
                service_providers: {
                    text: 'service providers',
                    click: function () {
                        window.location = TF.baseURL + 'calendar';
                    }
                }
            },
            eventClick: function (event) {
                if (event.editable) {
                    eventClickAction(event);
                }
            },
            eventRender: function (event, element, view) {

                if (event.status === 'receptionist') {
                    return;
                }

                if (event.show_tooltip === false) return;
                var title = event.title;


                if (event.notes) {
                    title = title + "\n" + event.notes;
                }

                if (typeof title === 'string' || title instanceof String) {
                    title = title.replace(/(?:\r\n|\r|\n)/g, '<br />');
                }

                $(element).popover({
                    html: true,
                    content: title,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            },
            drop: function (date, jsEvent, ui, resourceId) {

                if (TF.canChange) {
                    var event = ui.helper.data('event');
                    event.start = date.format();
                    event.resourceId = 0;
                    renderPopup(event);
                }
            },
            eventAfterAllRender: function (view) {
                $('.popover').find(':input').removeAttr('disabled');
            },
            viewRender: function (view, element) {

                start_date = $('#calendar').fullCalendar('getDate');

                TF.resource_field_id = 'contact_id';

                if (view.name === 'byGuest') {
                    TF.showGuestName = false;
                    TF.resource_field_id = 'guest_id';
                }
                else if (view.name === 'byFacilities') {
                    TF.resource_field_id = 'facility_id';
                }

                $('#calendar').fullCalendar('refetchResources');
                $('#calendar').fullCalendar('refetchEvents');
                if (view.name === TF.bookingView) {
                    view.start = moment(TF.start_date);
                    view.end = moment(TF.end_date);
                }

                var $table = $('#calendar table:first');
            },
            eventDragStart: function (event, jsEvent, ui, view) {
                $('.popover').popover('hide');
            },
            eventDragStop: function (event, jsEvent, ui, view) {
                $('.popover').popover('hide');
            },
            eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {
                var saved = saveEvent(event, ui);
                if (saved) {
                    $('#calendar').fullCalendar('rerenderEvents');
                }
                else {
                    revertFunc();
                }
            },
            dayClick: function (date, jsEvent, view, resourceObj) {
                if (TF.canChange) {
                    var event = {id: 0, start: date.format(), booking_id: 0, item_id: 0};

                    if (typeof resourceObj !== 'undefined' && resourceObj !== null) {

                        if (view.name === 'byGuest') {
                            event.booking_id = resourceObj.booking_id;
                        }

                        event.resourceId = resourceObj.id;
                    }
                    renderPopup(event);
                }
            },
            dayRender: function (date, cell) {
                if (date.isBefore(moment(TF.start_date))) {
                    //cell.addClass('fc-breaktime');
                }

                if (typeof TF.end_date !== 'undefined' && date.isAfter(moment(TF.end_date))) {
                    //cell.addClass('fc-breaktime');
                }
            },
            resourceRender: function (resourceObj, labelTds, bodyTds) {
                labelTds.css('text-decoration', 'underlined');
                labelTds.on('click', function () {
                    var view = $('#calendar').fullCalendar('getView');

                    if (view.name === 'byProgram') {

                    }
                });
            }
        };
        if (TF.calendarOptions)
            jQuery.extend(defaultCalendarOptions, TF.calendarOptions);

        var calendar = $('#calendar').fullCalendar(defaultCalendarOptions);

        $("a[href='#appointment']").on('shown.bs.tab', function (e) {
            $('#calendar').fullCalendar('render');
        });


        function eventClickAction(event) {
            if (event.editable) renderPopup(event);
        }

        function renderPopupWaiting(title, message) {
            var html = '<div role="document" class="modal-dialog modal-lg">' +
                '<div class="modal-content"><div class="modal-header"><button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span></button>' +
                '<h4 class="modal-title">' + title + '</h4></div>' +
                '<div class="modal-body">' + message + '</div></div>' +
                '</div>';

            return html;
        }

        renderPopup = function (event) {

            var post_data = {id: event.id, booking_item_id: event.booking_item_id};

            if (event.id === 0) {
                post_data = {
                    id: event.id,
                    start: event.start,
                    booking_id: event.booking_id,
                    item_id: event.item_id,
                    assigned_to: event.resourceId,
                    duration: parseInt(event.duration)
                }
            }

            if (TF.booking_id) {
                post_data.booking_id = TF.booking_id;
            }

            var modal = $('#modal-popup');

            modal.modal('show');
            modal.data('event', event);
            modal.html(renderPopupWaiting('Appointment', 'Please wait...'));
            modal.load(TF.baseURL + 'account/event/', post_data, function () {

                //modal.find('.datepicker').datepicker();
                //modal.find('.timepicker').timepicker();

                modal.find('button[name="service_as_item"]').on('click', function () {
                    modal.find('div#service-as-text').addClass('hidden');
                    modal.find('div#service-as-item').removeClass('hidden');
                    $('select[name="item_id"]').removeAttr('disabled');
                });

                modal.find('button[name="service_as_text"]').on('click', function () {

                    var item_name = $('select[name="item_id"]').find('option:selected').text();

                    modal.find('div#service-as-text').removeClass('hidden');
                    modal.find('div#service-as-item').addClass('hidden');

                    var event_title = $('input[name="event_title"]').val();
                    if (event_title.length == 0) {
                        $('input[name="event_title"]').val(item_name);
                        $('input[name="event_title"]').focus();
                    }
                    $('select[name="item_id"]').attr('disabled', 'disabled');
                });

                $('input[name="start_time"]').on("dp.update", function (e) {
                    console.log(this);
                });

                modal.find('select[name="booking_id"]').on('change', function () {

                    if (this.value === '') {
                        getAvailableServices(0);
                        $('.new-guest').removeClass('hidden');
                        $('select[name="start_date"]').find('option').remove();
                        $('select[name="end_date"]').find('option').remove();
                    }
                    else {
                        $('.new-guest').addClass('hidden');
                        getAvailableServices(this.value);
                        getBookingDates(this.value);
                    }

                });

                modal.find('a.btn-confirm').each(function () {
                    $(this).on('click', function (evt) {
                        evt.preventDefault();
                        var title = $(this).attr('title');
                        var url = $(this).attr('href');
                        var current_url = window.location;

                        title = (typeof title === 'undefined' ? 'Confirm?' : title);

                        bootbox.confirm(title, function (result) {
                            if (result) {
                                window.location = url + '?confirm=y&return=' + encodeURIComponent(current_url);
                            }
                        });
                    })
                });

                modal.find('select.multi-select').each(function () {
                    $(this).selectpicker({container: 'body'});
                });

                modal.find('select[name="item_id"]').on('change', function () {
                    $.getJSON(TF.baseURL + '/service/json/' + $(this).val(), function (output) {

                        if (output) {

                            var item = output[0];
                            var duration = parseInt(item.duration);
                            var max_provider = parseInt(item.max_provider);
                            if (max_provider > 1) {
                                $('select[name*=assigned_to]').attr('multiple', 'multiple');
                            }
                            else
                                $('select[name*=assigned_to]').removeAttr('multiple');
                            $('select[name="start_time"]').attr('data-duration', duration);
                            $('select[name="start_date"]').attr('data-duration', duration);

                            calculateEndTime(duration);
                        }
                    });
                });

                modal.find('select[name="start_date"]').on('change', function () {
                    var duration = $(this).attr('data-duration');
                    duration = parseInt(duration);
                    calculateEndTime(duration);
                });

                modal.find('select[name="start_time"]').on('change', function () {
                    var duration = $(this).attr('data-duration');
                    duration = parseInt(duration);
                    calculateEndTime(duration);
                });

                modal.find('select[name="status"]').on('change', function () {
                    var status = $(this).val();
                    var $options = modal.find('#'+status+'Options');

                    modal.find('.statusOptions').hide();

                    if ($options.length > 0) {
                        $options.show();
                    }
                });


                if (post_data.id === 0)
                    getAvailableRoomsAndPeople();

                modal.find('input[name="arrival_date"]').datepicker({
                    onSelect: function(dateText) {
                        getBookingDates(0, dateText, modal.find('input[name="departure_date"]').val());
                    }
                })

                modal.find('input[name="departure_date"]').datepicker({
                    onSelect: function(dateText) {
                        getBookingDates(0, modal.find('input[name="arrival_date"]').val(), dateText);
                    }
                });

                modal.find('input[name="first_name"], input[name="last_name"]').blur(function(){
                    checkGuestName();
                });

                modal.find('form#appointmentForm').validate({
                    submitHandler: function (form) {
                        $.post($(form).attr('action'), $(form).serialize(), function (output) {
                            if (output.errors) {
                                bootbox.alert(output.errors.join("\n"));
                                return;
                            }
                            var event = modal.data('event');
                            if (event.fromService) {
                                var qty = parseInt($(event.parent).attr('data-qty'));
                                if (qty === 1) {
                                    $(event.parent).remove();
                                }
                                else {
                                    $(event.parent).attr('data-qty', qty - 1);
                                    $(event.parent).html(event.title + ' x ' + (qty - 1) + ' ' + $(event.parent).attr('data-uom'));
                                }
                                updateInventory(event.bookingItemId, qty - 1);
                            }


                            if (event.id > 0) {
                                event.id = parseInt(event.id);
                                event.end = moment(output.end);
                                event.start = moment(output.start);
                                event.contact_id = output.contact_id;
                                event.classNames = output.className;
                            }
                            $('#calendar').fullCalendar('refetchEvents');
                            modal.modal('hide');
                        }, 'json');
                    }
                });
            });
        }

        function saveEvent(event, ui) {

            var resourceIds = $('#calendar').fullCalendar('getEventResource', event.id);

            var end = event.start.clone();
            end.add(event.duration, 'minutes');
            var success = true;
            var data = {
                booking_id: event.booking_id,
                event_id: event.id,
                item_id: event.item_id,
                start_date: event.start.format('YYYY-MM-DD'),
                start_time: event.start.format('HH:mm:00'),
                end_date: end.format('YYYY-MM-DD'),
                end_time: end.format('HH:mm:00'),
                assigned_to: typeof resourceIds !== 'undefined' ? resourceIds.id : 0,
                status: event.status
            };

            $.ajax(
                {
                    url: TF.baseURL + '/calendar/',
                    data: {
                        booking_id: event.booking_id,
                        event_id: event.id,
                        item_id: event.item_id,
                        start_date: event.start.format('YYYY-MM-DD'),
                        start_time: event.start.format('HH:mm:00'),
                        end_date: end.format('YYYY-MM-DD'),
                        end_time: end.format('HH:mm:00'),
                        assigned_to: typeof resourceIds !== 'undefined' ? resourceIds.id : 0,
                        status: event.status
                    },
                    async: false,
                    method: 'post',
                    dataType: 'json',
                    success: function (output) {

                        if (typeof output.errors != 'undefined' && output.errors != null) {
                            alert(output.errors);
                            /*
                             bootbox.dialog({
                             message : output.errors,
                             title : 'Error Encountered!',
                             buttons: {
                             main: {
                             label : 'OK',
                             callback: function() {

                             }
                             }
                             }});*/
                            success = false;
                        }
                    }
                }
            );

            return success;
        }

        // on load call this month list

        $('.btn-add-item-to-calendar').each(function () {

            var event = {
                id: 0,
                parent: this,
                title: $.trim($(this).attr('title')),
                item_id: $(this).attr('data-item-id'),
                duration: $(this).attr('data-duration'),
                resourceId: $(this).attr('data-resource-id'),
                stick: true,
                booking_id: $(this).attr('data-booking-id'),
                qty: $(this).attr('data-qty'),
                fromService: true,
                bookingItemId: $(this).attr('data-booking-item-id')
            };

            $(this).data('event', event);

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            if ((target == '#submissions')) {
                $('.nav-pills a:first').tab('show');
            }
        });

        $('input[name="calendar-cat-id"]').on('change', function () {
            TF.categories = this.value.split(',');
            $('#calendar').fullCalendar('refetchEvents');
        });

    }

    $('a.guest-calendar').on('click', function(evt){
        evt.preventDefault();
        renderGuestCalendarPopup($(this).attr('data-booking_id'));
    });

    function renderGuestCalendarPopup(booking_id) {
        $('#modal-popup').modal('show');
        $('#modal-popup').load(TF.baseURL + 'account/calendar', function () {
            $('#modal-popup').find('#calendar3').fullCalendar({
                header: {
                    left: 'prev, next, today',
                    center: 'title',
                    right: 'agendaDay,agendaWeek,month'
                },
                schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                defaultView: 'agendaDay',
                maxTime: TF.maxTime,
                minTime: TF.minTime,
                views: TF.views,
                slotMinutes: 15,
                events: TF.baseURL+'calendar/json/'+booking_id,
                eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {
                    if (TF.canChange) {
                        var saved = saveEvent(event, ui);
                        if (saved) {
                            //$('#calendar3').fullCalendar('rerenderEvents');
                        }
                        else {
                            revertFunc();
                        }
                    }
                }
            });

            $('#modal-popup').find('form').find('input[type="submit"]').on('click', function (evt) {
                evt.preventDefault();
                var start = jQuery(':input[name="date"] option:selected').val() + ' ' + jQuery(':input[name="time"] option:selected').val();
                var endTime = moment(start, 'YYYY-MM-DD HH:mm:ss');
                var startTime = moment();
                var hoursDiff = endTime.diff(startTime, 'hours');

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
                        function () {
                            form.submit();
                        });
                    return;
                }
            });
        });
    }


}(jQuery));