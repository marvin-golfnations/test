<?php
ob_start();


?>
    <div class="row" style="padding-bottom: 15px">
        <div class="col-lg-12">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input value="1,2" type="radio" name="calendar-cat-id" id="option1" autocomplete="off" checked> Treatments
                </label>
                <label class="btn btn-default">
                    <input value="3,12" type="radio" name="calendar-cat-id" id="option2" autocomplete="off"> Nutrional Activities
                </label>
            </div>
        </div>
    </div>
    <div id="calendar3"></div>
<?php
$contents = ob_get_clean();
//test
$this->view('partials/modal', array(
    'action' => 'backend/calendar',
    'ajax' => true,
    'title' => 'Appointment',
    'hidden_fields' => array(), // array('event_id' => $event_id, 'booking_item_id' => $booking_item_id),
    'contents' => $contents
));
?>