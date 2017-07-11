<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Calendar Privileges
            </a>
        </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <table width="100%">
                <tr>
                    <td width="50%">Can view schedules from other locations?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_view_schedule_other_location', 'y', $group['can_view_schedule_other_location'] == 'y', 'id="can_view_schedule_other_location_y"'); ?>
                            <label for="can_view_schedule_other_location_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_view_schedule_other_location', 'n', $group['can_view_schedule_other_location'] == 'n', 'id="can_view_schedule_other_location_n"'); ?>
                            <label for="can_view_schedule_other_location_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can edit schedules from other locations?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_edit_schedule_other_location', 'y', $group['can_edit_schedule_other_location'] == 'y', 'id="can_edit_schedule_other_location_y"'); ?>
                            <label for="can_edit_schedule_other_location_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_edit_schedule_other_location', 'n', $group['can_edit_schedule_other_location'] == 'n', 'id="can_edit_schedule_other_location_n"'); ?>
                            <label for="can_edit_schedule_other_location_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can assign schedules from other locations?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_assign_schedule_other_location', 'y', $group['can_assign_schedule_other_location'] == 'y', 'id="can_assign_schedule_other_location_y"'); ?>
                            <label for="can_assign_schedule_other_location_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_assign_schedule_other_location', 'n', $group['can_assign_schedule_other_location'] == 'n', 'id="can_assign_schedule_other_location_n"'); ?>
                            <label for="can_assign_schedule_other_location_n"> No </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>