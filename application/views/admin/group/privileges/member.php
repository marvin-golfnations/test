<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#member-account" aria-expanded="false" aria-controls="member-account">
                Member Account Privileges
            </a>
        </h4>
    </div>
    <div id="member-account" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
            <table width="100%">
	            <tr>
                    <td width="50%">Can manage guest BOOKINGS?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_manage_guest_bookings', 'y', $group['can_manage_guest_bookings'] == 'y', 'id="can_manage_guest_bookings_y"'); ?>
                            <label for="can_manage_guest_bookings_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_manage_guest_bookings', 'n', $group['can_manage_guest_bookings'] == 'n', 'id="can_manage_guest_bookings_n"'); ?>
                            <label for="can_manage_guest_bookings_n"> No </label>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td width="50%">Can manage guest FORMS?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_manage_guest_forms', 'y', $group['can_manage_guest_forms'] == 'y', 'id="can_manage_guest_forms_y"'); ?>
                            <label for="can_manage_guest_forms_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_manage_guest_forms', 'n', $group['can_manage_guest_forms'] == 'n', 'id="can_manage_guest_forms_n"'); ?>
                            <label for="can_manage_guest_forms_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can manage guest SETTINGS?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_manage_guest_settings', 'y', $group['can_manage_guest_settings'] == 'y', 'id="can_manage_guest_settings_y"'); ?>
                            <label for="can_manage_guest_settings_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_manage_guest_settings', 'n', $group['can_manage_guest_settings'] == 'n', 'id="can_manage_guest_settings_n"'); ?>
                            <label for="can_manage_guest_settings_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can view other profiles?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_view_other_profiles', 'y', $group['can_view_other_profiles'] == 'y', 'id="can_view_other_profiles_y"'); ?>
                            <label for="can_view_other_profiles_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_view_other_profiles', 'n', $group['can_view_other_profiles'] == 'n', 'id="can_view_other_profiles_n"'); ?>
                            <label for="can_view_other_profiles_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can edit other profiles?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_edit_other_profiles', 'y', $group['can_edit_other_profiles'] == 'y', 'id="can_edit_other_profiles_y"'); ?>
                            <label for="can_edit_other_profiles_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_edit_other_profiles', 'n', $group['can_edit_other_profiles'] == 'n', 'id="can_edit_other_profiles_n"'); ?>
                            <label for="can_edit_other_profiles_n"> No </label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%">Can add schedule?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_add_schedule', 'y', $group['can_add_schedule'] == 'y', 'id="can_add_schedule_y"'); ?>
                            <label for="can_add_schedule_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_add_schedule', 'n', $group['can_add_schedule'] == 'n', 'id="can_add_schedule_n"'); ?>
                            <label for="can_add_schedule_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can assign schedules?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_assign_schedules', 'y', $group['can_assign_schedules'] == 'y', 'id="can_assign_schedules_y"'); ?>
                            <label for="can_assign_schedules_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_assign_schedules', 'n', $group['can_assign_schedules'] == 'n', 'id="can_assign_schedules_n"'); ?>
                            <label for="can_assign_schedules_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can view other schedules?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_view_other_schedule', 'y', $group['can_view_other_schedule'] == 'y', 'id="can_view_other_schedule_y"'); ?>
                            <label for="can_view_other_schedule_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_view_other_schedule', 'n', $group['can_view_other_schedule'] == 'n', 'id="can_view_other_schedule_n"'); ?>
                            <label for="can_view_other_schedule_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can view DASHBOARD?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_view_dashboard', 'y', $group['can_view_dashboard'] == 'y', 'id="can_view_dashboard_y"'); ?>
                            <label for="can_view_dashboard_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_view_dashboard', 'n', $group['can_view_dashboard'] == 'n', 'id="can_view_dashboard_n"'); ?>
                            <label for="can_view_dashboard_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can view today's GUESTS?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_view_today_bookings', 'y', $group['can_view_today_bookings'] == 'y', 'id="can_view_today_bookings_y"'); ?>
                            <label for="can_view_today_bookings_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_view_today_bookings', 'n', $group['can_view_today_bookings'] == 'n', 'id="can_view_today_bookings_n"'); ?>
                            <label for="can_view_today_bookings_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Include members in Provider List?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('include_in_provider_list', 'y', $group['include_in_provider_list'] == 'y', 'id="include_in_provider_list_y"'); ?>
                            <label for="include_in_provider_list_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('include_in_provider_list', 'n', $group['include_in_provider_list'] == 'n', 'id="include_in_provider_list_n"'); ?>
                            <label for="include_in_provider_list_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Include members in Audit List?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('include_in_audit_list', 'y', $group['include_in_audit_list'] == 'y', 'id="include_in_audit_list_y"'); ?>
                            <label for="include_in_audit_list_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('include_in_audit_list', 'n', $group['include_in_audit_list'] == 'n', 'id="include_in_audit_list_n"'); ?>
                            <label for="include_in_audit_list_n"> No </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Can edit questionnaire/forms completed by others?</td>
                    <td width="50%">
                        <div class="radio radio-info radio-inline">
                            <?php echo form_radio('can_edit_completed_forms', 'y', $group['can_edit_completed_forms'] == 'y', 'id="can_edit_completed_forms_y"'); ?>
                            <label for="can_edit_completed_forms_y"> Yes </label>
                        </div>
                        <div class="radio radio-inline">
                            <?php echo form_radio('can_edit_completed_forms', 'n', $group['can_edit_completed_forms'] == 'n', 'id="can_edit_completed_forms_n"'); ?>
                            <label for="can_edit_completed_forms_n"> No </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>