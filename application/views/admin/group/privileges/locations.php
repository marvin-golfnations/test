<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#location-access" aria-expanded="false" aria-controls="location-access">
                Location Access
            </a>
        </h4>
    </div>
    <div id="location-access" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <table width="100%">
                <?php foreach (get_all_locations() as $location) :?>
                <tr>
                    <td width="50%">Can access <?php echo strtoupper($location['location']);?>?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('location['.$location['location_id'].']', 'y', in_array($location['location_id'], $group['location']), 'id="location_y_'.$location['location_id'].'"'); ?>
                            <label for="location_y_<?php echo $location['location_id'];?>"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('location['.$location['location_id'].']', 'n', !in_array($location['location_id'], $group['location']), 'id="location_n_'.$location['location_id'].'"'); ?>
                            <label for="location_n_<?php echo $location['location_id'];?>"> No </label>
                        </div>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>