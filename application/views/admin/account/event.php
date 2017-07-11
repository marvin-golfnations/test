<?php
ob_start();


?>
<?php if (!$booking_id) : ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#existing" aria-controls="existing" role="tab" data-toggle="tab">Select Existing Guest</a></li>
            <li><a href="#new-guest" aria-controls="new-guest" role="tab" data-toggle="tab">New Guest</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="existing">
                <div class="form-group">
                    <?php echo form_dropdown('booking_id', $bookings, $booking_id, 'class="show-tick form-control" ' . ($booking_id ? 'readonly' : '')); ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="new-guest">
                <fieldset>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                                <input type="text" name="first_name" class="form-control required" placeholder="First Name">
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                                <input type="text" name="last_name" class="form-control required" placeholder="Last Name">
                                <input type="hidden" name="guest_id" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                                <?php echo form_dropdown('package_type', $package_types, '', 'class="form-control required"'); ?>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-xs-3 col-md-3">
                                <input type="text" name="arrival_date" class="form-control datepicker required" placeholder="Arrival Date">
                            </div>
                            <div class="col-lg-3 col-sm-3 col-xs-3 col-md-3">
                                <input type="text" name="departure_date" class="form-control datepicker required" placeholder="Departure Date">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

    <?php else : ?>
    <h3 class="bg-info" style="background: #d9edf7; color: #333; padding: 10px; margin-top: 10px; margin-bottom: 10px;">
        <?php echo $booking_data['first_name'] . ' ' . $booking_data['last_name']; ?></strong> - <label style="font-size: 16px; padding-top: 7px" class="label label-primary"><?php echo $booking_data['title']; ?></label>
        <?php echo form_hidden('booking_id', $booking_id); ?>
    </h3>
    <?php endif; ?>

    <div class="row">

        <div class="col-xs-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="bold text-muted"><i class="fa fa-tasks"></i> Service</label>
                <div class="form-group">
                    <div class="input-group" style="width:100%">
                        <?php echo form_dropdown('item_id', available_booking_items($booking_id), $item_id,
                            'class="select-picker form-control" data-header="Select Service" data-live-search="true" ' . ($item_id ? 'readonly' : '')); ?>
                    </div>
                </div>
                <input type="checkbox" name="included" <?php echo $included ? 'checked' : '';?>> Included
                <input type="checkbox" name="not_included" <?php echo $not_included ? 'checked' : '';?>> Not Included
                <input type="checkbox" name="foc" <?php echo $foc ? 'checked' : '';?>> FOC
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="bold text-muted"><i class="fa fa-calendar"></i> Date & Time Settings</label>
                <div class="input-group">
                    <div class="start-dt col-lg-6" style="display: inline-block; padding-left: 0; padding-right: 0">
                        <?php echo form_dropdown('start_date', $dates, $start_date, 'data-duration="' . $duration . '" class="form-control required" style="width:50%"'); ?>
                        <?php echo form_dropdown('start_time', $times, $start_time, 'data-duration="' . $duration . '" class="form-control required" style="width:50%"'); ?>
                        <input type="hidden" name="_start_date" value="<?php echo $start_date; ?>"/>
                        <input type="hidden" name="_start_time" value="<?php echo $start_time; ?>"/>
                    </div>
                    <div class="end-dt col-lg-6" style="display: inline-block; padding-left: 0; padding-right: 0">
                        <?php echo form_dropdown('end_date', $dates, $end_date, 'class="form-control required" style="width:50%"'); ?>
                        <?php echo form_dropdown('end_time', $times, $end_time, 'class="form-control required" style="width:50%"'); ?>
                        <input type="hidden" name="_end_date" value="<?php echo $end_date; ?>"/>
                        <input type="hidden" name="_end_time" value="<?php echo $end_time; ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12 col-md-6 col-lg-6">

            <div class="form-group">
                <div class="input-group" style="width:100%">
                    <label class="bold text-muted"><i class="fa fa-home"></i> Facility</label>
                    <?php echo form_dropdown('facility_id', $facilities, $facility_id, 'class="show-tick form-control"'); ?>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-md-6 col-lg-6">
            <div class="form-group">
                <div class="input-group" style="width:100%">
                    <label class="bold text-muted"><i class="fa fa-user"></i> Service provider (s)</label>
                    <?php if ($max_provider > 1) : ?>
                        <?php echo form_multiselect('assigned_to[]', $providers, $assigned_to, 'class="multi-select show-tick form-control"', TRUE); ?>
                    <?php else : ?>
                        <?php echo form_dropdown('assigned_to[]', $providers, $assigned_to, 'class="show-tick form-control"', TRUE); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="form-group">
                <div class="input-group" style="width:100%">
                    <label class="bold text-muted"><i class="fa fa-flag"></i> Status</label>
                    <?php echo form_dropdown('status', $statuses, $status, 'class="show-tick form-control required"'); ?>
                </div>
            </div>

        </div>
        <div class="col-xs-2 col-md-6 col-lg-3">
            <div class="form-group">
                <div class="input-group" style="width:100%">
                    <label class="bold text-muted"><i class="fa fa-user"></i> Book By </label>
                    <?php echo form_dropdown('author_id', $audit_users, $author_id, 'class="show-tick form-control"'); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label class="bold text-muted"><i class="fa fa-file-text"></i> Additional Info </label>
                <?php echo form_input('notes', $notes, 'class="form-control"'); ?>
            </div>
        </div>

    </div>

    <div class="panel-collapse collapse <?php echo $status === 'cancelled' ? 'in' : '' ?>" id="collapseExample">

        <div class="alert alert-warning alert-dismissible fade in form-group" role="alert">
            <div class="row">
                <div class="col-lg-3">
                    <label class="bold text-muted">Called by</label>
                    <?php echo form_dropdown('called_by', $providers, $called_by, 'class="show-tick form-control"'); ?>
                </div>
                <div class="col-lg-3">
                    <label class="bold text-muted">Cancelled by</label>
                    <?php echo form_dropdown('cancelled_by', $audit_users, $cancelled_by, 'class="show-tick form-control"'); ?>
                </div>
                <div class="col-lg-3">
                    <label class="bold text-muted">Reason</label>
                    <?php echo form_dropdown('cancelled_reason', $reasons, $cancelled_reason, 'class="form-control required" placeholder="Enter Reason"'); ?>
                </div>

                <div class="col-lg-3">
                    <label class="bold text-muted">Date</label>
                    <?php echo form_input('date_cancelled', $date_cancelled, 'class="form-control required datepicker" placeholder="Enter Reason"'); ?>
                </div>


            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('input[name="first_name"]').on('blur', function(){
                console.log(this.value);
            }) ;
        });
    </script>

<?php
$contents = ob_get_clean();

$this->view('partials/modal', array(
    'action' => 'backend/calendar',
    'ajax' => true,
    'form_id' => 'appointmentForm',
    'form_name' => 'appointmentForm',
    'custom_buttons' => $event_id ? '<a class="btn btn-danger btn-confirm pull-left" title="Are you sure you want to delete this appointment" href="' . site_url('backend/calendar/delete/' . $event_id) . '">Delete</a>' : '',
    'title' => 'Appointment',
    'hidden_fields' => array('event_id' => $event_id, 'booking_item_id' => $booking_item_id),
    'contents' => $contents
));
?>