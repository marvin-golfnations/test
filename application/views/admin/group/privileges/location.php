<?php foreach (get_all_locations() as $location) :?>
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#location-privileges-<?php echo $location['location_id'];?>" aria-expanded="false" aria-controls="location-privileges-<?php echo $location['location_id'];?>">
                <?php echo strtoupper($location['location']);?> Privileges (must have access)
            </a>
        </h4>
    </div>
    <div id="location-privileges-<?php echo $location['location_id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
	        
            <table width="100%">

                <tr>
                    <td width="50%">Can view guest schedules?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_view_schedules_'.$location['location_id'], 'y', $group['can_view_schedules_'.$location['location_id']] === 'y', 'id="can_view_schedules_'.$location['location_id'].'_y"'); ?>
                            <label for="can_view_schedules_<?php echo $location['location_id'];?>_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_view_schedules_'.$location['location_id'], 'n', $group['can_view_schedules_'.$location['location_id']] === 'n', 'id="can_view_schedules_'.$location['location_id'].'_n"'); ?>
                            <label for="can_view_schedules_<?php echo $location['location_id'];?>_n"> No </label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%">Can edit guest schedules?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_edit_schedules_'.$location['location_id'], 'y', $group['can_edit_schedules_'.$location['location_id']] === 'y', 'id="can_edit_schedules_'.$location['location_id'].'_y"'); ?>
                            <label for="can_edit_schedules_<?php echo $location['location_id'];?>_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_edit_schedules_'.$location['location_id'], 'n', $group['can_edit_schedules_'.$location['location_id']] === 'n', 'id="can_edit_schedules_'.$location['location_id'].'_n"'); ?>
                            <label for="can_edit_schedules_<?php echo $location['location_id'];?>_n"> No </label>
                        </div>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>
<?php endforeach ?>