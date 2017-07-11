<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#cp-admin" aria-expanded="false" aria-controls="cp-admin">
                Control Panel Administration
            </a>
        </h4>
    </div>
    <div id="cp-admin" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <table width="100%">
                <tr>
                    <td width="50%">Can administrate guest?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_admin_guest', 'y', $group['can_admin_guest'] == 'y', 'id="can_admin_guest_y"'); ?>
                            <label for="can_admin_guest_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_admin_guest', 'n', $group['can_admin_guest'] == 'n', 'id="can_admin_guest_n"'); ?>
                            <label for="can_admin_guest_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can administrate calendar?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_admin_calendar', 'y', $group['can_admin_calendar'] == 'y', 'id="can_admin_calendar_y"'); ?>
                            <label for="can_admin_calendar_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_admin_calendar', 'n', $group['can_admin_calendar'] == 'n', 'id="can_admin_calendar_n"'); ?>
                            <label for="can_admin_calendar_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can administrate providers?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_admin_providers', 'y', $group['can_admin_providers'] == 'y', 'id="can_admin_providers_y"'); ?>
                            <label for="can_admin_providers_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_admin_providers', 'n', $group['can_admin_providers'] == 'n', 'id="can_admin_providers_n"'); ?>
                            <label for="can_admin_providers_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can administrate services?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_admin_services', 'y', $group['can_admin_services'] == 'y', 'id="can_admin_services_y"'); ?>
                            <label for="can_admin_services_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_admin_services', 'n', $group['can_admin_services'] == 'n', 'id="can_admin_services_n"'); ?>
                            <label for="can_admin_services_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can administrate facilities?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_admin_facilities', 'y', $group['can_admin_facilities'] == 'y', 'id="can_admin_facilities_y"'); ?>
                            <label for="can_admin_facilities_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_admin_facilities', 'n', $group['can_admin_facilities'] == 'n', 'id="can_admin_facilities_n"'); ?>
                            <label for="can_admin_facilities_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can administrate packages?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_admin_packages', 'y', $group['can_admin_packages'] == 'y', 'id="can_admin_packages_y"'); ?>
                            <label for="can_admin_packages_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_admin_packages', 'n', $group['can_admin_packages'] == 'n', 'id="can_admin_packages_n"'); ?>
                            <label for="can_admin_packages_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can administrate activities?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_admin_activities', 'y', $group['can_admin_activities'] == 'y', 'id="can_admin_activities_y"'); ?>
                            <label for="can_admin_activities_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_admin_activities', 'n', $group['can_admin_activities'] == 'n', 'id="can_admin_activities_n"'); ?>
                            <label for="can_admin_activities_n"> No </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>